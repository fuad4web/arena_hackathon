<?php
include '../core/init.php';

if(isset($_POST['category'])) {

  $name = $_POST['name'];
  $code = $_POST['code'];

     if(!empty($name) || !empty($phone_no)) {

          $name = $getFromU->checkInput($name);
          $code = $getFromU->checkInput($code);

          $getFromU->create('product_category', compact('name', 'code'));
          $_SESSION['status'] = "Category Created Successfully";
          $_SESSION['code'] = "success";
          echo '<script>window.location.href="../category"</script>';

     } else {
          $_SESSION['status'] = "Empty Value(s)";
          $_SESSION['code'] = "danger";
          echo '<script>window.location.href="../create_category"</script>';
     }
}

?>
