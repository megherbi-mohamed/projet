<?php 
session_start();
include_once './bdd/connexion.php';
$id_user = htmlspecialchars($_SESSION['user']);
$id_prd = htmlspecialchars($_POST['id_prd']);
$lieu_prd = htmlspecialchars($_POST['lieu_prd']);
$nom_prd = htmlspecialchars($_POST['nom_prd']);
$categorie_prd = htmlspecialchars($_POST['categorie_prd']);
$description_prd = htmlspecialchars($_POST['description_prd']);
$quantite_prd = htmlspecialchars($_POST['quantity_prd']);
$type_prd = htmlspecialchars($_POST['type_prd']);
$prix_prd = htmlspecialchars($_POST['price_prd']);
$date =  date("Y-m-d h:i:sa");
$create_product_query = $conn->prepare("UPDATE produit_boutdechantier SET lieu_prd = '$lieu_prd', nom_prd = '$nom_prd', type_prd = '$type_prd', categorie_prd = '$categorie_prd',
description_prd = '$description_prd', quantite_prd = '$quantite_prd', prix_prd = '$prix_prd', date = '$date', etat = 0 WHERE id_prd = '$id_prd' AND id_user = '$id_user'");
if ($create_product_query->execute()) {
    $update_media_query = $conn->prepare("UPDATE bt_produits_media SET etat = 0 WHERE id_prd = '$id_prd'");
    if ($update_media_query->execute()) {
        echo 1;
    }else{
        echo 0;
    }
}
else{
    echo 0;
}
?>