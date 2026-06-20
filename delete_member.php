<?php     
     include 'core/init.php';
     $mycode = $_GET['codes'];
     if(isset($mycode)) {
          $userId = $getFromU->select_one_val('user', 'id', 'email', $mycode);
          $getFromU->delete('user', 'id', $userId);
          $_SESSION['status'] = "User Deleted Successfully";
          $_SESSION['code'] = "success";
          echo '<script>window.location.href="staffs"</script>';
     }
?>
