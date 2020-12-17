<?php
include_once './bdd/connexion.php';
$id_prd = htmlspecialchars($_POST['id_prd']);
$media_url = htmlspecialchars($_POST['media_url']);
$delete_preview_query = $conn->prepare("UPDATE produits_media SET etat_updt = 1 WHERE id_prd = $id_prd AND media_url = '$media_url'");
if ($delete_preview_query->execute()) {
    echo 1;  
}
else {  
    echo 0;  
} 
?>