<?php 
include_once './bdd/connexion.php';
?>
<div class="boutdechantier-right-top">
    <div class="boutdechantier-right-pub"></div>
    <div class="boutdechantier-right-slider">
        <div class="boutdechantier-right-slider-img">
            <img class="current-slide" src="./boutique-logo/logo.png" alt="">
            <img src="./boutique-logo/logo2.jpg" alt="">
            <img src="./boutique-logo/logo3.jpg" alt="">
        </div>
        <div id="prev_slide">
            <i class="fas fa-chevron-left"></i>
        </div>
        <div id="next_slide">
            <i class="fas fa-chevron-right"></i>
        </div>
    </div>
    <div class="boutdechantier-right-pub"></div>
</div>
<div class="boutdechantier-right-middle"></div>
<div class="boutdechantier-right-bottom">
<?php 
$get_product_query = $conn->prepare("SELECT * FROM produit_boutdechantier ORDER BY date DESC");
$get_product_query->execute();
$i = 0;
while ($get_product_row = $get_product_query->fetch(PDO::FETCH_ASSOC)){
$i++;
$get_product_media_query = $conn->prepare("SELECT * FROM bt_produits_media WHERE id_prd = '{$get_product_row["id_prd"]}' LIMIT 1");
$get_product_media_query->execute();
$get_product_media_row = $get_product_media_query->fetch(PDO::FETCH_ASSOC);
?>
    <div class="bt-product">
        <div class="bt-product-img">
            <img src="<?php echo $get_product_media_row['media_url'] ?>" alt="">
        </div>
        <div class="bt-product-description">
            <p><?php echo $get_product_row['lieu_prd'] ?></p>
            <h4><?Php echo $get_product_row['prix_prd'].' DA' ?></h4>
        </div>
    </div>
<?php } ?>
</div>