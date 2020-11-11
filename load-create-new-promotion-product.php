<div class="select-boutique-product">
    <button id="select_boutique_product">Selectionner des produits depuis vos boutiques</button>
    <h5>Pourquoi cette option ?</h5>
    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aliquam nesciunt repellat voluptatum quis inventore asperiores aut reiciendis accusamus error corrupti!</p>
    <h4>OU créer un nouveau produit</h4>
</div>
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
    <input type="text" id="price_prm_prd" value="0">
    <span class="price-prm-prd">Price *</span>
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
<form enctype="multipart/form-data">
    <input type="file" id="image_promotion_product" name="images[]" accept="image/*" multiple>
    <input type="button" id="add_promotion_product_image_button">
</form>