<?php
    include '../core/init.php';

    $getFromU->logout();
    if($getFromU->loggedIn() === false) {
        header('Location: '.BASE_URL.'');
        $_SESSION['status'] = "Succesfully Logout";
        $_SESSION['code'] = "success";
    }
