<?php 
session_start();
include_once './bdd/connexion.php';
if (!empty($_GET['id_btq'])) {
    $id_btq = htmlspecialchars($_GET['id_btq']);

    $num_btq_msg_query = "SELECT id_msg FROM messages WHERE id_sender = $id_btq AND etat_sender_msg = $id_btq GROUP BY id_recever";    
    $num_btq_msg_result = mysqli_query($conn,$num_btq_msg_query);
    $num_btq_msg_row = mysqli_num_rows($num_btq_msg_result);
    $show_btq_message = '';
    if ($num_btq_msg_row > 0) {
        $show_btq_message = 'style="display:block"';
    }
}
?>
<div class="gb-messages" id="display_gb_messagerie">
    <div>
        <i class="fab fa-facebook-messenger"></i>
    </div>
    <p>Messages</p>
    <div class="btq-new-msg">
        <div id="btq_new_msg" <?php echo $show_btq_message ?>>
            <span><?php echo $num_btq_msg_row; ?></span>
        </div>
    </div>
</div>
<div class="gb-notifications" id="display_gb_notifications">
    <div>
        <i class="fas fa-bell"></i>
    </div>
    <p>Notifications</p>
    <!-- <div class="btq-new-ntf">
        <div id="btq_new_ntf" <?php echo $show_btq_notification ?>>
            <span><?php echo $num_btq_ntf_row; ?></span>
        </div>
    </div> -->
</div>
<div class="gb-update" id="display_gb_informations">
    <div>
        <i class="fas fa-cog"></i>
    </div>
    <p>Modifier la boutique</p>
</div>
<div class="gb-admin" id="create_gb_admin">
    <div>
        <i class="fas fa-user-cog"></i>
        <!-- <i class="fas fa-user-lock"></i> -->
    </div>
    <p>Admin boutique</p>
</div>