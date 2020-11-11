<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_idSender_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_idSender_query->execute();
$get_session_idSender_row = $get_session_idSender_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_idSender_row['id_user'];
$num_msg_query = $conn->prepare("SELECT id_msg FROM messages WHERE id_sender = $id_user AND etat_sender_msg = $id_user GROUP BY id_recever");    
$num_msg_query->execute();
$num_msg_num = $num_msg_query->rowCount();
$show_message = '';
if ($num_msg_num > 0) {
    $show_message = 'style="display:block"';
}
?>
<div <?php echo $show_message ?> id="user_new_msg"><span><?php echo $num_msg_num; ?></span></div>