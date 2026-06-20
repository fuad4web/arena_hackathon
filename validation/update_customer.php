<?php
    include '../core/init.php';

    if (isset($_POST['update_customer'])) {
        $id      = $_POST['customer_id'];
        $name    = $_POST['name'];
        $status  = $_POST['status'];
        $phone   = $_POST['phone_number'];
        $address = $_POST['address'];

        $name         = $getFromU->checkInput($name);
        $status       = $getFromU->checkInput($status);
        $phone_number = $getFromU->checkInput($phone);
        $address      = $getFromU->checkInput($address);

        // Update using your method
        $updateCustomer = $getFromU->update('customers', $id, compact('name', 'status', 'phone_number', 'address'));

        // Redirect or show success
        $_SESSION['status'] = "Customer Successfully Updated";
        $_SESSION['code'] = "success";
        echo '<script>window.location.href="../customers"</script>';
    }
?>
