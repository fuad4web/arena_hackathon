<?php     
     include 'elements/header.php';
?>

    <style>
        /* Modern Search Input */
        .search-input { padding-left: 50px !important; border-radius: 12px !important; border: 2px solid #e9ecef !important; transition: all 0.3s ease !important; }
        
        .search-input:focus { border-color: #0d6efd !important; box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important; }
        
        .search-icon { position: absolute; left: 20px; top: 50%; transform: translateY(-50%); color: #6c757d; pointer-events: none; z-index: 4; }
        
        .form-control-lg { height: calc(3.5rem + 2px) !important; font-size: 1.1rem !important; }
        
        /* Search Results Dropdown */
        .search-results { position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #dee2e6; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); max-height: 400px; overflow-y: auto; z-index: 1000; display: none; margin-top: 5px; }
        
        .search-result-item { padding: 12px 20px; border-bottom: 1px solid #f8f9fa; cursor: pointer; display: flex; align-items: center; transition: all 0.2s ease; }
        
        .search-result-item:hover { background-color: #f8f9fa; }
        
        .search-result-item:last-child { border-bottom: none; }
        
        .search-result-item img { width: 50px; height: 50px; border-radius: 6px; object-fit: cover; margin-right: 15px; }
        
        .search-result-info { flex: 1; }
        
        .search-result-name { font-weight: 600; color: #212529; margin-bottom: 3px; }
        
        .search-result-barcode { font-size: 12px; color: #6c757d; background: #f8f9fa; padding: 2px 8px; border-radius: 4px; display: inline-block; }
        
        .search-result-price { color: #198754; font-weight: 500; margin-top: 3px; }
        
        /* Products Grid */
        .products-grid-container { background: #f8f9fa; border-radius: 12px; padding: 20px; border: 1px solid #e9ecef; }
        
        .product-card-grid { margin-bottom: 20px; }
        
        .product-card { border: 2px solid #e9ecef; border-radius: 12px; overflow: hidden; transition: all 0.3s ease; background: white; cursor: pointer; height: 100%; }
        
        .product-card:hover { border-color: #0d6efd; transform: translateY(-5px); box-shadow: 0 10px 20px rgba(13, 110, 253, 0.1); }
        
        .product-card:active { transform: translateY(-2px); }
        
        .product-image-container { height: 180px; overflow: hidden; position: relative; }
        
        .product-image { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease; }
        
        .product-card:hover .product-image { transform: scale(1.05); }
        
        .product-overlay { position: absolute; top: 10px; right: 10px; background: rgba(255, 255, 255, 0.9); padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; color: #198754; }
        
        .product-info { padding: 15px; }
        
        .product-name { font-weight: 600; color: #212529; margin-bottom: 8px; font-size: 14px; line-height: 1.3; height: 36px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }
        
        .product-barcode-grid { font-size: 12px; color: #6c757d; background: #f8f9fa; padding: 2px 8px; border-radius: 4px; display: inline-block; margin-bottom: 8px; }
        
        .product-price-grid { color: #198754; font-weight: 600; font-size: 16px; margin-bottom: 5px; }
        
        .product-stock { font-size: 12px; color: #0d6efd; font-weight: 500; background: #e7f1ff; padding: 2px 8px; border-radius: 12px; display: inline-block; }
        
        .add-to-cart-btn { position: absolute; bottom: 15px; right: 15px; background: #0d6efd; color: white; border: none; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease; opacity: 0; transform: translateY(10px); }
        
        .product-card:hover .add-to-cart-btn { opacity: 1; transform: translateY(0); }
        
        .add-to-cart-btn:hover { background: #0b5ed7; transform: scale(1.1); }
        
        /* Cart Table */
        .table th { font-weight: 600; background: #f8f9fa; }
        
        .cart-product-image { width: 60px; height: 60px; border-radius: 8px; object-fit: cover; }
        
        .quantity-controls { display: flex; align-items: center; gap: 10px; }
        
        .quantity-input { width: 80px; text-align: center; }
        
        .quantity-btn { width: 35px; height: 35px; border-radius: 50%; border: 1px solid #dee2e6; background: white; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s ease; }
        
        .quantity-btn:hover { background: #f8f9fa; border-color: #0d6efd; }
        
        .remove-btn { color: #dc3545; background: none; border: none; padding: 5px 10px; border-radius: 6px; cursor: pointer; transition: all 0.2s ease; }
        
        .remove-btn:hover { background: rgba(220, 53, 69, 0.1); }
        
        .btn-purchase { padding: 15px 40px; font-size: 1.2rem; border-radius: 12px; transition: all 0.3s ease; }
        
        .btn-purchase:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(25, 135, 84, 0.2); }
        
        /* Responsive adjustments */
        @media (max-width: 1200px) { .pack-quantity-controls, .single-quantity-controls {     flex-direction: column;     align-items: stretch; } .quantity-group {     min-width: 100%; } }
        
        /* Animations */
        @keyframes slideIn { from {     opacity: 0;     transform: translateX(-20px); } to {     opacity: 1;     transform: translateX(0); } }
        
        .product-row { animation: slideIn 0.3s ease-out; }
        
        /* Responsive */
        @media (max-width: 768px) { .d-flex {     flex-direction: column; } .col-md-3, .col-md-6 {     width: 100% !important;     margin-bottom: 15px; } .form-control-lg {     height: calc(3rem + 2px) !important; } .product-card-grid {     flex: 0 0 50%;     max-width: 50%; } }
    </style>

     <div class="pcoded-main-container">
          <div class="pcoded-wrapper">
               <?php
                    include 'elements/sidebar.php';
               ?>

               <div class="pcoded-content">
                    <div class="page-header">
                         <div class="page-block">
                              <div class="row align-items-center">
                                   <div class="col-md-8">
                                   <div class="page-header-title">
                                        <h5 class="m-b-10">Return Products</h5>
                                        <p class="m-b-0">Welcome to <?= $selectCompanyName ?></p>
                                   </div>
                                   </div>
                                   <div class="col-md-4">
                                   <ul class="breadcrumb">
                                        <li class="breadcrumb-item">
                                             <a href="dashboard"> <i class="fa fa-home"></i> </a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#!">Return</a>
                                        </li>
                                   </ul>
                                   </div>
                              </div>
                         </div>
                    </div>

                    <div class="pcoded-inner-content">
                         <div class="main-body">
                              <div class="form-group text-center" style="width: 200px; margin: 10px auto;">
                                    <form method="POST" action="validation/setBranch">
                                        <label for="branchSelect" class="lead fw-bolder">Select Branch</label>
                                        <select id="branchSelect" name="branch_id" class="form-control" onchange="this.form.submit()">
                                            <option value="">All Branches</option>
                                            <?php foreach ($selectBranches as $branch): ?>
                                                <option value="<?= $branch?->id; ?>" <?= (isset($_SESSION['branch_id']) && $_SESSION['branch_id'] == $branch?->id) ? 'selected' : ''; ?>>
                                                    <?= $branch?->branch_name; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </form>
                              </div>

                              <?php if(isset($_SESSION['branch_id'])): ?>
                                   <p class="my-3 fw-bold lead text-center">
                                        You are currently on <?= ucwords($sessionBranch) ?> Branch
                                   </p>
                              <?php endif; ?>

                              <div class="page-wrapper">
                                   <div class="page-body">
                                        <?php
                                             echo SuccessMessage();
                                             echo ErrorMessage();
                                        if(isset($_SESSION['branch_id']) || $user?->status === 'staff') {
                                        ?>
                                        <div class="card">
                                            <div class="card-header">
                                                <h3>Return Product<small>(s)</small></h3>
                                                <span>Enable Product Return</span>
                                                <div class="card-header-right">
                                                    <ul class="list-unstyled card-option">
                                                        <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                                        <li><i class="fa fa-window-maximize full-card"></i></li>
                                                        <li><i class="fa fa-minus minimize-card"></i></li>
                                                        <li><i class="fa fa-refresh reload-card"></i></li>
                                                        <li><i class="fa fa-trash close-card"></i></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="card-block table-border-style">
                                                <?php
                                                    echo SuccessMessage();
                                                    echo ErrorMessage();
                                                ?>
                                                
                                                <div class="d-flex justify-content-between my-4 align-items-center">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="form-label text-muted small mb-1">Sales Type</label>
                                                            <select class="form-control sales_type form-select-lg" id="sales_type">
                                                                <option value="regular">Regular Sales</option>
                                                                <option value="special">Special Sales</option>
                                                                <option value="market">Market Sales</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label text-muted small mb-1">Search Product</label>
                                                            <div class="input-group" id="product-input">
                                                                    <input type="text" name="barcode" list="productOptions" id="product_barcode" placeholder="Search Product or Scan Barcode" autocomplete="off" class="form-control" required>
                                                                    <datalist id="productOptions">
                                                                        <?php foreach($selectActiveProducts as $selectActiveProduct): ?>
                                                                            <option value="<?= $selectActiveProduct->name ?>">
                                                                        <?php endforeach; ?>
                                                                    </datalist>

                                                                    <input type="button" name="submit" id="submit_barcode" value="ADD PRODUCT" class="btn btn-primary">
                                                            </div>
                                                            <!-- <div class="position-relative" id="product-input">
                                                                <input type="text" name="barcode" id="product_barcode" 
                                                                    placeholder="Search by name or barcode..." 
                                                                    autocomplete="off" 
                                                                    class="form-control form-control-lg search-input" 
                                                                    required>
                                                                <div class="search-icon">
                                                                    <i class="fas fa-search"></i>
                                                                </div>
                                                                <div class="search-results" id="search-results">
                                                                    !-- Search results will appear here --
                                                                </div>
                                                            </div> -->
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Products Grid Display -->
                                                <div class="products-grid-container mb-4" id="products-grid" style="display: none;">
                                                    <div class="row" id="products-grid-row">
                                                        <!-- Products will be loaded here dynamically -->
                                                    </div>
                                                </div>
                                                
                                                <div class="table-responsive mt-4">
                                                    <form action="validation/returns_product" method="POST" id="sales-form">
                                                        <input type="hidden" value="regular" name="sales_type" id="hidden_sales_type">
                                                       <table class="table table-striped table-hover order_product" id="order_product">
                                                            <thead class="" style="background-color: #0d6efd;">
                                                                <tr>
                                                                    <th width="5%">S/N</th>
                                                                    <th width="15%">Product Image</th>
                                                                    <th width="25%">Product Name</th>
                                                                    <th width="15%">Price (<?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?>)</th>
                                                                    <th width="15%">Quantity</th>
                                                                    <th width="15%">Total (<?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?>)</th>
                                                                    <th width="10%">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="product_sales">
                                                                <!-- Products will be added here -->
                                                            </tbody>
                                                            <tfoot id="cart-footer" style="display: none;">
                                                                <tr>
                                                                    <td colspan="5" class="text-end"><strong>Subtotal:</strong></td>
                                                                    <td><strong id="subtotal">0.00</strong></td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="5" class="text-end"><strong>Tax:</strong></td>
                                                                    <td><strong id="tax">0.00</strong></td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr class="table-active">
                                                                    <td colspan="5" class="text-end"><strong>Grand Total:</strong></td>
                                                                    <td><strong id="grand-total-display">0.00</strong></td>
                                                                    <td></td>
                                                                </tr>
                                                            </tfoot>
                                                       </table>
                                                        
                                                        <div class="row mt-4 bg-light p-4 rounded">
                                                            <div class="col-md-6">
                                                                 <div class="form-group form-default form-static-label">
                                                                      <textarea name="reason" id="reason" class="form-control" cols="5" rows="2"></textarea>
                                                                      <span class="form-bar"></span>
                                                                      <label class="float-label">Reason for Return (Optional)</label>
                                                                 </div>
                                                            </div>
                                                            
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="form-label text-muted small mb-1">Customer</label>
                                                                    <input type="text" name="customer_phone" list="customerOptions" id="customer_phone" placeholder="Search Phone Number" autocomplete="off" class="form-control" required>
                                                                    <datalist id="customerOptions">
                                                                        <?php foreach($selectBranchCustomers as $selectCustomer): ?>
                                                                            <option value="<?= $selectCustomer?->name ?>">
                                                                        <?php endforeach; ?>
                                                                    </datalist>
                                                                    <!-- <div class="position-relative">
                                                                        <input type="text" name="customer_phone" id="customer_phone" 
                                                                            placeholder="Search customer..." 
                                                                            autocomplete="off" 
                                                                            class="form-control form-control-lg customer-search">
                                                                        <div class="search-icon">
                                                                            <i class="fas fa-user"></i>
                                                                        </div>
                                                                        <div class="search-results" id="customer-results">
                                                                            !-- Customer search results --
                                                                        </div>
                                                                    </div> -->
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="form-label text-muted small mb-1">Grand Total</label>
                                                                    <input type="text" name="grand_total" id="grand_total_price" 
                                                                        class="form-control form-control-lg bg-white" 
                                                                        readonly 
                                                                        value="0.00">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="text-center mt-5">
                                                            <button type="submit" id="return_product" name="return_product" 
                                                                    class="btn btn-success btn-lg btn-purchase">
                                                                <i class="fas fa-shopping-cart me-2"></i>
                                                                Complete Return
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } else { ?>
                                             <p class="text-center display-4">Select Branch for Sales</p>
                                        <?php  } ?>
                                   </div>
                              </div>
                         </div>
                    </div>

               </div>
          </div>
     </div>
   </div>
</div>

<?php
     include 'elements/footer.php';
?>






















$("#return_product").click(function (e) {
          e.preventDefault();
          // alert("Return Product");
          // exit();

          if (!$('#customer_phone').val() || $('#customer_phone').val() === '') {
               alert('Customer not Selected');
               return;
          }

          const payload = return_products.map(p => ({
               id: p.id,
               name: p.name,
               code: p.code,
               is_pack: p.is_pack ? 1 : 0,
               pack_size: p.pack_size || 1,
               pack_qty: parseInt(p.pack_qty || 0),
               bottle_qty: parseInt(p.bottle_qty || 0),
               pack_price: parseFloat(p.pack_price || 0),
               single_price: parseFloat(p.single_price || 0),
               total_price: parseFloat(p.total_price || 0)
          }));

          $.ajax({
               url: 'validation/returns_product.php',
               method: 'post',
               dataType: 'json',
               data: {
                    type: 'return_order',
                    data: JSON.stringify(payload),
                    return_product: true,
                    reason: $('#reason').val(),
                    customer_phone: $('#customer_phone').val(),
                    sales_type: $("input[name='sales_type']").val()
               },
               beforeSend: function () {
                    $('#return_product').attr('disabled', 'disabled').text('Please wait . . . ');
               },
               success: function (res) {
                    $('#return_product').attr('disabled', false).text('Return Product');
                    if (res.success) {
                         alert(res.message || 'Return successful. Remaining stock: ' + (res.remaining_text || 'N/A'));
                         return_products = [];
                         display_products(return_products);
                         let basePath = window.location.pathname.split('/')[1];
                         if (basePath && basePath !== 'return_product') window.location.href = '/' + basePath + '/return_product';
                         else window.location.href = '/return_product';
                    } else {
                         alert(res.message || 'An error occurred while returning orders.');
                    }
               },
               error: function (err) {
                    console.error(err);
                    $('#return_product').attr('disabled', false).text('Return Product');
                    alert('An error occurred. Check console for details.');
               }
          });
     });















     <?php
     include '../core/init.php';

     $user_id = $_SESSION['id'] ?? null;

     if (isset($_POST['pro_return']) && ($_POST['type'] ?? '') == 'return_order') {

          $data = json_decode($_POST['data']);
          if (!is_array($data) || count($data) == 0) {
               echo json_encode(['success' => false, 'message' => 'Empty return data']);
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

          // get sales type for server-side pricing (fallback to POST or default 'regular')
          $price_type = $_POST['sales_type'] ?? 'regular';
          $price_type = trim(strtolower($price_type));
          
          $customer_id = $getFromU->select_one_val('customers', 'id', 'name', $customer_phone);
          if (!isset($_SESSION['branch_id'])) {
               $branch_id = $getFromU->select_one_val('user', 'branch_id', 'id', $user_id);
          } else {
               $branch_id = $_SESSION['branch_id'];
          }

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

               // pick pack price according to price_type
               $pack_price = $prod_price;
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

               $effective_pack_size_for_price = ($order_pack_size > 0) ? $order_pack_size : ($db_pack_size > 0 ? $db_pack_size : 1);
               if ($effective_pack_size_for_price > 0) {
                    $single_price = $pack_price / $effective_pack_size_for_price;
               } else {
                    $single_price = $pack_price;
               }

               // validation
               if ($bottle_qty <= 0) {
                    if ($useTransaction) $getFromU->rollback();
                    echo json_encode(['success' => false, 'message' => "Invalid quantity for single product id {$productId}."]);
                    exit;
               }

               // compute base units sold (pack_qty * order_pack_size + bottle_qty)
               $base_units_sold = ($pack_qty * $order_pack_size) + $bottle_qty;

               // current base units in DB (float)
               $db_base_units = $db_quantity_float * ($db_is_pack ? $db_pack_size : 1);

               // SERVER-SIDE price calculation for this line (do not trust client)
               if ($is_pack) {
                    $line_total_price = round(($pack_qty * $pack_price) + ($bottle_qty * $single_price), 2);
               } else {
                    $line_total_price = round($bottle_qty * $single_price, 2);
               }

               // compute new DB base units after sale (float)
               $new_db_base_units = $db_base_units + $base_units_sold;
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
                    $remaining_bottles = intval(round($new_db_base_units + ($remaining_full_packs * $effective_db_pack_size)));
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
                         if (abs(floatval($verify_qty_float) + floatval($new_db_quantity_to_save)) > 0.0001) {
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


               // save to return table
               $reason = $_POST['reason'] ?? 'cash';
               $customer_phone = $_POST['customer_phone'] ?? '';
               $staff_id = $user_id;

               $reason = $getFromU->checkInput($reason);
               $grand_total = $getFromU->checkInput($grand_total);
               $trans_code = $getFromU->checkInput($trans_code);
               $return_quantity = $quantity_to_save;
               $return_grand_total = $grand_total;
               $return_total_price = $line_total_price;

               // perform return functionality
               $return_products = $getFromU->create('return_product', compact(
                    'staff_id', 'branch_id', 'product_id', 'price_type', 'customer_id', 'return_quantity', 'return_total_price', 'return_grand_total', 'reason'
               ));

          } // end foreach

          // if any failed updates recorded, rollback and return error
          if (count($failedUpdates) > 0) {
               if ($useTransaction) $getFromU->rollback();
               echo json_encode(['success' => false, 'message' => 'Failed to update product IDs: ' . implode(',', $failedUpdates)]);
               exit;
          }

          // prepare to insert purchase record
          // $reason = $_POST['reason'] ?? 'cash';
          // $customer_phone = $_POST['customer_phone'] ?? '';
          // $price_type = $price_type;

          // $product_id_str = implode(',', $ids);
          // $quantity_str = implode(',', $quantities_for_record);
          // $total_price_str = implode(',', $total_prices);

          // if (!empty($product_id_str) && $grand_total > 0) {
          //      $product_id_str = $getFromU->checkInput($product_id_str);
          //      $quantity_str = $getFromU->checkInput($quantity_str);
          //      $total_price_str = $getFromU->checkInput($total_price_str);
          //      $reason = $getFromU->checkInput($reason);
          //      $grand_total = $getFromU->checkInput($grand_total);
          //      $trans_code = $getFromU->checkInput($trans_code);
          //      $price_type = $getFromU->checkInput($price_type);

          //      $customer_id = $getFromU->select_one_val('customers', 'id', 'name', $customer_phone);
          //      if (!isset($_SESSION['branch_id'])) {
          //           $branch_id = $getFromU->select_one_val('user', 'branch_id', 'id', $user_id);
          //      } else {
          //           $branch_id = $_SESSION['branch_id'];
          //      }

          //      // map to expected insert variable names
          //      $product_id = $product_id_str;
          //      $quantity = $quantity_str;
          //      $total_price = $total_price_str;

          //      $purchase_products = $getFromU->create('return_product', compact(
          //           'staff_id', 'branch_id', 'product_id', 'price_type', 'customer_id', 'return_quantity', 'return_total_price', 'return_grand_total', 'reason'
          //      ));

          //      if ($purchase_products) {
          //           if ($useTransaction) $getFromU->commit();

          //           $_SESSION['status'] = "Product Purchase Successful";
          //           $_SESSION['code'] = "success";

          //           echo json_encode(['success'=>true, 'message'=>'Product Purchased Successfully!', 'remaining_text' => implode('; ', $remaining_texts)]);
          //           exit;
          //      } else {
          //           if ($useTransaction) $getFromU->rollback();
          //           echo json_encode(['success'=>false, 'message'=>'Unable to insert purchase record, an error occurred!']);
          //           exit;
          //      }
          // } else {
          //      if ($useTransaction) $getFromU->rollback();
          //      echo json_encode(['success'=>false, 'message'=>'Empty product list or zero grand total']);
          //      exit;
          // }

     } else {
          echo json_encode(['success'=>false, 'message'=>'An error occurred!']);
          exit;
     }

     
     // if (isset($_POST['return_barcode']) && isset($_POST['return_sales_type'])) {
     //      $return_barcode = trim($_POST['return_barcode']);
     //      $return_sales_type = trim($_POST['return_sales_type']);

     //      // fetch product (assoc row) - searches by barcode OR name and respects branch if session set
     //      $selectProduct_forReturn = $getFromU->select_all_two_or_cond_branch(
     //           'products',
     //           'barcode',
     //           $return_barcode,
     //           'name',
     //           $return_barcode
     //      );

     //      // fetch Wholesale Price (scalar) if any - searches market_products.name OR market_products.barcode
     //      $marketPrice = $getFromU->select_one_value_two_or_conds(
     //           'market_products',
     //           'price',
     //           'name',
     //           $return_barcode,
     //           'barcode',
     //           $return_barcode
     //      );

     //      $htmlo = '';

     //      if ($selectProduct_forReturn) {
     //           // determine price based on requested sales type
     //           // fallbacks: if special missing, fall back to price; if Wholesale Price missing, fall back to price
     //           $price = $selectProduct_forReturn['price'] ?? 0;
     //           $specialPrice = $selectProduct_forReturn['special_price'] ?? null;

     //           switch (strtolower($return_sales_type)) {
     //                case 'regular':
     //                     $price = $selectProduct_forReturn['price'] ?? $price;
     //                     break;

     //                case 'special':
     //                     $price = $specialPrice !== null && $specialPrice !== '' ? $specialPrice : ($selectProduct_forReturn['price'] ?? $price);
     //                     break;

     //                case 'market':
     //                     $price = $marketPrice !== null ? $marketPrice : ($selectProduct_forReturn['price'] ?? $price);
     //                     break;

     //                default:
     //                     // unknown sales type -> fallback to product price or marketPrice
     //                     $price = $selectProduct_forReturn['price'] ?? ($marketPrice ?? 0);
     //                     break;
     //           }

     //           // compute default total for qty = 1
     //           $quantityAvailable = $selectProduct_forReturn['quantity'] ?? 0;
     //           $total = floatval($price) * 1;

     //           // sanitize values before embedding in HTML
     //           $img = htmlspecialchars($selectProduct_forReturn['product_pics'] ?? '', ENT_QUOTES);
     //           $name = htmlspecialchars($selectProduct_forReturn['name'] ?? '', ENT_QUOTES);
     //           $prodId = intval($selectProduct_forReturn['id'] ?? 0);
     //           $prodQty = htmlspecialchars((string)$quantityAvailable, ENT_QUOTES);
     //           $priceEsc = htmlspecialchars((string)$price, ENT_QUOTES);
     //           $totalEsc = htmlspecialchars(number_format($total, 2, '.', ''), ENT_QUOTES);

     //           // Build the HTML row
     //           $htmlo .= "<tr>
     //                <td>
     //                     <img src='{$img}' style='border-radius: 50%;' class='border-rounded' width='40' height='40' alt='{$name}'>
     //                </td>
     //                <td>
     //                     <input class='form-control' type='text' value='{$name}' readonly>
     //                     <input type='hidden' name='product_id' value='{$prodId}'>
     //                     <input type='hidden' name='quantity_available' value='{$prodQty}'>
     //                </td>
     //                <td>
     //                     <input class='form-control price' id='return_price' name='return_price' type='number' step='any' value='{$priceEsc}' readonly>
     //                </td>
     //                <td>
     //                     <input class='form-control quantity' data-id='{$prodId}' name='return_quantity' min='0.1' id='return_quantity' type='number' value='1' step='any' max='{$prodQty}' required>
     //                </td>
     //                <td>
     //                     <input class='form-control total_price' name='return_total_price' id='return_total_price' type='number' step='any' value='{$totalEsc}' readonly>
     //                </td>
     //           </tr>";
     //      } else {
     //           // optional: provide a "not found" row or empty result
     //           $htmlo .= "<tr><td colspan='5'>Product not found for '{$return_barcode}'</td></tr>";
     //      }

     //      echo $htmlo;
     //      exit;
     //      }



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
     //           echo '<script>window.location.href="../products_return"</script>';
     //      } else {
     //           $_SESSION['status'] = "Failed to return Product, set Branch and Staff 😢";
     //           $_SESSION['code'] = "danger";
     //           $_SESSION['ErrorMessage'] = "Failed to return Product, set Branch and Staff 😢";
     //           echo '<script>window.location.href="../products_return"</script>';
     //      }

     // }
