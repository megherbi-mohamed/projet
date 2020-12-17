<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_user_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
if ($get_session_user_query->execute()) {
    $get_session_user_row = $get_session_user_query->fetch(PDO::FETCH_ASSOC);
    $id_user = $get_session_user_row['id_user'];
    $id_prd = htmlspecialchars($_POST['id_prd']);
    $tail_prd = htmlspecialchars($_POST['tail_prd']);
    $get_bt_product_query = $conn->prepare("SELECT * FROM produit_boutdechantier WHERE id_user = $id_user AND id_prd = $id_prd");
    if ($get_bt_product_query->execute()) {
        $get_bt_product_row = $get_bt_product_query->fetch(PDO::FETCH_ASSOC);
        $get_bt_product_image_query = $conn->prepare("SELECT media_url FROM bt_produits_media WHERE id_prd = $id_prd AND media_type = 'i'");
        $get_bt_product_video_query = $conn->prepare("SELECT media_url FROM bt_produits_media WHERE id_prd = $id_prd AND media_type = 'v'");
        if ($get_bt_product_image_query->execute() && $get_bt_product_video_query->execute()) {
?>
<div class="create-publication-top">
    <div class="cancel-create-publication-responsive" id="cancel_update_bt_product">
        <i class="fas fa-arrow-left"></i>
    </div>
    <h4>Créer un produit sur boutdechantier</h4>
    <div class="cancel-create-publication" id="cancel_update_bt_product">
        <i class="fas fa-times"></i>
    </div>
    <div class="create-publication-top-button">
        <div id="loader_create_publication_top_button" class="button-center"></div>
        <button id="update_bt_product_button">Entregistrer</button>
    </div>
</div>
<input type="hidden" id="id_bt_product" value="<?php echo $id_prd ?>">
<input type="hidden" id="tail_product" value="<?php echo $tail_prd ?>">
<div class="create-publication-bottom">
    <div class="bt-product-input">
        <input type="text" id="name_bt_prd" value="<?php echo $get_bt_product_row['nom_prd'] ?>">
        <span class="name-bt-prd active-bt-product-span">Nom *</span>
    </div>
    <div class="bt-product-input" id="bt_product_categorie_select">
        <select id="categorie_bt_product">
            <option value="">Categorie</option>
            <option value="Outillages">Outillages</option>
            <option value="Quincalleries">Quincalleries</option>
            <option value="Matériel et équipement">Matériel et équipement</option>
            <option value="Peinture et vernis">Peinture et vernis</option>
            <option value="Revetement mural">Revetement mural</option>
            <option value="Eléctricité">Eléctricité</option>
            <option value="Menuiserie et bois">Menuiserie et bois</option>
            <option value="Portes et fenetres">Portes et fenetres</option>
            <option value="Cloison et séparation">Cloison et séparation</option>
            <option value="Isolation">Isolation</option>
            <option value="Revetements sol">Revetements sol</option>
            <option value="Matériaux et gros oeuvre">Matériaux et gros oeuvre</option>
            <option value="Plombrie">Plombrie</option>
        </select>
        <span class="categorie-bt-prd active-bt-product-span">Categorie *</span>
    </div>
    <div class="bt-product-input">
        <textarea id="description_bt_prd"><?php echo $get_bt_product_row['description_prd'] ?></textarea>
        <span class="description-bt-prd active-bt-product-span">Description</span>
    </div>
    <div class="bt-product-input">
        <input type="number" id="quantity_bt_prd" placeholder="0" value="<?php echo $get_bt_product_row['quantite_prd'] ?>">
        <span class="quanntite-bt-prd active-bt-product-span">Quantite</span>
    </div>
    <div class="bt-product-input" id="bt_product_type_select">
        <select id="type_bt_prd">
            <option value="payant">Payant</option>
            <option value="gratuit">Gratuit</option>
        </select>
        <span class="type-bt-prd active-bt-product-span">Type *</span>
    </div>
    <?php 
    $display = 'style="display:none"';
    if ($get_bt_product_row['type_prd'] == 'payant') {
        $display = 'style="display:"';
    }
    ?>
    <div class="bt-product-input bt-product-price" <?php echo $display ?>>
        <input type="text" step="000000.00" id="price_bt_prd" placeholder="0" value="<?php echo $get_bt_product_row['prix_prd'] ?>">
        <span class="price-bt-prd active-bt-product-span">Prix *</span>
    </div>
    <div class="bt-product-input" id="bt_product_ville_select">
        <select id="ville_bt_product">
            <option value="">Ville</option>
            <?php 
            $ville_query = $conn->prepare("SELECT * FROM villes");
            $ville_query->execute(); 
            while ($ville_row = $ville_query->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <option value="<?php echo $ville_row['ville'] ?>"><?php echo $ville_row['ville'] ?></option>
            <?php } ?>
        </select>
        <span class="ville-bt-prd active-bt-product-span">Ville *</span>    
    </div>
    <div class="bt-product-input commune-bt-product" id="bt_product_commune_select"> 
        <select id="commune_bt_product">
            <option value="">Commune</option>
        </select>
        <span class="commun-bt-prd active-bt-product-span">Commune *</span>
    </div>
    <div class="bt-product-images-preview-container">
        <div class="bt-product-images-preview">
        <?php
        if ($get_bt_product_image_query->rowCount() > 0) {
            $i = 0;
            while ($get_bt_product_image_row = $get_bt_product_image_query->fetch(PDO::FETCH_ASSOC)) {
            $i++;
        ?>
        <div class="bt-product-image-preview" id="bt_product_image_preview_<?php echo $i ?>">
            <div class="delete-preview" id="bt_product_delete_preview_<?php echo $i ?>">
                <i class="fas fa-times"></i>
            </div>
            <img src="<?php echo $get_bt_product_image_row['media_url'] ?>">
        </div>
        <?php }} ?>
        </div>
    </div>
    <div class="bt-product-video-preview-container">
        <div class="bt-product-video-preview">
        <?php 
        if ($get_bt_product_video_query->rowCount() > 0) {
            $get_bt_product_video_row = $get_bt_product_video_query->fetch(PDO::FETCH_ASSOC);
        ?>
        <div class="bt-prd-video-preview" id="bt_product_video_preview">
            <div class="delete-preview" id="bt_product_delete_video">
                <i class="fas fa-times"></i>
            </div>
            <video controls><source src="<?php echo $get_bt_product_video_row['media_url'] ?>"></video>
        </div>
        <?php } ?>
        </div>
    </div>
    <?php 
    $display = 'style="display:none"';
    if ($get_bt_product_image_query->rowCount()+$get_bt_product_video_query->rowCount() < 4) {
        $display = 'style="display:"';
    }
    ?>
    <div class="create-bt-product-options" <?php echo $display ?>>
        <P>Ajouter des photos ou vidéo</P>
        <div id="add_bt_product_image">
            <i class="far fa-images"></i>
        </div>
        <div id="add_bt_product_video">
            <i class="fas fa-video"></i>
        </div>
    </div>
    <form enctype="multipart/form-data">
        <input type="file" id="image_bt_product" name="images[]" accept="image/*" multiple>
        <input type="button" id="add_bt_product_image_button">
    </form>
    <form enctype="multipart/form-data">
        <input type="file" id="video_bt_product" name="video" accept="video/*">
        <input type="button" id="add_bt_product_video_button">
    </form>
    <div class="create-publication-bottom-button">
        <div id="loader_create_publication_bottom_button" class="button-center"></div>
        <button id="update_bt_product_button">Enregistrer les modification</button>
    </div>
</div>
<script>
$('#bt_product_categorie_select option[value="<?php echo $get_bt_product_row['categorie_prd'] ?>"]').prop('selected',true);
$('#bt_product_type_select option[value="<?php echo $get_bt_product_row['type_prd'] ?>"]').prop('selected',true);
$('#bt_product_ville_select option[value="<?php echo $get_bt_product_row['ville_prd'] ?>"]').prop('selected',true);
$('.commune-bt-product').load('commune-bt-product.php?v=<?php echo $get_bt_product_row['ville_prd'] ?>');
setTimeout(() => {
    $('#bt_product_commune_select option[value="<?php echo $get_bt_product_row['commune_prd'] ?>"]').prop('selected',true);
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
?>