<?php
    include '../core/init.php';

    if(isset($_POST['branch']) && !empty($_POST['name']) && !empty($_POST['idds'])) {

        $branch_name = $getFromU->checkInput($_POST['name']);
        $branch_slug = $getFromU->createSlug($branch_name);
        $idds = $_POST['idds'];

        $getFromU->update('branches', $idds, compact('branch_name', 'branch_slug'));
        $_SESSION['status'] = "Branch Updated Successfully";
        $_SESSION['code'] = "success";
        echo '<script>window.location.href="../branch"</script>';

    } else {
        $_SESSION['status'] = "Problem Somewhere, Try again later";
        $_SESSION['code'] = "danger";
        echo '<script>window.location.href="../branch"</script>';
    }

?>
