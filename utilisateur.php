<?php 
session_start();
include_once './bdd/connexion.php';
if (isset($_SESSION['user'])) {
    $cnx_user_query = "SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['user'];
    $result = mysqli_query($conn, $cnx_user_query);
    $row = mysqli_fetch_assoc($result);
    $id_user = $row['id_user'];
}
else{
    header('Location: inscription-connexion.php');
}

$msg_query = "SELECT * FROM messages WHERE id_msg IN ( SELECT MAX(id_msg) FROM messages WHERE id_recever = {$row['id_user']} GROUP BY id_sender) ORDER BY id_msg DESC";
$msg_result = mysqli_query($conn,$msg_query);

// $num_msg_query = "SELECT * FROM messages WHERE id_recever = {$row['id_user']} AND etat_msg = 1 GROUP BY id_sender";    
// $num_msg_result = mysqli_query($conn,$num_msg_query);
// $num_message = 0;
// while ($num_msg_row = mysqli_fetch_assoc($num_msg_result)) {
//     $num_message++;
// }
// $etat_message = '';
// if ($num_message > 0) {
//     $etat_message = 'active-message-num';
// }else{ $etat_message = '';}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css-js/style.css">
    <link rel="stylesheet" href="./css-js/utilisateur.css">
    <link rel="stylesheet" href="./css-js/demandeur.css">
    <link rel="stylesheet" href="./css-js/croppie.css">
    <link href="./css-js/fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fugaz One">
    <title><?php echo $row['nom_user'] ?></title>
</head>
<body>
    <?php include './navbar.php';?>
    <div class="clear"></div>
    <div class="user-profile-container">
        <?php 
        if (isset($_GET['a'])) {
            $updt_etat_ntf_query = "UPDATE notifications SET etat_n = 0 WHERE id_activity=".$_GET['a'];
            mysqli_query($conn, $updt_etat_ntf_query);    
        ?>
        <input type="hidden" id="active_notification" value="<?php echo $_GET['a']; ?>">
        <?php }else{?><input type="hidden" id="active_notification" value="0"><?php } ?>
        
        <?php if ($row['type_user'] == 'professionnel') { 
            include './professionnel.php';
        }else if ($row['type_user'] == 'client'){ 
            include './client.php';
        }?>
        <?php 
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
                        <label>Nom et prenom <span>*</span></label>
                        <input type="text" id="pre_nom_user" value="<?php echo $row['nom_user'] ?>">
                    </div>
                    <div>
                        <label>Nom d'entreprise <span>*</span></label>
                        <input type="text" id="pre_entrp_user">
                    </div>
                    <?php if ($row['email_user'] !== '') { ?>
                    <div>
                        <label>Téléphone <span>*</span></label>
                        <input type="text" id="pre_tlph_user">
                        <input type="hidden" id="pre_email_user" value="<?php echo $row['email_user'] ?>">
                    </div>
                    <?php }else{ ?>
                    <div>
                        <label>Email <span>*</span></label>
                        <input type="text" id="pre_email_user">
                        <input type="hidden" id="pre_tlph_user" value="<?php echo $row['tlph_user'] ?>">
                    </div>
                    <?php } ?>
                    <div>
                        <label>Adresse <span>*</span></label>
                        <input type="text" id="pre_adresse_user">
                    </div>
                    <div>
                        <label>Ville <span>*</span></label>
                        <input type="text" id="pre_ville_user">
                    </div>
                    <div class="pre-categories pre-categories-active">
                        <label>Catégories <span>*</span></label>
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
                        <label>Professions <span>*</span></label>
                        <select id="pre_profession">
                            <option value="">Professions</option>
                            <?php 
                                $categories_query = "SELECT * FROM categories WHERE categories = 'services'";
                                $categories_result = mysqli_query($conn,$categories_query);
                                while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                            ?>
                            <option value="<?php echo $categories_row['sous_categories'] ?>"><?php echo $categories_row['sous_categories'] ?></option>
                            <?php } ?>
                            <option value="autre">Autres</option>
                        </select>
                    </div>
                    <div class="pre-profession">
                        <label>Professions <span>*</span></label>
                        <select id="pre_profession">
                            <option value="">Professions</option>
                            <?php 
                                $categories_query = "SELECT * FROM categories WHERE categories = 'artisants'";
                                $categories_result = mysqli_query($conn,$categories_query);
                                while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                            ?>
                            <option value="<?php echo $categories_row['sous_categories'] ?>"><?php echo $categories_row['sous_categories'] ?></option>
                            <?php } ?>
                            <option value="autre">Autres</option>
                        </select>
                    </div>
                    <div class="pre-profession">
                        <label>Professions <span>*</span></label>
                        <select id="pre_profession">
                            <option value="">Professions</option>
                            <?php 
                                $categories_query = "SELECT * FROM categories WHERE categories = 'transports'";
                                $categories_result = mysqli_query($conn,$categories_query);
                                while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                            ?>
                            <option value="<?php echo $categories_row['sous_categories'] ?>"><?php echo $categories_row['sous_categories'] ?></option>
                            <?php } ?>
                            <option value="autre">Autres</option>
                        </select>
                    </div>
                    <div class="pre-profession">
                        <label>Professions <span>*</span></label>
                        <select id="pre_profession">
                            <option value="">Professions</option>
                            <?php 
                                $categories_query = "SELECT * FROM categories WHERE categories = 'locations'";
                                $categories_result = mysqli_query($conn,$categories_query);
                                while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                            ?>
                            <option value="<?php echo $categories_row['sous_categories'] ?>"><?php echo $categories_row['sous_categories'] ?></option>
                            <?php } ?>
                            <option value="autre">Autres</option>
                        </select>
                    </div>
                    <div class="pre-profession">
                        <label>Professions <span>*</span></label>
                        <select id="pre_profession">
                            <option value="">Professions</option>
                            <?php 
                                $categories_query = "SELECT * FROM categories WHERE categories = 'entreprises'";
                                $categories_result = mysqli_query($conn,$categories_query);
                                while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                            ?>
                            <option value="<?php echo $categories_row['sous_categories'] ?>"><?php echo $categories_row['sous_categories'] ?></option>
                            <?php } ?>
                            <option value="autre">Autres</option>
                        </select>
                    </div>
                    <div class="pre-profession">
                        <label>Professions <span>*</span></label>
                        <select id="pre_profession">
                            <option value="">Professions</option>
                            <?php 
                                $categories_query = "SELECT * FROM categories WHERE categories = 'detaillons'";
                                $categories_result = mysqli_query($conn,$categories_query);
                                while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                            ?>
                            <option value="<?php echo $categories_row['sous_categories'] ?>"><?php echo $categories_row['sous_categories'] ?></option>
                            <?php } ?>
                            <option value="autre">Autres</option>
                        </select>
                    </div>
                    <div class="pre-profession">
                        <label>Professions <span>*</span></label>
                        <select id="pre_profession">
                            <option value="">Professions</option>
                            <?php 
                                $categories_query = "SELECT * FROM categories WHERE categories = 'grossistes'";
                                $categories_result = mysqli_query($conn,$categories_query);
                                while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                            ?>
                            <option value="<?php echo $categories_row['sous_categories'] ?>"><?php echo $categories_row['sous_categories'] ?></option>
                            <?php } ?>
                            <option value="autre">Autres</option>
                        </select>
                    </div>
                    <div class="pre-profession">
                        <label>Professions <span>*</span></label>
                        <select id="pre_profession">
                            <option value="">Professions</option>
                            <?php 
                                $categories_query = "SELECT * FROM categories WHERE categories = 'fabriquants'";
                                $categories_result = mysqli_query($conn,$categories_query);
                                while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                            ?>
                            <option value="<?php echo $categories_row['sous_categories'] ?>"><?php echo $categories_row['sous_categories'] ?></option>
                            <?php } ?>
                            <option value="autre">Autres</option>
                        </select>
                    </div>
                    <div class="pre-profession">
                        <label>Professions <span>*</span></label>
                        <select id="pre_profession">
                            <option value="">Professions</option>
                            <?php 
                                $categories_query = "SELECT * FROM categories WHERE categories = 'import-export'";
                                $categories_result = mysqli_query($conn,$categories_query);
                                while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                            ?>
                            <option value="<?php echo $categories_row['sous_categories'] ?>"><?php echo $categories_row['sous_categories'] ?></option>
                            <?php } ?>
                            <option value="autre">Autres</option>
                        </select>
                    </div>
                    <div class="pre-profession">
                        <label>Professions <span>*</span></label>
                        <input type="text" id="pre_profession" placeholder="Entrez votre profession">
                    </div>
                </div>
                <input type="submit" id="pre_updt" value="Vailder">
            </div>
        </div>
    </div>
    <div class="show-hided-publications">
        <div class="show-hided-publications-container"></div>
    </div>
    <div class="show-saved-publications">
        <div class="show-saved-publications-container"></div>
    </div>
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

        function pushState(href){
            history.pushState('boutique','','/projet/gerer-boutique.php?btq='+href);
        }

        // add new publications when scroll bottom
        var scrollBottom = 0;         
        $(window).on("scroll", function () {
            if (window.innerHeight + window.pageYOffset >= document.body.scrollHeight) {
                scrollBottom++;
                var fd = new FormData();
                fd.append('offset', scrollBottom);
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

        if ($('#active_notification').val() != 0) {
            var actvNtf = $('#active_notification').val();
            $('html, body').animate({
                scrollTop: $("#active_notification_"+actvNtf).offset().top
            }, 1000);
        }

        document.querySelector('#input_user_checkbox').addEventListener('click',()=>{
            document.querySelector("#check_btn").click();
        })
        
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

        var categorie = document.querySelector('#pre_categorie');
        var profession = document.querySelectorAll('.pre-profession');
        var categorieActive = document.querySelector('.pre-categories');

        categorie.addEventListener('change', function (e) {
            $('#pre_categorie').css("border","");
            categorieActive.classList.remove('pre-categories-active');
            if (e.target.value !== '') {
                if (e.target.value == 'services') {
                    hideProfessions();
                    profession[0].classList.add('pre-profession-active');
                }
                if (e.target.value == 'artisants') {
                    hideProfessions();
                    profession[1].classList.add('pre-profession-active');
                }
                if (e.target.value == 'transports') {
                    hideProfessions();
                    profession[2].classList.add('pre-profession-active');
                }
                if (e.target.value == 'locations') {
                    hideProfessions();
                    profession[3].classList.add('pre-profession-active');
                }
                if (e.target.value == 'entreprises') {
                    hideProfessions();
                    profession[4].classList.add('pre-profession-active');
                }
                if (e.target.value == 'detaillons') {
                    hideProfessions();
                    profession[5].classList.add('pre-profession-active');
                }
                if (e.target.value == 'grossidtes') {
                    hideProfessions();
                    profession[6].classList.add('pre-profession-active');
                }
                if (e.target.value == 'fabriquants') {
                    hideProfessions();
                    profession[7].classList.add('pre-profession-active');
                }
                if (e.target.value == 'import-export') {
                    hideProfessions();
                    profession[8].classList.add('pre-profession-active');
                }
            }
            else{
                categorieActive.classList.add('pre-categories-active');
                hideProfessions();
            }
        });

        for (let p = 0; p < profession.length; p++) {
            profession[p].addEventListener('change', function (e) {
                if (e.target.value == 'autre') {
                    hideProfessions();
                    profession[9].classList.add('pre-profession-active');
                }
            });
        }
        
        function hideProfessions(){
            profession.forEach(p => {
                p.classList.remove('pre-profession-active');
            });
        }

        function validateEmail(email) {
            var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
            return re.test(email);
        }
        function validatePhone(phone) {
            var re = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;
            return re.test(phone);
        }

        $('#pre_updt').click(function(event){
            event.preventDefault(); 
            var nomUser = $('#pre_nom_user').val();
            var nomEntrpUser = $('#pre_entrp_user').val();
            var tlphUser = $('#pre_tlph_user').val();
            var emailUser = $('#pre_email_user').val();
            var adresseUser = $('#pre_adresse_user').val();
            var villeUser = $('#pre_ville_user').val();
            var categorieUser = $('#pre_categorie').val();
            var professionUser = $('.pre-profession-active #pre_profession').val();
            
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
                $('.pre-profession-active #pre_profession').css("border","2px solid red");
            }
            else if (nomUser != '' && nomEntrpUser != '' && tlphUser != '' &&
                    emailUser != '' && adresseUser != '' && villeUser != '' && 
                    categorieUser != '' && professionUser != '') {
                $('.pre-profession-active #pre_profession').css("border","");
                
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
                    success: function(response){
                        if(response != 0){
                            $('.pre-update-profile').hide();
                            $('body').removeClass('body-after');
                            $('#user_informations').replaceWith(response);
                        }else{
                            alert('err');
                        }
                    },
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
        if (windowWidth > 768) {
            $('#show_saved_publications').click(function(){
                console.log('med');
                $("body").addClass('body-after');
                $('.show-saved-publications').show();
                $('.show-saved-publications-container').load('saved-publications.php');
            })
            $('.show-saved-publications-container').on('click','#cancel_saved_publications',function(){
                $("body").removeClass('body-after');
                $('.show-saved-publications').hide();
                $('.show-saved-publications-container').empty();
            })
        }else{
            $('#show_saved_publications').click(function(){
                console.log('med');
                $('.show-saved-publications').css('transform','translateX(0)');
                $('.show-saved-publications-container').load('saved-publications.php');
            })
            $('.show-saved-publications-container').on('click','#cancel_saved_publications_resp',function(){
                $('.show-saved-publications').css('transform','');
                setTimeout(() => {
                    $('.show-saved-publications-container').empty();
                }, 400);
            })
        }

        $('.show-saved-publications').click(function(e){
            e.stopPropagation();
            $("body").removeClass('body-after');
            $('.show-saved-publications').hide();
            $('.show-saved-publications-container').empty();
        })

        $('.show-saved-publications-container').click(function(e){
            e.stopPropagation();
        })

        // remove saved publications
        $('.show-saved-publications-container').on('click','[id^="remove_saved_pub_button_"]',function(){
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
                success: function(response){
                    if(response != 0){
                        $('.show-saved-publications-container').load('saved-publications.php');
                    }
                }
            });
        });

        var uid = <?php echo $id_user; ?>;
        var websocket_server = 'ws://<?php echo $_SERVER['HTTP_HOST']; ?>:3030?uid='+uid;
        var websocket = false;
        var js_flood = 0;
        var status_websocket = 0;
        $(document).ready(function() {
            start(websocket_server);
        });
    </script>
    <script src="css-js/websocket.js"></script>
</body>
</html>