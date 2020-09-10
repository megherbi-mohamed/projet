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
    <div class="inscription-connexion-animation">
        <div class="inscription-connexion-responsive">
            <div class="inscription-connexion-container">
                <h3></h3>
                <div class="inscription-container">
                    <div class="inscription">
                        <form action="./inscription.php" method="post" id="inscription_form">
                            <h4>inscrivez-vous</h4>
                            <div>
                                <input type="text" id="nom_user" name="nom_user" autocomplete="offre" placeholder="Entrez le nom d'utilisateur">
                                <p id="nom_err"></p>
                            </div>
                            <div>
                                <input type="text" id="email_tlph_user" name="email_tlph_user" placeholder="Email ou numéro de téléphone">
                                <p id="email_tlph_err"></p>
                            </div>
                            <div>
                                <input type="password" id="mtp_user" name="mtp_user" placeholder="Entrez votre mot de passe">
                                <p id="mtp_err"></p>
                            </div>
                            <div>
                                <input type="password" id="cnfrm_mtp_user" name="cnfrm_mtp_user" placeholder="Confirmez votre mot de passe">
                                <p id="cnfrm_mtp_err"></p>
                            </div>
                            <input type="hidden" name="type_user" value="">
                            <input type="submit" id="inscrire" value="inscrire">
                        </form>
                        <h5>Vous avez déjà inscris ?
                        <button id="connexion_button">Connexion</button></h5>
                    </div>
                </div>
                <div class="connexion-container">
                    <div class="connexion">
                    <form action="./connexion.php" method="post" id="connexion_form">
                        <h4>connectez-vous</h4>
                        <div>
                            <i class="fa fa-envelope"></i>
                            <input type="text" id="cnx_email_user" name="email_user" placeholder="Email ou numéro téléphone">
                            <p id="cnx_email_err"></p>
                        </div>
                        <div style="padding-bottom:5px">
                            <i class="fa fa-lock"></i>
                            <input type="password" id="cnx_mtp_user" name="mtp_user" placeholder="Mot de passe">
                            <p id="cnx_mtp_err"></p>
                        </div>
                        <a href="#">Mot de passe oublié ?</a>
                        <input type="submit" id="connecter" value="Connecter">
                    </form>
                        <h5>Vous avez pas encore inscrire ?
                        <button id="inscription_button">Inscrire</button></h5>
                    </div>
                </div>
            </div>
        </div>
        <!-- Un code de vérification a été envoyé sur votre adresse e-mail -->
        <div class="mobile-email-confirmation-container">
            <div class="mobile-email-confirmation">
                <div class="email-confirmation">
                    <h3>Email confirmation</h3>
                    <p>Un code de vérification a été envoyé à votre adresse e-mail <span></span></p>
                    <form action="./code-verification.php" method="post" id="email_verification_form">
                        <input type="text" id="code_verification_email" name="code_verification" placeholder="Code de vérification">
                        <h4></h4>
                        <input type="hidden" name="id_user" id="id_user_email">
                        <input type="submit" value="Vérifier">
                    </form>
                </div>
                <div class="mobile-confirmation">
                    <h3>Mobile confirmation</h3>
                    <p>Un code de vérification a été envoyé par SMS à votre numéro <span></span></p>
                    <form action="./code-verification.php" method="post" id="mobile_verification_form">
                        <input type="text" id="code_verification_tlph" name="code_verification" placeholder="Code de vérification">
                        <h4></h4>
                        <input type="hidden" name="id_user" id="id_user_mobile">
                        <input type="submit" value="Vérifier">
                    </form>
                </div>
            </div>
        </div>
        <div class="inscription-details-container">
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
                    <input type="hidden" id="id_user_final" name="id_user">
                    <input type="hidden" id="type_user_final" name="typ_user">
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
        </div>
        <form action="./delete-user-inscription.php" method="post" id="delete_user_form">
            <input type="hidden" id="id_delete_user" name="id_user">
            <input type="submit" id="delete_user_btn">
        </form>
    </div>
    <div id="loader" class="center"></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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

        var windowWidth = window.innerWidth;
        if (windowWidth <= 768) {
            $(".navbar-menu").css('display','none');
            $(".navbar").height(40);
            $(".clear").height(40);

            $('#show_search_bar_rsp').click(function(){
                $('.categorie-search-bar').css('transform','translateX(0)');
                $('body').addClass('body-after');
            })

            $('.categorie-search-bar-bottom').click(function(){
                $('.categorie-search-bar').css('transform','');
                $('body').removeClass('body-after');
            });
        }

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

        // var hideMenuRight = document.querySelector('.hide-menu-right');
        // hideMenuRight.addEventListener('click',()=>{
        //     hideMenu.style.transform = '';
        //     showHideMenuButton.style.display = '';
        //     hideMenuButton.style.display = '';
        // })

        // var showHideMenuButton = document.querySelector('#show_hide_menu');
        // var hideMenuButton = document.querySelector('#hide_hide_menu');
        // var hideMenu = document.querySelector('.hide-menu');
        // var hideMenuRight = document.querySelector('.hide-menu-right');

        // showHideMenuButton.addEventListener('click',()=>{
        //     hideMenu.style.transform = 'translateX(0)';
        //     showHideMenuButton.style.display = 'none';
        //     hideMenuButton.style.display = 'block';
        //     $('.logo i').hide();
        //     $('.logo img').hide();
        //     $('.navbar').css('z-index','50');
        //     $('.categorie-search-bar').css('transform','');
        //     $('body').addClass('body-after');
        // })
        // hideMenuButton.addEventListener('click',()=>{
        //     hideMenu.style.transform = '';
        //     hideMenuButton.style.display = '';
        //     showHideMenuButton.style.display = '';
        //     $('.navbar').css('z-index','');
        //     $('.logo i').show();
        //     $('.logo img').show();
        //     $('body').removeClass('body-after');
        // })
        // hideMenuRight.addEventListener('click',()=>{
        //     hideMenu.style.transform = '';
        //     showHideMenuButton.style.display = '';
        //     hideMenuButton.style.display = '';
        //     $('.navbar').css('z-index','');
        //     $('.logo i').show();
        //     $('.logo img').show();
        //     $('body').removeClass('body-after');
        // })

        $('.show-hide-menu').click(function(){
            $('.hide-menu').css('transform','translateX(0)');
        });

        $(document).on('keypress',"#categorie_search",function() {
            if (event.which == 13) {
                $("#categorie_search_btn").click();
            }
        });

        $('#categorie_search_btn').click(function(){
            var rechercheText = $('#categorie_search').val();
            window.location = 'recherche.php?r='+rechercheText;
        });

        $('#show_search_bar').click(function(){
            $('.categorie-search-bar').css('transform','translateX(0)');
        })

        $('#cancel_search_bar').click(function(){
            $('.categorie-search-bar').css('transform','');
        })

        var promotionsButton = document.querySelector('#promotions_button');
        var homeButton = document.querySelector('#home_button');
        var evenementsButton = document.querySelector('#evenements_button');
        var demandeOffreButton = document.querySelector('#demande_offre_button');
        var ajouterEvenementButton = document.querySelector('#ajouter_evenement_button');
        var createGroupeButton = document.querySelector('#create_groupe_button');

        promotionsButton.addEventListener('click',()=>{
            window.location = './promotions.php';
        })
        evenementsButton.addEventListener('click',()=>{
            window.location = './evenements.php';
        })
        homeButton.addEventListener('click',()=>{
            window.location = './index.php';
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
                    $('h3').text('Vous avez déjà inscri, vous pouvez connecter');
                    $('h3').css('background','rgb(155, 250, 126)');
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

                    $('h3').text("Erreur d'inscription");
                    $('h3').css('background','red');
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
                    
                    $('#id_delete_user').val(id_user);

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
                    $('#id_user_final').val(response);
                    $('.inscription-connexion-responsive').css('transform','translateX(-300%)');
                    $('.mobile-email-confirmation-container').css('transform','translateX(-200%)');
                    $('.inscription-details-container').css('transform','translateX(-200%)');
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
                    $('#id_user_final').val(response);
                    $('.inscription-connexion-responsive').css('transform','translateX(-300%)');
                    $('.mobile-email-confirmation-container').css('transform','translateX(-200%)');
                    $('.inscription-details-container').css('transform','translateX(-200%)');
                }
                else{
                    $('.mobile-confirmation h4').text("Code de vérification invalide, réessayer.");
                }
            });
        });

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
            event.preventDefault(); 
            var emailUserCnx = $('#cnx_email_user').val();
            var mtpUserCnx = $('#cnx_mtp_user').val();
            
            if (emailUserCnx == '') {
                $('#cnx_email_err').text("Entrez votre email.");
            }
            else if (mtpUserCnx == '') {
                $('#cnx_email_err').text("");
                $('#cnx_mtp_err').text("Entrez votre mot de passe.");
            }
            else if (!validateEmail(emailUserCnx) && !validatePhone(emailUserCnx)) {
                $('.inscription-connexion-container h3').text("format de numéro ou email incorrecte.");
                $('h3').css('background','red');
            }
            else{
                $("#connexion_form").submit();
            }
        });

        $("#connexion_form").submit(function(event){
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
                    window.location.href = 'utilisateur.php';
                }
                else{
                    $("#connexion_form")[0].reset();
                    $('.inscription-connexion-container h3').text("Votre numéro ou mot de passe est incorrecte.");
                    $('h3').css('background','red');
                }
            });
                
        });

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