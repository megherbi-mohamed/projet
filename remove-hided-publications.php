<?php
session_start();
include_once './bdd/connexion.php';
$id_pub = htmlspecialchars($_POST['id_pub']);
$remove_hide_publication_query = "UPDATE publications SET masquer_pub = 0 WHERE id_pub = '$id_pub'";
if (mysqli_query($conn, $remove_hide_publication_query)) {
    echo 1;
}
else{
    echo 0;
}
?>