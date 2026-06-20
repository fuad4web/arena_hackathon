<?php
include '../core/init.php';

if(isset($_POST['register'])) {

  $fullname = $_POST['fullname'];
  $email = $_POST['email'];
  $status = $_POST['status'];
  $branch_id = $_POST['branch'];
  $passwords = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];

  if(!empty($fullname) || !empty($email) || !empty($passwords)) {

      $fullname = $getFromU->checkInput($fullname);
      $email = $getFromU->checkInput($email);
      $passwords = $getFromU->checkInput($passwords);
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['status'] = "Invalid Email Address";
        $_SESSION['code'] = "danger";
        echo '<script>window.location.href="../register"</script>';
      } else {
        
        if($getFromU->check_exist_one_col('user', 'email', $email) === true) {
          $_SESSION['status'] = "Email Address Already Used";
          $_SESSION['code'] = "danger";
          echo '<script>window.location.href="../register"</script>';
        } else {
          
          if($passwords !== $confirm_password) {
            $_SESSION['status'] = "Password didn't Match";
            $_SESSION['code'] = "danger";
            echo '<script>window.location.href="../register"</script>';
          } else {
            
            $password = md5($passwords);
            if(isset($_FILES['profile_pics'])) {
              if(!empty($_FILES['profile_pics']['name'][0])) {
                $profile_pics = $getFromU->cloudinaryUpload($_FILES['profile_pics'], 'profileImage');
                $getFromU->create('user', compact('fullname', 'email', 'profile_pics', 'password', 'status', 'branch_id'));
                $_SESSION['status'] = "Registration Successful";
                $_SESSION['code'] = "success";
                echo '<script>window.location.href="../dashboard"</script>';
              } else {
                $getFromU->create('user', compact('fullname', 'email', 'password', 'status', 'branch_id'));
                $_SESSION['status'] = "Registration Successful";
                $_SESSION['code'] = "success";
                echo '<script>window.location.href="../dashboard"</script>';
              }
            }

          }
            
         }
      }
  }
}

?>
