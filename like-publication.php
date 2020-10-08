<?php
session_start();
include_once './bdd/connexion.php';
$id_sender_ntf = htmlspecialchars($_SESSION['user']);
$id_recever_ntf = htmlspecialchars($_POST['id_recever_ntf']);
$id_pub = htmlspecialchars($_POST['id_pub']);
$message_ntf = 'à aimé(e) votre publication';
$date_ntf =  date("Y-m-d h:i:sa");
$type_ntf = 'like';
if ($id_sender_ntf == $id_recever_ntf) {
    $etat_ntf = 0;
}else{
    $etat_ntf = 1;
}

$like_pub_query = $conn->prepare("INSERT INTO jaime_publication (id_pub,id_user) VALUES (:id_pub,:id_user)");
$like_pub_query->bindParam(':id_pub', $id_pub);
$like_pub_query->bindParam(':id_user',$id_sender_ntf);

$notification_query = $conn->prepare("INSERT INTO publications_notifications (id_pub,id_sender_ntf,id_recever_ntf,message_ntf,etat_ntf,type_ntf,date_ntf) VALUES (:id_pub,:id_sender_ntf,:id_recever_ntf,:message_ntf,:etat_ntf,:type_ntf,:date_ntf)");
$notification_query->bindParam(':id_pub', $id_pub);
$notification_query->bindParam(':id_sender_ntf',$id_sender_ntf);
$notification_query->bindParam(':id_recever_ntf',$id_recever_ntf);
$notification_query->bindParam(':message_ntf',$message_ntf);
$notification_query->bindParam(':etat_ntf',$etat_ntf);
$notification_query->bindParam(':type_ntf',$type_ntf);
$notification_query->bindParam(':date_ntf',$date_ntf);

if ($like_pub_query->execute() && $notification_query->execute()) {
    echo 1;
}
else{
    echo 0;
}
?>