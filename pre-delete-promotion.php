<?php
include_once './bdd/connexion.php';
$id_prm = htmlspecialchars($_POST['id_prm']);
$delete_prm_query = $conn->prepare("DELETE FROM promotions WHERE id_prm = $id_prm AND etat = 1");
$delete_prm_prd_query = $conn->prepare("DELETE FROM produit_promotion WHERE etat = 1 AND id_prm = $id_prm");
$delete_prm_btq_prd_query = $conn->prepare("DELETE FROM produit_boutique_promotion WHERE etat = 1 AND id_prm = $id_prm");
if ($delete_prm_query->execute() && $delete_prm_prd_query->execute() && $delete_prm_btq_prd_query->execute()) { 
    $get_promotion_media_query = $conn->prepare("SELECT * FROM promotions_media WHERE id_prm = $id_prm");
    $get_promotion_prd_media_query = $conn->prepare("SELECT media_url FROM prm_produits_media WHERE id_prm = $id_prm AND etat = 1");
    if($get_promotion_media_query->execute() && $get_promotion_prd_media_query->execute()){
        if ($get_promotion_media_query->rowCount() > 0) {
            while($get_promotion_media_row = $get_promotion_media_query->fetch(PDO::FETCH_ASSOC)){
                if ($get_promotion_media_row['etat'] == 1) {
                    $id_prm_m = $get_promotion_media_row['id_prm_m'];
                    $delete_promotion_media_query = $conn->prepare("DELETE FROM promotions_media WHERE id_prm_m = $id_prm_m");
                    if ($delete_promotion_media_query->execute() && unlink($get_promotion_media_row['media_url'])) {
                        echo 1;
                    }
                    else{
                        echo 0;
                        break;
                    }
                }
                else if ($get_promotion_media_row['etat'] == 0 && $get_promotion_media_row['etat_updt'] == 1) {
                    $id_prm_m = $get_promotion_media_row['id_prm_m'];
                    $update_promotion_media_query = $conn->prepare("UPDATE promotions_media SET etat_updt = 0 WHERE id_prm_m = $id_prm_m");
                    if ($update_promotion_media_query->execute()) {
                        echo 1;
                    }
                    else{
                        echo 0;
                        break;
                    }
                }
                else{
                    echo 1;
                }
            }
        }
        else{
            echo 1;
        }
        while($get_promotion_prd_media_row = $get_promotion_prd_media_query->fetch(PDO::FETCH_ASSOC)){
            unlink($get_promotion_prd_media_row['media_url']);
        }
        $delete_promotion_prd_media_query = $conn->prepare("DELETE FROM prm_produits_media WHERE id_prm = $id_prm AND etat = 1");
        if ($delete_promotion_prd_media_query->execute()) {
            echo 1;
        }
        else{
            echo 0;
        }
    }
    else{
        echo 0;
    }
}   
else{
    echo 0;
}
?>