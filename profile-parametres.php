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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css-js/style.css">
    <link rel="stylesheet" href="./css-js/profile-parametres.css">
    <link href="./css-js/fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fugaz One">
    <title>Paramètres de profile</title>
</head>
<body>
    <?php include './navbar.php';?>
    <div class="clear"></div>
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
    </div>
    <div class="parametres-profile-right">
        <div class="parametres-profile-right-top">
            <div id="cancel_parametres_profile_right">
                <i class="fas fa-arrow-left"></i>
            </div>
            <h4>Modifier les informations de profile!</h4>
        </div>
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
    <div id="loader" class="center"></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="./css-js/main.js"></script>
    <script>
        var $pushState = 0;
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

        $(window).on('load',function(){
            if (history.state === 'parametres') {
                $('[class^="parametres-profile-button"]').removeClass('active-parametres-profile-button');
                $('#display_user_informations').addClass('active-parametres-profile-button');
                $.ajax({
                    url: 'load-profile-parametres.php',
                    beforeSend: function(){
                        $(".parametres-prfile-right-container").empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        history.pushState('parametres','', '/projet/profile-parametres.php?parametres');
                        if (windowWidth < 768) {
                            $('.parametres-profile-right').css('transform','translateX(0)');
                            $('.parametres-prfile-right-container').append(response);
                        }
                        else{
                            $('.parametres-prfile-right-container').append(response);
                        }
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
                        history.pushState('saved','', '/projet/profile-parametres.php?publication-enregistrees');
                        if (windowWidth < 768) {
                            $('.parametres-profile-right').css('transform','translateX(0)');
                            $('.parametres-prfile-right-container').append(response);
                        }
                        else{
                            $('.parametres-prfile-right-container').append(response);
                        }
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
                        history.pushState('hided','', '/projet/profile-parametres.php?publication-masuqees');
                        if (windowWidth < 768) {
                            $('.parametres-profile-right').css('transform','translateX(0)');
                            $('.parametres-prfile-right-container').append(response);
                        }
                        else{
                            $('.parametres-prfile-right-container').append(response);
                        }
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
            }
        })

        $(window).on('popstate',function(){
            if (history.state === 'parametres') {
                $('[class^="parametres-profile-button"]').removeClass('active-parametres-profile-button');
                $('#display_user_informations').addClass('active-parametres-profile-button');
                $.ajax({
                    url: 'load-profile-parametres.php',
                    beforeSend: function(){
                        $(".parametres-prfile-right-container").empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        history.pushState('parametres','', '/projet/profile-parametres.php?parametres');
                        if (windowWidth < 768) {
                            $('.parametres-profile-right').css('transform','translateX(0)');
                            $('.parametres-prfile-right-container').append(response);
                        }
                        else{
                            $('.parametres-prfile-right-container').append(response);
                        }
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
                        history.pushState('saved','', '/projet/profile-parametres.php?publication-enregistrees');
                        if (windowWidth < 768) {
                            $('.parametres-profile-right').css('transform','translateX(0)');
                            $('.parametres-prfile-right-container').append(response);
                        }
                        else{
                            $('.parametres-prfile-right-container').append(response);
                        }
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
                        history.pushState('hided','', '/projet/profile-parametres.php?publication-masuqees');
                        if (windowWidth < 768) {
                            $('.parametres-profile-right').css('transform','translateX(0)');
                            $('.parametres-prfile-right-container').append(response);
                        }
                        else{
                            $('.parametres-prfile-right-container').append(response);
                        }
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
            }
        })

        if (windowWidth < 768) {
            $('[class^="parametres-profile-button"]').removeClass('active-parametres-profile-button');
        }

        $('#cancel_parametres_profile_right').click(function(){
            $('.parametres-profile-right').css('transform','');
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
                    history.pushState('parametres','', '/projet/profile-parametres.php?parametres');
                    if (windowWidth < 768) {
                        $('.parametres-profile-right').css('transform','translateX(0)');
                        $('.parametres-prfile-right-container').append(response);
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
                    history.pushState('saved','', '/projet/profile-parametres.php?publication-enregistrees');
                    if (windowWidth < 768) {
                        $('.parametres-profile-right').css('transform','translateX(0)');
                        $('.parametres-prfile-right-container').append(response);
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
                    history.pushState('hided','', '/projet/profile-parametres.php?publication-masuqees');
                    if (windowWidth < 768) {
                        $('.parametres-profile-right').css('transform','translateX(0)');
                        $('.parametres-prfile-right-container').append(response);
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

        $(document).on('click','#update_profile_button',function(){
            var nomUser = $('#nom_user').val();
            var nomEntrpUser = $('#nom_entrp_user').val();
            var villeUser = $('#ville_user').val();
            var commune_user = $('#commune_user').val();
            var adresseUser = $('#adresse_user').val();
            var tlphUser = $('#tlph_user').val();
            var dscrpUser = $('#dscrp_user').val();
            if (nomUser == '') {
                $('#nom_user').css('border','2px solid red');
            }
            else if(nomEntrpUser == ''){
                $('#nom_user').css('border','');
                $('#nom_entrp_user').css('border','2px solid red');
            }
            else{
                $('#nom_entrp_user').css('border','');
                var fd = new FormData();
                fd.append('nom_user',nomUser);
                fd.append('nom_entrp_user',nomEntrpUser);
                fd.append('ville_user',villeUser);
                fd.append('commune_user',commune_user);
                fd.append('adresse_user',adresseUser);
                fd.append('tlph_user',tlphUser);
                fd.append('dscrp_user',dscrpUser);
                $.ajax({
                    url: 'update-profile-informations.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $(".update-profile-informations").css('opacity','0.5');
                        $("#loader_load").show();
                    },
                    success: function(response){
                        if(response != 0){
                            $('.pp-message-alert').css('transform','translateY(0)');
                        }
                    },
                    complete: function(){
                        $("#loader_load").hide();
                        $(".update-profile-informations").css('opacity','');
                        setTimeout(() => {
                            $('.pp-message-alert').css('transform','');
                        }, 4000);
                    }
                });
            }
        })

        // remove hided publications
        $(document).on('click','[id^="remove_hided_pub_button_"]',function(){
            id = $(this).attr("id").split("_")[4];
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
            id = $(this).attr("id").split("_")[4];
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
        
        <?php if (isset($_SESSION['user'])) { ?>
        var uid = <?php echo $id_user; ?>;
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