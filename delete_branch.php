<?php     
     include 'core/init.php';
     $slug = $_GET['slug'];
     if(isset($slug)) {
          $getFromU->delete('branches', 'branch_slug', $slug);
          $_SESSION['status'] = "Branch Deleted Successfully";
          $_SESSION['code'] = "success";
          echo '<script>window.location.href="branch"</script>';
     } else {
        $_SESSION['status'] = "Problem Somewhere";
        $_SESSION['code'] = "danger";
        echo '<script>window.location.href="branch"</script>';
     }
?>
