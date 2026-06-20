<?php
include '../core/init.php';

    if (isset($_GET['branch_id'])) {
        $branchId = (int) $_GET['branch_id'];

        // Fetch products for the branch
        $stmt = $pdo->prepare("SELECT * FROM products WHERE branch_id = ?");
        $stmt->execute([$branchId]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($products);
    }
    // exit($htmlo);
