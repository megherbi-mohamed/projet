<?php
session_start();
include_once './bdd/connexion.php';
$idBtq = $_POST['id_btq'];
$query = "INSERT INTO produit_boutique (id_btq,titre_prd,dscrp_prd,categorie_prd,prix_prd,image_1,image_2,image_3,image_4,modele_1,modele_2,modele_3,modele_4,prix_m_1,prix_m_2,prix_m_3,prix_m_4) VALUES 
('$idBtq','','','','','','','','','','','','','','','','')";

if(mysqli_query($conn, $query)){

    $id_product_query = "SELECT id_prd FROM produit_boutique WHERE id_prd IN ( SELECT max(id_prd) FROM produit_boutique WHERE id_btq = '$idBtq')";
    $id_product_result = mysqli_query($conn, $id_product_query);
    $id_product_row = mysqli_fetch_assoc($id_product_result);

    echo $id_product_row['id_prd'];
}
else{
    echo 0;
}

?>