<?php
     include 'elements/header.php';
?>

<style>
     #my_table {
     border-radius: 12px;
     overflow: hidden;
     background: #fff;
     }

     #my_table tbody tr {
     transition: all .2s ease;
     }

     #my_table tbody tr:hover {
     transform: translateY(-2px);
     box-shadow: 0 3px 10px rgba(0,0,0,.08);
     }

     #my_table .btn-group .btn {
     margin: 0 2px;
     border-radius: 8px;
     }

     #my_table img {
     border: 2px solid #f1f1f1;
     }
</style>

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
                                        <h5 class="m-b-10">Staffs</h5>
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
                                             <h3>Staffs</h3>
                                             <span>List of all Staffs</span>
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
                                                  <table class="table table-hover align-middle" id="my_table">
                                                       <thead class="table-dark">
                                                            <tr>
                                                                 <th>#</th>
                                                                 <th>Staff</th>
                                                                 <th>Email</th>
                                                                 <th>Branch</th>

                                                                 <?php if ($getFromU->hasAccess($user_id, 'delete_member') || $getFromU->hasAccess($user_id, 'access') || $getFromU->hasAccess($user_id, 'edit_page')): ?>
                                                                      <th class="text-center">Actions</th>
                                                                 <?php endif; ?>
                                                            </tr>
                                                       </thead>

                                                       <tbody>
                                                            <?php
                                                            $i = 0;
                                                            foreach ($selectBranchStaffs as $selectStaff):
                                                                 $i++;
                                                            ?>
                                                                 <tr>

                                                                      <td>
                                                                      <span class="fw-bold"><?= $i ?></span>
                                                                      </td>

                                                                      <td>
                                                                      <div class="d-flex align-items-center">
                                                                           <img src="<?= $selectStaff?->profile_pics ?>"
                                                                                width="50"
                                                                                height="50"
                                                                                class="rounded-circle border shadow-sm me-3"
                                                                                style="object-fit: cover;"
                                                                                alt="<?= $selectStaff?->fullname ?>">

                                                                           <div>
                                                                                <div class="fw-semibold">
                                                                                     <?= ucwords($selectStaff?->fullname) ?>
                                                                                </div>

                                                                                <small class="text-muted">
                                                                                     <?= $selectStaff?->access
                                                                                          ? '<span class="badge bg-success">Active</span>'
                                                                                          : '<span class="badge bg-danger">Inactive</span>' ?>
                                                                                </small>
                                                                           </div>
                                                                      </div>
                                                                      </td>

                                                                      <td>
                                                                      <?= $selectStaff?->email ?>
                                                                      </td>

                                                                      <td>
                                                                      <span class="badge bg-primary">
                                                                           <?= ucwords($selectStaff?->branch_name) ?>
                                                                      </span>
                                                                      </td>

                                                                      <?php if ($getFromU->hasAccess($user_id, 'delete_member') || $getFromU->hasAccess($user_id, 'access') || $getFromU->hasAccess($user_id, 'edit_page')): ?>

                                                                      <td class="text-center">

                                                                           <div class="btn-group">

                                                                                <?php if ($getFromU->hasAccess($user_id, 'access')): ?>
                                                                                     <a href="./validation/access.php?user=<?= $selectStaff?->email ?>"
                                                                                     class="btn btn-sm <?= $selectStaff?->access ? 'btn-warning' : 'btn-success' ?>"
                                                                                     title="<?= $selectStaff?->access ? 'Deactivate' : 'Activate' ?>">

                                                                                          <i class="fa <?= $selectStaff?->access ? 'fa-ban' : 'fa-check' ?>"></i>
                                                                                     </a>
                                                                                <?php endif; ?>

                                                                                <?php if ($getFromU->hasAccess($user_id, 'edit_page')): ?>
                                                                                     <a href="./edit_page?codes=<?= $selectStaff?->email ?>"
                                                                                     class="btn btn-sm btn-info text-white"
                                                                                     title="Edit Access">

                                                                                          <i class="fa fa-wrench"></i>
                                                                                     </a>
                                                                                <?php endif; ?>

                                                                                <?php if ($getFromU->hasAccess($user_id, 'delete_member')): ?>
                                                                                     <a href="./delete_member.php?codes=<?= $selectStaff?->email ?>"
                                                                                     class="btn btn-sm btn-danger"
                                                                                     title="Delete">

                                                                                          <i class="fa fa-trash"></i>
                                                                                     </a>
                                                                                <?php endif; ?>

                                                                           </div>

                                                                      </td>

                                                                      <?php endif; ?>

                                                                 </tr>

                                                            <?php endforeach; ?>
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
