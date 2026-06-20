<?php     
     include 'core/init.php';
     $mycode = $_GET['codes'];
     if(isset($mycode)) {
          $getFromU->delete('market_products', 'id', $mycode);
          $_SESSION['status'] = "Market Product Deleted Successfully";
          $_SESSION['code'] = "success";
          echo '<script>window.location.href="market_product"</script>';
     }
?>
