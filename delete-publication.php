<?php
session_start();
include_once './bdd/connexion.php';
$id_pub = htmlspecialchars($_POST['id_pub']);
$delete_publication_query = "DELETE FROM publications WHERE id_pub = '$id_pub'";
if (mysqli_query($conn, $delete_publication_query)) {
    $delete_publication_media_query = "DELETE FROM publications_media WHERE id_pub = '$id_pub'";
    if (mysqli_query($conn, $delete_publication_media_query)) {
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