<?php 
session_start();
include_once './bdd/connexion.php';

$cnx_user_query = "SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['user'];
$result = mysqli_query($conn, $cnx_user_query);
$row = mysqli_fetch_assoc($result);

?>

<p>Téléphone : <span><?php echo $row['tlph_user']; ?></span></p>
<p>Age : <span><?php echo $row['age_user']; ?></span></p>
<p>Profession : <span><?php echo $row['profession_user']; ?></span></p>
<p>Ville : <span><?php echo $row['ville']; ?></span></p>
<p>Pays : <span><?php echo $row['pays']; ?></span></p>
<p>Adresse 1 : <span><?php echo $row['adresse1_user']; ?></span></p>
<p>Adresse 2 : <span><?php echo $row['adresse2_user']; ?></span></p>