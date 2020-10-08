<?php
session_start();
include_once './bdd/connexion.php';
$id_prd = htmlspecialchars($_POST['id_prd']);
$id_btq = htmlspecialchars($_POST['id_btq']);
$media_url = htmlspecialchars($_POST['media_url']);
$delete_preview_query = $conn->prepare("DELETE FROM produits_media WHERE id_prd = '$id_prd' AND id_btq = '$id_btq' AND media_url = '$media_url'");
if ($delete_preview_query->execute()) {
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