<?php
include '../core/init.php';

if (isset($_POST['product'])) {
    // required helper / global objects
    $user_id = $_SESSION['id'] ?? null;

    // Read + sanitize raw inputs (we'll call checkInput later for final cleaning)
    $raw = [
        'name'          => $_POST['name'] ?? '',
        'barcode'       => $_POST['barcode'] ?? null,
        'price'         => $_POST['price'] ?? '0',
        'special_price' => $_POST['special_price'] ?? null,
        'market_price'  => $_POST['market_price'] ?? null,
        'is_pack'       => $_POST['is_pack'] ?? 0,
        'pack_size'     => $_POST['pack_size'] ?? null,
        'branch_id'     => $_POST['branch_id'] ?? null,
        'status'        => $_POST['status'] ?? 'active',
        'quantity'      => $_POST['quantity'] ?? 0,
        'category'      => $_POST['category'] ?? null,
        'distributor'   => $_POST['distributor'] ?? null,
        'description'   => $_POST['description'] ?? null,
    ];

    // basic server-side validation
    $errors = [];

    // required: name and price and quantity (you previously required several; adjust as needed)
    if (trim($raw['name']) === '')        $errors[] = 'Product name is required.';
    if (!is_numeric($raw['price']))       $errors[] = 'Valid product price is required.';
    if (!is_numeric($raw['quantity']))    $errors[] = 'Valid product quantity is required.';
    if (!is_numeric($raw['is_pack']))     $raw['is_pack'] = intval($raw['is_pack']) ? 1 : 0;

    // if product is pack, pack_size must be provided and > 0
    if (intval($raw['is_pack']) === 1) {
        if (!is_numeric($raw['pack_size']) || intval($raw['pack_size']) <= 0) {
            $errors[] = 'Pack size must be a positive number when product is marked as packed.';
        }
    } else {
        // ensure pack_size is null for single products
        $raw['pack_size'] = null;
    }

    // if any validation failed, send message and redirect
    if (count($errors) > 0) {
        $_SESSION['status'] = implode(' ', $errors);
        $_SESSION['code'] = 'danger';
        echo '<script>window.location.href="../create_product"</script>';
        exit;
    }

    // sanitize inputs using your helper
    $name          = $getFromU->checkInput(trim($raw['name']));
    $barcode       = $raw['barcode'] !== null ? $getFromU->checkInput(trim($raw['barcode'])) : null;
    $price         = $getFromU->checkInput($raw['price']);
    $special_price = $raw['special_price'] !== null ? $getFromU->checkInput($raw['special_price']) : null;
    $market_price  = $raw['market_price'] !== null ? $getFromU->checkInput($raw['market_price']) : null;
    $is_pack       = intval($getFromU->checkInput($raw['is_pack']));
    $pack_size     = $raw['pack_size'] !== null ? intval($getFromU->checkInput($raw['pack_size'])) : null;
    $branch_id     = $getFromU->checkInput($raw['branch_id']);
    $status        = $getFromU->checkInput($raw['status']);
    $quantity      = $getFromU->checkInput($raw['quantity']);
    $category      = $getFromU->checkInput($raw['category']);
    $distributor   = $getFromU->checkInput($raw['distributor']);
    $description   = $getFromU->checkInput($raw['description']);

    // generate unique short code (5 chars)
    $uniq = 'ab0cd1ef2gh3ij4kl5mn6opsdklhauioyq9ijio9uw9iojqwpouqw97qr8st9uvwx' . time() . bin2hex(random_bytes(3));
    $code = substr(str_shuffle($uniq), 0, 9);
    $code = $getFromU->checkInput($code);

    // uniqueness checks
    if ($getFromU->check_exist_one_col('products', 'name', $name) === true) {
        $_SESSION['status'] = "Product Name already exists";
        $_SESSION['code'] = "danger";
        echo '<script>window.location.href="../create_product"</script>';
        exit;
    }

    if (!empty($barcode) && $getFromU->check_exist_one_col('products', 'barcode', $barcode) === true) {
        $_SESSION['status'] = "Barcode already used";
        $_SESSION['code'] = "danger";
        echo '<script>window.location.href="../create_product"</script>';
        exit;
    }

    // determine Wholesale Price fallback: use market_price if provided otherwise use $price
    $market_price_to_store = $market_price !== null && $market_price !== '' ? $market_price : $price;

    // prepare product data arrays (reused for market_products)
    $productData = [
        'branch_id'     => $branch_id,
        'name'          => $name,
        'barcode'       => $barcode,
        'price'         => $price,
        'market_price' => $market_price_to_store,
        'special_price' => $special_price,
        'code'          => $code,
        'status'        => $status,
        'quantity'      => $quantity,
        'is_pack'       => $is_pack,
        'pack_size'     => $pack_size,
        'category'      => $category,
        'distributor'   => $distributor,
        'description'   => $description,
    ];

    $marketData = [
        'branch_id'   => $branch_id,
        'name'        => $name,
        'barcode'     => $barcode,
        'price'       => $market_price_to_store,
        'code'        => $code,
        'quantity'    => $quantity,
        'category'    => $category,
        'distributor' => $distributor,
        'description' => $description,
    ];

    // handle optional file upload if present
    $uploadedProductPics = null;
    if (isset($_FILES['product_pics']) && !empty($_FILES['product_pics']['name'][0])) {
        // cloudinaryUpload should return a URL or public id depending on your implementation
        $uploadedProductPics = $getFromU->cloudinaryUpload($_FILES['product_pics'], 'productImage');
        if($uploadedProductPics) {
            // if upload succeeded, add to both arrays
            $productData['product_pics'] = $uploadedProductPics;
            $marketData['product_pics'] = $uploadedProductPics;
        } else {
            $_SESSION['status'] = $e->getMessage();
            $_SESSION['code'] = "danger";
            echo '<script>window.location.href="../create_product"</script>';
            exit;
        }
    }

    // Transaction-safe creation (if $getFromU supports it)
    $useTransaction = false;
    if (isset($getFromU) && method_exists($getFromU, 'beginTransaction') && method_exists($getFromU, 'commit') && method_exists($getFromU, 'rollback')) {
        try {
            $getFromU->beginTransaction();
            $useTransaction = true;
        } catch (\Throwable $ex) {
            $useTransaction = false;
        }
    }

    try {
        // create product
        $createProduct = $getFromU->create('products', $productData);

        if (!$createProduct) {
            // failed to insert product
            if ($useTransaction) $getFromU->rollback();
            $_SESSION['status'] = "Unable to create product (DB insert failed).";
            $_SESSION['code'] = "danger";
            echo '<script>window.location.href="../create_product"</script>';
            exit;
        }

        // create market_products entry; note: we store Wholesale Price separately
        $createMarket = $getFromU->create('market_products', $marketData);
        if (!$createMarket) {
            // optionally rollback product if market_products is required
            if ($useTransaction) $getFromU->rollback();
            // if you don't require market_products to be created, you can skip rollback and continue
            $_SESSION['status'] = "Product created but failed to create market_product record.";
            $_SESSION['code'] = "warning";
            echo '<script>window.location.href="../create_product"</script>';
            exit;
        }

        if ($useTransaction) $getFromU->commit();

        $_SESSION['status'] = "Product Created Successfully";
        $_SESSION['code'] = "success";
        echo '<script>window.location.href="../create_product"</script>';
        exit;

    } catch (\Throwable $e) {
        if ($useTransaction) {
            try { $getFromU->rollback(); } catch (\Throwable $inner) { /* ignore */ }
        }
        error_log('Exception while creating product: ' . $e->getMessage());
        $_SESSION['status'] = "An error occurred while creating product.";
        $_SESSION['code'] = "danger";
        echo '<script>window.location.href="../create_product"</script>';
        exit;
    }
}

?>
