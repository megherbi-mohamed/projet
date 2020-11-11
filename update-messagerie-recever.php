<?php
session_start();
include_once './bdd/connexion.php';
$idSender = htmlspecialchars($_POST['id_sender']);
$idUser = htmlspecialchars($_POST['id_user']);

$get_session_idSender_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$idSender' OR id_user_1 = '$idSender' OR id_user_2 = '$idSender' 
                                            OR id_user_3 = '$idSender' OR id_user_4 = '$idSender' OR id_user_5 = '$idSender'");
$get_session_idSender_query->execute();
$get_session_idSender_row = $get_session_idSender_query->fetch(PDO::FETCH_ASSOC);
$id_sender = $get_session_idSender_row['id_user'];

$get_session_idUser_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$idUser' OR id_user_1 = '$idUser' OR id_user_2 = '$idUser' 
                                            OR id_user_3 = '$idUser' OR id_user_4 = '$idUser' OR id_user_5 = '$idUser'");
$get_session_idUser_query->execute();
$get_session_idUser_row = $get_session_idUser_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_idUser_row['id_user'];

$updt_sender_msg_query = $conn->prepare("UPDATE messages SET etat_recever_msg = 0 WHERE id_recever = $id_user AND id_sender = $id_sender");
if ($updt_sender_msg_query->execute()) {
        echo 1;
 
}else{
    echo 0;
}
?>