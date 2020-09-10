<?php
session_start();
include_once './bdd/connexion.php';
$id_pub = htmlspecialchars($_POST['id_pub']);
$media_url = htmlspecialchars($_POST['media_url']);
$delete_preview_query = "DELETE FROM publications_media WHERE id_pub = '$id_pub' AND id_user = {$_SESSION['user']} AND media_url = '$media_url'";
if (mysqli_query($conn, $delete_preview_query)) {
    if (unlink($media_url)) {  
        echo 1;  
    }  
    else {  
        echo 0;  
    }
}
else {  
    echo 0;  
}  
?>