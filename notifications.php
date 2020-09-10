<?php
session_start();
include_once './bdd/connexion.php';

$cnx_user_query = "SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['user-info'];
$result = mysqli_query($conn, $cnx_user_query);
$row = mysqli_fetch_assoc($result);

$etat_user = '';
$etat_line = '';
if ($row['etat_user'] == 'checked') { $etat_user = 'etat-online'; $etat_line = 'disponible'; }
else{ $etat_user = 'etat-offline'; $etat_line = 'indisponible'; }

if (isset($_SESSION['user'])) {
    $cnx_user_query = "SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['user'];
    $result = mysqli_query($conn, $cnx_user_query);
    $row = mysqli_fetch_assoc($result);
}

$sender_top_info_query = "SELECT * FROM utilisateurs WHERE id_user = {$_SESSION['senderinfo']}";
$sender_top_info_result = mysqli_query($conn,$sender_top_info_query);
$sender_top_info_row = mysqli_fetch_assoc($sender_top_info_result);

?>

<!-- <span id="info_etat_user"><?php echo $etat_line; ?></span> -->
<div id="info_line_user" style="top:80px" class="<?php echo $etat_user; ?>"></div>

<?php 
$num_msg_query = "SELECT * FROM messages WHERE id_recever = {$row['id_user']} AND etat_msg = 1 GROUP BY id_sender";    
$num_msg_result = mysqli_query($conn,$num_msg_query);
$num_message = 0;
while ($num_msg_row = mysqli_fetch_assoc($num_msg_result)) { $num_message++; }
$etat_message = '';
if ($num_message > 0) { $etat_message = 'active-message-num'; }
else{ $etat_message = '';}
?>
<span id="user_list_messages" class="<?php echo $etat_message;?>"><?php echo $num_message;?></span>

<?php 
$current_num_message_query = "SELECT * FROM messages WHERE id_recever = {$row['id_user']} AND id_sender = {$_SESSION['senderinfo']} AND etat_msg = 1";    
$current_num_message_result = mysqli_query($conn,$current_num_message_query);
$current_num_message = 0;
$current_message = 0;
while ($current_num_message_row = mysqli_fetch_assoc($current_num_message_result)) { $current_num_message++; }
if ($current_num_message >= 1) { $current_message = 1; }
else{ $current_message; }
?>
<p id="current_chat_num_messages"><?php echo $current_message; ?></p>

<?php 
$vue_sender_message_query = "SELECT * FROM messages WHERE id_recever = {$_SESSION['senderinfo']} AND id_sender = {$row['id_user']} AND etat_msg = 1";    
$vue_sender_message_result = mysqli_query($conn,$vue_sender_message_query);
$vue_sender_message = 0;
$vue_sender = 0;
while ($vue_sender_message_row = mysqli_fetch_assoc($vue_sender_message_result)) { $vue_sender_message++; }
if ($vue_sender_message >= 1) { $vue_sender = 1; }
else{ $vue_sender; }
?>
<p id="vue_sender_num_messages"><?php echo $vue_sender; ?></p>

<?php 
$message_check_query = "SELECT etat_msg FROM messages WHERE id_msg IN ( SELECT MAX(id_msg) FROM messages WHERE id_recever = {$_SESSION['senderinfo']} AND id_sender = {$row['id_user']})";    
$message_check_result = mysqli_query($conn,$message_check_query);
$message_check_row = mysqli_fetch_assoc($message_check_result);
    $check_circle_active_far = '';
    $check_circle_active_fas = '';
    $fa_circle_active = '';
    if ($message_check_row['etat_msg'] == 1) {
        $check_circle_active_far = 'check-circle-active';
        $fa_circle_active = '';
    }else{ $check_circle_active_fas = 'check-circle-active'; 
        $fa_circle_active = '';} ?>
<i id="message_check_i" class="far fa-check-circle sent <?php echo $check_circle_active_far; ?>"></i>
<i id="message_check_i" class="fas fa-check-circle vu <?php echo $check_circle_active_fas; ?>"></i>
<i id="message_check_i" class="far fa-circle not-sent <?php echo $fa_circle_active; ?>"></i>
