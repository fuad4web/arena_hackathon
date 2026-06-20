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
                                        <h5 class="m-b-10">Admins</h5>
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
                                             <h3>Admins</h3>
                                             <span>List of all Admins</span>
                                             <div class="card-header-right">
                                                  <ul class="list-unstyled card-option">
                                                       <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                                       <li><i class="fa fa-window-maximize full-card"></i></li>
                                                       <li><i class="fa fa-minus minimize-card"></i></li>
                                                       <li><i class="fa fa-refresh reload-card"></i></li>
                                                       <li><i class="fa fa-trash close-card"></i></li>
                                                  </ul>
                                             </div>
                                        </div>
                                        <div class="card-block table-border-style">
                                             <div class="table-responsive">
                                                  <table class="table table-striped table-hover text-dark" id="my_table">
                                                       <thead class="">
                                                            <tr>
                                                                 <th>S/N</th>
                                                                 <th>Profile Picture</th>
                                                                 <th>Fullname</th>
                                                                 <th>Email</th>
                                                                 <th>Delete</th>
                                                            </tr>
                                                       </thead>
                                                       <tbody>
                                                            <?php
                                                            $i = 0;
                                                            foreach ($selectAdmins as $selectAdmin) {
                                                                 $i++;
                                                            ?>
                                                                 <tr>
                                                                      <th scope="row"><?= $i ?></th>
                                                                      <td>
                                                                           <img src="profileImage/<?= $selectAdmin->profile_pics ?>" style="border-radius: 50%;" class="border-rounded" width="40" height="40" alt="<?= $selectAdmin->fullname ?>">
                                                                      </td>
                                                                      <td><?= $selectAdmin->fullname ?></td>
                                                                      <td><?= $selectAdmin->email ?></td>
                                                                      <td>
                                                                           <a href="./delete_member.php?codes=<?= $selectAdmin->id ?>">
                                                                                <input type="button" value="Delete" class="btn btn-danger">
                                                                           </a>
                                                                      </td>
                                                                 </tr>
                                                            <?php
                                                            }
                                                            ?>

                                                       </tbody>
                                                  </table>
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