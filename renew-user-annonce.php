<?php 
session_start();
include_once './bdd/connexion.php';
$id_prd = htmlspecialchars($_POST['id_prd']);
$date =  date("Y-m-d h:i:sa");
$renew_annoce_query = "UPDATE produit_boutdechantier SET date = '$date' WHERE id_prd = '$id_prd'";
if(mysqli_query($conn,$renew_annoce_query)){
    echo 1;
}
else{
    echo 0;
}
?>