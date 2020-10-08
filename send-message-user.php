<?php 
session_start();
include_once './bdd/connexion.php';
$id_user = htmlspecialchars($_SESSION['user']);
$id_corresponder = htmlspecialchars($_POST['id_corresponder']);
$msgCle = htmlspecialchars($_POST['msgCle']);

$verify_cle_query = $conn->prepare("SELECT message_cle FROM messages_cles WHERE id_recever = $id_user AND id_sender = $id_corresponder OR id_recever = $id_corresponder AND id_sender = $id_user");
$verify_cle_query->execute();
if($verify_cle_query->rowCount() > 0){
    echo 2;
}
else{
    $message_cle_query = $conn->prepare("INSERT INTO messages_cles (id_recever,id_sender,message_cle) VALUES (:id_recever,:id_sender,:message_cle)");
    $message_cle_query->bindParam(':id_recever',$id_user);
    $message_cle_query->bindParam(':id_sender',$id_corresponder);
    $message_cle_query->bindParam(':message_cle',$msgCle);
    if ($message_cle_query->execute()) {
        echo 1;
    }
    else{
        echo 0;
    }
}
?>