<?php
session_start();
include_once './bdd/connexion.php';
$id_user = htmlspecialchars($_SESSION['user']);
$id_pub = htmlspecialchars($_POST['id_pub']);
$commentaire_text = htmlspecialchars($_POST['commentaire_text']);
$comment_pub_query = $conn->prepare("INSERT INTO commentaire_publication (id_pub,id_user,commentaire_text) VALUES (:id_pub,:id_user,:commentaire_text)");
$comment_pub_query->bindParam(':id_pub', $id_pub);
$comment_pub_query->bindParam(':id_user',$id_user);
$comment_pub_query->bindParam(':commentaire_text', $commentaire_text);
if ($comment_pub_query->execute()) {
    echo 1;
}
else{
    echo 0;
}
?>