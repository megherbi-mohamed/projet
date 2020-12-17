<?php
include_once './bdd/connexion.php';
$tail_prm = htmlspecialchars($_POST['tail_prm']);
$id_prm = htmlspecialchars($_POST['id_prm']);
$get_promotion_query = $conn->prepare("SELECT * FROM promotions WHERE id_prm = $id_prm");
if($get_promotion_query->execute()){
    $get_promotion_row = $get_promotion_query->fetch(PDO::FETCH_ASSOC);
    $get_promotion_media_query = $conn->prepare("SELECT media_url,media_type FROM promotions_media WHERE id_prm = $id_prm");
    if($get_promotion_media_query->execute()){
        $get_promotion_media_row = $get_promotion_media_query->fetch(PDO::FETCH_ASSOC);
        $id_prd = htmlspecialchars($_POST['id_prd']);
        $get_promotion_product_query = $conn->prepare("SELECT * FROM produit_promotion WHERE id_prm = $id_prm");
        if($get_promotion_product_query->execute()){
            $get_promotion_product_row = $get_promotion_product_query->fetch(PDO::FETCH_ASSOC);
            $etat = 1;
            $create_prm_prd_query = $conn->prepare("INSERT INTO produit_promotion (id_prm,etat) VALUES (:id_prm,:etat)");
            $create_prm_prd_query->bindParam(':id_prm',$id_prm);
            $create_prm_prd_query->bindParam(':etat',$etat);
            if ($create_prm_prd_query->execute()) {
                $get_prm_prd_query = $conn->prepare("SELECT id_prd FROM produit_promotion WHERE id_prd IN (SELECT MAX(id_prd) FROM produit_promotion WHERE id_prm = $id_prm AND etat = 1)");
                if ($get_prm_prd_query->execute()) {
                    $get_prm_prd_row = $get_prm_prd_query->fetch(PDO::FETCH_ASSOC);
?>
<div class="create-publication-top">
    <div class="cancel-create-publication-responsive" id="cancel_update_promotion">
        <i class="fas fa-arrow-left"></i>
    </div>
    <h4>Modifier une promotion!</h4>
    <div class="cancel-create-publication" id="cancel_update_promotion">
        <i class="fas fa-times"></i>
    </div>
    <div class="create-publication-top-button">
        <div id="loader_create_publication_top_button" class="button-center"></div>
        <button id="final_update_promotion_button">Enregistrer</button>
    </div>
</div>
<div class="create-publication-bottom">
    <div class="create-promotion-options" style="display:none">
        <div class="create-promotion-option" id="add_promotion_image">
            <div>
                <P>Ajouter une photo de cette promotion</P>
                <i class="far fa-images"></i>
            </div>
        </div>
        <div class="create-promotion-option" id="add_promotion_video">
            <div>
                <P>Ajouter une vidéo de cette promotion</P>
                <i class="fas fa-video"></i>
            </div>
        </div>
    </div>
    <div class="promotion-images-preview" style="display:block">
        <?php if($get_promotion_media_row['media_type'] == 'i') { ?>
        <div class="promotion-image-preview" id="promotion_image_preview">
            <div id="promotion_delete_image_preview">
                <i class="fas fa-times"></i>
            </div>
            <img src="<?php echo $get_promotion_media_row['media_url'] ?>">
        </div>
        <?php } else { ?>
        <div class="promotion-video-preview" id="promotion_video_preview">
            <div id="promotion_delete_video_preview">
                <i class="fas fa-times"></i>
            </div>
            <video controls><source src="<?php echo $get_promotion_media_row['media_url'] ?>"></video>
        </div>
        <?php } ?>
    </div>
    <form enctype="multipart/form-data">
        <input type="file" id="image_promotion" name="image" accept="image/*">
        <input type="button" id="add_promotion_image_button">
    </form>
    <form enctype="multipart/form-data">
        <input type="file" id="video_promotion" name="video" accept="video/*">
        <input type="button" id="add_promotion_video_button">
    </form>
    <div class="promotion-input">
        <input type="text" id="updt_titre_prm" value="<?php echo $get_promotion_row['titre_prm'] ?>" autocomplete="off">
        <span class="titre-prm active-promotion-span">Titre *</span>
    </div>
    <div class="promotion-input" id="promotion_categorie_select">
        <span class="categorie-prm">Categorie *</span>
        <select id="categorie_prm">
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
    <div class="promotion-input updt-sous-categorie-promotion" id="promotion_profession_select">
        <span class="sous-categorie-prm">Sous categorie *</span>
        <select id="sous_categorie_prm">
            <option value="">Sous categories</option>
        </select>
    </div>
    <div class="promotion-input updt-sous-categorie-autre">
        <span class="sous-categorie-prm">Sous categorie *</span>
        <input type="text" id="sous_categorie_prm">
    </div>
    <div class="promotion-input" id="promotion_ville_select">
        <select id="ville_promotion">
            <option value="">Ville</option>
            <?php 
            $ville_query = $conn->prepare("SELECT * FROM villes");
            $ville_query->execute(); 
            while ($ville_row = $ville_query->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <option value="<?php echo $ville_row['ville'] ?>"><?php echo $ville_row['ville'] ?></option>
            <?php } ?>
        </select>
        <span class="lieu-prm active-promotion-span">Ville *</span>
    </div>
    <div class="promotion-input commune-promotion" id="promotion_commune_select">
        <select id="commune_promotion">
            <option value="">Commune</option>
        </select>
        <span class="lieu-prm active-promotion-span">Commune *</span>
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
            $get_crtd_btq_prd_query = $conn->prepare("SELECT id_prd_prm,id_btq,id_btq_prd,media_url FROM produit_boutique_promotion WHERE id_prm = $id_prm");
            $get_crtd_btq_prd_query->execute();
            if ($get_crtd_prd_query->rowCount()+$get_crtd_btq_prd_query->rowCount() > 0) {
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
            <div class="promotion-product-images-preview-container">
                <div class="promotion-product-images-preview"></div>
            </div>
            <div class="promotion-product-video-preview-container">
                <div class="promotion-product-video-preview"></div>
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
                <p>Ajouter un nouveau produit</p>
                <button id="add_new_product_promotion">Ajouter</button>
            </div>
            <form enctype="multipart/form-data">
                <input type="file" id="image_promotion_product" name="images[]" accept="image/*" multiple>
                <input type="button" id="add_promotion_product_image_button">
            </form>
            <form enctype="multipart/form-data">
                <input type="file" id="video_promotion_product" name="video" accept="video/*">
                <input type="button" id="add_promotion_product_video_button">
            </form>
            <input type="hidden" id="id_promotion_product" value="<?php echo $get_prm_prd_row['id_prd'] ?>">
        </div>
        <div id="loader_create_promotion_product_bottom" class="center"></div>
    </div>
    <input type="hidden" id="tail_updt_promotion" value="<?php echo $tail_prm ?>">
    <input type="hidden" id="id_updt_promotion" value="<?php echo $id_prm ?>">
    <div class="create-publication-bottom-button">
        <div id="loader_create_publication_bottom_button" class="button-center"></div>
        <button id="final_update_promotion_button">Enregistrer les modification</button>
    </div>
</div>
<script>
$('#promotion_categorie_select option[value="<?php echo $get_promotion_row['categorie_prm'] ?>"]').prop('selected',true);
$('.updt-sous-categorie-promotion').load('categorie-promotion.php?c=<?php echo $get_promotion_row['categorie_prm'] ?>');
setTimeout(() => {
    $('#promotion_profession_select option[value="<?php echo $get_promotion_row['sous_categorie_prm'] ?>"]').prop('selected',true);
}, 500);

$('#promotion_ville_select option[value="<?php echo $get_promotion_row['ville_prm'] ?>"]').prop('selected',true);
$('.commune-promotion').load('commune-promotion.php?v=<?php echo $get_promotion_row['ville_prm'] ?>');
setTimeout(() => {
    $('#promotion_commune_select option[value="<?php echo $get_promotion_row['commune_prm'] ?>"]').prop('selected',true);
}, 500);
</script>
<?php
                }
                else{
                    echo 0;
                }
            }
            else{
                echo 0;
            }
        }
        else{
            echo 0;
        }
    }
    else{
        echo 0;
    }
}
else{
    echo 0;
}
?>