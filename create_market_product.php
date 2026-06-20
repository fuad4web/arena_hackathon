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
                                        <h5 class="m-b-10">Create Market Product</h5>
                                        <p class="m-b-0">Welcome to <?= $selectCompanyName ?></p>
                                   </div>
                              </div>
                              <div class="col-md-4">
                                   <ul class="breadcrumb">
                                        <li class="breadcrumb-item">
                                             <a href="dashboard"> <i class="fa fa-home"></i> </a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#!">Market Product</a>
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
                                   $uniq = 'ab0cd1ef2gh3ij4kl5mn6op7qr8st9uvwxyz';
                                   $unique_id = rand(1, 5);
                                   $code = substr(str_shuffle($uniq), 0, 5);

                                   echo SuccessMessage();
                                   echo ErrorMessage();
                                   ?>
                                   <div class="card">
                                        <div class="card-header">
                                             <h5>Create Market Product</h5>
                                        </div>
                                        <div class="card-block">
                                             <form class="form-material" method="POST" action="validation/validate_market_product" enctype="multipart/form-data">
                                                  <input type="hidden" name="code" value="<?= $code ?>">

                                                  <div class="row">
                                                       <div class="col-md-6">
                                                            <div class="form-group form-default form-static-label">
                                                                 <input type="text" name="name" class="form-control" placeholder="Enter Product Name">
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Product Name</label>
                                                                 <br>
                                                            </div>
                                                       </div>
                                                       <div class="col-md-6">
                                                            <div class="form-group form-default form-static-label">
                                                                 <input type="text" name="barcode" class="form-control" placeholder="Enter Product Barcode">
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Product Barcode</label>
                                                                 <br>
                                                            </div>
                                                       </div>
                                                  </div>

                                                  <div class="row">
                                                       <div class="col-md-6">
                                                            <div class="form-group form-default form-static-label">
                                                                 <input type="number" step="any" name="price" class="form-control" placeholder="Enter Product Price">
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Product Price</label>
                                                                 <br>
                                                            </div>
                                                       </div>
                                                       <div class="col-md-6">
                                                            <div class="form-group form-default form-static-label">
                                                                 <input type="number" step="any" name="quantity" class="form-control" placeholder="Enter Product Quantity" required>
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Product Quantity</label>
                                                                 <br>
                                                            </div>
                                                       </div>
                                                  </div>

                                                  <div class="row">
                                                       <div class="col-md-6">
                                                            <div class="form-group form-default form-static-label">
                                                                 <select name="distributor" class="form-control" id="" required>
                                                                      <option value=""></option>
                                                                      <?php
                                                                      foreach ($selectDistributors as $selectDistributor) {
                                                                      ?>
                                                                           <option value="<?= $selectDistributor->id ?>"><?= $selectDistributor->name ?></option>
                                                                      <?php
                                                                      }
                                                                      ?>
                                                                 </select>
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Product Distributor</label>
                                                                 <br>
                                                            </div>
                                                       </div>
                                                       <div class="col-md-6">
                                                            <div class="form-group form-default form-static-label">
                                                                 <input type="file" name="product_pics" class="form-control">
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Product Picture</label>
                                                                 <br>
                                                            </div>
                                                       </div>
                                                  </div>

                                                  <div class="row">
                                                       <div class="col-md-6">
                                                            <div class="form-group form-default form-static-label">
                                                                 <select name="category" class="form-control" id="" required>
                                                                      <option value=""></option>
                                                                      <?php
                                                                      foreach ($selectCategories as $selectCategory) {
                                                                      ?>
                                                                           <option value="<?= $selectCategory->id ?>"><?= $selectCategory->name ?></option>
                                                                      <?php
                                                                      }
                                                                      ?>
                                                                 </select>
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Product Category</label>
                                                                 <br>
                                                            </div>
                                                       </div>
                                                       <div class="col-md-6">
                                                            <div class="form-group form-default form-static-label">
                                                                 <textarea name="description" id="" class="form-control" cols="30" rows="10"></textarea>
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Product Description</label>
                                                            </div>
                                                       </div>

                                                  </div>

                                                  <center>
                                                       <input type="submit" name="market_product" class="btn btn-outline-primary" value="Create Product">
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
?>