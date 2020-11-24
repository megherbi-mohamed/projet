<?php
session_start();
include_once './bdd/connexion.php';
$id_pub = htmlspecialchars($_POST['id_pub']);
$delete_publication_query = $conn->prepare("DELETE FROM publications WHERE id_pub = $id_pub");
if ($delete_publication_query->execute()) {
    $get_publication_media_query = $conn->prepare("SELECT media_url FROM publications_media WHERE id_pub = $id_pub");
    if ($get_publication_media_query->execute()) {
        while ($get_publication_media_row = $get_publication_media_query->fetch(PDO::FETCH_ASSOC)) {
            unlink($get_publication_media_row['media_url']);
        }
        $delete_publication_media_query = $conn->prepare("DELETE FROM publications_media WHERE id_pub = $id_pub");
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
}
else{
    echo 0;
}
?>