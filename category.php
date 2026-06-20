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
                                        <h5 class="m-b-10">Product Category</h5>
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
                                                <h5>Categories</h5>
                                                <span>List of all Products Categories</span>
                                                <div class="card-header-right">
                                                       <a href="create_category">
                                                       <input type="button" name="branch" class="btn btn-success" value="Create Category">
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
                                            <div class="card-block table-border-style">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover text-dark" id="my_table">
                                                        <thead>
                                                            <tr>
                                                                 <th>S/N</th>
                                                                <th>Category Name</th>
                                                                <th>Category Code</th>
                                                                <?php if ($getFromU->hasAccess($user_id, 'update_category') || $getFromU->hasAccess($user_id, 'delete_category')): ?>
                                                                      <th>Action</th>
                                                                <?php endif; ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                 $i = 0;
                                                                 foreach($selectCategories as $selectCategory) {
                                                                      $i++;
                                                            ?>
                                                                 <tr>
                                                                      <th scope="row"><?= $i ?></th>
                                                                      <td><?= ucwords($selectCategory->name) ?></td>
                                                                      <td><?= strtoupper($selectCategory->code) ?></td>
                                                                      <td>
                                                                           <ul class="d-flex justify-content-evenly">
                                                                                <?php if ($getFromU->hasAccess($user_id, 'update_category')): ?>
                                                                                     <a href="./update_category?codes=<?= $selectCategory->code ?>" title="Edit"><li><i class="fa fa fa-wrench open-card-option"></i></li></a>
                                                                                <?php endif; ?>
                                                                           </ul>
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
