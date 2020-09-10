<?php
session_start();
include_once './bdd/connexion.php';
$id_pub = htmlspecialchars($_POST['id_pub']);
$hide_publication_query = "UPDATE publications SET masquer_pub = 1 WHERE id_pub = '$id_pub'";
if (mysqli_query($conn, $hide_publication_query)) {
    echo 1;
}
else{
    echo 0;
}
?>