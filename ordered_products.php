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
                                        <h5 class="m-b-10">Order Product</h5>
                                        <p class="m-b-0">Welcome to <?= $selectCompanyName ?></p>
                                   </div>
                              </div>
                              <div class="col-md-4">
                                   <ul class="breadcrumb">
                                        <li class="breadcrumb-item">
                                             <a href="dashboard"> <i class="fa fa-home"></i> </a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#!">Product</a>
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
                                             <h5>Sales Product</h5>
                                             <span>List of all Product Sales</span>
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
                                                  <table class="table table-hover table-modern" id="my_table">
                                                       <thead class="table-dark">
                                                            <tr>
                                                                 <th class="text-center">S/N</th>
                                                                 <th>Receipt No.</th>
                                                                 <th>Customer</th>
                                                                 <th>Payment Mode</th>
                                                                 <th class="text-end">Price (<?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?>)</th>
                                                                 <th>Additional Info.</th>
                                                                 <th>Date & Time</th>
                                                                 <th class="text-center">Actions</th>
                                                            </tr>
                                                       </thead>
                                                       <tbody>
                                                            <?php
                                                            $i = 0;
                                                            foreach ($list_my_products as $list_my_product) {
                                                                 $i++;
                                                                 // Format the date for better display
                                                                 $formattedDate = date('M j, Y g:i A', strtotime($list_my_product?->created_at));
                                                            ?>
                                                                 <tr class="table-row-hover">
                                                                 <td class="text-center fw-bold text-primary"><?= $i ?></td>
                                                                 <td>
                                                                      <span class="badge bg-light text-dark border receipt-badge"><?= $list_my_product?->trans_code ?></span>
                                                                 </td>
                                                                 <td>
                                                                      <div class="customer-info">
                                                                           <div class="fw-semibold text-dark"><?= $list_my_product?->name ?></div>
                                                                           <div class="text-muted small"><?= $list_my_product?->phone_number ?></div>
                                                                           <?php if(!empty($list_my_product?->address)): ?>
                                                                                <div class="text-muted small address-truncate" title="<?= $list_my_product?->address ?>">
                                                                                     <i class="fas fa-map-marker-alt me-1"></i><?= $list_my_product?->address ?>
                                                                                </div>
                                                                           <?php endif; ?>
                                                                      </div>
                                                                 </td>
                                                                 <td>
                                                                      <span class="payment-badge badge bg-<?= 
                                                                           ($list_my_product?->payment_mode == 'cash') ? 'success' : 
                                                                           (($list_my_product?->payment_mode == 'card') ? 'info' : 'primary') 
                                                                      ?>">
                                                                           <i class="fas fa-<?= 
                                                                                ($list_my_product?->payment_mode == 'cash') ? 'money-bill' : 
                                                                                (($list_my_product?->payment_mode == 'card') ? 'credit-card' : 'mobile-alt') 
                                                                           ?> me-1"></i>
                                                                           <?= ucwords($list_my_product?->payment_mode) ?>
                                                                      </span>
                                                                 </td>
                                                                 <td class="text-end">
                                                                      <span class="amount-display fw-bold">
                                                                           <small class="text-secondary">V.A.T: <?= $getFromU->formatCurrency($list_my_product?->vat, $selectDefaultCurrency) ?></small><br>
                                                                           <small class="text-primary">Sub-Total: <?= $getFromU->formatCurrency($list_my_product?->grand_total, $selectDefaultCurrency) ?></small><br>
                                                                           <small class="text-success">Grand Total: <?= $getFromU->formatCurrency($list_my_product?->grand_total + $list_my_product?->vat, $selectDefaultCurrency) ?></small>
                                                                      </span>
                                                                 </td>
                                                                 <td>
                                                                      <small><?= $list_my_product?->additional_info ?></small>
                                                                 </td>
                                                                 <td>
                                                                      <div class="datetime-display">
                                                                           <div class="fw-semibold small"><?= date('M j, Y', strtotime($list_my_product?->created_at)) ?></div>
                                                                           <div class="text-muted smaller"><?= date('g:i A', strtotime($list_my_product?->created_at)) ?></div>
                                                                      </div>
                                                                 </td>
                                                                 <td class="text-center">
                                                                      <a href="./receipt?code=<?= $list_my_product?->trans_code ?>" class="btn btn-primary btn-sm print-btn" title="Print Receipt">
                                                                           <i class="fas fa-print me-1"></i> Print
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