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
                                        <h5 class="m-b-10">Create Product</h5>
                                        <p class="m-b-0">Welcome to <?= $selectCompanyName ?></p>
                                   </div>
                              </div>
                              <div class="col-md-4">
                                   <ul class="breadcrumb">
                                        <li class="breadcrumb-item">
                                             <a href="dashboard"> <i class="fa fa-home"></i> </a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#!">Create Product</a>
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
                                   <div class="card">
                                        <div class="card-header">
                                             <h5>Create Product</h5>
                                             <div class="card-header-right">
                                                  <a href="product">
                                                       <input type="button" name="branch" class="btn btn-success" value="Product Page">
                                                  </a>
                                                  <!-- <ul class="list-unstyled card-option">
                                                            <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                                            <li><i class="fa fa-window-maximize full-card"></i></li>
                                                            <li><i class="fa fa-minus minimize-card"></i></li>
                                                            <li><i class="fa fa-refresh reload-card"></i></li>
                                                            <li><i class="fa fa-trash close-card"></i></li>
                                                       </ul> -->
                                             </div>
                                        </div>
                                        <div class="card-block">
                                             <div class="form-container">
                                                  <form class="form-material" method="POST" action="validation/validate_create_product" enctype="multipart/form-data">
                                                       <div class="row g-4">
                                                            <!-- Product Name -->
                                                            <div class="col-md-6">
                                                                 <div class="form-group form-default form-static-label enhanced-form-group">
                                                                 <input type="text" name="name" class="form-control enhanced-input" placeholder="Enter Product Name" required>
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Product Name</label>
                                                                 <div class="form-icon">
                                                                      <i class="fas fa-tag"></i>
                                                                 </div>
                                                                 </div>
                                                            </div>

                                                            <!-- Product Barcode -->
                                                            <div class="col-md-6">
                                                                 <div class="form-group form-default form-static-label enhanced-form-group">
                                                                 <input type="text" name="barcode" class="form-control enhanced-input" placeholder="Enter Product Barcode">
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Product Barcode</label>
                                                                 <div class="form-icon">
                                                                      <i class="fas fa-barcode"></i>
                                                                 </div>
                                                                 </div>
                                                            </div>

                                                            <!-- Pricing Section -->
                                                            <div class="col-md-4">
                                                                 <div class="form-group form-default form-static-label enhanced-form-group">
                                                                 <input type="number" step="any" name="price" class="form-control enhanced-input" placeholder="Enter Product Price" required>
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Product Price</label>
                                                                 <div class="form-icon">
                                                                      <i class="fas fa-tag"></i>
                                                                 </div>
                                                                 </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                 <div class="form-group form-default form-static-label enhanced-form-group">
                                                                 <input type="number" step="any" name="market_price" class="form-control enhanced-input" placeholder="Enter Wholesale Price" required>
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Wholesale Price</label>
                                                                 <div class="form-icon">
                                                                      <i class="fas fa-shopping-cart"></i>
                                                                 </div>
                                                                 </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                 <div class="form-group form-default form-static-label enhanced-form-group">
                                                                 <input type="number" step="any" name="special_price" class="form-control enhanced-input" placeholder="Enter Retail Price" required>
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Retail Price</label>
                                                                 <div class="form-icon">
                                                                      <i class="fas fa-percentage"></i>
                                                                 </div>
                                                                 </div>
                                                            </div>

                                                            <!-- Status & Quantity -->
                                                            <div class="col-md-4">
                                                                 <div class="form-group form-default form-static-label enhanced-form-group">
                                                                 <select name="status" class="form-control enhanced-select" required>
                                                                      <option value="0" selected>Active</option>
                                                                      <option value="1">Suspend</option>
                                                                 </select>
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Product Status</label>
                                                                 <div class="form-icon">
                                                                      <i class="fas fa-toggle-on"></i>
                                                                 </div>
                                                                 </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                 <div class="form-group form-default form-static-label enhanced-form-group">
                                                                 <input type="number" step="any" name="quantity" class="form-control enhanced-input" placeholder="Enter Product Quantity" required>
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Product Quantity</label>
                                                                 <div class="form-icon">
                                                                      <i class="fas fa-boxes"></i>
                                                                 </div>
                                                                 </div>
                                                            </div>

                                                            <!-- Pack Size -->
                                                            <div class="col-md-4">
                                                                 <div class="form-group form-default form-static-label enhanced-form-group">
                                                                 <select name="is_pack" class="form-control enhanced-select" id="is_pack" required>
                                                                      <option value="0">Single Product</option>
                                                                      <option value="1">Packed Size (with Quantity)</option>
                                                                 </select>
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Product Type</label>
                                                                 <div class="form-icon">
                                                                      <i class="fas fa-box"></i>
                                                                 </div>
                                                                 </div>
                                                            </div>

                                                            <!-- Pack Size (Conditional) -->
                                                            <div class="col-md-4" id="pack_size" style="display: none;">
                                                                 <div class="form-group form-default form-static-label enhanced-form-group">
                                                                 <input type="number" step="any" name="pack_size" id="pack_size_input" class="form-control enhanced-input" placeholder="e.g., 24 (Bottles in a Crate)">
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Pack Size Quantity</label>
                                                                 <div class="form-icon">
                                                                      <i class="fas fa-layer-group"></i>
                                                                 </div>
                                                                 </div>
                                                            </div>

                                                            <!-- Branch Selection -->
                                                            <div class="col-md-4">
                                                                 <div class="form-group form-default form-static-label enhanced-form-group">
                                                                 <select name="branch_id" class="form-control enhanced-select" required>
                                                                      <option value="">Choose Branch</option>
                                                                      <?php foreach ($selectBranches as $selectBranches): ?>
                                                                           <option value="<?= $selectBranches->id ?>"><?= ucwords($selectBranches->branch_name) ?></option>
                                                                      <?php endforeach; ?>
                                                                 </select>
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Branch Location</label>
                                                                 <div class="form-icon">
                                                                      <i class="fas fa-store"></i>
                                                                 </div>
                                                                 </div>
                                                            </div>

                                                            <!-- Distributor Selection -->
                                                            <div class="col-md-4">
                                                                 <div class="form-group form-default form-static-label enhanced-form-group">
                                                                 <select name="distributor" class="form-control enhanced-select" required>
                                                                      <option value="">Select Distributor</option>
                                                                      <?php foreach ($selectDistributors as $selectDistributor): ?>
                                                                           <option value="<?= $selectDistributor->id ?>"><?= ucwords($selectDistributor->name) ?></option>
                                                                      <?php endforeach; ?>
                                                                 </select>
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Product Distributor</label>
                                                                 <div class="form-icon">
                                                                      <i class="fas fa-truck"></i>
                                                                 </div>
                                                                 </div>
                                                            </div>

                                                            <!-- Category Selection -->
                                                            <div class="col-md-4">
                                                                 <div class="form-group form-default form-static-label enhanced-form-group">
                                                                 <select name="category" class="form-control enhanced-select" required>
                                                                      <option value="">Select Category</option>
                                                                      <?php foreach ($selectCategories as $selectCategory): ?>
                                                                           <option value="<?= $selectCategory->id ?>"><?= $selectCategory->name ?></option>
                                                                      <?php endforeach; ?>
                                                                 </select>
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Product Category</label>
                                                                 <div class="form-icon">
                                                                      <i class="fas fa-folder"></i>
                                                                 </div>
                                                                 </div>
                                                            </div>

                                                            <!-- Enhanced File Upload -->
                                                            <div class="col-md-4">
                                                                 <div class="form-group enhanced-form-group">
                                                                 <label class="form-label">Product Picture</label>
                                                                 <div class="file-upload-wrapper">
                                                                      <input type="file" name="product_pics" class="file-upload-input" id="product_pics" accept="image/*">
                                                                      <div class="file-upload-area">
                                                                           <div class="file-upload-icon">
                                                                                <i class="fas fa-cloud-upload-alt"></i>
                                                                           </div>
                                                                           <div class="file-upload-text">
                                                                                <h4>Drag & Drop or Click to Upload</h4>
                                                                                <p>Supports JPG, PNG, GIF - Max 5MB</p>
                                                                           </div>
                                                                           <div class="file-upload-preview" id="file-preview" style="display: none;">
                                                                                <img id="preview-image" src="" alt="Preview">
                                                                                <span class="file-name" id="file-name"></span>
                                                                           </div>
                                                                      </div>
                                                                      <button type="button" class="file-browse-btn">
                                                                           <i class="fas fa-folder-open me-2"></i>Browse Files
                                                                      </button>
                                                                 </div>
                                                                 </div>
                                                            </div>

                                                            <!-- Description -->
                                                            <div class="col-8">
                                                                 <div class="form-group form-default form-static-label enhanced-form-group">
                                                                      <label for="">Product Description</label>
                                                                      <textarea name="description" class="form-control enhanced-textarea" cols="30" rows="6" placeholder="Enter product description..."></textarea>
                                                                      <span class="form-bar"></span>
                                                                      <label class="float-label">Product Description</label>
                                                                      <div class="form-icon textarea-icon">
                                                                           <i class="fas fa-align-left"></i>
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                       </div>

                                                       <!-- Submit Button -->
                                                       <div class="form-submit-section">
                                                            <button type="submit" name="product" class="btn btn-primary btn-create-product">
                                                                 <i class="fas fa-plus-circle me-2"></i>Create Product
                                                            </button>
                                                       </div>
                                                  </form>
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

<?php
     include 'elements/footer.php';
?>
