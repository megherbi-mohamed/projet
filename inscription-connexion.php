
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
                    <span class="nom-user">Nom d'utilisateur</span>
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
    <!-- <div class="inscription-details-container">
        <div class="inscription-client-professionnel-final">
            <div class="close-final-inscription" id="close_final_inscription">
                <i class="fas fa-times"></i>
            </div>
            <div class="inscription-final-details">
                <div class="inscription-client-final-details">
                    <p>Aujourd'hui, il n'a jamais été aussi simple de trouver un pro 
                        des taches que monsieur tout le monde a besoin avec la plate forme N’HANIK.</p>
                    <p>Si  vous avez une petite mission à déléguer, faites tout simplement 
                        appel à N’HANIK  plutôt qu'à une grande enseigne spécialisée : bricolage, 
                        ménage, jardinage ou même déménagement, de nombreux partenaires ont 
                        du temps à revendre et toutes les compétences nécessaires pour venir à 
                        bout de votre corvée en un temps record et de manière efficace et professionnelle. 
                        Alors, pour tous vos petits traquas du quotidien, faites confiance a N’HANIK.</p>
                    <p>Non seulement vous pourrez donner à un particulier le complément de revenu qu'il 
                        mérite, mais vous pourrez aussi aider une micro-entreprise qui débute à développer 
                        sa notoriété. Et pour cela, rien de plus simple, choisissez la catégorie dans laquelle 
                        poster votre besoin et faites nous confiance  pour tout le reste, il réalisera votre 
                        mission en toute confiance et en toute sécurité !</p>
                    <p>N’HANIK  est la solution idéale pour tous vos besoins: plomberie, électricité…etc.</p>
                    <p>Réactivité à toute heure, professionnalisme des intervenants, super expérience client, bref, que du positif.</p>
                    <p>- Décrivez votre besoin.</p>
                    <p>- Des professionnels disponibles et compétents vous proposent leurs services.</p>
                    <p>- Evaluez et réglez votre prestataire une fois le job terminé.</p>
                </div>
                <div class="inscription-professionnel-final-details">
                    <h4>Vous êtes une entreprise ou artisan!</h4>
                    <p>Devenez partenaire de la plate forme N’HANIK, trouvez de nouveaux clients.</p>
                    <p>En créant votre profil ; sélectionnez vos compétences. Souscrivez à nos alertes jobs pour ne jamais rien manquer.</p>
                    <p>Proposez vos services : Faites des offres pour les jobs qui vous intéressent. Vous fixez vos propres tarifs. Vous êtes payé après la fin du job.</p>
                    <h4>Vous avez un volume de travail dépassant vos capacités!</h4>
                    <p>nous vous mettons en relation avec des partenaires et des collaborateurs en cas de besoin et nous nous chargerons de toute prospection en matériaux et équipements.</p>
                    <h4>Nous mettons a votre disposition une équipe qui vous:</h4>
                    <p>déchargera  des taches administratifs et autres qui risquent de vous faire perdre du temps précieux.</p>
                </div>   
            </div>
            <form action="./client-professionnel-inscription.php" method="post" id="final_inscription_form">
                <input type="hidden" id="id_user_final">
                <input type="hidden" id="type_user_final">
                <input type="submit" value="Valider">
            </form>
        </div>
        <div class="inscription-details-container-responsive">
            <div class="profession-inscription">
                <div class="inscription-profession-details">
                    <div class="inscription-avantages">
                        <img src="./icons/service-icon.png" alt="">
                    </div>
                    <button id="professionnel_inscription">Inscription professionnel</button>
                </div>
            </div>
            <div class="inscription-choice">
                <p>- OU -</p>
            </div>
            <div class="client-inscription">
                <div class="inscription-client-details">
                    <div class="inscription-avantages">
                        <img src="./icons/service-icon.png" alt="">
                    </div>
                    <button id="client_inscription">Inscription client</button>
                </div>
            </div>
        </div>
    </div> -->
    </div>
    <input type="hidden" id="id_user">
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
                                $('.email-confirmation input[type="text"]').focus();
                                $('.mobile-confirmation input[type="text"]').focus();
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
                            console.log(response);
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
                            console.log(response);
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
            $('#delete_user_btn').click();
        });

        $('#delete_user_btn').click(function(){
            $("#delete_user_form").submit();
        });

        $("#delete_user_form").submit(function(event){
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
                }
                else{
                }
            });
        });

        $('#professionnel_inscription').click(function(event){
            // event.preventDefault();
            var windowWidth = window.innerWidth;
            if (windowWidth <= 768) {
                $('.clear').height(10);
            }
            $('#type_user_final').val("professionnel");
            $('.navbar').css('z-index','50');
            $('body').addClass('body-after');
            $('.inscription-client-professionnel-final').show();
            $('.inscription-details-container-responsive').hide();
            $('.inscription-client-final-details').hide();
            $('.inscription-professionnel-final-details').show();
        });

        $('#client_inscription').click(function(event){
            // event.preventDefault(); 
            var windowWidth = window.innerWidth;
            if (windowWidth <= 768) {
                $('.clear').height(10);
            }
            $('#type_user_final').val("client");
            $('.navbar').css('z-index','50');
            $('body').addClass('body-after');
            $('.inscription-client-professionnel-final').show();
            $('.inscription-details-container-responsive').hide();
            $('.inscription-client-final-details').show();
            $('.inscription-professionnel-final-details').hide();
        });

        $('#close_final_inscription').click(function(event){
            // event.preventDefault(); 
            var windowWidth = window.innerWidth;
            if (windowWidth <= 768) {
                $('.clear').height(40);
            }
            $('.navbar').css('z-index','');
            $('#type_user_final').val("");
            $('body').removeClass('body-after');
            $('.inscription-client-professionnel-final').hide();
            $('.inscription-details-container-responsive').show();
        });

        $("#final_inscription_form").submit(function(event){
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
                    $('#final_inscription_form')[0].reset();
                    window.location.href = 'utilisateur.php';
                }
                else{
                    alert("err d'inscription");
                }
            });
        });

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

        // $("#connexion_form").submit(function(event){
        //     event.preventDefault(); 
        //     var post_url = $(this).attr("action"); 
        //     var request_method = $(this).attr("method");
        //     var form_data = $(this).serialize();
            
        //     $.ajax({
        //         url : post_url,
        //         type: request_method,
        //         data : form_data
        //     }).done(function(response){
        //         if (response != 0) {
        //             window.location.href = 'utilisateur.php';
        //         }
        //         else{
        //             $("#connexion_form")[0].reset();
        //             $('.inscription-connexion-container h3').text("Votre numéro ou mot de passe est incorrecte.");
        //             $('h3').css('background','red');
        //         }
        //     });
                
        // });

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

        