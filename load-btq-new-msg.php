<?php
include_once './bdd/connexion.php';
session_start();
if (!empty($_GET['btq'])) {
    $id_session_btq = htmlspecialchars($_GET['btq']);
    $get_session_btq_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session_btq' OR id_user_1 = '$id_session_btq' OR id_user_2 = '$id_session_btq' 
                                                OR id_user_3 = '$id_session_btq' OR id_user_4 = '$id_session_btq' OR id_user_5 = '$id_session_btq'");
    $get_session_btq_query->execute();
    $get_session_btq_row = $get_session_btq_query->fetch(PDO::FETCH_ASSOC);
    $id_btq = $get_session_btq_row['id_user'];
    $num_btq_msg_query = $conn->prepare("SELECT id_msg FROM messages WHERE id_sender = $id_btq AND etat_sender_msg = $id_btq GROUP BY id_recever");    
    $num_btq_msg_query->execute();
    $num_btq_msg_num = $num_btq_msg_query->rowCount();
    $show_btq_message = '';
    if ($num_btq_msg_num > 0) {
        $show_btq_message = 'style="display:block"';
    }   
}
?>
<div <?php echo $show_btq_message ?> id="btq_new_msg"><span><?php echo $num_btq_msg_num; ?></span></div>