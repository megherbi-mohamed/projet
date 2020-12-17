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
$delete_evn_query = $conn->prepare("DELETE FROM evenements WHERE id_evn = $id_evn AND id_user = $id_user AND etat = 1");
if ($delete_evn_query->execute()) {
    $get_evn_media_query = $conn->prepare("SELECT * FROM evenements_media WHERE id_evn = $id_evn");
    if($get_evn_media_query->execute()) {
        if ($get_evn_media_query->rowCount() > 0) {
            while($get_evn_media_row = $get_evn_media_query->fetch(PDO::FETCH_ASSOC)){
                if ($get_evn_media_row['etat'] == 1) {
                    $id_evn_m = $get_evn_media_row['id_evn_m'];
                    $delete_evn_media_query = $conn->prepare("DELETE FROM evenements_media WHERE id_evn = $id_evn AND id_evn_m = $id_evn_m");
                    if ($delete_evn_media_query->execute() && unlink($get_evn_media_row['media_url'])) {
                        echo 1;
                    }
                    else{
                        echo 0;
                        break;
                    }
                }
                else if ($get_evn_media_row['etat'] == 0 && $get_evn_media_row['etat_updt'] == 1) {
                    $id_evn_m = $get_evn_media_row['id_evn_m'];
                    $update_evn_media_query = $conn->prepare("UPDATE evenements_media SET etat_updt = 0 WHERE id_evn = $id_evn AND id_evn_m = $id_evn_m");
                    if ($update_evn_media_query->execute()) {
                        echo 1;
                    }
                    else{
                        echo 0;
                        break;
                    }
                }
                else{
                    echo 1;
                }
            }
        }
        else{
            echo 1;
        }
    }
    else{
        echo 0;
    }
}
else{
    echo 0;
}
?>