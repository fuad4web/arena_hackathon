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
                                        <h5 class="m-b-10">Sign New Member Up</h5>
                                        <p class="m-b-0">Welcome to <?= $selectCompanyName ?></p>
                                   </div>
                              </div>
                              <div class="col-md-4">
                                   <ul class="breadcrumb">
                                        <li class="breadcrumb-item">
                                             <a href="dashboard"> <i class="fa fa-home"></i> </a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#!">Registration Page</a></li>
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
                                             <h5>Register Member</h5>
                                        </div>
                                        <div class="card-block">
                                             <form class="form-material row g-4" method="POST" action="validation/register_valid" enctype="multipart/form-data">

                                                  <div class="row">
                                                       <div class="col-md-6">
                                                            <div class="form-group form-default form-static-label">
                                                                 <input type="text" name="fullname" placeholder="Fullname" class="form-control" required>
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Fullname</label>
                                                                 <br>
                                                            </div>
                                                       </div>
                                                       <div class="col-md-6">
                                                            <div class="form-group form-default form-static-label">
                                                                 <input type="text" name="email" placeholder="Email" class="form-control" required>
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Email</label>
                                                                 <br>
                                                            </div>
                                                       </div>

                                                       <div class="col-md-4">
                                                            <div class="form-group form-default form-static-label">
                                                                 <select name="branch" id="" class="form-control" required>
                                                                      <option value="">Select Branch</option>
                                                                      <?php foreach ($selectBranches as $branch): ?>
                                                                           <option value="<?= $branch->id ?>"><?= ucwords($branch->branch_name) ?></option>
                                                                      <?php endforeach; ?>
                                                                 </select>
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Select Branch</label>
                                                                 <br>
                                                            </div>
                                                       </div>

                                                       <div class="col-md-4">
                                                            <div class="form-group form-default form-static-label">
                                                                 <input type="password" name="password" placeholder="Password" class="form-control" required>
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Password</label>
                                                                 <br>
                                                            </div>
                                                       </div>

                                                       <div class="col-md-4">
                                                            <div class="form-group form-default form-static-label">
                                                                 <input type="password" name="confirm_password" placeholder="Confirm Password" class="form-control" required>
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Confirm Password</label>
                                                                 <br>
                                                            </div>
                                                       </div>

                                                       <div class="col-md-4">
                                                            <div class="form-group form-default form-static-label">
                                                                 <select name="status" id="" class="form-control" required>
                                                                      <option value="staff">Staff</option>
                                                                      <option value="admin">Admin</option>
                                                                 </select>
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Status</label>
                                                                 <br>
                                                            </div>
                                                       </div>

                                                       <div class="col-md-4">
                                                            <div class="form-group form-default form-static-label">
                                                                 <input type="file" name="profile_pics" class="form-control">
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Upload Profile Pics</label>
                                                                 <br>
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <br>

                                                  <center>
                                                       <input type="submit" name="register" class="btn btn-outline-primary" value="Signup Now!">
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