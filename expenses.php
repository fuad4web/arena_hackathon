<?php
include 'elements/header.php';
?>
<!-- if(@$user->status !== 'admin') {
          echo '<script>window.location.replace("'.BASE_URL.'validation/logout");</script>';
     } -->
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
                                <h5 class="m-b-10">Expenses</h5>
                                <p class="m-b-0">Welcome to <?= $selectCompanyName ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="dashboard"> <i class="fa fa-home"></i> </a>
                                </li>
                                <li class="breadcrumb-item"><a href="#!">Expenses Page</a></li>
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
                                    <h5>Insert Expenses</h5>
                                </div>
                                <div class="card-block">
                                    <form class="form-material g-4" method="POST" action="validation/validate_expenses">
                                        <div class="row p-4">
                                            <div class="col-md-6">
                                                <input type="text" name="purpose" list="purposeOptions" id="purpose" placeholder="Search Purpose" autocomplete="off" class="form-control" required>
                                                <datalist id="purposeOptions">
                                                    <?php foreach ($selectExpenses as $selectExpense): ?>
                                                        <option value="<?= $selectExpense->purpose ?>">
                                                        <?php endforeach; ?>
                                                </datalist>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-default form-static-label">
                                                    <input type="number" name="amount" placeholder="Amount" class="form-control" required>
                                                    <span class="form-bar"></span>
                                                    <label class="float-label">Amount</label>
                                                    <br>
                                                </div>
                                            </div>

                                            <?php if($user?->status == 'admin'): ?>
                                            <div class="col-md-4">
                                                <div class="form-group form-default form-static-label">
                                                        <select name="branch_id" class="form-control" id="" required>
                                                            <option value="">Choose Branch</option>
                                                            <?php foreach ($selectBranches as $selectBranches): ?>
                                                                <option value="<?= $selectBranches->id ?>"><?= ucwords($selectBranches->branch_name) ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <span class="form-bar"></span>
                                                        <label class="float-label">Branches</label>
                                                        <br>
                                                </div>
                                            </div>
                                            <?php endif; ?>

                                            <div class="col-md-8">
                                                <div class="form-group form-default form-static-label">
                                                    <textarea name="remarks" id="" class="form-control" cols="30" rows="10"></textarea>
                                                    <span class="form-bar"></span>
                                                    <label class="float-label">Further Explanation</label>
                                                </div>
                                            </div>
                                        </div>

                                        <center>
                                            <input type="submit" name="expenses" class="btn btn-outline-primary" value="Addup Now!">
                                        </center>
                                    </form>
                                </div>
                            </div>
                            <div class="card text-info">
                                <div class="card-header">
                                    <h5>Expenses</h5>
                                    <span>List of all Latest Expenses</span>
                                </div>
                                <div class="card-block table-border-style text-dark">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover" id="my_table">
                                            <thead class="">
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>User</th>
                                                    <th>Branch</th>
                                                    <th>Purpose</th>
                                                    <th>Amount</th>
                                                    <th>Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 0;
                                                foreach ($fetch_all_expenses as $fetch_expenses):
                                                    $i++;
                                                ?>
                                                    <tr>
                                                        <th scope="row"><?= $i ?></th>
                                                        <center>
                                                            <td><?= ucwords($fetch_expenses?->fullname) ?></td>
                                                            <td><?= $getFromU->select_one_val('branches', 'branch_name', 'id', $fetch_expenses?->exp_branch_id); ?></td>
                                                            <td><?= ucwords($fetch_expenses?->purpose) ?></td>
                                                            <td><span style="font-weight: 650;"><?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?><?= @number_format($fetch_expenses?->amount, 2, '.', ',') ?></span></td>
                                                            <td><?= $fetch_expenses?->remarks ?></td>
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
</div>
</div>

<?php
include 'elements/footer.php';
?>