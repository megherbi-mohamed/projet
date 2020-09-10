<?php
session_start();
include_once './bdd/connexion.php';
$titre_prd = $_POST['titre_prd'];
$description_prd = $_POST['description_prd'];
$categorie_prd = $_POST['categorie_prd'];
$quantite_prd = $_POST['quantite_prd'];
$prix_prd = $_POST['prix_prd'];
$prix_modele_1 = $_POST['prix_modele_1'];
$prix_modele_2 = $_POST['prix_modele_2'];
$prix_modele_3 = $_POST['prix_modele_3'];
$prix_modele_4 = $_POST['prix_modele_4'];
$id_prd = $_POST['id_prd'];

$valide_product_query = "UPDATE produit_boutique SET titre_prd = '$titre_prd',dscrp_prd = '$description_prd',categorie_prd = '$categorie_prd',quantite_prd = '$quantite_prd',
prix_prd = '$prix_prd',prix_m_1 = '$prix_modele_1',prix_m_2 = '$prix_modele_2',prix_m_3 = '$prix_modele_3',prix_m_4 = '$prix_modele_4' WHERE id_prd = '$id_prd'";

if(mysqli_query($conn, $valide_product_query)){

    $get_product_query = "SELECT * FROM produit_boutique WHERE id_prd = '$id_prd'";
    $get_product_result = mysqli_query($conn, $get_product_query);
    $get_product_row = mysqli_fetch_assoc($get_product_result);

    echo "
        <div class='boutique-product'>
            <div class='boutique-product-modify-option'>
                <i id='modify_product_icon' class='fas fa-pen'></i>
            </div>
            <div class='boutique-product-delete-option'>
                <i id='delete_product_icon' class='fas fa-trash'></i>
            </div>
            <img src='./".$get_product_row['image_1']."' alt=''>
            <p>".$get_product_row['titre_prd']."</p>
            <div class='boutique-product-details'>
                <h4>".$get_product_row['prix_prd'].' DA'."</h4>
                <a href='./produit.php?id=".$get_product_row['id_prd']."'>Details ..</a>
            </div>
        </div>
    ";
}
else{
    echo 0;
}