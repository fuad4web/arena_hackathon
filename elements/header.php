<?php
     include './core/init.php';

     if($getFromU->loggedIn() !== true) {
          echo '<script>window.location.replace("'.BASE_URL.'validation/logout");</script>';
     }

     $user_id = $_SESSION['id'];

     $route = basename($_SERVER['PHP_SELF'], ".php"); // Get the current page's route name (without .php)
     // echo $route;

     if (!$user_id || !$getFromU->hasAccess($user_id, $route)) {
          echo '<script>window.location.replace("'.BASE_URL.'validation/logout");</script>';
          exit;
     }

     $user = $getFromU->userData($user_id);
     include 'functions.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Shopping Management System</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="keywords" content="bootstrap, bootstrap admin template, admin theme, admin dashboard, dashboard template, admin template, responsive" />
    <meta name="author" content="Codedthemes" />
    <!-- Favicon icon -->
    <link rel="icon" href="https://res.cloudinary.com/ddbk4vtwe/image/upload/v1766391915/IMG-20251222-WA0016-removebg-preview_l5tigj.png" type="image/png">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
    <!-- waves.css -->
    <link rel="stylesheet" href="assets/pages/waves/css/waves.min.css" type="text/css" media="all">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap/css/bootstrap.min.css">
    <!-- waves.css -->
    <link rel="stylesheet" href="assets/pages/waves/css/waves.min.css" type="text/css" media="all">
    <!-- themify icon -->
    <link rel="stylesheet" type="text/css" href="assets/icon/themify-icons/themify-icons.css">
    <!-- Notification.css -->
    <link rel="stylesheet" type="text/css" href="assets/pages/notification/notification.css">
    <!-- Toastr Notification -->
    <link rel="stylesheet" type="text/css" href="assets/toastr/toastr.min.css">
    <!-- Toastr CSS -->
     <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"> -->

     <!-- SweetAlert CSS -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="assets/icon/icofont/css/icofont.css">
    <!-- font-awesome-n -->
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome-n.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <!-- scrollbar.css -->
    <link rel="stylesheet" type="text/css" href="assets/css/jquery.mCustomScrollbar.css">
    <!-- morris chart -->
    <link rel="stylesheet" type="text/css" href="assets/css/morris.js/css/morris.css">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/mystyle.css">
    <link rel="stylesheet" href="assets/js/datepicker.css">

    <link rel="stylesheet" href="assets/datatables/datatables.min.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
          tr > th { text-align: center; }
          
          #my_table { overflow-x: scroll; }

          .swal2-container.swal2-top-end { top: 20px; right: 20px; }

          .toast-top-right { top: 20px; right: 20px; }

          .swal2-container.swal2-top-end { top: 20px; right: 20px; }

          .toast-top-right { top: 80px; right: 20px; }

          .list-products-page .product-card { transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out; border: 1px solid #e9ecef; }

          .list-products-page .product-card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important; }

          .list-products-page .product-image-wrapper { border-radius: 50%; padding: 3px; background: linear-gradient(45deg, #f8f9fa, #e9ecef); }

          .list-products-page .card-header { min-height: auto; }

          .list-products-page .pricing-info { border-left: 3px solid #007bff; padding-left: 12px; background-color: #f8f9fa; border-radius: 4px; padding: 10px; }

          .list-products-page .quantity-info { border: 1px solid #e9ecef; }

          .list-products-page .product-meta { border-top: 1px dashed #dee2e6; padding-top: 12px; }

          .list-products-page .badge { font-size: 0.75em; }

          /* Modern Table Styling */
          .table-modern { border: 1px solid #e3e6f0; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05); }

          .table-modern thead th { background: linear-gradient(135deg, #2c3e50, #34495e); border: none; padding: 15px 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; font-size: 0.85rem; color: #fff; }

          .table-modern tbody tr { transition: all 0.3s ease; border-bottom: 1px solid #f8f9fc; }

          .table-modern tbody tr.table-row-hover:hover { background-color: #f8f9ff; transform: translateY(-1px); box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08); }

          .table-modern tbody td { padding: 15px 12px; vertical-align: middle; border: none; font-size: 0.9rem; }

          /* Customer Info Styling */
          .customer-info .fw-semibold { font-size: 0.95rem; margin-bottom: 2px; }

          .customer-info .text-muted { font-size: 0.8rem; line-height: 1.3; }

          .address-truncate { max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

          /* Badge Styling */
          .receipt-badge { font-family: 'Courier New', monospace; font-weight: 600; padding: 6px 10px; border: 1px solid #dee2e6 !important; }

          .payment-badge { font-size: 0.8rem; padding: 6px 10px; border-radius: 15px; }

          /* Amount Display */
          .amount-display { font-size: 1rem; letter-spacing: 0.5px; }

          /* Date Time Display */
          .datetime-display .small { font-size: 0.85rem; }

          .datetime-display .smaller { font-size: 0.75rem; }

          /* Print Button Styling */
          .print-btn { background: linear-gradient(135deg, #007bff, #0056b3); border: none; border-radius: 8px; padding: 8px 16px; font-size: 0.85rem; font-weight: 500; transition: all 0.3s ease; box-shadow: 0 2px 4px rgba(0, 123, 255, 0.2); }

          .print-btn:hover { background: linear-gradient(135deg, #0056b3, #004085); transform: translateY(-1px); box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3); }

          /* Table Responsive Container */
          .table-responsive { border-radius: 10px; }

          /* Card Block Styling */
          .card-block { background: #fff; border-radius: 12px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08); padding: 20px; }

          /* Alternating row colors for better readability */
          .table-modern tbody tr:nth-child(even) { background-color: #fafbfe; }

          .table-modern tbody tr:nth-child(even):hover { background-color: #f0f2ff; }

          /* Header icon styling */
          .table-modern thead th i { opacity: 0.8; margin-right: 5px; }

          .branch-badge { background: linear-gradient(135deg, #f8f9fa, #e9ecef) !important; color: #495057 !important; }

          .seller-info { text-align: center; }

          .table-footer-modern { background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-top: 2px solid #e3e6f0; }

          .table-footer-modern td { padding: 20px; border: none; }

          /* Additional specific styling for creditors table */
          .debt-info { min-width: 100px; }

          .debt-progress { background-color: #f8d7da; border-radius: 2px; }

          .debt-progress .progress-bar { border-radius: 2px; }

          .debt-payment-form { min-width: 180px; }

          .debt-input-group { border-radius: 6px; overflow: hidden; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }

          .debt-input { border: 1px solid #28a745; border-right: none; font-size: 0.8rem; padding: 6px 8px; }

          .debt-input:focus { border-color: #28a745; box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25); }

          .debt-pay-btn { background: linear-gradient(135deg, #28a745, #20c997); border: 1px solid #28a745; padding: 6px 12px; font-size: 0.8rem; font-weight: 500; transition: all 0.3s ease; white-space: nowrap; }

          .debt-pay-btn:hover { background: linear-gradient(135deg, #218838, #1e9e8a); transform: translateY(-1px); box-shadow: 0 2px 6px rgba(40, 167, 69, 0.3); }

          /* Enhanced amount displays for better visual hierarchy */
          .amount-display.text-dark { color: #495057 !important; }

          .amount-display.text-success { color: #28a745 !important; }

          .amount-display.text-danger { color: #dc3545 !important; }

          /* Mobile responsiveness for debt payment form */
          @media (max-width: 768px) {
               .debt-payment-form { min-width: 150px; }
               
               .debt-input { font-size: 0.75rem; padding: 4px 6px; }
               
               .debt-pay-btn { padding: 4px 8px; font-size: 0.75rem; }
               
               .debt-input-group { flex-direction: column; }
               
               .debt-input { border-right: 1px solid #28a745; border-bottom: none; }
          }

          /* Hover effects for debt rows */
          .table-modern tbody tr.table-row-hover:hover .debt-progress .progress-bar { background-color: #c82333; }

          /* Create Product Form Container */
          .form-container { background: #fff; border-radius: 12px; padding: 30px; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08); }

          /* Enhanced Form Groups */
          .enhanced-form-group { position: relative; margin-bottom: 1.5rem; }

          .enhanced-form-group .form-control { height: 52px; border: 2px solid #e9ecef; border-radius: 8px; padding: 12px 45px 12px 15px; font-size: 14px; transition: all 0.3s ease; background: #fff; }

          .enhanced-form-group .form-control:focus { border-color: #007bff; box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15); background: #f8f9ff; }

          .enhanced-input, .enhanced-select, .enhanced-textarea { border: 2px solid #e9ecef; border-radius: 8px; padding: 12px 45px 12px 15px; font-size: 14px; transition: all 0.3s ease; background: #fff; }

          .enhanced-input:focus, .enhanced-select:focus, .enhanced-textarea:focus { border-color: #007bff; box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15); background: #f8f9ff; }

          .enhanced-textarea { resize: vertical; min-height: 120px; }

          /* Form Icons */
          .form-icon { position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: #6c757d; transition: all 0.3s ease; }

          .textarea-icon { top: 25px; transform: none; }

          .enhanced-form-group .form-control:focus + .form-icon { color: #007bff; }

          /* Float Labels */
          .float-label { position: absolute; top: -8px; left: 12px; font-size: 12px; font-weight: 500; background: #fff; padding: 0 8px; color: #007bff; transition: all 0.3s ease; }

          /* Enhanced File Upload */
          .file-upload-wrapper { position: relative; margin-top: 8px; }

          .file-upload-input { position: absolute; left: -9999px; opacity: 0; }

          .file-upload-area { border: 2px dashed #dee2e6; border-radius: 8px; padding: 30px 20px; text-align: center; transition: all 0.3s ease; background: #fafbfe; position: relative; cursor: pointer; }

          .file-upload-area:hover { border-color: #007bff; background: #f0f4ff; }

          .file-upload-area.dragover { border-color: #007bff; background: #e6f0ff; }

          .file-upload-icon { font-size: 48px; color: #6c757d; margin-bottom: 15px; }

          .file-upload-text h4 { font-size: 16px; font-weight: 600; color: #495057; margin-bottom: 5px; }

          .file-upload-text p { font-size: 12px; color: #6c757d; margin: 0; }

          .file-browse-btn { background: linear-gradient(135deg, #007bff, #0056b3); color: white; border: none; border-radius: 6px; padding: 10px 20px; font-size: 14px; font-weight: 500; margin-top: 15px; cursor: pointer; transition: all 0.3s ease; }

          .file-browse-btn:hover { background: linear-gradient(135deg, #0056b3, #004085); transform: translateY(-1px); box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3); }

          /* File Preview */
          .file-upload-preview { margin-top: 15px; text-align: center; }

          .file-upload-preview img { max-width: 120px; max-height: 120px; border-radius: 6px; border: 2px solid #e9ecef; }

          .file-name { display: block; margin-top: 8px; font-size: 12px; color: #495057; font-weight: 500; }

          /* Enhanced Select Dropdown */
          .enhanced-select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%236c757d' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 15px center; background-size: 12px; }

          /* Submit Button */
          .form-submit-section { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e9ecef; }

          .btn-create-product { background: linear-gradient(135deg, #28a745, #20c997); border: none; border-radius: 8px; padding: 12px 40px; font-size: 16px; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3); }

          .btn-create-product:hover { background: linear-gradient(135deg, #218838, #1e9e8a); transform: translateY(-2px); box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4); }

          /* Form Bar Animation */
          .form-bar { position: absolute; bottom: 0; left: 0; width: 0; height: 2px; background: linear-gradient(135deg, #007bff, #0056b3); transition: width 0.3s ease; }

          .enhanced-form-group .form-control:focus ~ .form-bar { width: 100%; }

          /* Additional specific styling for edit product form */
          .file-upload-preview img { max-width: 120px; max-height: 120px; border-radius: 6px; border: 2px solid #e9ecef; margin-bottom: 10px; }

          .file-upload-preview .file-name { display: block; font-size: 12px; color: #495057; font-weight: 500; text-align: center; }

          /* Ensure the preview is visible by default for edit form */
          .file-upload-preview { display: block !important; margin-bottom: 15px; }

          .file-upload-text { display: block; }

          .select2-container--default .select2-selection--single { height: 38px; border: 1px solid #ced4da; border-radius: 4px; }
          
          .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 36px; }
          
          .select2-container--default .select2-selection--single .select2-selection__arrow { height: 36px; }

          /* Responsive Design */
          @media (max-width: 768px) {
               .form-container { padding: 20px 15px; }
               
               .enhanced-form-group .form-control { height: 48px; font-size: 13px; }
               
               .file-upload-area { padding: 20px 15px; }
               
               .file-upload-icon { font-size: 36px; }
               
               .btn-create-product { width: 100%; padding: 12px 20px; }

               .table-modern { font-size: 0.8rem; }
               
               .table-modern thead th { padding: 12px 8px; font-size: 0.75rem; }
               
               .table-modern tbody td { padding: 12px 8px; }
               
               .print-btn { padding: 6px 12px; font-size: 0.75rem; }
               
               .address-truncate { max-width: 120px; }

               .table-footer-modern .d-flex { flex-direction: column; text-align: center; gap: 10px; }
          }
    </style>
</head>

<body>
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="loader-track">
            <div class="preloader-wrapper">
                <div class="spinner-layer spinner-blue">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
                <div class="spinner-layer spinner-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-yellow">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-green">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pre-loader end -->

    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
        <nav class="navbar header-navbar pcoded-header">
     <div class="navbar-wrapper">
     <div class="navbar-logo">
          <a class="mobile-menu waves-effect waves-light" id="mobile-collapse" href="#!">
               <i class="ti-menu"></i>
          </a>
          <div class="mobile-search waves-effect waves-light">
               <div class="header-search">
                    <div class="main-search morphsearch-search">
                         <div class="input-group">
                         <span class="input-group-prepend search-close"><i class="ti-close input-group-text"></i></span>
                         <input type="text" class="form-control" placeholder="Enter Keyword">
                         <span class="input-group-append search-btn"><i class="ti-search input-group-text"></i></span>
                         </div>
                    </div>
               </div>
          </div>
          <!-- <a href="dashboard">
               <img class="img-fluid" src="assets/images/logo.png" alt="Theme-Logo" />
          </a> -->
          <a class="mobile-options waves-effect waves-light">
               <i class="ti-more"></i>
          </a>
     </div>
     <div class="navbar-container container-fluid">
          <ul class="nav-left">
               <li>
                    <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
               </li>
               <li>
                    <a href="#!" onclick="javascript:toggleFullScreen()" class="waves-effect waves-light">
                         <i class="ti-fullscreen"></i>
                    </a>
               </li>
          </ul>
          <ul class="nav-right">
               <li class="header-notification">
                    <a href="#!" class="waves-effect waves-light">
                         <i class="ti-bell"></i>
                         <span class="badge bg-c-red"></span>
                    </a>
                    <ul class="show-notification">
                         <li>
                              <h6>Notifications</h6>
                              <label class="label label-danger">New</label>
                         </li>
                         <li class="waves-effect waves-light notification-box">

                         </li>
                    </ul>
               </li>
               <li class="user-profile header-notification">
                    <a href="#!" class="waves-effect waves-light">
                         <img src="<?= @$user?->profile_pics ?>" class="img-radius" alt="User-Profile-Image">
                         <span><?= $user->fullname ?></span>
                         <i class="ti-angle-down"></i>
                    </a>
                    <ul class="show-notification profile-notification">
                         <?php if ($getFromU->hasAccess($user_id, 'settings')): ?>
                         <li class="waves-effect waves-light">
                              <a href="./settings">
                                   <i class="ti-settings"></i> Settings
                              </a>
                         </li>
                         <?php endif; ?>
                         <?php if ($getFromU->hasAccess($user_id, 'profile')): ?>
                         <li class="waves-effect waves-light">
                              <a href="./profile">
                                   <i class="ti-user"></i> Profile
                              </a>
                         </li>
                         <?php endif; ?>
                         <li class="waves-effect waves-light">
                              <a href="./validation/logout">
                                   <i class="ti-layout-sidebar-left"></i> Logout
                              </a>
                         </li>
                    </ul>
               </li>
          </ul>
     </div>
     </div>
</nav>
