<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_idSender_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_idSender_query->execute();
$get_session_idSender_row = $get_session_idSender_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_idSender_row['id_user'];
$id_prm = htmlspecialchars($_POST['id_prm']);
$add_promotion_participant_query = $conn->prepare("INSERT INTO promotions_participants (id_prm,id_user) VALUES (:id_prm,:id_user)");
$add_promotion_participant_query->bindParam(':id_prm', $id_prm);
$add_promotion_participant_query->bindParam(':id_user',$id_user);
$add_promotion_view_query = $conn->prepare("UPDATE promotions SET views_prm = views_prm + 1 WHERE id_prm = $id_prm");
if ($add_promotion_participant_query->execute() && $add_promotion_view_query->execute()) {
    echo 1;
}
else{
    echo 0;
}
?>