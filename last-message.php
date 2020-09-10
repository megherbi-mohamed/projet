<?php
    session_start();
    // $_SESSION['senderinfo'];
    include_once './bdd/connexion.php';

    if (isset($_SESSION['admin'])) {
        $cnx_user_query = "SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['admin'];
        $result = mysqli_query($conn, $cnx_user_query);
        $row = mysqli_fetch_assoc($result);
    }
    if (isset($_SESSION['sous-admin'])) {
        $cnx_user_query = "SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['sous-admin'];
        $result = mysqli_query($conn, $cnx_user_query);
        $row = mysqli_fetch_assoc($result);
    }
    if (isset($_SESSION['user'])) {
        $cnx_user_query = "SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['user'];
        $result = mysqli_query($conn, $cnx_user_query);
        $row = mysqli_fetch_assoc($result);

        $msg_content_query = "SELECT id_recever,id_sender,message,date_format(temp_msg,'%H:%i') as temp_msg FROM messages WHERE id_msg IN ( SELECT MAX(id_msg) FROM messages WHERE id_recever = {$row['id_user']} AND id_sender = {$_SESSION['senderinfo']})";
        $msg_content_result = mysqli_query($conn,$msg_content_query);
        $msg_content_row = mysqli_fetch_assoc($msg_content_result);
    }
?>

<div class="messagerie-message-sender">
    <p><?php echo $msg_content_row['message']; ?><span><?php echo $msg_content_row['temp_msg']; ?></span></p>
</div>