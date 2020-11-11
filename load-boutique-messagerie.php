<?php
session_start();
include_once './bdd/connexion.php';
$id_session_btq = htmlspecialchars($_POST['id_btq']);
$get_session_btq_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session_btq' OR id_user_1 = '$id_session_btq' OR id_user_2 = '$id_session_btq' 
                                            OR id_user_3 = '$id_session_btq' OR id_user_4 = '$id_session_btq' OR id_user_5 = '$id_session_btq'");
$get_session_btq_query->execute();
$get_session_btq_row = $get_session_btq_query->fetch(PDO::FETCH_ASSOC);
$id_btq = $get_session_btq_row['id_user'];

$get_last_sender_query = $conn->prepare("SELECT id_recever,id_sender FROM messages WHERE id_msg IN ( SELECT MAX(id_msg) FROM messages WHERE id_recever = '$id_btq' OR id_sender = '$id_btq' GROUP BY msg_cle) ORDER BY id_msg DESC");
$get_last_sender_query->execute();
$get_last_sender_num = $get_last_sender_query->rowCount();

if ($get_last_sender_num > 0) {
$get_last_sender_row = $get_last_sender_query->fetch(PDO::FETCH_ASSOC);

if ($get_last_sender_row['id_sender'] == $id_btq) {
    $id_sender = $get_last_sender_row['id_recever'];
}
else if ($get_last_sender_row['id_recever'] == $id_btq) {
    $id_sender = $get_last_sender_row['id_sender'];
}

$get_sender_msg_query = $conn->prepare("SELECT id_recever,id_sender,message,date_format(temp_msg,'%H:%i') as temp_msg FROM messages WHERE 
id_recever = '$id_btq' AND id_sender = '$id_sender' OR id_recever = '$id_sender' AND id_sender = '$id_btq'");
$get_sender_msg_query->execute();

$get_last_sender_info_query = $conn->prepare("SELECT id_user AS id, nom_user AS nom, img_user AS img FROM utilisateurs WHERE id_user = $id_sender UNION SELECT id_btq AS id, nom_btq AS nom, logo_btq AS img FROM boutiques WHERE id_btq = $id_sender");
$get_last_sender_info_query->execute();
$get_last_sender_info_row = $get_last_sender_info_query->fetch(PDO::FETCH_ASSOC);
?>
<div class="boutique-message">
    <div class="boutique-message-left">
        <?php
        $get_btq_msg_query = $conn->prepare("SELECT * FROM messages WHERE id_msg IN ( SELECT MAX(id_msg) FROM messages WHERE id_recever = '$id_btq' OR id_sender = '$id_btq' GROUP BY msg_cle) ORDER BY id_msg DESC");
        $get_btq_msg_query->execute();
        $i=0;
        while($get_btq_msg_row = $get_btq_msg_query->fetch(PDO::FETCH_ASSOC)){
        $i++;

        if ($get_btq_msg_row['id_recever'] == $id_btq) {
            $get_sender_info_query = $conn->prepare("SELECT id_user,nom_user,img_user FROM utilisateurs WHERE id_user =".$get_btq_msg_row['id_sender']);
            $get_sender_info_query->execute();
            $get_sender_info_row = $get_sender_info_query->fetch(PDO::FETCH_ASSOC);
        }
        else if ($get_btq_msg_row['id_sender'] == $id_btq) {
            $get_sender_info_query = $conn->prepare("SELECT id_user,nom_user,img_user FROM utilisateurs WHERE id_user =".$get_btq_msg_row['id_recever']);
            $get_sender_info_query->execute();
            $get_sender_info_row = $get_sender_info_query->fetch(PDO::FETCH_ASSOC);
        }
        
        $last_msg_query = $conn->prepare("SELECT * FROM messages WHERE id_msg IN ( SELECT MAX(id_msg) FROM messages WHERE id_recever = '$id_btq' AND id_sender = {$get_sender_info_row['id_user']}
                            OR id_recever = {$get_sender_info_row['id_user']} AND id_sender = '$id_btq')");
        $last_msg_query->execute();
        $last_msg_row = $last_msg_query->fetch(PDO::FETCH_ASSOC);
        $new_msg = '';
        if ($last_msg_row['etat_recever_msg'] == $id_btq || $last_msg_row['etat_sender_msg'] == $id_btq) {
            $new_msg = 'style="background:#ecedee"';
        }
        ?>
        <input type="hidden" id="id_corresponder_<?php echo $i?>" value="<?php echo $get_sender_info_row['id_user'] ?>">
        <div <?php echo $new_msg; ?> class="boutique-corresponder" id="boutique_corresponder_<?php echo $i?>">
            <?php if ($get_sender_info_row['img_user'] == '') { ?>
            <img src="./images/profile.png" alt="">
            <?php }else{ ?>
            <img src="<?php echo $get_sender_info_row['img_user'] ?>" alt="">
            <?php } ?>
            <div class="boutique-corresponder-message">
                <h4><?php echo $get_sender_info_row['nom_user'] ?></h4>
                <p><?php echo $last_msg_row['message']; ?></p>
                <span><?php echo $get_btq_msg_row['temp_msg'] ?></span>
            </div>
        </div>
        <?php } ?>
    </div>
    <div class="boutique-message-right">
        <div class="boutique-message-right-container">
            <div class="boutique-message-right-top">
                <div id="back_sender">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <div class="corresponder-info">
                    <input type="hidden" id="id_corresponder" value="<?php echo $get_last_sender_info_row['id'] ?>">
                    <img src="<?php echo $get_last_sender_info_row['img'] ?>" alt="">
                    <h5><?php echo $get_last_sender_info_row['nom'] ?></h5>
                </div>
            </div>
            <div class="boutique-message-right-bottom" id="message_box">
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
            $get_message_key_query = $conn->prepare("SELECT message_cle FROM messages_cles WHERE id_recever = $id_btq AND id_sender = $id_sender OR id_recever = $id_sender AND id_sender = $id_btq");
            $get_message_key_query->execute();
            $get_message_key_row = $get_message_key_query->fetch(PDO::FETCH_ASSOC);
            ?>
            <input type="hidden" id="msgCle" value="<?php echo $get_message_key_row['message_cle']; ?>">
            <input type="hidden" id="type_messagerie" value="boutiqueUser">
            <input type="hidden" id="messagerie" value="boutique">
        </div>
        <div id="loader_message" class="center-message"></div>
    </div>
</div>
<div id="boutique_left_message" style="display:none">
    <div class="message-left">
        <div>
            <p>{message}</p>
        </div>
    </div>
</div>
<div id="boutique_right_message" style="display: none">
    <div class="message-right">
        <div>    
            <p>{message}</p>
        </div>
    </div>
</div>
<?php }else{ ?>
<div class="empty-msg-ntf">
    <p>Vous n'avez auccune conversation</p>
</div>
<?php } ?>
