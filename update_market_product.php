<?php
     include 'elements/header.php';
     // if(@$user->status !== 'admin') {
     //      echo '<script>window.location.replace("'.BASE_URL.'validation/logout");</script>';
     // }
     if(isset($_GET['codes'])) {
          $code = $_GET['codes'];
          $selectMarketProductsOneCond = $getFromU->select_all_one_cond('market_products', 'id', $code);
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
                                        <h5 class="m-b-10">Update Market Product</h5>
                                        <p class="m-b-0">Welcome to <?= $selectCompanyName ?></p>
                                   </div>
                                   </div>
                                   <div class="col-md-4">
                                   <ul class="breadcrumb">
                                        <li class="breadcrumb-item">
                                             <a href="dashboard"> <i class="fa fa-home"></i> </a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#!">Market Product Update</a>
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
                                                  <h5>Update Market Product</h5>
                                             </div>
                                             <div class="card-block">
                                                  <form class="form-material" method="POST" action="validation/validate_update_market_product" enctype="multipart/form-data">

                                                  <?php
                                                       foreach($selectMarketProductsOneCond as $selectMarketProductOneCond):
                                                  ?>
                                                       <div class="row">
                                                            <input type="hidden" name="id" value="<?= $selectMarketProductOneCond->id ?>">
                                                            <div class="col-md-6">
                                                                 <div class="form-group form-default form-static-label">
                                                                      <input type="text" name="name" value="<?= $selectMarketProductOneCond->name ?>" class="form-control" placeholder="Enter Product Name">
                                                                      <span class="form-bar"></span>
                                                                      <label class="float-label">Market Product Name</label>
                                                                      <br>
                                                                 </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                 <div class="form-group form-default form-static-label">
                                                                      <input type="text" name="barcode" class="form-control" value="<?= $selectMarketProductOneCond->barcode ?>" placeholder="Enter Product Barcode" >
                                                                      <span class="form-bar"></span>
                                                                      <label class="float-label">Market Product Barcode</label>
                                                                      <br>
                                                                 </div>
                                                            </div>
                                                       </div>

                                                       <div class="row">
                                                            <div class="col-md-6">
                                                                 <div class="form-group form-default form-static-label">
                                                                      <input type="number" step="any" name="price" value="<?= $selectMarketProductOneCond->price ?>" class="form-control" placeholder="Enter Product Price">
                                                                      <span class="form-bar"></span>
                                                                      <label class="float-label">Market Product Price</label>
                                                                      <br>
                                                                 </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                 <div class="form-group form-default form-static-label">
                                                                      <input type="number" step="any" name="quantity" value="<?= $selectMarketProductOneCond->quantity ?>" class="form-control" placeholder="Enter Product Quantity" required>
                                                                      <span class="form-bar"></span>
                                                                      <label class="float-label">Market Product Quantity</label>
                                                                      <br>
                                                                 </div>
                                                            </div>
                                                       </div>

                                                       <div class="row my-4">
                                                            <div class="col-md-4">
                                                                 <div class="form-group form-default form-static-label">
                                                                      <select name="distributor" class="form-control" id="" required>
                                                                           <?php
                                                                                $distributor_id = $selectMarketProductOneCond->distributor;
                                                                                $distributor_name = $getFromU->select_one_val('distributors', 'name', 'id', $distributor_id);
                                                                           ?>
                                                                           <option value="<?= $distributor_id ?>"></option>
                                                                           <?php
                                                                                foreach($selectDistributors as $selectDistributor) {
                                                                           ?>
                                                                           <option value="<?= $selectDistributor->id ?>"><?= $selectDistributor->name ?></option>
                                                                           <?php
                                                                                }
                                                                           ?>
                                                                      </select>
                                                                      <span class="form-bar"></span>
                                                                      <label class="float-label">Market Product Distributor</label>
                                                                      <br>
                                                                 </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                 <div class="form-group form-default form-static-label">
                                                                      <input type="file" value="<?= $selectMarketProductOneCond->product_pics ?>" name="product_pics" class="form-control">
                                                                      <input type="hidden" value="<?= $selectMarketProductOneCond->product_pics ?>" name="alternate_pics">
                                                                      <span class="form-bar"></span>
                                                                      <label class="float-label">Market Product Picture</label>
                                                                      <br>
                                                                 </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                 <div class="form-group form-default form-static-label">
                                                                      <img src="<?= $selectMarketProductOneCond->product_pics ?>" width="100" alt="">
                                                                 </div>
                                                            </div>
                                                       </div>

                                                       <div class="row">
                                                            <div class="col-md-6">
                                                                 <div class="form-group form-default form-static-label">
                                                                      <select name="category" class="form-control" id="" required>
                                                                           <?php     
                                                                                $category_id = $selectMarketProductOneCond->category;
                                                                           ?>
                                                                           <option value="<?= $category_id ?>"></option>
                                                                           <?php
                                                                                foreach($selectCategories as $selectCategory) {
                                                                           ?>
                                                                           <option value="<?= $selectCategory->id ?>"><?= $selectCategory->name ?></option>
                                                                           <?php
                                                                                }
                                                                           ?>
                                                                      </select>
                                                                      <span class="form-bar"></span>
                                                                      <label class="float-label">Market Product Category</label>
                                                                      <br>
                                                                 </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                 <div class="form-group form-default form-static-label">
                                                                      <textarea name="description" id="" class="form-control" cols="30" rows="10">
                                                                           <?= $selectMarketProductOneCond->description ?>
                                                                      </textarea>
                                                                      <span class="form-bar"></span>
                                                                      <label class="float-label">Market Product Description</label>
                                                                 </div>
                                                            </div>
                                                       
                                                       </div>
                                                  <?php
                                                       endforeach;
                                                  ?>

                                                       <center>
                                                            <input type="submit" name="market_product" class="btn btn-outline-primary" value="Update Product">
                                                       </center>
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

<?php
     include 'elements/footer.php';
     } else {
          echo '<script>window.location.replace("'.BASE_URL.'validation/logout");</script>';
     }
?>
