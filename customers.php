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
                                        <h5 class="m-b-10">Customers Page</h5>
                                        <p class="m-b-0">Welcome to <?= $selectCompanyName ?></p>
                                   </div>
                              </div>
                              <div class="col-md-4">
                                   <ul class="breadcrumb">
                                        <li class="breadcrumb-item">
                                             <a href="dashboard"> <i class="fa fa-home"></i> </a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#!">List of Customers</a>
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
                                             <h3>Customers</h3>
                                             <span>List of all Customers</span>
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
                                                                 <th>Customer Name</th>
                                                                 <th>Customer Status</th>
                                                                 <th>Customer Phone-Number</th>
                                                                 <th>Customer Address</th>
                                                                 <th>Edit</th>
                                                            </tr>
                                                       </thead>
                                                       <tbody>
                                                            <?php
                                                            $i = 0;
                                                            foreach ($selectCustomers as $selectCustomer):
                                                                 $i++;
                                                            ?>
                                                                 <tr>
                                                                      <th scope="row"><?= $i ?></th>
                                                                      <center>
                                                                           <td><?= $selectCustomer?->name ?></td>
                                                                           <td><?= ucwords($selectCustomer?->status) ?></td>
                                                                           <td><?= $selectCustomer?->phone_number ?></td>
                                                                           <td><?= $selectCustomer?->address ?></td>
                                                                           <td>
                                                                                <button class="btn btn-sm btn-primary editBtn"
                                                                                data-id="<?= $selectCustomer?->id ?>"
                                                                                data-name="<?= $selectCustomer?->name ?>"
                                                                                data-status="<?= $selectCustomer?->status ?>"
                                                                                data-phone="<?= $selectCustomer?->phone_number ?>"
                                                                                data-address="<?= $selectCustomer?->address ?>"
                                                                                data-toggle="modal"
                                                                                data-target="#editCustomerModal">
                                                                                Edit
                                                                                </button>
                                                                           </td>
                                                                      </center>
                                                                 </tr>
                                                            <?php
                                                            endforeach;
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

<!-- Edit Customer Modal -->
<div class="modal fade" id="editCustomerModal" tabindex="-1" aria-labelledby="editCustomerLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="validation/update_customer">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Customer</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="customer_id" id="customer_id">
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" id="customer_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Status</label>
                <select name="status" id="customer_status" class="form-control" required>
                    <option value="regular">Regular</option>
                    <option value="special">Special</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Phone Number</label>
                <input type="text" name="phone_number" id="customer_phone" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Address</label>
                <input type="text" name="address" id="customer_address" class="form-control" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="update_customer" class="btn btn-success">Update</button>
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
            document.getElementById('customer_id').value = this.dataset.id;
            document.getElementById('customer_name').value = this.dataset.name;
            document.getElementById('customer_status').value = this.dataset.status;
            document.getElementById('customer_phone').value = this.dataset.phone;
            document.getElementById('customer_address').value = this.dataset.address;
        });
    });
});
</script>
