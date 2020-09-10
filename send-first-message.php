<?php
session_start();
include_once './bdd/connexion.php';

$num_msg_query = "SELECT * FROM messages WHERE id_recever = {$_SESSION['user']} AND id_sender = {$_SESSION['user-info']}
                    OR id_recever = {$_SESSION['user-info']} AND id_sender = {$_SESSION['user']}";
$num_msg_result = mysqli_query($conn,$num_msg_query);

if (mysqli_num_rows($num_msg_result) == 0) {
    $time = date('H:i:s');
    $send_msg_suery = "INSERT INTO messages (id_sender,id_recever,message,temp_msg,etat_msg) VALUES ({$row['id_user']},{$_GET['id_user']},'Cc','$time',1)";

    if (mysqli_query($conn,$send_msg_suery)) {
        # code...
    }
    // header('location: messagerie.php?user='.$_GET['id_user']);
}
else{
    // header('location: messagerie.php?user='.$_GET['id_user']);
}
?>