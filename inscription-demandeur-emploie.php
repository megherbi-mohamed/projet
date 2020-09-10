<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css-js/style.css">
    <link rel="stylesheet" href="./css-js/inscription-connexion.css">
    <link href="./css-js/fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet">
    <title>Inscription demandeur d'emploie</title>
</head>
<body>
    <?php include './navbar.php'; ?>
    <div class="clear"></div>
    <div class="inscription-connexion-animation">
        <div class="inscription-connexion-responsive">
            <div class="inscription-connexion-container">
                <h3></h3>
                <div class="inscription-container" style="transform: rotateY(0deg)">
                    <div class="inscription">
                        <form action="./inscription.php" method="post" id="inscription_form">
                            <h4>inscrivez-vous</h4>
                            <div>
                                <input type="text" id="nom_user" name="nom_user" autocomplete="off" placeholder="Nom d'utilisateur">
                                <p id="nom_err"></p>
                            </div>
                            <div>
                                <input type="text" id="email_tlph_user" name="email_tlph_user" placeholder="Email ou numéro de téléphone">
                                <p id="email_tlph_err"></p>
                            </div>
                            <div>
                                <input type="password" id="mtp_user" name="mtp_user" placeholder="Mot de passe">
                                <p id="mtp_err"></p>
                            </div>
                            <div>
                                <input type="password" id="cnfrm_mtp_user" name="cnfrm_mtp_user" placeholder="Mot de passe confirmation">
                                <p id="cnfrm_mtp_err"></p>
                            </div>
                            <input type="hidden" name="type_user" value="demandeur">
                            <input type="submit" id="inscrire" value="Inscrire">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="mobile-email-confirmation-container" style="width:100%">
            <div class="mobile-email-confirmation">
                <div class="email-confirmation">
                    <h3>Email confirmation</h3>
                    <p>Un code de vérification a été envoyé à votre adresse e-mail <span></span></p>
                    <form action="./demandeur-code-verification.php" method="post" id="email_verification_form">
                        <input type="text" id="code_verification_email" name="code_verification" placeholder="Code de vérification">
                        <h4></h4>
                        <input type="hidden" name="id_user" id="id_user_email">
                        <input type="submit" value="Vérifier">
                    </form>
                </div>
                <div class="mobile-confirmation">
                    <h3>Mobile confirmation</h3>
                    <p>Un code de vérification a été envoyé par SMS à votre numéro <span></span></p>
                    <form action="./demandeur-code-verification.php" method="post" id="mobile_verification_form">
                        <input type="text" id="code_verification_tlph" name="code_verification" placeholder="Code de vérification">
                        <h4></h4>
                        <input type="hidden" name="id_user" id="id_user_mobile">
                        <input type="submit" value="Vérifier">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="./css-js/main.js"></script>
    <script>
        var windowWidth = window.innerWidth;
        if (windowWidth <= 768) {
            $(".navbar-menu").css('display','none');
            $(".navbar").css('height','60px');
            $('body').css('overflowY','hidden');
            $('.inscription-connexion-animation').css('width','100%');
        }
        var modifyProfileButton = document.querySelector('#modify_profile_button');
        var modifyProfile = document.querySelector('#modify_profile');

        modifyProfileButton.addEventListener('click',()=>{
            window.location = './utilisateur.php?modifier-profile';
        });

        modifyProfile.addEventListener('click',()=>{
            window.location = './utilisateur.php?modifier-profile';
        });

        function validateEmail(email) {
            var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
            return re.test(email);
        }
        function validatePhone(phone) {
            var re = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;
            return re.test(phone);
        }

        $('#inscrire').click(function(event){
            event.preventDefault(); 
            var nomUser = $('#nom_user').val();
            var emailTlphUser = $('#email_tlph_user').val();
            var mtpUser = $('#mtp_user').val();
            var cnfrmMtpUser = $('#cnfrm_mtp_user').val();

            if (nomUser == '') {
                $('#nom_err').text("Entrez un nom d'utilisateur.");
            }
            else if (emailTlphUser == '') {
                $('#nom_err').text("");
                $('#email_tlph_err').text("Entrez un numéro ou un email.");
            }
            else if(!validateEmail(emailTlphUser) && !validatePhone(emailTlphUser)){
                $('#nom_err').text("");
                $('#email_tlph_err').text("Entrez un numéro ou un email valide.");
            }
            else if (mtpUser == '') {
                $('#nom_err').text("");
                $('#email_tlph_err').text("");
                $('#mtp_err').text("Entrez un mot de passe.");
            }
            else if (cnfrmMtpUser == '') {
                $('#nom_err').text("");
                $('#email_tlph_err').text("");
                $('#mtp_err').text("");
                $('#cnfrm_mtp_err').text("Confirmez le mot de passe.");
            }
            else if (mtpUser != cnfrmMtpUser) {
                $('#nom_err').text("");
                $('#email_tlph_err').text("");
                $('#mtp_err').text("");
                $('#cnfrm_mtp_err').text("Erreur de confirmation du mot de passe.");
            }
            else if (mtpUser != '' && cnfrmMtpUser != '' && mtpUser == cnfrmMtpUser) {
                $("#inscription_form").submit();
            }
        })

        $("#inscription_form").submit(function(event){
            event.preventDefault(); 
            var post_url = $(this).attr("action"); 
            var request_method = $(this).attr("method");
            var form_data = $(this).serialize();
            
            $.ajax({
                url : post_url,
                type: request_method,
                data : form_data
            }).done(function(response){
                if (response == 2) {
                    $('#nom_err').text("");
                    $('#email_tlph_err').text("");
                    $('#mtp_err').text("");
                    $('#cnfrm_mtp_err').text("");

                    $('#nom_user').val("");
                    $('#email_tlph_user').val("");
                    $('#mtp_user').val("");
                    $('#cnfrm_mtp_user').val("");

                    $('#inscription_form')[0].reset();
                    $('.inscription-connexion-container h3').text('Vous avez déjà inscri, vous pouvez connecter');
                    $('.inscription-connexion-container h3').css('background','rgb(155, 250, 126)');
                }
                else if (response == 3) {
                    $('#nom_err').text("");
                    $('#email_tlph_err').text("");
                    $('#mtp_err').text("");
                    $('#cnfrm_mtp_err').text("");

                    $('#nom_user').val("");
                    $('#email_tlph_user').val("");
                    $('#mtp_user').val("");
                    $('#cnfrm_mtp_user').val("");

                    $('#inscription_form')[0].reset();
                    $('.inscription-connexion-container h3').text("Ce numéro de téléphone est deja inscri, entrer un nouveau.");
                    $('.inscription-connexion-container h3').css('background','red');
                }
                else if(response == 0){
                    $('#nom_err').text("");
                    $('#email_tlph_err').text("");
                    $('#mtp_err').text("");
                    $('#cnfrm_mtp_err').text("");

                    $('#nom_user').val("");
                    $('#email_tlph_user').val("");
                    $('#mtp_user').val("");
                    $('#cnfrm_mtp_user').val("");

                    $('.inscription-connexion-container h3').text("Erreur d'inscription");
                    $('.inscription-connexion-container h3').css('background','red');
                }
                else{
                    $('#nom_err').text("");
                    $('#email_tlph_err').text("");
                    $('#mtp_err').text("");
                    $('#cnfrm_mtp_err').text("");

                    $('#nom_user').val("");
                    $('#email_tlph_user').val("");
                    $('#mtp_user').val("");
                    $('#cnfrm_mtp_user').val("");
                    
                    var spaceChar = response.indexOf('(');
                    var id_user = response.substring(0,spaceChar);
                    var email_user = response.substring(spaceChar);
                    var id = email_user.split("(")[1];

                    if (validateEmail(id)) {
                        $('.mobile-confirmation').hide();
                        $('#id_user_email').val(id_user);
                        $('.email-confirmation span').text("("+id+")");
                    }
                    else{
                        $('.email-confirmation').hide();
                        $('#id_user_mobile').val(id_user);
                        $('.mobile-confirmation span').text("("+id+")");
                    }
                    $('#inscription_form')[0].reset();
                    $('.inscription-connexion-responsive').css('transform','translateX(-100%)');
                    $('.mobile-email-confirmation-container').css('transform','translateX(-100%)');
                }
            });
        });

        $("#email_verification_form").submit(function(event){
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
                    $('#email_verification_form')[0].reset();
                    $('#mobile_verification_form')[0].reset();
                    window.location.href = 'demande-emploie.php';
                }
                else{
                    $('.email-confirmation h4').text("Code de vérification invalide, réessayer.");
                }
            });
        });

        $("#mobile_verification_form").submit(function(event){
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
                    $('#email_verification_form')[0].reset();
                    $('#mobile_verification_form')[0].reset();
                    window.location.href = 'utilisateur.php';
                }
                else{
                    $('.email-confirmation h4').text("Code de vérification invalide, réessayer.");
                }
            });
        });
        
    </script>
</body>
</html>