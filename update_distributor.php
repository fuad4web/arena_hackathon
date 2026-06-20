<?php
include 'elements/header.php';


if (isset($_GET['nos'])) {

     $code = $_GET['nos'];
     $selectDistributorsOneCond = $getFromU->select_all_one_cond('distributors', 'id', $code);
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
                                             <h5 class="m-b-10">Update Distributor</h5>
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
                                                  <h5>Compan(ies) Settings Update</h5>
                                             </div>
                                             <div class="card-block">
                                                  <form class="form-material" method="POST" action="validation/validate_update_distributor.php">
                                                       <?php
                                                       foreach ($selectDistributorsOneCond as $selectDistributorOneCond):
                                                       ?>
                                                            <input type="hidden" value="<?= $selectDistributorOneCond->id ?>" name="ids">
                                                            <div class="form-group form-default form-static-label">
                                                                 <input type="text" name="name" class="form-control" value="<?= $selectDistributorOneCond->name ?>" placeholder="Enter Distributor Company Name" required>
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Distributor Company Name</label>
                                                                 <br>
                                                            </div>
                                                            <div class="form-group form-default form-static-label">
                                                                 <input type="number" step="any" min="11" name="phone_no" class="form-control" value="<?= $selectDistributorOneCond->phone_no ?>" placeholder="Enter Company Phone Number" required>
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Company Phone Number</label>
                                                                 <br>
                                                            </div>
                                                            <div class="form-group form-default form-static-label">
                                                                 <input type="email" name="email" class="form-control" value="<?= $selectDistributorOneCond->email ?>" placeholder="Enter Distributor Company mail" required>
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Email</label>
                                                                 <br>
                                                            </div>
                                                            <div class="form-group form-default form-static-label">
                                                                 <textarea name="address" id="" class="form-control" cols="30" rows="10" required>
                                                                 <?= $selectDistributorOneCond->address ?>
                                                            </textarea>
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Company Address</label>
                                                            </div>
                                                       <?php endforeach; ?>
                                                       <center>
                                                            <input type="submit" name="distributor" class="btn btn-outline-primary" value="Update Distributor Company">
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