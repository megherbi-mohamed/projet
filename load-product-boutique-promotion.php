<?php
include_once './bdd/connexion.php';
$id_btq = htmlspecialchars($_POST['id_btq']);
?>
<div class="back-to-boutique-user-promotion">
    <button id="back_to_boutique_user_promotion"><i class="fas fa-arrow-left"></i>Boutiques</button>
    <p>Retour vers les boutiques</p>
</div>
<div class="all-products-boutique-promotion">
<?php
$get_product_query = $conn->prepare("SELECT id_prd,prix_prd FROM produit_boutique WHERE id_btq = $id_btq ORDER BY id_prd DESC");
if($get_product_query->execute()){
$i = 0;
while ($get_product_row = $get_product_query->fetch(PDO::FETCH_ASSOC)) {
$i++;
$id_prd = $get_product_row['id_prd'];
$prix_prd = $get_product_row['prix_prd'];
$get_product_media_query = $conn->prepare("SELECT media_url FROM produits_media WHERE id_prd = $id_prd LIMIT 1");
$get_product_media_query->execute();
$get_product_media_row = $get_product_media_query->fetch(PDO::FETCH_ASSOC);
$img_prd = $get_product_media_row['media_url'];

$get_product_promotion_query = $conn->prepare("SELECT id_prd_prm FROM produit_boutique_promotion WHERE id_btq_prd = $id_prd AND id_btq = $id_btq");
$get_product_promotion_query->execute();
if ($get_product_promotion_query->rowCount() > 0) {
?>
<div class="product-boutique-promotion">
<button id="delete_product_boutique_promotion_<?php echo $i ?>">Annuler</button>
<?php } else { ?>
<div class="product-boutique-promotion">
<?php } ?>
    <input type="hidden" id="id_btq_prm" value="<?php echo $id_btq ?>">    
    <input type="hidden" id="id_prd_prm_<?php echo $i ?>" value="<?php echo $id_prd ?>">    
    <div id="product_boutique_promotion_<?php echo $i ?>">
        <img src="<?php echo $img_prd ?>" alt="">
    </div>
    <p>Prix : <?php echo $prix_prd ?></p>
</div>
<?php }} else { 
echo 0;
}?>
</div>
