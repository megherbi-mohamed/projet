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
$dislike_pub_query = $conn->prepare("DELETE FROM jaime_publication WHERE id_pub = '$id_pub' AND id_user = $id_user");
$delete_ntf_query = $conn->prepare("DELETE FROM publications_notifications WHERE id_pub = '$id_pub' AND id_sender_ntf = $id_user AND type_ntf = 'like'");
if ($dislike_pub_query->execute() && $delete_ntf_query->execute()) {
    echo 1;
}
else{
    echo 0;
}
?>