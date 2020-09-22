<?php 
session_start();
include_once './bdd/connexion.php';
$id_user = htmlspecialchars($_SESSION['user']);
$get_user_bt_annc_query = "SELECT * FROM produit_boutdechantier WHERE id_user = $id_user";
$get_user_bt_annc_result = mysqli_query($conn,$get_user_bt_annc_query);
if (mysqli_num_rows($get_user_bt_annc_result) > 0) {
?>
<div class="user-bt-annonces">
    <?php
    $i = 0;
    while ($get_user_bt_annc_row = mysqli_fetch_assoc($get_user_bt_annc_result)) {
    $i++;
    $get_image_query = "SELECT media_url FROM bt_produits_media WHERE id_prd = {$get_user_bt_annc_row['id_prd']}";
    $get_image_result = mysqli_query($conn, $get_image_query);
    ?>
    <input type="hidden" id="tail_prd_<?php echo $i ?>" value="<?php echo $i ?>">
    <input type="hidden" id="id_prd_<?php echo $i ?>" value="<?php echo $get_user_bt_annc_row['id_prd'] ?>">
    <input type="hidden" id="name_prd_<?php echo $i ?>" value="<?php echo $get_user_bt_annc_row['nom_prd'] ?>">
    <input type="hidden" id="categorie_prd_<?php echo $i ?>" value="<?php echo $get_user_bt_annc_row['categorie_prd'] ?>">
    <input type="hidden" id="description_prd_<?php echo $i ?>" value="<?php echo $get_user_bt_annc_row['description_prd'] ?>">
    <input type="hidden" id="quantity_prd_<?php echo $i ?>" value="<?php echo $get_user_bt_annc_row['quantite_prd'] ?>">
    <input type="hidden" id="type_prd_<?php echo $i ?>" value="<?php echo $get_user_bt_annc_row['type_prd'] ?>">
    <input type="hidden" id="price_prd_<?php echo $i ?>" value="<?php echo $get_user_bt_annc_row['prix_prd'] ?>">
    <div class="user-bt-annonce" id="user_bt_annonce_<?php echo $i ?>">
        <div class="user-bt-annonce-top">
            <h4><?php echo $get_user_bt_annc_row['nom_prd'] ?></h4>
            <p>Ajouté le <?php echo $get_user_bt_annc_row['date'] ?></p>
            <div>
                <i class="fas fa-eye"></i>
                <span><?php echo $get_user_bt_annc_row['view'] ?></span>
            </div>
        </div>
        <hr>
        <div class="user-bt-annonce-middle">
            <div class="user-bt-annonce-middle-left">
                <?php 
                while ($get_image_row = mysqli_fetch_assoc($get_image_result)) {
                ?>
                <img src="<?php echo $get_image_row['media_url'] ?>" alt="">
                <?php } ?>
            </div>
            <div class="user-bt-annonce-middle-right">
                <button id="update_bt_annc_<?php echo $i ?>">Modifier</button>
                <button id="renew_bt_annc_<?php echo $i ?>">Renouveller</button>
                <button class="delete-bt-annc" id="delete_bt_annc_<?php echo $i ?>">Supprimer</button>
            </div>
        </div>
        <div id="loader_annonce" class="center"></div>
    </div>
    <?php } ?>
</div>
<?php }else{ ?>
<div class="empty-msg-ntf">
    <p>Auccune annoces pour vous</p>
</div>
<?php } ?>