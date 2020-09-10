<?php
session_start();
include_once './bdd/connexion.php';

$etat_user_query = "SELECT etat_user FROM utilisateurs WHERE id_user=".$_SESSION['user'];
$etat_user_result = mysqli_query($conn,$etat_user_query);
$etat_user_row = mysqli_fetch_assoc($etat_user_result);
$etat_user = $etat_user_row['etat_user'];

if ($etat_user == 'checked') {
    $query = "UPDATE utilisateurs SET etat_user = '' WHERE id_user=".$_SESSION['user'];
    mysqli_query($conn,$query);
}else{
    $query = "UPDATE utilisateurs SET etat_user = 'checked' WHERE id_user=".$_SESSION['user'];
    mysqli_query($conn,$query);
}
?>