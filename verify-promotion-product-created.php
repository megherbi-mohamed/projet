<?php
include_once './bdd/connexion.php';
$id_prm = htmlspecialchars($_POST['id_prm']);
$get_promotion_product_query = $conn->prepare("SELECT id_prd FROM produit_promotion WHERE id_prm = $id_prm AND nom_prd IS NOT NULL");
$get_promotion_product_boutique_query = $conn->prepare("SELECT id_prd_prm FROM produit_boutique_promotion WHERE id_prm = $id_prm");
if ($get_promotion_product_query->execute() && $get_promotion_product_boutique_query->execute()) {
    echo $get_promotion_product_query->rowCount() + $get_promotion_product_boutique_query->rowCount();
}
else{ 
    echo 100;
}
?>