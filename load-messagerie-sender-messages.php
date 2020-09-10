<?php
session_start();
include_once './bdd/connexion.php';
$id_sender = htmlspecialchars($_POST['id_sender']);
$id_user = htmlspecialchars($_POST['id_user']);
$get_sender_msg_query = "SELECT id_recever,id_sender,message,date_format(temp_msg,'%H:%i') as temp_msg FROM messages WHERE id_recever = '$id_user' AND id_sender = '$id_sender'
OR id_recever = '$id_sender' AND id_sender = '$id_user'";
$get_sender_msg_result = mysqli_query($conn, $get_sender_msg_query);

$get_sender_info_query = "SELECT id_user AS id, nom_user AS nom, img_user AS img FROM utilisateurs WHERE id_user = $id_sender 
UNION SELECT id_btq AS id, nom_btq AS nom, logo_btq AS img FROM boutiques WHERE id_btq = $id_sender";
$get_sender_info_result = mysqli_query($conn, $get_sender_info_query);
$get_sender_info_row = mysqli_fetch_assoc($get_sender_info_result);
?>
<div class="messagerie-middle-top">
    <div id="display_list_chat_resp">
        <i class="fas fa-users"></i>
    </div>
    <div class="corresponder-info">
        <input type="hidden" id="id_corresponder" value="<?php echo $get_sender_info_row['id'] ?>">
        <img src="<?php echo $get_sender_info_row['img'] ?>" alt="">
        <h5><?php echo $get_sender_info_row['nom'] ?></h5>
    </div>
    <div id="display_corresponder_info">
        <i class="fas fa-info"></i>
    </div>
</div>
<div class="messagerie-middle-bottom" id="message_box">
<?php
while($get_sender_msg_row = mysqli_fetch_assoc($get_sender_msg_result)){
    if ($get_sender_msg_row['id_recever'] == $id_user) { ?>
        <div class="message-left">
            <div>
                <p><?php echo $get_sender_msg_row['message'] ?></p>
            </div>
        </div>
    <?php }else{ ?>
        <div class="message-right">
            <div>    
                <p><?php echo $get_sender_msg_row['message'] ?></p>
            </div>
        </div>
    <?php } ?>
<?php } ?>
</div>
<div class="send-message-messagerie">
    <input type="text" id="message_text" placeholder="Ecriver un message ..">
</div>
<?php
$get_message_key_query = "SELECT message_cle FROM messages_cles WHERE id_recever = $id_user AND id_sender = $id_sender OR id_recever = $id_sender AND id_sender = $id_user";
$get_message_key_result = mysqli_query($conn,$get_message_key_query);
$get_message_key_row = mysqli_fetch_assoc($get_message_key_result);
?>
<input type="hidden" id="msgCle" value="<?php echo $get_message_key_row['message_cle']; ?>">
<?php
$verify_user_query = "SELECT id_user FROM utilisateurs WHERE id_user = $id_sender";
$verify_user_result = mysqli_query($conn,$verify_user_query);
if(mysqli_fetch_assoc($verify_user_result) > 0){
?>
<input type="hidden" id="type_messagerie" value="userUser">
<?php }else{ ?>
<input type="hidden" id="type_messagerie" value="boutiqueUser">
<?php } ?>
<input type="hidden" id="messagerie" value="messagerie">