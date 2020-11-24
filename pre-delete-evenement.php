<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_user_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_user_query->execute();
$get_session_user_row = $get_session_user_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_user_row['id_user'];
$id_evn = htmlspecialchars($_POST['id_evn']);
$delete_evn_query = $conn->prepare("DELETE FROM evenements WHERE etat = 1 AND id_user = $id_user");
if ($delete_evn_query->execute()) {
    $get_evn_media_query = $conn->prepare("SELECT * FROM evenements_media WHERE id_evn = $id_evn AND etat = 1");
    if($get_evn_media_query->execute()) {
        while($get_evn_media_row = $get_evn_media_query->fetch(PDO::FETCH_ASSOC)){
            unlink($get_evn_media_row['media_url']);
        }
        $delete_evn_media_query = $conn->prepare("DELETE FROM evenements_media WHERE id_user = $id_user AND id_evn = $id_evn AND etat = 1");
        if ($delete_evn_media_query->execute()) {
            echo 1;
        }
        else{
            echo 0;
        }
    }else{
        echo 0;
    }
}
else{
    echo 0;
}
?>