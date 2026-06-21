<?php
include '../core/init.php';
header('Content-Type: application/json');

$user_id = $_SESSION['id'] ?? null;
$branch_id = $_SESSION['branch_id'] ?? $getFromU->select_one_val('user','branch_id','id',$user_id);

// only accept AJAX create_swap
if (isset($_POST['type']) && $_POST['type'] == 'create_swap' && !empty($_POST['data'])) {
    $payload = json_decode($_POST['data'], true);
    if (!is_array($payload)) {
        echo json_encode(['success'=>false, 'message'=>'Invalid payload']);
        exit;
    }

    // sanitize and extract
    $brought_pid = intval($payload['brought_product_id'] ?? 1);
    $brought_name = trim($payload['brought_product_name'] ?? '');
    $brought_qty = floatval($payload['brought_quantity'] ?? 1);
    $brought_unit_value = floatval($payload['brought_unit_value'] ?? 0);

    $wanted_pid = intval($payload['wanted_product_id'] ?? 1);
    $wanted_name = trim($payload['wanted_product_name'] ?? '');
    $wanted_qty = floatval($payload['wanted_quantity'] ?? 1);
    $wanted_unit_value = floatval($payload['wanted_unit_value'] ?? 0);

    $cash_added = floatval($payload['cash_added'] ?? 0);
    $customer_id = intval($payload['customer_id'] ?? 0);
    $additional_info = $payload['additional_info'] ?? null;

    // if ($brought_pid <= 0 || $wanted_pid <= 0 || $brought_qty <= 0 || $wanted_qty <= 0) {
    //     echo json_encode(['success'=>false, 'message'=>'Please select valid products and quantities.']);
    //     exit;
    // }

    // optional: fetch current quantities to check stock for wanted product
    $db_wanted_qty_raw = $getFromU->select_one_val('products', 'quantity', 'id', $wanted_pid);
    $db_wanted_qty = floatval($db_wanted_qty_raw);

    // For apps with pack logic you should convert unit vs pack; here we assume quantities are stored in the DB in the same unit the UI uses.
    if ($wanted_qty > $db_wanted_qty + 0.000001) {
        echo json_encode(['success'=>false, 'message'=>"Insufficient stock for {$wanted_name}. Available: {$db_wanted_qty}"]);
        exit;
    }

    // begin transaction if supported
    $useTransaction = false;
    if (isset($getFromU) && method_exists($getFromU, 'beginTransaction')) {
        try {
            $getFromU->beginTransaction();
            $useTransaction = true;
        } catch (Exception $e) {
            $useTransaction = false;
        }
    }

    // generate trans code
    $uniq = 'swp'.time().substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'),0,6);
    $trans_code = substr(str_shuffle($uniq), 0, 10);

    // update wanted product: decrement
    $new_wanted_qty = $db_wanted_qty - $wanted_qty;
    if ($new_wanted_qty < 0) $new_wanted_qty = 0;

    $updateWanted = $getFromU->update('products', $wanted_pid, ['quantity' => $new_wanted_qty]);

    // update brought product: increment (customer brought items into your stock)
    $db_brought_qty_raw = $getFromU->select_one_val('products', 'quantity', 'id', $brought_pid);
    $db_brought_qty = floatval($db_brought_qty_raw);
    $new_brought_qty = $db_brought_qty + $brought_qty;
    $updateBrought = $getFromU->update('products', $brought_pid, ['quantity' => $new_brought_qty]);

    if (!$updateWanted || !$updateBrought) {
        if ($useTransaction) $getFromU->rollback();
        echo json_encode(['success'=>false, 'message'=>'Failed to update product quantities.']);
        exit;
    }

    // build insert record (sanitize using checkInput)
    $record = [
        'trans_code' => $getFromU->checkInput($trans_code),
        'user_id' => $user_id,
        'branch_id' => $branch_id,
        'customer_id' => $customer_id ?: null,

        'brought_product_id' => $brought_pid,
        'brought_product_name' => $getFromU->checkInput($brought_name),
        'brought_quantity' => $getFromU->checkInput(number_format($brought_qty,4,'.','')),
        'brought_unit_value' => $getFromU->checkInput(number_format($brought_unit_value,2,'.','')),

        'wanted_product_id' => $wanted_pid,
        'wanted_product_name' => $getFromU->checkInput($wanted_name),
        'wanted_quantity' => $getFromU->checkInput(number_format($wanted_qty,4,'.','')),
        'wanted_unit_value' => $getFromU->checkInput(number_format($wanted_unit_value,2,'.','')),

        'cash_added' => $getFromU->checkInput(number_format($cash_added,2,'.','')),
        'additional_info' => $getFromU->checkInput($additional_info)
    ];

    $insertOk = $getFromU->create('swaps', $record);

    if ($insertOk) {
        if ($useTransaction) $getFromU->commit();
        $_SESSION['status'] = "Swap created";
        $_SESSION['code'] = "success";
        echo json_encode(['success'=>true, 'message'=>'Swap recorded successfully', 'trans_code'=>$trans_code]);
        exit;
    } else {
        if ($useTransaction) $getFromU->rollback();
        // try to revert product quantities if update happened (best-effort)
        $getFromU->update('products', $wanted_pid, ['quantity' => $db_wanted_qty]);
        $getFromU->update('products', $brought_pid, ['quantity' => $db_brought_qty]);
        echo json_encode(['success'=>false, 'message'=>'Unable to log swap record.']);
        exit;
    }

} else {
    echo json_encode(['success'=>false, 'message'=>'Invalid request.']);
    exit;
}
?>
