<?php
session_start();
include_once './bdd/connexion.php';

$time = date('H:i:s');
$message= $_POST['message'];
if ($message !== '') {
    $insrt_msg_query = "INSERT INTO messages (id_sender,id_recever,message,temp_msg,etat_msg) VALUE ({$_SESSION['user']},{$_SESSION['senderinfo']},'$message','$time',1)";
    if(mysqli_query($conn,$insrt_msg_query)){
        echo 1;
    }
    else{
        echo 0;
    }
}

?>