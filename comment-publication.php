<?php
session_start();
include_once './bdd/connexion.php';
$id_pub = htmlspecialchars($_POST['id_pub']);
$commentaire_text = htmlspecialchars($_POST['commentaire_text']);
$comment_pub_query = "INSERT INTO commentaire_publication (id_pub,id_user,commentaire_text) VALUES ('$id_pub',{$_SESSION['user']},'$commentaire_text')";
if (mysqli_query($conn, $comment_pub_query)) {
    echo 1;
}
else{
    echo 0;
}
?>