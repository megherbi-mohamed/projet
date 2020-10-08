<?php
session_start();
include_once './bdd/connexion.php';
$id_user = htmlspecialchars($_SESSION['user']);
$id_pub = htmlspecialchars($_POST['id_pub']);
$dislike_pub_query = $conn->prepare("DELETE FROM jaime_publication WHERE id_pub = '$id_pub' AND id_user = $id_user");
$delete_ntf_query = $conn->prepare("DELETE FROM publications_notifications WHERE id_pub = '$id_pub' AND id_sender_ntf = $id_user AND type_ntf = 'like'");
if ($dislike_pub_query->execute() && $delete_ntf_query->execute()) {
    echo 1;
}
else{
    echo 0;
}
?>