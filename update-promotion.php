<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_user_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_user_query->execute();
$get_session_user_row = $get_session_user_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_user_row['id_user'];
$tail_prm = htmlspecialchars($_POST['tail_prm']);
$id_prm = htmlspecialchars($_POST['id_prm']);
$titre_prm = htmlspecialchars($_POST['titre_prm']);
$categorie_prm = htmlspecialchars($_POST['categorie_prm']);
$sous_categorie_prm = htmlspecialchars($_POST['sous_categorie_prm']);
$ville_prm = htmlspecialchars($_POST['ville_prm']);
$commune_prm = htmlspecialchars($_POST['commune_prm']);
$adresse_prm = htmlspecialchars($_POST['adresse_prm']);
$latitude_prm = htmlspecialchars($_POST['latitude_prm']);
$longitude_prm = htmlspecialchars($_POST['longitude_prm']);
$date_debut_prm = htmlspecialchars($_POST['date_debut_prm']);
$date_fin_prm = htmlspecialchars($_POST['date_fin_prm']);
$description_prm = htmlspecialchars($_POST['description_prm']);
$update_promotion_query = $conn->prepare("UPDATE promotions SET titre_prm = '$titre_prm', categorie_prm = '$categorie_prm', sous_categorie_prm = '$sous_categorie_prm', ville_prm = '$ville_prm', commune_prm = '$commune_prm', adresse_prm = '$adresse_prm', 
latitude_prm = $latitude_prm, longitude_prm = $longitude_prm, date_debut_prm = '$date_debut_prm', date_fin_prm = '$date_fin_prm', description_prm = '$description_prm' WHERE id_prm = $id_prm AND id_user = $id_user");
$create_product_boutique_promotion_query = $conn->prepare("UPDATE produit_boutique_promotion SET etat = 0 WHERE id_prm = $id_prm");
if ($update_promotion_query->execute() && $create_product_boutique_promotion_query->execute()){
    $get_promotion_product_query = $conn->prepare("SELECT id_prd FROM produit_promotion WHERE id_prm = $id_prm AND nom_prd IS NOT NULL");
    $get_promotion_product_boutique_query = $conn->prepare("SELECT id_prd_prm FROM produit_boutique_promotion WHERE id_prm = $id_prm");
    if ($get_promotion_product_query->execute() && $get_promotion_product_boutique_query->execute()) {
        if ($get_promotion_product_query->rowCount() > 0 || $get_promotion_product_boutique_query->rowCount() > 0) {
            $delete_promotion_product_query = $conn->prepare("DELETE FROM produit_promotion WHERE id_prm = $id_prm AND nom_prd IS NULL");
            if ($delete_promotion_product_query->execute()) {
                $update_promotion_product_query = $conn->prepare("UPDATE produit_promotion SET etat = 0 WHERE id_prm = $id_prm");
                $update_promotion_boutique_product_query = $conn->prepare("UPDATE produit_boutique_promotion SET etat = 0 WHERE id_prm = $id_prm");
                if ($update_promotion_product_query->execute() && $update_promotion_boutique_product_query->execute()) {
                    $update_promotion_media_query = $conn->prepare("UPDATE promotions_media SET etat = 0 WHERE id_prm = $id_prm");
                    $update_promotion_product_media_query = $conn->prepare("UPDATE promotions_media SET etat = 0 WHERE id_prm = $id_prm");
                    $update_promotion_boutique_product_media_query = $conn->prepare("UPDATE prm_produits_media SET etat = 0 WHERE id_prm = $id_prm");
                    if ($update_promotion_media_query->execute() && $update_promotion_product_media_query->execute() && $update_promotion_boutique_product_media_query->execute()) {
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
        }
        else{
            echo $id_prd = htmlspecialchars($_POST['id_prd']);
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
    else {
        echo 0;
    }
}
else {
    echo 0;
}
?>