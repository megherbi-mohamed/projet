<?php
session_start();
include_once './bdd/connexion.php';
$id_user = htmlspecialchars($_SESSION['user']);
$id_prd = htmlspecialchars($_POST['id_prd']);
$delete_prd_query = "DELETE FROM produit_boutdechantier WHERE etat = 1 AND id_user = '$id_user' AND id_prd = '$id_prd'";
if (mysqli_query($conn, $delete_prd_query)) { 
    $get_product_media_query = "SELECT * FROM bt_produits_media WHERE id_prd = '$id_prd' AND etat = 1";
    if($get_product_media_result = mysqli_query($conn,$get_product_media_query)){
        while($get_product_media_row = mysqli_fetch_assoc($get_product_media_result)){
            unlink($get_product_media_row['media_url']);
        }
        $delete_product_media_query = "DELETE FROM bt_produits_media WHERE id_prd = '$id_prd' AND etat = 1";
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