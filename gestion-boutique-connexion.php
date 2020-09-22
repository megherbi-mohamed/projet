<?php 
session_start();
if (!empty( $_SESSION['btq'])) {
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
                <input type="text" id="cnx_id_btq" name="id_btq">
                <p id="cnx_id_err"></p>
            </div>
            <div>
                <span class="cnx-mtp-btq">Mot de passe</span>
                <input type="password" id="cnx_mtp_btq" name="mtp_btq">
                <p id="cnx_mtp_err"></p>
            </div>
            <a href="#">Mot de passe oublié ?</a> 
            <button id="connexion_gb_button">Connecter</button></h5>
        </div>
        <div id="loader_cnx_btq" class="center"></div>
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
            var fd = new FormData();
            var matriculeBtq = $('#cnx_id_btq').val();
            fd.append('matricule_adm',matriculeBtq);
            var mtpBtq = $('#cnx_mtp_btq').val();
            fd.append('mtp_adm',mtpBtq);
            $.ajax({
                url: 'connexion-admin-boutique.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $('.gb-connexion-container').css('opacity','0.4');
                    $("#loader_cnx_btq").show();
                },
                success: function(response){
                    if(response == 1){
                        console.log('matricule incoorect');
                    }
                    else if(response == 2){
                        console.log('mtp incorrect');
                    }
                    else if(response == 0){
                        console.log('compte existe plus');
                    }
                    else{
                        window.location.href = "./gerer-boutique.php?btq="+response;
                    }
                },
                complete: function(){
                    $('.gb-connexion-container').css('opacity','');
                    $("#loader_cnx_btq").hide();
                }
            });
        })

    </script>
</body>
</html>