<?php 
session_start();
include_once './bdd/connexion.php';
if (isset($_SESSION['user'])) {
    $cnx_user_query = "SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['user'];
    $result = mysqli_query($conn, $cnx_user_query);
    $row = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css-js/style.css">
    <link rel="stylesheet" href="./css-js/evenements.css">
    <link href="./css-js/fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fugaz One">
    <title>Evenements</title>
</head>
<body>
    <?php include './navbar.php'; ?>
    <?php if (isset($_SESSION['user'])) { ?>
        <input type="hidden" id="session" value="1">
        <div class="clear-session"></div>
    <?php }else{ ?>
        <input type="hidden" id="session" value="0">
        <div class="clear"></div>
    <?php } ?>
    <div class="responsive-container">
        <?php if (isset($_SESSION['user']) && $width <= 768) { ?>
        <div class="search-evenement">
        <?php }else{ ?>
        <div class="search-evenement" style="top:40px">
        <?php } ?>
            <div class="search-bar-evenement">
                <form action="./evenements.php" method="post">
                    <input type="text" name="recherche_text" placeholder="Checher un evenement">
                    <button type="submit" name="rechercher"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <div class="filter-date">
                <input type="date" name="date-debut">
                <input type="date" name="date-fin">
            </div>
        </div>
        <div class="evenements-list">
            <div class="evenement-information">
                <img src="./images/logo.png" alt="">
                <h5>01. fevrier 2020 au 20. fevrier 2020</h5>
                <h4>Titre d'evenement</h4>
                <p>Le lieu</p>
                <h4>Public</h4>
                <h3>Ville</h3>
                <h3>Pays</h3>
                <input type="submit" name="voir-evnmnt" value="Details ..">
            </div>
            <div class="evenement-information">
                <img src="./images/logo.png" alt="">
                <h5>01. fevrier 2020 au 20. fevrier 2020</h5>
                <h4>Titre d'evenement</h4>
                <p>Le lieu</p>
                <h4>Public</h4>
                <h3>Ville</h3>
                <h3>Pays</h3>
                <input type="submit" name="voir-evnmnt" value="Details ..">
            </div>
            <div class="evenement-information">
                <img src="./images/logo.png" alt="">
                <h5>01. fevrier 2020 au 20. fevrier 2020</h5>
                <h4>Titre d'evenement</h4>
                <p>Le lieu</p>
                <h4>Public</h4>
                <h3>Ville</h3>
                <h3>Pays</h3>
                <input type="submit" name="voir-evnmnt" value="Details ..">
            </div>
            <div class="evenement-information">
                <img src="./images/logo.png" alt="">
                <h5>01. fevrier 2020 au 20. fevrier 2020</h5>
                <h4>Titre d'evenement</h4>
                <p>Le lieu</p>
                <h4>Public</h4>
                <h3>Ville</h3>
                <h3>Pays</h3>
                <input type="submit" name="voir-evnmnt" value="Details ..">
            </div>
        </div>
        <div class="clear-responsive"></div>
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
            <a href="./inscription-connexion.html">Inscrire/Connecter</a>
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
                $('.navbar').height(40);
                $('.clear').css('height','40px');
            }
        }
        else{
            $('.clear-session').css('height','60px');
        }
        
    </script>
</body>
</html>