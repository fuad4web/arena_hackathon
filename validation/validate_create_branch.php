<?php
include '../core/init.php';

    if(isset($_POST['branch']) && !empty($_POST['name'])) {

        $branch_name = $getFromU->checkInput($_POST['name']);
        $branch_slug = $getFromU->createSlug($branch_name);

        if($getFromU->check_exist_one_col('branches', 'branch_slug', $branch_slug) === true) {
            $_SESSION['status'] = "Branch Already Exist";
            $_SESSION['code'] = "danger";
            echo '<script>window.location.replace("'.BASE_URL.'create_branch");</script>';
        }

        $getFromU->create('branches', compact('branch_name', 'branch_slug'));
        $_SESSION['status'] = "Category Created Successfully";
        $_SESSION['code'] = "success";
        echo '<script>window.location.replace("'.BASE_URL.'branch");</script>';

    } else {
        $_SESSION['status'] = "Empty Value(s)";
        $_SESSION['code'] = "danger";
        echo '<script>window.location.replace("'.BASE_URL.'create_branch");</script>';
    }

?>
