<?php 
session_start();
include_once './bdd/connexion.php';
$id_btq = htmlspecialchars($_POST['id_btq']);
$text = htmlspecialchars($_POST['text']);
?>
<?php 
$get_product_query = "SELECT * FROM produit_boutique WHERE id_btq = $id_btq AND (nom_prd LIKE '%$text%' OR description_prd 
OR reference_prd LIKE '%$text%' OR categorie_prd LIKE '%$text%' OR caracteristique_prd LIKE '%$text%' OR fonctionnalite_prd 
LIKE '%$text%') ORDER BY id_prd DESC";
$get_product_result = mysqli_query($conn,$get_product_query);
if (mysqli_num_rows($get_product_result) > 0) {
$i = 0;
while ($get_product_row = mysqli_fetch_assoc($get_product_result)){
$i++;
$get_product_media_query = "SELECT * FROM produits_media WHERE id_prd = '{$get_product_row['id_prd']}' LIMIT 1";
$get_product_media_result = mysqli_query($conn,$get_product_media_query);
$get_product_media_row = mysqli_fetch_assoc($get_product_media_result);
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