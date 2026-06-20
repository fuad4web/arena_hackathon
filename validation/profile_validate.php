<?php
include '../core/init.php';

if (isset($_POST['profile'])) {

    $id             = $_POST['ida'];
    $name           = $_POST['name'];
    $email          = $_POST['email'];
    $alternate_pics = $_POST['alternate_pics'];
    $password       = $_POST['password'];
    $confirm        = $_POST['confirm_password'];

    $name  = $getFromU->checkInput($name);
    $email = $getFromU->checkInput($email);

    $data = [
        'fullname' => $name,
        'email'    => $email
    ];

    /* ===== Password Update ===== */
    if (!empty($password) || !empty($confirm)) {

        if ($password !== $confirm) {
            $_SESSION['status'] = "Passwords do not match";
            $_SESSION['code']   = "error";
            echo '<script>window.location.href="../profile"</script>';
            exit;
        }

        // Same hashing method as registration
        $data['password'] = md5($password);
    }

    /* ===== Profile Image Update ===== */
    if (isset($_FILES['profile_pics']) && !empty($_FILES['profile_pics']['name'])) {
        $profile_pics = $getFromU->cloudinaryUpload($_FILES['profile_pics'], 'profileImage');
        $data['profile_pics'] = $profile_pics;
    } else {
        $data['profile_pics'] = $alternate_pics;
    }

    /* ===== Update User ===== */
    $getFromU->update('user', $id, $data);

    $_SESSION['status'] = "Profile updated successfully";
    $_SESSION['code']   = "success";
    echo '<script>window.location.href="../profile"</script>';
}
