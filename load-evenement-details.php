<?php
session_start();
include_once './bdd/connexion.php';
if (isset($_SESSION['user'])) {
    $id_session = htmlspecialchars($_SESSION['user']);
    $get_session_user_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                                OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
    if ($get_session_user_query->execute()) {
        $get_session_user_row = $get_session_user_query->fetch(PDO::FETCH_ASSOC);
        $id_user = $get_session_user_row['id_user'];
        $id_evn = htmlspecialchars($_POST['id_evn']);
        $get_evenement_details_query = $conn->prepare("SELECT * FROM evenements WHERE id_evn = $id_evn");
        if ($get_evenement_details_query->execute()) {
            $get_evenement_details_row = $get_evenement_details_query->fetch(PDO::FETCH_ASSOC);

            $date_debut = $get_evenement_details_row['date_debut_evn'];
            $date_d = DateTime::createFromFormat("Y-m-d H:i:s", $date_debut);
            $date_ddp = $date_d->format("d-m");
            $ddp = date('m F', strtotime($date_ddp));

            $time_debut = $get_evenement_details_row['date_debut_evn'];
            $time_d = strtotime($time_debut);
            $tdp = date('H', $time_d);

            $date_fin = $get_evenement_details_row['date_fin_evn'];
            $date_f = DateTime::createFromFormat("Y-m-d H:i:s", $date_fin);
            $date_dfp = $date_f->format("d-m");
            $dfp = date('m F', strtotime($date_dfp));

            $time_fin = $get_evenement_details_row['date_fin_evn'];
            $time_f = strtotime($time_fin);
            $tfp = date('H', $time_f);

            $get_evenement_media_query = $conn->prepare("SELECT media_url,media_type FROM evenements_media WHERE id_evn = $id_evn");
            $get_saved_evenement_query = $conn->prepare("SELECT * FROM evenements_enregistres WHERE id_evn = $id_evn AND id_user = $id_user");
            $get_participant_evenement_query = $conn->prepare("SELECT * FROM evenements_participants WHERE id_evn = $id_evn AND id_user = $id_user");
            $id_user_evn = $get_evenement_details_row['id_user'];
            $get_user_query = $conn->prepare("SELECT id_user,img_user,nom_user FROM utilisateurs WHERE id_user = $id_user_evn");
            if ($get_evenement_media_query->execute() && $get_saved_evenement_query->execute() && $get_user_query->execute() && $get_participant_evenement_query->execute()) {
                $get_evenement_media_row = $get_evenement_media_query->fetch(PDO::FETCH_ASSOC);
?>    
<div class="evenement-details-top">
    <div class="cancel-evenement-details-resp" id="cancel_evenement_details_resp">
        <i class="fas fa-arrow-left"></i>
    </div>
    <p>evenement details</p>
</div>
<div class="evenement-details-description">
    <div class="evenement-details-left">
        <h2><?php echo $get_evenement_details_row['titre_evn'] ?></h2>
        <?php 
        $get_user_row = $get_user_query->fetch(PDO::FETCH_ASSOC);
        ?>
        <div class="evenement-createur">
            <p>Crée par</p>
            <input type="hidden" id="type_evn_crtr" value="user">
            <input type="hidden" id="id_evn_crtr" value="<?php echo $get_user_row['id_user'] ?>">
            <img id="show_evenement_creator" src="<?php echo './'.$get_user_row['img_user'] ?>" alt="">
            <h4><?php echo $get_user_row['nom_user'] ?></h4>
        </div>
        <h4>Date debut de evenement : <span><?php echo $ddp.' à '.$tdp.'h' ?></span></h4>
        <h4>Date de fin de evenement : <span><?php echo $dfp.' à '.$tfp.'h' ?></span></h4>
        <p><?php echo $get_evenement_details_row['ville_evn'].', '.$get_evenement_details_row['commune_evn'].', '.$get_evenement_details_row['adresse_evn'] ?></p>
        <p id="description_evenement"><?php echo $get_evenement_details_row['description_evn'] ?></p>
        <div class="evenement-details-left-button">
            <input type="hidden" id="latitude_evn" value="<?php echo $get_evenement_details_row['latitude_evn'] ?>">
            <input type="hidden" id="longitude_evn" value="<?php echo $get_evenement_details_row['longitude_evn'] ?>">
            <div class="show-evenement-position" id="show_evenement_position">
                <p>Position</p>
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="show-evenement-direction" id="show_evenement_direction">
                <p>Direction</p>    
                <i class="fas fa-directions"></i>
            </div>
            <input type="hidden" id="id_evenement" value="<?php echo $get_evenement_details_row['id_evn'] ?>">
            <?php
            if ($get_saved_evenement_query->rowCount() > 0) {
                $get_saved_evenement_row = $get_saved_evenement_query->fetch(PDO::FETCH_ASSOC);
                if ($get_saved_evenement_row['id_user'] == $id_user) { ?>
                <p>interessé(e)</p>
                <?php } else { ?>
                <button id="save_evenement">interesser</button>
                <?php }} else { ?>
                <button id="save_evenement">interesser</button>
            <?php } ?>
            <?php
            if ($get_participant_evenement_query->rowCount() > 0) {
                $get_participant_evenement_row = $get_participant_evenement_query->fetch(PDO::FETCH_ASSOC);
                if ($get_participant_evenement_row['id_user'] == $id_user) { ?>
                <p>participé(e)</p>
                <?php } else { ?>
                <button id="updt_view">participer</button>
                <?php }} else { ?>
                <button id="updt_view">participer</button>
            <?php } ?>
        </div>
    </div>
    <div class="evenement-details-right">
        <?php if ($get_evenement_media_row['media_type'] == 'i') { ?>
        <img src="<?php echo './'.$get_evenement_media_row['media_url'] ?>" alt="">
        <?php } else { ?>
        <video controls><source src="<?php echo $get_evenement_media_row['media_url']?>"></video>
        <?php } ?>        
    </div>
</div>
<script>
if (windowWidth < 768) {
    $('.show-evenement-position p').remove();
    $('.show-evenement-direction p').remove();
}
</script>
<?php 
            }
            else{
                echo 0;
            }
        }
        else{
            echo 0;
        }
    }
    else{
        echo 0;
    }
}
else {
    $id_evn = htmlspecialchars($_POST['id_evn']);
    $get_evenement_details_query = $conn->prepare("SELECT * FROM evenements WHERE id_evn = $id_evn");
    if ($get_evenement_details_query->execute()) {
        $get_evenement_details_row = $get_evenement_details_query->fetch(PDO::FETCH_ASSOC);

        $date_debut = $get_evenement_details_row['date_debut_evn'];
        $date_d = DateTime::createFromFormat("Y-m-d H:i:s", $date_debut);
        $date_ddp = $date_d->format("d-m");
        $ddp = date('m F', strtotime($date_ddp));

        $time_debut = $get_evenement_details_row['date_debut_evn'];
        $time_d = strtotime($time_debut);
        $tdp = date('H', $time_d);

        $date_fin = $get_evenement_details_row['date_fin_evn'];
        $date_f = DateTime::createFromFormat("Y-m-d H:i:s", $date_fin);
        $date_dfp = $date_f->format("d-m");
        $dfp = date('m F', strtotime($date_dfp));

        $time_fin = $get_evenement_details_row['date_fin_evn'];
        $time_f = strtotime($time_fin);
        $tfp = date('H', $time_f);

        $get_evenement_media_query = $conn->prepare("SELECT media_url,media_type FROM evenements_media WHERE id_evn = $id_evn");
        $id_user_evn = $get_evenement_details_row['id_user'];
        $get_user_query = $conn->prepare("SELECT id_user,img_user,nom_user FROM utilisateurs WHERE id_user = $id_user_evn");
        if ($get_evenement_media_query->execute() && $get_user_query->execute()) {
            $get_evenement_media_row = $get_evenement_media_query->fetch(PDO::FETCH_ASSOC);
?>    
<div class="evenement-details-top">
    <div class="cancel-evenement-details-resp" id="cancel_evenement_details_resp">
        <i class="fas fa-arrow-left"></i>
    </div>
    <p>evenement details</p>
</div>
<div class="evenement-details-description">
    <div class="evenement-details-left">
        <h2><?php echo $get_evenement_details_row['titre_evn'] ?></h2>
        <?php 
        $get_user_row = $get_user_query->fetch(PDO::FETCH_ASSOC);
        ?>
        <div class="evenement-createur">
            <p>Crée par</p>
            <input type="hidden" id="type_evn_crtr" value="user">
            <input type="hidden" id="id_evn_crtr" value="<?php echo $get_user_row['id_user'] ?>">
            <img id="show_evenement_creator" src="<?php echo './'.$get_user_row['img_user'] ?>" alt="">
            <h4><?php echo $get_user_row['nom_user'] ?></h4>
        </div>
        <h4>Date debut de evenement : <span><?php echo $ddp.' à '.$tdp.'h' ?></span></h4>
        <h4>Date de fin de evenement : <span><?php echo $dfp.' à '.$tfp.'h' ?></span></h4>
        <p><?php echo $get_evenement_details_row['ville_evn'].', '.$get_evenement_details_row['commune_evn'].', '.$get_evenement_details_row['adresse_evn'] ?></p>
        <p id="description_evenement"><?php echo $get_evenement_details_row['description_evn'] ?></p>
        <div class="evenement-details-left-button">
            <input type="hidden" id="latitude_evn" value="<?php echo $get_evenement_details_row['latitude_evn'] ?>">
            <input type="hidden" id="longitude_evn" value="<?php echo $get_evenement_details_row['longitude_evn'] ?>">
            <div class="show-evenement-position" id="show_evenement_position">
                <p>Position</p>
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="show-evenement-direction" id="show_evenement_direction">
                <p>Direction</p>    
                <i class="fas fa-directions"></i>
            </div>
            <input type="hidden" id="id_evenement" value="<?php echo $get_evenement_details_row['id_evn'] ?>">
        </div>
    </div>
    <div class="evenement-details-right">
        <?php if ($get_evenement_media_row['media_type'] == 'i') { ?>
        <img src="<?php echo './'.$get_evenement_media_row['media_url'] ?>" alt="">
        <?php } else { ?>
        <video controls><source src="<?php echo $get_evenement_media_row['media_url']?>"></video>
        <?php } ?>        
    </div>
</div>
<script>
if (windowWidth < 768) {
    $('.show-evenement-position p').remove();
    $('.show-evenement-direction p').remove();
}
</script>
<?php 
        }
        else{
            echo 0;
        }
    }
    else{
        echo 0;
    }
}
?>