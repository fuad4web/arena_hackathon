<?php

include '../core/init.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['distributor'])) {

    $name = trim($_POST['name'] ?? '');
    $phone_no = trim($_POST['phone_no'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');

    // Check for empty fields
    if (
        empty($name) ||
        empty($phone_no) ||
        empty($email)
    ) {

        $_SESSION['status'] = "All fields are required";
        $_SESSION['code'] = "danger";
        echo '<script>window.location.href="../create_distributor"</script>';
        exit();
    }

    // Sanitize inputs
    $name = $getFromU->checkInput($name);
    $phone_no = $getFromU->checkInput($phone_no);
    $email = $getFromU->checkInput($email);
    $address = $getFromU->checkInput($address) ?? null;

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $_SESSION['status'] = "Invalid Email Address";
        $_SESSION['code'] = "danger";
        echo '<script>window.location.href="../create_distributor"</script>';
        exit();
    }

    // Check if distributor email already exists
    if ($getFromU->check_exist_one_col('distributors', 'email', $email)) {

        $_SESSION['status'] = "Email Already Used";
        $_SESSION['code'] = "danger";
        echo '<script>window.location.href="../create_distributor"</script>';
        exit();
    }

    try {

        $result = $getFromU->create(
            'distributors',
            compact('name', 'phone_no', 'email', 'address')
        );

        if ($result) {

            $_SESSION['status'] = "Distributor Created Successfully";
            $_SESSION['code'] = "success";
            echo '<script>window.location.href="../distributor"</script>';
            exit();

        } else {

            $_SESSION['status'] = "Failed to create distributor";
            $_SESSION['code'] = "danger";
            echo '<script>window.location.href="../create_distributor"</script>';
            exit();
        }

    } catch (Exception $e) {

        $_SESSION['status'] = $e->getMessage();
        $_SESSION['code'] = "danger";
        echo '<script>window.location.href="../create_distributor"</script>';
        exit();
    }
}
