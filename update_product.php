<?php
     include 'elements/header.php';
  
     if(isset($_GET['codes'])) {
          $code = $_GET['codes'];
          $id = $getFromU->select_one_val('products', 'id', 'code', $code);
          $selectProductsOneCond = $getFromU->select_all_one_cond('products', 'id', $id);
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
                                        <h5 class="m-b-10">Update Product</h5>
                                        <p class="m-b-0">Welcome to <?= $selectCompanyName ?></p>
                                   </div>
                                   </div>
                                   <div class="col-md-4">
                                   <ul class="breadcrumb">
                                        <li class="breadcrumb-item">
                                             <a href="dashboard"> <i class="fa fa-home"></i> </a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#!">Product Update</a>
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
                                                  <h5>Update Product</h5>
                                             </div>
                                             <div class="card-block">
                                                  <div class="form-container">
                                                       <form class="form-material" method="POST" action="validation/validate_update_product" enctype="multipart/form-data">
                                                            <?php foreach($selectProductsOneCond as $selectProductOneCond): 
                                                                 $productStatus = $selectProductOneCond->status;
                                                            ?>
                                                                 <input type="hidden" name="id" value="<?= $code ?>">
                                                                 <input type="hidden" name="product_id" value="<?= $id ?>">
                                                                 <input type="hidden" name="branch_id" value="<?= $selectProductOneCond?->branch_id ?>">
                                                                 
                                                                 <div class="row g-4">
                                                                      <!-- Product Name -->
                                                                      <div class="col-md-6">
                                                                           <div class="form-group form-default form-static-label enhanced-form-group">
                                                                                <input type="text" name="name" value="<?= $selectProductOneCond->name ?>" class="form-control enhanced-input" placeholder="Enter Product Name" required>
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
                                                                           <input type="text" name="barcode" class="form-control enhanced-input" value="<?= $selectProductOneCond->barcode ?>" placeholder="Enter Product Barcode">
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
                                                                           <input type="number" step="any" name="price" value="<?= $selectProductOneCond->price ?>" class="form-control enhanced-input" placeholder="Enter Product Price" required>
                                                                           <span class="form-bar"></span>
                                                                           <label class="float-label">Product Price</label>
                                                                           <div class="form-icon">
                                                                                <i class="fas fa-tag"></i>
                                                                           </div>
                                                                      </div>
                                                                      </div>

                                                                      <div class="col-md-4">
                                                                      <div class="form-group form-default form-static-label enhanced-form-group">
                                                                           <input type="number" step="any" name="market_price" value="<?= $selectProductOneCond?->market_price ?>" class="form-control enhanced-input" placeholder="Enter Wholesale Price" required>
                                                                           <span class="form-bar"></span>
                                                                           <label class="float-label">Wholesale Price</label>
                                                                           <div class="form-icon">
                                                                                <i class="fas fa-shopping-cart"></i>
                                                                           </div>
                                                                      </div>
                                                                      </div>

                                                                      <div class="col-md-4">
                                                                      <div class="form-group form-default form-static-label enhanced-form-group">
                                                                           <input type="number" step="any" name="special_price" value="<?= $selectProductOneCond->special_price ?>" class="form-control enhanced-input" placeholder="Enter Retail Price" required>
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
                                                                                <option value="0" <?= $productStatus === 0 ? 'selected' : '' ?>>Active</option>
                                                                                <option value="1" <?= $productStatus === 1 ? 'selected' : '' ?>>Suspend</option>
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
                                                                           <input type="number" step="any" name="quantity" value="<?= number_format($selectProductOneCond->quantity, 0) ?>" class="form-control enhanced-input" placeholder="Enter Product Quantity" required>
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
                                                                                <option value="0" <?= $selectProductOneCond?->is_pack === 0 ? 'selected' : '' ?>>Single Product</option>
                                                                                <option value="1" <?= $selectProductOneCond?->is_pack === 1 ? 'selected' : '' ?>>Packed Size (with Quantity)</option>
                                                                           </select>
                                                                           <span class="form-bar"></span>
                                                                           <label class="float-label">Product Type</label>
                                                                           <div class="form-icon">
                                                                                <i class="fas fa-box"></i>
                                                                           </div>
                                                                      </div>
                                                                      </div>

                                                                      <!-- Pack Size (Conditional) -->
                                                                      <div class="col-md-4" id="pack_size" style="<?= $selectProductOneCond?->is_pack === 1 ? '' : 'display: none;' ?>">
                                                                      <div class="form-group form-default form-static-label enhanced-form-group">
                                                                           <input type="number" step="any" name="pack_size" id="pack_size_input" value="<?= number_format($selectProductOneCond?->pack_size, 0) ?? 0 ?>" class="form-control enhanced-input" placeholder="e.g., 24 (Bottles in a Crate)" <?= $selectProductOneCond?->is_pack === 1 ? 'required' : '' ?>>
                                                                           <span class="form-bar"></span>
                                                                           <label class="float-label">Pack Size Quantity</label>
                                                                           <div class="form-icon">
                                                                                <i class="fas fa-layer-group"></i>
                                                                           </div>
                                                                      </div>
                                                                      </div>

                                                                      <!-- Distributor Selection -->
                                                                      <div class="col-md-4">
                                                                      <div class="form-group form-default form-static-label enhanced-form-group">
                                                                           <select name="distributor" class="form-control enhanced-select" required>
                                                                                <?php
                                                                                $distributor_name = $getFromU->select_one_val('distributors', 'name', 'id', $selectProductOneCond->distributor);
                                                                                foreach($selectDistributors as $selectDistributor):
                                                                                ?>
                                                                                <option value="<?= $selectDistributor->id ?>" <?= $selectDistributor->id === $selectProductOneCond->distributor ? 'selected' : '' ?>><?= $selectDistributor->name ?></option>
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
                                                                                     <?php     
                                                                                     $category_id = $selectProductOneCond->category;
                                                                                     foreach($selectCategories as $selectCategory) {
                                                                                     ?>
                                                                                     <option value="<?= $selectCategory->id ?>" <?= $selectCategory->id === $category_id ? 'selected' : '' ?>><?= $selectCategory->name ?></option>
                                                                                     <?php } ?>
                                                                                </select>
                                                                                <span class="form-bar"></span>
                                                                                <label class="float-label">Product Category</label>
                                                                                <div class="form-icon">
                                                                                     <i class="fas fa-folder"></i>
                                                                                </div>
                                                                           </div>
                                                                      </div>

                                                                      <!-- Enhanced File Upload with Current Image -->
                                                                      <div class="col-md-6">
                                                                      <div class="form-group enhanced-form-group">
                                                                           <label class="form-label">Product Picture</label>
                                                                           <div class="file-upload-wrapper">
                                                                                <input type="file" name="product_pics" class="file-upload-input" id="product_pics" accept="image/*">
                                                                                <input type="hidden" value="<?= $selectProductOneCond->product_pics ?>" name="alternate_pics">
                                                                                <div class="file-upload-area">
                                                                                     <div class="file-upload-preview" id="file-preview">
                                                                                          <img id="preview-image" src="<?= $selectProductOneCond->product_pics ?>" alt="Current Product Image" onerror="this.style.display='none'">
                                                                                          <span class="file-name" id="file-name">Current Image</span>
                                                                                     </div>
                                                                                     <div class="file-upload-text">
                                                                                          <h4>Drag & Drop or Click to Upload New Image</h4>
                                                                                          <p>Supports JPG, PNG, GIF - Max 5MB</p>
                                                                                     </div>
                                                                                </div>
                                                                                <button type="button" class="file-browse-btn">
                                                                                     <i class="fas fa-folder-open me-2"></i>Browse Files
                                                                                </button>
                                                                           </div>
                                                                      </div>
                                                                      </div>

                                                                      <!-- Description -->
                                                                      <div class="col-6 mt-3">
                                                                           <label for="">Product Description</label>
                                                                      <div class="form-group form-default form-static-label enhanced-form-group">
                                                                           <textarea name="description" class="form-control enhanced-textarea" cols="30" rows="6" placeholder="Enter product description..."><?= $selectProductOneCond->description ?></textarea>
                                                                           <span class="form-bar"></span>
                                                                           <div class="form-icon textarea-icon">
                                                                                <i class="fas fa-align-left"></i>
                                                                           </div>
                                                                      </div>
                                                                      </div>
                                                                 </div>

                                                            <?php endforeach; ?>

                                                            <!-- Submit Button -->
                                                            <div class="form-submit-section">
                                                                 <button type="submit" name="product" class="btn btn-primary btn-create-product">
                                                                      <i class="fas fa-save me-2"></i>Update Product
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
     } else echo '<script>window.location.replace("'.BASE_URL.'validation/logout");</script>';
?>
