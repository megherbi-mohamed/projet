<?php
session_start();
include_once './bdd/connexion.php';
$id_user= htmlspecialchars($_SESSION['user']);
$id_pub = htmlspecialchars($_POST['id_pub']);
$save_publication_query = $conn->prepare("INSERT INTO publications_enregistres (id_pub,id_user) VALUES (:id_pub,:id_user)");
$save_publication_query->bindParam(':id_pub', $id_pub);
$save_publication_query->bindParam(':id_user',$id_user);
if ($save_publication_query->execute()) {
    echo 1;
}
else{
    echo 0;
}
?>