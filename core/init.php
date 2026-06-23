<?php
    session_start();
    use Core\Classes\PdfService;
    include 'database/connection.php';
    include 'classes/User.php';
    include 'classes/PdfService.php';

    global $pdo;

    $getFromU = new User($pdo);
    $getFromPdf = new PdfService($pdo);

    define("CLOUDINARY_NAME", "dodl3q3vr");
    define("CLOUDINARY_API_KEY", "897453696266978");
    define("CLOUDINARY_API_SECRET", "9c5IusyEnZqtWY3o-9eYoJCTKc8"); // adoxzy89@gmail.com

    define("BASE_URL", "http://localhost/vision/");
    date_default_timezone_set("Africa/Lagos");

    function SuccessMessage() {
        if (isset($_SESSION['SuccessMessage'])) {
            $message = htmlentities($_SESSION['SuccessMessage']);
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Toastr notification (existing)
                    toastr.success('$message', 'Success', {
                        positionClass: 'toast-top-right',
                        timeOut: 5000,
                        closeButton: true,
                        progressBar: true
                    });
                    
                    // SweetAlert notification (new addition)
                    Swal.fire({
                        title: 'Success!',
                        text: '$message',
                        icon: 'success',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                });
            </script>";
            unset($_SESSION['SuccessMessage']); // Clear session after displaying
        }
    }

    function ErrorMessage() {
        if (isset($_SESSION['ErrorMessage'])) {
            $message = htmlentities($_SESSION['ErrorMessage']);
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Toastr notification (existing)
                    toastr.error('$message', 'Error', {
                        positionClass: 'toast-top-right',
                        timeOut: 5000,
                        closeButton: true,
                        progressBar: true
                    });
                    
                    // SweetAlert notification (new addition)
                    Swal.fire({
                        title: 'Error!',
                        text: '$message',
                        icon: 'error',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                });
            </script>";
            unset($_SESSION['ErrorMessage']); // Clear session after displaying
        }
    }

    // Optional: Add warning and info message functions too
    function WarningMessage() {
        if (isset($_SESSION['WarningMessage'])) {
            $message = htmlentities($_SESSION['WarningMessage']);
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Toastr notification
                    toastr.warning('$message', 'Warning', {
                        positionClass: 'toast-top-right',
                        timeOut: 5000,
                        closeButton: true,
                        progressBar: true
                    });
                    
                    // SweetAlert notification
                    Swal.fire({
                        title: 'Warning!',
                        text: '$message',
                        icon: 'warning',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                });
            </script>";
            unset($_SESSION['WarningMessage']);
        }
    }

    function InfoMessage() {
        if (isset($_SESSION['InfoMessage'])) {
            $message = htmlentities($_SESSION['InfoMessage']);
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Toastr notification
                    toastr.info('$message', 'Info', {
                        positionClass: 'toast-top-right',
                        timeOut: 5000,
                        closeButton: true,
                        progressBar: true
                    });
                    
                    // SweetAlert notification
                    Swal.fire({
                        title: 'Info',
                        text: '$message',
                        icon: 'info',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                });
            </script>";
            unset($_SESSION['InfoMessage']);
        }
    }

    // function SuccessMessage() {
    //     if (isset($_SESSION['SuccessMessage'])) {
    //         $message = htmlentities($_SESSION['SuccessMessage']);
    //         echo "<script>
    //             document.addEventListener('DOMContentLoaded', function() {
    //                 Swal.fire({
    //                     title: 'Success!',
    //                     text: '$message',
    //                     icon: 'success',
    //                     confirmButtonText: 'OK'
    //                 });
    //             });
    //         </script>";
    //         unset($_SESSION['SuccessMessage']); // Clear session after displaying
    //     }
    // }
    
    // function ErrorMessage() {
    //     if (isset($_SESSION['ErrorMessage'])) {
    //         $message = htmlentities($_SESSION['ErrorMessage']);
    //         echo "<script>
    //             document.addEventListener('DOMContentLoaded', function() {
    //                 Swal.fire({
    //                     title: 'Error!',
    //                     text: '$message',
    //                     icon: 'error',
    //                     confirmButtonText: 'OK'
    //                 });
    //             });
    //         </script>";
    //         unset($_SESSION['ErrorMessage']); // Clear session after displaying
    //     }
    // }

    // function SuccessMessage() {
    //     if(isset($_SESSION['SuccessMessage'])) {
    //         $output = '<script type="text/javascript">$(function){swal("Success!","';
    //         $output.= htmlentities($_SESSION['SuccessMessage']);
    //         $output.= '","success")}</script>';
    //         $_SESSION['SuccessMessage'] = null;
    //         return $output;
    //     }
    // }

    
    // function ErrorMessage() {
    //     if(isset($_SESSION['ErrorMessage'])) {
    //         $output = '<div class="alert alert-danger" style="text-align: center; font-size: 16px;" role="alert">';
    //         $output.= htmlentities($_SESSION['ErrorMessage']);
    //         $output.= '</div>';
    //         $_SESSION['ErrorMessage'] = null;
    //         return $output;
    //     }
    // }
