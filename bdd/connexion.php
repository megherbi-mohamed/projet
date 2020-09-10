<?php
    $serverName = 'localhost';
    $userName = 'root';
    $passWord = '';
    $dbName = 'projet';
   
    $conn = mysqli_connect($serverName,$userName,$passWord,$dbName);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>