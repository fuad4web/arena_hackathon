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
                                        <h5 class="m-b-10">Creditors Page</h5>
                                        <p class="m-b-0">Welcome to <?= $selectCompanyName ?></p>
                                   </div>
                              </div>
                              <div class="col-md-4">
                                   <ul class="breadcrumb">
                                        <li class="breadcrumb-item">
                                             <a href="dashboard"> <i class="fa fa-home"></i> </a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#!">Creditors</a>
                                        </li>
                                   </ul>
                              </div>
                         </div>
                    </div>
               </div>

               <div class="pcoded-inner-content text-danger">
                    <div class="main-body">
                         <div class="page-wrapper">
                              <div class="page-body">
                                   <?php
                                   echo SuccessMessage();
                                   echo ErrorMessage();
                                   ?>
                                   <div class="card">
                                        <div class="card-header">
                                             <h3>Creditors</h3>
                                             <span>List of all Creditors</span>
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
                                                                 <th class="text-end">Total Cost</th>
                                                                 <th class="text-end">Amount Paid</th>
                                                                 <th class="text-end">Debt</th>
                                                                 <th>Date & Time</th>
                                                                 <th class="text-center">Receipt</th>
                                                                 <th class="text-center">Action</th>
                                                            </tr>
                                                       </thead>
                                                       <tbody>
                                                            <?php
                                                            $i = 0;
                                                            foreach ($list_all_creditors as $list_all_creditor):
                                                                 $i++;
                                                                 $exactAmount = $list_all_creditor->grand_total - $list_all_creditor->credit;
                                                                 $branchName = $getFromU->select_one_val('branches', 'branch_name', 'id', $list_all_creditor->branch_id);
                                                                 $formattedDate = date('M j, Y g:i A', strtotime($list_all_creditor->created_at));
                                                                 $debtPercentage = ($list_all_creditor->credit / $list_all_creditor->grand_total) * 100;
                                                            ?>
                                                                 <tr class="table-row-hover">
                                                                 <td class="text-center fw-bold text-primary"><?= $i ?></td>
                                                                 <td>
                                                                      <span class="badge bg-light text-dark border branch-badge">
                                                                           <i class="fas fa-store me-1"></i><?= $branchName ?>
                                                                      </span>
                                                                 </td>
                                                                 <td>
                                                                      <span class="badge bg-light text-dark border receipt-badge"><?= $list_all_creditor->trans_code ?></span>
                                                                 </td>
                                                                 <td>
                                                                      <div class="customer-info">
                                                                           <div class="fw-semibold text-dark"><?= $list_all_creditor->name ?></div>
                                                                           <div class="text-muted small"><?= $list_all_creditor->phone_number ?></div>
                                                                           <?php if(!empty($list_all_creditor->address)): ?>
                                                                                <div class="text-muted small address-truncate" title="<?= $list_all_creditor->address ?>">
                                                                                     <i class="fas fa-map-marker-alt me-1"></i><?= $list_all_creditor->address ?>
                                                                                </div>
                                                                           <?php endif; ?>
                                                                      </div>
                                                                 </td>
                                                                 <td class="text-end">
                                                                      <span class="amount-display fw-bold text-dark">
                                                                           <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?><?= @number_format($list_all_creditor->grand_total, 2, '.', ',') ?>
                                                                      </span>
                                                                 </td>
                                                                 <td class="text-end">
                                                                      <span class="amount-display fw-bold text-success">
                                                                           <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?><?= @number_format($exactAmount, 2, '.', ',') ?>
                                                                      </span>
                                                                 </td>
                                                                 <td class="text-end">
                                                                      <div class="debt-info">
                                                                           <span class="amount-display fw-bold text-danger">
                                                                                <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?><?= @number_format($list_all_creditor->credit, 2, '.', ',') ?>
                                                                           </span>
                                                                           <div class="progress debt-progress mt-1" style="height: 4px;">
                                                                                <div class="progress-bar bg-danger" 
                                                                                     role="progressbar" 
                                                                                     style="width: <?= $debtPercentage ?>%"
                                                                                     aria-valuenow="<?= $debtPercentage ?>" 
                                                                                     aria-valuemin="0" 
                                                                                     aria-valuemax="100">
                                                                                </div>
                                                                           </div>
                                                                      </div>
                                                                 </td>
                                                                 <td>
                                                                      <div class="datetime-display">
                                                                           <div class="fw-semibold small"><?= date('M j, Y', strtotime($list_all_creditor->created_at)) ?></div>
                                                                           <div class="text-muted smaller"><?= date('g:i A', strtotime($list_all_creditor->created_at)) ?></div>
                                                                      </div>
                                                                 </td>
                                                                 <td class="text-center">
                                                                      <a href="./receipt?code=<?= $list_all_creditor->trans_code ?>" class="btn btn-primary btn-sm print-btn" title="Print Receipt">
                                                                           <i class="fas fa-print me-1"></i> Print
                                                                      </a>
                                                                 </td>
                                                                 <td class="text-center">
                                                                      <form action="validation/access" method="POST" class="debt-payment-form">
                                                                           <input type="hidden" name="transCode" value="<?= $list_all_creditor->trans_code ?>">
                                                                           <div class="input-group input-group-sm debt-input-group">
                                                                                <input type="number" 
                                                                                     name="debtMoney" 
                                                                                     class="form-control debt-input" 
                                                                                     placeholder="Amount" 
                                                                                     aria-label="Payment Amount"
                                                                                     value="<?= $list_all_creditor->credit ?>"
                                                                                     min="0"
                                                                                     max="<?= $list_all_creditor->credit ?>"
                                                                                     step="0.01">
                                                                                <button class="btn btn-success debt-pay-btn" name="debt" type="submit" title="Make Payment">
                                                                                     <i class="fas fa-money-bill-wave me-1"></i> Pay
                                                                                </button>
                                                                           </div>
                                                                      </form>
                                                                 </td>
                                                                 </tr>
                                                            <?php endforeach; ?>
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