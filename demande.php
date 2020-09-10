<?php 
session_start();
include_once './bdd/connexion.php';
if (isset($_SESSION['user'])) {
    $cnx_user_query = "SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['user'];
    $result = mysqli_query($conn, $cnx_user_query);
    $row = mysqli_fetch_assoc($result);
}else{ header("location: inscription-connexion.php"); }

$demande_details_query = "SELECT * FROM recrutements WHERE id_recrtm =".$_GET['r'];
$demande_details_result = mysqli_query($conn, $demande_details_query);
$demande_details_row = mysqli_fetch_assoc($demande_details_result);

$user_query = "SELECT * FROM utilisateurs WHERE id_user = {$demande_details_row['id_user']}";
$user_result = mysqli_query($conn, $user_query);
$user_row = mysqli_fetch_assoc($user_result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css-js/style.css">
    <link href="./css-js/fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet">
    <title>Demande</title>
</head>
<body>
    <?php include './navbar.php'; ?>
    <div class="clear"></div>
    <div class="offre-details">
        <div class="offre-top-description">
            <img src="./images/logo.png" alt="">
            <div>
                <h4><?php echo $demande_details_row['titre']; ?></h4>
                <p><i class="fas fa-building"></i><?php echo $user_row['nom_user']; ?></p>
                <p><i class="fas fa-map-marker-alt"></i><?php echo $demande_details_row['ville'].', Algérie'; ?></p>
            </div>
            <a href="utilisateur-info.php?id_user=<?php echo $demande_details_row['id_user']; ?>"><i class="fas fa-user"></i>Voire mon profile</a>
        </div>
        <div class="offre-middle-description">
            <div>
                <h5>Proffesion</h5>
                <h5>Date de demande</h5>
            </div>
            <div>
                <p><?php echo $demande_details_row['profession']; ?></p>
                <p><?php echo $demande_details_row['date']; ?></p>
            </div>
            <div>
                <h5>Sexe</h5>
                <h5>Salaire</h5>
            </div>
            <div>
                <p><?php echo $demande_details_row['sexe']; ?></p>
                <p><?php echo $demande_details_row['salaire']; ?></p>
            </div>
        </div>
        <div class="offre-bottom-description">
            <div class="offre-bottom-description-left">
                <h4>Compétences</h4>
                <li><?php echo $demande_details_row['mission_1'].'.'; ?></li>
                <li><?php echo $demande_details_row['mission_2'].'.'; ?></li>
                <li><?php echo $demande_details_row['mission_3'].'.'; ?></li>
                <li><?php echo $demande_details_row['mission_4'].'.'; ?></li>
                
                <h4>travaille recherché</h4>
                <li><?php echo $demande_details_row['qualite_1'].'.'; ?></li>
                <li><?php echo $demande_details_row['qualite_2'].'.'; ?></li>
                <li><?php echo $demande_details_row['qualite_3'].'.'; ?></li>
                <li><?php echo $demande_details_row['qualite_4'].'.'; ?></li>
                
                <h4>Lieu de résidence</h4>
                <li><?php echo $demande_details_row['ville'].', Algérie' ?></li>
            </div>
            <div class="offre-bottom-description-right">
                <h4>Publicité</h4>
            </div>
        </div>
        <div class="clear-responsive"></div>
    </div>
    <div class="clear-offre"></div>
    <div class="clear-offre"></div>
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

        var offreDescriptionLi = document.querySelectorAll('.offre-bottom-description-left li');
        for (let i = 0; i < offreDescriptionLi.length; i++) {
            if (offreDescriptionLi[i].textContent == '.') {
                offreDescriptionLi[i].style.display = 'none';
            }
        }
        
    </script>
</body>
</html>