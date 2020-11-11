<?php 
session_start();
include_once './bdd/connexion.php';
$id_session_btq = htmlspecialchars($_POST['id_btq']);
$get_session_btq_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session_btq' OR id_user_1 = '$id_session_btq' OR id_user_2 = '$id_session_btq' 
                                            OR id_user_3 = '$id_session_btq' OR id_user_4 = '$id_session_btq' OR id_user_5 = '$id_session_btq'");
$get_session_btq_query->execute();
$get_session_btq_row = $get_session_btq_query->fetch(PDO::FETCH_ASSOC);
$id_btq = $get_session_btq_row['id_user'];
$btq_inf_query = $conn->prepare("SELECT * FROM boutiques WHERE id_btq = $id_btq");
$btq_inf_query->execute();
$btq_inf_row = $btq_inf_query->fetch(PDO::FETCH_ASSOC);
?>
<div class="update-boutique-informations">
    <h3>Modifier les informations de boutique!</h3>
    <div class="update-boutique-informations-top">
        <div>
            <input type="text" id="nom_btq" value="<?php echo $btq_inf_row['nom_btq'] ?>">
            <span class="nom-btq">Nom *</span>
        </div>
        <div>
            <select id="ville_btq">
                <option value="<?php echo $btq_inf_row['ville_btq'] ?>"><?php echo $btq_inf_row['ville_btq'] ?></option>
                <?php
                $ville_query = $conn->prepare("SELECT * FROM villes");
                $ville_query->execute(); 
                while ($ville_row = $ville_query->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <option value="<?php echo $ville_row['ville'] ?>"><?php echo $ville_row['ville'] ?></option>
                <?php } ?>
            </select>
            <span class="ville-btq">ville *</span>
        </div>
        <div class="commune-btq">
            <select id="commune_btq">
                <option value="<?php echo $btq_inf_row['commune_btq'] ?>"><?php echo $btq_inf_row['commune_btq'] ?></option>
            </select>
            <span class="commun-btq">Commune *</span>
        </div>
        <div>
            <input type="text" id="adresse_btq" value="<?php echo $btq_inf_row['adresse_btq'] ?>">
            <?php if ($btq_inf_row['adresse_btq'] == '') { ?>
                <span class="adresse-btq">Adresse</span>
            <?php } else { ?>
                <span class="btq-span-active">Adresse</span>
            <?php } ?>
        </div>
        <div>
            <input type="text" id="email_btq" value="<?php echo $btq_inf_row['email_btq'] ?>">
            <span class="email-btq">Email</span>
        </div>
        <div>
            <input type="text" id="tlph_btq" value="<?php echo $btq_inf_row['tlph_btq'] ?>">
            <span class="tlph-btq">Téléphone</span>
        </div>
        <div>
            <textarea id="dscrp_btq"></textarea>
            <span class="dscrp-btq">Description *</span>
        </div>
    </div>
    <hr>
    <div class="update-boutique-informations-bottom">
        <h4>Modifier la position de boutique</h4>
        <input type="hidden" id="latitude_btq" value="<?php echo $btq_inf_row['latitude_btq'] ?>">
        <input type="hidden" id="longitude_btq" value="<?php echo $btq_inf_row['longitude_btq'] ?>">
        <button id="update_btq_position">Modifier la position</button>
        <div id="boutique_map"></div>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBEGrApnjX_7GHcNDtF0LR0pgrwxj5j2Q&callback=initBtqMap"></script>
        <script>
            var latitudeBtq = document.querySelector('#latitude_btq');
            var longitudeBtq = document.querySelector('#longitude_btq');
            function initBtqMap() {
                var map = new google.maps.Map(document.getElementById('boutique_map'), {
                    center: new google.maps.LatLng(latitudeBtq.value, longitudeBtq.value),
                    zoom: 14
                });
                var marker = new google.maps.Marker({
                    map: map,
                    position: new google.maps.LatLng(latitudeBtq.value, longitudeBtq.value),
                    icon : {
                        url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png"
                    }
                });
            }
            var villeBtq = document.querySelector('#ville_btq');
            villeBtq.addEventListener('change', function (e) {
                if (e.target.value !== '') {
                    var ville = e.target.value;
                    $('.commune-btq').load('commune-boutique.php?v='+ville);
                }
            })
        </script>
    </div>
    <button id="update_boutique_button">Enregistrer les modification</button>
    <div class="gb-message-alert">
        <p>La modification est en attente de validation par l'administration de NHANNIK!</p>
        <div class="cancel-alert-message">
            <i class="fas fa-times"></i>
        </div>
    </div>
</div>