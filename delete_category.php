<?php
     include 'core/init.php';
     $mycode = $_GET['codes'];
     if(isset($mycode)) {
          $getFromU->delete('product_category', 'code', $mycode);
          $_SESSION['status'] = "Category Deleted Successfully";
          $_SESSION['code'] = "success";
          echo '<script>window.location.href="category"</script>';
     }
?>
