<?php
session_start();
include_once './bdd/connexion.php';
$id_user = htmlspecialchars($_SESSION['user']);
$id_pub = htmlspecialchars($_POST['id_pub']);
$like_pub_query = $conn->prepare("INSERT INTO jaime_publication (id_pub,id_user) VALUES (:id_pub,:id_user)");
$like_pub_query->bindParam(':id_pub', $id_pub);
$like_pub_query->bindParam(':id_user',$id_user);
if ($like_pub_query->execute()) {
    echo 1;
}
else{
    echo 0;
}
?>