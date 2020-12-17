<?php 
session_start();
include_once './bdd/connexion.php';
if (isset($_SESSION['user'])) {
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
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/projet/" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css-js/style.css">
    <link rel="stylesheet" href="css-js/profile-parametres.css">
    <link href="css-js/fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fugaz One">
    <title>Paramètres de profile</title>
</head>
<body>
    <?php include './navbar.php';?>
    <div class="clear"></div>
    <div class="profile-parametres-responsive">
        <div class="profile-parametres-responsive-container">
            <div class="show-hide-menu" id="show_hide_menu">
                <i class="fas fa-bars"></i>
            </div>
            <div class="logo-name">
                <h4>Nhannik</h4>
            </div>
            <div id="display_pp_manager">
                <i class="fas fa-cog"></i>
            </div>
            <div class="show-search-bar-rsp" id="show_search_bar_rsp">
                <i class="fas fa-search"></i>
            </div>
        </div>
    </div>
    <div class="parametres-profile-left">
        <h2>Paramètres de profile</h2>
        <hr>
        <div class="parametres-profile">
            <div class="parametres-profile-button active-parametres-profile-button" id="display_user_informations">
                <div>
                    <i class="fas fa-cog"></i>
                </div>
                <p>Modifier vos informations</p>
            </div>
        </div>
        <div class="parametres-profile">
            <div class="parametres-profile-button" id="display_hided_publications">
                <div>
                    <i class="fas fa-eye-slash"></i>
                </div>
                <p>Publications masquées</p>
            </div>
        </div>
        <div class="parametres-profile">
            <div class="parametres-profile-button" id="display_saved_publications">
                <div>
                    <i class="fas fa-bookmark"></i>
                </div>
                <p>Publications enregistrées</p>
            </div>
        </div>
        <div class="parametres-profile">
            <div class="parametres-profile-button" id="display_all_notifications">
                <div>
                    <i class="fas fa-bell"></i>
                </div>
                <p>Notifications</p>
            </div>
        </div>
        <div class="parametres-profile">
            <div class="parametres-profile-button" id="display_all_followers">
                <div>
                    <i class="fas fa-users"></i>
                </div>
                <p>Abonnes</p>
            </div>
        </div>
    </div>
    <div class="parametres-profile-right">
        <div class="parametres-prfile-right-container">
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
        </div>
        <div id="loader_load" class="center"></div>
    </div>
    <div class="pp-message-alert">
        <p>L'annence a été bien renouvelée !</p>
        <div class="cancel-alert-message">
            <i class="fas fa-times"></i>
        </div>
    </div>
    <div class="abonne-user" id="disabonne_user">
        <div class="abonne-user-container" id="disabonne_user_container">
            <div class="abonne-user-top">
                <h4></h4>
                <div class="cancel-abonne-user" id="cancel_disabonne_user">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="abonne-user-middle">
                <p></p>
                <input type="hidden" id="id_user_abn">
                <input type="hidden" id="user_tail">
            </div>
            <div class="abonne-user-bottom">
                <div></div>
                <div></div>
                <button id="cancel_disabonne_user_button">Annuler</button>
                <button id="disabonne_user_button">Disbonner</button>
            </div>
        </div>
        <div id="loader_disabn_user" class="center"></div>
    </div>
    <div id="loader" class="center"></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="css-js/main.js"></script>
    <script>
        document.onreadystatechange = function() { 
            if (document.readyState !== "complete") { 
                document.querySelector("body").style.visibility = "hidden"; 
                document.querySelector("#loader").style.visibility = "visible"; 
            } 
            else { 
                document.querySelector("#loader").style.display = "none"; 
                document.querySelector("body").style.visibility = "visible"; 
            } 
        };

        var action = '<?php echo $_GET['act'] ?>';
        
        $(window).on('load',function(){
            if (history.state === 'parametres' || action === 'parametres') {
                $('[class^="parametres-profile-button"]').removeClass('active-parametres-profile-button');
                $('#display_user_informations').addClass('active-parametres-profile-button');
                $.ajax({
                    url: 'load-profile-parametres.php',
                    beforeSend: function(){
                        $(".parametres-prfile-right-container").empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        history.replaceState('parametres','', '/projet/profile-parametres/parametres');
                        $('.parametres-prfile-right-container').append(response);
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
            }
            if (history.state === 'saved') {
                $('[class^="parametres-profile-button"]').removeClass('active-parametres-profile-button');
                $('#display_saved_publications').addClass('active-parametres-profile-button');
                $.ajax({
                    url: 'load-saved-publications.php',
                    beforeSend: function(){
                        $(".parametres-prfile-right-container").empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        history.replaceState('saved','', '/projet/profile-parametres/publication-enregistrees');
                        $('.parametres-prfile-right-container').append(response);
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
            }
            if (history.state === 'hided') {
                $('[class^="parametres-profile-button"]').removeClass('active-parametres-profile-button');
                $('#display_hided_publications').addClass('active-parametres-profile-button');
                $.ajax({
                    url: 'load-hided-publications.php',
                    beforeSend: function(){
                        $(".parametres-prfile-right-container").empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        history.replaceState('hided','', '/projet/profile-parametres/publication-masuqees');
                        $('.parametres-prfile-right-container').append(response);
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
            }
            if (history.state === 'notification' || action === 'notifications') {
                $('[class^="parametres-profile-button"]').removeClass('active-parametres-profile-button');
                $('#display_all_notifications').addClass('active-parametres-profile-button');
                $.ajax({
                    url: 'load-all-notifications.php',
                    beforeSend: function(){
                        $(".parametres-prfile-right-container").empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        history.replaceState('notification','', '/projet/profile-parametres/notifications');
                        $('.parametres-prfile-right-container').append(response);
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
            }
            if (history.state === 'abonne') {
                $('[class^="parametres-profile-button"]').removeClass('active-parametres-profile-button');
                $('#display_all_followers').addClass('active-parametres-profile-button');
                $.ajax({
                    url: 'load-all-followers.php',
                    beforeSend: function(){
                        $(".parametres-prfile-right-container").empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        history.replaceState('abonne','', '/projet/profile-parametres/abonnes');
                        $('.parametres-prfile-right-container').append(response);
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
            }
        })

        $(window).on('popstate',function(){
            if (history.state === 'parametres' || history.state === null) {
                $('[class^="parametres-profile-button"]').removeClass('active-parametres-profile-button');
                $('#display_user_informations').addClass('active-parametres-profile-button');
                $.ajax({
                    url: 'load-profile-parametres.php',
                    beforeSend: function(){
                        $(".parametres-prfile-right-container").empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        $('.parametres-prfile-right-container').append(response);
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
            }
            if (history.state === 'saved') {
                $('[class^="parametres-profile-button"]').removeClass('active-parametres-profile-button');
                $('#display_saved_publications').addClass('active-parametres-profile-button');
                $.ajax({
                    url: 'load-saved-publications.php',
                    beforeSend: function(){
                        $(".parametres-prfile-right-container").empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        $('.parametres-prfile-right-container').append(response);
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
            }
            if (history.state === 'hided') {
                $('[class^="parametres-profile-button"]').removeClass('active-parametres-profile-button');
                $('#display_hided_publications').addClass('active-parametres-profile-button');
                $.ajax({
                    url: 'load-hided-publications.php',
                    beforeSend: function(){
                        $(".parametres-prfile-right-container").empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        $('.parametres-prfile-right-container').append(response);
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
            }
            if (history.state === 'notification') {
                $('[class^="parametres-profile-button"]').removeClass('active-parametres-profile-button');
                $('#display_all_notifications').addClass('active-parametres-profile-button');
                $.ajax({
                    url: 'load-all-notifications.php',
                    beforeSend: function(){
                        $(".parametres-prfile-right-container").empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        $('.parametres-prfile-right-container').append(response);
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
            }
            if (history.state === 'abonne') {
                $('[class^="parametres-profile-button"]').removeClass('active-parametres-profile-button');
                $('#display_all_followers').addClass('active-parametres-profile-button');
                $.ajax({
                    url: 'load-all-followers.php',
                    beforeSend: function(){
                        $(".parametres-prfile-right-container").empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        $('.parametres-prfile-right-container').append(response);
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
            }
        })

        // display profile informations
        $(document).on('click',"#display_user_informations",function() {
            $('[class^="parametres-profile-button"]').removeClass('active-parametres-profile-button');
            $(this).addClass('active-parametres-profile-button');
            $.ajax({
                url: 'load-profile-parametres.php',
                beforeSend: function(){
                    $(".parametres-prfile-right-container").empty();
                    $("#loader_load").show();
                },
                success: function(response){
                    console.log(response);
                    history.pushState('parametres','', '/projet/profile-parametres/parametres');
                    if (windowWidth < 768) {
                        $('.parametres-profile-left').css('transform','');
                        setTimeout(() => {
                            $('.parametres-prfile-right-container').append(response);
                        }, 400);
                    }
                    else{
                        $('.parametres-prfile-right-container').append(response);
                    }
                },
                complete: function(response){
                    $("#loader_load").hide();
                }
            });
        });

        // display saved publications
        $(document).on('click',"#display_saved_publications",function() {
            $('[class^="parametres-profile-button"]').removeClass('active-parametres-profile-button');
            $(this).addClass('active-parametres-profile-button');
            $.ajax({
                url: 'load-saved-publications.php',
                beforeSend: function(){
                    $(".parametres-prfile-right-container").empty();
                    $("#loader_load").show();
                },
                success: function(response){
                    history.pushState('saved','', '/projet/profile-parametres/publication-enregistrees');
                    if (windowWidth < 768) {
                        $('.parametres-profile-left').css('transform','');
                        setTimeout(() => {
                            $('.parametres-prfile-right-container').append(response);
                        }, 400);
                    }
                    else{
                        $('.parametres-prfile-right-container').append(response);
                    }
                },
                complete: function(response){
                    $("#loader_load").hide();
                }
            });
        });

        // display user hided publications
        $(document).on('click',"#display_hided_publications",function() {
            $('[class^="parametres-profile-button"]').removeClass('active-parametres-profile-button');
            $(this).addClass('active-parametres-profile-button');
            $.ajax({
                url: 'load-hided-publications.php',
                beforeSend: function(){
                    $(".parametres-prfile-right-container").empty();
                    $("#loader_load").show();
                },
                success: function(response){
                    history.pushState('hided','', '/projet/profile-parametres/publication-masuqees');
                    if (windowWidth < 768) {
                        $('.parametres-profile-left').css('transform','');
                        setTimeout(() => {
                            $('.parametres-prfile-right-container').append(response);
                        }, 400);
                    }
                    else{
                        $('.parametres-prfile-right-container').append(response);
                    }
                },
                complete: function(response){
                    $("#loader_load").hide();
                }
            });
        });

        // display all notifications
        $(document).on('click',"#display_all_notifications",function() {
            $('[class^="parametres-profile-button"]').removeClass('active-parametres-profile-button');
            $(this).addClass('active-parametres-profile-button');
            $.ajax({
                url: 'load-all-notifications.php',
                beforeSend: function(){
                    $(".parametres-prfile-right-container").empty();
                    $("#loader_load").show();
                },
                success: function(response){
                    history.pushState('notification','', '/projet/profile-parametres/notifications');
                    if (windowWidth < 768) {
                        $('.parametres-profile-left').css('transform','');
                        setTimeout(() => {
                            $('.parametres-prfile-right-container').append(response);
                        }, 400);
                    }
                    else{
                        $('.parametres-prfile-right-container').append(response);
                    }
                },
                complete: function(response){
                    $("#loader_load").hide();
                }
            });
        });

        // display user hided publications
        $(document).on('click',"#display_all_followers",function() {
            $('[class^="parametres-profile-button"]').removeClass('active-parametres-profile-button');
            $(this).addClass('active-parametres-profile-button');
            $.ajax({
                url: 'load-all-followers.php',
                beforeSend: function(){
                    $(".parametres-prfile-right-container").empty();
                    $("#loader_load").show();
                },
                success: function(response){
                    history.pushState('abonne','', '/projet/profile-parametres/abonnes');
                    if (windowWidth < 768) {
                        $('.parametres-profile-left').css('transform','');
                        setTimeout(() => {
                            $('.parametres-prfile-right-container').append(response);
                        }, 400);
                    }
                    else{
                        $('.parametres-prfile-right-container').append(response);
                    }
                },
                complete: function(response){
                    $("#loader_load").hide();
                }
            });
        });

        // update profile
        $(document).on('focus','.update-profile-informations-top input',function(){
            var id = $(this).attr('id');
            if (id == 'adresse_user') {
                $('.adresse-user').addClass('active-updt-prf-span');
            }
            if (id == 'email_user') {
                $('.email-user').addClass('active-updt-prf-span');
            }
            if (id == 'tlph_user') {
                $('.tlph-user').addClass('active-updt-prf-span');
            }
        })

        $(document).on('focus','.update-profile-informations-top textarea',function(){
            var id = $(this).attr('id');
            if (id == 'description_user') {
                $(".description-user").attr('class', 'active-updt-prf-span');
            }
        })

        // select categorie user
        $(document).on('change','#categorie_user',function() {
            var categorie  = $(this).val();
            if (categorie !== '') {
                $('.profession-user').load('categorie-user.php?c='+categorie);
            }
        })

        // $(document).on('change','#sous_categorie_user',function() {
        //     var profession = $(this).val();
        //     if (profession == 'autre') {
        //         $('.sous-categorie-user').hide(); 
        //         $('.sous-categorie-autre').show(); 
        //     }
        // })

        // select user ville and commune
        $(document).on('change','#ville_user',function() {
            var ville  = $(this).val();
            if (ville !== '') {
                $('.commune-user').load('commune-user.php?v='+ville);
            }
        })

        // get user location
        function getUserLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(getUserPosition, showError);
            } else { 
                $('.user-localisation-gps p').text("La geolocation ne support pas cette navigateur.");
                $('.update-user-localisation-gps p').text("La geolocation ne support pas cette navigateur.");
            }
        }

        function getUserPosition(position) {
            var latitudeUser = position.coords.latitude;
            var longitudeUser = position.coords.longitude;
            $('#latitude_user').val(latitudeUser);
            $('#longitude_user').val(longitudeUser);
            $('.user-localisation-gps p').text('La position a été bien modifiée');
            $('.user-localisation-gps button').text('modifiée');
        }

        $(document).on('click','#update_profile_button',function(){
            var nomUser = $('#nom_user').val();
            var nomEntrpUser = $('#nom_entrp_user').val();
            var categorieUser = $('#categorie_user').val();
            var professionUser = $('#profession_user').val();
            var villeUser = $('#ville_user').val();
            var communeUser = $('#commune_user').val();
            var adresseUser = $('#adresse_user').val();
            var tlphUser = $('#tlph_user').val();
            var descriptionUser = $('#description_user').val();
            var latitudeUser = $('#latitude_user').val();
            var longitudeUser = $('#longitude_user').val();
            if (nomUser == '') {
                $('#nom_user').css('border','2px solid red');
            }
            else if(nomEntrpUser == ''){
                $('#nom_user').css('border','');
                $('#nom_entrp_user').css('border','2px solid red');
            }
            else if(nomEntrpUser == ''){
                $('#nom_user').css('border','');
                $('#nom_entrp_user').css('border','2px solid red');
            }
            else if(categorieUser == ''){
                $('#nom_user').css('border','');
                $('#nom_entrp_user').css('border','');
                $('#categorie_user').css('border','2px solid red');
            }
            else if(professionUser == ''){
                $('#nom_user').css('border','');
                $('#nom_entrp_user').css('border','');
                $('#categorie_user').css('border','');
                $('#profession_user').css('border','2px solid red');
            }
            else if(villeUser == ''){
                $('#nom_user').css('border','');
                $('#nom_entrp_user').css('border','');
                $('#categorie_user').css('border','');
                $('#profession_user').css('border','2');
                $('#ville_user').css('border','2px solid red');
            }
            else if(communeUser == ''){
                $('#nom_user').css('border','');
                $('#nom_entrp_user').css('border','');
                $('#categorie_user').css('border','');
                $('#profession_user').css('border','2');
                $('#ville_user').css('border','');
                $('#commune_user').css('border','2px solid red');
            }
            else if(tlphUser == ''){
                $('#nom_user').css('border','');
                $('#nom_entrp_user').css('border','');
                $('#categorie_user').css('border','');
                $('#profession_user').css('border','2');
                $('#ville_user').css('border','');
                $('#commune_user').css('border','');
                $('#tlph_user').css('border','2px solid red');
            }
            else{
                $('#tlph_user').css('border','');
                var fd = new FormData();
                fd.append('nom_user',nomUser);
                fd.append('nom_entrp_user',nomEntrpUser);
                fd.append('categorie_user',categorieUser);
                fd.append('profession_user',professionUser);
                fd.append('ville_user',villeUser);
                fd.append('commune_user',communeUser);
                fd.append('adresse_user',adresseUser);
                fd.append('tlph_user',tlphUser);
                fd.append('description_user',descriptionUser);
                fd.append('latitude_user',latitudeUser);
                fd.append('longitude_user',longitudeUser);
                $.ajax({
                    url: 'update-profile-informations.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $("#loader_update_user_profile").show();
                    },
                    success: function(response){
                        console.log(response);
                        if(response != 0){
                            $.ajax({
                                url: 'load-profile-parametres.php',
                                beforeSend: function(){
                                    $(".parametres-prfile-right-container").empty();
                                    $("#loader_load").show();
                                },
                                success: function(response){
                                    $('.parametres-prfile-right-container').append(response);
                                },
                                complete: function(response){
                                    $("#loader_load").hide();
                                }
                            });
                            // $('.pp-message-alert').css('transform','translateY(0)');
                        }
                    },
                    complete: function(){
                        $("#loader_update_user_profile").hide();
                        // setTimeout(() => {
                        //     $('.pp-message-alert').css('transform','');
                        // }, 4000);
                    }
                });
            }
        })

        // remove hided publications
        $(document).on('click','[id^="remove_hided_pub_button_"]',function(){
            var id = $(this).attr("id").split("_")[4];
            var fd = new FormData();
            var idPub = $('#id_publication_hide_'+id).val();
            fd.append('id_pub',idPub);
            $.ajax({
                url: 'remove-hided-publications.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".parametres-prfile-right-container").css('opacity','0.5');
                    $("#loader_load").show();
                },
                success: function(response){
                    if(response != 0){
                        $('#user_publication_'+id).remove();
                    }
                },
                complete: function(){
                    $(".parametres-prfile-right-container").css('opacity','');
                    $("#loader_load").hide();
                }
            });
        });

        // remove saved publications
        $(document).on('click','[id^="remove_saved_pub_button_"]',function(){
            var id = $(this).attr("id").split("_")[4];
            var fd = new FormData();
            var idPub = $('#id_publication_save_'+id).val();
            fd.append('id_pub',idPub);
            $.ajax({
                url: 'remove-saved-publications.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".parametres-prfile-right-container").css('opacity','0.5');
                    $("#loader_load").show();
                },
                success: function(response){
                    console.log(response);
                    if(response != 0){
                        $('#user_publication_'+id).remove();
                    }
                },
                complete: function(){
                    $(".parametres-prfile-right-container").css('opacity','');
                    $("#loader_load").hide();
                }
            });
        });

        $(document).on('click','.cancel-alert-message',function(){
            $('.pp-message-alert').css('transform','');
        })

        function updateReceverMessage(userId,senderId){
            var fd = new FormData();
            fd.append('id_user',userId);
            fd.append('id_sender',senderId);
            $.ajax({
                url: 'update-messagerie-recever.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response != 0){

                    }
                }
            });
        }

        // disfollow user
        $(document).on('click','[id^="disfollow_button_"]',function(e) {
            var id = $(this).attr("id").split("_")[2];
            var idUser = $('#id_user_abn_'+id).val();
            var nomUser = $('#nom_user_abn_'+id).val();
            $('#user_tail').val(id);
            $('#id_user_abn').val(idUser);
            $('.abonne-user-top h4').text('Disabonner a '+nomUser);
            $('.abonne-user-middle p').text('Voulez vous disabonner a '+nomUser);
            $("body").addClass('body-after');
            if (windowWidth > 768) {
                $("#disabonne_user").show();
            }else{
                $("#disabonne_user").css('transform','translateY(0)');
            }
        })

        $('#cancel_disabonne_user').click(function(e){
            e.stopPropagation();
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $("#disabonne_user").hide();
            }else{
                $("#disabonne_user").css('transform','');
            }
        });

        $('#cancel_disabonne_user_button').click(function(e){
            e.stopPropagation();
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $("#disabonne_user").hide();
            }else{
                $("#disabonne_user").css('transform','');
            }
        });

        $('#disabonne_user').click(function(e){
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $("#disabonne_user").hide();
            }else{
                $("#disabonne_user").css('transform','');
            }
        });

        $('#disabonne_user_container').click(function(e){
            e.stopPropagation();
        });

        $('#disabonne_user_button').click(function(e){
            var id = $('#user_tail').val();
            var fd = new FormData();
            var idUser = $('#id_user_abn').val();
            fd.append('id_user',idUser);
            $.ajax({
                url: 'disabonne-user.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $('#disabonne_user').css('opacity','0.5');
                    $("#loader_disabn_user").show();
                },
                success: function(response){
                    if(response != 0){
                        $("#user_follower_"+id).remove();
                    }
                },
                complete: function(){
                    $('#disabonne_user').css('opacity','');
                    $("#loader_disabn_user").hide();
                    $("body").removeClass('body-after');
                    if (windowWidth > 768) {
                        $("#disabonne_user").hide();
                    }else{
                        $("#disabonne_user").css('transform','');
                    }
                }
            });
        });

        $('#display_pp_manager').click(function(e){
            e.stopPropagation();
            setTimeout(() => {
                $('body').addClass('body-after');
            }, 0);
            $('.parametres-profile-left').css('transform','translateX(0)');
        })

        // show user profile
        $(document).on('click','[id^="show_profile_button_"]',function(e) {
            var id = $(this).attr("id").split("_")[3];
            var idUser = $('#id_user_abn_'+id).val();
            window.location = 'utilisateur/'+idUser;
        })

        $('#search_pp_bar_button').click(function(e){
            console.log('click');
            // e.stopPropagation();
            $('.categorie-professionnel').show();
            $('#categorie_search').focus();
            if (windowWidth > 768) {
                $('.user-list-dropdown').hide();
                $('.user-create-options').hide();
                $('.user-list-messages').hdie();
                $('.user-list-notifications').hide();
            }else{
                $('.user-list-dropdown').css('transform','');
                $('.user-create-options').css('transform','');
                $('.user-list-messages').css('transform','');
                $('.user-list-notifications').css('transform','');
            }
        })
        
        <?php if (isset($_SESSION['user'])) { ?>
        var uid = <?php echo $uid; ?>;
        var websocket_server = 'ws://<?php echo $_SERVER['HTTP_HOST']; ?>:3030?uid='+uid;
        var websocket = false;
        var js_flood = 0;
        var status_websocket = 0;
        $(document).ready(function() {
            start(websocket_server);
        });
        <?php } ?>
    </script>
    <script src="css-js/websocket.js"></script>
</body>
</html>