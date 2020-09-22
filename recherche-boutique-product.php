<?php 
session_start();
include_once './bdd/connexion.php';
$id_btq = htmlspecialchars($_POST['id_btq']);
$text = htmlspecialchars($_POST['text']);
?>
<div class="boutique-bottom">
<?php 
$get_product_query = "SELECT * FROM produit_boutique WHERE id_btq = $id_btq AND (nom_prd LIKE '%$text%' OR description_prd 
OR reference_prd LIKE '%$text%' OR categorie_prd LIKE '%$text%' OR caracteristique_prd LIKE '%$text%' OR fonctionnalite_prd 
LIKE '%$text%') ORDER BY id_prd DESC";
$get_product_result = mysqli_query($conn,$get_product_query);
if (mysqli_num_rows($get_product_result) > 0) {
$i = 0;
while ($get_product_row = mysqli_fetch_assoc($get_product_result)){
$i++;
$get_product_media_query = "SELECT * FROM produits_media WHERE id_prd = '{$get_product_row['id_prd']}' LIMIT 1";
$get_product_media_result = mysqli_query($conn,$get_product_media_query);
$get_product_media_row = mysqli_fetch_assoc($get_product_media_result);
?>
<input type="hidden" id="id_prd_<?php echo $i ?>" value="<?php echo $get_product_row['id_prd'] ?>">
<input type="hidden" id="product_tail_<?php echo $i ?>" value="<?php echo $i ?>">
<input type="hidden" id="name_prd_<?php echo $i ?>" value="<?php echo $get_product_row['nom_prd'] ?>">
<input type="hidden" id="reference_prd_<?php echo $i ?>" value="<?php echo $get_product_row['reference_prd'] ?>">
<input type="hidden" id="categorie_prd_<?php echo $i ?>" value="<?php echo $get_product_row['categorie_prd'] ?>">
<input type="hidden" id="description_prd_<?php echo $i ?>" value="<?php echo $get_product_row['description_prd'] ?>">
<input type="hidden" id="quantity_prd_<?php echo $i ?>" value="<?php echo $get_product_row['quantite_prd'] ?>">
<input type="hidden" id="price_prd_<?php echo $i ?>" value="<?php echo $get_product_row['prix_prd'] ?>">
<div class="boutique-product" id="boutique_product_<?php echo $i ?>">
    <div class="product-option-button" id="display_prd_options_button_<?php echo $i ?>">
        <i class="fas fa-ellipsis-v"></i>
    </div>
    <div class="product-options" id="product_options_<?php echo $i ?>">
        <div class="product-option" id="update_product_<?php echo $i ?>">
            <i class="fas fa-pen"></i>
            <div>
                <p>Modifer le produit</p>
            </div>
        </div>
        <div class="product-option" id="delete_product_<?php echo $i ?>">
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
            <!-- <button id="display_product_details_<?php echo $i ?>">Details</button> -->
        </div>
    </div>
</div>
<?php } ?>
</div>
<?php }else{ ?>
<div class="empty-msg-ntf">
    <p>Auccun produit pour (<?php echo $text ?>)</p>
</div>
<?php } ?>