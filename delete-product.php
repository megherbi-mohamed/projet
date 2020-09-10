<?php
session_start();
include_once './bdd/connexion.php';
$id_prd = htmlspecialchars($_POST['id_prd']);
$delete_product_query = "DELETE FROM produit_boutique WHERE id_prd = '$id_prd'";
if (mysqli_query($conn, $delete_product_query)) {
    $get_product_media_query = "SELECT * FROM produits_media WHERE id_prd = '$id_prd'";
    if($get_product_media_result = mysqli_query($conn,$get_product_media_query)){
        while($get_product_media_row = mysqli_fetch_assoc($get_product_media_result)){
            unlink($get_product_media_row['media_url']);
        }
        $delete_product_media_query = "DELETE FROM produits_media WHERE id_prd = '$id_prd'";
        if (mysqli_query($conn, $delete_product_media_query)) {
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