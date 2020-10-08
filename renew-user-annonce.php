<?php 
session_start();
include_once './bdd/connexion.php';
$id_prd = htmlspecialchars($_POST['id_prd']);
$date =  date("Y-m-d h:i:sa");
$renew_annoce_query = $conn->prepare("UPDATE produit_boutdechantier SET date = '$date' WHERE id_prd = '$id_prd'");
if($renew_annoce_query->execute()){
    echo 1;
}
else{
    echo 0;
}
?>