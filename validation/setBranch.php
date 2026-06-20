<?php
    include '../core/init.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['branch_id'])) {
        if (!empty($_POST['branch_id'])) {
            unset($_SESSION['branch_id']);
            $_SESSION['branch_id'] = $_POST['branch_id']; // Set the branch ID in session
        } else {
            unset($_SESSION['branch_id']); // Clear the branch filter for "All Branches"
        }
        
        // Reload the page to apply changes
        echo '<script>window.location.replace(document.referrer);</script>';
        // echo '<script>window.location.replace("'.BASE_URL.'admin_dashboard");</script>';
        exit;
    }
