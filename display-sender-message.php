<?php 
session_start();
include_once './bdd/connexion.php';
$_SESSION['senderinfo'] = $_GET['id_sender'];
$msg_content_query = "SELECT id_recever,id_sender,message,etat_msg,date_format(temp_msg,'%H:%i') as temp_msg FROM messages  WHERE id_recever = {$_SESSION['user']} AND id_sender = {$_GET['id_sender']}
OR id_recever = {$_GET['id_sender']} AND id_sender = {$_SESSION['user']}";
$msg_content_result = mysqli_query($conn,$msg_content_query);

$etat_msg_query = "UPDATE messages SET etat_msg = 0 WHERE id_recever = {$_SESSION['user']} AND id_sender = {$_SESSION['senderinfo']}";
mysqli_query($conn, $etat_msg_query);

?>
<div class="messagerie-message hide-scroll-bar" id="messagerie_message">
    <?php 
        while ($msg_content_row = mysqli_fetch_assoc($msg_content_result)) {
            if($msg_content_row['id_recever'] == $_SESSION['user']) { ?>
            <div class="messagerie-message-sender">
                <p><?php echo $msg_content_row['message']; ?><span><?php echo $msg_content_row['temp_msg']; ?></span></p>
            </div>
            <?php }else{
            $check_circle_active_far = '';
            $check_circle_active_fas = '';
            $fa_circle_active = '';
            if ($msg_content_row['etat_msg'] == 1) {
                $check_circle_active_far = 'check-circle-active';
                $fa_circle_active = '';
            }else{ $check_circle_active_fas = 'check-circle-active'; 
                $fa_circle_active = '';} ?> 
            <div class="messagerie-message-recever">
                <p><?php echo $msg_content_row['message']; ?></p>
                <span><?php echo $msg_content_row['temp_msg']; ?>
                    <div id="message_check">
                        <i class="far fa-check-circle <?php echo $check_circle_active_far; ?>"></i>
                        <i class="fas fa-check-circle <?php echo $check_circle_active_fas; ?>"></i>
                        <i class="far fa-circle <?php echo $fa_circle_active; ?>"></i>
                    </div>
                </span>
            </div>
    <?php }} ?>
</div>