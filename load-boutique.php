<?php 
session_start();
include_once './bdd/connexion.php';
$id_btq = htmlspecialchars($_POST['id_btq']);
$btq_inf_query = "SELECT * FROM boutiques WHERE id_btq = $id_btq";
$btq_inf_result = mysqli_query($conn, $btq_inf_query);
$btq_inf_row = mysqli_fetch_assoc($btq_inf_result);
$id_createur = $btq_inf_row['id_createur'];
?>
<div class="boutique-top">
    <div class="boutique-couverture-logo">
        <div class="boutique-couverture">
        <?php if ($btq_inf_row['couverture_btq'] != '') { ?>
            <img id="couverture_img" src="./<?php echo $btq_inf_row['couverture_btq'] ?>" alt="">
        <?php }else if($btq_inf_row['couverture_btq'] == ''){ ?>
            <img id="couverture_img" src="./boutique-couverture/couverture.png" alt="">
        <?php } ?>
        <div class="couverture-modification-icon" id="but_updt_img_cvrt">
            <i class="fas fa-camera"></i>
        </div>
        </div>
        <div class="boutique-logo">
        <?php if ($btq_inf_row['logo_btq'] != '') { ?>
            <img src="./<?php echo $btq_inf_row['logo_btq'] ?>" alt="">
        <?php }else if($btq_inf_row['logo_btq'] == ''){ ?>
            <img src="./boutique-logo/logo.png" alt="">
        <?php } ?>
        <div class="logo-modification-icon" id="but_updt_img_logo">
            <i class="fas fa-camera"></i>
        </div>
        </div>
    </div>
    <div class="boutique-options">
        <h3><?php echo $btq_inf_row['nom_btq'] ?></h3>
    </div>   
</div>
<div class="boutique-bottom">
<?php 
$get_product_query = "SELECT * FROM produit_boutique WHERE id_btq = '{$btq_inf_row['id_btq']}' ORDER BY id_prd DESC";
$get_product_result = mysqli_query($conn,$get_product_query);
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
            <button id="display_product_details_<?php echo $i ?>">Details</button>
        </div>
    </div>
</div>
<?php } ?>
</div>