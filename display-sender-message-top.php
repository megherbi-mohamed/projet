<?php 
session_start();
include_once './bdd/connexion.php';
$sender_top_info_query = "SELECT * FROM utilisateurs WHERE id_user = {$_GET['id_sender']}";
$sender_top_info_result = mysqli_query($conn,$sender_top_info_query);
$sender_top_info_row = mysqli_fetch_assoc($sender_top_info_result);
?>

<img src="./<?php echo $sender_top_info_row['img_user']; ?>" alt="">
<p><?php echo $sender_top_info_row['nom_user']; ?></p>
