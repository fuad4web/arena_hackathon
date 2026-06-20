<?php     
     include 'core/init.php';
     $mycode = $_GET['nos'];
     if(isset($mycode)) {
          $getFromU->delete('distributors', 'id', $mycode);
          $_SESSION['status'] = "Distributor Deleted Successfully";
          $_SESSION['code'] = "success";
          echo '<script>window.location.href="distributor"</script>';
     }
?>
