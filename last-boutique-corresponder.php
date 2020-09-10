<?php
session_start();
include_once './bdd/connexion.php';
$id_btq = htmlspecialchars($_GET['id_btq']);
$get_last_sender_query = "SELECT id_sender FROM messages WHERE id_msg IN ( SELECT MAX(id_msg) FROM messages WHERE id_recever = '$id_btq' GROUP BY id_sender) ORDER BY id_msg DESC";
$get_last_sender_result = mysqli_query($conn, $get_last_sender_query);
$get_last_sender_row = mysqli_fetch_assoc($get_last_sender_result);
echo $get_last_sender_row['id_sender'];
?>