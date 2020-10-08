<?php
session_start();
include_once './bdd/connexion.php';
$id_user = htmlspecialchars($_SESSION['user']);
$delete_btq_query = $conn->prepare("DELETE FROM boutiques WHERE etat = 1 AND id_createur = '$id_user'");
if ($delete_btq_query->execute()) {
    echo 1;
}
else{
    echo 0;
}
?>