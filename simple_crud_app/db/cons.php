<?php

    $host = 'localhost';
    $db = 'uts_pweb';
    $username = 'root';
    $pass = '';
    $charset = 'utf8mb4';
    
    /* Attempt to connect to MySQL database */
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    try{
        $pdo = new PDO($dsn, $username, $pass);
        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e){
        die("ERROR: Could not connect. " . $e->getMessage());
    }
    
?>