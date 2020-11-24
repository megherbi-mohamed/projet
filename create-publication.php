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
$lieu_pub = htmlspecialchars($_POST['lieu_pub']);
$description_pub = htmlspecialchars($_POST['description_pub']);
$temp_pub =  date("Y-m-d h:i:sa");
$message_ntf = 'a ajouté(e) une nouvelle publication';
$date_ntf =  date("Y-m-d h:i:sa");
$type_ntf = 'publication';
$etat_ntf = 0;
$vu_ntf = ',';
$create_pub_query = $conn->prepare("UPDATE publications SET lieu_pub = '$lieu_pub', description_pub = '$description_pub', temp_pub = '$temp_pub',etat = 0, masquer_pub = 0, etat_commentaire = 0 WHERE id_pub = '$id_pub' AND id_user = $id_user");
$notification_query = $conn->prepare("INSERT INTO publications_notifications (id_pub,id_sender_ntf,id_recever_ntf,message_ntf,etat_ntf,vu_ntf,type_ntf,date_ntf) VALUES (:id_pub,:id_sender_ntf,:id_recever_ntf,:message_ntf,:etat_ntf,:vu_ntf,:type_ntf,:date_ntf)");
$notification_query->bindParam(':id_pub', $id_pub);
$notification_query->bindParam(':id_sender_ntf',$id_user);
$notification_query->bindParam(':id_recever_ntf',$id_user);
$notification_query->bindParam(':message_ntf',$message_ntf);
$notification_query->bindParam(':etat_ntf',$etat_ntf);
$notification_query->bindParam(':vu_ntf',$vu_ntf);
$notification_query->bindParam(':type_ntf',$type_ntf);
$notification_query->bindParam(':date_ntf',$date_ntf);

if ($create_pub_query->execute() && $notification_query->execute()) {
    $update_media_query = $conn->prepare("UPDATE publications_media SET etat = 0 WHERE id_pub = '$id_pub' AND id_user = $id_user");
    if ($update_media_query->execute()) {
        echo $id_pub;
    }
    else{
        echo 0;
    }
}
else{
    echo 0;
}
?>