<?php
include_once './bdd/connexion.php';
$id_prm = htmlspecialchars($_POST['id_prm']);
$delete_promotion_query = $conn->prepare("DELETE FROM promotions WHERE id_prm = $id_prm");
$delete_promotion_product_query = $conn->prepare("DELETE FROM produit_promotion WHERE id_prm = $id_prm");
$delete_promotion_boutique_product_query = $conn->prepare("DELETE FROM produit_boutique_promotion WHERE id_prm = $id_prm");
if ($delete_promotion_query->execute() && $delete_promotion_product_query->execute() && $delete_promotion_boutique_product_query->execute()) {
    $get_promotion_media_query = $conn->prepare("SELECT media_url FROM promotions_media WHERE id_prm = $id_prm");
    $get_promotion_product_media_query = $conn->prepare("SELECT media_url FROM prm_produits_media WHERE id_prm = $id_prm");
    if($get_promotion_media_query->execute() && $get_promotion_product_media_query->execute()){
        unlink($get_promotion_media_row['media_url']);
        while($get_promotion_product_media_row = $get_promotion_product_media_query->fetch(PDO::FETCH_ASSOC)){
            unlink($get_promotion_product_media_row['media_url']);
        }
        $delete_promotions_media_query = $conn->prepare("DELETE FROM promotions_media WHERE id_prm = $id_prm");
        $delete_promotions_product_media_query = $conn->prepare("DELETE FROM prm_produits_media WHERE id_prm = $id_prm");
        if ($delete_promotions_media_query->execute() && $delete_promotions_product_media_query->execute()) {
            echo 1;
        }
        else{
            echo 0;
        }
    }else{
        echo 0;
    }
}
else{
    echo 0;
}
?>