<?php 
include_once './bdd/connexion.php';
$id_prm = htmlspecialchars($_POST['id_prm']);
$id_btq = htmlspecialchars($_POST['id_btq']);
$id_prd = htmlspecialchars($_POST['id_prd']);
$delete_product_promotion_query = $conn->prepare("DELETE FROM produit_boutique_promotion WHERE id_btq_prd = $id_prd AND id_btq = $id_btq AND id_prm = $id_prm");
if ($delete_product_promotion_query->execute()) {
    echo 1;
}
else{
    echo 0;
}
?>