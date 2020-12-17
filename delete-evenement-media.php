<?php
include_once './bdd/connexion.php';
$id_evn = htmlspecialchars($_POST['id_evn']);
$media_url = htmlspecialchars($_POST['media_url']);
$delete_preview_query = $conn->prepare("UPDATE evenements_media SET etat_updt = 1 WHERE id_evn = $id_evn AND media_url = '$media_url'");
if ($delete_preview_query->execute()) {
    echo 1;
}
else {  
    echo 0;  
}  
?>