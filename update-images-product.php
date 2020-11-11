<?php
session_start();
include_once './bdd/connexion.php';
$id_session_btq = htmlspecialchars($_POST['id_btq']);
$get_session_btq_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session_btq' OR id_user_1 = '$id_session_btq' OR id_user_2 = '$id_session_btq' 
                                            OR id_user_3 = '$id_session_btq' OR id_user_4 = '$id_session_btq' OR id_user_5 = '$id_session_btq'");
$get_session_btq_query->execute();
$get_session_btq_row = $get_session_btq_query->fetch(PDO::FETCH_ASSOC);
$id_btq = $get_session_btq_row['id_user'];
$id_prd = htmlspecialchars($_POST['id_prd']);
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