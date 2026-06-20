<?php
include '../core/init.php';

if(isset($_POST['distributor'])) {

  $name = $_POST['name'];
  $phone_no = $_POST['phone_no'];
  $email = $_POST['email'];
  $address = $_POST['address'];

     if(!empty($name) || !empty($phone_no) || !empty($email) || !empty($address)) {

          $name = $getFromU->checkInput($name);
          $phone_no = $getFromU->checkInput($phone_no);
          $email = $getFromU->checkInput($email);
          $address = $getFromU->checkInput($address);

          if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $_SESSION['status'] = "Invalid Email Address";
          $_SESSION['code'] = "danger";
          echo '<script>window.location.href="../create_distributor"</script>';
          } else {
               if($getFromU->check_exist_one_col('user', 'email', $email) === true) {
                    $_SESSION['status'] = "Email Already Used";
                    $_SESSION['code'] = "danger";
                    echo '<script>window.location.href="../create_distributor"</script>';
               } else {
                    $getFromU->create('distributors', compact('name', 'phone_no', 'email', 'address'));
                    $_SESSION['status'] = "Distributor Created Successfully";
                    $_SESSION['code'] = "success";
                    echo '<script>window.location.href="../distributor"</script>';
               }
          }
     } else {
          $_SESSION['status'] = "Empty Value(s)";
          $_SESSION['code'] = "danger";
          echo '<script>window.location.href="../create_distributor"</script>';
     }
}

?>
