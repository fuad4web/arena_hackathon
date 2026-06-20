
$(document).ready(function() {

     const fetchNotification = () => {
          $.ajax({
               url: './validation/fetchNotification.php',
               // data: {padi_id: padi_id},
               method: 'get',
               success:function(data){
                    $('.notification-box').html(data);
               },
               error:function(jqXHR, status, message){
                    console.error(message);
               }
          })
     };

     fetchNotification();

     setInterval(() => {
          fetchNotification();
     }, 5000);

     // $("window").keydown(function(e) {
     //      if(e.keycode == 13) {
     //           e.preventDefault();
     //           return false;
     //      }
     // });
     
     $('#return_barcode').click(function () {
          var return_barcode = $("#return_product_barcode").val();
          var return_sales_type = $("#return_sales_type").val();
          // console.log(return_barcode, return_sales_type);

          $.ajax({
               url: "validation/returns_product.php",
               method: "POST",
               data: {
                    return_barcode: return_barcode,
                    return_sales_type: return_sales_type
               },
               success: function (data) {
                    // console.log(data);
                    $('#product_return_sales').html(data);
               }
          });
     });


     $("#ret_product").on("click, change", "#return_quantity", function() {
          "use strict";

          var row = $(this).closest("tr");
          var quantity = parseFloat(row.find("#return_quantity").val());
          var price = parseFloat(row.find("#return_price").val());
          var total = quantity * price;
          row.find("#return_total_price").val(isNaN(total) ? "" : total);
     });

});
