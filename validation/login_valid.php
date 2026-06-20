<?php
include '../core/init.php';

    if(isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if(!empty($email) && !empty($password)) {
            $email = $getFromU->checkInput($email);
            $password = $getFromU->checkInput($password);

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['status'] = "Invalid Email Address";
                $_SESSION['code'] = "error";
                header('Location: ../');
                exit();
            } else {
                $loginResult = $getFromU->login($email, md5($password));
                
                if($loginResult === 'banned') {
                    $_SESSION['status'] = "You are banned from accessing your Account, reach out to the Admin";
                    $_SESSION['code'] = "error";
                    header('Location: ../');
                    exit();
                } elseif($loginResult === false) {
                    $_SESSION['status'] = "Incorrect Email or Password";
                    $_SESSION['code'] = "error";
                    header('Location: ../');
                    exit();
                } else {
                    // Check if user has a page assigned
                    if($loginResult === 'admin') {
                        $_SESSION['status'] = "Login Successful";
                        $_SESSION['code'] = "success";
                        echo '<script>window.location.replace("'.BASE_URL.'admin_dashboard");</script>';
                    } else {
                        // Check if route is valid (not 'nill' or empty)
                        if($loginResult === 'nill' || empty($loginResult) || $loginResult === false) {
                            // User doesn't have a page assigned
                            $_SESSION['status'] = "No page assigned to your account. Please contact administrator.";
                            $_SESSION['code'] = "error";
                            
                            // Destroy session to log user out
                            session_destroy();
                            
                            echo '<script>
                                Swal.fire({
                                    icon: "error",
                                    title: "No Page Assigned",
                                    text: "Your account does not have a page assigned. Please contact administrator.",
                                    showConfirmButton: true
                                }).then(() => {
                                    window.location.href = "../";
                                });
                            </script>';
                            exit();
                        } else {
                            $_SESSION['status'] = "Login Successful";
                            $_SESSION['code'] = "success";
                            echo '<script>window.location.replace("'.BASE_URL.''.$loginResult.'");</script>';
                        }
                    }
                }
            }
        } else {
            $_SESSION['status'] = "Fill in the Input Fields";
            $_SESSION['code'] = "error";
            header('Location: ../index');
            exit();
        }
    }
