<?php
include_once './bdd/connexion.php';
$id_prm = htmlspecialchars($_POST['id_prm']);
$date_prm =  date("Y-m-d");
$create_promotion_query = $conn->prepare("UPDATE promotions SET date_prm = '$date_prm', etat = 0 WHERE id_prm = $id_prm");
$get_promotion_media_query = $conn->prepare("SELECT * FROM promotions_media WHERE id_prm = $id_prm");
if($create_promotion_query->execute() && $get_promotion_media_query->execute()){
    if ($get_promotion_media_query->rowCount() > 0) {
        while($get_promotion_media_row = $get_promotion_media_query->fetch(PDO::FETCH_ASSOC)){
            if (($get_promotion_media_row['etat'] == 1 && $get_promotion_media_row['etat_updt'] == 1) || ($get_promotion_media_row['etat'] == 0 && $get_promotion_media_row['etat_updt'] == 1)) {
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
            else if ($get_promotion_media_row['etat'] == 1 && $get_promotion_media_row['etat_updt'] == 0) {
                $id_prm_m = $get_promotion_media_row['id_prm_m'];
                $update_promotion_media_query = $conn->prepare("UPDATE promotions_media SET etat = 0,etat_updt = 0 WHERE id_prm_m = $id_prm_m");
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
}
else{
    echo 0;
}
$get_promotion_product_boutique_query = $conn->prepare("SELECT id_prd_prm FROM produit_boutique_promotion WHERE id_prm = $id_prm");
$get_promotion_product_query = $conn->prepare("SELECT id_prd FROM produit_promotion WHERE id_prm = $id_prm AND nom_prd IS NOT NULL");
if ($get_promotion_product_boutique_query->execute() && $get_promotion_product_query->execute()){
    if ($get_promotion_product_query->rowCount() > 0 || $get_promotion_product_boutique_query->rowCount() > 0) {
        $delete_promotion_product_query = $conn->prepare("DELETE FROM produit_promotion WHERE id_prm = $id_prm AND nom_prd IS NULL");
        $update_promotion_product_query = $conn->prepare("UPDATE produit_promotion SET etat = 0 WHERE id_prm = $id_prm");
        $update_promotion_boutique_product_query = $conn->prepare("UPDATE produit_boutique_promotion SET etat = 0 WHERE id_prm = $id_prm");
        $update_promotion_product_media_query = $conn->prepare("UPDATE prm_produits_media SET etat = 0 WHERE id_prm = $id_prm");
        if ($delete_promotion_product_query->execute() && $update_promotion_product_query->execute() && $update_promotion_boutique_product_query->execute() && $update_promotion_product_media_query->execute()) {
            echo 1;
        }
        else{
            echo 0;
        }
    }
    else{
        $id_prd = htmlspecialchars($_POST['id_prd']);
        $nom_prd = htmlspecialchars($_POST['nom_prd']);
        $reference_prd = htmlspecialchars($_POST['reference_prd']);
        $quantite_prd = htmlspecialchars($_POST['quantite_prd']);
        $ancien_prix_prd = htmlspecialchars($_POST['ancien_prix_prd']);
        $nouveau_prix_prd = htmlspecialchars($_POST['nouveau_prix_prd']);
        $fonctionnalites_prd = htmlspecialchars($_POST['fonctionalites_prd']);
        $caracteristiques_prd = htmlspecialchars($_POST['caracteristiques_prd']);
        $avantages_prd = htmlspecialchars($_POST['avantages_prd']);
        $description_prd = htmlspecialchars($_POST['description_prd']);
        $create_promotion_product_query = $conn->prepare("UPDATE produit_promotion SET nom_prd = '$nom_prd', reference_prd = '$reference_prd', quantite_prd = '$quantite_prd', ancien_prix_prd = '$ancien_prix_prd', nouveau_prix_prd = '$nouveau_prix_prd',
        fonctionnalites_prd = '$fonctionnalites_prd', caracteristiques_prd = '$caracteristiques_prd', avantages_prd = '$avantages_prd', description_prd = '$description_prd', etat = 0 WHERE id_prm = $id_prm AND id_prd = $id_prd");
        if ($create_promotion_product_query->execute()) {
            $update_promotion_media_query = $conn->prepare("UPDATE promotions_media SET etat = 0 WHERE id_prm = $id_prm");
            $update_promotion_product_media_query = $conn->prepare("UPDATE prm_produits_media SET etat = 0 WHERE id_prd = $id_prd");
            if ($update_promotion_media_query->execute() && $update_promotion_product_media_query->execute()) {
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
}
else{
    echo 0;
}
?>