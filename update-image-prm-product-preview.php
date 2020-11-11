<?php
include_once './bdd/connexion.php';
$id_prd = htmlspecialchars($_POST['id_prd']);
$media_url = htmlspecialchars($_POST['media_url']);
$update_preview_query = $conn->prepare("DELETE FROM prm_produits_media WHERE id_prd = '$id_prd' AND media_url = '$media_url'");
if ($update_preview_query->execute()) {
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