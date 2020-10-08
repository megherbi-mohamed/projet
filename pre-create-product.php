<?php
session_start();
include_once './bdd/connexion.php';
$id_user = htmlspecialchars($_SESSION['user']);
$id_btq = htmlspecialchars($_POST['id_btq']);
$etat = 1;
$create_prd_query = $conn->prepare("INSERT INTO produit_boutique (id_btq,id_user,etat) VALUES (:id_btq,:id_user,:etat)");
$create_prd_query->bindParam(':id_btq',$id_btq);
$create_prd_query->bindParam(':id_user',$id_user);
$create_prd_query->bindParam(':etat',$etat);
if ($create_prd_query->execute()) {
    $get_prd_query = $conn->prepare("SELECT id_prd FROM produit_boutique WHERE id_btq = '$id_btq' AND etat = 1");
    $get_prd_query->execute();
    if($get_prd_row = $get_prd_query->fetch(PDO::FETCH_ASSOC)){
        echo $get_prd_row['id_prd'];
    }
    else{
        echo 0;
    }
}
else{
    echo 0;
}
?>