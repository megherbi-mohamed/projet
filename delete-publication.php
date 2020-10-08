<?php
session_start();
include_once './bdd/connexion.php';
$id_pub = htmlspecialchars($_POST['id_pub']);
$delete_publication_query = $conn->prepare("DELETE FROM publications WHERE id_pub = '$id_pub'");
if ($delete_publication_query->execute()) {
    $delete_publication_media_query = $conn->prepare("DELETE FROM publications_media WHERE id_pub = '$id_pub'");
    if ($delete_publication_media_query->execute()) {
        echo 1;
    }
    else{
        echo 0;
    }
}
else{
    echo 0;
}
?>