<?php
include '../core/init.php';

$user_id = $_SESSION['id'] ?? null;
$selectCompanyVat = $getFromU->select_one_val('company_settings', 'vat', 'id', 1);
$companyPriceEditability = $getFromU->select_one_val('company_settings', 'sales_price_edit', 'id', 1) ?? 'uneditable';

if (isset($_POST['pro_purchase']) && ($_POST['type'] ?? '') == 'place_order') {

    $data = json_decode($_POST['data']);
    if (!is_array($data) || count($data) == 0) {
        echo json_encode(['success' => false, 'message' => 'Empty order data']);
        exit;
    }

    $ids = [];
    $quantities_for_record = [];
    $total_prices = [];
    $grand_total = 0.0;
    $failedUpdates = [];
    $remaining_texts = [];

    // Try to use transactions if $getFromU exposes them
    $useTransaction = false;
    if (isset($getFromU) && method_exists($getFromU, 'beginTransaction') && method_exists($getFromU, 'commit') && method_exists($getFromU, 'rollback')) {
        try {
            $getFromU->beginTransaction();
            $useTransaction = true;
        } catch (\Throwable $e) {
            $useTransaction = false;
        }
    }

    // Generate trans code
    $uniq = 'trx'.time().substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'),0,7);
    $trans_code = substr(str_shuffle($uniq), 0, 7);

    // get sales type for server-side pricing (fallback to POST or default 'regular')
    $price_type = $_POST['sales_type'] ?? 'regular';
    $price_type = trim(strtolower($price_type));

    // iterate lines
    foreach ($data as $order) {
        $productId = intval($order->id ?? 0);
        if ($productId <= 0) {
            if ($useTransaction) $getFromU->rollback();
            echo json_encode(['success' => false, 'message' => 'Invalid product id in order data']);
            exit;
        }

        $is_pack = intval($order->is_pack ?? 0);
        $order_pack_size = intval($order->pack_size) ?: 1;
        $pack_qty = intval($order->pack_qty ?? 0);
        $bottle_qty = intval($order->bottle_qty ?? 0);

        // server-side fetch product info needed for pricing and pack_size
        $prod_price = floatval($getFromU->select_one_val('products', 'price', 'id', $productId) ?? 0.0);
        $prod_special_price = floatval($getFromU->select_one_val('products', 'special_price', 'id', $productId) ?? 0.0);
        $prod_market_price = floatval($getFromU->select_one_val('market_products', 'price', 'code', $order?->code) ?? 0.0);
        $db_is_pack = intval($getFromU->select_one_val('products', 'is_pack', 'id', $productId));
        $db_pack_size = intval($getFromU->select_one_val('products', 'pack_size', 'id', $productId)) ?: 1;
        $db_quantity_raw = $getFromU->select_one_val('products', 'quantity', 'id', $productId);
        $db_quantity_float = floatval($db_quantity_raw);

        // pick pack price according to price_type and editability setting
        $pack_price = $prod_price;
        
        // If price is editable, use frontend values (with validation)
        if (strtolower(trim($companyPriceEditability)) === 'editable') {
            // Frontend provided prices - validate and use them
            $frontend_pack_price = floatval($order->pack_price ?? 0);
            $frontend_single_price = floatval($order->single_price ?? 0);
            
            // Only use frontend prices if they are positive numbers
            if ($frontend_pack_price > 0) {
                $pack_price = $frontend_pack_price;
                $single_price = $frontend_single_price > 0 ? $frontend_single_price : ($pack_price / $order_pack_size);
            } else {
                // Fallback to backend prices if frontend values invalid
                switch ($price_type) {
                    case 'special':
                        $pack_price = $prod_special_price > 0 ? $prod_special_price : $prod_price;
                        break;
                    case 'market':
                        $pack_price = $prod_market_price > 0 ? $prod_market_price : $prod_price;
                        break;
                    default:
                        $pack_price = $prod_price;
                }
                $single_price = $pack_price / $order_pack_size;
            }
        } else {
            // Price is not editable - always use backend calculated prices (secure)
            switch ($price_type) {
                case 'special':
                    $pack_price = $prod_special_price > 0 ? $prod_special_price : $prod_price;
                    break;
                case 'market':
                    $pack_price = $prod_market_price > 0 ? $prod_market_price : $prod_price;
                    break;
                default:
                    $pack_price = $prod_price;
            }
            $single_price = $pack_price / $order_pack_size;
        }

        // validation
        if ($is_pack) {
            if ($bottle_qty > $order_pack_size) {
                if ($useTransaction) $getFromU->rollback();
                echo json_encode(['success' => false, 'message' => "Bottles-from-pack for product id {$productId} cannot exceed pack_size ({$order_pack_size})."]);
                exit;
            }
        } else {
            if ($bottle_qty <= 0) {
                if ($useTransaction) $getFromU->rollback();
                echo json_encode(['success' => false, 'message' => "Invalid quantity for single product id {$productId}."]);
                exit;
            }
        }

        // compute base units sold (pack_qty * order_pack_size + bottle_qty)
        $base_units_sold = ($pack_qty * $order_pack_size) + $bottle_qty;

        // current base units in DB (float)
        $db_base_units = $db_quantity_float * ($db_is_pack ? $db_pack_size : 1);

        // ensure enough stock
        if ($base_units_sold > $db_base_units + 0.000001) {
            if ($useTransaction) $getFromU->rollback();
            $productName = $getFromU->select_one_val('products', 'name', 'id', $productId);
            echo json_encode([
                'success' => false,
                'message' => "Insufficient stock for product {$productName} (id {$productId}). Requested {$base_units_sold} base units, available {$db_base_units}."
            ]);
            exit;
        }

        // SERVER-SIDE price calculation for this line (do not trust client)
        if ($is_pack) {
            $line_total_price = round(($pack_qty * $pack_price) + ($bottle_qty * $single_price), 2);
        } else {
            $line_total_price = round($bottle_qty * $single_price, 2);
        }

        // compute new DB base units after sale (float)
        $new_db_base_units = $db_base_units - $base_units_sold;
        if ($new_db_base_units < 0) $new_db_base_units = 0.0;

        // detect if cashier changed pack_size and persist if different
        $persistPackSize = false;
        $effective_db_pack_size = $db_pack_size;
        if ($is_pack && isset($order->pack_size) && intval($order->pack_size) > 0 && intval($order->pack_size) != $db_pack_size) {
            $persistPackSize = true;
            $effective_db_pack_size = intval($order->pack_size);
        }

        // convert base units back to DB units and compute fractional quantity to save
        if ($db_is_pack) {
            if ($effective_db_pack_size <= 0) $effective_db_pack_size = 1;
            $new_db_quantity_float = round($new_db_base_units / $effective_db_pack_size, 4);
            $remaining_full_packs = intval(floor($new_db_quantity_float));
            $remaining_bottles = intval(round($new_db_base_units - ($remaining_full_packs * $effective_db_pack_size)));
            $new_db_quantity_to_save = $new_db_quantity_float;
        } else {
            $new_db_quantity_to_save = intval(round($new_db_base_units));
            $remaining_full_packs = 0;
            $remaining_bottles = $new_db_quantity_to_save;
        }

        // prepare update fields
        if (is_float($new_db_quantity_to_save) || strpos((string)$new_db_quantity_to_save, '.') !== false) {
            $quantity_to_save = number_format($new_db_quantity_to_save, 4, '.', '');
        } else {
            $quantity_to_save = (string)$new_db_quantity_to_save;
        }

        $updateFields = ['quantity' => $quantity_to_save];
        if ($persistPackSize) {
            $updateFields['pack_size'] = $effective_db_pack_size;
            if (!$db_is_pack) $updateFields['is_pack'] = 1;
        }

        // perform update
        $updated = $getFromU->update('products', $productId, $updateFields);
        if ($updated) {
            // update cached product quantity if you maintain such mapping
            $productCode = $getFromU->select_one_val('products', 'code', 'id', $productId);
            $getFromU->updateProductQuantity($productCode, $quantity_to_save);

            // concurrency check when not using transaction: read the value back and ensure it matches what we intended
            if (!$useTransaction) {
                $verify_qty_raw = $getFromU->select_one_val('products', 'quantity', 'id', $productId);
                $verify_qty_float = floatval($verify_qty_raw);
                // allow small difference due to rounding
                if (abs(floatval($verify_qty_float) - floatval($new_db_quantity_to_save)) > 0.0001) {
                    // conflict detected
                    $failedUpdates[] = $productId;
                    if ($useTransaction) $getFromU->rollback();
                    else {
                        echo json_encode(['success' => false, 'message' => "Concurrency error: product {$productId} changed during update. Please retry the sale."]);
                        exit;
                    }
                }
            }
        } else {
            $failedUpdates[] = $productId;
            if ($useTransaction) {
                $getFromU->rollback();
                echo json_encode(['success' => false, 'message' => 'Failed to update product quantities; transaction rolled back.']);
                exit;
            }
        }

        // prepare recorded quantity string for product_purchase
        if ($is_pack) {
            $qty_record = "{$pack_qty}|pack+{$bottle_qty}|single";
        } else {
            $qty_record = "{$bottle_qty}|single";
        }

        $ids[] = $productId;
        $quantities_for_record[] = $qty_record;
        $total_prices[] = number_format($line_total_price, 2, '.', '');
        $grand_total += $line_total_price;

        // prepare a remaining message for response
        if ($db_is_pack) {
            $remaining_texts[] = $getFromU->select_one_val('products','name','id',$productId) . ": {$remaining_full_packs} packs and {$remaining_bottles} bottles remaining";
        } else {
            $remaining_texts[] = $getFromU->select_one_val('products','name','id',$productId) . ": {$new_db_quantity_to_save} units remaining";
        }
    } // end foreach

    // if any failed updates recorded, rollback and return error
    if (count($failedUpdates) > 0) {
        if ($useTransaction) $getFromU->rollback();
        echo json_encode(['success' => false, 'message' => 'Failed to update product IDs: ' . implode(',', $failedUpdates)]);
        exit;
    }

    // prepare to insert purchase record
    $credit = $_POST['credit'] ?? 0;
    $additional_info = $_POST['additional_info'] ?? null;
    $payment_mode = $_POST['payment_mode'] ?? 'cash';
    $customer_phone = $_POST['customer_phone'] ?? '';
    $price_type = $price_type;

    $product_id_str = implode(',', $ids);
    $quantity_str = implode(',', $quantities_for_record);
    $total_price_str = implode(',', $total_prices);

    if (!empty($product_id_str) && $grand_total > 0) {

        $product_id_str = $getFromU->checkInput($product_id_str);
        $quantity_str = $getFromU->checkInput($quantity_str);
        $total_price_str = $getFromU->checkInput($total_price_str);
        $payment_mode = $getFromU->checkInput($payment_mode);
        $credit = $getFromU->checkInput($credit);
        $grand_total = $getFromU->checkInput($grand_total);
        $trans_code = $getFromU->checkInput($trans_code);
        $price_type = $getFromU->checkInput($price_type);
        $additional_info = $getFromU->checkInput($additional_info);

        (int) $customer_id = $customer_phone;
        $branch_id = (isset($_SESSION['branch_id'])) ? $_SESSION['branch_id'] : $getFromU->select_one_val('user', 'branch_id', 'id', $user_id);

        if ($payment_mode == 'creditor') {
            $credit = $grand_total - $credit;
        } else {
            $credit = 0;
        }

        // map to expected insert variable names
        $product_id = $product_id_str;
        $quantity = $quantity_str;
        $total_price = $total_price_str;
        $vat = $grand_total * ($selectCompanyVat / 100);

        $purchase_products = $getFromU->create('product_purchase', compact(
            'user_id', 'branch_id', 'product_id', 'price_type', 'customer_id', 'quantity', 'total_price', 'payment_mode', 'credit', 'grand_total', 'vat', 'trans_code', 'additional_info'
        ));

        if ($purchase_products) {
            if ($useTransaction) $getFromU->commit();

            $_SESSION['status'] = "Product Purchase Successful";
            $_SESSION['code'] = "success";

            echo json_encode(['success'=>true, 'message'=>'Product Purchased Successfully!', 'remaining_text' => implode('; ', $remaining_texts)]);
            exit;
        } else {
            if ($useTransaction) $getFromU->rollback();
            echo json_encode(['success'=>false, 'message'=>'Unable to insert purchase record, an error occurred!']);
            exit;
        }
    } else {
        if ($useTransaction) $getFromU->rollback();
        echo json_encode(['success'=>false, 'message'=>'Empty product list or zero grand total']);
        exit;
    }

} else {
    echo json_encode(['success'=>false, 'message'=>'An error occurred!']);
    exit;
}
?>
