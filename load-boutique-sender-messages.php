<?php
session_start();
include_once './bdd/connexion.php';
$id_sender = htmlspecialchars($_POST['id_sender']);
$id_btq = htmlspecialchars($_POST['id_btq']);
$get_sender_msg_query = $conn->prepare("SELECT id_recever,id_sender,message,date_format(temp_msg,'%H:%i') as temp_msg FROM messages WHERE id_recever = '$id_btq' AND id_sender = '$id_sender'
OR id_recever = '$id_sender' AND id_sender = '$id_btq'");
$get_sender_msg_query->execute();

$get_sender_info_query = $conn->prepare("SELECT id_user AS id, nom_user AS nom, img_user AS img FROM utilisateurs WHERE id_user = $id_sender 
                        UNION SELECT id_btq AS id, nom_btq AS nom, logo_btq AS img FROM boutiques WHERE id_btq = $id_sender");
$get_sender_info_query->execute();
$get_sender_info_row = $get_sender_info_query->fetch(PDO::FETCH_ASSOC);
?>
<div class="boutique-message-right-top">
    <div id="back_sender">
        <i class="fas fa-arrow-left"></i>
    </div>
    <div class="corresponder-info">
        <input type="hidden" id="id_corresponder" value="<?php echo $get_sender_info_row['id'] ?>">
        <img src="<?php echo $get_sender_info_row['img'] ?>" alt="">
        <h5><?php echo $get_sender_info_row['nom'] ?></h5>
    </div>
</div>
<div class="boutique-message-right-bottom">
<?php
while($get_sender_msg_row = $get_sender_msg_query->fetch(PDO::FETCH_ASSOC)){
    if ($get_sender_msg_row['id_recever'] == $id_btq) { ?>
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
<div class="send-message-boutique">
    <input type="text" id="message_text" placeholder="Ecriver un message ..">
    <div id="send_message_button">
        <img src="./icons/send-message-icon.png" alt="">
    </div>
</div>
<?php 
$get_message_key_query = $conn->prepare("SELECT message_cle FROM messages_cles WHERE id_recever = '$id_btq' AND id_sender = '$id_sender' OR id_recever = '$id_sender' AND id_sender = '$id_btq'");
$get_message_key_query->execute();
$get_message_key_row = $get_message_key_query->fetch(PDO::FETCH_ASSOC);
?>
<input type="hidden" id="msgCle" value="<?php echo $get_message_key_row['message_cle']; ?>">
<input type="hidden" id="type_messagerie" value="boutiqueUser">
<input type="hidden" id="messagerie" value="boutique">