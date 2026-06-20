<?php
include '../core/init.php';

$selectDefaultCurrency = $getFromU->select_one_val('company_settings', 'currency', 'id', 1) ?? '$';
$currency = $getFromU->getCurrencySymbol($selectDefaultCurrency);

if (isset($_POST['first_value']) && isset($_POST['second_value'])) {
     $first_value = $_POST['first_value'];
     $second_value = $_POST['second_value'];

     $selected_two_dates_products = $getFromU->fetch_innerjoin_btw_values('product_purchase', 'user', 'user_id', $first_value, $second_value . ' 23:59:59', 'customers');

     $i = 0;
     $htmlo = '';

     foreach ($selected_two_dates_products as $selected_two_dates_product) {
          $i++;
          $branchName = $getFromU->select_one_val('branches', 'branch_name', 'id', $selected_two_dates_product->branch_id);

          $htmlo .= "<tr><th scope='row'>" . $i . "</th>
                    <td>" . $branchName . "</td>
                    <td>" . $selected_two_dates_product->trans_code . "</td>
                    <td>
                         <span class='text-sm'>" . $selected_two_dates_product->name . "</span><br>
                         <span class='text-sm'>" . $selected_two_dates_product->phone_number . "</span><br>
                         <span class='text-sm'>" . $selected_two_dates_product->address . "</span>
                    </td>
                    <td>" . $selected_two_dates_product->payment_mode . "</td>
                    <td><?= $currency) ?>" . @number_format($selected_two_dates_product->grand_total, 2, '.', ',') . "</td>
                    <td>" . $selected_two_dates_product->fullname . "</td>
                    <td><a href='" . BASE_URL . "'receipt?code=" . $selected_two_dates_product->trans_code . "'>
                         <input type='text' class='btn btn-outline-primary' value='Print Receipt'>
                    </a></td>
               </tr>";
     }

     echo $htmlo;
     exit();
}
