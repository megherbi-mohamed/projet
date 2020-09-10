<?php
session_start();
include_once './bdd/connexion.php';
$id_pub = htmlspecialchars($_POST['id_pub']);
$like_pub_query = "INSERT INTO jaime_publication (id_pub,id_user) VALUES ('$id_pub',{$_SESSION['user']})";
if (mysqli_query($conn, $like_pub_query)) {
    echo 1;
}
else{
    echo 0;
}
?>