<?php 
session_start();
include_once './bdd/connexion.php';
if (isset($_SESSION['user'])) {
    $id_session = htmlspecialchars($_SESSION['user']);
    $get_session_id_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
    $get_session_id_query->execute();
    $get_session_id_row = $get_session_id_query->fetch(PDO::FETCH_ASSOC);
    $user_session_query = $conn->prepare("SELECT * FROM utilisateurs WHERE id_user = {$get_session_id_row['id_user']}");
    $user_session_query->execute();
    if ($user_session_query->rowCount() > 0) {
        $row = $user_session_query->fetch(PDO::FETCH_ASSOC);
        $uid = $id_session;
        $id_user = $row['id_user'];
    }
    else {
        header('Location: inscription-connexion.php');
    }
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
    <link rel="stylesheet" href="css-js/index.css">
    <link href="css-js/fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fugaz One">
    <title>Nhannik | Acceuil</title>
</head>
<body>
    <?php include './navbar.php'; ?>
    <div class="clear"></div>
    <div class="acceuil-presentation">

    </div>
    <div class="acceuil-categories">
        <div class="acceuil-categorie">

        </div>
        <div class="acceuil-categorie">
            
        </div>
        <div class="acceuil-categorie">
            
        </div>
        <div class="acceuil-categorie">
            
        </div>
        <div class="acceuil-categorie">
            
        </div>
        <div class="acceuil-categorie">
            
        </div>
        <div class="acceuil-categorie">
            
        </div>
        <div class="acceuil-categorie">
            
        </div>
        <div class="acceuil-categorie">
            
        </div>
    </div>
    <div class="acceuil-sous-categories">
        <div class="acceuil-sous-categorie-left">
            <div class="acceuil-sous-categorie">
            
            </div>
            <div class="acceuil-sous-categorie">
                
            </div>
            <div class="acceuil-sous-categorie">
                
            </div>
            <div class="acceuil-sous-categorie">
                
            </div>
            <div class="acceuil-sous-categorie">
            
            </div>
            <div class="acceuil-sous-categorie">
            
            </div>
            <div class="acceuil-sous-categorie">
            
            </div>
            <div class="acceuil-sous-categorie">
            
            </div>
            <div class="acceuil-sous-categorie">
            
            </div>
        </div>
        <div class="acceuil-sous-categorie-right">
            <div>
                <i class="fas fa-times"></i>
            </div>
        </div>
    </div>
    <div class="acceuil-publicites">

    </div>
    <div class="acceuil-boutiques">
        <div class="acceuil-overview-title">
            <div class="acceuil-overview-title-top">
                <div>
                    <i class="fas fa-store-alt"></i>
                </div>
                <h3>Boutiques</h3>
            </div>
            <a href="">Voir Plus</a>
        </div>
        <div class="acceuil-all-boutiques">
            <div class="acceuil-boutique">
                <div class="acceuil-boutique-couverture">

                </div>
                <div class="acceuil-boutique-logo">

                </div>
                <div class="acceuil-boutique-description">
                    <h4>Boutique 1</h4>
                    <p>Lorem ipsum dolor sit amet.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="acceuil-professionnels">
        <div class="acceuil-overview-title">
            <div class="acceuil-overview-title-top">
                <div>
                    <i class="fas fa-user"></i>
                </div>
                <h3>Professionnel - entreprises</h3>
            </div>
            <a href="">Voir Plus</a>
        </div>
        <div class="acceuil-all-professionnels">
            <div class="acceuil-professionnel">
                <div class="acceuil-professionnel-couverture">

                </div>
                <div class="acceuil-professionnel-logo">

                </div>
                <div class="acceuil-professionnel-description">
                    <h4>Boutique 1</h4>
                    <p>Lorem ipsum dolor sit amet.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="acceuil-products">
        <div class="acceuil-overview-title">
            <div class="acceuil-overview-title-top">
                <div>
                    <i class="fas fa-boxes"></i>
                </div>
                <h3>Produits boutiques</h3>
            </div>
            <a href="">Voir Plus</a>
        </div>
        <div class="acceuil-all-products">
            <div class="acceuil-product">
                <div class="acceuil-product-image">

                </div>
                <div class="acceuil-product-descirption">
                    <p>1200 da</p>
                </div>
            </div>
            <div class="acceuil-product">
                <div class="acceuil-product-image">

                </div>
                <div class="acceuil-product-descirption">
                    <p>1200 da</p>
                </div>
            </div>
            <div class="acceuil-product">
                <div class="acceuil-product-image">

                </div>
                <div class="acceuil-product-descirption">
                    <p>1200 da</p>
                </div>
            </div>
        </div>
    </div>
    <div class="acceuil-boutdechantiers">
        <div class="acceuil-overview-title">
            <div class="acceuil-overview-title-top">
                <div>
                    <i class="fas fa-store"></i>
                </div>
                <h3>Produits boutdechantier</h3>
            </div>
            <a href="">Voir Plus</a>
        </div>
        <div class="acceuil-all-boutdechantiers">
            <div class="acceuil-boutdechantier">
                <div class="acceuil-boutdechantier-image">

                </div>
                <div class="acceuil-boutdechantier-descirption">
                    <p>1200 da</p>
                </div>
            </div>
        </div>
    </div>
    <div id="loader" class="center"></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="css-js/main.js"></script>
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

        $('.acceuil-categorie').on('click',function(){
            $('body').addClass('body-after');
            $('.acceuil-sous-categories').css('display','grid');
        })

        <?php if (isset($_SESSION['user'])) { ?>
        var uid = <?php echo $uid; ?>;
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