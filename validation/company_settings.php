<?php
     include '../core/init.php';

     if(isset($_POST['settings'])) {
          $name = $_POST['name'];
          $phone_no = $_POST['phone_no'];
          $email = $_POST['email'];
          $sales_price_edit = $_POST['sales_price_edit'] ?? 'uneditable';
          $address = $_POST['address'];
          $currency = $_POST['currency'];
          $vat = $_POST['vat'];
          $receipt_footer = $_POST['receipt_footer'];

          if(!empty($name) || !empty($phone_no) || !empty($email) || !empty($address)) {

               $name = $getFromU->checkInput($name);
               $phone_no = $getFromU->checkInput($phone_no);
               $email = $getFromU->checkInput($email);
               $address = $getFromU->checkInput($address);
               $vat = $getFromU->checkInput($vat);
               $receipt_footer = $getFromU->checkInput($receipt_footer);
               $sales_price_edit = $getFromU->checkInput($sales_price_edit);

               if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
               $_SESSION['status'] = "Invalid Email Address";
               $_SESSION['code'] = "danger";
               echo '<script>window.location.href="../settings"</script>';
               } else {
                    $getFromU->update('company_settings', 1, compact('name', 'phone_no', 'email', 'sales_price_edit', 'address', 'currency', 'vat', 'receipt_footer'));
                    $_SESSION['status'] = "Updated Successfully";
                    $_SESSION['code'] = "success";
                    echo '<script>window.location.href="../settings"</script>';
               }
          } else {
               $_SESSION['status'] = "Empty Value(s)";
               $_SESSION['code'] = "danger";
               echo '<script>window.location.href="../settings"</script>';
          }
     }

?>
