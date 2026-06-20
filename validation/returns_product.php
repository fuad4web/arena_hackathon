<?php
     include '../core/init.php';
     
     if (isset($_POST['return_barcode']) && isset($_POST['return_sales_type'])) {
          $return_barcode = trim($_POST['return_barcode']);
          $return_sales_type = trim($_POST['return_sales_type']);

          // fetch product (assoc row) - searches by barcode OR name and respects branch if session set
          $selectProduct_forReturn = $getFromU->select_all_two_or_cond_branch(
               'products',
               'barcode',
               $return_barcode,
               'name',
               $return_barcode
          );

          // fetch Wholesale Price (scalar) if any - searches market_products.name OR market_products.barcode
          $marketPrice = $getFromU->select_one_value_two_or_conds(
               'market_products',
               'price',
               'name',
               $return_barcode,
               'barcode',
               $return_barcode
          );

          $htmlo = '';

          if ($selectProduct_forReturn) {
               // determine price based on requested sales type
               // fallbacks: if special missing, fall back to price; if Wholesale Price missing, fall back to price
               $price = $selectProduct_forReturn['price'] ?? 0;
               $specialPrice = $selectProduct_forReturn['special_price'] ?? null;

               switch (strtolower($return_sales_type)) {
                    case 'regular':
                         $price = $selectProduct_forReturn['price'] ?? $price;
                         break;

                    case 'special':
                         $price = $specialPrice !== null && $specialPrice !== '' ? $specialPrice : ($selectProduct_forReturn['price'] ?? $price);
                         break;

                    case 'market':
                         $price = $marketPrice !== null ? $marketPrice : ($selectProduct_forReturn['price'] ?? $price);
                         break;

                    default:
                         // unknown sales type -> fallback to product price or marketPrice
                         $price = $selectProduct_forReturn['price'] ?? ($marketPrice ?? 0);
                         break;
               }

               // compute default total for qty = 1
               $quantityAvailable = $selectProduct_forReturn['quantity'] ?? 0;
               $total = floatval($price) * 1;

               // sanitize values before embedding in HTML
               $img = htmlspecialchars($selectProduct_forReturn['product_pics'] ?? '', ENT_QUOTES);
               $name = htmlspecialchars($selectProduct_forReturn['name'] ?? '', ENT_QUOTES);
               $prodId = intval($selectProduct_forReturn['id'] ?? 0);
               $prodQty = htmlspecialchars((string)$quantityAvailable, ENT_QUOTES);
               $priceEsc = htmlspecialchars((string)$price, ENT_QUOTES);
               $totalEsc = htmlspecialchars(number_format($total, 2, '.', ''), ENT_QUOTES);

               // Build the HTML row
               $htmlo .= "<tr>
                    <td>
                         <img src='{$img}' style='border-radius: 50%;' class='border-rounded' width='40' height='40' alt='{$name}'>
                    </td>
                    <td>
                         <input class='form-control' type='text' value='{$name}' readonly>
                         <input type='hidden' name='product_id' value='{$prodId}'>
                         <input type='hidden' name='quantity_available' value='{$prodQty}'>
                    </td>
                    <td>
                         <input class='form-control price' id='return_price' name='return_price' type='number' step='any' value='{$priceEsc}' readonly>
                    </td>
                    <td>
                         <input class='form-control quantity' data-id='{$prodId}' name='return_quantity' min='0.1' id='return_quantity' type='number' value='1' step='any' max='{$prodQty}' required>
                    </td>
                    <td>
                         <input class='form-control total_price' name='return_total_price' id='return_total_price' type='number' step='any' value='{$totalEsc}' readonly>
                    </td>
               </tr>";
          } else {
               // optional: provide a "not found" row or empty result
               $htmlo .= "<tr><td colspan='5'>Product not found for '{$return_barcode}'</td></tr>";
          }

          echo $htmlo;
          exit;
     }




     if(isset($_POST['type']) && $_POST['type'] == 'return_product') {
          // Get the JSON data from frontend
          $data = json_decode($_POST['data'], true);
          $customer_phone = $_POST['customer_phone'];
          // $sales_type = $_POST['sales_type'];
          $credit = $_POST['credit'] ?? 0;
          
          $branch_id = $_SESSION['branch_id'];
          $staff_id = $_SESSION['id']; // Assuming staff ID is stored in session
          
          if(!empty($staff_id) && isset($branch_id)) {
               // Get customer ID by phone
               $customer = $getFromU->select_one_row('customers', 'phone_number', $customer_phone);
               if(!$customer) {
                    // Try getting by name if phone not found
                    $customer = $getFromU->select_one_row('customers', 'name', $customer_phone);
               }
               
               if(!$customer) {
                    echo json_encode([
                         'success' => false,
                         'message' => 'Customer not found. Please check customer details.'
                    ]);
                    exit;
               }
               
               $customer_id = $customer->id;
               
               // Start transaction for data consistency
               // $pdo = $getFromU->getPDO();
               // $pdo->beginTransaction();
               
               try {
                    $return_total_all = 0;
                    
                    foreach($data as $product) {
                         $product_id = $getFromU->checkInput($product['id']);
                         $code = $getFromU->checkInput($product['code']);
                         $name = $getFromU->checkInput($product['name']);
                         $is_pack = intval($getFromU->checkInput($product['is_pack']));
                         $pack_size = intval($getFromU->checkInput($product['pack_size']));
                         $pack_qty = intval($getFromU->checkInput($product['pack_qty']));
                         $bottle_qty = intval($getFromU->checkInput($product['bottle_qty']));
                         $pack_price = floatval($getFromU->checkInput($product['pack_price']));
                         $single_price = floatval($getFromU->checkInput($product['single_price']));
                         $total_price = floatval($getFromU->checkInput($product['total_price']));
                         
                         // Calculate return quantity in base units
                         if($is_pack == 1) {
                              // For packed products: (pack_qty * pack_size) + bottle_qty
                              $return_quantity = ($pack_qty * $pack_size) + $bottle_qty;
                              $price_per_unit = $single_price; // Use single price as unit price
                         } else {
                              // For single products: just bottle_qty
                              $return_quantity = $bottle_qty;
                              $price_per_unit = $single_price;
                         }
                         
                         // Calculate grand total for this product
                         $return_grand_total = $return_quantity * $price_per_unit;
                         
                         // Save to return_product table
                         $return_data = [
                              'branch_id' => $branch_id,
                              'product_id' => $product_id,
                              'customer_id' => $customer_id,
                              'price_type' => 'regular',
                              'return_grand_total' => $return_grand_total,
                              'return_total_price' => $price_per_unit,
                              'return_quantity' => $return_quantity,
                              'staff_id' => $staff_id,
                              'reason' => 'Customer return',
                              'return_date' => date('Y-m-d H:i:s')
                         ];
                         
                         $getFromU->create('return_product', $return_data);
                         
                         // Update product quantity (add back returned quantity)
                         $current_product = $getFromU->select_one_row('products', 'id', $product_id);
                         if($current_product) {
                              if($is_pack == 1) {
                                   // For packed products, convert base units back to packs
                                   $current_packs = floatval($current_product->quantity);
                                   $return_packs = $return_quantity / $pack_size;
                                   $new_quantity = $current_packs + $return_packs;
                              } else {
                                   // For single products
                                   $current_quantity = floatval($current_product->quantity);
                                   $new_quantity = $current_quantity + $return_quantity;
                              }
                              
                              $getFromU->update('products', $product_id, ['quantity' => $new_quantity]);
                              
                              // Also update market_products if exists
                              $market_product = $getFromU->select_one_row('market_products', 'code', $code);
                              if($market_product) {
                                   $market_product_id = $market_product->id;
                                   if($is_pack == 1) {
                                        $current_market_qty = floatval($market_product->quantity);
                                        $return_market_qty = $return_quantity;
                                        $new_market_quantity = $current_market_qty + $return_market_qty;
                                   } else {
                                        $current_market_qty = floatval($market_product->quantity);
                                        $new_market_quantity = $current_market_qty + $return_quantity;
                                   }
                                   
                                   $getFromU->update('market_products', $market_product_id, ['quantity' => $new_market_quantity]);
                              }
                         }
                         
                         $return_total_all += $return_grand_total;
                    }
                    
                    // Commit transaction
                    // $pdo->commit();
                    
                    // Create a sales record for the return (optional)
                    // $return_sales_data = [
                    //      'code' => 'RET' . time() . rand(100, 999),
                    //      'customer_id' => $customer_id,
                    //      'branch_id' => $branch_id,
                    //      'staff_id' => $staff_id,
                    //      'total' => $return_total_all,
                    //      'payment_mode' => 'return', // Special mode for returns
                    //      'sales_type' => 'regular' ?? $sales_type,
                    //      'created_at' => date('Y-m-d H:i:s')
                    // ];
                    
                    // $getFromU->create('sales', $return_sales_data);
                    
                    echo json_encode([
                         'success' => true,
                         'message' => 'Products returned successfully!'
                    ]);
                    
               } catch(Exception $e) {
                    // $pdo->rollBack();
                    echo json_encode([
                         'success' => false,
                         'message' => 'Error processing return: ' . $e->getMessage()
                    ]);
               }
               
          } else {
               echo json_encode([
                    'success' => false,
                    'message' => 'Staff or branch not set'
               ]);
          }
          exit;
          }

          // Keep the old single product return for backward compatibility
          if(isset($_POST['pro_returns'])) {
          $product_id = $_POST['product_id'];
          $return_quantity = $_POST['return_quantity'];
          $return_total_price = $_POST['return_total_price'];
          $staff_id = $_POST['staff_id'];
          $reason = $_POST['reason'];
          $branch_id = $_SESSION['branch_id'];
          $customer_id = $_POST['customer_id'] ?? null;
          $price_type = $_POST['price_type'] ?? 'regular';
          
          if(!empty($staff_id) && isset($branch_id)) {
               $product_id = $getFromU->checkInput($product_id);
               $return_quantity = $getFromU->checkInput($return_quantity);
               $return_total_price = $getFromU->checkInput($return_total_price);
               $reason = $getFromU->checkInput($reason);
               $staff_id = $getFromU->checkInput($staff_id);
               $customer_id = $customer_id ? $getFromU->checkInput($customer_id) : null;
               $price_type = $getFromU->checkInput($price_type);
               
               // Calculate grand total
               $return_grand_total = $return_quantity * $return_total_price;
               
               $return_data = [
                    'branch_id' => $branch_id,
                    'product_id' => $product_id,
                    'customer_id' => $customer_id,
                    'price_type' => $price_type,
                    'return_grand_total' => $return_grand_total,
                    'return_total_price' => $return_total_price,
                    'return_quantity' => $return_quantity,
                    'staff_id' => $staff_id,
                    'reason' => $reason
               ];
               
               $getFromU->create('return_product', $return_data);
               
               $current_quantity = $getFromU->select_one_val('products', 'quantity', 'id', $product_id);
               $code = $getFromU->select_one_val('products', 'code', 'id', $product_id);
               $market_product_id = $getFromU->select_one_val('market_products', 'id', 'code', $code);
               
               $quantity = $current_quantity + $return_quantity;
               $getFromU->update('products', $product_id, compact('quantity'));
               $getFromU->update('market_products', $market_product_id, compact('quantity'));
               
               $_SESSION['status'] = "Product Successfully Returned";
               $_SESSION['code'] = "success";
               echo '<script>window.location.href="../return_product"</script>';
          } else {
               $_SESSION['status'] = "Failed to return Product, set Branch and Staff 😢";
               $_SESSION['code'] = "danger";
               $_SESSION['ErrorMessage'] = "Failed to return Product, set Branch and Staff 😢";
               echo '<script>window.location.href="../return_product"</script>';
          }
     }
     // if(isset($_POST['pro_returns'])) {
     //      $product_id = $_POST['product_id'];
     //      $return_quantity = $_POST['return_quantity'];
     //      $return_total_price = $_POST['return_total_price'];
     //      $staff_id = $_POST['staff_id'];
     //      $quantity = $_POST['quantity'];
     //      $reason = $_POST['reason'];
     //      $branch_id = $_SESSION['branch_id'];

     //      if(!empty($staff_id) && isset($branch_id)) {
     //           $product_id = $getFromU->checkInput($product_id);
     //           $return_quantity = $getFromU->checkInput($return_quantity);
     //           $return_total_price = $getFromU->checkInput($return_total_price);
     //           $reason = $getFromU->checkInput($reason);
     //           $staff_id = $getFromU->checkInput($staff_id);
               
     //           $getFromU->create('return_product', compact('branch_id', 'product_id', 'return_quantity', 'return_total_price', 'staff_id', 'reason'));

     //           $current_quantity = $getFromU->select_one_val('products', 'quantity', 'id', $product_id);
     //           $code = $getFromU->select_one_val('products', 'code', 'id', $product_id);
     //           $market_product_id = $getFromU->select_one_val('market_products', 'id', 'code', $code);

     //           $quantity = $current_quantity + $return_quantity;
     //           $getFromU->update('products', $product_id, compact('quantity'));
     //           $getFromU->update('market_products', $market_product_id, compact('quantity'));
     //           $_SESSION['status'] = "Product Successfully Returned";
     //           $_SESSION['code'] = "success";
     //           echo '<script>window.location.href="../return_product"</script>';
     //      } else {
     //           $_SESSION['status'] = "Failed to return Product, set Branch and Staff 😢";
     //           $_SESSION['code'] = "danger";
     //           $_SESSION['ErrorMessage'] = "Failed to return Product, set Branch and Staff 😢";
     //           echo '<script>window.location.href="../return_product"</script>';
     //      }

     // }

?>
