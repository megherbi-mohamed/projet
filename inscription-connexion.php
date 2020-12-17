<?php 
session_start();
include_once './bdd/connexion.php';
if (!empty($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css-js/style.css">
    <link rel="stylesheet" href="./css-js/inscription-connexion.css">
    <link href="./css-js/fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fugaz One">
    <title>Inscription | Connexion</title>
</head>
<body>
<?php include 'navbar.php';?>
    <div class="clear"></div>
    <div class="inscription-connexion-container">
        <div class="inscription-container">
            <div class="inscription">
                <h4>inscrivez-vous</h4>
                <div class="inscription-input">
                    <span class="nom-user">Nom et prenom</span>
                    <input type="text" id="nom_user" autocomplete="off">
                    <div id="nom_user_err">
                        <p></p>
                        <i class="fas fa-caret-left"></i>
                    </div>
                </div>
                <div class="inscription-input">
                    <span class="email-tlph-user">Adresse email ou téléphone</span>
                    <input type="text" id="email_tlph_user">
                    <div id="email_user_err">
                        <p></p>
                        <i class="fas fa-caret-left"></i>
                    </div>
                </div>
                <div class="inscription-input">
                    <span class="mtp-user">Mot de passe</span>
                    <input type="password" id="mtp_user">
                    <div id="mtp_user_err">
                        <p></p>
                        <i class="fas fa-caret-left"></i>
                    </div>
                </div>
                <div class="inscription-input">
                    <span class="cnfrm-mtp-user">Mot de passe confirmation</span>
                    <input type="password" id="cnfrm_mtp_user">
                    <div id="cnfrm_mtp_user_err">
                        <p></p>
                        <i class="fas fa-caret-left"></i>
                    </div>
                </div>
                <div class="create-publication-bottom-button" style="width:400px;margin:auto">
                    <div id="loader_create_publication_bottom_button" style="margin-top:15px" class="button-center"></div>
                    <button style="width:400px;margin:10px auto" id="inscrire">Inscrire</button>
                </div>
                <hr>
                <h5>Vous avez déjà inscris ?</h5>
                <button id="connexion_button">Connexion</button>
            </div>
        </div>
        <div class="connexion-container">
            <div class="connexion">
                <h4>connectez-vous</h4>
                <div class="connexion-input">
                    <span class="cnx-email-user">Adresse email ou téléphone</span>
                    <input type="text" id="cnx_email_user">
                    <div id="cnx_email_user_err">
                        <p></p>
                        <i class="fas fa-caret-left"></i>
                    </div>
                </div>
                <div class="connexion-input">
                    <span class="cnx-mtp-user">Mot de passe</span>
                    <input type="password" id="cnx_mtp_user">
                    <div id="cnx_mtp_user_err">
                        <p></p>
                        <i class="fas fa-caret-left"></i>
                    </div>
                </div>
                <a href="#">Mot de passe oublié ?</a>
                <div class="create-publication-bottom-button" style="width:400px;margin:auto">
                    <div id="loader_create_publication_bottom_button" style="margin-top:15px" class="button-center"></div>
                    <button style="width:400px;margin:10px auto" id="connecter">Connecter</button>
                </div>
                <hr>
                <h5>Vous avez pas encore inscrire ?</h5>
                <button id="inscription_button">Inscrire</button>
            </div>
        </div>
    </div>
    <div class="alert-messages">
        <p></p>
    </div>
    <div id="loader" class="center"></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="./css-js/main.js"></script>
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

        function emailCnxUserErr (type) {
            if (type == 1) {
                $('#cnx_email_user').css("border","2px solid #bd2121");
                $('#cnx_email_user_err p').text("Entrez un Email ou numéro de téléphone");
                $('#cnx_email_user_err').show();
            }
            else{
                $('#cnx_email_user').css("border","");
                $('#cnx_email_user_err p').text("");
                $('#cnx_email_user_err').hide();
            }
        }

        function mtpCnxUserErr (type) {
            if (type == 1) {
                $('#cnx_mtp_user').css("border","2px solid #bd2121");
                $('#cnx_mtp_user_err p').text("Entrez un mot de passe");
                $('#cnx_mtp_user_err').show();
            }
            else{
                $('#cnx_mtp_user').css("border","");
                $('#cnx_mtp_user_err p').text("");
                $('#cnx_mtp_user_err').hide();
            }
        }

        $('#cnx_email_user').on('keypress',function(event){
            emailCnxUserErr (0);
            mtpCnxUserErr (0);
        })

        $('#cnx_mtp_use').on('keypress',function(event){
            emailCnxUserErr (0);
            mtpCnxUserErr (0);
        })

        $('#connecter').click(function(event){
            var emailUserCnx = $('#cnx_email_user').val();
            var mtpUserCnx = $('#cnx_mtp_user').val();
            if (emailUserCnx == '') {
                emailCnxUserErr (1);
            }
            else if (!validateEmail(emailUserCnx) && !validatePhone(emailUserCnx)) {
                emailCnxUserErr (1);
                $('#cnx_email_user_err p').text("Adresse email ou numéro de téléphone invalide");
            }
            else if (mtpUserCnx == '') {
                mtpCnxUserErr (1);
            }
            else{
                emailCnxUserErr (0);
                mtpCnxUserErr (0);
                var fd = new FormData();
                fd.append('email_user',emailUserCnx);
                fd.append('mtp_user',mtpUserCnx);
                $.ajax({
                    url: 'connexion.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $('#connecter').prop('disabled', true);
                        $('#connecter').css('opacity','.8');
                        $("#loader_create_publication_bottom_button").show();
                    },
                    success: function(response){
                        if(response != 0){
                            window.location.href = 'utilisateur/'+response;
                        }
                        else{
                            $('.alert-messages p').text("Inforamtions incorrect, réessayer!");
                            $('.alert-messages').css({'visibility':'visible','transform':'translate(-50%,70px)'});
                            setTimeout(() => {
                                $('.alert-messages').css({'visibility':'','transform':''});
                            }, 4000);
                        } 
                    },
                    complete: function(){
                        $('#connecter').prop('disabled', false);
                        $('#connecter').css('opacity','');
                        $("#loader_create_publication_bottom_button").hide();
                    }
                }); 
            }
        });

        $(document).on('focus','.inscription input',function(){
            var id = $(this).attr('id');
            if (id == 'nom_user') {
                $('.nom-user').addClass('active-cnx-connexion-span');
            }
            if (id == 'email_tlph_user') {
                $('.email-tlph-user').addClass('active-cnx-connexion-span');
            }
            if (id == 'mtp_user') {
                $('.mtp-user').addClass('active-cnx-connexion-span');
            }
            if (id == 'cnfrm_mtp_user') {
                $('.cnfrm-mtp-user').addClass('active-cnx-connexion-span');
            }
        })

        $(document).on('focus','.connexion input',function(){
            var id = $(this).attr('id');
            if (id == 'cnx_email_user') {
                $('.cnx-email-user').addClass('active-cnx-connexion-span');
            }
            if (id == 'cnx_mtp_user') {
                $('.cnx-mtp-user').addClass('active-cnx-connexion-span');
            }
        })

        $('#inscription_button').click(function(){
            $(".connexion-container").css('transform','rotateY(180deg)');
            $(".inscription-container").css('transform','rotateY(0deg)');
            $(".connexion-container").css('visibility','hidden');
            $(".connexion-container").css('opacity','0');
        })

        $('#connexion_button').click(function(){
            $(".connexion-container").css('transform','rotateY(0deg)');
            $(".inscription-container").css('transform','rotateY(-180deg)');
            $(".connexion-container").css('visibility','');
            $(".connexion-container").css('opacity','');
        })

        function validateEmail(email) {
            var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
            return re.test(email);
        }
        function validatePhone(phone) {
            var re = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;
            return re.test(phone);
        }

        function nomUserErr (type) {
            if (type == 1) {
                $('#nom_user').css("border","2px solid #bd2121");
                $('#nom_user_err p').text("Entrez un nom d'utilisateur.");
                $('#nom_user_err').show();
            }
            else{
                $('#nom_user').css("border","");
                $('#nom_user_err p').text("");
                $('#nom_user_err').hide();
            }
        }

        function emailUserErr (type) {
            if (type == 1) {
                $('#email_tlph_user').css("border","2px solid #bd2121");
                $('#email_user_err p').text("Entrez un email ou numéro de téléphone");
                $('#email_user_err').show();
            }
            else{
                $('#email_tlph_user').css("border","");
                $('#email_user_err p').text("");
                $('#email_user_err').hide();
            }
        }

        function mtpUserErr (type) {
            if (type == 1) {
                $('#mtp_user').css("border","2px solid #bd2121");
                $('#mtp_user_err p').text("Entrez un mot de passe");
                $('#mtp_user_err').show();
            }
            else{
                $('#mtp_user').css("border","");
                $('#mtp_user_err p').text("");
                $('#mtp_user_err').hide();
            }
        }

        function cnfrmMtpUserErr (type) {
            if (type == 1) {
                $('#cnfrm_mtp_user').css("border","2px solid #bd2121");
                $('#cnfrm_mtp_user_err p').text("Confirmer le mot de passe");
                $('#cnfrm_mtp_user_err').show();
            }
            else{
                $('#cnfrm_mtp_user').css("border","");
                $('#cnfrm_mtp_user_err p').text("");
                $('#cnfrm_mtp_user_err').hide();
            }
        }

        $('#nom_user').on('keypress',function(event){
            nomUserErr (0);
            emailUserErr (0);
            mtpUserErr (0);
            cnfrmMtpUserErr (0);
        })

        $('#email_tlph_user').on('keypress',function(event){
            nomUserErr (0);
            emailUserErr (0);
            mtpUserErr (0);
            cnfrmMtpUserErr (0);
        })

        $('#mtp_user').on('keypress',function(event){
            nomUserErr (0);
            emailUserErr (0);
            mtpUserErr (0);
            cnfrmMtpUserErr (0);
        })

        $('#cnfrm_mtp_user').on('keypress',function(event){
            nomUserErr (0);
            emailUserErr (0);
            mtpUserErr (0);
            cnfrmMtpUserErr (0);
        })

        $('#inscrire').click(function(event){
            var nomUser = $('#nom_user').val();
            var emailTlphUser = $('#email_tlph_user').val();
            var mtpUser = $('#mtp_user').val();
            var cnfrmMtpUser = $('#cnfrm_mtp_user').val();
            if (nomUser == '') {
                nomUserErr (1);
            }
            else if (emailTlphUser == '') {
                emailUserErr (1);
            }
            else if(!validateEmail(emailTlphUser) && !validatePhone(emailTlphUser)){
                emailUserErr (1);
                $('#email_user_err p').text("Email ou numéro de téléphone invalide");
            }
            else if (mtpUser == '') {
                mtpUserErr (1);
            }
            else if (cnfrmMtpUser == '') {
                cnfrmMtpUserErr (1);
            }
            else if (mtpUser != cnfrmMtpUser) {
                cnfrmMtpUserErr (1);
                $('#cnfrm_mtp_user_err p').text("Confirmation de mot de passe incorrect");
            }
            else {
                nomUserErr (0);
                emailUserErr (0);
                mtpUserErr (0);
                cnfrmMtpUserErr (0);
                var fd = new FormData();
                fd.append('nom_user',nomUser);
                fd.append('email_tlph_user',emailTlphUser);
                fd.append('mtp_user',mtpUser);
                $.ajax({
                    url: 'inscription.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $('#inscrire').prop('disabled', true);
                        $('#inscrire').css('opacity','.8');
                        $("#loader_create_publication_bottom_button").show();
                    },
                    success: function(response){
                        console.log(response);
                        if (response == 2) {
                            $('.alert-messages p').text("Vous avez déjà inscri, vous pouvez connecter");
                            $('.alert-messages').css({'visibility':'visible','transform':'translate(-50%,70px)'});
                            setTimeout(() => {
                                $('.alert-messages').css({'visibility':'','transform':''});
                            }, 4000);
                        }
                        else if(response == 0){
                            $('.alert-messages p').text("Erreur d'inscription");
                            $('.alert-messages').css({'visibility':'visible','transform':'translate(-50%,70px)'});
                            setTimeout(() => {
                                $('.alert-messages').css({'visibility':'','transform':''});
                            }, 4000);
                        }
                        else{
                            $('.inscription-connexion-container').empty();
                            $('.inscription-connexion-container').append(response);
                        }
                    },
                    complete: function(){
                        $('#inscrire').prop('disabled', false);
                        $('#inscrire').css('opacity','');
                        $("#loader_create_publication_bottom_button").hide();
                    }
                });
            }
        })

        $(document).on('focus','#code_verification',function(){
            $('.code-verification').addClass('active-cnx-connexion-span');
        })

        function cnfrmCoderErr (type) {
            if (type == 1) {
                $('#code_verification').css("border","2px solid #bd2121");
                $('#cnfrm_code_err p').text("Entrez le code de vérification");
                $('#cnfrm_code_err').show();
            }
            else{
                $('#code_verification').css("border","");
                $('#cnfrm_code_err p').text("");
                $('#cnfrm_code_err').hide();
            }
        }

        $('#code_verification').on('keypress',function(event){
            cnfrmCoderErr (0);
        })

        $(document).on('click','#verify_email_button',function(event){
            var code = $('#code_verification').val();
            var idUser = $('#id_user').val();
            if (code == '') {
                cnfrmCoderErr (1);
            }
            else {
                cnfrmCoderErr (0);
                var fd = new FormData();
                fd.append('code_verification',code);
                fd.append('id_user',idUser);
                $.ajax({
                    url: 'code-verification.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $('#verify_email_button').prop('disabled', true);
                        $('#verify_email_button').css('opacity','.8');
                        $("#loader_create_publication_bottom_button").show();
                    },
                    success: function(response){
                        if(response == 0){
                            $('.alert-messages p').text("Erreur d'inscription");
                            $('.alert-messages').css({'visibility':'visible','transform':'translate(-50%,70px)'});
                            setTimeout(() => {
                                $('.alert-messages').css({'visibility':'','transform':''});
                            }, 4000);
                        }
                        if(response == 2){
                            $('.alert-messages p').text("Code de vérification incorrect");
                            $('.alert-messages').css({'visibility':'visible','transform':'translate(-50%,70px)'});
                            setTimeout(() => {
                                $('.alert-messages').css({'visibility':'','transform':''});
                            }, 4000);
                        }
                        else{
                            $('.inscription-connexion-container').empty();
                            $('.inscription-connexion-container').append(response);
                        }
                    },
                    complete: function(){
                        $('#verify_email_button').prop('disabled', false);
                        $('#verify_email_button').css('opacity','');
                        $("#loader_create_publication_bottom_button").hide();
                    }
                });
            }
        })

        $(document).on('click','#verify_mobile_button',function(event){
            var code = $('#code_verification').val();
            var idUser = $('#id_user').val();
            if (code == '') {
                $('#code_verification').css("border","2px solid #bd2121");
            }
            else {
                $('#code_verification').css("border","");
                var fd = new FormData();
                fd.append('code_verification',code);
                fd.append('id_user',idUser);
                $.ajax({
                    url: 'code-verification.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $('#verify_mobile_button').prop('disabled', true);
                        $('#verify_mobile_button').css('opacity','.8');
                        $("#loader_create_publication_bottom_button").show();
                    },
                    success: function(response){
                        if(response != 0){
                            $('.inscription-connexion-container').empty();
                            $('.inscription-connexion-container').append(response);
                        }
                        else{
                            $('#code_verification').val("");
                            $('.alert-inscription-connexion p').text("Code de vérification invalide, réessayer.");
                            $('.alert-inscription-connexion').css('display','grid');
                        }
                    },
                    complete: function(){
                        $('#verify_mobile_button').prop('disabled', false);
                        $('#verify_mobile_button').css('opacity','');
                        $("#loader_create_publication_bottom_button").hide();
                    }
                });
            }
        })

        $(window).on('beforeunload', function(){
            var fd = new FormData();
                var idUser = $("#id_user").val();
                fd.append('id_user',idUser);
                $.ajax({
                    url: 'delete-user-inscription.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                });
        });

        $(document).on('click','#client_inscription_button',function(event){
            $('#type_user').val('client');
            $('.inscription-details-background').css('transform','translateX(100%)');
            $('.inscription-professionnel-information').css('transform','translateX(-101%)');
            $('.inscription-client-information').css('transform','translateX(0)');
            setTimeout(() => {
                $(this).addClass('active-button');
                $('#professionnel_inscription_button').removeClass('active-button');
            }, 300);
        })

        $(document).on('click','#professionnel_inscription_button',function(event){
            $('#type_user').val('professionnel');
            $('.inscription-details-background').css('transform','');
            $('.inscription-professionnel-information').css('transform','');
            $('.inscription-client-information').css('transform','');
            setTimeout(() => {
                $(this).addClass('active-button');
                $('#client_inscription_button').removeClass('active-button');
            }, 300);
        })

        $(document).on('click','#valide_final_inscription',function(event){
            var fd = new FormData();
            var idUser = $('#id_user').val();
            var typeUser = $('#type_user').val();
            fd.append('type_user',typeUser);
            fd.append('id_user',idUser);
            $.ajax({
                url: 'client-professionnel-inscription.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $('#valide_final_inscription').prop('disabled', true);
                    $('#valide_final_inscription').css('opacity','.8');
                    $("#loader_create_publication_bottom_button").show();
                },
                success: function(response){
                    console.log(response);
                    if(response != 0){
                        window.location.href = 'utilisateur/'+response;
                    }
                    else{
                        $('#code_verification').val("");
                        $('.alert-inscription-connexion p').text("Erreur d'inscription, réessayer.");
                        $('.alert-inscription-connexion').css('display','grid');
                    }
                },
                complete: function(){
                    $('#valide_final_inscription').prop('disabled', false);
                    $('#valide_final_inscription').css('opacity','');
                    $("#loader_create_publication_bottom_button").show();
                }
            });
        })

        var categorieProfssTop = document.querySelectorAll('.categorie-profss-top');
        var categorieProfssBottom = document.querySelectorAll('.categorie-profss-bottom');
        var clickCategorie = new Array(categorieProfssTop.length);

        for (let k = 0; k < categorieProfssTop.length; k++) {
            clickCategorie[k] = 1;
            categorieProfssTop[k].addEventListener('click',()=>{
                clickCategorie[k]++;
                if (clickCategorie[k]%2 == 1) {
                    categorieProfssBottom[k].style.display = "";
                }
                else{
                    hideCategories();
                    categorieProfssBottom[k].style.display = "initial";
                }
            }) 
        }

        function hideCategories (){
            categorieProfssBottom.forEach(c => {
                c.style.display = "";
            });
        }

    </script>
</body>
</html>

        