<?php
include '../core/init.php';

if(isset($_POST['distributor'])) {

  $ids = $_POST['ids'];
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
          echo '<script>window.location.href="../distributor"</script>';
          } else {
               $getFromU->update('distributors', $ids, compact('name', 'phone_no', 'email', 'address'));
               $_SESSION['status'] = "Distributor Updated Successfully";
               $_SESSION['code'] = "success";
               echo '<script>window.location.href="../distributor"</script>';
          }
     } else {
          $_SESSION['status'] = "Empty Value(s)";
          $_SESSION['code'] = "danger";
          echo '<script>window.location.href="../distributor"</script>';
     }
}

?>
