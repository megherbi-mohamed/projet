<?php 
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_user_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_user_query->execute();
$get_session_user_row = $get_session_user_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_user_row['id_user'];
$id_prd = htmlspecialchars($_POST['id_prd']);
$nom_prd = htmlspecialchars($_POST['nom_prd']);
$categorie_prd = htmlspecialchars($_POST['categorie_prd']);
$description_prd = htmlspecialchars($_POST['description_prd']);
$quantite_prd = htmlspecialchars($_POST['quantite_prd']);
$type_prd = htmlspecialchars($_POST['type_prd']);
$prix_prd = htmlspecialchars($_POST['prix_prd']);
$ville_prd = htmlspecialchars($_POST['ville_prd']);
$commune_prd = htmlspecialchars($_POST['commune_prd']);
$date =  date("Y-m-d h:i:sa");
$create_product_query = $conn->prepare("UPDATE produit_boutdechantier SET nom_prd = '$nom_prd', type_prd = '$type_prd', categorie_prd = '$categorie_prd',
description_prd = '$description_prd', quantite_prd = '$quantite_prd', prix_prd = '$prix_prd', ville_prd = '$ville_prd',commune_prd = '$commune_prd', date = '$date', etat = 0 WHERE id_prd = $id_prd AND id_user = $id_user");
if ($create_product_query->execute()) {
    $get_bt_product_media_query = $conn->prepare("SELECT * FROM bt_produits_media WHERE id_prd = $id_prd");
    if($get_bt_product_media_query->execute()) {
        while($get_bt_product_media_row = $get_bt_product_media_query->fetch(PDO::FETCH_ASSOC)){
            if ($get_bt_product_media_row['etat'] == 1 && $get_bt_product_media_row['etat_updt'] == 1) {
                $id_prd_m = $get_bt_product_media_row['id_prd_m'];
                $delete_prd_media_query = $conn->prepare("DELETE FROM bt_produits_media WHERE id_prd = $id_prd AND id_prd_m = $id_prd_m");
                if ($delete_prd_media_query->execute() && unlink($get_bt_product_media_row['media_url'])) {
                    echo 1;
                }
                else{
                    echo 0;
                    break;
                }
            }
            else if ($get_bt_product_media_row['etat'] == 1 && $get_bt_product_media_row['etat_updt'] == 0) {
                $id_prd_m = $get_bt_product_media_row['id_prd_m'];
                $update_prd_media_query = $conn->prepare("UPDATE bt_produits_media SET etat = 0,etat_updt = 0 WHERE id_prd = $id_prd AND id_prd_m = $id_prd_m");
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