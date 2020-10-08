<?php 
session_start();
include_once './bdd/connexion.php';
$id_btq = htmlspecialchars($_POST['id_btq']);
$text = htmlspecialchars($_POST['text']);
?>
<?php 
$get_product_query = $conn->prepare("SELECT * FROM produit_boutique WHERE id_btq = $id_btq AND (nom_prd LIKE '%$text%' OR description_prd 
OR reference_prd LIKE '%$text%' OR categorie_prd LIKE '%$text%' OR caracteristique_prd LIKE '%$text%' OR fonctionnalite_prd 
LIKE '%$text%') ORDER BY id_prd DESC");
$get_product_query->execute();
if ($get_product_query->rowCount() > 0) {
$i = 0;
while ($get_product_row = $get_product_query->fetch(PDO::FETCH_ASSOC)){
$i++;
$get_product_media_query = $conn->prepare("SELECT * FROM produits_media WHERE id_prd = '{$get_product_row['id_prd']}' LIMIT 1");
$get_product_media_query->execute();
$get_product_media_row = $get_product_media_query->fetch(PDO::FETCH_ASSOC);
?>
<input type="hidden" id="id_prd_<?php echo $i ?>" value="<?php echo $get_product_row['id_prd'] ?>">
<div class="boutique-product" id="boutique_product_<?php echo $i ?>">
    <div class="boutique-product-img">
        <img src="<?php echo $get_product_media_row['media_url'] ?>" alt="">
    </div>
    <div class="product-description">
        <div class="product-description-top">
            <p><?php echo $get_product_row['description_prd'] ?></p>
        </div>
        <div class="product-description-bottom">
            <h4><?Php echo $get_product_row['prix_prd'].' DA' ?></h4>
        </div>
    </div>
</div>
<?php } ?>
<?php }else{ ?>
<div class="empty-msg-ntf">
    <p>Auccun produit</p>
</div>
<?php } ?>