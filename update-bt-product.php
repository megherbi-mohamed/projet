<?php
session_start();
include_once './bdd/connexion.php';
$id_prd = htmlspecialchars($_POST['id_prd']);
$nom_prd = htmlspecialchars($_POST['nom_prd']);
$description_prd = htmlspecialchars($_POST['description_prd']);
$categorie_prd = htmlspecialchars($_POST['categorie_prd']);
$quantite_prd = htmlspecialchars($_POST['quantite_prd']);
$type_prd = htmlspecialchars($_POST['type_prd']);
$prix_prd = htmlspecialchars($_POST['prix_prd']);
$id = htmlspecialchars($_POST['tail_prd']);

$update_product_query = "UPDATE produit_boutdechantier SET nom_prd = '$nom_prd', categorie_prd = '$categorie_prd', 
description_prd = '$description_prd', quantite_prd = '$quantite_prd', prix_prd = '$prix_prd', type_prd = '$type_prd' WHERE id_prd = '$id_prd'";
if(mysqli_query($conn, $update_product_query)){
    $update_media_query = "UPDATE bt_produits_media SET etat = 0 WHERE id_prd = '$id_prd'";
    if (mysqli_query($conn,$update_media_query)) {
        $get_product_query = "SELECT * FROM produit_boutdechantier WHERE id_prd = '$id_prd'";
        if ($get_product_result = mysqli_query($conn,$get_product_query)) {
            $get_product_row = mysqli_fetch_assoc($get_product_result); 
            $get_product_media_query = "SELECT * FROM bt_produits_media WHERE id_prd = '$id_prd'";
            $get_product_media_result = mysqli_query($conn,$get_product_media_query);
?>

<input type="hidden" id="tail_prd_<?php echo $id ?>" value="<?php echo $id ?>">
<input type="hidden" id="id_prd_<?php echo $id ?>" value="<?php echo $get_product_row['id_prd'] ?>">
<input type="hidden" id="name_prd_<?php echo $id ?>" value="<?php echo $get_product_row['nom_prd'] ?>">
<input type="hidden" id="categorie_prd_<?php echo $id ?>" value="<?php echo $get_product_row['categorie_prd'] ?>">
<input type="hidden" id="description_prd_<?php echo $id ?>" value="<?php echo $get_product_row['description_prd'] ?>">
<input type="hidden" id="quantity_prd_<?php echo $id ?>" value="<?php echo $get_product_row['quantite_prd'] ?>">
<input type="hidden" id="type_prd_<?php echo $id ?>" value="<?php echo $get_product_row['type_prd'] ?>">
<input type="hidden" id="price_prd_<?php echo $id ?>" value="<?php echo $get_product_row['prix_prd'] ?>">
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
            while ($get_image_row = mysqli_fetch_assoc($get_product_media_result)) {
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
        }else{
            echo 0;
        }
    }else{
        echo 0;
    }
}else{
    echo 0;
}
?>