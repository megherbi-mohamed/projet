<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_idSender_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_idSender_query->execute();
$get_session_idSender_row = $get_session_idSender_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_idSender_row['id_user'];
$get_all_promotions_query = $conn->prepare("SELECT * FROM promotions WHERE id_user = $id_user ORDER BY id_prm DESC");
$get_all_promotions_query->execute();
$i = 0;
while ($get_all_promotions_row = $get_all_promotions_query->fetch(PDO::FETCH_ASSOC)) {
    $i++;
    $id_prm = $get_all_promotions_row['id_prm'];
    $get_promotion_media_query = $conn->prepare("SELECT media_url,media_type FROM promotions_media WHERE id_prm = $id_prm");
    $get_promotion_media_query->execute();
    $get_promotion_media_row = $get_promotion_media_query->fetch(PDO::FETCH_ASSOC);

    $date_creation = $get_all_promotions_row['date_prm'];
    $date_crt = DateTime::createFromFormat("Y-m-d", $date_creation);
    $date_c = $date_crt->format("d-m");
    $dc = date('m F', strtotime($date_c));

    $get_promotion_product_query = $conn->prepare("SELECT id_prd FROM produit_promotion WHERE id_prm = $id_prm");
    $get_promotion_product_query->execute();
    $get_promotion_product_row = $get_promotion_product_query->fetch(PDO::FETCH_ASSOC);
?>
<div class="promotion-user-overview" id="promotion_user_overview_<?php echo $i ?>">
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
            <h4><?php echo $get_all_promotions_row['titre_prm'] ?></h4>
            <p>créer le <span><?php echo $dc ?></span></p>
        </div>
        <div class="promotion-user-overview-right-middle">
            <p>Participants <span><?php echo $get_all_promotions_row['views_prm'] ?></span></p>
            <p>Personnes interessées <span><?php echo $get_all_promotions_row['save_prm'] ?></span></p>
        </div>
        <div class="promotion-user-overview-right-bottom">
            <input type="hidden" id="id_prm_<?php echo $i ?>" value="<?php echo $get_all_promotions_row['id_prm'] ?>">
            <input type="hidden" id="id_prm_prd_<?php echo $i ?>" value="<?php echo $get_promotion_product_row['id_prd'] ?>">
            <input type="hidden" id="tail_prm_<?php echo $i ?>" value="<?php echo $i ?>">
            <button id="update_prm_<?php echo $i ?>">Modifier</button>
            <button id="delete_prm_<?php echo $i ?>">Supprimer</button>
        </div>
    </div>
</div>
<?php } ?>