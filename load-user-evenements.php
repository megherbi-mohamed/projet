<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_user_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_user_query->execute();
$get_session_user_row = $get_session_user_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_user_row['id_user'];
$get_all_evenements_query = $conn->prepare("SELECT * FROM evenements WHERE id_user = $id_user ORDER BY id_evn DESC");
if ($get_all_evenements_query->execute()){
    if ($get_all_evenements_query->rowCount()) {
        $i = 0;
        while ($get_all_evenements_row = $get_all_evenements_query->fetch(PDO::FETCH_ASSOC)) {
            $i++;
            $id_evn = $get_all_evenements_row['id_evn'];
            $get_evenement_media_query = $conn->prepare("SELECT media_url,media_type FROM evenements_media WHERE id_evn = $id_evn");
            $get_evenement_media_query->execute();
            $get_evenement_media_row = $get_evenement_media_query->fetch(PDO::FETCH_ASSOC);

            // echo $date_creation = $get_all_evenements_row['date_evn'];
            // echo $date_crt = DateTime::createFromFormat("Y-m-d", $date_creation);
            // $date_c = $date_crt->format("d-m");
            // $dc = date('m F', strtotime($date_c));
?>
<div class="evenement-user-overview" id="evenement_user_overview_<?php echo $i ?>">
    <div class="evenement-user-overview-right">
        <div class="evenement-user-overview-right-top">
            <h4><?php echo $get_all_evenements_row['titre_evn'] ?></h4>
            <!-- <p>créer le <span><?php echo $dc ?></span></p> -->
        </div>
        <div class="evenement-user-overview-right-middle">
            <p>Participants <span><?php echo $get_all_evenements_row['views_evn'] ?></span></p>
            <p>Personnes interessées <span><?php echo $get_all_evenements_row['save_evn'] ?></span></p>
        </div>
        <div class="evenement-user-overview-right-bottom">
            <input type="hidden" id="id_evn_<?php echo $i ?>" value="<?php echo $get_all_evenements_row['id_evn'] ?>">
            <input type="hidden" id="tail_evn_<?php echo $i ?>" value="<?php echo $i ?>">
            <button id="update_evn_<?php echo $i ?>">Modifier</button>
            <button id="delete_evn_<?php echo $i ?>">Supprimer</button>
        </div>
    </div>
    <div class="evenement-user-overview-left">
        <div class="evenement-user-overview-left-media">
            <?php if ($get_evenement_media_row['media_type'] == 'i') { ?>
            <img src="./<?php echo $get_evenement_media_row['media_url'] ?>" alt="">
            <?php } else { ?>
            <video id="evenement_video_<?php echo $i ?>"><source src="<?php echo $get_evenement_media_row['media_url']?>"></video>
            <div id="show_evenement_video_<?php echo $i ?>">
                <i class="fas fa-play"></i>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
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