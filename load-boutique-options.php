<?php 
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_id_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                        OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_id_query->execute();
$get_session_id_row = $get_session_id_query->fetch(PDO::FETCH_ASSOC);
$user_session_query = $conn->prepare("SELECT * FROM utilisateurs WHERE id_user = {$get_session_id_row['id_user']}");
$user_session_query->execute();
if ($user_session_query->rowCount() > 0) {
    $row = $user_session_query->fetch(PDO::FETCH_ASSOC);
    $uid = $id_session;
    $id_user = $row['id_user'];
}
if (!empty($_GET['id_btq'])) {
    $id_session_btq = htmlspecialchars($_GET['id_btq']);
    $get_session_btq_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session_btq' OR id_user_1 = '$id_session_btq' OR id_user_2 = '$id_session_btq' 
                                                OR id_user_3 = '$id_session_btq' OR id_user_4 = '$id_session_btq' OR id_user_5 = '$id_session_btq'");
    $get_session_btq_query->execute();
    $get_session_btq_row = $get_session_btq_query->fetch(PDO::FETCH_ASSOC);
    $id_btq = $get_session_btq_row['id_user'];
    $num_btq_msg_query = $conn->prepare("SELECT id_msg FROM messages WHERE id_sender = $id_btq AND etat_sender_msg = $id_btq GROUP BY id_recever");    
    $num_btq_msg_query->execute();
    $num_btq_msg_num= $num_btq_msg_query->rowCount();
    $show_btq_message = '';
    if ($num_btq_msg_num > 0) {
        $show_btq_message = 'style="display:block"';
    }

    $num_btq_ntf_query = $conn->prepare("SELECT id_ntf FROM publications_notifications WHERE id_recever_ntf = $id_btq AND etat_ntf = 1 AND id_sender_ntf != $id_btq AND id_sender_ntf != $id_user");    
    $num_btq_ntf_query->execute();
    $num_btq_ntf_num = $num_btq_ntf_query->rowCount();
    $show_btq_notification = '';
    if ($num_btq_ntf_num > 0) {
        $show_btq_notification = 'style="display:block"';
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
            <span><?php echo $num_btq_msg_num; ?></span>
        </div>
    </div>
</div>
<div class="gb-notifications" id="display_gb_notifications">
    <div>
        <i class="fas fa-bell"></i>
    </div>
    <p>Notifications</p>
    <div class="btq-new-ntf">
        <div id="btq_new_ntf" <?php echo $show_btq_notification ?>>
            <span><?php echo $num_btq_ntf_num; ?></span>
        </div>
    </div>
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