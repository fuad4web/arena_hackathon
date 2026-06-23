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
                                        <h5 class="m-b-10">Create Distributor</h5>
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
                                             <h5>Company Settings</h5>
                                             <div class="card-header-right">
                                                  <a href="distributor">
                                                       <input type="button" name="branch" class="btn btn-success" value="Distributor Page">
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
                                             <form class="form-material" method="POST" action="validation/validate_create_distributor.php">

                                                  <div class="row">
                                                       <div class="col-md-6">
                                                            <div class="form-group form-default form-static-label">
                                                                 <input type="text" name="name" class="form-control" placeholder="Enter Distributor Company Name" required>
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Distributor Company Name</label>
                                                                 <br>
                                                            </div>
                                                       </div>
                                                       <div class="col-md-6">
                                                            <div class="form-group form-default form-static-label">
                                                                 <input type="number" step="any" min="11" name="phone_no" class="form-control" placeholder="Enter Company Phone Number" required>
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Company Phone Number</label>
                                                                 <br>
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="row">
                                                       <div class="col-md-6">
                                                            <div class="form-group form-default form-static-label">
                                                                 <input type="email" name="email" class="form-control" placeholder="Enter Distributor Company mail" required>
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Email</label>
                                                                 <br>
                                                            </div>
                                                       </div>
                                                       <div class="col-md-6">
                                                            <div class="form-group form-default form-static-label">
                                                                 <textarea name="address" id="" class="form-control" cols="30" rows="10"></textarea>
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Company Location</label>
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <center>
                                                       <input type="submit" name="distributor" class="btn btn-outline-primary" value="SUBMIT">
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