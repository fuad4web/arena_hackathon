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
                                        <h5 class="m-b-10">Profile</h5>
                                        <p class="m-b-0">Welcome to <?= $selectCompanyName ?></p>
                                   </div>
                                   </div>
                                   <div class="col-md-4">
                                   <ul class="breadcrumb">
                                        <li class="breadcrumb-item">
                                             <a href="dashboard"> <i class="fa fa-home"></i> </a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#!">Profile</a>
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
                                                  <h5 class="mb-0">Edit Profile</h5>
                                                  <small class="text-muted">Update your personal information</small>
                                             </div>

                                             <div class="card-block">
                                                  <form method="POST" enctype="multipart/form-data" action="validation/profile_validate.php">

                                                       <input type="hidden" name="alternate_pics" value="<?= $user->profile_pics ?>">
                                                       <input type="hidden" name="ida" value="<?= $_SESSION['id'] ?>">

                                                       <div class="row">
                                                            <!-- Fullname -->
                                                            <div class="col-md-6">
                                                                 <div class="form-group">
                                                                 <label>Fullname</label>
                                                                 <input type="text" name="name" value="<?= $user->fullname ?>" class="form-control">
                                                                 </div>
                                                            </div>

                                                            <!-- Email -->
                                                            <div class="col-md-6">
                                                                 <div class="form-group">
                                                                 <label>Email</label>
                                                                 <input type="email" name="email" value="<?= $user->email ?>" class="form-control">
                                                                 </div>
                                                            </div>
                                                       </div>

                                                       <!-- Password Section -->
                                                       <hr>
                                                       <h6 class="text-muted">Change Password (optional)</h6>

                                                       <div class="row">
                                                            <div class="col-md-6">
                                                                 <div class="form-group">
                                                                 <label>New Password</label>
                                                                 <input type="password" name="password" class="form-control">
                                                                 </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                 <div class="form-group">
                                                                 <label>Confirm Password</label>
                                                                 <input type="password" name="confirm_password" class="form-control">
                                                                 </div>
                                                            </div>
                                                       </div>

                                                       <!-- Profile Image -->
                                                       <div class="row mt-3">
                                                            <div class="col-md-6">
                                                                 <div class="form-group">
                                                                 <label>Profile Picture</label>
                                                                 <input type="file" name="profile_pics" class="form-control">
                                                                 </div>
                                                            </div>

                                                            <div class="col-md-6 text-center">
                                                                 <img src="<?= $user->profile_pics ?>" width="150" class="img-thumbnail" alt="Profile Picture">
                                                            </div>
                                                       </div>

                                                       <div class="text-center mt-4">
                                                            <button type="submit" name="profile" class="btn btn-primary">
                                                                 Update Profile
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

<?php
     include 'elements/footer.php';
?>
