<?php
session_start();
include_once './bdd/connexion.php';
$id_pub = htmlspecialchars($_POST['id_pub']);
$id_user = htmlspecialchars($_SESSION['user']);
$remove_saved_publication_query = $conn->prepare("DELETE FROM publications_enregistres WHERE id_pub = '$id_pub' AND id_user = '$id_user'");
if ($remove_saved_publication_query->execute()) {
    echo 1;
}
else{
    echo 0;
}
?>