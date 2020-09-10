<?php
include_once './bdd/connexion.php';
$recever_session= mysqli_real_escape_string($conn, $_REQUEST['recever_session']);
$sender_session= mysqli_real_escape_string($conn, $_REQUEST['sender_session']);
$etat_msg_query = "UPDATE messages SET etat_msg = 0 WHERE id_recever = '$recever_session' AND id_sender = '$sender_session'";
mysqli_query($conn, $etat_msg_query);
?>