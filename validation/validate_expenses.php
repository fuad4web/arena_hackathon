<?php
include '../core/init.php';

if(isset($_POST['expenses'])) {

     $user_id = $_SESSION['id'];
     $purpose = $_POST['purpose'];
     $branch_id = $_POST['branch_id'];
     $amount = $_POST['amount'];
     $remarks = $_POST['remarks'];
     $created_at = date('Y-m-d');
     $user = $getFromU->userData($user_id);

     if(!empty($purpose) || !empty($amount)) {
          $user_id = $getFromU->checkInput($user_id);
          $purpose = $getFromU->checkInput($purpose);
          $amount = $getFromU->checkInput($amount);
          $exp_branch_id = $getFromU->checkInput($branch_id);
          $remarks = $getFromU->checkInput($remarks);

          $exp_branch_id = ($user?->status == 'admin') ? $exp_branch_id : $user?->branch_id;

          $getFromU->create('expenses', compact('user_id', 'exp_branch_id', 'purpose', 'amount', 'remarks', 'created_at'));
          $_SESSION['status'] = "Expenses Created Successfully";
          $_SESSION['code'] = "success";
          echo '<script>window.location.href="../expenses"</script>';
     } else {
          $_SESSION['status'] = "One of the fields is empty";
          $_SESSION['code'] = "danger";
          echo '<script>window.location.href="../expenses"</script>';
     }
}
