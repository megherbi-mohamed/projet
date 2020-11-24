<?php
include_once './bdd/connexion.php';
$id_prm = htmlspecialchars($_POST['id_prm']);
$etat = 1;
$create_prm_prd_query = $conn->prepare("INSERT INTO produit_promotion (id_prm,etat) VALUES (:id_prm,:etat)");
    $create_prm_prd_query->bindParam(':id_prm',$id_prm);
    $create_prm_prd_query->bindParam(':etat',$etat);
    if ($create_prm_prd_query->execute()) {
        $get_prm_prd_query = $conn->prepare("SELECT id_prd FROM produit_promotion WHERE id_prd IN (SELECT MAX(id_prd) FROM produit_promotion WHERE id_prm = $id_prm AND etat = 1)");
        if ($get_prm_prd_query->execute()) {
            $get_prm_prd_row = $get_prm_prd_query->fetch(PDO::FETCH_ASSOC);
?>
<div class="select-boutique-product">
    <button id="select_boutique_product">Selectionner des produits depuis vos boutiques</button>
    <h5>Pourquoi cette option ?</h5>
    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aliquam nesciunt repellat voluptatum quis inventore asperiores aut reiciendis accusamus error corrupti!</p>
    <h4>OU créer un nouveau produit</h4>
</div>
<?php 
$get_crtd_prd_query = $conn->prepare("SELECT id_prd,nom_prd FROM produit_promotion WHERE id_prm = $id_prm AND nom_prd IS NOT null");
$get_crtd_prd_query->execute();
$get_crtd_btq_prd_query = $conn->prepare("SELECT id_prd_prm,id_btq,id_btq_prd,media_url FROM produit_boutique_promotion WHERE id_prm = $id_prm");
$get_crtd_btq_prd_query->execute();
if ($get_crtd_prd_query->rowCount()+$get_crtd_btq_prd_query->rowCount() > 0) {
?>
<div class="products-promotion-overview">
<?php 
$i = 0;
while ($get_crtd_prd_row = $get_crtd_prd_query->fetch(PDO::FETCH_ASSOC)) {
    $i++;
    $get_crtd_prd_media_query = $conn->prepare("SELECT media_url FROM prm_produits_media WHERE id_prm = $id_prm AND id_prd = {$get_crtd_prd_row['id_prd']}");
    $get_crtd_prd_media_query->execute();
    $get_crtd_prd_media_row = $get_crtd_prd_media_query->fetch(PDO::FETCH_ASSOC);
?>
<input type="hidden" id="id_prd_ovrw_<?php echo $i ?>" value="<?php echo $get_crtd_prd_row['id_prd'] ?>">
<div class="product-promotion-overview" id="product_promotion_overview_<?php echo $i ?>">
    <div class="product-promotion-overview-image">
        <img src="<?php echo $get_crtd_prd_media_row['media_url'] ?>" alt="">
    </div>
    <h5><?php echo $get_crtd_prd_row['nom_prd'] ?></h5>
</div>
<?php } ?>
<?php
$j = 0;
while ($get_crtd_btq_prd_row = $get_crtd_btq_prd_query->fetch(PDO::FETCH_ASSOC)) {
    $j++;
    $id_btq_prd = $get_crtd_btq_prd_row['id_btq_prd'];
    $get_prm_prd_name_query = $conn->prepare("SELECT nom_prd FROM produit_boutique WHERE id_prd = $id_btq_prd");
    $get_prm_prd_name_query->execute();
    $get_prm_prd_name_row = $get_prm_prd_name_query->fetch(PDO::FETCH_ASSOC);
?>
<input type="hidden" id="id_btq_prd_ovrw_<?php echo $j ?>" value="<?php echo $get_crtd_btq_prd_row['id_btq'] ?>">
<input type="hidden" id="id_prd_btq_ovrw_<?php echo $j ?>" value="<?php echo $get_crtd_btq_prd_row['id_btq_prd'] ?>">
<div class="product-boutique-promotion-overview" id="product_boutique_promotion_overview_<?php echo $j ?>">
    <div class="product-promotion-overview-image">
        <img src="<?php echo $get_crtd_btq_prd_row['media_url'] ?>" alt="">
    </div>
    <h5><?php echo $get_prm_prd_name_row['nom_prd'] ?></h5>
</div>
<?php } ?>
</div>
<?php } ?>
<div class="promotion-input">
    <input type="text" id="name_prm_prd" autocomplete="off">
    <span class="name-prm-prd">nom *</span>
</div>
<div class="promotion-input">
    <input type="text" id="reference_prm_prd" autocomplete="off">
    <span class="reference-prm-prd">Reference</span>
</div>
<div class="promotion-input">
    <input type="number" id="quantity_prm_prd" value="0">
    <span class="quantity-prm-prd">Quantité</span>
</div>
<div class="promotion-input">
    <input type="text" id="old_price_prm_prd" value="0">
    <span class="old-price-prm-prd">Ancien prix *</span>
</div>
<div class="promotion-input">
    <input type="text" id="new_price_prm_prd" value="0">
    <span class="new-price-prm-prd">Nouveau prix *</span>
</div>
<div class="promotion-input">
    <input type="text" id="fonctionality_prm_prd" autocomplete="off">
    <span class="fonctionality-prm-prd">fonctionalités</span>
</div>
<div class="promotion-input">
    <input type="text" id="caracteristic_prm_prd" autocomplete="off">
    <span class="caracteristic-prm-prd">Caractéristiques</span>
</div>
<div class="promotion-input">
    <input type="text" id="avantage_prm_prd" autocomplete="off">
    <span class="avantage-prm-prd">Avantages</span>
</div>
<div class="promotion-input">
    <textarea id="description_prm_prd"></textarea>
    <span class="description-prm-prd">Description</span>
</div>
<div class="promotion-product-images-preview"></div>
<div class="create-promotion-product-options">
    <P>Ajouter des photos</P>
    <div id="add_promotion_product_image">
        <i class="far fa-images"></i>
    </div>
</div>
<div class="create-new-promotion-product">
    <p>Ajouter un nouveau produit</p>
    <button id="add_new_product_promotion">Ajouter</button>
</div>
<form enctype="multipart/form-data">
    <input type="file" id="image_promotion_product" name="images[]" accept="image/*" multiple>
    <input type="button" id="add_promotion_product_image_button">
</form>
<input type="hidden" id="id_promotion_product" value="<?php echo $get_prm_prd_row['id_prd'] ?>">
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