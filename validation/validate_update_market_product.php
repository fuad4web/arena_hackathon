<?php
include '../core/init.php';

if(isset($_POST['market_product'])) {

     $id = $_POST['market_id'];
     $price = $_POST['price'];
     $quantity = $_POST['quantity'];

     if(!empty($price) || !isset($quantity)) {

          $id = $getFromU->checkInput($id);
          $price = $getFromU->checkInput($price);
          $quantity = $getFromU->checkInput($quantity);

          $getFromU->update('market_products', $id, $fields = array('price' => $price, 'quantity' => $quantity));
          // $getFromU->update('market_products', $id, $fields = array('market_price' => $price));

          $_SESSION['status'] = "Market Product Updated Successfully";
          $_SESSION['code'] = "success";
          echo '<script>window.location.href="../market_product"</script>';
     }
}

?>
