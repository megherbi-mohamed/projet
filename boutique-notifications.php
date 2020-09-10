<?php
session_start();
include_once './bdd/connexion.php';
$current_num_message_query = "SELECT * FROM boutique_messages WHERE id_btq = {$_SESSION['boutique']} AND id_sender = {$_SESSION['boutiqueCorrespondent']} AND etat_msg = 1";    
$current_num_message_result = mysqli_query($conn,$current_num_message_query);
$current_num_message = 0;
$current_message = 0;
$current_num_message_row = mysqli_num_rows($current_num_message_result);
if ($current_num_message >= 1) { $current_message = 1; }
else{ $current_message; }
?>
<p id="current_boutique_num_messages"><?php echo $current_message; ?></p>