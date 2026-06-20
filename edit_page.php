<?php 
    include 'elements/header.php';
    $userEmail = $_GET['codes'];
    $userInfo = $getFromU->select_all_val_row('user', 'email', $userEmail);
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
                                        <h5 class="m-b-10">Page Access</h5>
                                        <p class="m-b-0">Welcome to <?= $selectCompanyName ?></p>
                                   </div>
                                   </div>
                                   <div class="col-md-4">
                                   <ul class="breadcrumb">
                                        <li class="breadcrumb-item">
                                             <a href="dashboard"> <i class="fa fa-home"></i> </a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#!">Page Access for <?= $userInfo?->fullname ?></a></li>
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
                                                  <h5>Edit Page Access for <?= $userInfo?->fullname ?></h5>
                                             </div>
                                             <div class="card-block">
                                                <?php 
                                                    $getFromU->renderNestedPageEditForm($userInfo?->id);
                                                ?>
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Handle main menu check/uncheck
        document.querySelectorAll('.main-menu').forEach(mainCheckbox => {
            mainCheckbox.addEventListener('change', function () {
                const mainId = this.getAttribute('data-id');
                const subMenus = document.querySelectorAll('.sub-menu-' + mainId);

                subMenus.forEach(subMenu => {
                    subMenu.checked = this.checked;
                });
            });
        });

        // Handle sub-menu check/uncheck
        document.querySelectorAll('.sub-menu').forEach(subCheckbox => {
            subCheckbox.addEventListener('change', function () {
                const mainId = this.classList[1].split('-')[2];
                const mainCheckbox = document.querySelector('.main-menu[data-id="' + mainId + '"]');
                const subMenus = document.querySelectorAll('.sub-menu-' + mainId);

                // If any sub-menu is unchecked, uncheck the main menu
                if ([...subMenus].some(sub => !sub.checked)) {
                    mainCheckbox.checked = false;
                } else {
                    // If all sub-menus are checked, check the main menu
                    mainCheckbox.checked = true;
                }
            });
        });
    });
</script>
