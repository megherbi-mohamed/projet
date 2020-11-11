<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_idSender_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_idSender_query->execute();
$get_session_idSender_row = $get_session_idSender_query->fetch(PDO::FETCH_ASSOC);
$id_sender_ntf = $get_session_idSender_row['id_user'];

$id_recever_ntf = htmlspecialchars($_POST['id_recever_ntf']);
$id_pub = htmlspecialchars($_POST['id_pub']);
$commentaire_text = htmlspecialchars($_POST['commentaire_text']);
$message_ntf = 'à commenté(e) votre publication';
$date_ntf =  date("Y-m-d h:i:sa");
$type_ntf = 'commentaire';
if ($id_sender_ntf == $id_recever_ntf) {
    $etat_ntf = 0;
}else{
    $etat_ntf = 1;
}
$comment_pub_query = $conn->prepare("INSERT INTO commentaire_publication (id_pub,id_user,commentaire_text) VALUES (:id_pub,:id_user,:commentaire_text)");
$comment_pub_query->bindParam(':id_pub', $id_pub);
$comment_pub_query->bindParam(':id_user',$id_sender_ntf);
$comment_pub_query->bindParam(':commentaire_text', $commentaire_text);

$notification_query = $conn->prepare("INSERT INTO publications_notifications (id_pub,id_sender_ntf,id_recever_ntf,message_ntf,etat_ntf,type_ntf,date_ntf) VALUES (:id_pub,:id_sender_ntf,:id_recever_ntf,:message_ntf,:etat_ntf,:type_ntf,:date_ntf)");
$notification_query->bindParam(':id_pub', $id_pub);
$notification_query->bindParam(':id_sender_ntf',$id_sender_ntf);
$notification_query->bindParam(':id_recever_ntf',$id_recever_ntf);
$notification_query->bindParam(':message_ntf',$message_ntf);
$notification_query->bindParam(':etat_ntf',$etat_ntf);
$notification_query->bindParam(':type_ntf',$type_ntf);
$notification_query->bindParam(':date_ntf',$date_ntf);

if ($comment_pub_query->execute() && $notification_query->execute()) {
    echo 1;
}
else{
    echo 0;
}
?>