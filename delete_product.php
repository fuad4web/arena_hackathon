<?php     
     include 'core/init.php';
     $mycode = $_GET['codes'];
     if(isset($mycode)) {
          $getFromU->delete('products', 'code', $mycode);
          $getFromU->delete('market_products', 'code', $mycode);
          $_SESSION['status'] = "Product Deleted Successfully";
          $_SESSION['code'] = "success";
          echo '<script>window.location.href="product"</script>';
     }
?>
