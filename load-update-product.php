<?php
session_start();
include_once './bdd/connexion.php';
$id_session_btq = htmlspecialchars($_POST['id_btq']);
$get_session_btq_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session_btq' OR id_user_1 = '$id_session_btq' OR id_user_2 = '$id_session_btq' 
OR id_user_3 = '$id_session_btq' OR id_user_4 = '$id_session_btq' OR id_user_5 = '$id_session_btq'");
if ($get_session_btq_query->execute()) {
    $get_session_btq_row = $get_session_btq_query->fetch(PDO::FETCH_ASSOC);
    $id_btq = $get_session_btq_row['id_user'];
    if (isset($_SESSION['user'])) {
        $id_session = htmlspecialchars($_SESSION['user']);
        $get_session_user_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
        OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
    }
    else if (isset($_SESSION['btq'])) {
        $get_session_user_query = $conn->prepare("SELECT id_createur AS id_user FROM boutiques WHERE id_btq = $id_btq");
    }
    if ($get_session_user_query->execute()) {
        $get_session_user_row = $get_session_user_query->fetch(PDO::FETCH_ASSOC);
        $id_user = $get_session_user_row['id_user'];
        $id_prd = htmlspecialchars($_POST['id_prd']);
        $tail_prd = htmlspecialchars($_POST['tail_prd']);
        $get_product_query = $conn->prepare("SELECT * FROM produit_boutique WHERE id_user = $id_user AND id_prd = $id_prd");
        if ($get_product_query->execute()) {
            $get_product_row = $get_product_query->fetch(PDO::FETCH_ASSOC);
            $get_product_image_query = $conn->prepare("SELECT media_url FROM produits_media WHERE id_prd = $id_prd AND media_type = 'i'");
            $get_product_video_query = $conn->prepare("SELECT media_url FROM produits_media WHERE id_prd = $id_prd AND media_type = 'v'");
            if ($get_product_image_query->execute() && $get_product_video_query->execute()) {
?>
<div class="create-publication-top">
    <div class="cancel-create-publication-responsive" id="cancel_update_product">
        <i class="fas fa-arrow-left"></i>
    </div>
    <h4>Créer un produit sur la boutique</h4>
    <div class="cancel-create-publication" id="cancel_update_product">
        <i class="fas fa-times"></i>
    </div>
    <div class="create-publication-top-button">
        <div id="loader_create_publication_top_button" class="button-center"></div>
        <button id="update_product_button">Enregistrer</button>
    </div>
</div>
<input type="hidden" id="id_product" value="<?php echo $id_prd ?>">
<input type="hidden" id="tail_product" value="<?php echo $tail_prd ?>">
<div class="create-publication-bottom">
    <div class="product-input">
        <input type="text" id="name_prd" value="<?php echo $get_product_row['nom_prd'] ?>" autocomplete = "off">
        <span class="name-prd active-product-span">Nom *</span>
    </div>
    <div class="product-input">
        <input type="text" id="categorie_prd" value="<?php echo $get_product_row['categorie_prd'] ?>" autocomplete = "off">
        <span class="categorie-prd active-product-span">Categorie *</span>
    </div>
    <div class="product-input">
        <input type="text" id="reference_prd" value="<?php echo $get_product_row['reference_prd'] ?>" autocomplete = "off">
        <span class="reference-prd active-product-span">Reference *</span>
    </div>
    <div class="product-input">
        <input type="number" id="quantity_prd" value="<?php echo $get_product_row['quantite_prd'] ?>" placeholder="0" autocomplete = "off">
        <span class="quantity-prd active-product-span">Quantite *</span>
    </div>
    <div class="product-input">
        <input type="text" id="price_prd" value="<?php echo $get_product_row['prix_prd'] ?>" autocomplete = "off">
        <span class="price-prd active-product-span">Prix *</span>
    </div>
    <div class="product-input">
        <input type="text" id="caracteristique_prd" value="<?php echo $get_product_row['caracteristique_prd'] ?>" autocomplete = "off">
        <?php if ($get_product_row['caracteristique_prd'] == '') { ?>
        <span class="caracteristique-prd">Caractéristiques</span>
        <?php } else { ?>
        <span class="caracteristique-prd active-product-span">Caractéristiques</span>
        <?php } ?>
    </div>
    <div class="product-input">
        <input type="text" id="fonctionnalite_prd" value="<?php echo $get_product_row['fonctionnalite_prd'] ?>" autocomplete = "off">
        <?php if ($get_product_row['fonctionnalite_prd'] == '') { ?>
        <span class="fonctionnalite-prd">Fonctionnalités</span>
        <?php } else { ?>
        <span class="fonctionnalite-prd active-product-span">Fonctionnalités</span>
        <?php } ?>
    </div>
    <div class="product-input">
        <input type="text" id="avantage_prd" value="<?php echo $get_product_row['avantage_prd'] ?>" autocomplete = "off">
        <?php if ($get_product_row['avantage_prd'] == '') { ?>
        <span class="avantage-prd">Avantages</span>
        <?php } else { ?>
        <span class="avantage-prd active-product-span">Avantages</span>
        <?php } ?>
    </div>
    <div class="product-input">
        <textarea id="description_prd"><?php echo $get_product_row['description_prd'] ?></textarea>
        <span class="description-prd active-product-span">Description *</span>
    </div>
    <div class="product-images-preview-container">
        <div class="product-images-preview">
        <?php
        if ($get_product_image_query->rowCount() > 0) {
            $i = 0;
            while ($get_product_image_row = $get_product_image_query->fetch(PDO::FETCH_ASSOC)) {
            $i++;
        ?>
        <div class="product-image-preview" id="product_image_preview_<?php echo $i ?>">
            <div class="delete-preview" id="product_delete_preview_<?php echo $i ?>">
                <i class="fas fa-times"></i>
            </div>
            <img src="<?php echo $get_product_image_row['media_url'] ?>">
        </div>
        <?php }} ?>  
        </div>
    </div>
    <div class="product-video-preview-container">
        <div class="product-video-preview">
        <?php 
        if ($get_product_video_query->rowCount() > 0) {
            $get_product_video_row = $get_product_video_query->fetch(PDO::FETCH_ASSOC);
        ?>
        <div class="prd-video-preview" id="product_video_preview">
            <div class="delete-preview" id="product_delete_video">
                <i class="fas fa-times"></i>
            </div>
            <video controls><source src="<?php echo $get_product_video_row['media_url'] ?>"></video>
        </div>
        <?php } ?>
        </div>
    </div>
    <?php 
    $display = 'style="display:none"';
    if ($get_product_image_query->rowCount()+$get_product_video_query->rowCount() < 4) {
        $display = 'style="display:"';
    }
    ?>
    <div class="create-product-options" <?php echo $display ?>>
        <P>Ajouter des photos ou vidéo</P>
        <div id="add_product_image">
            <i class="far fa-images"></i>
        </div>
        <div id="add_product_video">
            <i class="fas fa-video"></i>
        </div>
    </div>
    <form enctype="multipart/form-data">
        <input type="file" id="image_product" name="images[]" accept="image/*" multiple>
        <input type="button" id="add_product_image_button">
    </form>
    <form enctype="multipart/form-data">
        <input type="file" id="video_product" name="video" accept="video/*">
        <input type="button" id="add_product_video_button">
    </form>
    <div class="create-publication-bottom-button">
        <div id="loader_create_publication_bottom_button" class="button-center"></div>
        <button id="update_product_button">Enregistrer les modification</button>
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
    }
    else{
        echo 0;
    }
}
else{
    echo 0;
}
?>