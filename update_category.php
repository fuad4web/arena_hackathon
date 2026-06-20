<?php
include 'elements/header.php';


if (isset($_GET['codes'])) {

     $code = $_GET['codes'];
     $selectCategoriesOneCond = $getFromU->select_all_one_cond('product_category', 'code', $code);
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
                                             <h5 class="m-b-10">Update Category</h5>
                                             <p class="m-b-0">Welcome to <?= $selectCompanyName ?></p>
                                        </div>
                                   </div>
                                   <div class="col-md-4">
                                        <ul class="breadcrumb">
                                             <li class="breadcrumb-item">
                                                  <a href="dashboard"> <i class="fa fa-home"></i> </a>
                                             </li>
                                             <li class="breadcrumb-item"><a href="#!">Dashboard</a>
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
                                                  <h5>Update Category</h5>
                                             </div>
                                             <div class="card-block">
                                                  <form class="form-material" method="POST" action="validation/validate_update_category.php">

                                                       <?php
                                                       foreach ($selectCategoriesOneCond as $selectCategoryOneCond):
                                                       ?>
                                                            <input type="hidden" name="idds" value="<?= $selectCategoryOneCond->id ?>">
                                                            <div class="form-group form-default form-static-label">
                                                                 <input type="text" name="name" value="<?= $selectCategoryOneCond->name ?>" class="form-control" placeholder="Enter Category Name">
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Category Name</label>
                                                                 <br>
                                                            </div>

                                                            <div class="form-group form-default form-static-label">
                                                                 <input type="text" min="11" name="code" class="form-control" value="<?= $selectCategoryOneCond->code ?>" readonly>
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Category Code</label>
                                                                 <br>
                                                            </div>
                                                       <?php endforeach; ?>

                                                       <center>
                                                            <input type="submit" name="category" class="btn btn-outline-primary" value="Update Category">
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
     echo '<script>window.location.replace("' . BASE_URL . 'validation/logout");</script>';
}
?>