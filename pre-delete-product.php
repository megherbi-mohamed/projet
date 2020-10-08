<?php
session_start();
include_once './bdd/connexion.php';
$id_prd = htmlspecialchars($_POST['id_prd']);
$delete_prd_query = $conn->prepare("DELETE FROM produit_boutique WHERE etat = 1 AND id_user = {$_SESSION['user']} AND id_prd = '$id_prd'");
if ($delete_prd_query->execute()) { 
    $get_product_media_query = $conn->prepare("SELECT * FROM produits_media WHERE id_prd = '$id_prd' AND etat = 1");
    if($get_product_media_query->execute()){
        while($get_product_media_row = $get_product_media_query->fetch(PDO::FETCH_ASSOC)){
            unlink($get_product_media_row['media_url']);
        }
        $delete_product_media_query = $conn->prepare("DELETE FROM produits_media WHERE id_prd = '$id_prd' AND etat = 1");
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