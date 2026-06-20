
<nav class="pcoded-navbar">
     <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
     <div class="pcoded-inner-navbar main-menu">
          <div class="">
               <div class="main-menu-header">
                    <img class="img-80 img-radius" src="<?= $user->profile_pics ?>" alt="User-Profile-Image">
                    <div class="user-details">
                    <span id="more-details"><?= $user->fullname ?><i class="fa fa-caret-down"></i></span>
                    </div>
               </div>
               <div class="main-menu-content">
                    <ul>
                    <li class="more-details">
                         <a href="profile"><i class="ti-user"></i>View Profile</a>
                         <?php
                              if($user->status === 'admin') {
                         ?>
                         <a href="./settings"><i class="ti-settings"></i>Settings</a>
                         <?php
                              }
                         ?>
                         <a href="<?php '.BASE_URL.' ?>validation/logout"><i class="ti-layout-sidebar-left"></i>Logout</a>
                    </li>
                    </ul>
               </div>
          </div>
          <div class="p-15 p-b-0">
               <!-- <form class="form-material">
                    <div class="form-group form-primary">
                    <input type="text" name="footer-email" class="form-control">
                    <span class="form-bar"></span>
                    <label class="float-label"><i class="fa fa-search m-r-10"></i>Search Friend</label>
                    </div>
               </form> -->
          </div>

          <?php
               if($user->status === 'admin') {
          ?>

          <div class="pcoded-navigation-label">Dashboard</div>
          <ul class="pcoded-item pcoded-left-item">
               <li class="active">
                    <a href="dashboard" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                    <span class="pcoded-mtext">Dashboard</span>
                    <span class="pcoded-mcaret"></span>
                    </a>
               </li>
          </ul>

          <?php
               }
          ?>

          <div class="pcoded-navigation-label">Sales Products</div>
          <ul class="pcoded-item pcoded-left-item">
               <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i><b>BC</b></span>
                    <span class="pcoded-mtext">Sales Product<small>(s)</small></span>
                    <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                         <li class="">
                              <a href="orders" class="waves-effect waves-dark">
                                   <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                   <span class="pcoded-mtext">Sales Product(s)</span>
                                   <span class="pcoded-mcaret"></span>
                              </a>
                         </li>
                         <li class="">
                              <a href="ordered_products" class="waves-effect waves-dark">
                                   <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                   <span class="pcoded-mtext">List My Ordered Products</span>
                                   <span class="pcoded-mcaret"></span>
                              </a>
                         </li>
                         <?php if($user->status === 'admin'): ?>

                         <li class="">
                              <a href="allordered_products" class="waves-effect waves-dark">
                                   <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                   <span class="pcoded-mtext">List All Ordered Products</span>
                                   <span class="pcoded-mcaret"></span>
                              </a>
                         </li>
                         
                         <li class="">
                              <a href="record" class="waves-effect waves-dark">
                                   <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                   <span class="pcoded-mtext">Record Page</span>
                                   <span class="pcoded-mcaret"></span>
                              </a>
                         </li>
                         
                         <li class="">
                              <a href="creditors" class="waves-effect waves-dark">
                                   <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                   <span class="pcoded-mtext">Creditors Page</span>
                                   <span class="pcoded-mcaret"></span>
                              </a>
                         </li>

                         <?php endif; ?>
                    </ul>
               </li>
          </ul>

          <div class="pcoded-navigation-label">Products</div>
          <ul class="pcoded-item pcoded-left-item">
               <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i><b>BC</b></span>
                    <span class="pcoded-mtext">Products</span>
                    <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                         <li class="">
                              <a href="product" class="waves-effect waves-dark">
                                   <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                   <span class="pcoded-mtext">List Products</span>
                                   <span class="pcoded-mcaret"></span>
                              </a>
                         </li>
                         <?php
                              if($user->status === 'admin') {
                         ?>
                              <li class="">
                                   <a href="create_product" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                        <span class="pcoded-mtext">Create New Product</span>
                                        <span class="pcoded-mcaret"></span>
                                   </a>
                              </li>
                         <?php
                              }
                         ?>
                    </ul>
               </li>
          </ul>

          <?php
               if($user->status === 'admin') {
          ?>

          <div class="pcoded-navigation-label">Market Products</div>
          <ul class="pcoded-item pcoded-left-item">
               <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i><b>BC</b></span>
                    <span class="pcoded-mtext">Market Products</span>
                    <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                         <li class="">
                              <a href="market_product" class="waves-effect waves-dark">
                                   <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                   <span class="pcoded-mtext">List Market Products</span>
                                   <span class="pcoded-mcaret"></span>
                              </a>
                         </li>
                         <!-- <li class="">
                              <a href="create_market_product" class="waves-effect waves-dark">
                                   <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                   <span class="pcoded-mtext">Create New Market Product</span>
                                   <span class="pcoded-mcaret"></span>
                              </a>
                         </li> -->
                    </ul>
               </li>
          </ul>

          <div class="pcoded-navigation-label">Product Categories</div>
          <ul class="pcoded-item pcoded-left-item">
               <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i><b>BC</b></span>
                    <span class="pcoded-mtext">Product Categories</span>
                    <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                         <li class="">
                              <a href="category" class="waves-effect waves-dark">
                                   <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                   <span class="pcoded-mtext">List Categories</span>
                                   <span class="pcoded-mcaret"></span>
                              </a>
                         </li>
                         <li class="">
                              <a href="create_category" class="waves-effect waves-dark">
                                   <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                   <span class="pcoded-mtext">Create New Category</span>
                                   <span class="pcoded-mcaret"></span>
                              </a>
                         </li>
                    </ul>
               </li>
          </ul>

          <div class="pcoded-navigation-label">Company Branches</div>
          <ul class="pcoded-item pcoded-left-item">
               <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i><b>BC</b></span>
                    <span class="pcoded-mtext">Company Branches</span>
                    <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                         <li class="">
                              <a href="branch" class="waves-effect waves-dark">
                                   <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                   <span class="pcoded-mtext">List Branches</span>
                                   <span class="pcoded-mcaret"></span>
                              </a>
                         </li>
                         <li class="">
                              <a href="create_branch" class="waves-effect waves-dark">
                                   <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                   <span class="pcoded-mtext">Create New Branch</span>
                                   <span class="pcoded-mcaret"></span>
                              </a>
                         </li>
                    </ul>
               </li>
          </ul>
          
          <div class="pcoded-navigation-label">Distributors (Companies)</div>
          <ul class="pcoded-item pcoded-left-item">
               <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i><b>BC</b></span>
                    <span class="pcoded-mtext">Distributor Companies</span>
                    <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                         <li class="">
                              <a href="distributor" class="waves-effect waves-dark">
                                   <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                   <span class="pcoded-mtext">List Distributors</span>
                                   <span class="pcoded-mcaret"></span>
                              </a>
                         </li>
                         <li class="">
                              <a href="create_distributor" class="waves-effect waves-dark">
                                   <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                   <span class="pcoded-mtext">Create New Distributor</span>
                                   <span class="pcoded-mcaret"></span>
                              </a>
                         </li>
                    </ul>
               </li>
          </ul>

          <div class="pcoded-navigation-label">Members</div>
          <ul class="pcoded-item pcoded-left-item">
               <li class="pcoded-hasmenu ">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-id-badge"></i><b>A</b></span>
                    <span class="pcoded-mtext">Staff Members</span>
                    <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                         <li class="">
                              <a href="staffs" class="waves-effect waves-dark">
                                   <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                   <span class="pcoded-mtext">Staff Members</span>
                                   <span class="pcoded-mcaret"></span>
                              </a>
                         </li>
                         <li class="">
                              <a href="admins" class="waves-effect waves-dark">
                                   <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                   <span class="pcoded-mtext">Admins</span>
                                   <span class="pcoded-mcaret"></span>
                              </a>
                         </li>
                         <li class="">
                              <a href="register" class="waves-effect waves-dark">
                                   <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                   <span class="pcoded-mtext">Registration Page</span>
                                   <span class="pcoded-mcaret"></span>
                              </a>
                         </li>
                    </ul>
               </li>
          </ul>

          <div class="pcoded-navigation-label">List of Customers</div>
          <ul class="pcoded-item pcoded-left-item">
               <li class="">
                    <a href="customers" class="waves-effect waves-dark">
                         <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                         <span class="pcoded-mtext">Customers</span>
                         <span class="pcoded-mcaret"></span>
                    </a>
               </li>
          </ul>
          
          <div class="pcoded-navigation-label">Company Settings</div>
          <ul class="pcoded-item pcoded-left-item">
               <li class="">
                    <a href="settings" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-receipt"></i><b>B</b></span>
                    <span class="pcoded-mtext">Settings</span>
                    <span class="pcoded-mcaret"></span>
                    </a>
               </li>
          </ul>

          <div class="pcoded-navigation-label">Transfer Products</div>
          <ul class="pcoded-item pcoded-left-item">
               <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i><b>BC</b></span>
                    <span class="pcoded-mtext">Transfer Product<small>(s)</small></span>
                    <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">

                         <li class="">
                              <a href="transfer_product" class="waves-effect waves-dark">
                                   <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                   <span class="pcoded-mtext">Transfer Product</span>
                                   <span class="pcoded-mcaret"></span>
                              </a>
                         </li>

                    </ul>
               </li>
          </ul>


          <div class="pcoded-navigation-label">Return Products</div>
          <ul class="pcoded-item pcoded-left-item">
               <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i><b>BC</b></span>
                    <span class="pcoded-mtext">Return Product<small>(s)</small></span>
                    <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">

                         <li class="">
                              <a href="return_product" class="waves-effect waves-dark">
                                   <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                   <span class="pcoded-mtext">Return Product</span>
                                   <span class="pcoded-mcaret"></span>
                              </a>
                         </li>

                         <li class="">
                              <a href="products_return" class="waves-effect waves-dark">
                                   <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                   <span class="pcoded-mtext">List Products returned</span>
                                   <span class="pcoded-mcaret"></span>
                              </a>
                         </li>
                         
                    </ul>
               </li>
          </ul>
          
          <?php
               }
          ?>

          <div class="pcoded-navigation-label">Profile</div>
          <ul class="pcoded-item pcoded-left-item">
               <li class="">
                    <a href="profile" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-receipt"></i><b>B</b></span>
                    <span class="pcoded-mtext">Profile</span>
                    <span class="pcoded-mcaret"></span>
                    </a>
               </li>
          </ul>
          
          <!-- <div class="pcoded-navigation-label">UI Element</div>
          <ul class="pcoded-item pcoded-left-item">
               <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i><b>BC</b></span>
                    <span class="pcoded-mtext">Basic</span>
                    <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                    <li class=" ">
                         <a href="breadcrumb.html" class="waves-effect waves-dark">
                              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                              <span class="pcoded-mtext">Breadcrumbs</span>
                              <span class="pcoded-mcaret"></span>
                         </a>
                    </li>
                    <li class=" ">
                         <a href="button.html" class="waves-effect waves-dark">
                              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                              <span class="pcoded-mtext">Button</span>
                              <span class="pcoded-mcaret"></span>
                         </a>
                    </li>
                    <li class="">
                         <a href="accordion.html" class="waves-effect waves-dark">
                              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                              <span class="pcoded-mtext">Accordion</span>
                              <span class="pcoded-mcaret"></span>
                         </a>
                    </li>
                    <li class=" ">
                         <a href="tabs.html" class="waves-effect waves-dark">
                              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                              <span class="pcoded-mtext">Tabs</span>
                              <span class="pcoded-mcaret"></span>
                         </a>
                    </li>
                    <li class=" ">
                         <a href="color.html" class="waves-effect waves-dark">
                              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                              <span class="pcoded-mtext">Color</span>
                              <span class="pcoded-mcaret"></span>
                         </a>
                    </li>
                    <li class=" ">
                         <a href="label-badge.html" class="waves-effect waves-dark">
                              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                              <span class="pcoded-mtext">Label Badge</span>
                              <span class="pcoded-mcaret"></span>
                         </a>
                    </li>
                    <li class=" ">
                         <a href="tooltip.html" class="waves-effect waves-dark">
                              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                              <span class="pcoded-mtext">Tooltip And Popover</span>
                              <span class="pcoded-mcaret"></span>
                         </a>
                    </li>
                    <li class=" ">
                         <a href="typography.html" class="waves-effect waves-dark">
                              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                              <span class="pcoded-mtext">Typography</span>
                              <span class="pcoded-mcaret"></span>
                         </a>
                    </li>
                    <li class=" ">
                         <a href="notification.html" class="waves-effect waves-dark">
                              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                              <span class="pcoded-mtext">Notifications</span>
                              <span class="pcoded-mcaret"></span>
                         </a>
                    </li>
                    </ul>
               </li>
          </ul>
          <div class="pcoded-navigation-label">Forms</div>
          <ul class="pcoded-item pcoded-left-item">
               <li class="">
                    <a href="form-elements-component.html" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                    <span class="pcoded-mtext">Form</span>
                    <span class="pcoded-mcaret"></span>
                    </a>
               </li>
          </ul>
          
          <div class="pcoded-navigation-label">Tables</div>
          <ul class="pcoded-item pcoded-left-item">
               <li class="">
                    <a href="bs-basic-table.html" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-receipt"></i><b>B</b></span>
                    <span class="pcoded-mtext">Table</span>
                    <span class="pcoded-mcaret"></span>
                    </a>
               </li>
          </ul>
          <div class="pcoded-navigation-label">Chart And Maps</div>
          <ul class="pcoded-item pcoded-left-item">
               <li class="">
                    <a href="chart-morris.html" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-bar-chart-alt"></i><b>C</b></span>
                    <span class="pcoded-mtext">Charts</span>
                    <span class="pcoded-mcaret"></span>
                    </a>
               </li>
               <li class="">
                    <a href="map-google.html" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-map-alt"></i><b>M</b></span>
                    <span class="pcoded-mtext">Maps</span>
                    <span class="pcoded-mcaret"></span>
                    </a>
               </li>
          </ul>
          <div class="pcoded-navigation-label">Pages</div>
          <ul class="pcoded-item pcoded-left-item">
               <li class="pcoded-hasmenu ">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-id-badge"></i><b>A</b></span>
                    <span class="pcoded-mtext">Pages</span>
                    <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                    <li class="">
                         <a href="auth-normal-sign-in.html" class="waves-effect waves-dark">
                              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                              <span class="pcoded-mtext">Login</span>
                              <span class="pcoded-mcaret"></span>
                         </a>
                    </li>
                    <li class="">
                         <a href="auth-sign-up.html" class="waves-effect waves-dark">
                              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                              <span class="pcoded-mtext">Registration</span>
                              <span class="pcoded-mcaret"></span>
                         </a>
                    </li>
                    <li class="">
                         <a href="sample-page.html" class="waves-effect waves-dark">
                              <span class="pcoded-micon"><i class="ti-layout-sidebar-left"></i><b>S</b></span>
                              <span class="pcoded-mtext">Sample Page</span>
                              <span class="pcoded-mcaret"></span>
                         </a>
                    </li>
                    </ul>
               </li>
          </ul> -->
     </div>
</nav>
