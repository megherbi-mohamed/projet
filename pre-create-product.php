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
        $etat = 1;
        $create_prd_query = $conn->prepare("INSERT INTO produit_boutique (id_btq,id_user,etat) VALUES (:id_btq,:id_user,:etat)");
        $create_prd_query->bindParam(':id_btq',$id_btq);
        $create_prd_query->bindParam(':id_user',$id_user);
        $create_prd_query->bindParam(':etat',$etat);
        if ($create_prd_query->execute()) {
            $get_prd_query = $conn->prepare("SELECT id_prd FROM produit_boutique WHERE id_btq = $id_btq AND id_user = $id_user AND etat = 1");
            if ($get_prd_query->execute()) {
                $get_prd_row = $get_prd_query->fetch(PDO::FETCH_ASSOC);
?>
<div class="create-publication-top">
    <div class="cancel-create-publication-responsive" id="cancel_create_product">
        <i class="fas fa-arrow-left"></i>
    </div>
    <h4>Créer un produit sur la boutique</h4>
    <div class="cancel-create-publication" id="cancel_create_product">
        <i class="fas fa-times"></i>
    </div>
    <div class="create-publication-top-button">
        <div id="loader_create_publication_top_button" class="button-center"></div>
        <button id="create_product_button">Créer</button>
    </div>
</div>
<input type="hidden" id="id_product" value="<?php echo $get_prd_row['id_prd'] ?>">
<div class="create-publication-bottom">
    <div class="product-input">
        <input type="text" id="name_prd" autocomplete = "off">
        <span class="name-prd">Nom *</span>
    </div>
    <div class="product-input">
        <input type="text" id="categorie_prd" autocomplete = "off">
        <span class="categorie-prd">Categorie *</span>
    </div>
    <div class="product-input">
        <input type="text" id="reference_prd" autocomplete = "off">
        <span class="reference-prd">Reference *</span>
    </div>
    <div class="product-input">
        <input type="number" id="quantity_prd" placeholder="0" autocomplete = "off">
        <span class="quantity-prd active-product-span">Quantite *</span>
    </div>
    <div class="product-input">
        <input type="text" id="price_prd" autocomplete = "off">
        <span class="price-prd">Prix *</span>
    </div>
    <div class="product-input">
        <input type="text" id="caracteristique_prd" autocomplete = "off">
        <span class="caracteristique-prd">Caractéristiques</span>
    </div>
    <div class="product-input">
        <input type="text" id="fonctionnalite_prd" autocomplete = "off">
        <span class="fonctionnalite-prd">Fonctionnalités</span>
    </div>
    <div class="product-input">
        <input type="text" id="avantage_prd" autocomplete = "off">
        <span class="avantage-prd">Avantages</span>
    </div>
    <div class="product-input">
        <textarea id="description_prd"></textarea>
        <span class="description-prd">Description *</span>
    </div>
    <div class="product-images-preview-container">
        <div class="product-images-preview"></div>
    </div>
    <div class="product-video-preview-container">
        <div class="product-video-preview"></div>
    </div>
    <div class="create-product-options">
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
        <button id="create_product_button">Créer maintenant</button>
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