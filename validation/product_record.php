<?php
     include '../core/init.php';

     $selectDefaultCurrency = $getFromU->select_one_val(
     'company_settings',
     'currency',
     'id',
     1
     ) ?? '$';

     $currency = $getFromU->getCurrencySymbol($selectDefaultCurrency);

     if (isset($_POST['first_value']) && isset($_POST['second_value'])) {

     $first_value = $_POST['first_value'] . ' 00:00:00';
     $second_value = $_POST['second_value'] . ' 23:59:59';

     $selected_two_dates_products =
          $getFromU->fetch_innerjoin_btw_values_record(
               'product_purchase',
               'user',
               'user_id',
               $first_value,
               $second_value,
               'customers'
          );

     $i = 0;
     $htmlo = '';

     foreach ($selected_two_dates_products as $row) {

          $i++;

          $branchName = $getFromU->select_one_val(
               'branches',
               'branch_name',
               'id',
               $row->branch_id
          );

          $htmlo .= "
               <tr>
                    <th scope='row'>{$i}</th>

                    <td>{$branchName}</td>

                    <td>{$row->trans_code}</td>

                    <td>
                         <span class='text-sm'>{$row->name}</span><br>
                         <span class='text-sm'>{$row->phone_number}</span><br>
                         <span class='text-sm'>{$row->address}</span>
                    </td>

                    <td>{$row->payment_mode}</td>

                    <td>"
                         . $currency .
                         number_format($row->grand_total, 2, '.', ',') .
                    "</td>

                    <td>{$row->fullname}</td>

                    <td>
                         <a href='" . BASE_URL . "receipt?code={$row->trans_code}'>
                         <button class='btn btn-outline-primary btn-sm'>
                              Print Receipt
                         </button>
                         </a>
                    </td>
               </tr>
          ";
     }

     echo $htmlo;
     exit();
     }
