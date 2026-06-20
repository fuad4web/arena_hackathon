<?php
include '../core/init.php';

     if(isset($_POST['keysearch'])) {
          $sea = $_POST['keysearch'];

          $search_all_product_names = $getFromU->search_all_one_cond('products', 'name', $sea);
          
          $impot = '';

          foreach($search_all_product_names as $search_all_product_name):
               $impot .= "<option value='".$search_all_product_name->name."'";
          endforeach;

          echo $impot;
     }

?>
