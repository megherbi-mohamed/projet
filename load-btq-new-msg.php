<?php
include_once './bdd/connexion.php';
session_start();
if (!empty($_GET['btq'])) {
    $id_btq = $_GET['btq'];
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