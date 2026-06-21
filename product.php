<?php
include 'elements/header.php';
?>

<div class="pcoded-main-container">
     <div class="pcoded-wrapper">

          <?php
          include 'elements/sidebar.php';
          ?>

          <div class="pcoded-content">

               <!-- Breadcrumbs -->
               <div class="page-header">
                    <div class="page-block">
                         <div class="row align-items-center">
                              <div class="col-md-8">
                                   <div class="page-header-title">
                                        <h5 class="m-b-10">Product Page</h5>
                                        <p class="m-b-0">Welcome to <?= $selectCompanyName ?></p>
                                   </div>
                              </div>
                              <div class="col-md-4">
                                   <ul class="breadcrumb">
                                        <li class="breadcrumb-item">
                                             <a href="dashboard"> <i class="fa fa-home"></i> </a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#!">Product</a>
                                        </li>
                                   </ul>
                              </div>
                         </div>
                    </div>
               </div>

               <div class="pcoded-inner-content">
                    <div class="main-body">
                         <div class="page-wrapper">
                              <div class="page-body">
                                   <?php
                                        echo SuccessMessage();
                                        echo ErrorMessage();
                                   ?>
                                   <div class="card text-info">
                                        <div class="card-header">
                                             <h5>Products</h5>
                                             <span>List of all Products</span>
                                             <div class="card-header-right d-flex gap-2">
                                                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#productFilterModal">
                                                       <i class="fa fa-filter"></i> Filter Products
                                                  </button>

                                                  <a href="create_product">
                                                       <input type="button" name="branch" class="btn btn-success" value="Create Product">
                                                  </a>
                                             </div>
                                        </div>
                                        <div class="list-products-page">
                                             <!-- Totals Section (kept from your footer) -->
                                             <div class="row mb-4">
                                                  <div class="col-md-6">
                                                       <div class="card bg-light">
                                                            <div class="card-body">
                                                                 <h5 class="card-title mb-0" style="font-weight: 400; font-size: 18px;">
                                                                      Total Price of Products: 
                                                                      <span style="font-weight: 650;">
                                                                      <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?><?= @number_format($sumTotalProductsAmount, 2, '.', ',') ?>
                                                                      </span>
                                                                 </h5>
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                       <div class="card bg-light">
                                                            <div class="card-body">
                                                                 <h5 class="card-title mb-0" style="font-weight: 400; font-size: 18px;">
                                                                      Total Quantity of Products: 
                                                                      <span style="font-weight: 650;">
                                                                      <?= @number_format($totalProductsInStore, 0, '.', ',') ?>
                                                                      </span>
                                                                      <small>pieces</small>
                                                                 </h5>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>

                                             <!-- Products Cards Grid -->
                                             <div class="row" id="products-grid">
                                                  <?php
                                                  $i = 0;
                                                  foreach ($selectProducts as $selectProduct):
                                                       $i++;
                                                       $product_category = $getFromU->select_one_val('product_category', 'name', 'id', $selectProduct?->category);
                                                       $product_distributor = $getFromU->select_one_val('distributors', 'name', 'id', $selectProduct?->distributor);
                                                       $branchName = $getFromU->select_one_val('branches', 'branch_name', 'id', $selectProduct?->branch_id);
                                                  ?>
                                                  <div class="col-xl-4 col-lg-6 col-md-6 mb-4 product-item"
                                                       data-name="<?= strtolower($selectProduct?->name) ?>"
                                                       data-barcode="<?= strtolower($selectProduct?->barcode ?? '') ?>"
                                                       data-branch="<?= strtolower($branchName) ?>"
                                                       data-category="<?= strtolower($product_category) ?>"
                                                       data-distributor="<?= strtolower($product_distributor) ?>"
                                                       data-status="<?= ($selectProduct?->status === 0) ? 'active' : 'inactive' ?>"
                                                       data-price="<?= $selectProduct?->price ?>"
                                                       data-retail="<?= $selectProduct?->special_price ?>"
                                                       data-wholesale="<?= $selectProduct?->market_price ?>"
                                                  >
                                                       <div class="card product-card h-100 shadow-sm">
                                                            <!-- Card Header with Image and Status -->
                                                            <div class="card-header position-relative bg-transparent border-bottom-0 pb-0">
                                                                 <div class="d-flex justify-content-between align-items-start">
                                                                      <div class="product-image-wrapper">
                                                                      <img src="<?= $selectProduct?->product_pics ?>" 
                                                                           class="card-img-top rounded-circle border" 
                                                                           alt="<?= $selectProduct?->name ?>"
                                                                           style="width: 80px; height: 80px; object-fit: cover;">
                                                                      </div>
                                                                      <div class="product-status">
                                                                           <span class="badge <?= ($selectProduct?->status === 0) ? 'bg-primary' : 'bg-danger' ?>">
                                                                                <?= ($selectProduct?->status === 0) ? 'Active' : 'Suspended' ?>
                                                                           </span>
                                                                      </div>
                                                                 </div>
                                                            </div>

                                                            <!-- Card Body -->
                                                            <div class="card-body pt-2">
                                                                 <!-- Product Name and Barcode -->
                                                                 <h5 class="card-title text-dark mb-1"><?= ucwords($selectProduct?->name) ?></h5>
                                                                 <p class="text-muted small mb-2">
                                                                      <i class="fas fa-barcode me-1"></i>Barcode: <?= $selectProduct?->barcode ?? 'No Barcode' ?>
                                                                 </p>

                                                                 <!-- Branch Info -->
                                                                 <div class="branch-info mb-2">
                                                                      <span class="badge bg-info">
                                                                      <i class="fas fa-store me-1"></i>Branch: <?= ucwords($branchName) ?>
                                                                      </span>
                                                                 </div>

                                                                 <!-- Pricing Information -->
                                                                 <div class="pricing-info mb-3">
                                                                      <div class="d-flex justify-content-between align-items-center mb-1">
                                                                           <span class="text-muted small">Regular Price:</span>
                                                                           <span class="fw-bold text-dark">
                                                                                <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?><?= @number_format($selectProduct?->price, 2, '.', ',') ?>
                                                                           </span>
                                                                      </div>
                                                                      <div class="d-flex justify-content-between align-items-center">
                                                                           <span class="text-muted small">Retail Price:</span>
                                                                           <span class="fw-bold text-success">
                                                                                <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?><?= @number_format($selectProduct?->special_price, 2, '.', ',') ?>
                                                                           </span>
                                                                      </div>
                                                                      <div class="d-flex justify-content-between align-items-center">
                                                                           <span class="text-muted small">Wholesale Price:</span>
                                                                           <span class="fw-bold text-success">
                                                                                <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?><?= @number_format($selectProduct?->market_price, 2, '.', ',') ?>
                                                                           </span>
                                                                      </div>
                                                                 </div>

                                                                 <!-- Quantity Information -->
                                                                 <div class="quantity-info mb-3 p-2 bg-light rounded">
                                                                      <?php if($selectProduct?->is_pack !== 1): ?>
                                                                      <div class="text-center">
                                                                           <span class="fw-bold text-primary" style="font-size: 1.1rem;">
                                                                                <?= number_format(@$selectProduct?->quantity, 0) ?> Units
                                                                           </span>
                                                                      </div>
                                                                      <?php else: 
                                                                      $crates = floor(@$selectProduct?->quantity);
                                                                      $bottles = round(($selectProduct?->quantity - $crates) * $selectProduct?->pack_size);
                                                                      ?>
                                                                      <div class="text-center">
                                                                           <span class="fw-bold text-primary d-block" style="font-size: 1.1rem;">
                                                                                <?= $crates ?> Packs
                                                                           </span>
                                                                           <span class="text-muted small">
                                                                                <?= $bottles ?> quantities • Pack Size: <?= $selectProduct?->pack_size ?>
                                                                           </span>
                                                                      </div>
                                                                      <?php endif; ?>
                                                                 </div>

                                                                 <!-- Category and Distributor -->
                                                                 <div class="product-meta">
                                                                      <div class="row text-center">
                                                                      <div class="col-6">
                                                                           <small class="text-muted d-block">Category</small>
                                                                           <span class="fw-semibold"><?= ucwords($product_category) ?></span>
                                                                      </div>
                                                                      <div class="col-6">
                                                                           <small class="text-muted d-block">Distributor</small>
                                                                           <span class="fw-semibold"><?= ucwords($product_distributor) ?></span>
                                                                      </div>
                                                                      </div>
                                                                 </div>
                                                            </div>

                                                            <!-- Card Footer with Actions -->
                                                            <?php if ($getFromU->hasAccess($user_id, 'update_product') || $getFromU->hasAccess($user_id, 'delete_product')): ?>
                                                            <div class="card-footer bg-transparent border-top-0 pt-0">
                                                                 <div class="d-flex justify-content-center">
                                                                      <?php if ($getFromU->hasAccess($user_id, 'update_product')): ?>
                                                                      <a href="./update_product?codes=<?= $selectProduct?->code ?>" 
                                                                      class="btn btn-outline-primary btn-sm" 
                                                                      title="Edit Product">
                                                                      <i class="fa fa-wrench me-1"></i> Edit
                                                                      </a>
                                                                      <?php endif; ?>
                                                                      
                                                                      <?php if ($getFromU->hasAccess($user_id, 'delete_product')): ?>
                                                                      <!-- Add delete button here if needed -->
                                                                      <?php endif; ?>
                                                                 </div>
                                                            </div>
                                                            <?php endif; ?>
                                                       </div>
                                                  </div>
                                                  <?php endforeach; ?>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>

          </div>
     </div>
</div>
</div>
</div>

     <div class="modal fade" id="productFilterModal" tabindex="-1" role="dialog" aria-labelledby="productFilterModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg">
          <div class="modal-content">

               <div class="modal-header">
                    <h5 class="modal-title">Filter Products</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
               </div>

               <div class="modal-body">

                    <div class="row">

                         <div class="col-md-6 mb-3">
                         <label>Product Name</label>
                         <input type="text" class="form-control" id="filterName">
                         </div>

                         <div class="col-md-6 mb-3">
                         <label>Barcode</label>
                         <input type="text" class="form-control" id="filterBarcode">
                         </div>

                         <div class="col-md-6 mb-3">
                         <label>Branch</label>
                         <!-- <input type="text" class="form-control" id="filterBranch"> -->
                         <select name="branch_id" class="form-control enhanced-select" id="filterBranch">
                              <option value="">Choose Branch</option>
                              <?php foreach ($selectBranches as $selectBranches): ?>
                                   <option value="<?= $selectBranches->branch_name ?>"><?= ucwords($selectBranches->branch_name) ?></option>
                              <?php endforeach; ?>
                         </select>
                         </div>

                         <div class="col-md-6 mb-3">
                         <label>Category</label>
                         <!-- <input type="text" class="form-control" id="filterCategory"> -->
                         <select name="category" class="form-control enhanced-select" id="filterCategory">
                              <option value="">Select Category</option>
                              <?php foreach ($selectCategories as $selectCategory): ?>
                                   <option value="<?= $selectCategory->name ?>"><?= $selectCategory->name ?></option>
                              <?php endforeach; ?>
                         </select>
                         </div>

                         <div class="col-md-6 mb-3">
                              <label>Distributor</label>
                              <!-- <input type="text" class="form-control" id="filterDistributor"> -->
                              <select name="distributor" class="form-control enhanced-select" id="filterDistributor">
                                   <option value="">Select Distributor</option>
                                   <?php foreach ($selectDistributors as $selectDistributor): ?>
                                        <option value="<?= $selectDistributor->name ?>"><?= ucwords($selectDistributor->name) ?></option>
                                   <?php endforeach; ?>
                              </select>
                         </div>

                         <div class="col-md-6 mb-3">
                         <label>Status</label>
                         <select class="form-control" id="filterStatus">
                              <option value="">All</option>
                              <option value="active">Active</option>
                              <option value="inactive">Inactive</option>
                         </select>
                         </div>

                         <div class="col-md-4 mb-3">
                         <label>Regular Price Min</label>
                         <input type="number" class="form-control" id="minPrice">
                         </div>

                         <div class="col-md-4 mb-3">
                         <label>Retail Price Min</label>
                         <input type="number" class="form-control" id="minRetail">
                         </div>

                         <div class="col-md-4 mb-3">
                         <label>Wholesale Price Min</label>
                         <input type="number" class="form-control" id="minWholesale">
                         </div>

                    </div>

               </div>

               <div class="modal-footer">
                    <button type="button" class="btn btn-secondary resetFilters">
                         Reset
                    </button>

                    <button type="button" class="btn btn-primary applyFilters">
                         Apply Filters
                    </button>
               </div>

          </div>
     </div>
     </div>

<?php
     include 'elements/footer.php';
?>
<script>
     $(document).ready(function(){
          $('.applyFilters').on('click', function(){
               let name = $('#filterName').val().toLowerCase();
               let barcode = $('#filterBarcode').val().toLowerCase();
               let branch = $('#filterBranch').val().toLowerCase();
               let category = $('#filterCategory').val().toLowerCase();
               let distributor = $('#filterDistributor').val().toLowerCase();
               let status = $('#filterStatus').val();

               let minPrice = parseFloat($('#minPrice').val()) || 0;
               let minRetail = parseFloat($('#minRetail').val()) || 0;
               let minWholesale = parseFloat($('#minWholesale').val()) || 0;

               $('.product-item').each(function(){

                    let product = $(this);

                    let show = true;

                    let pName = product.data('name').toString();
                    let pBarcode = product.data('barcode').toString();
                    let pBranch = product.data('branch').toString();
                    let pCategory = product.data('category').toString();
                    let pDistributor = product.data('distributor').toString();
                    let pStatus = product.data('status').toString();

                    let pPrice = parseFloat(product.data('price'));
                    let pRetail = parseFloat(product.data('retail'));
                    let pWholesale = parseFloat(product.data('wholesale'));

                    if(name && !pName.includes(name))
                         show = false;

                    if(barcode && !pBarcode.includes(barcode))
                         show = false;

                    if(branch && !pBranch.includes(branch))
                         show = false;

                    if(category && !pCategory.includes(category))
                         show = false;

                    if(distributor && !pDistributor.includes(distributor))
                         show = false;

                    if(status && pStatus !== status)
                         show = false;

                    if(pPrice < minPrice)
                         show = false;

                    if(pRetail < minRetail)
                         show = false;

                    if(pWholesale < minWholesale)
                         show = false;

                    product.toggle(show);

               });

               $('#productFilterModal').modal('hide');
          });

          $('.resetFilters').on('click', function(){
               $('#productFilterModal input').val('');
               $('#productFilterModal select').val('');

               $('.product-item').show();
          });
     });
</script>
