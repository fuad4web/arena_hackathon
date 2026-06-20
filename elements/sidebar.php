
<nav class="pcoded-navbar">
     <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
     <div class="pcoded-inner-navbar main-menu">
          <div class="">
               <div class="main-menu-header">
                    <img class="img-80 img-radius" src="<?= $user?->profile_pics ?>" alt="User-Profile-Image">
                    <div class="user-details">
                    <span id="more-details"><?= $user?->fullname ?><i class="fa fa-caret-down"></i></span>
                    </div>
               </div>
               <div class="main-menu-content">
                    <ul>
                    <li class="more-details">
                         <?php if ($getFromU->hasAccess($user_id, 'settings')): ?>
                              <a href="./settings"><i class="ti-settings"></i>Settings</a>
                         <?php endif; ?>
                         <?php if ($getFromU->hasAccess($user_id, 'profile')): ?>
                              <a href="profile"><i class="ti-user"></i>View Profile</a>
                         <?php endif; ?>
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
               // $userId = 1; // Replace with the current user's ID
               $menu = $getFromU->getMenuByUser($user_id);

               // Render and output the menu
               echo $getFromU->renderMenu($menu);
          ?>
     </div>
</nav>
