<?php 
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_id_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                        OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_id_query->execute();
$get_session_id_row = $get_session_id_query->fetch(PDO::FETCH_ASSOC);
$user_session_query = $conn->prepare("SELECT * FROM utilisateurs WHERE id_user = {$get_session_id_row['id_user']}");
$user_session_query->execute();
if ($user_session_query->rowCount() > 0) {
    $row = $user_session_query->fetch(PDO::FETCH_ASSOC);
    $uid = $id_session;
    $id_user = $row['id_user'];
}
else{
    header('Location: inscription-connexion.php');
}
?>
<div class="update-profile-informations">
    <h3>Modifier les informations de profile!</h3>
    <div class="update-profile-informations-top">
        <div class="update-profile-input">
            <input type="text" id="nom_user" value="<?php echo $row['nom_user'] ?>">
            <span class="nom-user active-updt-prf-span">Nom *</span>
        </div>
        <div class="update-profile-input">
            <input type="text" id="nom_entrp_user" value="<?php echo $row['nom_entrp_user'] ?>">
            <span class="nom-user active-updt-prf-span">Nom d'entreprise *</span>
        </div>
        <div class="update-profile-input" id="user_categorie_select">
            <span class="categorie-user active-updt-prf-span">Categorie *</span>
            <select id="categorie_user">
                <option value="">Categories</option>
                <option id="services" value="services">Services</option>
                <option id="artisants" value="artisants">Artisants</option>
                <option id="transports" value="transports">Transports</option>
                <option id="locations" value="locations">Locations</option>
                <option id="entreprises" value="entreprises">Entreprises</option>
                <option id="detaillons" value="detaillons">Detaillons</option>
                <option id="grossidtes" value="grossidtes">Grossistes</option>
                <option id="fabriquants" value="fabriquants">Fabriquants</option>
                <option id="import-export" value="import-export">Import-Export</option>
            </select>
        </div>
        <div class="update-profile-input profession-user" id="user_profession_select">
            <span class="profession-user active-updt-prf-span">Profession *</span>
            <select id="profession_user">
                <option value="">Profession</option>
            </select>
        </div>
        <div class="update-profile-input" id="user_ville_select">
            <select id="ville_user">
                <option value="">Ville</option>
                <?php
                $ville_query = $conn->prepare("SELECT * FROM villes");
                $ville_query->execute(); 
                while ($ville_row = $ville_query->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <option value="<?php echo $ville_row['ville'] ?>"><?php echo $ville_row['ville'] ?></option>
                <?php } ?>
            </select>
            <span class="ville-user active-updt-prf-span">ville *</span>
        </div>
        <div class="update-profile-input commune-user" id="user_commune_select">
            <select id="commune_user">
                <option value="">Commune</option>
            </select>
            <span class="commune-user active-updt-prf-span">Commune *</span>
        </div>
        <div class="update-profile-input">
            <input type="text" id="adresse_user" value="<?php echo $row['adresse_user'] ?>">
            <?php if ($row['adresse_user'] == '') { ?>
            <span class="adresse-user">Adresse</span>
            <?php }else{ ?>
            <span class="adresse-user active-updt-prf-span">Adresse</span>
            <?php } ?>
        </div>
        <div class="update-profile-input">
            <input type="text" id="tlph_user" value="<?php echo $row['tlph_user'] ?>">
            <?php if ($row['tlph_user'] == '') { ?>
            <span class="tlph-user">Téléphone</span>
            <?php }else{ ?>
            <span class="tlph-user active-updt-prf-span">Téléphone</span>
            <?php }?>
        </div>
        <div class="update-profile-input">
            <textarea id="description_user"></textarea>
            <span class="description-user">Description</span>
        </div>
    </div>
    <hr>
    <div class="user-localisation-gps">
        <p>Modifier votre localisation gps (optionnelle)</p>
        <button onclick="getUserLocation()">Modifier</button>
        <input type="hidden" id="latitude_user" value="<?php echo $row['latitude_user']?>">
        <input type="hidden" id="longitude_user" value="<?php echo $row['longitude_user']?>">
    </div>
    <div id="user_map"></div>
    <div class="create-publication-bottom-button">
        <div id="loader_update_user_profile" class="button-center"></div>
        <button id="update_profile_button">Enregistrer les modification</button>
    </div>
</div>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBEGrApnjX_7GHcNDtF0LR0pgrwxj5j2Q&callback=inituserMap"></script>
<script>
// inituserMap(<?php echo $row['latitude_user']?>, <?php echo $row['longitude_user']?>);
// function inituserMap(lat, lng) {
//     var map = new google.maps.Map(document.getElementById('user_map'), {
//         center: new google.maps.LatLng(lat, lng),
//         zoom: 14
//     });
//     var marker = new google.maps.Marker({
//         map: map,
//         position: new google.maps.LatLng(lat, lng),
//         icon : {
//             url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png"
//         }
//     });
// }

$('#user_categorie_select option[value="<?php echo $row['categorie_user'] ?>"]').prop('selected',true);
$('.profession-user').load('categorie-user.php?c=<?php echo $row['categorie_user'] ?>');
setTimeout(() => {
    $('#user_profession_select option[value="<?php echo $row['profession_user'] ?>"]').prop('selected',true);
}, 500);

$('#user_ville_select option[value="<?php echo $row['ville_user'] ?>"]').prop('selected',true);
$('.commune-user').load('commune-user.php?v=<?php echo $row['ville_user'] ?>');
setTimeout(() => {
    $('#user_commune_select option[value="<?php echo $row['commune_user'] ?>"]').prop('selected',true);
}, 500);
</script>