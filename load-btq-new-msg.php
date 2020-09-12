<?php
include_once './bdd/connexion.php';
session_start();
if (!empty($_GET['btq'])) {
    $id_btq = $_GET['btq'];
    $num_btq_msg_query = "SELECT id_msg FROM messages WHERE id_sender = $id_btq AND etat_sender_msg = $id_btq GROUP BY id_recever";    
    $num_btq_msg_result = mysqli_query($conn,$num_btq_msg_query);
    $num_btq_msg_row = mysqli_num_rows($num_btq_msg_result);
    $show_btq_message = '';
    if ($num_btq_msg_row > 0) {
        $show_btq_message = 'style="display:block"';
    }   
}
?>
<div <?php echo $show_btq_message ?> id="btq_new_msg"><span><?php echo $num_btq_msg_row; ?></span></div>