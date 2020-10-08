<?php 
session_start();
include_once './bdd/connexion.php';
$text = htmlspecialchars($_POST['text']);
?>
<div class="boutdechantier-right-bottom">
<?php 
$get_product_query = $conn->prepare("SELECT * FROM produit_boutdechantier WHERE lieu_prd LIKE '%$text%' OR nom_prd LIKE '%$text%' OR description_prd LIKE '%$text%' OR categorie_prd LIKE '%$text%' OR type_prd LIKE '%$text%' ORDER BY id_prd DESC");
$get_product_query->execute();
if ($get_product_query->rowCount() > 0) {
while ($get_product_row = $get_product_query->fetch(PDO::FETCH_ASSOC)){
    $get_product_media_query = $conn->prepare("SELECT * FROM bt_produits_media WHERE id_prd = '{$get_product_row['id_prd']}' LIMIT 1");
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
<?php }else{ ?>
<div class="empty-msg-ntf">
    <p>Auccun produit pour (<?php echo $text ?>)</p>
</div>
<?php } ?>