<?php
session_start();
include_once './bdd/connexion.php';
$id_btq = htmlspecialchars($_POST['id_btq']);
$btq_inf_query = $conn->prepare("SELECT * FROM boutiques WHERE id_btq = $id_btq");
$btq_inf_query->execute();
$btq_inf_row = $btq_inf_query->fetch(PDO::FETCH_ASSOC);

if (isset($_SESSION['user'])) {
    $id_session = htmlspecialchars($_SESSION['user']);
    $get_session_id_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
    $get_session_id_query->execute();
    $get_session_id_row = $get_session_id_query->fetch(PDO::FETCH_ASSOC);
    $user_session_query = $conn->prepare("SELECT * FROM utilisateurs WHERE id_user = {$get_session_id_row['id_user']}");
    $user_session_query->execute();
    if ($user_session_query->rowCount() > 0) {
        $row = $user_session_query->fetch(PDO::FETCH_ASSOC);
    }
}

$id_prd = htmlspecialchars($_POST['id_prd']);
$get_prd_query = $conn->prepare("SELECT * FROM produit_boutique WHERE id_prd = '$id_prd'");
$get_prd_query->execute();
$get_prd_row = $get_prd_query->fetch(PDO::FETCH_ASSOC);

$get_image1_query = $conn->prepare("SELECT media_url FROM produits_media WHERE id_prd = '$id_prd' LIMIT 1");
$get_image1_query->execute();
$image1 = '';
if ($get_image1_query->rowCount() > 0) {
    $image1 = $get_image1_query->fetch(PDO::FETCH_ASSOC);
}

$get_image_query = $conn->prepare("SELECT media_url FROM produits_media WHERE id_prd = '$id_prd'");
$get_image_query->execute();

$get_modele_query = $conn->prepare("SELECT media_url FROM produits_media WHERE id_prd = '$id_prd'");
$get_modele_query->execute();

$get_apercu_query = $conn->prepare("SELECT media_url FROM produits_media WHERE id_prd = '$id_prd'");
$get_apercu_query->execute();

?>
<div class="cancel-product-details" id="cancel_product_details">
    <i class="fas fa-times"></i>
</div>
<div class="cancel-product-details-resp">
    <div id="cancel_product_details_resp">
        <i class="fas fa-arrow-left"></i>
    </div>
    <h4><?php echo $get_prd_row['nom_prd'] ?></h4>
</div>
<div class="product-details-top">
    <div class="product-details-images">
        <div class="product-details-images-top">
            <img src="<?php echo './'.$image1['media_url'] ?>" alt="">
        </div>
        <div class="product-details-images-bottom">
            <?php
            while ($get_image_row = $get_image_query->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="display-modele">
                <img src="<?php echo $get_image_row['media_url'] ?>" alt="">
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="product-details-informations">
        <div class="product-details-description">
            <p><?php echo $get_prd_row['description_prd'] ?></p>
        </div>
        <div class="product-details-price">
            <h3>Prix : <?php echo $get_prd_row['prix_prd'] ?> DA</h3>
        </div>
        <div class="product-details-modele">
            <p>Modele: <span>modele1</span></p>
            <div class="product-details-modele-image">
                <?php
                while ($get_modele_row = $get_modele_query->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <div class="display-modele">
                    <img src="<?php echo $get_modele_row['media_url'] ?>" alt="">
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="product-details-quatity">
            <h4>Quantite : <span><?php echo $get_prd_row['quantite_prd'] ?> pcs</span></h4>
        </div>
        <div class="product-details-button">
            <button><a href="tel:<?php echo $btq_inf_row['tlph_btq'] ?>">Appeler le <?php echo $btq_inf_row['tlph_btq'] ?></a></button>
            <button>Ajouter au panier</button>
        </div>
    </div>
    <div class="product-details-same">
        <h4>Recommandé pout vous</h4>
        <div>
            <img src="./boutique-logo/logo.png" alt="">
            <p>200 DA</p>
        </div>
        <div>
            <img src="./boutique-logo/logo.png" alt="">
            <p>200 DA</p>
        </div>
        <div>
            <img src="./boutique-logo/logo.png" alt="">
            <p>200 DA</p>
        </div>
    </div>
</div>
<div class="product-details-bottom">
    <div class="product-details-bottom-top">
        <div id="overview_product_button" class="product-details-bottom-top-active">
            <p>Produit aperçu</p>
        </div>
        <div id="informations_product_button">
            <p>Produit détails</p>
        </div>
        <div id="comment_product_button">
            <p>Commentaire</p>
        </div>
    </div>
    <div class="product-details-bottom-bottom">
        <div class="product-details-bottom-bottom-image product-details-bottom-bottom-active" id="overview_product">
        <?php
        while ($get_apercu_row = $get_apercu_query->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <div>
            <img src="<?php echo $get_apercu_row['media_url'] ?>" alt="">
        </div>
        <?php } ?>
        </div>
        <div class="product-details-bottom-bottom-informations" id="informations_product">
            <div class="information-boutique-left">
                <h4>Caractéristiques</h4>
                <p><?php echo $get_prd_row['caracteristique_prd'] ?></p>
                <h4>Catégorie</h4>
                <p><?php echo $get_prd_row['categorie_prd'] ?></p>
            </div>
            <div class="information-boutique-right">
                <h4>Foctionnalités</h4>
                <p><?php echo $get_prd_row['fonctionnalite_prd'] ?></p>
                <h4>Avantages</h4>
                <p><?php echo $get_prd_row['avantage_prd'] ?></p>
            </div>
        </div>
        <div class="product-details-bottom-bottom-comments" id="comments_product">
            <?php if (isset($_SESSION['user'])) { ?>
            <div class="type-product-comment">
                <img src="./<?php echo $row['img_user'] ?>" alt="">
                <input type="text" id="commentaire_prd_text" placeholder = "Tapez une commentaire ...">
                <input type="hidden" id="commentaire_img_user" value="<?php echo $row['img_user'] ?>">
                <input type="hidden" id="commentaire_nom_user" value="<?php echo $row['nom_user'] ?>">
                <input type="hidden" id="id_prd" value="<?php echo $get_prd_row['id_prd'] ?>">
                <input type="hidden" id="id_user_comment" value="<?php echo $row['id_user'] ?>">
            </div>
            <?php } ?>
            <div class="product-comments-preview" id="product_comments_preview"></div>
            <div class="all-product-comments">
                <?php
                $product_comment_query = $conn->prepare("SELECT * FROM commentaires_produits WHERE id_prd = '{$get_prd_row["id_prd"]}' ORDER BY id_c DESC"); 
                $product_comment_query->execute();
                $product_comment_count = $product_comment_query->rowCount();
                while($product_comment_row = $product_comment_query->fetch(PDO::FETCH_ASSOC)){
                $product_comment_user_query = $conn->prepare("SELECT img_user AS img, nom_user AS nom FROM utilisateurs WHERE id_user = '{$product_comment_row["id_user"]}'
                UNION SELECT logo_btq AS img, nom_btq AS nom FROM boutiques WHERE id_btq = '{$product_comment_row["id_user"]}'");
                $product_comment_user_query->execute();
                $product_comment_user_row = $product_comment_user_query->fetch(PDO::FETCH_ASSOC);
                ?>
                <?php if ($product_comment_user_row['img'] != '') { ?>
                    <img src="./<?php echo $product_comment_user_row['img'] ?>" alt="">
                <?php }else if($product_comment_user_row['img'] == ''){ ?>
                    <img src="./boutique-logo/logo.png" alt="">
                <?php } ?>
                <div>
                    <h4><?php echo $product_comment_user_row['nom'] ?></h4>
                    <p><?php echo $product_comment_row['commentaire_text'] ?></p>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<div class="all-same-product">
    <div class="all-same-product-container">
        <div>
            <img src="./boutique-logo/logo.png" alt="">
            <h4>200 DA</h4>
        </div>
        <div>
            <img src="./boutique-logo/logo.png" alt="">
            <h4>200 DA</h4>
        </div>
        <div>
            <img src="./boutique-logo/logo.png" alt="">
            <h4>200 DA</h4>
        </div>
        <div>
            <img src="./boutique-logo/logo.png" alt="">
            <h4>200 DA</h4>
        </div>
        <div>
            <img src="./boutique-logo/logo.png" alt="">
            <h4>200 DA</h4>
        </div>
        <div>
            <img src="./boutique-logo/logo.png" alt="">
            <h4>200 DA</h4>
        </div>
        <div>
            <img src="./boutique-logo/logo.png" alt="">
            <h4>200 DA</h4>
        </div>
        <div>
            <img src="./boutique-logo/logo.png" alt="">
            <h4>200 DA</h4>
        </div>
    </div>
</div>