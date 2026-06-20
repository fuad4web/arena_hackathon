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
                                        <h5 class="m-b-10">Settings</h5>
                                        <p class="m-b-0">Welcome to <?= $selectCompanyName ?></p>
                                   </div>
                              </div>
                              <div class="col-md-4">
                                   <ul class="breadcrumb">
                                        <li class="breadcrumb-item">
                                             <a href="dashboard"> <i class="fa fa-home"></i> </a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#!">Settings</a>
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
                                             <h5>Company Settings</h5>
                                        </div>
                                        <div class="card-block">
                                             <form class="form-material" method="POST" action="validation/company_settings.php">

                                                  <div class="row">
                                                       <div class="col-md-8 form-group form-default form-static-label">
                                                            <input type="text" name="name" value="<?= $selectCompanyName ?>" class="form-control" placeholder="Enter Company Name">
                                                            <span class="form-bar"></span>
                                                            <label class="float-label">Company Name</label>
                                                            <br>
                                                       </div>
                                                       <div class="col-md-4 form-group form-default form-static-label">
                                                            <input type="number" name="vat" value="<?= $selectCompanyVat ?>" class="form-control" placeholder="Enter V.A.T" step="0.01">
                                                            <span class="form-bar"></span>
                                                            <label class="float-label">V.A.T</label>
                                                            <br>
                                                       </div>
                                                  </div>
                                                  <div class="form-group form-default form-static-label">
                                                       <input type="text" value="<?= $selectCompanyMobile ?>" name="phone_no" class="form-control" placeholder="Enter Company Phone Number">
                                                       <span class="form-bar"></span>
                                                       <label class="float-label">Company Phone Number</label>
                                                       <br>
                                                  </div>
                                                  <div class="row">
                                                       <div class="col-md-6">
                                                            <div class="form-group form-default form-static-label">
                                                                 <input type="text" name="email" value="<?= $selectCompanyEmail ?>" class="form-control" placeholder="Enter Company Email">
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Email</label>
                                                                 <br>
                                                            </div>
                                                       </div>
                                                       
                                                       <div class="col-md-6">
                                                            <select name="sales_price_edit" class="form-control" required>
                                                                 <option value="">Select Sales Price</option>
                                                                 <option value="editable" <?= $companyPriceEditability === 'editable' ? 'selected' : ''; ?>>Editable</option>
                                                                 <option value="uneditable" <?= $companyPriceEditability === 'uneditable' ? 'selected' : ''; ?>>Uneditable</option>
                                                            </select>
                                                       </div>

                                                       <div class="col-md-6">
                                                            <select name="currency" class="form-control" required>
                                                                 <option value="">Select Default Currency</option>
                                                                 <option value="NGN" <?= $selectDefaultCurrency === 'NGN' ? 'selected' : ''; ?>>₦ - Nigerian Naira</option>
                                                                 <option value="USD" <?= $selectDefaultCurrency === 'USD' ? 'selected' : ''; ?>>$ - US Dollar</option>
                                                                 <option value="EUR" <?= $selectDefaultCurrency === 'EUR' ? 'selected' : ''; ?>>€ - Euro</option>
                                                                 <option value="GBP" <?= $selectDefaultCurrency === 'GBP' ? 'selected' : ''; ?>>£ - British Pound</option>
                                                                 <option value="JPY" <?= $selectDefaultCurrency === 'JPY' ? 'selected' : ''; ?>>¥ - Japanese Yen</option>
                                                                 <option value="INR" <?= $selectDefaultCurrency === 'INR' ? 'selected' : ''; ?>>₹ - Indian Rupee</option>
                                                                 <option value="CAD" <?= $selectDefaultCurrency === 'CAD' ? 'selected' : ''; ?>>C$ - Canadian Dollar</option>
                                                                 <option value="AUD" <?= $selectDefaultCurrency === 'AUD' ? 'selected' : ''; ?>>A$ - Australian Dollar</option>
                                                                 <option value="ZAR" <?= $selectDefaultCurrency === 'ZAR' ? 'selected' : ''; ?>>R - South African Rand</option>
                                                                 <option value="CHF" <?= $selectDefaultCurrency === 'CHF' ? 'selected' : ''; ?>>₣ - Swiss Franc</option>
                                                            </select>
                                                       </div>
                                                       
                                                       <div class="col-md-6">
                                                            <div class="form-group form-default form-static-label">
                                                                 <textarea name="address" id="" class="form-control" cols="30" rows="10">
                                                                           <?= $selectCompanyAddr ?>
                                                                      </textarea>
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Company Address</label>
                                                            </div>
                                                       </div>
                                                       <div class="col-md-6">
                                                            <div class="form-group form-default form-static-label">
                                                                 <textarea name="receipt_footer" id="" class="form-control" cols="30" rows="10">
                                                                           <?= $selectCompanyReceiptFooter ?>
                                                                      </textarea>
                                                                 <span class="form-bar"></span>
                                                                 <label class="float-label">Receipt Footer</label>
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <center>
                                                       <input type="submit" name="settings" class="btn btn-outline-primary" value="SUBMIT">
                                                  </center>
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