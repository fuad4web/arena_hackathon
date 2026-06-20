<?php 
    $dsn = 'mysql:host=localhost; dbname=shop';
    $user = 'root';
    $pass = '';

    try {
        $pdo = new PDO ($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo 'Connection error! ' . $e->getMessage();
        echo '<script>alert("Database Connection Error");</script>';
    }
