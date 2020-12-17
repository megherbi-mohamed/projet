<?php
session_start();
include_once './bdd/connexion.php';
$id_prd = htmlspecialchars($_POST['id_prd']);
$nom_prd = htmlspecialchars($_POST['nom_prd']);
$reference_prd = htmlspecialchars($_POST['reference_prd']);
$description_prd = htmlspecialchars($_POST['description_prd']);
$caracteristique_prd = htmlspecialchars($_POST['caracteristique_prd']);
$fonctionnalite_prd = htmlspecialchars($_POST['fonctionnalite_prd']);
$avantage_prd = htmlspecialchars($_POST['avantage_prd']);
$categorie_prd = htmlspecialchars($_POST['categorie_prd']);
$quantite_prd = htmlspecialchars($_POST['quantite_prd']);
$prix_prd = htmlspecialchars($_POST['prix_prd']);
$update_product_query = $conn->prepare("UPDATE produit_boutique SET nom_prd = '$nom_prd', reference_prd = '$reference_prd',
categorie_prd = '$categorie_prd',description_prd = '$description_prd', caracteristique_prd = '$caracteristique_prd', 
fonctionnalite_prd = '$fonctionnalite_prd', avantage_prd = '$avantage_prd',quantite_prd = '$quantite_prd',
prix_prd = '$prix_prd' WHERE id_prd = $id_prd");
if($update_product_query->execute()){
    $get_product_media_query = $conn->prepare("SELECT * FROM produits_media WHERE id_prd = $id_prd");
    if($get_product_media_query->execute()) {
        while($get_product_media_row = $get_product_media_query->fetch(PDO::FETCH_ASSOC)){
            if (($get_product_media_row['etat'] == 1 && $get_product_media_row['etat_updt'] == 1) || ($get_product_media_row['etat'] == 0 && $get_product_media_row['etat_updt'] == 1)) {
                $id_prd_m = $get_product_media_row['id_prd_m'];
                $delete_prd_media_query = $conn->prepare("DELETE FROM produits_media WHERE id_prd = $id_prd AND id_prd_m = $id_prd_m");
                if ($delete_prd_media_query->execute() && unlink($get_product_media_row['media_url'])) {
                    echo 1;
                }
                else{
                    echo 0;
                    break;
                }
            }
            else if ($get_product_media_row['etat'] == 1 && $get_product_media_row['etat_updt'] == 0) {
                $id_prd_m = $get_product_media_row['id_prd_m'];
                $update_prd_media_query = $conn->prepare("UPDATE produits_media SET etat = 0,etat_updt = 0 WHERE id_prd = $id_prd AND id_prd_m = $id_prd_m");
                if ($update_prd_media_query->execute()) {
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
        echo 0;
    }
}
else{
    echo 0;
}
?>