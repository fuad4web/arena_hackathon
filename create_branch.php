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
                                        <h5 class="m-b-10">Create Branch</h5>
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
                                   <div class="card">
                                        <div class="card-header">
                                             <h5>Create Branch</h5>
                                             <div class="card-header-right">
                                                  <a href="branch">
                                                       <input type="button" name="branch" class="btn btn-success" value="Branch Page">
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
                                             <form class="form-material" method="POST" action="validation/validate_create_branch">

                                                  <div class="form-group form-default form-static-label">
                                                       <input type="text" name="name" class="form-control" placeholder="Enter Branch Name">
                                                       <span class="form-bar"></span>
                                                       <label class="float-label">Branch Name</label>
                                                       <br>
                                                  </div>

                                                  <center>
                                                       <input type="submit" name="branch" class="btn btn-outline-success" value="Create Branch">
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