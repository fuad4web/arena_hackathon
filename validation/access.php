<?php
   include '../core/init.php';

   if(isset($_GET['user'])) {
      $userMail = $_GET['user'];
      $userId = $getFromU->select_one_val('user', 'id', 'email', $userMail);
      $userStatus = $getFromU->select_one_val('user', 'access', 'id', $userId);
      if($userStatus == true) {
         $access = 0;
            $getFromU->update('user', $userId, $fields = array('access' => $access));
            $_SESSION['status'] = "User deactivated Successfully";
            $_SESSION['code'] = "danger";
      } else {
         $access = 1;
         $getFromU->update('user', $userId, $fields = array('access' => $access));
         $_SESSION['status'] = "User Successfully Activated";
         $_SESSION['code'] = "success";
      }
      echo '<script>window.location.href="../staffs"</script>';
   }


   if (isset($_POST['debt']) && !empty($_POST['debtMoney'])) {
      $userCredit = (float) $_POST['debtMoney'];
      $transCode = $_POST['transCode'];
  
      // Retrieve transaction status
      $transStatus = $getFromU->select_all_val_row('product_purchase', 'trans_code', $transCode);
  
      if ($transStatus) {
          // Cast the credit property to a float for proper arithmetic comparison
          $transCredit = (float) $transStatus->credit;
  
          if ($userCredit >= $transCredit) {
              // Update payment mode to cash when debt is cleared
              $getFromU->update('product_purchase', $transStatus->id, [
                  'payment_mode' => 'cash',
              ]);
              $_SESSION['status'] = "Debt Cleared Successfully";
              $_SESSION['code'] = "success";
          } else {
              // Calculate the remaining amount and update the credit field
              $currAmount = $transCredit - $userCredit;
              $getFromU->update('product_purchase', $transStatus->id, [
                  'credit' => $currAmount,
              ]);
              $_SESSION['status'] = "Amount Paid Updated Successfully";
              $_SESSION['code'] = "success";
          }
      } else {
          $_SESSION['status'] = "Transaction not found.";
          $_SESSION['code'] = "error";
      }
      
      // Redirect to creditors page
      echo '<script>window.location.href="../creditors"</script>';
  }
  
