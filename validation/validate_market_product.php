<?php
include '../core/init.php';

     if(isset($_POST['market_product'])) {

          $name = $_POST['name'];
          $barcode = $_POST['barcode'];
          $price = $_POST['price'];
          $code = $_POST['code'];
          $quantity = $_POST['quantity'];
          $category = $_POST['category'];
          $distributor = $_POST['distributor'];
          $description = $_POST['description'];

          if(!empty($name) || !empty($price) || !empty($quantity) || !empty($distributor) || !empty($description)) {

               $name = $getFromU->checkInput($name);
               $barcode = $getFromU->checkInput($barcode);
               $price = $getFromU->checkInput($price);
               $code = $getFromU->checkInput($code);
               $quantity = $getFromU->checkInput($quantity);
               $category = $getFromU->checkInput($category);
               $distributor = $getFromU->checkInput($distributor);
               $description = $getFromU->checkInput($description);

               if($getFromU->check_exist_one_col('market_products', 'name', $name) === true) {
                    $_SESSION['status'] = "Market Product Name Existing";
                    $_SESSION['code'] = "danger";
                    echo '<script>window.location.href="../create_market_product"</script>';
               } else {
                    if(!empty($barcode)) {
                         if($getFromU->check_exist_one_col('market_products', 'barcode', $barcode) === true) {
                              $_SESSION['ErrorMessage'] = "Barcode Already used";
                              echo '<script>window.location.href="../create_market_product"</script>';
                         } else {
                              if(isset($_FILES['product_pics'])) {
                                   if(!empty($_FILES['product_pics']['name'][0])) {
                                        $product_pics = $getFromU->cloudinaryUpload($_FILES['product_pics'], 'productImage');
                                        $getFromU->create('market_products', compact('name', 'barcode', 'price', 'code', 'quantity', 'category', 'distributor', 'product_pics', 'description'));
                                        $_SESSION['status'] = "Market Product Created Successfully";
                                        $_SESSION['code'] = "success";
                                        echo '<script>window.location.href="../create_market_product"</script>';
                                   } else {
                                        $getFromU->create('market_products', compact('name', 'barcode', 'price', 'code', 'quantity', 'category', 'distributor', 'description'));
                                        $_SESSION['status'] = "Market Product Created Successfully";
                                        $_SESSION['code'] = "success";
                                        echo '<script>window.location.href="../create_market_product"</script>';
                                   }
                              }
                         }
                    } else {
                         if(isset($_FILES['product_pics'])) {
                              if(!empty($_FILES['product_pics']['name'][0])) {
                                   $product_pics = $getFromU->cloudinaryUpload($_FILES['product_pics'], 'productImage');
                                   $getFromU->create('market_products', compact('name', 'barcode', 'price', 'code', 'quantity', 'category', 'distributor', 'product_pics', 'description'));
                                   $_SESSION['status'] = "Market Product Created Successfully";
                                   $_SESSION['code'] = "success";
                                   echo '<script>window.location.href="../create_market_product"</script>';
                              } else {
                                   $getFromU->create('market_products', compact('name', 'price', 'code', 'quantity', 'category', 'distributor', 'description'));
                                   $_SESSION['status'] = "Market Product Created Successfully";
                                   $_SESSION['code'] = "success";
                                   echo '<script>window.location.href="../create_market_product"</script>';
                              }
                         }
                    }
               }
          }
     }

?>
