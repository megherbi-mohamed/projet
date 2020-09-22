<?php
session_start();
include_once './bdd/connexion.php';
$id_btq = htmlspecialchars($_POST['id_btq']);
$btq_inf_query = "SELECT * FROM boutiques WHERE id_btq = $id_btq";
$btq_inf_result = mysqli_query($conn, $btq_inf_query);
$btq_inf_row = mysqli_fetch_assoc($btq_inf_result);

$id_prd = htmlspecialchars($_POST['id_prd']);
$get_prd_query = "SELECT * FROM produit_boutique WHERE id_prd = '$id_prd'";
$get_prd_result = mysqli_query($conn, $get_prd_query);
$get_prd_row = mysqli_fetch_assoc($get_prd_result);

$get_image1_query = "SELECT media_url FROM produits_media WHERE id_prd = '$id_prd' LIMIT 1";
$get_image1_result = mysqli_query($conn, $get_image1_query);
$image1 = '';
if (mysqli_num_rows($get_image1_result) > 0) {
    $image1 = mysqli_fetch_assoc($get_image1_result);
}

$get_image2_query = "SELECT media_url FROM produits_media WHERE id_prd = '$id_prd' LIMIT 1 OFFSET 1";
$get_image2_result = mysqli_query($conn, $get_image2_query);
$image2 = '';
if (mysqli_num_rows($get_image2_result) > 0) {
    $image2 = mysqli_fetch_assoc($get_image2_result);
}

$get_image3_query = "SELECT media_url FROM produits_media WHERE id_prd = '$id_prd' LIMIT 1 OFFSET 2";
$get_image3_result = mysqli_query($conn, $get_image3_query);
$image3 = '';
if (mysqli_num_rows($get_image3_result) > 0) {
    $image3 = mysqli_fetch_assoc($get_image3_result);
}

$get_image4_query = "SELECT media_url FROM produits_media WHERE id_prd = '$id_prd' LIMIT 1 OFFSET 3";
$get_image4_result = mysqli_query($conn, $get_image4_query);
$image4 = '';
if (mysqli_num_rows($get_image4_result) > 0) {
    $image4 = mysqli_fetch_assoc($get_image4_result);
}

?>
<div class="cancel-product-details" id="cancel_product_details">
    <i class="fas fa-times"></i>
</div>
<div class="cancel-product-details-resp" id="cancel_product_details_resp">
    <div>
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
            <?php if ($image1 !== '') { ?>
            <div class="product-details-modele-image-active display-modele">
                <img src="<?php echo './'.$image1['media_url'] ?>" alt="">
            </div>
            <?php } ?>
            <?php if ($image2 !== '') { ?>
            <div class="display-modele">
                <img src="<?php echo './'.$image2['media_url'] ?>" alt="">
            </div>
            <?php } ?>
            <?php if ($image3 !== '') { ?>
            <div class="display-modele">
                <img src="<?php echo './'.$image3['media_url'] ?>" alt="">
            </div>
            <?php } ?>
            <?php if ($image4 !== '') { ?>
            <div class="display-modele">
                <img src="<?php echo './'.$image4['media_url'] ?>" alt="">
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
                <?php if ($image1 !== '') { ?>
                <div class="product-details-modele-image-active display-modele">
                    <img src="<?php echo './'.$image1['media_url'] ?>" alt="">
                </div>
                <?php } ?>
                <?php if ($image2 !== '') { ?>
                <div class="display-modele">
                    <img src="<?php echo './'.$image2['media_url'] ?>" alt="">
                </div>
                <?php } ?>
                <?php if ($image3 !== '') { ?>
                <div class="display-modele">
                    <img src="<?php echo './'.$image3['media_url'] ?>" alt="">
                </div>
                <?php } ?>
                <?php if ($image4 !== '') { ?>
                <div class="display-modele">
                    <img src="<?php echo './'.$image4['media_url'] ?>" alt="">
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
            <?php if ($image1 !== '') { ?>
            <div>
                <img src="<?php echo './'.$image1['media_url'] ?>" alt="">
            </div>
            <?php } ?>    
            <?php if ($image2 !== '') { ?>
            <div>
                <img src="<?php echo './'.$image2['media_url'] ?>" alt="">
            </div>
            <?php } ?>
            <?php if ($image3 !== '') { ?>
            <div>
                <img src="<?php echo './'.$image3['media_url'] ?>" alt="">
            </div>
            <?php } ?> 
            <?php if ($image4 !== '') { ?>
            <div>
                <img src="<?php echo './'.$image4['media_url'] ?>" alt="">
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
            med
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