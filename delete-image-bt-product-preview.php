<?php
session_start();
include_once './bdd/connexion.php';
$id_user = htmlspecialchars($_SESSION['user']);
$id_prd = htmlspecialchars($_POST['id_prd']);
$media_url = htmlspecialchars($_POST['media_url']);
$delete_preview_query = $conn->prepare("DELETE FROM bt_produits_media WHERE id_prd = '$id_prd' AND id_user = '$id_user' AND media_url = '$media_url' AND etat = 1");
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