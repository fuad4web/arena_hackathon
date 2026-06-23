<?php
    include '../core/init.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $sourceBranch = (int) $_POST['source_branch_id'];
        $destinationBranch = (int) $_POST['destination_branch_id'];
        $productCode = $_POST['product_barcode'];
        $productBarcode = $_POST['product_barcode'];
        $transferQuantity = (int) $_POST['quantity'];

        if($sourceBranch === $destinationBranch) {
            $_SESSION['status'] = "You can\'t transfer to same Branch";
            $_SESSION['code'] = "danger";
            echo '<script>window.location.href="../transfer_product"</script>';
        }

        try {
            // Start a transaction
            $pdo->beginTransaction();

            // Fetch source product
            $stmt = $pdo->prepare("SELECT * FROM products WHERE branch_id = ? AND barcode = ?");
            $stmt->execute([$sourceBranch, $productBarcode]);
            $sourceProduct = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$sourceProduct || $sourceProduct['quantity'] < $transferQuantity) {
                $_SESSION['status'] = "Barcode Already Used";
                $_SESSION['code'] = "danger";
                echo '<script>window.location.href="../transfer_product"</script>';
            }

            // Deduct quantity from source branch
            $stmt = $pdo->prepare("UPDATE products SET quantity = quantity - ? WHERE branch_id = ? AND barcode = ?");
            $stmt->execute([$transferQuantity, $sourceBranch, $productCode]);

            // Check if product exists in destination branch
            $stmt = $pdo->prepare("SELECT * FROM products WHERE branch_id = ? AND barcode  = ?");
            $stmt->execute([$destinationBranch, $productBarcode]);
            $destinationProduct = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($destinationProduct) {
                // Update quantity for existing product
                $stmt = $pdo->prepare("UPDATE products SET quantity = quantity + ? WHERE branch_id = ? AND barcode = ?");
                $stmt->execute([$transferQuantity, $destinationBranch, $productCode]);
            } else {
                // Insert new product
                $stmt = $pdo->prepare("INSERT INTO products (branch_id, barcode, price, `status`, code, `name`, category, distributor, product_pics, `description`, quantity) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                // generate unique short code (5 chars)
                $uniq = '0123456789qwertyuioplkjhgfdsazxcvbnmsdghiudhbue7y378bw7' . time() . bin2hex(random_bytes(3));
                $code = substr(str_shuffle($uniq), 0, 9);
                $code = $getFromU->checkInput($code);

                $stmt->execute([$destinationBranch, $sourceProduct['barcode'], $sourceProduct['price'], $sourceProduct['status'], $code, $sourceProduct['name'], $sourceProduct['category'], $sourceProduct['distributor'], $sourceProduct['product_pics'], $sourceProduct['description'], $transferQuantity]);
            }

            // Commit transaction
            $pdo->commit();
            $_SESSION['status'] = "Product Transfered Successfully";
            $_SESSION['code'] = "success";
            echo '<script>window.location.href="../transfer_product"</script>';
        } catch (Exception $e) {
            $pdo->rollBack();
            $_SESSION['status'] = $e->getMessage();
            $_SESSION['code'] = "danger";
            echo '<script>window.location.href="../transfer_product"</script>';
        }
    }
?>
