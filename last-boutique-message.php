<?php
    session_start();
    include_once './bdd/connexion.php';
    if (isset($_SESSION['boutique'])) {
        $msg_content_query = "SELECT id_btq,id_sender,message_text,date_format(message_time,'%H:%i') as message_time FROM boutique_messages WHERE id_m IN ( SELECT MAX(id_m) FROM boutique_messages WHERE id_btq = {$_SESSION['boutique']} AND id_sender = {$_SESSION['boutiqueCorrespondent']})";
        $msg_content_result = mysqli_query($conn,$msg_content_query);
        $msg_content_row = mysqli_fetch_assoc($msg_content_result);
    }
?>

<div class="messagerie-message-sender">
    <p><?php echo $msg_content_row['message']; ?><span><?php echo $msg_content_row['temp_msg']; ?></span></p>
</div>