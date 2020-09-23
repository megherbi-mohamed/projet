<?php 
session_start();
include_once './bdd/connexion.php';
if (isset($_SESSION['user'])) {
    $cnx_user_query = "SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['user'];
    $result = mysqli_query($conn, $cnx_user_query);
    $row = mysqli_fetch_assoc($result);
    $id_user = $row['id_user'];
}

$btq_inf_query = "SELECT * FROM boutiques WHERE id_btq = {$_GET['btq']}";
$btq_inf_result = mysqli_query($conn, $btq_inf_query);
$btq_inf_row = mysqli_fetch_assoc($btq_inf_result);
$id_createur = $btq_inf_row['id_createur'];

$btq_crtr_query = "SELECT img_user,nom_user FROM utilisateurs WHERE id_user = '$id_createur'";
$btq_crtr_result = mysqli_query($conn, $btq_crtr_query);
$btq_crtr_row = mysqli_fetch_assoc($btq_crtr_result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css-js/style.css">
    <link rel="stylesheet" href="./css-js/boutique.css">
    <link rel="stylesheet" href="./css-js/croppie.css">
    <link href="./css-js/fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fugaz One">
    <title>Boutique</title>
</head>
<body>
    <?php include './navbar.php'; ?>
    <div class="clear"></div>
    <div class="boutique-container">
        <div class="boutique-top">
            <div class="boutique-couverture-logo">
                <div class="boutique-couverture">
                <?php if ($btq_inf_row['couverture_btq'] != '') { ?>
                    <img id="couverture_img" src="./<?php echo $btq_inf_row['couverture_btq'] ?>" alt="">
                <?php }else if($btq_inf_row['couverture_btq'] == ''){ ?>
                    <img id="couverture_img" src="./boutique-couverture/couverture.png" alt="">
                <?php } ?>
                </div>
                <div class="boutique-logo">
                <?php if ($btq_inf_row['logo_btq'] != '') { ?>
                    <img src="./<?php echo $btq_inf_row['logo_btq'] ?>" alt="">
                <?php }else if($btq_inf_row['logo_btq'] == ''){ ?>
                    <img src="./boutique-logo/logo.png" alt="">
                <?php } ?>
                </div>
            </div>
            <div class="boutique-options">
                <div class="boutique-name">
                    <h3><?php echo $btq_inf_row['nom_btq'] ?></h3>
                </div>
                <!-- <hr> -->
                <div class="boutique-option">
                    <?php if (isset($_SESSION['user']) && $_SESSION['user'] !== $btq_inf_row['id_createur']) { ?>
                    <div id="follow_button">
                        <i class="fas fa-user-plus"></i>
                        <p>Abonner-vous</p>
                    </div>
                    <div id="message_button">
                        <i class="fab fa-facebook-messenger"></i>
                        <p>Envoyer un message</p>
                    </div>
                    <?php } ?>
                    <div>
                        <input type="text" id="product_search_text" placeholder="Chercher votre produit" autocomplete="off">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="categrie_button">
                        <i class="fas fa-list"></i>
                    </div>
                    <div class="filter_button">
                        <i class="fas fa-filter"></i>   
                    </div>
                </div>
            </div>
        </div>
        <div class="boutique-bottom">

        </div>
    </div>
    <div id="loader" class="center"></div>
    <!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBEGrApnjX_7GHcNDtF0LR0pgrwxj5j2Q&callback=initBoutiqueMap"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="./css-js/main.js"></script>
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