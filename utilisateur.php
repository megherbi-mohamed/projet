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
else{
    header('Location: inscription-connexion.php');
}
if (isset($_GET['user'])) {
    $get_id = htmlspecialchars($_GET['user']);
    $get_id_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$get_id' OR id_user_1 = '$get_id' OR id_user_2 = '$get_id' 
                                            OR id_user_3 = '$get_id' OR id_user_4 = '$get_id' OR id_user_5 = '$get_id'");
    $get_id_query->execute();
    $get_id_row = $get_id_query->fetch(PDO::FETCH_ASSOC);
    $user_get_query = $conn->prepare("SELECT * FROM utilisateurs WHERE id_user = {$get_id_row['id_user']}");
    $user_get_query->execute();
    if ($user_get_query->rowCount() > 0) {
        $row_g = $user_get_query->fetch(PDO::FETCH_ASSOC);
        $user = $row_g['id_user'];
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
    <link rel="stylesheet" href="css-js/utilisateur.css">
    <link rel="stylesheet" href="css-js/croppie.css">
    <link href="css-js/fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fugaz One">
    <title><?php echo $row_g['nom_user'] ?></title>
</head>
<body>
    <?php include './navbar.php';?>
    <div class="clear"></div>
    <div class="user-profile-container">
        <?php if ($row_g['type_user'] == 'professionnel') { 
            include './professionnel.php';
        }else if ($row_g['type_user'] == 'client'){ 
            include './client.php';
        }?>
        <?php 
        if (isset($_SESSION['user']) && $row['type_user'] == 'professionnel') {
            if ($row['cnx_count'] == 0) {
        ?>
        <input type="hidden" id="pre_update_profile" value="1">
        <?php }else{ ?>
        <input type="hidden" id="pre_update_profile" value="0">
        <?php } ?> 
        <div class="pre-update-profile">
            <div class="pre-update-profile-container">
                <h4>Completer les informations de votre profile</h4>
                <div class="pre-update-profile-left">
                    <div>
                        <span class="pre-nom-user">Nom et prenom *</span>
                        <input type="text" id="pre_nom_user" value="<?php echo $row['nom_user'] ?>" autocomplete="off">
                    </div>
                    <div>
                        <span class="pre-entrp-user">Nom d'entreprise *</span>
                        <input type="text" id="pre_entrp_user" autocomplete="off">
                    </div>
                    <?php if ($row['email_user'] !== '') { ?>
                    <div>
                        <span class="pre-tlph-user">Téléphone *</span>
                        <input type="text" id="pre_tlph_user" autocomplete="off">
                        <input type="hidden" id="pre_email_user" value="<?php echo $row['email_user'] ?>">
                    </div>
                    <?php }else{ ?>
                    <div>
                        <span class="pre-email-user">Email *</span>
                        <input type="text" id="pre_email_user" autocomplete="off">
                        <input type="hidden" id="pre_tlph_user" value="<?php echo $row['tlph_user'] ?>">
                    </div>
                    <?php } ?>
                    <div>
                        <span class="pre-adresse-user">Adresse *</span>
                        <input type="text" id="pre_adresse_user" autocomplete="off">
                    </div>
                    <div>
                        <span class="pre-ville-user">Ville *</span>
                        <input type="text" id="pre_ville_user" autocomplete="off">
                    </div>
                    <div class="pre-categories">
                        <span class="pre-categorie-user">Categorie *</span>
                        <select id="pre_categorie">
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
                    <div class="pre-profession">
                        <span class="pre-profession-user">Profession *</span>
                        <select id="pre_profession">
                            <option value="">Professions</option>
                        </select>
                    </div>
                    <div class="pre-profession-autre">
                        <span class="pre-profession-user">Profession *</span>
                        <input type="text" id="pre_profession" autocomplete="off">
                    </div>
                </div>
                <button id="pre_updt">Enregirer</button>
            </div>
            <div id="loader_load" class="center"></div>
        </div>
        <?php } ?>
    </div>
    <input type="hidden" id="id_user" value="<?php echo $user ?>">
    <?php if (isset($_SESSION['user']) && $_SESSION['user'] !== $_GET['user']) { ?>
    <input type="hidden" id="id_corresponder" value="<?php echo $user ?>">
    <input type="hidden" id="type_msg" value="userUser">
    <input type="hidden" id="msg_cle" value="<?php echo $user.$id_user ?>">
    <button style="display:none" id="send_message_button"></button>
    <?php } ?>  
    <div id="loader" class="center"></div>
    <!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBEGrApnjX_7GHcNDtF0LR0pgrwxj5j2Q&callback=initUserMap"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="./css-js/main.js"></script>
    <script src="./css-js/croppie.js"></script>
    <script>
        document.onreadystatechange = function() { 
            if (document.readyState !== "complete") { 
                document.querySelector("body").style.visibility = "hidden"; 
                document.querySelector("#loader").style.visibility = "visible"; 
            } else { 
                document.querySelector("#loader").style.display = "none"; 
                document.querySelector("body").style.visibility = "visible"; 
            } 
        };

        // add new publications when scroll bottom
        var scrollBottom = 0;         
        $(window).on("scroll", function () {
            if (window.innerHeight + window.pageYOffset >= document.body.scrollHeight) {
                scrollBottom++;
                var fd = new FormData();
                fd.append('offset', scrollBottom);
                var idUser = $('#id_user').val();
                fd.append('id_user', idUser);
                $.ajax({
                    url: 'load-user-publications.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(response){
                        if(response != 0){
                            // console.log(response);
                            $('.user-profile-publications').append(response);
                        }else{
                            // alert('err');
                        }
                    },
                });
            }
        });

        // if ($('#active_notification').val() != 0) {
        //     var actvNtf = $('#active_notification').val();
        //     $('html, body').animate({
        //         scrollTop: $("#active_notification_"+actvNtf).offset().top
        //     }, 1000);
        // }
        
        // document.querySelector('#input_user_checkbox').addEventListener('click',()=>{
        //     document.querySelector("#check_btn").click();
        // })
        
        $("#check_form").submit(function(event){
            event.preventDefault(); 
            var post_url = $(this).attr("action"); 
            var request_method = $(this).attr("method"); 
            var form_data = $(this).serialize(); 
            
            $.ajax({
                url : post_url,
                type: request_method,
                data : form_data
            }).done(function(response){    
            });
        });

        var latitudeUser = document.querySelector('#latitude_user');
        var longitudeUser = document.querySelector('#longitude_user');
        function initUserMap() {
            var map = new google.maps.Map(document.getElementById('user_map'), {
                center: new google.maps.LatLng(latitudeUser.value, longitudeUser.value),
                zoom: 14
            });
            var marker = new google.maps.Marker({
                map: map,
                position: new google.maps.LatLng(latitudeUser.value, longitudeUser.value),
                icon : {
                    url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png"
                }
            });
        }

        $("#update_user_image").click(function(){
            if (windowWidth < 768) {
                $(".user-image-update").css('transform','translateX(0)');
            }
            else{
                $('body').addClass('body-after');
                $(".user-image-update").css('display','initial');
            }
        });

        $("#update_user_couverture").click(function(){
            if (windowWidth < 768) {
                $(".user-couverture-update").css('transform','translateX(0)');
            }
            else{
                $('body').addClass('body-after');
                $(".user-couverture-update").css('display','initial');
            }
        });

        $(".user-image-update").click(function(){
            if (windowWidth < 768) {
                $(".user-image-update").css('transform','');
            }
            else{
                $('body').removeClass('body-after');
                $(".user-image-update").css('display','');
            }
        });

        $(".user-couverture-update").click(function(){
            if (windowWidth < 768) {
                $(".user-couverture-update").css('transform','');
            }
            else{
                $('body').removeClass('body-after');
                $(".user-couverture-update").css('display','');
            }
        });

        $(".user-image-update-container").click(function(e){
            e.stopPropagation();
        });

        $(".user-couverture-update-container").click(function(e){
            e.stopPropagation();
        });

        $("#cancel_user_image_update").click(function(){
            if (windowWidth < 768) {
                $(".user-image-update").css('transform','');
            }
            else{
                $('body').removeClass('body-after');
                $(".user-image-update").css('display','');
            }
        });

        $("#cancel_user_couverture_update").click(function(){
            if (windowWidth < 768) {
                $(".user-couverture-update").css('transform','');
            }
            else{
                $('body').removeClass('body-after');
                $(".user-couverture-update").css('display','');
            }
        });

        $("#cancel_updt_img_button").click(function(){
            if (windowWidth < 768) {
                $(".user-image-update").css('transform','');
            }
            else{
                $('body').removeClass('body-after');
                $(".user-image-update").css('display','');
            }
        });

        $("#cancel_updt_cvrt_button").click(function(){
            if (windowWidth < 768) {
                $(".user-couverture-update").css('transform','');
            }
            else{
                $('body').removeClass('body-after');
                $(".user-couverture-update").css('display','');
            }
        });

        $("#cancel_user_image_update_resp").click(function(){
            $(".user-image-update").css('transform','');
        });

        $("#cancel_user_couverture_update_resp").click(function(){
            $(".user-couverture-update").css('transform','');
        });

        $("#find_image_btn").click(function(){
            $('#upload').click();
        });

        $("#find_couverture_btn").click(function(){
            $('#upload_couverture').click();
        });
        
        $uploadCrop = $('#upload-demo').croppie({
            enableExif: true,
            viewport: {
                width: 200,
                height: 200,
                type: 'square'
            },
            boundary: {
                width: 250,
                height: 250
            }
        });

        $uploadCropCouverture = $('#upload-demo-couverture').croppie({
            enableExif: true,
            viewport: {
                width: 300,
                height: 180,
                type: 'square'
            },
            boundary: {
                width: 320,
                height: 200
            }
        });

        $('#upload').on('change', function () { 
            var reader = new FileReader();
            reader.onload = function (e) {
                $uploadCrop.croppie('bind', {
                    url: e.target.result
                });
            }
            reader.readAsDataURL(this.files[0]);
        });

        $('#upload_couverture').on('change', function () { 
            var reader = new FileReader();
            reader.onload = function (e) {
                $uploadCropCouverture.croppie('bind', {
                    url: e.target.result
                });
            }
            reader.readAsDataURL(this.files[0]);
        });

        $('.upload-result').on('click', function (ev) {
            $uploadCrop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (resp) {
                $.ajax({
                    url: "update-user-image.php",
                    type: "POST",
                    data: {"image":resp},
                    beforeSend: function(){
                        $('.user-image-update-container').css('opacity','0.5');
                        $("#loader_updt_img").show();
                    },
                    success: function (response) {
                        if (response != 0) {
                            if (windowWidth > 768) {
                                $('.user-picture img').replaceWith("<img id='user_img' src='"+resp+"' alt='logo'>");
                                $('.profile-image-desktop img').replaceWith("<img src='"+resp+"' alt='logo'>");
                                $('#profile_button img').replaceWith("<img id='profile_button' src='"+resp+"' alt='logo'>");
                                $('body').removeClass('body-after');
                                $(".user-image-update").css('display',''); 
                            }
                            else{
                                $(".user-image-update").css('transform','');
                                setTimeout(() => {
                                    $('.user-picture img').replaceWith("<img id='user_img' src='"+resp+"' alt='logo'>");
                                    $('.profile-image-desktop img').replaceWith("<img src='"+resp+"' alt='logo'>");
                                    $('#profile_button img').replaceWith("<img id='profile_button' src='"+resp+"' alt='logo'>"); 
                                }, 400);
                            }
                        }
                    },
                    complete: function(){
                        $('.user-image-update-container').css('opacity','');
                        $("#loader_updt_img").hide();
                    }
                });
            });
        });

        $('.upload-result-couverture').on('click', function (ev) {
            $uploadCropCouverture.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (resp) {
                $.ajax({
                    url: "update-user-couverture.php",
                    type: "POST",
                    data: {"image":resp},
                    beforeSend: function(){
                        $('.user-couverture-update-container').css('opacity','0.5');
                        $("#loader_updt_cvrt").show();
                    },
                    success: function (data) {
                        if (response != 0) {
                            if (windowWidth > 768) {
                                $('#user_couverture').replaceWith("<img id='user_couverture' src='"+resp+"' alt='couverture'>");
                                $('body').removeClass('body-after');
                                $(".user-couverture-update").css('display','');
                            }
                            else{
                                $(".user-couverture-update").css('transform','');
                                setTimeout(() => {
                                    $('#user_couverture').replaceWith("<img id='user_couverture' src='"+resp+"' alt='couverture'>");
                                    $('body').removeClass('body-after');
                                }, 400);
                            }
                        }
                    },
                    complete: function(){
                        $('.user-couverture-update-container').css('opacity','');
                        $("#loader_updt_cvrt").hide();
                    }
                });
            });
        });

        $('.upload-result-couverture-resp').on('click', function (ev) {
            $uploadCropCouverture.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (resp) {
                $.ajax({
                    url: "update-user-couverture.php",
                    type: "POST",
                    data: {"image":resp},
                    beforeSend: function(){
                        $('.user-couverture-update-container').css('opacity','0.5');
                        $("#loader_updt_cvrt").show();
                    },
                    success: function (data) {
                        $(".user-couverture-update").css('transform','');
                        setTimeout(() => {
                            $('#user_couverture').replaceWith("<img id='user_couverture' src='"+resp+"' alt='couverture'>");
                            $('body').removeClass('body-after');
                        }, 400);
                    },
                    complete: function(){
                        $('.user-couverture-update-container').css('opacity','');
                        $("#loader_updt_cvrt").hide();
                    }
                });
            });
        });

        if ($('#pre_update_profile').val() == 1) {
          $('.pre-update-profile').show();
          $('body').addClass('body-after');
        }

        var preCategories = document.querySelector('#pre_categorie');
        preCategories.addEventListener('change', function (e) {
            if (e.target.value !== '') {
                var categorie = e.target.value;
                $('.pre-profession').load('categorie-profile.php?c='+categorie);
            }
        })

        $(document).on('focus','.pre-update-profile-left input',function(){
            var id = $(this).attr('id');
            if (id == 'pre_entrp_user') {
                $('.pre-entrp-user').addClass('pre-updt-active-span');
            }
            if (id == 'pre_email_user') {
                $('.pre-email-user').addClass('pre-updt-active-span');
            }
            if (id == 'pre_tlph_user') {
                $('.pre-tlph-user').addClass('pre-updt-active-span');
            }
            if (id == 'pre_adresse_user') {
                $('.pre-adresse-user').addClass('pre-updt-active-span');
            }
            if (id == 'pre_ville_user') {
                $('.pre-ville-user').addClass('pre-updt-active-span');
            }
        })

        function validateEmail(email) {
            var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
            return re.test(email);
        }
        function validatePhone(phone) {
            var re = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;
            return re.test(phone);
        }

        $('#pre_updt').click(function(event){;
            var nomUser = $('#pre_nom_user').val();
            var nomEntrpUser = $('#pre_entrp_user').val();
            var tlphUser = $('#pre_tlph_user').val();
            var emailUser = $('#pre_email_user').val();
            var adresseUser = $('#pre_adresse_user').val();
            var villeUser = $('#pre_ville_user').val();
            var categorieUser = $('#pre_categorie').val();
            var professionUser = $('.pre-update-profile-left #pre_profession').val();
            if (nomUser == '') {
                $('#pre_nom_user').css("border","2px solid red");
            }
            else if (nomEntrpUser == '') {
                $('#pre_nom_user').css("border","");
                $('#pre_entrp_user').css("border","2px solid red");
            }
            else if (tlphUser == '' || !validatePhone(tlphUser)) {
                $('#pre_nom_user').css("border","");
                $('#pre_entrp_user').css("border","");
                $('#pre_tlph_user').css("border","2px solid red");
            }
            else if (emailUser == '' || !validateEmail(emailUser)) {
                $('#pre_nom_user').css("border","");
                $('#pre_entrp_user').css("border","");
                $('#pre_tlph_user').css("border","");
                $('#pre_email_user').css("border","2px solid red");
            }
            else if (adresseUser == '') {
                $('#pre_nom_user').css("border","");
                $('#pre_entrp_user').css("border","");
                $('#pre_tlph_user').css("border","");
                $('#pre_email_user').css("border","");
                $('#pre_adresse_user').css("border","2px solid red");
            }
            else if (villeUser == '') {
                $('#pre_nom_user').css("border","");
                $('#pre_entrp_user').css("border","");
                $('#pre_tlph_user').css("border","");
                $('#pre_email_user').css("border","");
                $('#pre_adresse_user').css("border","");
                $('#pre_ville_user').css("border","2px solid red");
            }
            else if (categorieUser == '') {
                $('#pre_nom_user').css("border","");
                $('#pre_entrp_user').css("border","");
                $('#pre_tlph_user').css("border","");
                $('#pre_email_user').css("border","");
                $('#pre_adresse_user').css("border","");
                $('#pre_ville_user').css("border","");
                $('#pre_categorie').css("border","2px solid red");
            }
            else if (professionUser == '') {
                $('#pre_nom_user').css("border","");
                $('#pre_entrp_user').css("border","");
                $('#pre_tlph_user').css("border","");
                $('#pre_email_user').css("border","");
                $('#pre_adresse_user').css("border","");
                $('#pre_ville_user').css("border","");
                $('#pre_categorie').css("border","");
                $('.pre-update-profile-left #pre_profession').css("border","2px solid red");
            }
            else if (nomUser != '' && nomEntrpUser != '' && tlphUser != '' &&
                    emailUser != '' && adresseUser != '' && villeUser != '' && 
                    categorieUser != '' && professionUser != '') {
                $('.pre-update-profile-left #pre_profession').css("border","");
                
                var fd = new FormData();
                fd.append('nom_user',nomUser);
                fd.append('nom_entrp_user',nomEntrpUser);
                fd.append('tlph_user',tlphUser);
                fd.append('email_user',emailUser);
                fd.append('adresse_user',adresseUser);
                fd.append('ville_user',villeUser);
                fd.append('categorie_user',categorieUser);
                fd.append('profession_user',professionUser);

                $.ajax({
                    url: 'pre-update-profile.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $("#loader_load").show();
                        $('.pre-update-profile').css('opacity','0.5');
                    },
                    success: function(response){
                        console.log(response);
                        if(response != 0){
                            $('.pre-update-profile').hide();
                            $('body').removeClass('body-after');
                            $('#user_informations').replaceWith(response);
                        }else{
                            alert('err');
                        }
                    },
                    complete: function(){
                        $("#loader_load").hide();
                        $('.pre-update-profile').css('opacity','');
                    }
                });
            }
        })

        var slideClick = 0;
        $('#slide_right').click(function (){
            slideClick++;
            var leftPos = $('.user-profile-middle-content-pub-slide-button').scrollLeft();
            $(".user-profile-middle-content-pub-slide-button").animate({scrollLeft: leftPos + 200}, 500);
            $('#slide_left').show();
        })

        $('#slide_left').click(function (){
            slideClick--;
            var leftPos = $('.user-profile-middle-content-pub-slide-button').scrollLeft();
            $(".user-profile-middle-content-pub-slide-button").animate({scrollLeft: leftPos - 200}, 500);
            if (slideClick == 0) {
                $('#slide_left').hide();
            }
        })

        $(".user-profile-left-content").mouseover(function(){
            $(this).removeClass('hide-scroll-bar');
        })

        $(".user-profile-left-content").mouseout(function(){
            $(this).addClass('hide-scroll-bar');
        })

        // show hided publications
        if (windowWidth > 768) {
            $('#show_hided_publications').click(function(){
                $("body").addClass('body-after');
                $('.show-hided-publications').show();
                $('.show-hided-publications-container').load('hided-publications.php');
            })
            $('.show-hided-publications-container').on('click','#cancel_hided_publications',function(){
                $("body").removeClass('body-after');
                $('.show-hided-publications').hide();
                $('.show-hided-publications-container').empty();
            })
        }else{
            $('#show_hided_publications').click(function(){
                $('.show-hided-publications').css('transform','translateX(0)');
                $('.show-hided-publications-container').load('hided-publications.php');
            })
            $('.show-hided-publications-container').on('click','#cancel_hided_publications_resp',function(){
                $('.show-hided-publications').css('transform','');
                setTimeout(() => {
                    $('.show-hided-publications-container').empty();
                }, 400);
            })
        }

        $('.show-hided-publications').click(function(){
            $("body").removeClass('body-after');
            $('.show-hided-publications').hide();
            $('.show-hided-publications-container').empty();
        })

        $('.show-hided-publications-container').click(function(e){
            e.stopPropagation();
        })

        // remove hided publications
        $('.show-hided-publications-container').on('click','[id^="remove_hided_pub_button_"]',function(){
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
                success: function(response){
                    if(response != 0){
                        $('.show-hided-publications-container').load('hided-publications.php');
                    }
                }
            });
        });

        //utilisateur info
        $(document).on('click',"#follow_button",function(e) {
            $("body").addClass('body-after');
            if (windowWidth > 768) {
                $("#abonne_user").show();
            }else{
                $("#abonne_user").css('transform','translateY(0)');
            }
        })

        $('#ntf_user_btn').click(function(e){
            e.stopPropagation();
            var etat = $(this).find('i').attr('class');
            var etatBtn = $(this).find('i');
            if (etat == 'fas fa-check etat') {
                $('#notifications_user').val("0");
                etatBtn.replaceWith('<i class="fas fa-ban etat"></i>');
            }
            else{
                $('#notifications_user').val("1");
                etatBtn.replaceWith('<i class="fas fa-check etat"></i>');
            }
        })

        $('#cancel_abonne_user').click(function(e){
            e.stopPropagation();
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $("#abonne_user").hide();
            }else{
                $("#abonne_user").css('transform','');
            }
        });

        $('#cancel_abonne_user_button').click(function(e){
            e.stopPropagation();
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $("#abonne_user").hide();
            }else{
                $("#abonne_user").css('transform','');
            }
        });

        $('#abonne_user').click(function(e){
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $("#abonne_user").hide();
            }else{
                $("#abonne_user").css('transform','');
            }
        });

        $('#abonne_user_container').click(function(e){
            e.stopPropagation();
        });

        // $('#abonne_user_button').click(function(e){
        //     var fd = new FormData();
        //     var idUser= $('#id_user').val();
        //     fd.append('id_user',idUser);
        //     var ntfUser = $('#notifications_user').val();
        //     fd.append('notifications_user',ntfUser);
        //     $.ajax({
        //         url: 'abonne-user.php',
        //         type: 'post',
        //         data: fd,
        //         contentType: false,
        //         processData: false,
        //         beforeSend: function(){
        //             $('#abonne_user').css('opacity','0.5');
        //             $("#loader_abn_user").show();
        //         },
        //         success: function(response){
        //             if(response != 0){
        //                 console.log(response);
        //                 $("#follow_button").replaceWith('<div id="disfollow_button"><p>Disabonner</p><i class="fas fa-user-slash"></i></div>');
        //             }
        //         },
        //         complete: function(){
        //             $('#abonne_user').css('opacity','');
        //             $("#loader_abn_user").hide();
        //             $("body").removeClass('body-after');
        //             if (windowWidth > 768) {
        //                 $("#abonne_user").hide();
        //             }else{
        //                 $("#abonne_user").css('transform','');
        //             }
        //         }
        //     });
        // });

        $(document).on('click',"#disfollow_button",function(e) {
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
            var fd = new FormData();
            var idUser= $('#id_user').val();
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
                        $("#disfollow_button").replaceWith('<div id="follow_button"><p>Abonner</p><i class="fas fa-user-plus"></i></div>');
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

        $(document).on('click',"#message_button",function() {
            $("body").addClass('body-after');
            if (windowWidth > 768) {
                $("#message_user").show();
            }else{
                $("#message_user").css('transform','translateY(0)');
            }
        })

        $('#cancel_message_user').click(function(e){
            e.stopPropagation();
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $("#message_user").hide();
            }else{
                $("#message_user").css('transform','');
            }
        });

        $('#cancel_message_user_button').click(function(e){
            e.stopPropagation();
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $("#message_user").hide();
            }else{
                $("#message_user").css('transform','');
            }
        });

        $('#message_user').click(function(e){
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $("#message_user").hide();
            }else{
                $("#message_user").css('transform','');
            }
        });

        $('#message_user_container').click(function(e){
            e.stopPropagation();
        });

        $('#message_user_button').click(function(e){
            var fd = new FormData();
            var idCrsp = $('#id_corresponder').val();
            fd.append('id_corresponder',idCrsp);
            var msgCle = $('#msg_cle').val();
            fd.append('msgCle',msgCle);
            $.ajax({
                url: 'send-message-user.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $('#message_user').css('opacity','0.5');
                    $("#loader_msg_user").show();
                },
                success: function(response){
                    if(response != 0){
                        if (response == 2) {
                            window.location = 'messagerie/'+idCrsp;
                        }
                        else if (response == 1){
                            $('#send_message_button').click();
                        }
                    }
                    else{
                        console.log('err');
                    }
                },
                complete: function(){
                    $('#message_user').css('opacity','');
                    $("#loader_msg_user").hide();
                    $("body").removeClass('body-after');
                    if (windowWidth > 768) {
                        $("#message_user").hide();
                    }else{
                        $("#message_user").css('transform','');
                    }
                }
            });
        });

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

        <?php 
        if (isset($_GET['pub'])) {
            if ($id_user == $row_g['id_user']) {
        ?>
        var fd = new FormData();
        fd.append('id_user',<?php echo $id_user; ?>);
        fd.append('id_pub',<?php echo $_GET['pub']; ?>);
        $.ajax({
            url: 'load-user-publication-notification.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            beforeSend: function(){
                $('.user-profile-middle-container').empty();
                $("#loader_publications").show();
            },
            success: function(response){
                $('.user-profile-middle-container').append(response);
            },
            complete: function(){
                $("#loader_publications").hide();
                $("html, body").animate({ scrollTop: $(document).height() }, 2000); 
                history.pushState('','','/projet/utilisateur/<?php echo $id_user ?>');
            }
        });
        <?php }else{ ?>
            $("html, body").animate({
                scrollTop: $("#pub_tail_<?php echo $_GET['pub'] ?>").offset().top - 70
            }, 1000); 
            history.pushState('','','/projet/utilisateur/<?php echo $row_g['id_user'] ?>');
        <?php }}?>
        
        $('.user-publication-middle-one-view img').on('load', function(){
            console.log('load 1 img');
        });

        $('.user-publication-middle-two-view img').on('load', function(){
            console.log('load 2 img');
        });

        $('.user-publication-middle-three-view').on('load', function(){
            console.log('load 3 img');
        });

        $('.user-publication-middle-four-view img').on('load', function(){
            console.log('load 4 img');
        });

        $('[id^="show_gb_btq_"]').click(function(e){
            var id = $(this).attr('id').split('_')[3];
            var fd = new FormData();
            var idBtq = $('#id_user_btq_'+id).val();
            fd.append('id_btq',idBtq);
            $.ajax({
                url: 'get-boutique-session.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(this).css('opacity','0.5');
                    $("#loader_btq_id").show();
                },
                success: function(response){
                    if(response != 0){
                        window.location = 'gerer-boutique/'+response;
                    }
                },
                complete: function(){
                    $(this).css('opacity','');
                    $("#loader_btq_id").hide();
                }
            });
        });

        $('[id^="show_btq_"]').click(function(e){
            var id = $(this).attr('id').split('_')[2];
            var idBtq = $('#id_user_btq_'+id).val();
            window.location = 'boutique/'+idBtq;
        });
    
        <?php if (isset($_SESSION['user'])) { ?>
        var idUser = <?php echo $id_user; ?>;
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