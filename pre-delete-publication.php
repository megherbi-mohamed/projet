<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_idSender_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_idSender_query->execute();
$get_session_idSender_row = $get_session_idSender_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_idSender_row['id_user'];
$id_pub = htmlspecialchars($_POST['id_pub']);
$delete_pub_query = $conn->prepare("DELETE FROM publications WHERE etat = 1 AND id_user = $id_user");
if ($delete_pub_query->execute()) {
    $get_pub_media_query = $conn->prepare("SELECT * FROM publications_media WHERE id_pub = '$id_pub' AND etat = 1");
    if($get_pub_media_query->execute()) {
        while($get_pub_media_row = $get_pub_media_query->fetch(PDO::FETCH_ASSOC)){
            unlink($get_pub_media_row['media_url']);
        }
        $delete_pub_media_query = $conn->prepare("DELETE FROM publications_media WHERE id_user = $id_user AND id_pub = '$id_pub' AND etat = 1");
        if ($delete_pub_media_query->execute()) {
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