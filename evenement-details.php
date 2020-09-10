<?php 
    session_start();

    include_once './bdd/connexion.php';
    if (!isset($_SESSION['admin']) && !isset($_SESSION['sous-admin']) && !isset($_SESSION['user'])) {
        header("location: inscription-connexion.php");
    }else{
        if (isset($_SESSION['admin'])) {
            $cnx_user_query = "SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['admin'];
            $result = mysqli_query($conn, $cnx_user_query);
            $row = mysqli_fetch_assoc($result);
        }
        if (isset($_SESSION['sous-admin'])) {
            $cnx_user_query = "SELECT * FROM utilisateurs WHERE id_admin=".$_SESSION['sous-admin'];
            $result = mysqli_query($conn, $cnx_user_query);
            $row = mysqli_fetch_assoc($result);
        }
        if (isset($_SESSION['user'])) {
            $cnx_user_query = "SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['user'];
            $result = mysqli_query($conn, $cnx_user_query);
            $row = mysqli_fetch_assoc($result);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css-js/style.css">
    <link href="./css-js/fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <?php include './navbar.php'; ?>
    <div class="clear"></div>
    <div class="responsive-container">
        <div class="evenement-tout-details">
            <div class="evenement-left-description">
                <img src="./images/logo.png" alt="">
                <p>Date debut : 01. fevrier 2020</p>
                <p>date fin : 25. fevrier 2020</p>
                <p>Lieu</p>
            </div>
            <div class="evenement-middle-description">
                <h4>Titre d'evenement</h4>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. At minus, quidem, suscipit sint facilis dolorum odit ratione omnis qui eos aliquam eaque ut nesciunt ad explicabo illum unde, in voluptatum. Odio et non velit iure, error rerum adipisci tenetur quasi?</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. At minus, quidem, suscipit sint facilis dolorum odit ratione omnis qui eos aliquam eaque ut nesciunt ad explicabo illum unde, in voluptatum. Odio et non velit iure, error rerum adipisci tenetur quasi?</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. At minus, quidem, suscipit sint facilis dolorum odit ratione omnis qui eos aliquam eaque ut nesciunt ad explicabo illum unde, in voluptatum. Odio et non velit iure, error rerum adipisci tenetur quasi?</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. At minus, quidem, suscipit sint facilis dolorum odit ratione omnis qui eos aliquam eaque ut nesciunt ad explicabo illum unde, in voluptatum. Odio et non velit iure, error rerum adipisci tenetur quasi?</p>
                <div class="middle-description-images">
                    <img src="./images/logo.png" alt="">
                    <img src="./images/logo.png" alt="">
                    <img src="./images/logo.png" alt="">
                    <img src="./images/logo.png" alt="">
                </div>
            </div>
            <div class="evenement-right-description">
                <h3>Personnes</h3>
                <div class="personne-evenement">
                    <img src="./images/profile.jpg" alt="">
                    <p>Nom de la personne</p>
                    <img src="./images/profile.jpg" alt="">
                    <p>Nom de la personne</p>
                    <img src="./images/profile.jpg" alt="">
                    <p>Nom de la personne</p>
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
                <a href="./inscription-connexion.html">Inscrire/Connecter</a>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="./css-js/main.js"></script>
    <script>
        var windowWidth = window.innerWidth;
        if (windowWidth <= 768) {
            $('.footer').css('display','none');
            $('body').css('overflowY','hidden');
        }

        var modifyProfileButton = document.querySelector('#modify_profile_button');
        var modifyProfile = document.querySelector('#modify_profile');

        modifyProfileButton.addEventListener('click',()=>{
            window.location = './utilisateur.php?modifier-profile';
        });

        modifyProfile.addEventListener('click',()=>{
            window.location = './utilisateur.php?modifier-profile';
        });
        
    </script>
</body>
</html>