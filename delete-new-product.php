<?php
session_start();
include_once './bdd/connexion.php';
$idPrd = $_POST['id_prd'];
$etat_msg_query = "DELETE FROM produit_boutique WHERE id_prd = '$idPrd'";
if(mysqli_query($conn, $etat_msg_query)){
    echo 1;
}else{
    echo 0;
}
?>