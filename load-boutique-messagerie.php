<?php
session_start();
include_once './bdd/connexion.php';
$id_btq = htmlspecialchars($_POST['id_btq']);
$id_sender = htmlspecialchars($_POST['id_sender']);

$get_sender_msg_query = "SELECT id_recever,id_sender,message,date_format(temp_msg,'%H:%i') as temp_msg FROM messages WHERE 
id_recever = '$id_btq' AND id_sender = '$id_sender' OR id_recever = '$id_sender' AND id_sender = '$id_btq'";
$get_sender_msg_result = mysqli_query($conn, $get_sender_msg_query);

$get_last_sender_info_query = "SELECT id_user AS id, nom_user AS nom, img_user AS img FROM utilisateurs WHERE id_user = $id_sender UNION SELECT id_btq AS id, nom_btq AS nom, logo_btq AS img FROM boutiques WHERE id_btq = $id_sender";
$get_last_sender_info_result = mysqli_query($conn, $get_last_sender_info_query);
$get_last_sender_info_row = mysqli_fetch_assoc($get_last_sender_info_result);

?>
<div class="boutique-message">
    <div class="boutique-message-left">
        <?php
        $get_btq_msg_query = "SELECT * FROM messages WHERE id_msg IN ( SELECT MAX(id_msg) FROM messages WHERE id_recever = '$id_btq' GROUP BY id_sender) ORDER BY id_msg DESC";
        $get_btq_msg_result = mysqli_query($conn, $get_btq_msg_query);
        $i=0;
        while($get_btq_msg_row = mysqli_fetch_assoc($get_btq_msg_result)){
        $i++;

        $get_sender_info_query = "SELECT id_user,nom_user,img_user FROM utilisateurs WHERE id_user =".$get_btq_msg_row['id_sender'];
        $get_sender_info_result = mysqli_query($conn, $get_sender_info_query);
        $get_sender_info_row = mysqli_fetch_assoc($get_sender_info_result);
        
        $last_msg_query = "SELECT * FROM messages WHERE id_msg IN ( SELECT MAX(id_msg) FROM messages WHERE id_recever = '$id_btq' AND id_sender = {$get_sender_info_row['id_user']}
                            OR id_recever = {$get_sender_info_row['id_user']} AND id_sender = '$id_btq')";
        $last_msg_result = mysqli_query($conn,$last_msg_query);
        $last_msg_row = mysqli_fetch_assoc($last_msg_result);
        
        $new_msg = '';
        if ($last_msg_row['etat_recever_msg'] == $id_btq || $last_msg_row['etat_sender_msg'] == $id_btq) {
            $new_msg = 'style="background:#ecedee"';
        }
        ?>
        <input type="hidden" id="id_corresponder_<?php echo $i?>" value="<?php echo $get_btq_msg_row['id_sender'] ?>">
        <div <?php echo $new_msg; ?> class="boutique-corresponder" id="boutique_corresponder_<?php echo $i?>">
            <img src="<?php echo $get_sender_info_row['img_user'] ?>" alt="">
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
            while($get_sender_msg_row = mysqli_fetch_assoc($get_sender_msg_result)){
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
            </div>
            <?php 
            $get_message_key_query = "SELECT message_cle FROM messages_cles WHERE id_recever = $id_btq AND id_sender = $id_sender OR id_recever = $id_sender AND id_sender = $id_btq";
            $get_message_key_result = mysqli_query($conn,$get_message_key_query);
            $get_message_key_row = mysqli_fetch_assoc($get_message_key_result);
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