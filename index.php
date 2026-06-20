<?php   
    include 'core/init.php';
    $companyName = $getFromU->select_one_val('company_settings', 'name', 'id', 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katron App | Inventory Software</title>
    <!-- Favicon icon -->
    <link rel="icon" href="https://res.cloudinary.com/ddbk4vtwe/image/upload/v1766391915/IMG-20251222-WA0016-removebg-preview_l5tigj.png" type="image/png">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="assets/css/login.css">
    <!-- Notification.css -->
    <!-- <link rel="stylesheet" type="text/css" href="assets/pages/notification/notification.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Toastr Notification -->
    <link rel="stylesheet" type="text/css" href="assets/toastr/toastr.min.css">
</head>
<body>
    <div class="bg-circle c1"></div>
    <div class="bg-circle c2"></div>
    <div class="bg-circle c3"></div>

    <div class="container">
        <!-- <h2 style="position: fixed; top: 120px;"><?= $companyName ?></h2> -->
        <div class="login-wrapper">

        <div class="login-card">

            <div class="logo-area">
                <img src="https://res.cloudinary.com/ddbk4vtwe/image/upload/v1766391915/IMG-20251222-WA0016-removebg-preview_l5tigj.png" alt="Logo">

                <h2><?= $companyName ?></h2>
                <p>Inventory Management Software</p>
            </div>

            <?php
                echo SuccessMessage();
                echo ErrorMessage();
            ?>

            <form method="POST" action="validation/login_valid" id="loginForm">

                <div class="input-group-custom">
                    <input type="email" name="email" required>
                    <label>Email Address</label>
                    <!-- <i class="bi bi-envelope-fill"></i> -->
                </div>

                <div class="input-group-custom password-box">

                    <input type="password" id="password" name="password" required>

                    <label>Password</label>

                    <span id="togglePassword">
                        👁️
                    </span>

                </div>

                <button type="submit" name="login" class="login-btn">
                    Login Now
                </button>

            </form>

        </div>

    </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="assets/js/bootstrap-growl.min.js"></script>
    <script type="text/javascript" src="assets/pages/notification/notification.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Function to show SweetAlert messages based on session variables
        document.addEventListener('DOMContentLoaded', function() {
            <?php if(isset($_SESSION['status'])): ?>
                Swal.fire({
                    icon: '<?php echo $_SESSION['code']; ?>',
                    title: '<?php echo $_SESSION['status']; ?>',
                    showConfirmButton: true,
                    timer: 3000
                });
                
                <?php 
                    // Clear the session messages after showing
                    unset($_SESSION['status']);
                    unset($_SESSION['code']);
                ?>
            <?php endif; ?>
        });
    </script>

    <script>
        const togglePassword =
        document.querySelector("#togglePassword");

        const password =
        document.querySelector("#password");

        togglePassword.addEventListener("click", function(){

            const type =
            password.getAttribute("type") === "password"
            ? "text"
            : "password";

            password.setAttribute("type", type);

            this.textContent =
            type === "password"
            ? "👁️"
            : "🙈";

        });
    </script>
</body>
</html>
