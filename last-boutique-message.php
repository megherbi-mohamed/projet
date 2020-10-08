<?php
session_start();
include_once './bdd/connexion.php';
if (isset($_SESSION['boutique'])) {
    $msg_content_query =  $conn->prepare("SELECT id_btq,id_sender,message_text,date_format(message_time,'%H:%i') as message_time FROM boutique_messages WHERE id_m IN ( SELECT MAX(id_m) FROM boutique_messages WHERE id_btq = {$_SESSION['boutique']} AND id_sender = {$_SESSION['boutiqueCorrespondent']})");
    $msg_content_query->execute();
    $msg_content_row = $msg_content_query->fetch(PDO::FETCH_ASSOC);
}
?>
<div class="messagerie-message-sender">
    <p><?php echo $msg_content_row['message']; ?><span><?php echo $msg_content_row['temp_msg']; ?></span></p>
</div>