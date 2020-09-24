<?php
session_start();
include_once './bdd/connexion.php';
$id_pub = htmlspecialchars($_POST['id_pub']);
$hide_publication_query = $conn->prepare("UPDATE publications SET masquer_pub = 1 WHERE id_pub = '$id_pub'");
if ($hide_publication_query->execute()) {
    echo 1;
}
else{
    echo 0;
}
?>