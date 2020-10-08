<?php 
session_start();
include_once './bdd/connexion.php';
if (isset($_SESSION['user'])) {
    $cnx_user_query = $conn->prepare("SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['user']);
    $cnx_user_query->execute();
    $row = $cnx_user_query->fetch(PDO::FETCH_ASSOC);
    $id_user = $row['id_user'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css-js/style.css">
    <link rel="stylesheet" href="./css-js/index.css">
    <link href="./css-js/fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fugaz One">
    <title>Nhannik | Acceuil</title>
</head>
<body>
    <?php include './navbar.php';
    if (isset($_SESSION['user'])) { ?>
        <input type="hidden" id="session" value="1">
        <div id="session" class="clear-session"></div>
    <?php }else{ ?>
        <input type="hidden" id="session" value="0">
        <div class="clear"></div>
    <?php } ?>
    <div class="responsive-container">
        <div class="carousel">
            <img src="./images/background.png" alt="background">
            <img src="" alt="">
            <img src="" alt="">
        </div>
        <div class="titre">
            <hr><p>Meilleurs entreprises</p><hr>
        </div>
        <div class="entreprises">
            <div class="entreprises-container">
                <div class="entreprise-description">
                    <img src="./images/logo.png" alt="entreprise-1">
                    <div class="entrp-dscrp">
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Illum magnam et libero, earum quidem obcaecati 
                            repellat harum nesciunt saepe tempora!</p>
                        <a href="#">Voire Plus ..</a>
                    </div>
                </div>
                <div class="entreprise-description">
                    <img src="./images/logo.png" alt="entreprise-1">
                    <div class="entrp-dscrp">
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Illum magnam et libero, earum quidem obcaecati 
                            repellat harum nesciunt saepe tempora!</p>
                        <a href="#">Voire Plus ..</a>
                    </div>
                </div>
                <div class="entreprise-description">
                    <img src="./images/logo.png" alt="entreprise-1">
                    <div class="entrp-dscrp">
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Illum magnam et libero, earum quidem obcaecati 
                            repellat harum nesciunt saepe tempora!</p>
                        <a href="#">Voire Plus ..</a>
                    </div>
                </div>
                <div class="entreprise-description">
                    <img src="./images/logo.png" alt="entreprise-1">
                    <div class="entrp-dscrp">
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Illum magnam et libero, earum quidem obcaecati 
                            repellat harum nesciunt saepe tempora!</p>
                        <a href="#">Voire Plus ..</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="clear"></div>
        <div class="clear-responsive"></div>
        <div class="titre">
            <hr><p>produits/services en promotions</p><hr>
        </div>
        <div class="clear"></div>
        <!-- <div class="clear-responsive"></div> -->
        <div class="produits-services-promotions">
            <div class="produits-services-promotions-container">
                <!-- <form action="./function.php" method="get">  -->
                    <div class="produit-service">
                        <img src="./images/logo.png" alt="entreprise-1">
                        <p>Description - profession</p>
                        <input type="submit" role="button" value="Voir Plus ..">
                    </div>
                    <div class="produit-service">
                        <img src="./images/logo.png" alt="entreprise-1">
                        <p>Description - profession</p>
                        <input type="submit" role="button" value="Voir Plus ..">
                    </div>
                    <div class="produit-service">
                        <img src="./images/logo.png" alt="entreprise-1">
                        <p>Description - profession</p>
                        <input type="submit" role="button" value="Voir Plus ..">
                    </div>
                    <div class="produit-service">
                        <img src="./images/logo.png" alt="entreprise-1">
                        <p>Description - profession</p>
                        <input type="submit" role="button" value="Voir Plus ..">
                    </div>
                    <div class="produit-service">
                        <img src="./images/logo.png" alt="entreprise-1">
                        <p>Description - profession</p>
                        <input type="submit" role="button" value="Voir Plus ..">
                    </div>
                    <div class="produit-service">
                        <img src="./images/logo.png" alt="entreprise-1">
                        <p>Description - profession</p>
                        <input type="submit" role="button" value="Voir Plus ..">
                    </div>
                <!-- </form> -->
            </div>
        </div>
        <div class="clear"></div>
        <div class="clear"></div>
        <div class="clear-responsive"></div>
        <div class="titre">
            <hr><p>les évenements</p><hr>
        </div>
        <div class="clear-responsive"></div>
        <div class="clear"></div>
        <div class="evenements">
            <div class="evenements-container">
                <div class="evenement-description">
                    <div class="evnmnt-dscrp">
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Hic veniam facilis illum dolore in nesciunt
                            quos recusandae est voluptate fugit.Lorem ipsum dolor sit, amet consectetur adipisicing elit. Hic veniam 
                            facilis illum dolore in nesciunt quos recusandae est voluptate fugit.</p>
                        <img src="./images/logo.png" alt="evenement">
                    </div>
                    <div class="evnmnt-imgs">
                        <img src="./images/logo.png" alt="">
                        <img src="./images/logo.png" alt="">
                        <img src="./images/logo.png" alt="">
                        <img src="./images/logo.png" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="clear"></div>
        <div class="titre">
            <hr><p>les familles de métiers</p><hr>
        </div>
        <div class="clear"></div>
        <div class="familles">
            <div class="familles-container">
                <div class="famille">
                    <img src="./images/profile.jpg" alt="profile">
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quisquam, assumenda.</p>
                </div>
                <div class="famille">
                    <img src="./images/profile.jpg" alt="profile">
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quisquam, assumenda.</p>
                </div>
                <div class="famille">
                    <img src="./images/profile.jpg" alt="profile">
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quisquam, assumenda.</p>
                </div>
                <div class="famille">
                    <img src="./images/profile.jpg" alt="profile">
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quisquam, assumenda.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="footer">
        <img src="./images/logo.png" alt="logo">
        <div class="newsletter-droit">
            <div class="newsletter">
                <input type="email" placeholder="Entrez votre e-mail">
                <input type="submit" value="Submit">
            </div>
            <p>Copyright &copy; SiteWeb 2020</p>
        </div>
        <div class="footer-navbar">
            <a href="./index.html">acceuil</a>
            <a href="#">promotions</a>
            <a href="#">évènements</a>
            <a href="#">recrutement</a>
            <a class="last-child" href="./inscription-connexion.html">Inscrire/Connecter</a>
        </div>
    </div>
    <div id="loader" class="center"></div>
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

        var windowWidth = window.innerWidth;
        if (windowWidth <= 768) {
            $('.footer').css('display','none');
            var session = $('#session').val();
            if (session == 0) {
                // $('.navbar').height(40);
                // $('.clear').css('height','40px');
            }
        }
        else{
            // $('.clear-session').css('height','60px');
        }

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