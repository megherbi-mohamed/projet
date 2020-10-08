<?php
session_start();
include_once './bdd/connexion.php';
$id_prd = htmlspecialchars($_POST['id_prd']);
$delete_product_query = $conn->prepare("DELETE FROM produit_boutdechantier WHERE id_prd = '$id_prd'");
if ($delete_product_query->execute()) {
    $get_product_media_query = $conn->prepare("SELECT * FROM bt_produits_media WHERE id_prd = '$id_prd'");
    if($get_product_media_query->execute()){
        while($get_product_media_row = $get_product_media_query->fetch(PDO::FETCH_ASSOC)){
            unlink($get_product_media_row['media_url']);
        }
        $delete_product_media_query = $conn->prepare("DELETE FROM bt_produits_media WHERE id_prd = '$id_prd'");
        if ($delete_product_media_query->execute()) {
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