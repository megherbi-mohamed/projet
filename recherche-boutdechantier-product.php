<?php 
session_start();
include_once './bdd/connexion.php';
$text = htmlspecialchars($_POST['text']);
?>
<div class="boutdechantier-right-bottom">
<?php 
$get_product_query = "SELECT * FROM produit_boutdechantier WHERE lieu_prd LIKE '%$text%' OR nom_prd LIKE '%$text%' OR description_prd LIKE '%$text%' OR categorie_prd LIKE '%$text%' OR type_prd LIKE '%$text%' ORDER BY id_prd DESC";
$get_product_result = mysqli_query($conn,$get_product_query);
if (mysqli_num_rows($get_product_result) > 0) {
while ($get_product_row = mysqli_fetch_assoc($get_product_result)){
    $get_product_media_query = "SELECT * FROM bt_produits_media WHERE id_prd = '{$get_product_row['id_prd']}' LIMIT 1";
    $get_product_media_result = mysqli_query($conn,$get_product_media_query);
    $get_product_media_row = mysqli_fetch_assoc($get_product_media_result);
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
<?php }else{ ?>
<div class="empty-msg-ntf">
    <p>Auccun produit pour (<?php echo $text ?>)</p>
</div>
<?php } ?>