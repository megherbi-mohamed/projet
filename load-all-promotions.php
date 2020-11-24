<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_user_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_user_query->execute();
$get_session_user_row = $get_session_user_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_user_row['id_user'];
$get_all_promotions_query = $conn->prepare("SELECT * FROM promotions ORDER BY id_prm DESC");
if ($get_all_promotions_query->execute()){
    if ($get_all_promotions_query->rowCount()) {
        $i = 0;
        while ($get_all_promotions_row = $get_all_promotions_query->fetch(PDO::FETCH_ASSOC)) {
        $i++;
        $date_debut = $get_all_promotions_row['date_debut_prm'];
        $date_d = DateTime::createFromFormat("Y-m-d H:i:s", $date_debut);
        $date_ddp = $date_d->format("d-m");
        $ddp = date('m F', strtotime($date_ddp));

        $time_debut = $get_all_promotions_row['date_debut_prm'];
        $time_d = strtotime($time_debut);
        $tdp = date('H', $time_d);

        $date_fin = $get_all_promotions_row['date_fin_prm'];
        $date_f = DateTime::createFromFormat("Y-m-d H:i:s", $date_fin);
        $date_dfp = $date_f->format("d-m");
        $dfp = date('m F', strtotime($date_dfp));

        $time_fin = $get_all_promotions_row['date_fin_prm'];
        $time_f = strtotime($time_fin);
        $tfp = date('H', $time_f);

        $id_prm = $get_all_promotions_row['id_prm'];
        $get_promotion_media_query = $conn->prepare("SELECT media_url,media_type FROM promotions_media WHERE id_prm = $id_prm");
        $get_promotion_media_query->execute();
        $get_promotion_media_row = $get_promotion_media_query->fetch(PDO::FETCH_ASSOC);
?>
<div class="promotion-overview">
    <div class="promotion-overview-left">
        <div class="promotion-overview-left-media">
            <?php if ($get_promotion_media_row['media_type'] == 'i') { ?>
            <img src="./<?php echo $get_promotion_media_row['media_url'] ?>" alt="">
            <?php } else { ?>
            <video id="promotion_video_<?php echo $i ?>"><source src="<?php echo $get_promotion_media_row['media_url']?>"></video>
            <div id="show_promotion_video_<?php echo $i ?>">
                <i class="fas fa-play"></i>
            </div>
            <?php } ?>
            <p id="promotion_participate_<?php echo $i ?>">Participants <span><?php echo $get_all_promotions_row['views_prm'] ?></span></p>
        </div>
    </div>
    <div class="promotion-overview-right">
        <h3><?php echo $get_all_promotions_row['titre_prm'] ?></h3>
        <div class="promotion-overview-right-middle">
            <p><?php echo $get_all_promotions_row['description_prm'] ?></p>
            <h4>Ajoutée le <span><?php echo $get_all_promotions_row['date_prm'] ?></span></h4>
            <h4>Debut de pormotion : <span><?php echo $ddp.' à '.$tdp.'h' ?></span></h4>
            <h4>fin de promotion : <span><?php echo $dfp.' à '.$tfp.'h' ?></span></h4>
            <p><?php echo $get_all_promotions_row['ville_prm'].', '.$get_all_promotions_row['commune_prm'].', '.$get_all_promotions_row['adresse_prm'] ?></p>
        </div>
        <div class="promotion-overview-right-bottom">
            <input type="hidden" id="latitude_prm_<?php echo $i ?>" value="<?php echo $get_all_promotions_row['latitude_prm'] ?>">
            <input type="hidden" id="longitude_prm_<?php echo $i ?>" value="<?php echo $get_all_promotions_row['longitude_prm'] ?>">
            <div id="show_promotion_position_<?php echo $i ?>">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div id="show_promotion_direction_<?php echo $i ?>">
                <i class="fas fa-directions"></i>
            </div>
            <input type="hidden" id="id_promotion_<?php echo $i ?>" value="<?php echo $get_all_promotions_row['id_prm'] ?>">
            <?php
            $get_saved_promotion_query = $conn->prepare("SELECT * FROM promotions_enregistres WHERE id_prm = $id_prm AND id_user = $id_user");
            $get_saved_promotion_query->execute();
            if ($get_saved_promotion_query->rowCount() > 0) {
                $get_saved_promotion_row = $get_saved_promotion_query->fetch(PDO::FETCH_ASSOC);
                if ($get_saved_promotion_row['id_user'] == $id_user) { ?>
                <p>interessé(e)</p>
                <?php } else { ?>
                <button id="save_promotion_<?php echo $i ?>">interesser</button>
                <?php }} else { ?>
                <button id="save_promotion_<?php echo $i ?>">interesser</button>
            <?php } ?>
            <?php
            $get_participant_promotion_query = $conn->prepare("SELECT * FROM promotions_participants WHERE id_prm = $id_prm AND id_user = $id_user");
            $get_participant_promotion_query->execute();
            if ($get_participant_promotion_query->rowCount() > 0) {
                $get_participant_promotion_row = $get_participant_promotion_query->fetch(PDO::FETCH_ASSOC);
                if ($get_participant_promotion_row['id_user'] == $id_user) { ?>
                <p>participé(e)</p>
                <?php } else { ?>
                <button id="updt_view_<?php echo $i ?>">participer</button>
                <?php }} else { ?>
                <button id="updt_view_<?php echo $i ?>">participer</button>
            <?php } ?>
            <button id="promotion_details_button_<?php echo $i ?>">Voir details</button>
        </div>
    </div>
</div>
<script>
if (windowWidth < 768) {
    $('[id^="promotion_details_button_"]').html('Details');
}
</script>
<?php
    }
}
else{
?>
<div class="empty-prm">
    <p>Aucune promotion</p>
</div>
<?php
    }
}
else{
    echo 0;
}
?>