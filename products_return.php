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
                                        <h5 class="m-b-10">Staffs</h5>
                                        <p class="m-b-0">Welcome to <?= $selectCompanyName ?></p>
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
                                   <?php
                                   echo SuccessMessage();
                                   echo ErrorMessage();
                                   ?>
                                   <div class="card">
                                        <div class="card-header">
                                             <h3>Products Returned</h3>
                                             <span>List of all Products Returned</span>
                                             <div class="card-header-right">
                                                  <a href="return_product">
                                                       <input type="button" name="branch" class="btn btn-success" value="Return Product Page">
                                                  </a>
                                                  <!-- <ul class="list-unstyled card-option">
                                                        <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                                        <li><i class="fa fa-window-maximize full-card"></i></li>
                                                        <li><i class="fa fa-minus minimize-card"></i></li>
                                                        <li><i class="fa fa-refresh reload-card"></i></li>
                                                        <li><i class="fa fa-trash close-card"></i></li>
                                                    </ul> -->
                                             </div>
                                        </div>
                                        <div class="card-block table-border-style">
                                             <div class="table-responsive">
                                                  <table class="table table-striped text-primary">
                                                       <thead>
                                                            <tr>
                                                                 <th>S/N</th>
                                                                 <th>Product Name</th>
                                                                 <th>Staff Name</th>
                                                                 <th>Product Pics</th>
                                                                 <th>Product Price</th>
                                                                 <th>Quantity Returned</th>
                                                                 <th>Total Price</th>
                                                                 <th>Grand Total</th>
                                                                 <th>Reason</th>
                                                                 <th>Date</th>
                                                            </tr>
                                                       </thead>
                                                       <tbody>

                                                            <?php
                                                            $i = 0;
                                                            foreach ($products_returned as $product_returned) {
                                                                 $staffName = $getFromU->select_one_val('user', 'fullname', 'id', $product_returned?->staff_id);
                                                                 $i++;
                                                            ?>
                                                                 <tr>
                                                                      <td scope="row"><?= $i ?></td>
                                                                      <td><?= $product_returned?->name ?></td>
                                                                      <td><?= $staffName ?></td>
                                                                      <td>
                                                                           <img src="<?= $product_returned?->product_pics ?>" style="border-radius: 50%;" class="border-rounded" width="40" height="40" alt="<?= $product_returned?->name ?>">
                                                                      </td>
                                                                      <td><?= $product_returned?->price ?></td>
                                                                      <td><?= $product_returned?->return_quantity ?></td>
                                                                      <td><?= $product_returned?->return_total_price ?></td>
                                                                      <td><?= $product_returned?->return_grand_total ?></td>
                                                                      <td><?= $product_returned?->reason ?></td>
                                                                      <td><?= $product_returned?->created_at ?></td>
                                                                 </tr>
                                                            <?php
                                                            }
                                                            ?>

                                                       </tbody>
                                                       <tfoot>
                                                            <td colspan="5">
                                                                 <p style="font-weight: 400; font-size: 20px;">Total Price of Returned Product: <span style="font-weight: 650;"><?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?><?= @number_format($sumTotalProductsReturnedAmount, 2, '.', ',') ?></span></p>
                                                            </td>
                                                            <td colspan="4">
                                                                 <p style="font-weight: 400; font-size: 20px;">Total Quantity of Products: <span style="font-weight: 650;"><?= @number_format($totalProductsReturnedInStore, 2, '.', ',') ?></span>&nbsp;<small>pieces</small></p>
                                                            </td>
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