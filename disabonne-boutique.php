<?php 
session_start();
include_once './bdd/connexion.php';
$id_user = htmlspecialchars($_SESSION['user']);
$id_abn_user = htmlspecialchars($_POST['id_btq']);
$abonne_query = $conn->prepare("DELETE FROM abonnes WHERE id_user = '$id_user' AND id_abn_user = '$id_abn_user'");
if($abonne_query->execute()){
    echo 1;
}
else{
    echo 0;
}
?>