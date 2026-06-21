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
                                        <h5 class="m-b-10">Swap Products</h5>
                                        <p class="m-b-0">Welcome to <?= $selectCompanyName ?></p>
                                   </div>
                                   </div>
                                   <div class="col-md-4">
                                   <ul class="breadcrumb">
                                        <li class="breadcrumb-item">
                                             <a href="dashboard"> <i class="fa fa-home"></i> </a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#!">Swap</a>
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
                                                <div class="card-body">
                                                    <h4>Create Swap / Trade-in</h4>

                                                    <form id="swap-form">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                        <label>Customer (optional)</label>
                                                        <div class="form-group">
                                                            <label class="form-label text-muted small mb-1">Select Customer</label>
                                                            <select name="swap_customer" id="swap_customer" class="form-control select2-customer">
                                                                <option value="">Walk-in / No Customer</option>
                                                                <?php foreach($selectBranchCustomers as $selectCustomer): ?>
                                                                    <option value="<?= $selectCustomer?->id ?>">
                                                                        <?= $selectCustomer?->name ?> 
                                                                        <?php if(!empty($selectCustomer?->phone_number)): ?>
                                                                            (<?= $selectCustomer?->phone_number ?>)
                                                                        <?php endif; ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label>Branch (auto)</label>
                                                            <input class="form-control" readonly value="<?= htmlspecialchars($sessionBranch ?? '') ?>">
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                        <h6>Product customer brought (trade-in)</h6>
                                                        <div class="form-group">
                                                            <input type="text" id="brought_product" list="productOptions" placeholder="Search product customer brought" class="form-control" required>
                                                            <input type="hidden" id="brought_product_id">
                                                            <datalist id="productOptions">
                                                            <?php foreach($selectActiveProducts as $p): ?>
                                                                <option data-id="<?= $p?->id ?>" value="<?= htmlspecialchars($p?->name) ?>"></option>
                                                            <?php endforeach; ?>
                                                            </datalist>
                                                        </div>

                                                        <div class="form-row">
                                                            <div class="col">
                                                            <label>Quantity brought-in</label>
                                                            <input type="number" min="0.0001" step="0.0001" id="brought_quantity" class="form-control" value="1" required>
                                                            </div>
                                                            <div class="col">
                                                            <label>Product Brought trade value (₦)</label>
                                                            <input type="number" min="0" step="0.01" id="brought_unit_value" class="form-control" value="0.00" required>
                                                            </div>
                                                        </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                        <h6>Product customer wants (from inventory)</h6>
                                                        <div class="form-group">
                                                            <input type="text" id="wanted_product" list="productOptions" placeholder="Search product customer wants" class="form-control" required>
                                                            <input type="hidden" id="wanted_product_id">
                                                        </div>

                                                        <div class="form-row">
                                                            <div class="col">
                                                            <label>Product wanted quantity</label>
                                                            <input type="number" min="0.0001" step="0.0001" id="wanted_quantity" class="form-control" value="1" required>
                                                            </div>
                                                            <div class="col">
                                                            <label>Product wanted value (₦)</label>
                                                            <input type="number" min="0" step="0.01" id="wanted_unit_value" class="form-control" value="0.00" required>
                                                            </div>
                                                        </div>

                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                        <label>Cash customer adds (₦)</label>
                                                        <input type="number" min="0" step="0.01" id="cash_added" class="form-control" value="0.00" required>
                                                        <small class="text-muted">This is the amount the customer pays in addition to the brought item(s). This is the amount that will display on the receipt.</small>
                                                        </div>

                                                        <div class="col-md-8">
                                                        <label>Additional info</label>
                                                        <textarea id="swap_additional_info" class="form-control" rows="2"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="mt-3 text-end">
                                                        <button type="submit" id="save-swap" class="btn btn-primary btn-lg">
                                                        <i class="fas fa-exchange-alt me-2"></i>Create Swap
                                                        </button>
                                                    </div>
                                                    </form>
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
// small helper to map datalist choice to id
function findProductIdByName(name) {
  const opts = document.querySelectorAll('#productOptions option');
  for (let o of opts) {
    if (o.value === name) return o.getAttribute('data-id');
  }
  return null;
}

// keep both inputs in sync
document.getElementById('brought_product').addEventListener('change', function() {
  document.getElementById('brought_product_id').value = findProductIdByName(this.value) || '';
});
document.getElementById('wanted_product').addEventListener('change', function() {
  document.getElementById('wanted_product_id').value = findProductIdByName(this.value) || '';
});

// submit via AJAX
document.getElementById('swap-form').addEventListener('submit', function(e) {
  e.preventDefault();
  const btn = document.getElementById('save-swap');
  btn.disabled = true; btn.innerText = 'Processing...';

  const payload = {
    brought_product_id: document.getElementById('brought_product_id').value,
    brought_product_name: document.getElementById('brought_product').value,
    brought_quantity: document.getElementById('brought_quantity').value,
    brought_unit_value: document.getElementById('brought_unit_value').value,

    wanted_product_id: document.getElementById('wanted_product_id').value,
    wanted_product_name: document.getElementById('wanted_product').value,
    wanted_quantity: document.getElementById('wanted_quantity').value,
    wanted_unit_value: document.getElementById('wanted_unit_value').value,

    cash_added: document.getElementById('cash_added').value,
    customer_id: document.getElementById('swap_customer').value,
    additional_info: document.getElementById('swap_additional_info').value
  };

  $.ajax({
    url: 'validation/swap_process.php',
    method: 'POST',
    dataType: 'json',
    data: { type: 'create_swap', data: JSON.stringify(payload) },
    success: function(res) {
      btn.disabled = false; btn.innerText = 'Create Swap';
      if (res.success) {
        Swal.fire({
          icon: 'success',
          title: 'Swap Created',
          text: res.message || 'Swap recorded successfully',
          confirmButtonText: 'Print Receipt',
          confirmButtonColor: '#0d6efd',
          showCancelButton: true,
          cancelButtonText: 'Go to list'
        }).then(choice => {
        if (choice.isConfirmed) {
            const basePath = <?= json_encode(BASE_URL) ?>;
            const root = String(basePath).replace(/\/$/, '');
            window.open(root + '/swap_receipt.php?code=' + encodeURIComponent(res.trans_code), '_blank');
            location.reload();
        } else {
            const basePath = <?= json_encode(BASE_URL) ?>;
            const root = String(basePath).replace(/\/$/, '');
            window.location.href = root + '/swaps_list';
        }
        });
      } else {
        Swal.fire({ icon:'warning', title: 'Error', text: res.message || 'Unable to create swap' });
      }
    },
    error: function(err) {
      console.error(err);
      btn.disabled = false; btn.innerText = 'Create Swap';
      Swal.fire({ icon:'error', title:'Operation Failed', text:'Check console for details.' });
    }
  });
});
</script>
