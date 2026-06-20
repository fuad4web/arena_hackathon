
<?php

     // current date
     $cur_date = date('Y-m-d');

     // One week ago
     $oneWeekAgo = date('Y-m-d', strtotime('-1 week'));

     // One Month ago
     $oneMonthAgo = date('Y-m-d', strtotime('-1 month'));

     // One Year ago
     $oneYearAgo = date('Y-m-d', strtotime('-1 year'));
     // var_dump($oneMonthAgo);

     //selecting software informations
     $selectCompanyName = $getFromU->select_one_val('company_settings', 'name', 'id', 1);
     $selectCompanyMobile = $getFromU->select_one_val('company_settings', 'phone_no', 'id', 1);
     $selectCompanyEmail = $getFromU->select_one_val('company_settings', 'email', 'id', 1);
     $selectCompanyAddr = $getFromU->select_one_val('company_settings', 'address', 'id', 1);
     $selectCompanyReceiptFooter = $getFromU->select_one_val('company_settings', 'receipt_footer', 'id', 1);
     $selectCompanyVat = $getFromU->select_one_val('company_settings', 'vat', 'id', 1);
     $selectDefaultCurrency = $getFromU->select_one_val('company_settings', 'currency', 'id', 1) ?? '$';
     $companyPriceEditability = $getFromU->select_one_val('company_settings', 'sales_price_edit', 'id', 1) ?? 'uneditable';
     
     
     if(isset($_SESSION['branch_id'])) {
          $sessionBranch = $getFromU->select_one_val('branches', 'branch_name', 'id', $_SESSION['branch_id']);
     }

     // selecting all users infromations
     $select_all_employees = $getFromU->select_all_val_table_desc('user');

     // selecting all admins only
     $selectAdmins  = $getFromU->select_all_one_cond('user', 'status', 'admin');

     // selecting all staffs only
     $selectStaffs = $getFromU->select_all_one_cond('user', 'status', 'staff');

     // selecting all expenses purpose
     $selectExpenses = $getFromU->select_all_val_table_desc('expenses');

     // selecting all staffs only
     $selectBranchStaffs = $getFromU->fetch_innerjoin_one_cond('user', 'branches', 'branch_id', 'status', 'staff');
     
     // selecting all companies distributing products to companies
     $selectDistributors = $getFromU->select_all_val_table_desc('distributors');
     
     // sedlecting all categories of all products
     $selectCategories = $getFromU->select_all_val_table_desc('product_category');
     
     // sedlecting all categories of all products
     $selectBranches = $getFromU->select_all_val_table_desc('branches');
     
     // sedlecting all categories of all products
     // $selectCustomers = $getFromU->select_all_val_table_desc('customers');
     
     // selexct active pridcts for sale
     if($user?->status == 'staff') { $selectActiveProducts = $getFromU->select_all_three_cond_one_greater('products', 'status', '0', 'quantity', '1', 'branch_id', $user?->branch_id); } else {
          if (isset($_SESSION['branch_id'])) {
               $selectActiveProducts = $getFromU->select_all_three_cond_one_greater('products', 'status', '0', 'quantity', '1', 'branch_id', $_SESSION['branch_id']);
          } else { $selectActiveProducts = $getFromU->select_all_two_cond_one_greater('products', 'status', '0', 'quantity', '1'); }
     }
     
     // selecting all products in descending order
     if($user?->status == 'staff') { $selectProducts = $getFromU->select_all_one_cond_desc('products', 'branch_id', $user?->branch_id); } else { $selectProducts = $getFromU->select_all_val_table_desc('products'); }
     
     // selecting all market products in descending order
     $selectMarketProducts = $getFromU->select_all_val_table_desc('market_products');
     
     // selecting all customers in descending order
     if($user?->status == 'staff') { $selectCustomers = $getFromU->select_all_one_cond_desc('customers', 'branch_id', $user?->branch_id); } else { $selectCustomers = $getFromU->select_all_val_table_desc('customers'); }

     if(isset($_SESSION['branch_id'])) { 
          $branch_id = $_SESSION['branch_id'];
          $selectBranchCustomers = $getFromU->select_all_val_table_branch_desc('customers', $branch_id);
     } else {
          $branch_id = $user?->branch_id ?? null;
          $selectBranchCustomers = $getFromU->select_all_val_table_branch_desc('customers', $branch_id);
     }
     
     // selctiong all products purchased in descending order
     $list_my_products = $getFromU->fetch_innerjoin_one_cond('product_purchase', 'customers', 'customer_id', 'user_id', $user_id);

     // selctiong all products purchased in descending order
     $list_all_creditors = $getFromU->fetch_innerjoin_one_cond('product_purchase', 'customers', 'customer_id', 'payment_mode', 'creditor');

     // selctiong all expenses in descending order
     $fetch_all_expenses = $getFromU->fetch_innerjoin_desc('expenses', 'user', 'user_id');
     
     // daily sum of products puchased
     $mySumTotalProductsSold = $getFromU->sum_two_cond('product_purchase', 'grand_total', 'user_id', $user_id, 'created_at', $cur_date);
     
     // list 250 products under purchase
     $list_ordered_products = $getFromU->fetch_innerjoin_limit_desc('product_purchase', 'customers', 'customer_id');

     // selecting last transaction value
     $my_last_sale = $getFromU->select_last_val('product_purchase', 'trans_code', 'user_id', $user_id);

     // counting all products available
     $productsNumber = $getFromU->count_all_col('products', 'id');

     // sum all products purchased
     $totalProductsPrice = $getFromU->sum_all_column('products', 'price');

     // sum all products credit
     $totalPurchaseCredit = $getFromU->sum_all_column('product_purchase', 'credit');

     
     $countAvailableProducts = $getFromU->count_ono_cond('products', 'id', 'status', '0') ?? 0;
     $countUnavailableProducts = $getFromU->count_ono_cond('products', 'id', 'status', '1') ?? 0;
     $sumAvailableProducts = $getFromU->sum_column_one_cond('products', 'price', 'status', '0') ?? 0;
     $sumUnavailableProducts = $getFromU->sum_column_one_cond('products', 'price', 'status', '1') ?? 0;

     // daily revenue
     $dailyRevenue = $getFromU->sum_search_column_one_cond('product_purchase', 'grand_total', 'created_at', $cur_date) ?? 0;
     
     // daily credit
     $dailyCredit = $getFromU->sum_search_column_one_cond('product_purchase', 'credit', 'created_at', $cur_date) ?? 0;
     
     // daily expenses
     $dailyExpenses = $getFromU->sum_search_column_one_cond_exp('expenses', 'amount', 'created_at', $cur_date) ?? 0;
     
     // daily producty returned
     $dailyReturnRevenue = $getFromU->sum_search_column_one_cond('return_product', 'return_total_price', 'return_date', $cur_date) ?? 0;

     //daily orders
     $dailyOrders = $getFromU->count_one_cond('product_purchase', 'id', 'created_at', $cur_date) ?? 0;

     // daily prioduct returns
     $dailyReturns = $getFromU->count_one_cond('return_product', 'id', 'return_date', $cur_date) ?? 0;

     // net daily
     $netDaily = $dailyRevenue - $dailyReturnRevenue - $dailyCredit - $dailyExpenses;

     //Weekly Statistics
     //Weekly Income of Products Purchased
     $weeklyIncome = $getFromU->sum_between_two_cases('product_purchase', 'grand_total', 'created_at', $oneWeekAgo, $cur_date) ?? 0;
     
     //Weekly Income of Products Purchased
     $weeklyCredit = $getFromU->sum_between_two_cases('product_purchase', 'credit', 'created_at', $oneWeekAgo, $cur_date) ?? 0;
     
     //Weekly Income of Products Purchased
     $weeklyExpenses = $getFromU->sum_between_two_cases_exp('expenses', 'amount', 'created_at', $oneWeekAgo, $cur_date) ?? 0;

     // Weekly Return Revenue products
     $weeklyReturnProducts = $getFromU->sum_between_two_cases('return_product', 'return_total_price', 'return_date', $oneWeekAgo, $cur_date) ?? 0;
     
     //weekly orders
     $weeklyOrders = $getFromU->count_between_cases('product_purchase', 'id', 'created_at', $oneWeekAgo, $cur_date) ?? 0;
     
     //weekly orders
     $weeklyProductsReturned = $getFromU->count_between_cases('return_product', 'id', 'return_date', $oneWeekAgo, $cur_date) ?? 0;


     //Monthly Statistics
     //Monthly Income of Products Purchased
     $monthlyIncome = $getFromU->sum_between_two_cases('product_purchase', 'grand_total', 'created_at', $oneMonthAgo, $cur_date) ?? 0;
     
     //Monthly Income of Products Purchased
     $monthlyCredit = $getFromU->sum_between_two_cases('product_purchase', 'credit', 'created_at', $oneMonthAgo, $cur_date) ?? 0;
     
     //Monthly Income of Products Purchased
     $monthlyExpenses = $getFromU->sum_between_two_cases_exp('expenses', 'amount', 'created_at', $oneMonthAgo, $cur_date) ?? 0;

     // monthly Return Revenue products
     $monthlyReturnProducts = $getFromU->sum_between_two_cases('return_product', 'return_total_price', 'return_date', $oneMonthAgo, $cur_date) ?? 0;
     
     //monthly orders
     $monthlyOrders = $getFromU->count_between_cases('product_purchase', 'id', 'created_at', $oneMonthAgo, $cur_date) ?? 0;
     
     //monthly orders
     $monthlyProductsReturned = $getFromU->count_between_cases('return_product', 'id', 'return_date', $oneMonthAgo, $cur_date) ?? 0;


     //yearly Statistics
     //yearly Income of Products Purchased
     $yearlyIncome = $getFromU->sum_between_two_cases('product_purchase', 'grand_total', 'created_at', $oneYearAgo, $cur_date) ?? 0;
     
     //yearly Income of Products Purchased
     $yearlyCredit = $getFromU->sum_between_two_cases('product_purchase', 'credit', 'created_at', $oneYearAgo, $cur_date) ?? 0;
     
     //yearly Income of Products Purchased
     $yearlyExpenses = $getFromU->sum_between_two_cases_exp('expenses', 'amount', 'created_at', $oneYearAgo, $cur_date) ?? 0;

     // yearly Return Revenue products
     $yearlyReturnProducts = $getFromU->sum_between_two_cases('return_product', 'return_total_price', 'return_date', $oneYearAgo, $cur_date) ?? 0;
     
     //yearly orders
     $yearlyOrders = $getFromU->count_between_cases('product_purchase', 'id', 'created_at', $oneYearAgo, $cur_date) ?? 0;
     
     //yearly orders
     $yearlyProductsReturned = $getFromU->count_between_cases('return_product', 'id', 'return_date', $oneYearAgo, $cur_date) ?? 0;


     // total staffs
     $totalStaffs = $getFromU->count_one_cond('user', 'id', 'status', 'staff') ?? 0;
     
     // total workers including admins
     $totalWorkers = $getFromU->count_all_col('user', 'id') ?? 0;

     //select all prodyucts returned in desceneding order
     $products_returned = $getFromU->fetch_innerjoin_desc('return_product', 'products', 'product_id', 'product_id');
     // $products_returned = $getFromU->fetch_three_innerjoin_desc('return_product', 'products', 'customers', 'product_id', 'product_id');

     // sum all price in all the products in the store company
     $sumTotalProductsAmount = $getFromU->sum_all_multiplied_column('products', 'price', 'quantity') ?? 0;

     // sum all price in all the products returned in the store company
     $sumTotalProductsReturnedAmount = $getFromU->sum_all_column('return_product', 'return_total_price') ?? 0;

     // total products returned
     $totalProductsReturnedInStore = $getFromU->sum_all_column('return_product', 'return_quantity') ?? 0;

     // sum all price in all the market products in the store company
     $sumTotalMarketProductsAmount = $getFromU->sum_all_multiplied_column('market_products', 'price', 'quantity') ?? 0;

     // sum all price in all the products purchasedd in the store company
     $totalAmountSoldProducts = $getFromU->sum_all_column('product_purchase', 'grand_total') ?? 0;

     // total products
     $totalProductsInStore = $getFromU->sum_all_column('products', 'quantity') ?? 0;

     // total market prodcts
     $totalMarketProductsInStore = $getFromU->sum_all_column('market_products', 'quantity') ?? 0;

     $swaps = $getFromU->select_all_val_table_branch_desc('swaps', $branch_id);
?>
