<?php
session_start();
include_once './bdd/connexion.php';
$id_prd = htmlspecialchars($_POST['id_prd']);
$media_url = htmlspecialchars($_POST['media_url']);
$delete_preview_query = "DELETE FROM produits_media WHERE id_prd = '$id_prd' AND id_user = {$_SESSION['user']} AND media_url = '$media_url' AND etat = 1";
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