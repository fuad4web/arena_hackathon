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

        .hidden { display: none; }

        .invalid-feedback { display: block; font-size: 0.875em; margin-top: 0.25rem; }

        .is-invalid { border-color: #dc3545; padding-right: calc(1.5em + 0.75rem); background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e"); background-repeat: no-repeat; background-position: right calc(0.375em + 0.1875rem) center; background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem); }

        .is-invalid:focus { border-color: #dc3545; box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25); }

        /* Modal button loading state */
        #saveCustomerBtn:disabled { opacity: 0.7; cursor: not-allowed; }

        /* Modal alerts */
        #errorAlert, #successAlert { animation: slideDown 0.3s ease-out; }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
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
                                        <h5 class="m-b-10">Order Products</h5>
                                        <p class="m-b-0">Welcome to <?= $selectCompanyName ?></p>
                                   </div>
                                   </div>
                                   <div class="col-md-4">
                                   <ul class="breadcrumb">
                                        <li class="breadcrumb-item">
                                             <a href="dashboard"> <i class="fa fa-home"></i> </a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#!">Order</a>
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
                                                <h3>Order Product<small>(s)</small></h3>
                                                <span>List of all Products Ordered</span>
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
                                                
                                                <div class="d-flex justify-content-between inputs my-4">
                                                    <div class="col-md-3">
                                                        <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#exampleModal">
                                                            <i class="fas fa-user-plus me-2"></i>Add Customer
                                                        </button>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <a href="./receipt?code=<?= $my_last_sale ?>" class="btn btn-danger btn-lg">
                                                            <i class="fas fa-print me-2"></i>Print Last Receipt
                                                        </a>
                                                    </div>
                                                </div>
                                                
                                                <div class="d-flex justify-content-between my-4 align-items-center">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="form-label text-muted small mb-1">Sales Type</label>
                                                            <select class="form-control sales_type form-select-lg" id="sales_type">
                                                                <option value="regular">Regular Price</option>
                                                                <option value="special">Retail Price</option>
                                                                <option value="market">Wholesale Price</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6" id="market-place">
                                                        <div class="form-group">
                                                            <label class="form-label text-muted small mb-1">Search Product</label>
                                                            <div class="input-group" id="product-input">
                                                                    <input type="text" name="barcode" list="productOptions" id="product_barcode" placeholder="Search Product or Scan Barcode" autocomplete="off" class="form-control" required autofocus>
                                                                    <datalist id="productOptions">
                                                                        <?php foreach($selectActiveProducts as $selectActiveProduct): ?>
                                                                            <option value="<?= $selectActiveProduct->name ?>">
                                                                        <?php endforeach; ?>
                                                                    </datalist>

                                                                    <input type="button" name="submit" id="submit_barcode" value="ADD PRODUCT" class="btn btn-primary">
                                                            </div>
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
                                                    <form action="validation/purchase_product" method="POST" id="sales-form">
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
                                                            <tfoot id="cart-footer" style="">
                                                                <tr>
                                                                    <td colspan="5" class="text-end"><strong>Subtotal:</strong></td>
                                                                    <td><strong id="product_subtotal">0.00</strong></td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="5" class="text-end"><strong>VAT (<?= $selectCompanyVat ?>)%:</strong></td>
                                                                    <td><strong id="vat_amount">0.00</strong></td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr class="table-active">
                                                                    <td colspan="5" class="text-end"><strong>Grand Total (with VAT):</strong></td>
                                                                    <td><strong id="grand-total-display">0.00</strong></td>
                                                                    <td></td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                        
                                                        <div class="row mt-4 bg-light p-4 rounded">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="form-label text-muted small mb-1">Payment Mode</label>
                                                                    <select name="payment_mode" id="payment_mode" class="form-control form-select-lg">
                                                                        <option value="cash">Cash</option>
                                                                        <option value="transfer">Transfer</option>
                                                                        <option value="cheque">Cheque</option>
                                                                        <option value="creditor" class="creditor">Creditor</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-3 hidden">
                                                                <label for="">Amount Creditor Paid</label>
                                                                <input type="number" name="credit" value="0" id="jkashuias" class="form-control">
                                                            </div>
                                                            
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="form-label text-muted small mb-1">Select Customer</label>
                                                                    <select name="customer_phone" id="customer_phone" class="form-control select2-customer" required>
                                                                        <option value="">Select Customer</option>
                                                                        <?php foreach($selectBranchCustomers as $selectCustomer): ?>
                                                                            <option value="<?= $selectCustomer->id ?>">
                                                                                <?= $selectCustomer->name ?> 
                                                                                <?php if(!empty($selectCustomer->phone_number)): ?>
                                                                                    (<?= $selectCustomer->phone_number ?>)
                                                                                <?php endif; ?>
                                                                            </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
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

                                                            <div class="form-group form-default form-static-label enhanced-form-group">
                                                                <textarea name="additional_info" id="additional_info" class="form-control enhanced-textarea" cols="30" rows="4" placeholder="Enter additional info..."></textarea>
                                                                <span class="form-bar"></span>
                                                                <label class="float-label">Additional Information</label>
                                                                <div class="form-icon textarea-icon">
                                                                    <i class="fas fa-align-left"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="text-center mt-5">
                                                            <button type="submit" id="savesjkbsd" name="pro_purchase" 
                                                                    class="btn btn-success btn-lg btn-purchase">
                                                                <i class="fas fa-shopping-cart me-2"></i>
                                                                Complete Purchase
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

    <!-- Add Customer Modals -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="customerForm" method="POST" action="javascript:void(0);">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Customer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Error Alert Container -->
                        <div class="alert alert-danger alert-dismissible fade show d-none" id="errorAlert" role="alert">
                            <span id="errorMessage"></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        
                        <!-- Success Alert Container -->
                        <div class="alert alert-success alert-dismissible fade show d-none" id="successAlert" role="alert">
                            <span id="successMessage"></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        
                        <div class="form-group">
                            <label for="customerName">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="customerName" name="name" required>
                            <div class="invalid-feedback" id="nameError"></div>
                        </div>
                        <div class="form-group">
                            <label for="customerPhone">Phone Number <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="customerPhone" name="phone_number" required>
                            <div class="invalid-feedback" id="phoneError"></div>
                        </div>
                        <!-- <div class="form-group">
                            <label for="customerStatus">Customer Status <span class="text-danger">*</span></label>
                            <select name="status" id="customerStatus" class="form-control" required>
                                <option value="regular">Regular</option>
                                <option value="special">Special</option>
                            </select>
                            <div class="invalid-feedback" id="statusError"></div>
                        </div> -->
                        <div class="form-group">
                            <label for="customerAddress">Address</label>
                            <textarea class="form-control" id="customerAddress" name="address" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="saveCustomerBtn">
                            <span class="spinner-border spinner-border-sm d-none" id="loadingSpinner" role="status" aria-hidden="true"></span>
                            <span id="btnText">Save Customer</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
    include 'elements/footer.php';
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('product_barcode').focus();
    });
    
    document.getElementById('product_barcode').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            document.getElementById('submit_barcode').click();
        }
    });

    window.onload = function () {
        window.scrollTo(0, 300); // adjust 150 to whatever feels right
    };
</script>