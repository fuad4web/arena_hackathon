
<?php
     include '../core/init.php';

     if(isset($_POST['valuess'])) {
          $barcode = $_POST['valuess'];
          $branch_id = $_SESSION['branch_id'];

          $fetchProducts = $getFromU->fetch_product_with_market_price($barcode, $branch_id);
               $i = 0;
               // exit(var_dump($fetchProducts));

          // $market_price = $getFromU->select_market_row($barcode, $branch_id);
          
          // Add Wholesale Price to product object
          // $fetchProducts->market_price = $market_price ? $market_price->price : null;
          
          // echo json_encode([$product]);
               
          echo json_encode($fetchProducts);
     }
?>
