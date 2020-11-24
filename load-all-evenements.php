<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_user_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_user_query->execute();
$get_session_user_row = $get_session_user_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_user_row['id_user'];
$get_all_evenements_query = $conn->prepare("SELECT * FROM evenements ORDER BY id_evn DESC");
if ($get_all_evenements_query->execute()){
    if ($get_all_evenements_query->rowCount()) {
        $i = 0;
        while ($get_all_evenements_row = $get_all_evenements_query->fetch(PDO::FETCH_ASSOC)) {
        $i++;
        $date_debut = $get_all_evenements_row['date_debut_evn'];
        $date_d = DateTime::createFromFormat("Y-m-d H:i:s", $date_debut);
        $date_ddp = $date_d->format("d-m");
        $ddp = date('m F', strtotime($date_ddp));

        $time_debut = $get_all_evenements_row['date_debut_evn'];
        $time_d = strtotime($time_debut);
        $tdp = date('H', $time_d);

        $date_fin = $get_all_evenements_row['date_fin_evn'];
        $date_f = DateTime::createFromFormat("Y-m-d H:i:s", $date_fin);
        $date_dfp = $date_f->format("d-m");
        $dfp = date('m F', strtotime($date_dfp));

        $time_fin = $get_all_evenements_row['date_fin_evn'];
        $time_f = strtotime($time_fin);
        $tfp = date('H', $time_f);

        $id_evn = $get_all_evenements_row['id_evn'];
        $get_evenement_media_query = $conn->prepare("SELECT media_url,media_type FROM evenements_media WHERE id_evn = $id_evn");
        $get_evenement_media_query->execute();
        $get_evenement_media_row = $get_evenement_media_query->fetch(PDO::FETCH_ASSOC);
?>
<div class="evenement-overview">
    <div class="evenement-overview-right">
        <h3><?php echo $get_all_evenements_row['titre_evn'] ?></h3>
        <div class="evenement-overview-right-middle">
            <p><?php echo $get_all_evenements_row['description_evn'] ?></p>
            <h4>Ajoutée le <span><?php echo $get_all_evenements_row['date_evn'] ?></span></h4>
            <h4>Debut d'évènement : <span><?php echo $ddp.' à '.$tdp.'h' ?></span></h4>
            <h4>fin d'évènement : <span><?php echo $dfp.' à '.$tfp.'h' ?></span></h4>
            <p><?php echo $get_all_evenements_row['ville_evn'].', '.$get_all_evenements_row['commune_evn'].', '.$get_all_evenements_row['adresse_evn'] ?></p>
        </div>
        <div class="evenement-overview-right-bottom">
            <input type="hidden" id="latitude_evn_<?php echo $i ?>" value="<?php echo $get_all_evenements_row['latitude_evn'] ?>">
            <input type="hidden" id="longitude_evn_<?php echo $i ?>" value="<?php echo $get_all_evenements_row['longitude_evn'] ?>">
            <div id="show_evenement_position_<?php echo $i ?>">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div id="show_evenement_direction_<?php echo $i ?>">
                <i class="fas fa-directions"></i>
            </div>
            <input type="hidden" id="id_evenement_<?php echo $i ?>" value="<?php echo $get_all_evenements_row['id_evn'] ?>">
            <?php
            $get_saved_evenement_query = $conn->prepare("SELECT * FROM evenements_enregistres WHERE id_evn = $id_evn AND id_user = $id_user");
            $get_saved_evenement_query->execute();
            if ($get_saved_evenement_query->rowCount() > 0) {
                $get_saved_evenement_row = $get_saved_evenement_query->fetch(PDO::FETCH_ASSOC);
                if ($get_saved_evenement_row['id_user'] == $id_user) { ?>
                <p>interessé(e)</p>
                <?php } else { ?>
                <button id="save_evenement_<?php echo $i ?>">interesser</button>
                <?php }} else { ?>
                <button id="save_evenement_<?php echo $i ?>">interesser</button>
            <?php } ?>
            <?php
            $get_participant_evenement_query = $conn->prepare("SELECT * FROM evenements_participants WHERE id_evn = $id_evn AND id_user = $id_user");
            $get_participant_evenement_query->execute();
            if ($get_participant_evenement_query->rowCount() > 0) {
                $get_participant_evenement_row = $get_participant_evenement_query->fetch(PDO::FETCH_ASSOC);
                if ($get_participant_evenement_row['id_user'] == $id_user) { ?>
                <p>participé(e)</p>
                <?php } else { ?>
                <button id="updt_view_<?php echo $i ?>">participer</button>
                <?php }} else { ?>
                <button id="updt_view_<?php echo $i ?>">participer</button>
            <?php } ?>
            <button id="evenement_details_button_<?php echo $i ?>">Voir details</button>
        </div>
    </div>
    <div class="evenement-overview-left">
        <div class="evenement-overview-left-media">
            <?php if ($get_evenement_media_row['media_type'] == 'i') { ?>
            <img src="./<?php echo $get_evenement_media_row['media_url'] ?>" alt="">
            <?php } else { ?>
            <video id="evenement_video_<?php echo $i ?>"><source src="<?php echo $get_evenement_media_row['media_url']?>"></video>
            <div id="show_evenement_video_<?php echo $i ?>">
                <i class="fas fa-play"></i>
            </div>
            <?php } ?>
            <p id="evenement_participate_<?php echo $i ?>">Participants <span><?php echo $get_all_evenements_row['views_evn'] ?></span></p>
        </div>
    </div>
</div>
<script>
if (windowWidth < 768) {
    $('[id^="evenement_details_button_"]').html('Details');
}
</script>
<?php
    }
}
else{
?>
<div class="empty-evn">
    <p>Aucune evenement</p>
</div>
<?php
    }
}
else{
    echo 0;
}
?>