<?php
include '../core/init.php';

if (isset($_POST['product'])) {
    $user_id = $_SESSION['id'] ?? null;

    $raw = [
        'id'             => $_POST['id'] ?? null,
        'alternate_pics' => $_POST['alternate_pics'] ?? null,
        'name'           => $_POST['name'] ?? '',
        'barcode'        => $_POST['barcode'] ?? null,
        'price'          => $_POST['price'] ?? '0',
        'market_price'   => $_POST['market_price'] ?? null,
        'special_price'  => $_POST['special_price'] ?? null,
        'status'         => $_POST['status'] ?? 0,
        'quantity'       => $_POST['quantity'] ?? 0,
        'category'       => $_POST['category'] ?? null,
        'distributor'    => $_POST['distributor'] ?? null,
        'description'    => $_POST['description'] ?? null,
        'branch_id'      => $_POST['branch_id'] ?? null,
        'is_pack'        => $_POST['is_pack'] ?? 0,
        'pack_size'      => $_POST['pack_size'] ?? null,
    ];

    $errors = [];

    if (trim($raw['name']) === '')        $errors[] = 'Product name is required.';
    if (!is_numeric($raw['price']))       $errors[] = 'Valid product price is required.';
    if (!is_numeric($raw['quantity']))    $errors[] = 'Valid product quantity is required.';

    if (intval($raw['is_pack']) === 1) {
        if (!is_numeric($raw['pack_size']) || intval($raw['pack_size']) <= 0) {
            $errors[] = 'Pack size must be a positive number when product is marked as packed.';
        }
    } else {
        $raw['pack_size'] = null;
    }

    if (count($errors) > 0) {
        $_SESSION['status'] = implode(' ', $errors);
        $_SESSION['code'] = 'danger';
        echo '<script>window.location.href="../edit_product?id=' . $raw['id'] . '"</script>';
        exit;
    }

    // Sanitize
    $id             = $getFromU->checkInput($raw['id']);
    $name           = $getFromU->checkInput(trim($raw['name']));
    $barcode        = $raw['barcode'] !== null ? $getFromU->checkInput(trim($raw['barcode'])) : null;
    $price          = $getFromU->checkInput($raw['price']);
    $market_price   = $raw['market_price'] !== null ? $getFromU->checkInput($raw['market_price']) : $price;
    $special_price  = $raw['special_price'] !== null ? $getFromU->checkInput($raw['special_price']) : null;
    $status         = $getFromU->checkInput($raw['status']);
    $quantity       = $getFromU->checkInput($raw['quantity']);
    $category       = $getFromU->checkInput($raw['category']);
    $distributor    = $getFromU->checkInput($raw['distributor']);
    $description    = $getFromU->checkInput($raw['description']);
    $branch_id      = $getFromU->checkInput($raw['branch_id']);
    $is_pack        = intval($getFromU->checkInput($raw['is_pack']));
    $pack_size      = $raw['pack_size'] !== null ? intval($getFromU->checkInput($raw['pack_size'])) : null;

    // Get actual row IDs for update
    $product_id = $getFromU->selectOneColumnWithTwoConditionsNot('products', 'id', 'code', $id, 'branch_id', $branch_id);
    $market_id = $getFromU->selectOneColumnWithTwoConditionsNot('market_products', 'id', 'code', $id, 'branch_id', $branch_id);

    // File handling
    $product_pics = $raw['alternate_pics'];
    if (isset($_FILES['product_pics']) && !empty($_FILES['product_pics']['name'][0])) {
        // try {
            $product_pics = $getFromU->cloudinaryUpload($_FILES['product_pics'], 'productImage');
        // } catch (\Throwable $e) {
        //     $_SESSION['status'] = "Product image upload failed.";
        //     $_SESSION['code'] = "danger";
        //     echo '<script>window.location.href="../edit_product?id=' . $id . '"</script>';
        //     exit;
        // }
    }

    $productFields = [
        'name'          => $name,
        'barcode'       => $barcode,
        'price'         => $price,
        'market_price'  => $market_price,
        'special_price' => $special_price,
        'status'        => $status,
        'quantity'      => $quantity ?? null,
        'is_pack'       => $is_pack ?? null,
        'pack_size'     => $pack_size ?? 0,
        'category'      => $category,
        'distributor'   => $distributor,
        'product_pics'  => $product_pics,
        'description'   => $description,
    ];

    // $marketProductFields = [
    //     'name'          => $name,
    //     'barcode'       => $barcode,
    //     'quantity'      => $quantity,
    //     'price'         => $market_price,
    //     'category'      => $category,
    //     'distributor'   => $distributor,
    //     'product_pics'  => $product_pics,
    //     'description'   => $description,
    // ];

    // exit(var_dump($product_id, $productFields));

    try {
        $getFromU->update('products', $product_id, $productFields);
        // $getFromU->update('market_products', $market_id, $marketProductFields);

        $_SESSION['status'] = "Product Updated Successfully";
        $_SESSION['code'] = "success";
    } catch (Exception $e) {
        $_SESSION['status'] = "An error occurred while updating the product, " . $e->getMessage();
        $_SESSION['code'] = "danger";
    }

    echo '<script>window.location.href="../product";</script>';
    exit;
}
?>
