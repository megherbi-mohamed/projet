<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_idSender_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_idSender_query->execute();
$get_session_idSender_row = $get_session_idSender_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_idSender_row['id_user'];
$id_prm = htmlspecialchars($_POST['id_prm']);
$get_promotion_details_query = $conn->prepare("SELECT * FROM promotions WHERE id_prm = $id_prm");
$get_promotion_details_query->execute();
$get_promotion_details_row = $get_promotion_details_query->fetch(PDO::FETCH_ASSOC);

$date_debut = $get_promotion_details_row['date_debut_prm'];
$date_d = DateTime::createFromFormat("Y-m-d H:i:s", $date_debut);
$date_ddp = $date_d->format("d-m");
$ddp = date('m F', strtotime($date_ddp));

$time_debut = $get_promotion_details_row['date_debut_prm'];
$time_d = strtotime($time_debut);
$tdp = date('H', $time_d);

$date_fin = $get_promotion_details_row['date_fin_prm'];
$date_f = DateTime::createFromFormat("Y-m-d H:i:s", $date_fin);
$date_dfp = $date_f->format("d-m");
$dfp = date('m F', strtotime($date_dfp));

$time_fin = $get_promotion_details_row['date_fin_prm'];
$time_f = strtotime($time_fin);
$tfp = date('H', $time_f);

$get_promotion_media_query = $conn->prepare("SELECT media_url,media_type FROM promotions_media WHERE id_prm = $id_prm");
$get_promotion_media_query->execute();
$get_promotion_media_row = $get_promotion_media_query->fetch(PDO::FETCH_ASSOC);
?>
<div class="promotion-details-top">
    <div class="cancel-promotion-details-resp" id="cancel_promotion_details_resp">
        <i class="fas fa-arrow-left"></i>
    </div>
    <p>Promotion details</p>
</div>
<div class="promotion-details-description">
    <div class="promotion-details-descirption-left">
        <?php if ($get_promotion_media_row['media_type'] == 'i') { ?>
        <img src="<?php echo './'.$get_promotion_media_row['media_url'] ?>" alt="">
        <?php } else { ?>
        <video controls><source src="<?php echo $get_promotion_media_row['media_url']?>"></video>
        <?php } ?>
    </div>
    <div class="promotion-details-description-middle">
        <h2><?php echo $get_promotion_details_row['titre_prm'] ?></h2>
        <?php 
        $get_promotion_product_boutique_query = $conn->prepare("SELECT id_btq FROM produit_boutique_promotion WHERE id_prm = $id_prm");
        $get_promotion_product_boutique_query->execute();
        if ($get_promotion_product_boutique_query->rowCount() > 0) {
            $get_promotion_product_boutique_row = $get_promotion_product_boutique_query->fetch(PDO::FETCH_ASSOC);
            $id_btq = $get_promotion_product_boutique_row['id_btq'];
            $get_boutique_query = $conn->prepare("SELECT id_btq,logo_btq,nom_btq FROM boutiques WHERE id_btq = $id_btq");
            $get_boutique_query->execute();
            $get_boutique_row = $get_boutique_query->fetch(PDO::FETCH_ASSOC);
        ?>
        <div class="promotion-createur">
            <p>Crée par</p>
            <input type="hidden" id="type_prm_crtr" value="boutique">
            <input type="hidden" id="id_prm_crtr" value="<?php echo $get_boutique_row['id_btq'] ?>">
            <img id="show_promotion_creator" src="<?php echo './'.$get_boutique_row['logo_btq'] ?>" alt="">
            <h4><?php echo $get_boutique_row['nom_btq'] ?></h4>
        </div>
        <?php } else{ 
            $id_user_prm = $get_promotion_details_row['id_user'];
            $get_user_query = $conn->prepare("SELECT id_user,img_user,nom_user FROM utilisateurs WHERE id_user = $id_user_prm");
            $get_user_query->execute();
            $get_user_row = $get_user_query->fetch(PDO::FETCH_ASSOC);
        ?>
        <div class="promotion-createur">
            <p>Crée par</p>
            <input type="hidden" id="type_prm_crtr" value="user">
            <input type="hidden" id="id_prm_crtr" value="<?php echo $get_user_row['id_user'] ?>">
            <img id="show_promotion_creator" src="<?php echo './'.$get_user_row['img_user'] ?>" alt="">
            <h4><?php echo $get_user_row['nom_user'] ?></h4>
        </div>
        <?php } ?>
        <h4>Date debut de promotion : <span><?php echo $ddp.' à '.$tdp.'h' ?></span></h4>
        <h4>Date de fin de promotion : <span><?php echo $dfp.' à '.$tfp.'h' ?></span></h4>
        <p><?php echo $get_promotion_details_row['ville_prm'].', '.$get_promotion_details_row['commune_prm'].', '.$get_promotion_details_row['adresse_prm'] ?></p>
        <p id="description_promotion"><?php echo $get_promotion_details_row['description_prm'] ?></p>
        <div class="promotion-details-description-middle-button">
            <input type="hidden" id="latitude_prm" value="<?php echo $get_promotion_details_row['latitude_prm'] ?>">
            <input type="hidden" id="longitude_prm" value="<?php echo $get_promotion_details_row['longitude_prm'] ?>">
            <div class="show-promotion-position" id="show_promotion_position">
                <p>Position</p>
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="show-promotion-direction" id="show_promotion_direction">
                <p>Direction</p>    
                <i class="fas fa-directions"></i>
            </div>
            <input type="hidden" id="id_promotion" value="<?php echo $get_promotion_details_row['id_prm'] ?>">
            <?php
            $get_saved_promotion_query = $conn->prepare("SELECT * FROM promotions_enregistres WHERE id_prm = $id_prm AND id_user = $id_user");
            $get_saved_promotion_query->execute();
            if ($get_saved_promotion_query->rowCount() > 0) {
                $get_saved_promotion_row = $get_saved_promotion_query->fetch(PDO::FETCH_ASSOC);
                if ($get_saved_promotion_row['id_user'] == $id_user) { ?>
                <p>interessé(e)</p>
                <?php } else { ?>
                <button id="save_promotion">interesser</button>
                <?php }} else { ?>
                <button id="save_promotion">interesser</button>
            <?php } ?>
            <?php
            $get_participant_promotion_query = $conn->prepare("SELECT * FROM promotions_participants WHERE id_prm = $id_prm AND id_user = $id_user");
            $get_participant_promotion_query->execute();
            if ($get_participant_promotion_query->rowCount() > 0) {
                $get_participant_promotion_row = $get_participant_promotion_query->fetch(PDO::FETCH_ASSOC);
                if ($get_participant_promotion_row['id_user'] == $id_user) { ?>
                <p>participé(e)</p>
                <?php } else { ?>
                <button id="updt_view">participer</button>
                <?php }} else { ?>
                <button id="updt_view">participer</button>
            <?php } ?>
        </div>
    </div>
    <div class="promotion-details-description-right"></div>
</div>
<hr>
<?php 
$get_promotion_boutique_product_query = $conn->prepare("SELECT * FROM produit_boutique_promotion WHERE id_prm = $id_prm");
$get_promotion_boutique_product_query->execute();
$i = 0;
while ($get_promotion_boutique_product_row = $get_promotion_boutique_product_query->fetch(PDO::FETCH_ASSOC)) {
$i++;
$id_btq = $get_promotion_boutique_product_row['id_btq'];
$id_btq_prd = $get_promotion_boutique_product_row['id_btq_prd'];
$get_boutique_product_query = $conn->prepare("SELECT * FROM produit_boutique WHERE id_prd = $id_btq_prd");
$get_boutique_product_query->execute();
$get_boutique_product_row = $get_boutique_product_query->fetch(PDO::FETCH_ASSOC);
$perc_price = round(100-(($get_promotion_boutique_product_row['prix_prm_prd']*100)/$get_boutique_product_row['prix_prd']));
?>
<div class="produit-boutique-promotion-details">
   <div class="produit-boutique-promotion-details-left">
       <img src="<?php echo './'.$get_promotion_boutique_product_row['media_url']?>" alt="">
   </div>
   <div class="produit-boutique-promotion-details-middle">
        <h3><?php echo $get_boutique_product_row['nom_prd'] ?></h3>
        <h4><?php echo $get_boutique_product_row['prix_prd'] ?><i>.Da</i><span><?php echo '-'.$perc_price.'%' ?></span><?php echo $get_promotion_boutique_product_row['prix_prm_prd'] ?><i>.Da</i></h4>
        <p>Référence : <span><?php echo $get_boutique_product_row['reference_prd'] ?></span></p>
        <p>Quantité : <span><?php echo $get_boutique_product_row['quantite_prd'].' pcs' ?></span></p>
        <p id="description_produit"><?php echo $get_boutique_product_row['description_prd'] ?></p>
        <div>
            <p>Voire ce produit deatils et d'autre produits sur la boutique</p>
            <input type="hidden" id="id_btq_<?php echo $i ?>" value="<?php echo $id_btq ?>">
            <input type="hidden" id="id_btq_prd_<?php echo $i ?>" value="<?php echo $id_btq_prd ?>">
            <button id="go_boutique_button_<?php echo $i ?>">Aller à la boutique</button>
        </div>
    </div> 
    <div class="produit-boutique-promotion-details-right"></div>
</div>
<?php } ?>
<script>
if (windowWidth < 768) {
    $('.produit-boutique-promotion-details-middle div button').text('Voir le produit sur la boutique');
}
</script>
<?php 
$get_promotion_product_query = $conn->prepare("SELECT * FROM produit_promotion WHERE id_prm = $id_prm");
$get_promotion_product_query->execute();
while ($get_promotion_product_row = $get_promotion_product_query->fetch(PDO::FETCH_ASSOC)) {
$i++;
$perc_price = round(100-(($get_promotion_product_row['nouveau_prix_prd']*100)/$get_promotion_product_row['ancien_prix_prd']));
$get_fist_promotion_product_media_query = $conn->prepare("SELECT media_url,media_type FROM prm_produits_media WHERE id_prm = $id_prm");
$get_fist_promotion_product_media_query->execute();
$get_fist_promotion_product_media_row = $get_fist_promotion_product_media_query->fetch(PDO::FETCH_ASSOC);
$get_promotion_product_media_query = $conn->prepare("SELECT media_url FROM prm_produits_media WHERE id_prm = $id_prm");
$get_promotion_product_media_query->execute();
?>
<div class="produit-promotion-details">
    <div class="produit-promotion-details-left">
        <?php if ($get_fist_promotion_product_media_row['media_type'] == 'i') { ?>
        <div class="produit-promotion-details-left-top">
            <img src="<?php echo './'.$get_fist_promotion_product_media_row['media_url']?>" alt="">
        </div>
        <div class="produit-promotion-details-left-bottom">
            <?php
            while ($get_promotion_product_media_row = $get_promotion_product_media_query->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="display-modele">
                <img src="<?php echo './'.$get_promotion_product_media_row['media_url'] ?>" alt="">
            </div>
            <?php } ?>
        </div>
        <?php } else { ?>
        <div class="produit-promotion-details-left-top">
            <video controls><source src="<?php echo $get_fist_promotion_product_media_row['media_url']?>"></video>
        </div>
        <div class="produit-promotion-details-left-bottom" style="justify-content:center">
            <video><source src="<?php echo $get_fist_promotion_product_media_row['media_url']?>"></video>
        </div>
        <script>
        if (windowWidth < 768) {
            $('.produit-promotion-details-left-bottom').hide();
        }
        </script>
        <?php } ?>
    </div>
    <div class="produit-promotion-details-middle">
        <h3><?php echo $get_promotion_product_row['nom_prd'] ?></h3>
        <h4><?php echo $get_promotion_product_row['ancien_prix_prd'] ?><i>.Da</i><span><?php echo '-'.$perc_price.'%' ?></span><?php echo $get_promotion_product_row['nouveau_prix_prd'] ?><i>.Da</i></h4>
        <p>Référence : <span><?php echo $get_promotion_product_row['reference_prd'] ?></span></p>
        <p>Quantité : <span><?php echo $get_promotion_product_row['quantite_prd'].' pcs' ?></span></p>
        <p>Fonctionnalités : <span><?php echo $get_promotion_product_row['fonctionnalites_prd'] ?></span></p>
        <p>Caractéristiques : <span><?php echo $get_promotion_product_row['caracteristiques_prd'] ?></span></p>
        <p>Avantages : <span><?php echo $get_promotion_product_row['avantages_prd'] ?></span></p>
        <p id="description_produit"><?php echo $get_promotion_product_row['description_prd'] ?></p>
        <div>
            <p>Appeler le vendeur pour plus de details</p>
            <button><a href="tel:">Appeler le </a></button>
        </div>
    </div>
    <div class="produit-promotion-details-right"></div>
</div>
<?php } ?>