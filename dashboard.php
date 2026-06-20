<?php
    include 'core/init.php';

    if($getFromU->loggedIn() !== true) {
        echo '<script>window.location.replace("'.BASE_URL.'validation/logout");</script>';
    }

    $user_id = $_SESSION['id'];
    $user = $getFromU->userData($user_id);

    if($user->status === 'staff') {
        echo '<script>window.location.replace("'.BASE_URL.'orders");</script>';
    } else echo '<script>window.location.replace("'.BASE_URL.'admin_dashboard");</script>';

?>
