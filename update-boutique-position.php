<?php 
session_start();
include_once './bdd/connexion.php';

$id_btq = htmlspecialchars($_POST['id_btq']);
$latitude_btq = htmlspecialchars($_POST['latitude_btq']);
$longitude_btq = htmlspecialchars($_POST['longitude_btq']);

$updt_pst_query = "UPDATE boutiques SET latitude_btq='$latitude_btq', longitude_btq='$longitude_btq' WHERE id_btq= '$id_btq'";
if(mysqli_query($conn, $updt_pst_query)){
    echo 1;
}
else{
    echo 0;
}