<?php
    $serverName = 'localhost';
    $userName = 'root';
    $passWord = '';
    $dbName = 'projet';
    try {
        $conn = new PDO("mysql:host=$serverName;dbname=$dbName", $userName, $passWord);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     } catch (PDOException $e) {
        echo $e->getMessage();
     }
?>