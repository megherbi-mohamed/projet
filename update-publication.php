<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_user_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_user_query->execute();
$get_session_user_row = $get_session_user_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_user_row['id_user'];
$id_pub = htmlspecialchars($_POST['id_pub']);
$lieu_pub = htmlspecialchars($_POST['lieu_pub']);
$description_pub = htmlspecialchars($_POST['description_pub']);
$update_pub_query = $conn->prepare("UPDATE publications SET lieu_pub = '$lieu_pub', description_pub = '$description_pub' WHERE id_pub = $id_pub AND id_user = $id_user");
if ($update_pub_query->execute()) {
    $get_pub_media_query = $conn->prepare("SELECT * FROM publications_media WHERE id_pub = $id_pub");
    if($get_pub_media_query->execute()) {
        while($get_pub_media_row = $get_pub_media_query->fetch(PDO::FETCH_ASSOC)){
            if (($get_pub_media_row['etat'] == 1 && $get_pub_media_row['etat_updt'] == 1) || ($get_pub_media_row['etat'] == 0 && $get_pub_media_row['etat_updt'] == 1)) {
                $id_pub_m = $get_pub_media_row['id_pub_m'];
                $delete_pub_media_query = $conn->prepare("DELETE FROM publications_media WHERE id_pub = $id_pub AND id_pub_m = $id_pub_m");
                if ($delete_pub_media_query->execute() && unlink($get_pub_media_row['media_url'])) {
                    echo 1;
                }
                else{
                    echo 0;
                    break;
                }
            }
            else if ($get_pub_media_row['etat'] == 1 && $get_pub_media_row['etat_updt'] == 0) {
                $id_pub_m = $get_pub_media_row['id_pub_m'];
                $update_pub_media_query = $conn->prepare("UPDATE publications_media SET etat = 0,etat_updt = 0 WHERE id_pub = $id_pub AND id_pub_m = $id_pub_m");
                if ($update_pub_media_query->execute()) {
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
        echo 0;
    }
}
else{
    echo 0;
}