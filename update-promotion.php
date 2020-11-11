<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_user_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_user_query->execute();
$get_session_user_row = $get_session_user_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_user_row['id_user'];
$tail_prm = htmlspecialchars($_POST['tail_prm']);
$id_prm = htmlspecialchars($_POST['id_prm']);
$titre_prm = htmlspecialchars($_POST['titre_prm']);
$categorie_prm = htmlspecialchars($_POST['categorie_prm']);
$sous_categorie_prm = htmlspecialchars($_POST['sous_categorie_prm']);
$lieu_prm = htmlspecialchars($_POST['lieu_prm']);
$adresse_prm = htmlspecialchars($_POST['adresse_prm']);
$latitude_prm = htmlspecialchars($_POST['latitude_prm']);
$longitude_prm = htmlspecialchars($_POST['longitude_prm']);
$date_debut_prm = htmlspecialchars($_POST['date_debut_prm']);
$date_fin_prm = htmlspecialchars($_POST['date_fin_prm']);
$description_prm = htmlspecialchars($_POST['description_prm']);

$id_prd = htmlspecialchars($_POST['id_prd']);
$nom_prd = htmlspecialchars($_POST['nom_prd']);
$reference_prd = htmlspecialchars($_POST['reference_prd']);
$quantite_prd = htmlspecialchars($_POST['quantite_prd']);
$prix_prd = htmlspecialchars($_POST['prix_prd']);
$fonctionnalites_prd = htmlspecialchars($_POST['fonctionalites_prd']);
$caracteristiques_prd = htmlspecialchars($_POST['caracteristiques_prd']);
$avantages_prd = htmlspecialchars($_POST['avantages_prd']);
$description_prd = htmlspecialchars($_POST['description_prd']);

$update_promotion_query = $conn->prepare("UPDATE promotions SET titre_prm = '$titre_prm', categorie_prm = '$categorie_prm', sous_categorie_prm = '$sous_categorie_prm', lieu_prm = '$lieu_prm', adresse_prm = '$adresse_prm', 
latitude_prm = $latitude_prm, longitude_prm = $longitude_prm, date_debut_prm = '$date_debut_prm', date_fin_prm = '$date_fin_prm', description_prm = '$description_prm' WHERE id_prm = $id_prm AND id_user = $id_user");

$update_id_product_query = $conn->prepare("UPDATE produit_promotion SET nom_prd = '$nom_prd', reference_prd = '$reference_prd', quantite_prd = '$quantite_prd', prix_prd = '$prix_prd', 
fonctionnalites_prd = '$fonctionnalites_prd', caracteristiques_prd = '$caracteristiques_prd', avantages_prd = '$avantages_prd', description_prd = '$description_prd' WHERE id_prm = $id_prm AND id_prd = $id_prd");

if ($update_promotion_query->execute() && $update_id_product_query->execute()) {
    $update_promotion_media_query = $conn->prepare("UPDATE promotions_media SET etat = 0 WHERE id_prm = '$id_prm'");
    $update_id_product_media_query = $conn->prepare("UPDATE prm_produits_media SET etat = 0 WHERE id_prd = $id_prd");
    if ($update_promotion_media_query->execute() && $update_id_product_media_query->execute()) {
    
    $get_updated_promotions_query = $conn->prepare("SELECT * FROM promotions WHERE id_prm = $id_prm");
    $get_updated_promotions_query->execute();
    $get_updated_promotions_row = $get_updated_promotions_query->fetch(PDO::FETCH_ASSOC);
    
    $get_promotion_media_query = $conn->prepare("SELECT media_url,media_type FROM promotions_media WHERE id_prm = $id_prm");
    $get_promotion_media_query->execute();
    $get_promotion_media_row = $get_promotion_media_query->fetch(PDO::FETCH_ASSOC);
    
    $date_creation = $get_updated_promotions_row['date_prm'];
    $date_crt = DateTime::createFromFormat("Y-m-d", $date_creation);
    $date_c = $date_crt->format("d-m");
    $dc = date('m F', strtotime($date_c));
    
    $get_id_product_query = $conn->prepare("SELECT id_prd FROM produit_promotion WHERE id_prm = $id_prm");
    $get_id_product_query->execute();
    $get_id_product_row = $get_id_product_query->fetch(PDO::FETCH_ASSOC);
?>    
<div class="promotion-user-overview" id="promotion_user_overview_<?php echo $tail_prm ?>">
    <div class="promotion-user-overview-left">
        <div>
            <?php if ($get_promotion_media_row['media_type'] == 'i') { ?>
                <img src="./<?php echo $get_promotion_media_row['media_url'] ?>" alt="">
            <?php } else { ?>
                <!-- video -->
            <?php } ?>
        </div>
    </div>
    <div class="promotion-user-overview-right">
        <div class="promotion-user-overview-right-top">
            <h4><?php echo $get_updated_promotions_row['titre_prm'] ?></h4>
            <p>créer le <span><?php echo $dc ?></span></p>
        </div>
        <div class="promotion-user-overview-right-middle">
            <p>Participants <span><?php echo $get_updated_promotions_row['views_prm'] ?></span></p>
            <p>Personnes interessées <span><?php echo $get_updated_promotions_row['save_prm'] ?></span></p>
        </div>
        <div class="promotion-user-overview-right-bottom">
            <input type="hidden" id="id_prm_<?php echo $tail_prm ?>" value="<?php echo $get_updated_promotions_row['id_prm'] ?>">
            <input type="hidden" id="id_prm_prd_<?php echo $tail_prm ?>" value="<?php echo $get_id_product_row['id_prd'] ?>">
            <input type="hidden" id="tail_prm_<?php echo $tail_prm ?>" value="<?php echo $tail_prm ?>">
            <button id="update_prm_<?php echo $tail_prm ?>">Modifier</button>
            <button id="delete_prm_<?php echo $tail_prm ?>">Supprimer</button>
        </div>
    </div>
</div>    
<?php
    }else{
        echo 0;
    }
}
else{
    echo 0;
}
?>