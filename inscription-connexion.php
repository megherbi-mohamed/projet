
<?php 
session_start();
if (!empty( $_SESSION['user'])) {
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
<?php include './navbar.php';?>
    <div class="clear"></div>
    <div class="inscription-connexion-container">
        <div class="alert-inscription-connexion">
            <div>
                <i class="fas fa-times"></i>
            </div>
            <p></p>
        </div>
        <div class="inscription-container">
            <div class="inscription">
                <h4>inscrivez-vous</h4>
                <div>
                    <span class="nom-user">Nom et prenom</span>
                    <input type="text" id="nom_user" autocomplete="off">
                </div>
                <p id="nom_err"></p>
                <div>
                    <span class="email-tlph-user">Adresse email ou téléphone</span>
                    <input type="text" id="email_tlph_user">
                </div>
                <p id="email_tlph_err"></p>
                <div>
                    <span class="mtp-user">Mot de passe</span>
                    <input type="password" id="mtp_user">
                </div>
                <p id="mtp_err"></p>
                <div>
                    <span class="cnfrm-mtp-user">Mot de passe confirmation</span>
                    <input type="password" id="cnfrm_mtp_user">
                </div>
                <p id="cnfrm_mtp_err"></p>
                <button id="inscrire">Inscrire</button>
                <h5>Vous avez déjà inscris ?
                <button id="connexion_button">Connexion</button></h5>
            </div>
            <div id="loader_load" class="center"></div>
        </div>
        <div class="connexion-container">
            <div class="connexion">
                <h4>connectez-vous</h4>
                <div>
                    <span class="cnx-email-user">Adresse email ou téléphone</span>
                    <input type="text" id="cnx_email_user">
                </div>
                <p id="cnx_email_err"></p>
                <div>
                    <span class="cnx-mtp-user">Mot de passe</span>
                    <input type="password" id="cnx_mtp_user">
                </div>
                <p id="cnx_mtp_err"></p>
                <a href="#">Mot de passe oublié ?</a>
                <button id="connecter">Connecter</button>
                <h5>Vous avez pas encore inscrire ?
                <button id="inscription_button">Inscrire</button>
            </div>
        </div>
        <div id="loader_load" class="center"></div>
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

        $('#connecter').click(function(event){
            var emailUserCnx = $('#cnx_email_user').val();
            var mtpUserCnx = $('#cnx_mtp_user').val();
            if (emailUserCnx == '') {
                $('#cnx_email_err').text("Entrez votre email ou téléphone.");
                $('#cnx_email_user').css('border','2px solid red');
            }
            else if (!validateEmail(emailUserCnx) && !validatePhone(emailUserCnx)) {
                $('#cnx_email_err').text("Format incorrect.");
                $('#cnx_email_user').css('border','2px solid red');
            }
            else if (mtpUserCnx == '') {
                $('#cnx_email_err').text("");
                $('#cnx_mtp_err').text("Entrez votre mot de passe.");
                $('#cnx_email_user').css('border','');
                $('#cnx_mtp_user').css('border','2px solid red');
            }
            else{
                $('#cnx_mtp_user').css('border','');
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
                        $("#loader_load").show();
                        $('.inscription-connexion-container').css('opacity','0.5');
                    },
                    success: function(response){
                        if(response != 0){
                            window.location.href = 'utilisateur.php';
                        }
                        else{
                            $('.alert-inscription-connexion p').text("Information incorrecte.");
                            $('.alert-inscription-connexion').css('display','grid');
                        } 
                    },
                    complete: function(){
                        $("#loader_load").hide();
                        $('.inscription-connexion-container').css('opacity','');
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


        $('#inscrire').click(function(event){
            var nomUser = $('#nom_user').val();
            var emailTlphUser = $('#email_tlph_user').val();
            var mtpUser = $('#mtp_user').val();
            var cnfrmMtpUser = $('#cnfrm_mtp_user').val();

            if (nomUser == '') {
                $('#nom_err').text("Entrez un nom d'utilisateur.");
                $('#nom_user').css("border","2px solid red");
            }
            else if (emailTlphUser == '') {
                $('#nom_err').text("");
                $('#email_tlph_err').text("Entrez un numéro ou un email.");
                $('#nom_user').css("border","");
                $('#email_tlph_user').css("border","2px solid red");
            }
            else if(!validateEmail(emailTlphUser) && !validatePhone(emailTlphUser)){
                $('#nom_err').text("");
                $('#email_tlph_err').text("Entrez un numéro ou un email valide.");
                $('#nom_user').css("border","");
                $('#email_tlph_user').css("border","2px solid red");
            }
            else if (mtpUser == '') {
                $('#nom_err').text("");
                $('#email_tlph_err').text("");
                $('#mtp_err').text("Entrez un mot de passe.");
                $('#nom_user').css("border","");
                $('#email_tlph_user').css("border","");
                $('#mtp_user').css("border","2px solid red");
            }
            else if (cnfrmMtpUser == '') {
                $('#nom_err').text("");
                $('#email_tlph_err').text("");
                $('#mtp_err').text("");
                $('#cnfrm_mtp_err').text("Confirmez le mot de passe.");
                $('#nom_user').css("border","");
                $('#email_tlph_user').css("border","");
                $('#mtp_user').css("border","");
                $('#cnfrm_mtp_user').css("border","2px solid red");
            }
            else if (mtpUser != cnfrmMtpUser) {
                $('#nom_err').text("");
                $('#email_tlph_err').text("");
                $('#mtp_err').text("");
                $('#cnfrm_mtp_err').text("Erreur de confirmation du mot de passe.");
                $('#nom_user').css("border","");
                $('#email_tlph_user').css("border","");
                $('#mtp_user').css("border","");
                $('#cnfrm_mtp_user').css("border","2px solid red");
            }
            else if (mtpUser != '' && cnfrmMtpUser != '' && mtpUser == cnfrmMtpUser) {
                $('#cnfrm_mtp_user').css("border","");
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
                        $("#loader_load").show();
                        $('.inscription-connexion-container').css('opacity','0.5');
                    },
                    success: function(response){
                        if(response != 0){
                            if (response == 2) {
                                $('#nom_err').text("");
                                $('#email_tlph_err').text("");
                                $('#mtp_err').text("");
                                $('#cnfrm_mtp_err').text("");
                                $('#nom_user').css('border','');
                                $('#email_tlph_user').css('border','');
                                $('#mtp_user').css('border','');
                                $('#cnfrm_mtp_user').css('border','');
                                $('.alert-inscription-connexion p').text("Vous avez déjà inscri, vous pouvez connecter");
                                $('.alert-inscription-connexion').css('display','grid');
                            }
                            else if(response == 0){
                                $('#nom_err').text("");
                                $('#email_tlph_err').text("");
                                $('#mtp_err').text("");
                                $('#cnfrm_mtp_err').text("");
                                $('#nom_user').css('border','');
                                $('#email_tlph_user').css('border','');
                                $('#mtp_user').css('border','');
                                $('#cnfrm_mtp_user').css('border','');
                                $('.alert-inscription-connexion p').text("Erreur d'inscription");
                                $('.alert-inscription-connexion').css('display','grid');
                            }
                            else{
                                $('.inscription-connexion-container').empty();
                                $('.inscription-connexion-container').append(response);
                                var windowWidth = window.innerWidth;
                                if (windowWidth > 768) {
                                    $('.email-confirmation input[type="text"]').focus();
                                    $('.mobile-confirmation input[type="text"]').focus();
                                }
                            }
                        }
                    },
                    complete: function(){
                        $("#loader_load").hide();
                        $('.inscription-connexion-container').css('opacity','');
                    }
                });
            }
        })

        $(document).on('click','#verify_email_button',function(event){
            var code = $('#code_verification').val();
            var idUser = $('#id_user').val();
            if (code == '') {
                $('#code_verification').css("border","2px solid red");
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
                        $("#loader_load").show();
                        $('.inscription-connexion-container').css('opacity','0.5');
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
                        $("#loader_load").hide();
                        $('.inscription-connexion-container').css('opacity','');
                    }
                });
            }
        })

        $(document).on('click','#verify_mobile_button',function(event){
            var code = $('#code_verification').val();
            var idUser = $('#id_user').val();
            if (code == '') {
                $('#code_verification').css("border","2px solid red");
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
                        $("#loader_load").show();
                        $('.inscription-connexion-container').css('opacity','0.5');
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
                        $("#loader_load").hide();
                        $('.inscription-connexion-container').css('opacity','');
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
                    $("#loader_load").show();
                    $('.inscription-connexion-container').css('opacity','0.5');
                },
                success: function(response){
                    console.log(response);
                    if(response != 0){
                        window.location.href = 'utilisateur.php';
                    }
                    else{
                        $('#code_verification').val("");
                        $('.alert-inscription-connexion p').text("Erreur d'inscription, réessayer.");
                        $('.alert-inscription-connexion').css('display','grid');
                    }
                },
                complete: function(){
                    $("#loader_load").hide();
                    $('.inscription-connexion-container').css('opacity','');
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

        