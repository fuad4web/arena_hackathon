<?php
     include 'core/init.php';
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
                                        <h5 class="m-b-10">Dashboard</h5>
                                        <p class="m-b-0">Welcome to Material Able</p>
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
                                             <h5>Material Form Inputs With Static Label</h5>
                                             <!--<span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>-->
                                        </div>
                                        <div class="card-block">
                                             <form class="form-material">
                                             <div class="form-group form-default form-static-label">
                                                  <input type="text" name="footer-email" class="form-control" placeholder="Enter User Name">
                                                  <span class="form-bar"></span>
                                                  <label class="float-label">Username</label>
                                             </div>
                                             <div class="form-group form-default form-static-label">
                                                  <input type="text" name="footer-email" class="form-control" placeholder="Enter Email">
                                                  <span class="form-bar"></span>
                                                  <label class="float-label">Email (exa@gmail.com)</label>
                                             </div>
                                             <div class="form-group form-default form-static-label">
                                                  <input type="password" name="footer-email" class="form-control" placeholder="Enter Password">
                                                  <span class="form-bar"></span>
                                                  <label class="float-label">Password</label>
                                             </div>
                                             <div class="form-group form-default form-static-label">
                                                  <input type="text" name="footer-email" class="form-control" placeholder="Pre define value" value="My value">
                                                  <span class="form-bar"></span>
                                                  <label class="float-label">Predefine value</label>
                                             </div>
                                             <div class="form-group form-default form-static-label">
                                                  <input type="text" name="footer-email" class="form-control" placeholder="disabled Input" disabled>
                                                  <span class="form-bar"></span>
                                                  <label class="float-label">Disabled</label>
                                             </div>
                                             <div class="form-group form-default form-static-label">
                                                  <input type="text" name="footer-email" class="form-control" maxlength="6" placeholder="Enter only 6 char">
                                                  <span class="form-bar"></span>
                                                  <label class="float-label">Max length 6 char</label>
                                             </div>
                                             <div class="form-group form-default form-static-label">
                                                  <textarea class="form-control">Enter Text hear</textarea>
                                                  <span class="form-bar"></span>
                                                  <label class="float-label">Text area Input</label>
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
