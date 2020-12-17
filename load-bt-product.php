<?php
include_once './bdd/connexion.php';
$id_prd = htmlspecialchars($_POST['id_prd']);
$id = htmlspecialchars($_POST['tail_prd']);
$get_product_query = $conn->prepare("SELECT * FROM produit_boutdechantier WHERE id_prd = $id_prd");
if ($get_product_query->execute()) {
    $get_product_row = $get_product_query->fetch(PDO::FETCH_ASSOC); 
    $get_product_media_query = $conn->prepare("SELECT * FROM bt_produits_media WHERE id_prd = $id_prd");
    if($get_product_media_query->execute()){
?>
<input type="hidden" id="tail_prd_<?php echo $id ?>" value="<?php echo $id ?>">
<input type="hidden" id="id_prd_<?php echo $id ?>" value="<?php echo $id ?>">
<div class="user-bt-annonce" id="user_bt_annonce_<?php echo $id ?>">
    <div class="user-bt-annonce-top">
        <h4><?php echo $get_product_row['nom_prd'] ?></h4>
        <p>Ajouté le <?php echo $get_product_row['date'] ?></p>
        <div>
            <i class="fas fa-eye"></i>
            <span><?php echo $get_product_row['view'] ?></span>
        </div>
    </div>
    <hr>
    <div class="user-bt-annonce-middle">
        <div class="user-bt-annonce-middle-left">
            <?php 
            while ($get_image_row = $get_product_media_query->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <img src="<?php echo $get_image_row['media_url'] ?>" alt="">
            <?php } ?>
        </div>
        <div class="user-bt-annonce-middle-right">
            <button id="update_bt_annc_<?php echo $id ?>">Modifier</button>
            <button id="renew_bt_annc_<?php echo $id ?>">Renouveller</button>
            <button class="delete-bt-annc" id="delete_bt_annc_<?php echo $id ?>">Supprimer</button>
        </div>
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
?>