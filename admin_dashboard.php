<?php
     include 'elements/header.php';
?>

<style>
    /* Modern Dashboard Card Styling */
    .dashboard-card { border: none; border-radius: 16px; background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); overflow: hidden; position: relative; z-index: 1; }

    .dashboard-card::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 4px; background: linear-gradient(90deg, #0d6efd, #198754); z-index: 2; }

    .dashboard-card:hover { transform: translateY(-8px); box-shadow: 0 12px 40px rgba(13, 110, 253, 0.15); background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%); border-color: transparent !important; }

    .dashboard-card:hover::before { background: linear-gradient(90deg, #198754, #0d6efd); }

    .card-header-custom { border-bottom: none; background: transparent; padding: 20px 20px 0; margin-bottom: 0; }

    .card-title { font-size: 14px; font-weight: 600; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0; display: flex; align-items: center; justify-content: center; gap: 8px; }

    .card-title i { font-size: 16px; color: #0d6efd; }

    .card-title small { font-size: 12px; color: #6c757d; font-weight: 400; text-transform: none; }

    .card-body-custom { padding: 20px; }

    .card-value { font-size: 28px; font-weight: 600; color: #212529; margin: 10px 0; font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; }

    .card-value i { font-size: 24px; margin-right: 10px; vertical-align: middle; }

    .card-value .text-c-green { color: #198754 !important; }

    .card-value .text-c-red { color: #dc3545 !important; }

    .card-subtitle { font-size: 13px; color: #6c757d; margin-top: 10px; display: flex; align-items: center; justify-content: center; gap: 5px; }

    .card-subtitle span { color: #0d6efd; font-weight: 600; background: #e7f1ff; padding: 2px 8px; border-radius: 20px; }

    /* Trend indicator */
    .trend-indicator { display: inline-flex; align-items: center; background: rgba(25, 135, 84, 0.1); padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; margin-left: 10px; }

    .trend-indicator.up { background: rgba(25, 135, 84, 0.1); color: #198754; }

    .trend-indicator.down { background: rgba(220, 53, 69, 0.1); color: #dc3545; }

    /* Card with icon on left */
    .card-with-icon { display: flex; align-items: center; gap: 15px; }

    .card-icon { width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }

    .card-icon.revenue { background: linear-gradient(135deg, #0d6efd, #198754); color: white; }

    .card-icon.orders { background: linear-gradient(135deg, #ff6b6b, #ffa726); color: white; }

    .card-icon.users { background: linear-gradient(135deg, #6f42c1, #e83e8c); color: white; }

    .card-icon i { font-size: 24px; }

    .card-info { flex: 1; }

    /* Responsive */
    @media (max-width: 768px) { .dashboard-card {     margin-bottom: 20px } .card-value {     font-size: 24px } .card-title {     font-size: 12px } }

    /* Fix for the white blanking issue */
    .dashboard-card * { transition: none !important; }
    
    .dashboard-card:hover * { background: transparent !important; color: inherit !important; opacity: 1 !important; }

    /* Add this to your existing CSS to fix the blanking issue */
    .order-visitor-card { transition: all 0.3s ease; position: relative; overflow: hidden; z-index: 1; }

    .order-visitor-card * { transition: none !important; position: relative; z-index: 2; }

    .order-visitor-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); border-color: #dee2e6; }

    .order-visitor-card:hover * { background: transparent !important; color: inherit !important; opacity: 1 !important; }

    /* Force background colors to stay */
    .order-visitor-card .card-block,
    .order-visitor-card .card-body { background: transparent !important; }

    .kpi-card { position: relative; background: #ffffff; border-radius: 16px; padding: 25px 20px 20px; box-shadow: 0 12px 30px rgba(0,0,0,0.08); transition: all .3s ease; overflow: hidden; }

    .kpi-card:hover { transform: translateY(-6px); box-shadow: 0 18px 45px rgba(0,0,0,0.12); }

    .kpi-icon { position: absolute; top: 5px; left: 20px; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 22px; color: #fff; }

    .kpi-content h3 { margin-top: 25px; font-weight: 700; font-size: 22px; }

    .kpi-content p { margin: 0; color: #6c757d; font-size: 14px; }

    /* Color Variants */
    .kpi-green .kpi-icon { background: #28a745; }
    .kpi-blue  .kpi-icon { background: #007bff; }
    .kpi-purple .kpi-icon { background: #6f42c1; }
    .kpi-yellow .kpi-icon { background: #f0ad4e; }
    .kpi-red .kpi-icon { background: #dc3545; }
</style>


<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <?php include 'elements/sidebar.php'; ?>
        <div class="pcoded-content">
            <!-- Page-header start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Dashboard</h5>
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

            <!-- Page-header end -->
            <div class="pcoded-inner-content">
                <!-- Main-body start -->
                <div class="main-body">

                    <div class="form-group text-center" style="width: 200px; margin: 10px auto;">
                        <form method="POST" action="validation/setBranch">
                            <label for="branchSelect" class="lead fw-bolder">Select Branch</label>
                            <select id="branchSelect" name="branch_id" class="form-control" onchange="this.form.submit()">
                                <option value="">All Branches</option>
                                <?php foreach ($selectBranches as $branch): ?>
                                    <option value="<?= $branch?->id; ?>" <?= (isset($_SESSION['branch_id']) && $_SESSION['branch_id'] == $branch?->id) ? 'selected' : ''; ?>>
                                        <?= $branch?->branch_name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    </div>

                    <?php if (isset($_SESSION['branch_id'])): ?>
                        <p class="my-3 fw-bold lead text-center">
                            You are currently on <?= $sessionBranch ?> Branch
                        </p>
                    <?php endif; ?>

                    <div class="page-wrapper">
                        <!-- Page-body start -->
                        <!-- Daily Statistics -->
                        <div class="page-body">
                            <h4 class="text-dark text-center">Daily Statistics</h4>
                            <div class="my-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card dashboard-card">
                                            <div class="card-header-custom">
                                                <h6 class="card-title">
                                                    <i class="fas fa-chart-line"></i>Daily Revenue <small>(Income)</small>
                                                </h6>
                                            </div>
                                            <div class="card-body-custom">
                                                <div class="card-with-icon">
                                                    <div class="card-icon revenue">
                                                        <i class="fas fa-money-bill-wave"></i>
                                                    </div>
                                                    <div class="card-info">
                                                        <h4 class="card-value">
                                                            <i class="fas fa-arrow-up text-c-green"></i>
                                                            <?= $getFromU->formatCurrency($netDaily, $selectDefaultCurrency) ?>
                                                        </h4>
                                                        <p class="card-subtitle">
                                                            <i class="far fa-calendar-alt"></i> 
                                                            For <span><?= date('d F, Y') ?></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card dashboard-card">
                                            <div class="card-header-custom">
                                                <h6 class="card-title">
                                                    <i class="fa fa-arrow-up text-c-red"></i>Daily Orders <small>(Total Sales)</small>
                                                </h6>
                                            </div>
                                            <div class="card-body-custom">
                                                <div class="card-with-icon">
                                                    <div class="card-icon revenue">
                                                        <i class="fas fa-money-bill-wave"></i>
                                                    </div>
                                                    <div class="card-info">
                                                        <h4 class="card-value">
                                                            <i class="fa fa-arrow-up text-c-red"></i>
                                                            <?= $dailyOrders ?? 0 ?>
                                                        </h4>
                                                        <p class="card-subtitle">
                                                            <i class="far fa-calendar-alt"></i> 
                                                            For <span><?= date('d F, Y') ?></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card dashboard-card">
                                            <div class="card-header-custom">
                                                <h6 class="card-title">
                                                    <i class="fas fa-credit-card text-c-red"></i> Daily Credit
                                                </h6>
                                            </div>
                                            <div class="card-body-custom">
                                                <div class="card-with-icon">
                                                    <div class="card-icon revenue">
                                                        <i class="fas fa-arrow-down"></i>
                                                    </div>
                                                    <div class="card-info">
                                                        <h4 class="card-value">
                                                            <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?>
                                                            <?= number_format($dailyCredit ?? 0, 2, '.', ',') ?>
                                                        </h4>
                                                        <p class="card-subtitle">
                                                            <i class="far fa-calendar-alt"></i>
                                                            For <span><?= date('d F, Y') ?></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card dashboard-card">
                                            <div class="card-header-custom">
                                                <h6 class="card-title">
                                                    <i class="fas fa-undo text-c-red"></i> Product Returns
                                                </h6>
                                            </div>
                                            <div class="card-body-custom">
                                                <div class="card-with-icon">
                                                    <div class="card-icon revenue">
                                                        <i class="fas fa-box-open"></i>
                                                    </div>
                                                    <div class="card-info">
                                                        <h4 class="card-value">
                                                            <?= $dailyReturns ?? 0 ?>
                                                        </h4>
                                                        <p class="card-subtitle">
                                                            <i class="far fa-calendar-alt"></i>
                                                            For <span><?= date('d F, Y') ?></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card dashboard-card">
                                            <div class="card-header-custom">
                                                <h6 class="card-title">
                                                    <i class="fas fa-shopping-cart text-c-blue"></i> Product Sales
                                                </h6>
                                            </div>
                                            <div class="card-body-custom">
                                                <div class="card-with-icon">
                                                    <div class="card-icon revenue">
                                                        <i class="fas fa-arrow-up"></i>
                                                    </div>
                                                    <div class="card-info">
                                                        <h4 class="card-value">
                                                            <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?>
                                                            <?= number_format($dailyRevenue ?? 0, 2, '.', ',') ?>
                                                        </h4>
                                                        <p class="card-subtitle">
                                                            <i class="far fa-calendar-alt"></i>
                                                            For <span><?= date('d F, Y') ?></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card dashboard-card">
                                            <div class="card-header-custom">
                                                <h6 class="card-title">
                                                    <i class="fas fa-exchange-alt text-c-red"></i> Returns Revenue
                                                </h6>
                                            </div>
                                            <div class="card-body-custom">
                                                <div class="card-with-icon">
                                                    <div class="card-icon revenue">
                                                        <i class="fas fa-arrow-down"></i>
                                                    </div>
                                                    <div class="card-info">
                                                        <h4 class="card-value">
                                                            <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?>
                                                            <?= number_format($dailyReturnRevenue ?? 0, 2, '.', ',') ?>
                                                        </h4>
                                                        <p class="card-subtitle">
                                                            <i class="far fa-calendar-alt"></i>
                                                            For <span><?= date('d F, Y') ?></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card dashboard-card">
                                            <div class="card-header-custom">
                                                <h6 class="card-title">
                                                    <i class="fas fa-wallet text-c-red"></i> Daily Expenses
                                                </h6>
                                            </div>
                                            <div class="card-body-custom">
                                                <div class="card-with-icon">
                                                    <div class="card-icon revenue">
                                                        <i class="fas fa-arrow-down"></i>
                                                    </div>
                                                    <div class="card-info">
                                                        <h4 class="card-value">
                                                            <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?>
                                                            <?= number_format($dailyExpenses ?? 0, 2, '.', ',') ?>
                                                        </h4>
                                                        <p class="card-subtitle">
                                                            <i class="far fa-calendar-alt"></i>
                                                            For <span><?= date('d F, Y') ?></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Weekly Statistics -->
                        <div class="page-body">
                            <h4 class="text-dark text-center">Weekly Statistics</h4>
                            <div class="my-4">
                                <div class="row">
                                    <!-- Weekly Revenue -->
                                    <div class="col-md-4">
                                        <div class="card dashboard-card">
                                            <div class="card-header-custom">
                                                <h6 class="card-title">
                                                    <i class="fas fa-chart-line text-c-green"></i> Weekly Revenue
                                                </h6>
                                            </div>
                                            <div class="card-body-custom">
                                                <div class="card-with-icon">
                                                    <div class="card-icon revenue">
                                                        <i class="fas fa-arrow-up"></i>
                                                    </div>
                                                    <div class="card-info">
                                                        <h4 class="card-value">
                                                            <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?>
                                                            <?= number_format(
                                                                ($weeklyIncome ?? 0) 
                                                                - ($weeklyReturnProducts ?? 0) 
                                                                - ($weeklyCredit ?? 0) 
                                                                - ($weeklyExpenses ?? 0),
                                                                2, '.', ','
                                                            ) ?>
                                                        </h4>
                                                        <p class="card-subtitle">
                                                            <i class="far fa-calendar-alt"></i>
                                                            This Week
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Weekly Orders -->
                                    <div class="col-md-4">
                                        <div class="card dashboard-card">
                                            <div class="card-header-custom">
                                                <h6 class="card-title">
                                                    <i class="fas fa-shopping-bag text-c-red"></i> Weekly Orders
                                                </h6>
                                            </div>
                                            <div class="card-body-custom">
                                                <div class="card-with-icon">
                                                    <div class="card-icon revenue">
                                                        <i class="fas fa-arrow-up"></i>
                                                    </div>
                                                    <div class="card-info">
                                                        <h4 class="card-value"><?= $weeklyOrders ?? 0 ?></h4>
                                                        <p class="card-subtitle">
                                                            <i class="far fa-calendar-alt"></i>
                                                            This Week
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Weekly Credits -->
                                    <div class="col-md-4">
                                        <div class="card dashboard-card">
                                            <div class="card-header-custom">
                                                <h6 class="card-title">
                                                    <i class="fas fa-credit-card text-c-red"></i> Weekly Credits
                                                </h6>
                                            </div>
                                            <div class="card-body-custom">
                                                <div class="card-with-icon">
                                                    <div class="card-icon revenue">
                                                        <i class="fas fa-arrow-down"></i>
                                                    </div>
                                                    <div class="card-info">
                                                        <h4 class="card-value">
                                                            <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?>
                                                            <?= number_format($weeklyCredit ?? 0, 2, '.', ',') ?>
                                                        </h4>
                                                        <p class="card-subtitle">This Week</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Weekly Product Returns -->
                                    <div class="col-md-4">
                                        <div class="card dashboard-card">
                                            <div class="card-header-custom">
                                                <h6 class="card-title">
                                                    <i class="fas fa-undo text-c-red"></i> Product Returns
                                                </h6>
                                            </div>
                                            <div class="card-body-custom">
                                                <div class="card-with-icon">
                                                    <div class="card-icon revenue">
                                                        <i class="fas fa-box-open"></i>
                                                    </div>
                                                    <div class="card-info">
                                                        <h4 class="card-value"><?= $weeklyProductsReturned ?? 0 ?></h4>
                                                        <p class="card-subtitle">This Week</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Weekly Product Sales -->
                                    <div class="col-md-4">
                                        <div class="card dashboard-card">
                                            <div class="card-header-custom">
                                                <h6 class="card-title">
                                                    <i class="fas fa-shopping-cart text-c-blue"></i> Product Sales
                                                </h6>
                                            </div>
                                            <div class="card-body-custom">
                                                <div class="card-with-icon">
                                                    <div class="card-icon revenue">
                                                        <i class="fas fa-arrow-up"></i>
                                                    </div>
                                                    <div class="card-info">
                                                        <h4 class="card-value">
                                                            <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?>
                                                            <?= number_format($weeklyIncome ?? 0, 2, '.', ',') ?>
                                                        </h4>
                                                        <p class="card-subtitle">This Week</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Weekly Returns Revenue -->
                                    <div class="col-md-4">
                                        <div class="card dashboard-card">
                                            <div class="card-header-custom">
                                                <h6 class="card-title">
                                                    <i class="fas fa-exchange-alt text-c-red"></i> Returns Revenue
                                                </h6>
                                            </div>
                                            <div class="card-body-custom">
                                                <div class="card-with-icon">
                                                    <div class="card-icon revenue">
                                                        <i class="fas fa-arrow-down"></i>
                                                    </div>
                                                    <div class="card-info">
                                                        <h4 class="card-value">
                                                            <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?>
                                                            <?= number_format($weeklyReturnProducts ?? 0, 2, '.', ',') ?>
                                                        </h4>
                                                        <p class="card-subtitle">This Week</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Weekly Expenses -->
                                    <div class="col-md-4">
                                        <div class="card dashboard-card">
                                            <div class="card-header-custom">
                                                <h6 class="card-title">
                                                    <i class="fas fa-wallet text-c-red"></i> Weekly Expenses
                                                </h6>
                                            </div>
                                            <div class="card-body-custom">
                                                <div class="card-with-icon">
                                                    <div class="card-icon revenue">
                                                        <i class="fas fa-arrow-down"></i>
                                                    </div>
                                                    <div class="card-info">
                                                        <h4 class="card-value">
                                                            <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?>
                                                            <?= number_format($weeklyExpenses ?? 0, 2, '.', ',') ?>
                                                        </h4>
                                                        <p class="card-subtitle">This Week</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Monthly Statistics -->
                        <div class="page-body">
                            <h4 class="text-dark text-center">Monthly Statistics</h4>
                            <div class="my-4">
                                <div class="row">
                                    <!-- Monthly Revenue -->
                                    <div class="col-md-4">
                                        <div class="card dashboard-card">
                                            <div class="card-header-custom">
                                                <h6 class="card-title">
                                                    <i class="fas fa-chart-line text-c-green"></i> Monthly Revenue
                                                </h6>
                                            </div>
                                            <div class="card-body-custom">
                                                <div class="card-with-icon">
                                                    <div class="card-icon revenue">
                                                        <i class="fas fa-arrow-up"></i>
                                                    </div>
                                                    <div class="card-info">
                                                        <h4 class="card-value">
                                                            <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?>
                                                            <?= number_format(
                                                                ($monthlyIncome ?? 0)
                                                                - ($monthlyReturnProducts ?? 0)
                                                                - ($monthlyCredit ?? 0)
                                                                - ($monthlyExpenses ?? 0),
                                                                2, '.', ','
                                                            ) ?>
                                                        </h4>
                                                        <p class="card-subtitle">
                                                            <i class="far fa-calendar-alt"></i>
                                                            This Month
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Monthly Orders -->
                                    <div class="col-md-4">
                                        <div class="card dashboard-card">
                                            <div class="card-header-custom">
                                                <h6 class="card-title">
                                                    <i class="fas fa-shopping-bag text-c-red"></i> Monthly Orders
                                                </h6>
                                            </div>
                                            <div class="card-body-custom">
                                                <div class="card-with-icon">
                                                    <div class="card-icon revenue">
                                                        <i class="fas fa-arrow-up"></i>
                                                    </div>
                                                    <div class="card-info">
                                                        <h4 class="card-value"><?= $monthlyOrders ?? 0 ?></h4>
                                                        <p class="card-subtitle">This Month</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Monthly Credit -->
                                    <div class="col-md-4">
                                        <div class="card dashboard-card">
                                            <div class="card-header-custom">
                                                <h6 class="card-title">
                                                    <i class="fas fa-credit-card text-c-red"></i> Monthly Credit
                                                </h6>
                                            </div>
                                            <div class="card-body-custom">
                                                <div class="card-with-icon">
                                                    <div class="card-icon revenue">
                                                        <i class="fas fa-arrow-down"></i>
                                                    </div>
                                                    <div class="card-info">
                                                        <h4 class="card-value">
                                                            <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?>
                                                            <?= number_format($monthlyCredit ?? 0, 2, '.', ',') ?>
                                                        </h4>
                                                        <p class="card-subtitle">This Month</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Monthly Product Returns -->
                                    <div class="col-md-4">
                                        <div class="card dashboard-card">
                                            <div class="card-header-custom">
                                                <h6 class="card-title">
                                                    <i class="fas fa-undo text-c-red"></i> Product Returns
                                                </h6>
                                            </div>
                                            <div class="card-body-custom">
                                                <div class="card-with-icon">
                                                    <div class="card-icon revenue">
                                                        <i class="fas fa-box-open"></i>
                                                    </div>
                                                    <div class="card-info">
                                                        <h4 class="card-value"><?= $monthlyProductsReturned ?? 0 ?></h4>
                                                        <p class="card-subtitle">This Month</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Monthly Product Sales -->
                                    <div class="col-md-4">
                                        <div class="card dashboard-card">
                                            <div class="card-header-custom">
                                                <h6 class="card-title">
                                                    <i class="fas fa-shopping-cart text-c-blue"></i> Product Sales
                                                </h6>
                                            </div>
                                            <div class="card-body-custom">
                                                <div class="card-with-icon">
                                                    <div class="card-icon revenue">
                                                        <i class="fas fa-arrow-up"></i>
                                                    </div>
                                                    <div class="card-info">
                                                        <h4 class="card-value">
                                                            <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?>
                                                            <?= number_format($monthlyIncome ?? 0, 2, '.', ',') ?>
                                                        </h4>
                                                        <p class="card-subtitle">This Month</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Monthly Returns Revenue -->
                                    <div class="col-md-4">
                                        <div class="card dashboard-card">
                                            <div class="card-header-custom">
                                                <h6 class="card-title">
                                                    <i class="fas fa-exchange-alt text-c-red"></i> Returns Revenue
                                                </h6>
                                            </div>
                                            <div class="card-body-custom">
                                                <div class="card-with-icon">
                                                    <div class="card-icon revenue">
                                                        <i class="fas fa-arrow-down"></i>
                                                    </div>
                                                    <div class="card-info">
                                                        <h4 class="card-value">
                                                            <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?>
                                                            <?= number_format($monthlyReturnProducts ?? 0, 2, '.', ',') ?>
                                                        </h4>
                                                        <p class="card-subtitle">This Month</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Monthly Expenses -->
                                    <div class="col-md-4">
                                        <div class="card dashboard-card">
                                            <div class="card-header-custom">
                                                <h6 class="card-title">
                                                    <i class="fas fa-wallet text-c-red"></i> Monthly Expenses
                                                </h6>
                                            </div>
                                            <div class="card-body-custom">
                                                <div class="card-with-icon">
                                                    <div class="card-icon revenue">
                                                        <i class="fas fa-arrow-down"></i>
                                                    </div>
                                                    <div class="card-info">
                                                        <h4 class="card-value">
                                                            <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?>
                                                            <?= number_format($monthlyExpenses ?? 0, 2, '.', ',') ?>
                                                        </h4>
                                                        <p class="card-subtitle">This Month</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Yearly Statistics -->
                        <div class="page-body">
                            <h4 class="text-dark text-center">Yearly Statistics</h4>
                            <div class="my-4">
                                <div class="row">
                                    <!-- Yearly Revenue -->
                                    <div class="col-md-4">
                                        <div class="card dashboard-card">
                                            <div class="card-header-custom">
                                                <h6 class="card-title">
                                                    <i class="fas fa-chart-line text-c-green"></i> Yearly Revenue
                                                </h6>
                                            </div>
                                            <div class="card-body-custom">
                                                <div class="card-with-icon">
                                                    <div class="card-icon revenue">
                                                        <i class="fas fa-arrow-up"></i>
                                                    </div>
                                                    <div class="card-info">
                                                        <h4 class="card-value">
                                                            <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?>
                                                            <?= number_format(
                                                                ($yearlyIncome ?? 0)
                                                                - ($yearlyReturnProducts ?? 0)
                                                                - ($yearlyCredit ?? 0)
                                                                - ($yearlyExpenses ?? 0),
                                                                2, '.', ','
                                                            ) ?>
                                                        </h4>
                                                        <p class="card-subtitle">
                                                            <i class="far fa-calendar-alt"></i>
                                                            This Year
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Yearly Orders -->
                                    <div class="col-md-4">
                                        <div class="card dashboard-card">
                                            <div class="card-header-custom">
                                                <h6 class="card-title">
                                                    <i class="fas fa-shopping-bag text-c-red"></i> Yearly Orders
                                                </h6>
                                            </div>
                                            <div class="card-body-custom">
                                                <div class="card-with-icon">
                                                    <div class="card-icon revenue">
                                                        <i class="fas fa-arrow-up"></i>
                                                    </div>
                                                    <div class="card-info">
                                                        <h4 class="card-value"><?= $yearlyOrders ?? 0 ?></h4>
                                                        <p class="card-subtitle">This Year</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Yearly Credit -->
                                    <div class="col-md-4">
                                        <div class="card dashboard-card">
                                            <div class="card-header-custom">
                                                <h6 class="card-title">
                                                    <i class="fas fa-credit-card text-c-red"></i> Yearly Credit
                                                </h6>
                                            </div>
                                            <div class="card-body-custom">
                                                <div class="card-with-icon">
                                                    <div class="card-icon revenue">
                                                        <i class="fas fa-arrow-down"></i>
                                                    </div>
                                                    <div class="card-info">
                                                        <h4 class="card-value">
                                                            <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?>
                                                            <?= number_format($yearlyCredit ?? 0, 2, '.', ',') ?>
                                                        </h4>
                                                        <p class="card-subtitle">This Year</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Yearly Product Returns -->
                                    <div class="col-md-4">
                                        <div class="card dashboard-card">
                                            <div class="card-header-custom">
                                                <h6 class="card-title">
                                                    <i class="fas fa-undo text-c-red"></i> Product Returns
                                                </h6>
                                            </div>
                                            <div class="card-body-custom">
                                                <div class="card-with-icon">
                                                    <div class="card-icon revenue">
                                                        <i class="fas fa-box-open"></i>
                                                    </div>
                                                    <div class="card-info">
                                                        <h4 class="card-value"><?= $yearlyProductsReturned ?? 0 ?></h4>
                                                        <p class="card-subtitle">This Year</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Yearly Product Sales -->
                                    <div class="col-md-4">
                                        <div class="card dashboard-card">
                                            <div class="card-header-custom">
                                                <h6 class="card-title">
                                                    <i class="fas fa-shopping-cart text-c-blue"></i> Product Sales
                                                </h6>
                                            </div>
                                            <div class="card-body-custom">
                                                <div class="card-with-icon">
                                                    <div class="card-icon revenue">
                                                        <i class="fas fa-arrow-up"></i>
                                                    </div>
                                                    <div class="card-info">
                                                        <h4 class="card-value">
                                                            <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?>
                                                            <?= number_format($yearlyIncome ?? 0, 2, '.', ',') ?>
                                                        </h4>
                                                        <p class="card-subtitle">This Year</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Yearly Returns Revenue -->
                                    <div class="col-md-4">
                                        <div class="card dashboard-card">
                                            <div class="card-header-custom">
                                                <h6 class="card-title">
                                                    <i class="fas fa-exchange-alt text-c-red"></i> Returns Revenue
                                                </h6>
                                            </div>
                                            <div class="card-body-custom">
                                                <div class="card-with-icon">
                                                    <div class="card-icon revenue">
                                                        <i class="fas fa-arrow-down"></i>
                                                    </div>
                                                    <div class="card-info">
                                                        <h4 class="card-value">
                                                            <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?>
                                                            <?= number_format($yearlyReturnProducts ?? 0, 2, '.', ',') ?>
                                                        </h4>
                                                        <p class="card-subtitle">This Year</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Yearly Expenses -->
                                    <div class="col-md-4">
                                        <div class="card dashboard-card">
                                            <div class="card-header-custom">
                                                <h6 class="card-title">
                                                    <i class="fas fa-wallet text-c-red"></i> Yearly Expenses
                                                </h6>
                                            </div>
                                            <div class="card-body-custom">
                                                <div class="card-with-icon">
                                                    <div class="card-icon revenue">
                                                        <i class="fas fa-arrow-down"></i>
                                                    </div>
                                                    <div class="card-info">
                                                        <h4 class="card-value">
                                                            <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?>
                                                            <?= number_format($yearlyExpenses ?? 0, 2, '.', ',') ?>
                                                        </h4>
                                                        <p class="card-subtitle">This Year</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                         <!-- General Statistics -->
                        <div class="page-body">
                            <h4 class="text-dark text-center mb-4">General Statistics</h4>

                            <div class="row p-2 mt-4">

                                <!-- Total Workers -->
                                <div class="col-md-3 mt-3 py-4">
                                    <div class="kpi-card kpi-green">
                                        <div class="kpi-icon mb-5">
                                            <i class="far fa-user"></i>
                                        </div>
                                        <div class="kpi-content">
                                            <h3><?= $totalWorkers ?? 0 ?></h3>
                                            <p>Total Workers</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total Products -->
                                <div class="col-md-3 mt-3 py-4">
                                    <div class="kpi-card kpi-blue">
                                        <div class="kpi-icon mb-5">
                                            <i class="fas fa-boxes"></i>
                                        </div>
                                        <div class="kpi-content">
                                            <h3><?= $productsNumber ?? 0 ?></h3>
                                            <p>Total Products</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total Product Sales -->
                                <div class="col-md-3 mt-3 py-4">
                                    <div class="kpi-card kpi-purple">
                                        <div class="kpi-icon mb-5">
                                            <i class="fas fa-shopping-cart"></i>
                                        </div>
                                        <div class="kpi-content">
                                            <h3>
                                                <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?>
                                                <?= number_format($totalAmountSoldProducts ?? 0, 2, '.', ',') ?>
                                            </h3>
                                            <p>Total Product Sales</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total Income -->
                                <div class="col-md-3 mt-3 py-4">
                                    <div class="kpi-card kpi-yellow">
                                        <div class="kpi-icon mb-5">
                                            <i class="fas fa-chart-line"></i>
                                        </div>
                                        <div class="kpi-content">
                                            <h3>
                                                <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?>
                                                <?= number_format(
                                                    ($totalAmountSoldProducts ?? 0) - ($totalPurchaseCredit ?? 0),
                                                    2, '.', ','
                                                ) ?>
                                            </h3>
                                            <p>Total Income</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total Credit -->
                                <div class="col-md-3 mt-3 py-4">
                                    <div class="kpi-card kpi-red">
                                        <div class="kpi-icon mb-5">
                                            <i class="fas fa-arrow-down"></i>
                                        </div>
                                        <div class="kpi-content">
                                            <h3>
                                                <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?>
                                                <?= number_format($totalPurchaseCredit ?? 0, 2, '.', ',') ?>
                                            </h3>
                                            <p>Total Credit</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-12 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Product Price</h5>
                                    <span>Total Price of Available and Pending Products</span>
                                </div>
                                <div class="card-block">
                                    <div id="donut-example"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div id="styleSelector"> </div>
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
