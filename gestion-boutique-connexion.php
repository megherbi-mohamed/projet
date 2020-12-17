<?php 
// session_start();
include_once './bdd/connexion.php';
// if (!empty($_SESSION['btq'])) {
//     header('Location: gerer-boutique/'.$_SESSION['btq']);
//     exit;
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css-js/style.css">
    <link rel="stylesheet" href="./css-js/gestion-boutique-connexion.css">
    <link href="./css-js/fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fugaz One">
    <title>Gestion boutique</title>
</head>
<body>
<?php include './navbar.php';?>
    <div class="clear"></div>
    <div class="gb-connexion-container">
        <h3></h3>
        <div class="gb-connexion">
            <h4>Connexion au gestionnaire boutique</h4>
            <div>
                <span class="cnx-id-btq">Identifiant</span>
                <input type="text" id="cnx_id_btq">
            </div>
            <div>
                <span class="cnx-mtp-btq">Mot de passe</span>
                <input type="password" id="cnx_mtp_btq">
            </div>
            <a href="#">Mot de passe oublié ?</a> 
            <div class="create-publication-bottom-button">
                <div id="loader_create_publication_bottom_button" style="margin-top:5px" class="button-center"></div>
                <button id="connexion_gb_button">Connecter</button>
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

        $(document).on('focus','.gb-connexion input',function(){
            var id = $(this).attr('id');
            if (id == 'cnx_id_btq') {
                $('.cnx-id-btq').addClass('active-gb-connexion-span');
            }
            if (id == 'cnx_mtp_btq') {
                $('.cnx-mtp-btq').addClass('active-gb-connexion-span');
            }
        })

        $(document).on('click','#connexion_gb_button',function(e){
            var matriculeBtq = $('#cnx_id_btq').val();
            var mtpBtq = $('#cnx_mtp_btq').val();
            if (matriculeBtq == '') {
                $('#cnx_id_btq').css('border','2px solid red');
            }
            else if (mtpBtq == '') {
                $('#cnx_id_btq').css('border','');
                $('#cnx_mtp_btq').css('border','2px solid red');
            }
            else{
                var fd = new FormData();
                fd.append('matricule_adm',matriculeBtq);
                fd.append('mtp_adm',mtpBtq);
                $.ajax({
                    url: 'connexion-admin-boutique.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $("#loader_create_publication_bottom_button").show();
                    },
                    success: function(response){
                        if(response == 0){
                            $('.alert-messages p').text('Erreur de connexion.');
                            $('.alert-messages').css({'visibility':'visible','transform':'translate(-50%,70px)'});
                            setTimeout(() => {
                                $('.alert-messages').css({'visibility':'','transform':''});
                            }, 4000);
                        }
                        if (response == 2) {
                            $('.alert-messages p').text("Identification incorrect.");
                            $('.alert-messages').css({'visibility':'visible','transform':'translate(-50%,70px)'});
                            setTimeout(() => {
                                $('.alert-messages').css({'visibility':'','transform':''});
                            }, 4000);
                        }
                        else {
                            window.location.href = "gerer-boutique/"+response;
                        }
                    },
                    complete: function(){
                        $("#loader_create_publication_bottom_button").hide();
                    }
                });
            }
        })
    </script>
</body>
</html>