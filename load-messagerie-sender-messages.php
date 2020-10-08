<?php
session_start();
include_once './bdd/connexion.php';
$id_sender = htmlspecialchars($_POST['id_sender']);
$id_user = htmlspecialchars($_POST['id_user']);

$get_sender_msg_query = $conn->prepare("SELECT id_recever,id_sender,message,date_format(temp_msg,'%H:%i') as temp_msg FROM messages WHERE id_recever = '$id_user' AND id_sender = '$id_sender'
OR id_recever = '$id_sender' AND id_sender = '$id_user'");
$get_sender_msg_query->execute();

$get_sender_info_query = $conn->prepare("SELECT id_user AS id, nom_user AS nom, img_user AS img FROM utilisateurs WHERE id_user = $id_sender 
UNION SELECT id_btq AS id, nom_btq AS nom, logo_btq AS img FROM boutiques WHERE id_btq = $id_sender");
$get_sender_info_query->execute();
$get_sender_info_row = $get_sender_info_query->fetch(PDO::FETCH_ASSOC);
?>
<div class="messagerie-middle-top">
    <div id="display_list_chat_resp">
        <i class="fas fa-users"></i>
    </div>
    <div class="corresponder-info">
        <input type="hidden" id="id_corresponder" value="<?php echo $get_sender_info_row['id'] ?>">
        <?php if ($get_sender_info_row['img'] == '') { ?>
        <img src="./images/profile.png" alt="">
        <?php }else{ ?>
        <img src="<?php echo $get_sender_info_row['img'] ?>" alt="">
        <?php } ?>
        <h5><?php echo $get_sender_info_row['nom'] ?></h5>
    </div>
    <div id="display_corresponder_info">
        <i class="fas fa-info"></i>
    </div>
</div>
<div class="messagerie-middle-bottom" id="message_box">
<?php
while($get_sender_msg_row = $get_sender_msg_query->fetch(PDO::FETCH_ASSOC)){
    if ($get_sender_msg_row['id_recever'] == $id_user) { ?>
        <div class="message-right">
            <div>
                <p><?php echo $get_sender_msg_row['message'] ?></p>
            </div>
        </div>
    <?php }else{ ?>
        <div class="message-left">
            <div>    
                <p><?php echo $get_sender_msg_row['message'] ?></p>
            </div>
        </div>
    <?php } ?>
<?php } ?>
</div>
<div class="send-message-messagerie">
    <input type="text" id="message_text" placeholder="Ecriver un message ..">
    <div id="send_message_button">
        <img src="./icons/send-message-icon.png" alt="">
    </div>
</div>
<?php
$get_message_key_query = $conn->prepare("SELECT message_cle FROM messages_cles WHERE id_recever = '$id_user' AND id_sender = '$id_sender' OR id_recever = '$id_sender' AND id_sender = '$id_user'");
$get_message_key_query->execute();
$get_message_key_row = $get_message_key_query->fetch(PDO::FETCH_ASSOC);
?>
<input type="hidden" id="msgCle" value="<?php echo $get_message_key_row['message_cle']; ?>">
<?php
$verify_user_query = $conn->prepare("SELECT id_user FROM utilisateurs WHERE id_user = '$id_sender'");
$verify_user_query->execute();
if($verify_user_query->rowCount() > 0){
?>
<input type="hidden" id="type_messagerie" value="userUser">
<?php }else{ ?>
<input type="hidden" id="type_messagerie" value="boutiqueUser">
<?php } ?>
<input type="hidden" id="messagerie" value="messagerie">