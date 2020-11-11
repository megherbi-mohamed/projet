<?php 
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_idSender_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_idSender_query->execute();
$get_session_idSender_row = $get_session_idSender_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_idSender_row['id_user'];
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