<?php
include '../core/init.php';

if (isset($_POST['downloadPdf'])) {
     $first_date = $_POST['first_date'];
     $second_date = $_POST['second_date'];
     $formated_firstdate = (new DateTime($first_date))->format('jS F, Y');
     $formated_seconddate = (new DateTime($second_date))->format('jS F, Y');
     $fileName = 'record from '.$formated_firstdate.' to '.$formated_seconddate.'.pdf';
 
     $generatePdf = $getFromPdf->generatePdfFromDatabase('product_purchase', 'user', $first_date, $second_date . ' 23:59:59', $fileName);
     if($generatePdf) {
          $_SESSION['code'] = "success";
          $_SESSION['status'] = "PDF generated successfully!";
          echo '<script>window.location.href="../record"</script>';
     } else {
          $_SESSION['status'] = "Fail to Generate PDF, try again Later!";
          $_SESSION['code'] = "danger";
          echo '<script>window.location.replace("'.BASE_URL.'record");</script>';
     }
}
