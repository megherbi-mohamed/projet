<?php
session_start();
include_once './bdd/connexion.php';
$id_prd = $_POST['id_prd'];
$nom_prd = $_POST['nom_prd'];
$reference_prd = $_POST['reference_prd'];
$description_prd = $_POST['description_prd'];
$categorie_prd = $_POST['categorie_prd'];
$quantite_prd = $_POST['quantite_prd'];
$prix_prd = $_POST['prix_prd'];
$id = $_POST['tail_prd'];

$update_product_query = "UPDATE produit_boutique SET nom_prd = '$nom_prd', reference_prd = '$reference_prd',
categorie_prd = '$categorie_prd',description_prd = '$description_prd', quantite_prd = '$quantite_prd',
prix_prd = '$prix_prd' WHERE id_prd = '$id_prd'";
if(mysqli_query($conn, $update_product_query)){
    $update_media_query = "UPDATE produits_media SET etat = 0 WHERE id_prd = '$id_prd'";
    if (mysqli_query($conn,$update_media_query)) {
        $get_product_query = "SELECT * FROM produit_boutique WHERE id_prd = '$id_prd'";
        if ($get_product_result = mysqli_query($conn,$get_product_query)) {
            $get_product_row = mysqli_fetch_assoc($get_product_result); 
            $get_product_media_query = "SELECT * FROM produits_media WHERE id_prd = '$id_prd' LIMIT 1";
            $get_product_media_result = mysqli_query($conn,$get_product_media_query);
            $get_product_media_row = mysqli_fetch_assoc($get_product_media_result);       
?>

<input type="hidden" id="id_prd_<?php echo $id ?>" value="<?php echo $get_product_row['id_prd'] ?>">
<input type="hidden" id="product_tail_<?php echo $id ?>" value="<?php echo $i ?>">
<input type="hidden" id="name_prd_<?php echo $id ?>" value="<?php echo $get_product_row['nom_prd'] ?>">
<input type="hidden" id="reference_prd_<?php echo $id ?>" value="<?php echo $get_product_row['reference_prd'] ?>">
<input type="hidden" id="categorie_prd_<?php echo $id ?>" value="<?php echo $get_product_row['categorie_prd'] ?>">
<input type="hidden" id="description_prd_<?php echo $id ?>" value="<?php echo $get_product_row['description_prd'] ?>">
<input type="hidden" id="quantity_prd_<?php echo $id ?>" value="<?php echo $get_product_row['quantite_prd'] ?>">
<input type="hidden" id="price_prd_<?php echo $id ?>" value="<?php echo $get_product_row['prix_prd'] ?>">
<div class="boutique-product" id="boutique_product_<?php echo $id ?>">
    <div class="product-option-button" id="display_prd_options_button_<?php echo $id ?>">
        <i class="fas fa-ellipsis-v"></i>
    </div>
    <div class="product-options" id="product_options_<?php echo $id ?>">
        <div class="product-option" id="update_product_<?php echo $id ?>">
            <i class="fas fa-pen"></i>
            <div>
                <p>Modifer le produit</p>
            </div>
        </div>
        <div class="product-option" id="delete_product_<?php echo $id ?>">
            <i class="fas fa-trash"></i>
            <div>
                <p>Supprimer le produit</p>
            </div>
        </div>
    </div>
    <div class="boutique-product-img">
        <img src="<?php echo $get_product_media_row['media_url'] ?>" alt="">
    </div>
    <div class="product-description">
        <div class="product-description-top">
            <p><?php echo $get_product_row['description_prd'] ?></p>
        </div>
        <div class="product-description-bottom">
            <h4><?Php echo $get_product_row['prix_prd'].' DA' ?></h4>
            <button id="display_product_details_<?php echo $id ?>">Details</button>
        </div>
    </div>
</div>

<?php
        }else{
            echo 0;
        }
    }else{
        echo 0;
    }
}else{
    echo 0;
}
?>