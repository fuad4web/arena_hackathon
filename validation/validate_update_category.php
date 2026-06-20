<?php
include '../core/init.php';

if(isset($_POST['category'])) {

  $name = $_POST['name'];
  $code = $_POST['code'];
  $idds = $_POST['idds'];

     if(!empty($name) || !empty($phone_no)) {

          $name = $getFromU->checkInput($name);
          $code = $getFromU->checkInput($code);

          $getFromU->update('product_category', $idds, compact('name', 'code'));
          $_SESSION['status'] = "Category Updated Successfully";
          $_SESSION['code'] = "success";
          echo '<script>window.location.href="../category"</script>';

     } else {
          $_SESSION['ErrorMessage'] = "Empty Value(s)";
          echo '<script>window.location.href="../category"</script>';
     }
}

?>
