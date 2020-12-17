<?php
include_once './bdd/connexion.php';
$id_prm = htmlspecialchars($_POST['id_prm']);
$media_url = htmlspecialchars($_POST['media_url']);
$delete_preview_query = $conn->prepare("UPDATE promotions_media SET etat_updt = 1 WHERE id_prm = $id_prm AND media_url = '$media_url'");
if ($delete_preview_query->execute()) {
    echo 1;
}
else {  
    echo 0;  
}  
?>