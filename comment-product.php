<?php
session_start();
include_once './bdd/connexion.php';
$id_sender_ntf = htmlspecialchars($_POST['id_user']);
$id_recever_ntf = htmlspecialchars($_POST['id_btq']);
$id_prd = htmlspecialchars($_POST['id_prd']);
$commentaire_text = htmlspecialchars($_POST['commentaire_text']);
$message_ntf = 'à commenté(e) votre produit';
$date_ntf =  date("Y-m-d h:i:sa");
$type_ntf = 'commentaire';
if ($id_sender_ntf == $id_recever_ntf) {
    $etat_ntf = 0;
}else{
    $etat_ntf = 1;
}
$comment_prd_query = $conn->prepare("INSERT INTO commentaires_produits (id_prd,id_user,commentaire_text) VALUES (:id_prd,:id_user,:commentaire_text)");
$comment_prd_query->bindParam(':id_prd', $id_prd);
$comment_prd_query->bindParam(':id_user',$id_sender_ntf);
$comment_prd_query->bindParam(':commentaire_text', $commentaire_text);

$notification_query = $conn->prepare("INSERT INTO publications_notifications (id_pub,id_sender_ntf,id_recever_ntf,message_ntf,etat_ntf,type_ntf,date_ntf) VALUES (:id_pub,:id_sender_ntf,:id_recever_ntf,:message_ntf,:etat_ntf,:type_ntf,:date_ntf)");
$notification_query->bindParam(':id_pub', $id_prd);
$notification_query->bindParam(':id_sender_ntf',$id_sender_ntf);
$notification_query->bindParam(':id_recever_ntf',$id_recever_ntf);
$notification_query->bindParam(':message_ntf',$message_ntf);
$notification_query->bindParam(':etat_ntf',$etat_ntf);
$notification_query->bindParam(':type_ntf',$type_ntf);
$notification_query->bindParam(':date_ntf',$date_ntf);

if ($comment_prd_query->execute() && $notification_query->execute()) {
    echo 1;
}
else{
    echo 0;
}
?>