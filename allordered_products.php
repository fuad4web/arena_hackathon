<?php

include 'elements/header.php';

// if (@$user->status !== 'admin') {
//      echo '<script>window.location.replace("' . BASE_URL . 'validation/logout");</script>';
// }
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
                                        <h5 class="m-b-10">Purchased Product Page</h5>
                                        <p class="m-b-0">Welcome to <?= $selectCompanyName ?></p>
                                   </div>
                              </div>
                              <div class="col-md-4">
                                   <ul class="breadcrumb">
                                        <li class="breadcrumb-item">
                                             <a href="dashboard"> <i class="fa fa-home"></i> </a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#!">Purchased Products</a>
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
                                             <h5>Purchased Products</h5>
                                             <span>List of Last 250 Products Sales</span>
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
                                                                 <th>Branch Name</th>
                                                                 <th>Receipt No.</th>
                                                                 <th>Customer</th>
                                                                 <th>Payment Mode</th>
                                                                 <th class="text-end">Price Cost (<?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?>)</th>
                                                                 <th>Sold by</th>
                                                                 <th>Additional Info.</th>
                                                                 <th>Date & Time</th>
                                                                 <th class="text-center">Actions</th>
                                                            </tr>
                                                       </thead>
                                                       <tbody>
                                                            <?php
                                                            $i = 0;
                                                            foreach ($list_ordered_products as $list_ordered_product) {
                                                                 $i++;
                                                                 $seller_name = $getFromU->select_one_val('user', 'fullname', 'id', $list_ordered_product?->user_id);
                                                                 $branchName = $getFromU->select_one_val('branches', 'branch_name', 'id', $list_ordered_product?->branch_id);
                                                                 // Format the date for better display
                                                                 $formattedDate = date('M j, Y g:i A', strtotime($list_ordered_product?->created_at));
                                                            ?>
                                                                 <tr class="table-row-hover">
                                                                 <td class="text-center fw-bold text-primary"><?= $i ?></td>
                                                                 <td>
                                                                      <span class="badge bg-light text-dark border branch-badge">
                                                                           <i class="fas fa-store me-1"></i><?= ucwords($branchName) ?>
                                                                      </span>
                                                                 </td>
                                                                 <td>
                                                                      <span class="badge bg-light text-dark border receipt-badge"><?= $list_ordered_product?->trans_code ?></span>
                                                                 </td>
                                                                 <td>
                                                                      <div class="customer-info">
                                                                           <div class="fw-semibold text-dark"><?= $list_ordered_product?->name ?></div>
                                                                           <div class="text-muted small"><?= $list_ordered_product?->phone_number ?></div>
                                                                           <?php if(!empty($list_ordered_product?->address)): ?>
                                                                                <div class="text-muted small address-truncate" title="<?= $list_ordered_product?->address ?>">
                                                                                     <i class="fas fa-map-marker-alt me-1"></i><?= $list_ordered_product?->address ?>
                                                                                </div>
                                                                           <?php endif; ?>
                                                                      </div>
                                                                 </td>
                                                                 <td>
                                                                      <span class="payment-badge badge bg-<?= 
                                                                           ($list_ordered_product?->payment_mode == 'cash') ? 'success' : 
                                                                           (($list_ordered_product?->payment_mode == 'card') ? 'info' : 'warning') 
                                                                      ?>">
                                                                           <i class="fas fa-<?= 
                                                                                ($list_ordered_product?->payment_mode == 'cash') ? 'money-bill' : 
                                                                                (($list_ordered_product?->payment_mode == 'card') ? 'credit-card' : 'mobile-alt') 
                                                                           ?> me-1"></i>
                                                                           <?= ucwords($list_ordered_product?->payment_mode) ?>
                                                                      </span>
                                                                 </td>
                                                                 <td class="text-end">
                                                                      <span class="amount-display fw-bold">
                                                                           <small class="text-secondary">V.A.T: <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?><?= @number_format($list_ordered_product?->vat, 2, '.', ',') ?></small><br>
                                                                           <small class="text-primary">Sub-Total: <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?><?= @number_format($list_ordered_product?->grand_total, 2, '.', ',') ?></small><br>
                                                                           <small class="text-success">Grand Total: <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?><?= @number_format($list_ordered_product?->grand_total + $list_ordered_product?->vat, 2, '.', ',') ?></small>
                                                                      </span>
                                                                 </td>
                                                                 <td>
                                                                      <div class="seller-info">
                                                                           <span class="fw-semibold text-dark"><?= $seller_name ?></span>
                                                                      </div>
                                                                 </td>
                                                                 <td>
                                                                      <small><?= $list_ordered_product?->additional_info ?></small>
                                                                 </td>
                                                                 <td>
                                                                      <div class="datetime-display">
                                                                           <div class="fw-semibold small"><?= date('M j, Y', strtotime($list_ordered_product?->created_at)) ?></div>
                                                                           <div class="text-muted smaller"><?= date('g:i A', strtotime($list_ordered_product?->created_at)) ?></div>
                                                                      </div>
                                                                 </td>
                                                                 <td class="text-center">
                                                                      <a href="./receipt?code=<?= $list_ordered_product?->trans_code ?>" class="btn btn-primary btn-sm print-btn" title="Print Receipt">
                                                                           <i class="fas fa-print me-1"></i> Print
                                                                      </a>
                                                                 </td>
                                                                 </tr>
                                                            <?php
                                                            }
                                                            ?>
                                                       </tbody>
                                                       <tfoot class="table-footer-modern">
                                                            <tr>
                                                                 <td colspan="9" class="py-3">
                                                                 <div class="d-flex justify-content-between align-items-center">
                                                                      <p class="mb-0" style="font-weight: 500; font-size: 18px; color: #2c3e50;">
                                                                           Total Amount of Products Sold: 
                                                                           <span style="font-weight: 650; color: #27ae60;">
                                                                                <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?><?= @number_format($totalAmountSoldProducts, 2, '.', ',') ?>
                                                                           </span>
                                                                      </p>
                                                                      <span class="badge bg-primary fs-6">
                                                                           <i class="fas fa-chart-line me-1"></i>Total Sales
                                                                      </span>
                                                                 </div>
                                                                 </td>
                                                            </tr>
                                                       </tfoot>
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