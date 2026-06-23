<?php
include 'elements/header.php';


?>

<div class="pcoded-main-container">
     <div class="pcoded-wrapper">

          <?php
          include 'elements/sidebar.php';
          ?>

          <div class="pcoded-content">

               <div class="page-header">
                    <div class="page-block">
                         <div class="row align-items-center">
                              <div class="col-md-8">
                                   <div class="page-header-title">
                                        <h5 class="m-b-10">View and analyze sales records within a selected date range.</h5>
                                        <p class="m-b-0">Welcome to <?= $selectCompanyName ?></p>
                                   </div>
                              </div>
                              <div class="col-md-4">
                                   <ul class="breadcrumb">
                                        <li class="breadcrumb-item">
                                             <a href="dashboard"> <i class="fa fa-home"></i> </a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#!">Record Page</a>
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
                                             <h3>Sales Report</h3>
                                             <span>View and analyze sales records within a selected date range.</span>
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
                                             <?php
                                                  echo SuccessMessage();
                                                  echo ErrorMessage();
                                             ?>
                                             <form method="POST" action="validation/downloadrecord">
                                                  <div class="d-flex justify-content-between inputs my-4 text-center">
                                                       <div class="col-md-4">
                                                            <input type="text" name="first_date" id="first_date" autocomplete="off" placeholder="First Date" class="form-control" required>
                                                       </div>
                                                       <div class="col-md-4">
                                                            <input type="button" id="selectRecords" value="Select Records" class="btn btn-danger">
                                                       </div>
                                                       <div class="col-md-4">
                                                            <input type="text" name="second_date" id="second_date" autocomplete="off" placeholder="Second Date" class="form-control" required>
                                                       </div>
                                                  </div>

                                                  <div class="card-block table-border-style">
                                                       <div class="table-responsive">
                                                            <table class="table table-striped text-dark" id="my_table">
                                                                 <thead class="">
                                                                      <tr>
                                                                           <th>S/N</th>
                                                                           <th>Branch Name</th>
                                                                           <th>Receipt No.</th>
                                                                           <th>Customer</th>
                                                                           <th>Payment Mode</th>
                                                                           <th>Total Cost</th>
                                                                           <th>Staff Name</th>
                                                                           <th>Print Receipt</th>
                                                                      </tr>
                                                                 </thead>
                                                                 <tbody id="mypurrecords">

                                                                 </tbody>
                                                            </table>
                                                       </div>
                                                  </div>

                                                  <center>
                                                       <!-- <form action="validation/product_record" method="POST"> -->
                                                       <div class="col-md-4">
                                                            <input type="submit" id="selectRecords" download='downloaded_records.pdf' name="downloadPdf" value="Download PDF" class="btn btn-success">
                                                       </div>
                                             </form>
                                             </center>

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