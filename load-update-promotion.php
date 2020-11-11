<?php
include_once './bdd/connexion.php';
$tail_prm = htmlspecialchars($_POST['tail_prm']);
$id_prm = htmlspecialchars($_POST['id_prm']);
$get_promotion_query = $conn->prepare("SELECT * FROM promotions WHERE id_prm = $id_prm");
$get_promotion_query->execute();
$get_promotion_row = $get_promotion_query->fetch(PDO::FETCH_ASSOC);
$get_promotion_img_query = $conn->prepare("SELECT media_url,media_type FROM promotions_media WHERE id_prm = $id_prm");
$get_promotion_img_query->execute();
$get_promotion_img_row = $get_promotion_img_query->fetch(PDO::FETCH_ASSOC);

$id_prd = htmlspecialchars($_POST['id_prd']);
$get_promotion_product_query = $conn->prepare("SELECT * FROM produit_promotion WHERE id_prm = $id_prm");
$get_promotion_product_query->execute();
$get_promotion_product_row = $get_promotion_product_query->fetch(PDO::FETCH_ASSOC);
?>
<div class="create-publication-top">
    <div class="cancel-create-mobile" id="cancel_update_promotion_resp">
        <i class="fas fa-arrow-left"></i>
    </div>
    <h4>Modifier la promotion!</h4>
    <div class="cancel-create" id="cancel_update_promotion">
        <i class="fas fa-times"></i>
    </div>
</div>
<div class="create-publication-bottom">
    <div class="create-promotion-options" style="display:none">
        <div class="create-promotion-option" id="updt_promotion_image">
            <div>
                <P>Ajouter une photo de cette promotion</P>
                <i class="far fa-images"></i>
            </div>
        </div>
        <div class="create-promotion-option" id="updt_promotion_video">
            <div>
                <P>Ajouter une vidéo de cette promotion</P>
                <i class="fas fa-video"></i>
            </div>
        </div>
    </div>
    <div class="promotion-update-images-preview" style="display:block">
        <?php if ($get_promotion_img_row['media_type'] == 'i') { ?>
        <div class="promotion-image-preview" id="promotion_image_preview">
            <div id="promotion_update_image_preview">
                <i class="fas fa-times"></i>
            </div>
            <img src="<?php echo $get_promotion_img_row['media_url'] ?>">
        </div>
        <?php } else { ?>
        <!-- video -->
        <?php } ?>
    </div>
    <form enctype="multipart/form-data">
        <input type="file" id="update_image_promotion" name="image" accept="image/*">
        <input type="button" id="updt_promotion_image_button">
    </form>
    <form enctype="multipart/form-data">
        <input type="file" id="update_video_promotion" name="video" accept="video/*">
        <input type="button" id="updt_promotion_video_button">
    </form>
    <div class="promotion-input">
        <input type="text" id="updt_titre_prm" value="<?php echo $get_promotion_row['titre_prm'] ?>" autocomplete="off">
        <span class="titre-prm active-promotion-span">Titre *</span>
    </div>
    <div class="promotion-input">
        <span class="categorie-prm">Categorie *</span>
        <select id="updt_categorie_prm">
            <option value="">Categories</option>
            <option id="services" value="services">Services</option>
            <option id="artisants" value="artisants">Artisants</option>
            <option id="transports" value="transports">Transports</option>
            <option id="locations" value="locations">Locations</option>
            <option id="entreprises" value="entreprises">Entreprises</option>
            <option id="detaillons" value="detaillons">Detaillons</option>
            <option id="grossites" value="grossites">Grossistes</option>
            <option id="fabriquants" value="fabriquants">Fabriquants</option>
            <option id="import-export" value="import-export">Import-Export</option>
        </select>
    </div>
    <div class="promotion-input updt-sous-categorie-promotion">
        <span class="sous-categorie-prm">Sous categorie *</span>
        <select id="updt_sous_categorie_prm">
            <option value="">Sous categories</option>
        </select>
    </div>
    <div class="promotion-input updt-sous-categorie-autre">
        <span class="sous-categorie-prm">Sous categorie *</span>
        <input type="text" id="updt_sous_categorie_prm">
    </div>
    <div class="promotion-input">
        <input type="text" id="updt_lieu_prm" value="<?php echo $get_promotion_row['lieu_prm'] ?>" autocomplete="off">
        <span class="lieu-prm active-promotion-span">Lieu *</span>
    </div>
    <div class="promotion-preview-location">
        <?php 
        $ville_query = $conn->prepare("SELECT * FROM villes");
        $ville_query->execute(); 
        while ($ville_row = $ville_query->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <div id="update_promotion_location_item"><p><?php echo $ville_row['ville']; ?></p></div>
        <?php } ?>    
    </div>
    <div class="promotion-input">
        <input type="text" id="updt_adresse_prm" value="<?php echo $get_promotion_row['adresse_prm'] ?>" autocomplete="off">
        <span class="adresse-prm active-promotion-span">Adresse *</span>
    </div>
    <div class="update-promotion-localisation-gps">
        <p>Modifier la localisation gps (optionnelle)</p>
        <button onclick="getLocation()">Modifier</button>
        <input type="hidden" id="updt_latitude_prm" value="<?php echo $get_promotion_row['latitude_prm'] ?>">
        <input type="hidden" id="updt_longitude_prm" value="<?php echo $get_promotion_row['longitude_prm'] ?>">
    </div>
    <div class="promotion-input">
        <input type="datetime-local" id="updt_date_debut_prm" value="<?php echo date("Y-m-d\TH:i:s", strtotime($get_promotion_row['date_debut_prm'])); ?>">
        <span class="date-debut-prm">Date debut promotion *</span>
    </div>
    <div class="promotion-input">
        <input type="datetime-local" id="updt_date_fin_prm" value="<?php echo date("Y-m-d\TH:i:s", strtotime($get_promotion_row['date_fin_prm'])); ?>">
        <span class="date-fin-prm">Date fin promotion *</span>
    </div>
    <div class="promotion-input">
        <?php if ($get_promotion_row['description_prm'] == '') { ?>
            <span class="description-prm">Description</span>
        <?php } else { ?>
            <span class="description-prm active-promotion-span">Description</span>
        <?php } ?>
        <textarea id="updt_description_prm"><?php echo $get_promotion_row['description_prm'] ?></textarea>
    </div>
    <hr>
    <div class="promotion-input">
        <input type="text" id="updt_name_prm_prd" value="<?php echo $get_promotion_product_row['nom_prd'] ?>" autocomplete="off">
        <span class="name-prm-prd active-promotion-span">nom *</span>
    </div>
    <div class="promotion-input">
        <?php if ($get_promotion_product_row['reference_prd'] == '') { ?>
            <span class="reference-prm-prd">Reference</span>
        <?php } else { ?>
            <span class="reference-prm-prd active-promotion-span">Reference</span>
        <?php } ?>
        <input type="text" id="updt_reference_prm_prd" value="<?php echo $get_promotion_product_row['reference_prd'] ?>" autocomplete="off">
    </div>
    <div class="promotion-input">
        <?php if ($get_promotion_product_row['quantite_prd'] == '') { ?>
            <span class="quantity-prm-prd">Quantité</span>
        <?php } else { ?>
            <span class="quantity-prm-prd active-promotion-span">Quantité</span>
        <?php } ?>
        <input type="number" id="updt_quantity_prm_prd" value="<?php echo $get_promotion_product_row['quantite_prd'] ?>">
    </div>
    <div class="promotion-input">
        <input type="text" id="updt_price_prm_prd" value="<?php echo $get_promotion_product_row['prix_prd'] ?>">
        <span class="price-prm-prd active-promotion-span">Price *</span>
    </div>
    <div class="promotion-input">
        <?php if ($get_promotion_product_row['fonctionnalites_prd'] == '') { ?>
            <span class="fonctionality-prm-prd">fonctionalités</span>
        <?php } else { ?>
            <span class="fonctionality-prm-prd active-promotion-span">fonctionalités</span>
        <?php } ?>
        <input type="text" id="updt_fonctionality_prm_prd" value="<?php echo $get_promotion_product_row['fonctionnalites_prd'] ?>" autocomplete="off">
    </div>
    <div class="promotion-input">
        <?php if ($get_promotion_product_row['caracteristiques_prd'] == '') { ?>
            <span class="caracteristic-prm-prd">Caractéristiques</span>
        <?php } else { ?>
            <span class="caracteristic-prm-prd active-promotion-span">Caractéristiques</span>
        <?php } ?>
        <input type="text" id="updt_caracteristic_prm_prd" value="<?php echo $get_promotion_product_row['caracteristiques_prd'] ?>" autocomplete="off">
    </div>
    <div class="promotion-input">
        <?php if ($get_promotion_product_row['avantages_prd'] == '') { ?>
            <span class="avantage-prm-prd">Avantages</span>
        <?php } else { ?>
            <span class="avantage-prm-prd active-promotion-span">Avantages</span>
        <?php } ?>
        <input type="text" id="updt_avantage_prm_prd" value="<?php echo $get_promotion_product_row['avantages_prd'] ?>" autocomplete="off">
    </div>
    <div class="promotion-input">
        <?php if ($get_promotion_product_row['description_prd'] == '') { ?>
            <span class="description-prm-prd">Description</span>
        <?php } else { ?>
            <span class="description-prm-prd active-promotion-span">Description</span>
        <?php } ?>
        <textarea id="updt_description_prm_prd"><?php echo $get_promotion_product_row['description_prd'] ?></textarea>
    </div>
    <div class="promotion-product-update-images-preview">
    <?php
    $get_product_media_query = $conn->prepare("SELECT * FROM prm_produits_media WHERE id_prm = $id_prm");
    $get_product_media_query->execute();
    $i = 0;
    while ($get_product_media_row = $get_product_media_query->fetch(PDO::FETCH_ASSOC)){
    $i++;
    ?>
    <div class="prm-product-image-preview" id="prm_product_image_preview_<?php echo $i ?>">
        <div id="prm_product_update_preview_<?php echo $i ?>">
            <i class="fas fa-times"></i>
        </div>
        <img src="<?php echo $get_product_media_row['media_url'] ?>">
    </div>
    <?php } ?>
    </div>
    <div class="create-promotion-product-options">
        <P>Ajouter des photos</P>
        <div id="updt_promotion_product_image">
            <i class="far fa-images"></i>
        </div>
    </div>
    <form enctype="multipart/form-data">
        <input type="file" id="updt_image_promotion_product" name="images[]" accept="image/*" multiple>
        <input type="button" id="updt_promotion_product_image_button">
    </form>
    <input type="hidden" id="tail_updt_promotion" value="<?php echo $tail_prm ?>">
    <input type="hidden" id="id_updt_promotion" value="<?php echo $id_prm ?>">
    <input type="hidden" id="id_updt_promotion_product" value="<?php echo $id_prd ?>">
    <div class="update-promotion-button">
        <div id="loader_update_promotion_button" class="button-center"></div>
        <button id="final_update_promotion_button">Enregistrer les modificactions</button>
    </div>
</div>