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
                                        <h5 class="m-b-10">Market Product Page</h5>
                                        <p class="m-b-0">Welcome to <?= $selectCompanyName ?></p>
                                   </div>
                              </div>
                              <div class="col-md-4">
                                   <ul class="breadcrumb">
                                        <li class="breadcrumb-item">
                                             <a href="dashboard"> <i class="fa fa-home"></i> </a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#!">Market Products</a>
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
                                             <h3>Market Products</h3>
                                             <span>List of all Market Products</span>
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
                                                  <table class="table table-striped bg-light text-primary" id="my_table">
                                                       <thead class="">
                                                            <tr>
                                                                 <th>S/N</th>
                                                                 <th>Product Pics</th>
                                                                 <th>Product Name</th>
                                                                 <th>Product Barcode</th>
                                                                 <th>Product Price (<?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?>)</th>
                                                                 <th>Product Quantity</th>
                                                                 <th>Product Category</th>
                                                                 <th>Product Distributor</th>
                                                                 <th>Created At</th>
                                                                 <!-- <th>Action</th> -->
                                                            </tr>
                                                       </thead>
                                                       <tbody>
                                                            <?php
                                                            $i = 0;
                                                            foreach ($selectMarketProducts as $selectMarketProduct):
                                                                 $i++;
                                                                 $product_category = $getFromU->select_one_val('product_category', 'name', 'id', $selectMarketProduct?->category);
                                                                 $product_distributor = $getFromU->select_one_val('distributors', 'name', 'id', $selectMarketProduct?->distributor);
                                                            ?>
                                                                 <tr>
                                                                      <th scope="row"><?= $i ?></th>
                                                                      <center>
                                                                           <td>
                                                                                <img src="<?= $selectMarketProduct?->product_pics ?>" style="border-radius: 50%;" class="border-rounded" width="40" height="40" alt="<?= $selectMarketProduct?->name ?>">
                                                                           </td>
                                                                           <td><?= $selectMarketProduct?->name ?></td>
                                                                           <td><?= $selectMarketProduct?->barcode ?></td>
                                                                           <td><span style="font-weight: 650;"><?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?><?= @number_format($selectMarketProduct?->price, 2, '.', ',') ?></span></td>
                                                                           <td><span style="font-weight: 650;"><?= @$selectMarketProduct?->quantity ?></span></td>
                                                                           <td><?= $product_category ?></td>
                                                                           <td><?= $product_distributor ?></td>
                                                                           <td><?= $selectMarketProduct?->created_at ?></td>
                                                                           <!-- <td>
                                                                                <ul class="d-flex justify-content-evenly">
                                                                                     <td>
                                                                                          <button class="btn btn-sm btn-primary editBtn"
                                                                                          data-id="<?= $selectMarketProduct?->id ?>"
                                                                                          data-name="<?= $selectMarketProduct?->name ?>"
                                                                                          data-quantity="<?= $selectMarketProduct?->quantity ?>"
                                                                                          data-price="<?= $selectMarketProduct?->price ?>"
                                                                                          data-toggle="modal"
                                                                                          data-target="#editMarketProductModal">
                                                                                          Edit
                                                                                          </button>
                                                                                     </td>
                                                                                     &nbsp;&nbsp;&nbsp;
                                                                                     <a href="./delete_market_product?codes="2" title="Delete">
                                                                                          <li><i class="fa fa-trash close-card"></i></li>
                                                                                     </a>
                                                                                </ul>
                                                                           </td> -->
                                                                      </center>
                                                                 </tr>
                                                            <?php
                                                            endforeach;
                                                            ?>

                                                       </tbody>
                                                       <tfoot>
                                                            <td colspan="5">
                                                                 <p style="font-weight: 550; font-size: 18px;">Market Products Total Price: <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?><?= @@number_format($sumTotalMarketProductsAmount, 2, '.', ',') ?></span></p>
                                                            </td>
                                                            <td colspan="5">
                                                                 <p style="font-weight: 550; font-size: 18px;">Total Quantity of Market Products: <?= @@number_format($totalMarketProductsInStore, 2, '.', ',') ?></span>&nbsp;<small>pieces</small></p>
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

<!-- Edit Market Product Modal -->
<div class="modal fade" id="editMarketProductModal" tabindex="-1" aria-labelledby="editCustomerLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="validation/validate_update_market_product">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit <span id="market_product_name"></span> Market Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="market_id" id="market_id">
            <div class="mb-3">
                <label>Price</label>
                <input type="text" name="price" id="market_price" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Quantity</label>
                <input type="text" name="quantity" id="market_quantity" class="form-control" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="market_product" class="btn btn-success">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>

</div>
</div>

<?php
     include 'elements/footer.php';
?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.editBtn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('market_id').value = this.dataset.id;
            document.getElementById('market_price').value = this.dataset.price;
            document.getElementById('market_quantity').value = this.dataset.quantity;
            document.getElementById('market_product_name').text = this.dataset.name;
        });
    });
});
</script>
