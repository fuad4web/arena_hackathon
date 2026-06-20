<?php
include '../core/init.php';

if (isset($_POST['customer_name'])) {
    $customer_name = $_POST['customer_name'];
    $customerStatus = $getFromU->select_one_val('customers', 'status', 'name', $customer_name);

    if ($customerStatus) {
        exit($customerStatus);
    } else {
        exit('regular'); // Default to regular if not fod
    }
}
