<?php
include_once './bdd/connexion.php';
$id_pub = htmlspecialchars($_POST['id_pub']);
$media_url = htmlspecialchars($_POST['media_url']);
$delete_preview_query = $conn->prepare("UPDATE publications_media SET etat_updt = 1 WHERE id_pub = $id_pub AND media_url = '$media_url'");
if ($delete_preview_query->execute()) {
    echo 1;  
}
else {  
    echo 0;  
} 
?>