<?php
session_start();
include_once './bdd/connexion.php';
$id_pub = htmlspecialchars($_POST['id_pub']);
$like_pub_query = $conn->prepare("DELETE FROM jaime_publication WHERE id_pub = '$id_pub' AND id_user = {$_SESSION['user']}");
if ($like_pub_query->execute()) {
    echo 1;
}
else{
    echo 0;
}
?>