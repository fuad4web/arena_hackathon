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
                                                  <table class="table table-striped">
                                                       <thead>
                                                            <tr>
                                                                 <th>#</th><th>Code</th><th>Customer</th><th>Brought</th><th>Wanted</th><th>Cash Added</th><th>Additional Info.</th><th>Date</th><th>Action</th>
                                                            </tr>
                                                       </thead>
                                                       <tbody>
                                                       <?php foreach($swaps as $s): ?>
                                                            <tr>
                                                            <td><?= $s->id ?></td>
                                                            <td><?= htmlspecialchars($s->trans_code) ?></td>
                                                            <td>
                                                                 <?php if($s->customer_id): 
                                                                 $cname = $getFromU->select_one_val('customers','name','id',$s->customer_id);
                                                                 echo htmlspecialchars($cname);
                                                                 else: echo 'Walk-in'; endif; ?>
                                                            </td>
                                                            <td><?= htmlspecialchars("{$s->brought_product_name} x {$s->brought_quantity}") ?></td>
                                                            <td><?= htmlspecialchars("{$s->wanted_product_name} x {$s->wanted_quantity}") ?></td>
                                                            <td><?= number_format($s->cash_added,2) ?></td>
                                                            <td>
                                                                 <small><?= htmlspecialchars($s->additional_info) ?></small>
                                                            </td>
                                                            <td><?= $s->created_at ?></td>
                                                            <td>
                                                                 <a href="swap_receipt.php?code=<?= urlencode($s->trans_code) ?>" class="btn btn-sm btn-danger" target="_blank"><i class="fas fa-print"></i> Print</a>
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