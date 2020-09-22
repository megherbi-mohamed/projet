<?php
include_once './bdd/connexion.php';
session_start();
$id_user = htmlspecialchars($_SESSION['user']);
$num_msg_query = "SELECT id_msg FROM messages WHERE id_sender = $id_user AND etat_sender_msg = $id_user GROUP BY id_recever";    
$num_msg_result = mysqli_query($conn,$num_msg_query);
$num_msg_row = mysqli_num_rows($num_msg_result);
$show_message = '';
if ($num_msg_row > 0) {
    $show_message = 'style="display:block"';
}
?>
<div <?php echo $show_message ?> id="user_new_msg"><span><?php echo $num_msg_row; ?></span></div>