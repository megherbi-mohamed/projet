<?php
include_once './bdd/connexion.php';
$id_prm = htmlspecialchars($_POST['id_prm']);
$id_btq = htmlspecialchars($_POST['id_btq']);
$id_prd = htmlspecialchars($_POST['id_prd']);
?>
<div class="back-to-boutique-product-promotion">
    <button id="back_to_boutique_product_promotion"><i class="fas fa-arrow-left"></i>Produits</button>
    <div>
        <div id="loader_create_promotion_product_button" class="button-center"></div>
        <button id="valide_product_promotion">Valider</button>
    </div>
</div>
<div class="promotion-product-details-images">
<?php
$get_product_details_query = $conn->prepare("SELECT id_prd FROM produit_boutique WHERE id_prd = $id_prd");
if($get_product_details_query->execute()){
$get_product_details_row = $get_product_details_query->fetch(PDO::FETCH_ASSOC);
$id_prd = $get_product_details_row['id_prd'];
$get_product_media_query = $conn->prepare("SELECT media_url FROM produits_media WHERE id_prd = $id_prd");
$get_product_media_query->execute(); 
$i = 0;
while ($get_product_media_row = $get_product_media_query->fetch(PDO::FETCH_ASSOC)) {
$i++;
$img_prd = $get_product_media_row['media_url'];

$get_product_promotion_media_query = $conn->prepare("SELECT media_url FROM produit_boutique_promotion WHERE id_btq_prd = $id_prd AND id_btq = $id_btq AND media_url = '$img_prd' AND id_prm = $id_prm");
$get_product_promotion_media_query->execute();
if ($get_product_promotion_media_query->rowCount() > 0) {
?>
<div class="promotion-product-image" id="promotion_product_image_<?php echo $i ?>" style="opacity:.6">
    <i class="fas fa-check etat"></i>
    <img src="<?php echo $img_prd ?>" alt="">
</div>
<?php } else { ?>
<div class="promotion-product-image" id="promotion_product_image_<?php echo $i ?>">
    <img src="<?php echo $img_prd ?>" alt="">
</div>  
<?php }} ?>
</div>
<div class="promotion-price-product">
<input type="hidden" id="id_btq_prm" value="<?php echo $id_btq ?>">
<input type="hidden" id="id_prm_prd" value="<?php echo $id_prd ?>">
<?php 
$get_product_promotion_price_query = $conn->prepare("SELECT prix_prm_prd FROM produit_boutique_promotion WHERE id_btq_prd = $id_prd AND id_btq = $id_btq AND id_prm = $id_prm");
$get_product_promotion_price_query->execute();
$prix_prm = 0;
if ($get_product_promotion_price_query->rowCount() > 0) {
    $get_product_promotion_price_row = $get_product_promotion_price_query->fetch(PDO::FETCH_ASSOC);
    $prix_prm = $get_product_promotion_price_row['prix_prm_prd'];
}
?>
<input type="text" id="prm_price_prd" autocomplete="off" value="<?php echo $prix_prm ?>">
<span>Nouveau prix (prix promotion)</span>
</div>
<div class="select-image-alert-message">
    <p>S'il vous plait selectionner une photo.</p>
</div>
<?php } else { 
echo 0;
}?>