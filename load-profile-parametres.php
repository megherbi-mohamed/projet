<?php 
session_start();
include_once './bdd/connexion.php';
if (isset($_SESSION['user'])) {
    $cnx_user_query = $conn->prepare("SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['user']);
    $cnx_user_query->execute();
    $row = $cnx_user_query->fetch(PDO::FETCH_ASSOC);
    $id_user = $row['id_user'];
}
?>
<div class="update-profile-informations">
    <h3>Modifier les informations de profile!</h3>
    <div class="update-profile-informations-top">
        <div>
            <input type="text" id="nom_user" value="<?php echo $row['nom_user'] ?>">
            <span class="nom-user active-updt-prf-span">Nom *</span>
        </div>
        <div>
            <input type="text" id="nom_entrp_user" value="<?php echo $row['nom_entrp_user'] ?>">
            <span class="nom-user active-updt-prf-span">Nom d'entreprise *</span>
        </div>
        <div>
            <select id="ville_user">
                <option value="<?php echo $row['ville_user'] ?>"><?php echo $row['ville'] ?></option>
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
        <div class="commune-user">
            <select id="commune_user">
                <option value="<?php echo $row['commune_user'] ?>"><?php echo $row['commune'] ?></option>
            </select>
            <span class="commune-user active-updt-prf-span">Commune *</span>
        </div>
        <div>
            <input type="text" id="adresse_user" value="<?php echo $row['adresse_user'] ?>">
            <?php if ($row['adresse_user'] == '') { ?>
            <span class="adresse-user">Adresse</span>
            <?php }else{ ?>
            <span class="adresse-user active-updt-prf-span">Adresse</span>
            <?php } ?>
        </div>
        <!-- <div>
            <input type="text" id="email_user" value="<?php echo $row['email_user'] ?>">
            <?php if ($row['email_user'] == '') { ?>
            <span class="email-user">Email</span>
            <?php }else{ ?>
            <span class="email-user active-updt-prf-span">Email</span>
            <?php } ?>
        </div> -->
        <div>
            <input type="text" id="tlph_user" value="<?php echo $row['tlph_user'] ?>">
            <?php if ($row['tlph_user'] == '') { ?>
            <span class="tlph-user">Téléphone</span>
            <?php }else{ ?>
            <span class="tlph-user active-updt-prf-span">Téléphone</span>
            <?php }?>
        </div>
        <div>
            <textarea id="dscrp_user"></textarea>
            <span class="dscrp-user">Description</span>
        </div>
    </div>
    <hr>
    <div class="update-profile-informations-bottom">
        <h4>Modifier la position de profile</h4>
        <input type="hidden" id="latitude_user" value="<?php echo $row['latitude_user'] ?>">
        <input type="hidden" id="longitude_user" value="<?php echo $row['longitude_user'] ?>">
        <button id="update_user_position">Modifier la position</button>
        <div id="profile_map"></div>
        <!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBEGrApnjX_7GHcNDtF0LR0pgrwxj5j2Q&callback=inituserMap"></script> -->
        <script>
            var latitudeuser = document.querySelector('#latitude_user');
            var longitudeuser = document.querySelector('#longitude_user');
            function inituserMap() {
                var map = new google.maps.Map(document.getElementById('profile_map'), {
                    center: new google.maps.LatLng(latitudeuser.value, longitudeuser.value),
                    zoom: 14
                });
                var marker = new google.maps.Marker({
                    map: map,
                    position: new google.maps.LatLng(latitudeuser.value, longitudeuser.value),
                    icon : {
                        url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png"
                    }
                });
            }
            var villeuser = document.querySelector('#ville_user');
            villeuser.addEventListener('change', function (e) {
                if (e.target.value !== '') {
                    var ville = e.target.value;
                    $('.commune-user').load('commune-profile.php?v='+ville);
                }
            })
        </script>
    </div>
    <button id="update_profile_button">Enregistrer les modification</button>
</div>