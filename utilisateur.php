<?php 
session_start();
include_once './bdd/connexion.php';
if (isset($_SESSION['user'])) {
    $user_session_query = $conn->prepare("SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['user']);
    $user_session_query->execute();
    $row = $user_session_query->fetch(PDO::FETCH_ASSOC);
    $id_user = $row['id_user'];
}
else{
    header('Location: inscription-connexion.php');
}
if (isset($_GET['user'])) {
    $user_get_query = $conn->prepare("SELECT * FROM utilisateurs WHERE id_user=".$_GET['user']);
    $user_get_query->execute();
    $row_g = $user_get_query->fetch(PDO::FETCH_ASSOC);
    $user = $row_g['id_user'];
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
    <!-- <link rel="stylesheet" href="css-js/demandeur.css"> -->
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
    <input type="hidden" id="msg_cle" value="<?php echo $user.$_SESSION['user'] ?>">
    <button style="display:none" id="send_message_button"></button>
    <?php } ?>  
    <div id="loader" class="center"></div>
    <!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBEGrApnjX_7GHcNDtF0LR0pgrwxj5j2Q&callback=initUserMap"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="./css-js/main.js"></script>
    <!-- <script src="./css-js/activites-notes.js"></script> -->
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

        // function pushState(href){
        //     history.pushState('boutique','','/projet/gerer-boutique.php?btq='+href);
        // }

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

        $('[id^="delete_boutique_btn_"]').click(function(){
            var id = $(this).attr("id").split("_")[3];
            $('.alert-message button').show();
            $('.alert-message p').text('Voulez vous vraiment supprimer la boutique!');
            $('.alert-message').css('transform','translate(-50%,0)');
            var idBtq = $('#id_btq_'+id).val();
            $('#id_btq_dlt').val(idBtq);
            $('#btq_cls').val(id);
        });

        $('#delete_confirmation_btn').click(function(){
            $("#dlt_btq_btn").click();
            $('.alert-message').css('transform','');
            setTimeout(() => {
                $('.alert-message button').hide();
                $('.alert-message p').text('');
            }, 1000);
        });
    
        $('#cancel_alert_message').click(function(){
            $('.alert-message').css('transform','');
            setTimeout(() => {
                $('.alert-message button').hide();
                $('.alert-message p').text('');
            }, 1000);
        });

        $("#delete_boutique_form").submit(function(event){
            event.preventDefault(); 
            var fd = new FormData();
            var idBtq = $('#id_btq_dlt').val();
            var btqCls = $('#btq_cls').val();
            fd.append('id_btq',idBtq);

            $.ajax({
                url: 'delete-boutique.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response != 0){
                        $("#delete_boutique_form")[0].reset();
                        setTimeout(() => {
                            $('.alert-message p').text('La boutique a été bien supprimé, vous pouver la récuperer dans les 15 jours suivant!');
                        }, 1000);
                        setTimeout(() => {
                            $('.alert-message').css('transform','translate(-50%,0)');
                        }, 2000);
                        setTimeout(() => {
                            $('.alert-message').css('transform','');
                        }, 4000);
                        setTimeout(() => {
                            $('.alert-message p').text('');
                        }, 5000);
                        $('#user_boutique_'+btqCls).addClass('unset-btq');
                        $('#user_boutique_'+btqCls+' span').text('('+response+')');
                    }else{
                        alert('err');
                    }
                },
            });
        });

        $('[id^="recover_boutique_btn_"]').click(function(){
            var id = $(this).attr("id").split("_")[3];
            var idBtq = $('#id_btq_'+id).val();
            var nomBtq = $('#nom_btq_'+id).val();
            $('#id_btq_rcv').val(idBtq);
            $('#nom_btq_rcv').val(nomBtq);
            $('#btq_cls_rcv').val(id);
            $('#rcv_btq_btn').click();
        });

        $("#recover_boutique_form").submit(function(event){
            event.preventDefault(); 
            var fd = new FormData();
            var idBtq = $('#id_btq_rcv').val();
            var btqCls = $('#btq_cls_rcv').val();
            var nomBtq = $('#nom_btq_rcv').val();
            fd.append('id_btq',idBtq);

            $.ajax({
                url: 'recover-boutique.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response != 0){
                        $("#recover_boutique_form")[0].reset();
                        // setTimeout(() => {
                            $('.alert-message p').text('La boutique '+nomBtq+' a été bien récuperer!');
                        // }, 1000);
                        setTimeout(() => {
                            $('.alert-message').css('transform','translate(-50%,0)');
                        }, 1000);
                        setTimeout(() => {
                            $('.alert-message').css('transform','');
                        }, 3000);
                        setTimeout(() => {
                            $('.alert-message p').text('');
                        }, 5000);
                        $('#user_boutique_'+btqCls).removeClass('unset-btq');
                        $('#user_boutique_'+btqCls+' span').text('');
                    }else{
                        alert('err');
                    }
                },
            });
        });

        $("#update_user_image").click(function(){
            setTimeout(() => {
                $('body').addClass('body-after');
            }, 0);
            var windowWidth = window.innerWidth;
            if (windowWidth <= 768) {
                $('.navbar').css('z-index','50');
            }
            $(".user-image-update-container").css('display','initial');
        });

        $("#update_user_couverture").click(function(){
            setTimeout(() => {
                $('body').addClass('body-after');
            }, 0);
            var windowWidth = window.innerWidth;
            if (windowWidth <= 768) {
                $('.navbar').css('z-index','50');
            }
            $(".user-couverture-update-container").css('display','initial');
        });

        $("#cancel_user_image_update").click(function(){
            $('body').removeClass('body-after');
            var windowWidth = window.innerWidth;
            if (windowWidth <= 768) {
                $('.navbar').css('z-index','');
            }
            $(".user-image-update-container").css('display','');
        });

        $("#cancel_user_couverture_update").click(function(){
            $('body').removeClass('body-after');
            var windowWidth = window.innerWidth;
            if (windowWidth <= 768) {
                $('.navbar').css('z-index','');
            }
            $(".user-couverture-update-container").css('display','');
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
                    success: function (data) {

                        $('.user-picture img').replaceWith("<img id='user_img' src='"+resp+"' alt='logo'>");
                        $('.profile-image-desktop img').replaceWith("<img src='"+resp+"' alt='logo'>");
                        $('#profile_button img').replaceWith("<img id='profile_button' src='"+resp+"' alt='logo'>");

                        $('body').removeClass('body-after');
                        var windowWidth = window.innerWidth;
                        if (windowWidth <= 768) {
                            $('.navbar').css('z-index','');
                        }
                        $(".user-image-update-container").css('display','');
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
                    success: function (data) {
                        $('#user_couverture').replaceWith("<img id='user_couverture' src='"+resp+"' alt='couverture'>");
                        $('body').removeClass('body-after');
                        var windowWidth = window.innerWidth;
                        if (windowWidth <= 768) {
                            $('.navbar').css('z-index','');
                        }
                        $(".user-couverture-update-container").css('display','');
                    }
                });
            });
        });

        // create boutique
        $('#create_pre_boutique').click(function(){
            $('.create-pre-boutique-name').show();
        });

        $('#cancel_create_boutique').click(function(){
            $('.create-pre-boutique-name').hide();
            $('#nom_btq').val("");
        });

        $('#create_btq_btn').click(function(event){
            event.preventDefault(); 
            if ($('#nom_btq').val() == ''){
                $('#nom_btq').css('border','2px solid red');
            }
            else{
                $("#create_boutique_form").submit();
            }
        });

        $("#create_boutique_form").submit(function(event){
            event.preventDefault(); 
            var post_url = $(this).attr("action"); 
            var request_method = $(this).attr("method");
            var form_data = $(this).serialize();
            $.ajax({
                url : post_url,
                type: request_method,
                data : form_data
            }).done(function(response){
                if (response != 0) {
                    $("#create_boutique_form")[0].reset();
                    setTimeout(() => {
                        window.location = './boutique.php?id_btq='+response;
                    }, 500);
                }
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

        // show saved publications
        // if (windowWidth > 768) {
        //     $('#show_saved_publications').click(function(){
        //         console.log('med');
        //         $("body").addClass('body-after');
        //         $('.show-saved-publications').show();
        //         $('.show-saved-publications-container').load('saved-publications.php');
        //     })
        //     $('.show-saved-publications-container').on('click','#cancel_saved_publications',function(){
        //         $("body").removeClass('body-after');
        //         $('.show-saved-publications').hide();
        //         $('.show-saved-publications-container').empty();
        //     })
        // }else{
        //     $('#show_saved_publications').click(function(){
        //         console.log('med');
        //         $('.show-saved-publications').css('transform','translateX(0)');
        //         $('.show-saved-publications-container').load('saved-publications.php');
        //     })
        //     $('.show-saved-publications-container').on('click','#cancel_saved_publications_resp',function(){
        //         $('.show-saved-publications').css('transform','');
        //         setTimeout(() => {
        //             $('.show-saved-publications-container').empty();
        //         }, 400);
        //     })
        // }

        // $('.show-saved-publications').click(function(e){
        //     e.stopPropagation();
        //     $("body").removeClass('body-after');
        //     $('.show-saved-publications').hide();
        //     $('.show-saved-publications-container').empty();
        // })

        // $('.show-saved-publications-container').click(function(e){
        //     e.stopPropagation();
        // })

        // remove saved publications
        // $('.show-saved-publications-container').on('click','[id^="remove_saved_pub_button_"]',function(){
        //     id = $(this).attr("id").split("_")[4];
        //     var fd = new FormData();
        //     var idPub = $('#id_publication_save_'+id).val();
        //     fd.append('id_pub',idPub);
        //     $.ajax({
        //         url: 'remove-saved-publications.php',
        //         type: 'post',
        //         data: fd,
        //         contentType: false,
        //         processData: false,
        //         success: function(response){
        //             if(response != 0){
        //                 $('.show-saved-publications-container').load('saved-publications.php');
        //             }
        //         }
        //     });
        // });

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
                            window.location = 'messagerie.php?user='+idCrsp;
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
        <?php } ?>
        
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