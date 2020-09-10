<?php
session_start();
include_once './bdd/connexion.php';
$id_sender = htmlspecialchars($_POST['id_sender']);
$id_user = htmlspecialchars($_POST['id_user']);
// $updt_sender_msg_query = "UPDATE  messages
// SET etat_sender_msg = IF(id_recever = $id_user AND id_sender = $id_sender, etat_sender_msg = 0, etat_sender_msg),
// etat_recever_msg = IF(id_recever = $id_sender AND id_sender = $id_user, etat_recever_msg = 0, etat_recever_msg)
// WHERE id_recever = $id_user AND id_sender = $id_sender OR id_recever = $id_sender AND id_sender = $id_user";
// if (mysqli_query($conn, $updt_sender_msg_query)) {
//     echo 1;
// }else{
//     echo 0;
// }

// $updt_sender_msg_query = "UPDATE messages SET etat_recever_msg = 0 WHERE id_recever = $id_sender AND id_sender = $id_user";

$updt_recever_msg_query = "UPDATE messages SET etat_sender_msg = 0 WHERE id_recever = $id_user AND id_sender = $id_sender";
// if (mysqli_query($conn, $updt_sender_msg_query)) {
    if (mysqli_query($conn, $updt_recever_msg_query)) {
        echo 1;
    }else{
        echo 0;
    }
// }else{
//     echo 0;
// }
?>