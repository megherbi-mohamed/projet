<?php
include_once './bdd/connexion.php';
$id_prm = htmlspecialchars($_POST['id_prm']);
$id_prd = htmlspecialchars($_POST['id_prd']);
$get_prm_prd_query = $conn->prepare("SELECT * FROM produit_promotion WHERE id_prm = $id_prm AND id_prd = $id_prd");
if ($get_prm_prd_query->execute()) {
    $get_prm_prd_row = $get_prm_prd_query->fetch(PDO::FETCH_ASSOC);
    $id_prd = $get_prm_prd_row['id_prd'];
    $nom_prd = $get_prm_prd_row['nom_prd'];
    $reference_prd = $get_prm_prd_row['reference_prd'];
    $quantite_prd = $get_prm_prd_row['quantite_prd'];
    $ancien_prix_prd = $get_prm_prd_row['ancien_prix_prd'];
    $nouveau_prix_prd = $get_prm_prd_row['nouveau_prix_prd'];
    $fonctionnalites_prd = $get_prm_prd_row['fonctionnalites_prd'];
    $caracteristiques_prd = $get_prm_prd_row['caracteristiques_prd'];
    $avantages_prd = $get_prm_prd_row['avantages_prd'];
    $description_prd = $get_prm_prd_row['description_prd'];
?>
<div class="create-promotion-product-container" id="create_promotion_product_container">
    <div class="create-promotion-product-top">
        <div class="cancel-create-promotion-product" id="cancel_create_promotion_product">
            <i class="fas fa-arrow-left"></i>
        </div>
        <h4>Produits details</h4>
        <div class="create-publication-top-button">
            <div id="loader_create_publication_top_button" class="button-center"></div>
            <button id="final_create_promotion_button">Créer</button>
        </div>
    </div>
    <div class="create-publication-bottom create-promotion-product-bottom">
        <div class="create-promotion-product-bottom-container" id="create_promotion_product_bottom_container">
            <div class="select-boutique-product">
                <button id="select_boutique_product">Selectionner des produits depuis vos boutiques</button>
                <h5>Pourquoi cette option ?</h5>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aliquam nesciunt repellat voluptatum quis inventore asperiores aut reiciendis accusamus error corrupti!</p>
                <h4>OU créer un nouveau produit</h4>
            </div>
            <?php 
            $get_crtd_prd_query = $conn->prepare("SELECT id_prd,nom_prd FROM produit_promotion WHERE id_prm = $id_prm AND nom_prd IS NOT null");
            $get_crtd_prd_query->execute();
            if ($get_crtd_prd_query->rowCount() > 0) {
            ?>
            <div class="products-promotion-overview">
            <?php 
            $i = 0;
            while ($get_crtd_prd_row = $get_crtd_prd_query->fetch(PDO::FETCH_ASSOC)) {
                $i++;
                $get_crtd_prd_media_query = $conn->prepare("SELECT media_url,media_type FROM prm_produits_media WHERE id_prm = $id_prm AND id_prd = {$get_crtd_prd_row['id_prd']}");
                $get_crtd_prd_media_query->execute();
                $get_crtd_prd_media_row = $get_crtd_prd_media_query->fetch(PDO::FETCH_ASSOC);
            ?>
            <input type="hidden" id="id_prd_ovrw_<?php echo $i ?>" value="<?php echo $get_crtd_prd_row['id_prd'] ?>">
            <div class="product-promotion-overview" id="product_promotion_overview_<?php echo $i ?>">
                <?php if ($get_crtd_prd_media_row['media_type'] == 'i') { ?>
                <div class="product-promotion-overview-image">
                    <img src="<?php echo $get_crtd_prd_media_row['media_url'] ?>" alt="">
                </div>
                <?php } else { ?>
                <div class="product-promotion-overview-video">
                    <video><source src="<?php echo $get_crtd_prd_media_row['media_url']?>"></video>
                    <i class="fas fa-play"></i>
                </div>
                <?php } ?>
                <h5><?php echo $get_crtd_prd_row['nom_prd'] ?></h5>
            </div>
            <?php } ?>
            </div>
            <?php } ?>
            <div class="delete-product-promotion-overview">
                <p>Modifier ou supprimer ce produit</p>
                <button id="cancel_product_promotion_overview">Annuler</button>
                <button id="delete_product_promotion_overview">Supprimer</button>
            </div>
            <div class="promotion-input">
                <?php if ($nom_prd == null) { ?>
                <span class="name-prm-prd">nom *</span>
                <?php } else { ?>
                <span class="name-prm-prd active-promotion-span">nom *</span>
                <?php } ?>
                <input type="text" id="name_prm_prd" autocomplete="off" value="<?php echo $nom_prd ?>">
            </div>
            <div class="promotion-input">
                <?php if ($reference_prd == null) { ?>
                <span class="reference-prm-prd">Reference</span>
                <?php } else { ?>
                <span class="reference-prm-prd active-promotion-span">Reference</span>
                <?php } ?>
                <input type="text" id="reference_prm_prd" autocomplete="off" value="<?php echo $reference_prd ?>">
            </div>
            <div class="promotion-input">
                <?php if ($quantite_prd == null) { ?>
                <span class="quantity-prm-prd">Quantité</span>
                <?php } else { ?>
                <span class="quantity-prm-prd active-promotion-span">Quantité</span>
                <?php } ?>
                <input type="number" id="quantity_prm_prd" value="<?php echo $quantite_prd ?>">
            </div>
            <div class="promotion-input">
                <?php if ($ancien_prix_prd == null) { ?>
                <span class="old-price-prm-prd">Price *</span>
                <?php } else { ?>
                <span class="old-price-prm-prd active-promotion-span">Price *</span>
                <?php } ?>
                <input type="text" id="old_price_prm_prd" value="<?php echo $ancien_prix_prd ?>">
            </div>
            <div class="promotion-input">
                <?php if ($nouveau_prix_prd == null) { ?>
                <span class="new-price-prm-prd">Price *</span>
                <?php } else { ?>
                <span class="new-price-prm-prd active-promotion-span">Price *</span>
                <?php } ?>
                <input type="text" id="new_price_prm_prd" value="<?php echo $nouveau_prix_prd ?>">
            </div>
            <div class="promotion-input">
                <?php if ($fonctionnalites_prd == null) { ?>
                <span class="fonctionality-prm-prd">fonctionalités</span>
                <?php } else { ?>
                <span class="fonctionality-prm-prd active-promotion-span">fonctionalités</span>
                <?php } ?>
                <input type="text" id="fonctionality_prm_prd" autocomplete="off" value="<?php echo $fonctionnalites_prd ?>">
            </div>
            <div class="promotion-input">
                <?php if ($caracteristiques_prd == null) { ?>
                <span class="caracteristic-prm-prd">Caractéristiques</span>
                <?php } else { ?>
                <span class="caracteristic-prm-prd active-promotion-span">Caractéristiques</span>
                <?php } ?>
                <input type="text" id="caracteristic_prm_prd" autocomplete="off" value="<?php echo $caracteristiques_prd ?>">
            </div>
            <div class="promotion-input">
                <?php if ($avantages_prd == null) { ?>
                <span class="avantage-prm-prd">Avantages</span>
                <?php } else { ?>
                <span class="avantage-prm-prd active-promotion-span">Avantages</span>
                <?php } ?>
                <input type="text" id="avantage_prm_prd" autocomplete="off" value="<?php echo $avantages_prd ?>">
            </div>
            <div class="promotion-input">
                <?php if ($description_prd == null) { ?>
                <span class="description-prm-prd">Description</span>
                <?php } else { ?>
                <span class="description-prm-prd active-promotion-span">Description</span>
                <?php } ?>
                <textarea id="description_prm_prd"><?php echo $description_prd ?></textarea>
            </div>
            <div class="promotion-product-images-preview-container">
                <div class="promotion-product-images-preview">
                    <?php
                    $get_product_images_query = $conn->prepare("SELECT media_url FROM prm_produits_media WHERE id_prm = $id_prm AND id_prd = $id_prd AND media_type = 'i'");
                    $get_product_images_query->execute();
                    $i = 0;
                    while ($get_product_images_row = $get_product_images_query->fetch(PDO::FETCH_ASSOC)){
                    $i++;
                    ?>
                    <div class="prm-product-image-preview" id="prm_product_image_preview_<?php echo $i ?>">
                        <div class='delete-preview' id="prm_product_delete_preview_<?php echo $i ?>">
                            <i class="fas fa-times"></i>
                        </div>
                        <img src="<?php echo $get_product_images_row['media_url'] ?>">
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="promotion-product-video-preview-container">
                <div class="promotion-product-video-preview">
                    <?php
                    $get_product_video_query = $conn->prepare("SELECT media_url FROM prm_produits_media WHERE id_prm = $id_prm AND id_prd = $id_prd AND media_type = 'v'");
                    $get_product_video_query->execute();
                    if ($get_product_video_query->rowCount() > 0) {
                        $get_product_video_row = $get_product_video_query->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <div class="prm-product-video-preview" id="prm_product_video_preview">
                        <div class='delete-preview' id="prm_product_delete_video">
                            <i class="fas fa-times"></i>
                        </div>
                        <video controls><source src="<?php echo $get_product_video_row['media_url']?>"></video>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="create-promotion-product-options">
                <P>Ajouter des photos</P>
                <div id="add_promotion_product_image">
                    <i class="far fa-images"></i>
                </div>
                <div id="add_promotion_product_video">
                    <i class="fas fa-video"></i>
                </div>
            </div>
            <div class="create-new-promotion-product">
                <p>Enregistrer les modifications</p>
                <button id="add_new_product_promotion">Enregistrer</button>
            </div>
            <form enctype="multipart/form-data">
                <input type="file" id="image_promotion_product" name="images[]" accept="image/*" multiple>
                <input type="button" id="add_promotion_product_image_button">
            </form>
            <form enctype="multipart/form-data">
                <input type="file" id="video_promotion_product" name="video" accept="video/*">
                <input type="button" id="add_promotion_product_video_button">
            </form>
        </div>
        <div id="loader_create_promotion_product_bottom" class="center"></div>
    </div>
    <div class="create-publication-bottom-button">
        <div id="loader_create_publication_bottom_button" class="button-center"></div>
        <button id="final_create_promotion_button">Créer maintenant</button>
    </div>
    <input type="hidden" id="id_promotion_product" value="<?php echo $get_prm_prd_row['id_prd'] ?>">
</div>
<?php
}
else{
    echo 0;
}
?>