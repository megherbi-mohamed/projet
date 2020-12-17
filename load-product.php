<?php
include_once './bdd/connexion.php';
$id_prd = htmlspecialchars($_POST['id_prd']);
$id = htmlspecialchars($_POST['tail_prd']);
$get_product_query = $conn->prepare("SELECT * FROM produit_boutique WHERE id_prd = $id_prd");
if ($get_product_query->execute()) {
    $get_product_row = $get_product_query->fetch(PDO::FETCH_ASSOC); 
    $get_product_media_query = $conn->prepare("SELECT media_url,media_type FROM produits_media WHERE id_prd = $id_prd LIMIT 1");
    if ($get_product_media_query->execute()) {
        $get_product_media_row = $get_product_media_query->fetch(PDO::FETCH_ASSOC);       
?>
<input type="hidden" id="id_prd_<?php echo $id ?>" value="<?php echo $get_product_row['id_prd'] ?>">
<input type="hidden" id="tail_prd_<?php echo $id ?>" value="<?php echo $id ?>">
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
        </div>
    </div>
</div>
<?php
    }
    else{
        echo 0;
    }
}
else{
    echo 0;
}
?>