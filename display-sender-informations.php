<?php
session_start();
include_once './bdd/connexion.php';
$sender_top_info_query = "SELECT * FROM utilisateurs WHERE utilisateurs.id_user = {$_GET['id_sender']}";
$sender_top_info_result = mysqli_query($conn,$sender_top_info_query);
$sender_top_info_row = mysqli_fetch_assoc($sender_top_info_result);
?>

<img src="<?php echo $sender_top_info_row['img_user']; ?>" alt="">
<h3><?php echo $sender_top_info_row['nom_user']; ?></h3>
<p>Etat : <span><?php
if ($sender_top_info_row['etat_user'] == '') { echo 'indisponible';}
else { echo 'disponible'; } ?></span></p>
<p>Email : <span><?php echo $sender_top_info_row['email_user']; ?></span></p>
<p>N°téléphone : <span><?php echo $sender_top_info_row['tlph_user']; ?></span></p>
<p>Ville : <span><?php echo $sender_top_info_row['ville']; ?></span></p>
<p>Pays : <span><?php echo $sender_top_info_row['pays']; ?></span></p><br>
<a href="./utilisateur-info.php?id_user=<?php echo $sender_top_info_row['id_user']; ?>">Voir le profile</a>  
