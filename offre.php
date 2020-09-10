<?php 
session_start();
include_once './bdd/connexion.php';
if (isset($_SESSION['user'])) {
    $cnx_user_query = "SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['user'];
    $result = mysqli_query($conn, $cnx_user_query);
    $row = mysqli_fetch_assoc($result);
}else{ header("location: inscription-connexion.php"); }

$offre_details_query = "SELECT * FROM recrutements WHERE id_recrtm =".$_GET['r'];
$offre_details_result = mysqli_query($conn, $offre_details_query);
$offre_details_row = mysqli_fetch_assoc($offre_details_result);

$user_query = "SELECT * FROM utilisateurs WHERE id_user = {$offre_details_row['id_user']}";
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
    <link rel="stylesheet" href="./css-js/offre.css">
    <link href="./css-js/fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet">
    <title>Offre</title>
</head>
<body>
    <?php include './navbar.php'; ?>
    <div class="clear"></div>
    <div class="offre-details">
        <div class="offre-top-description">
            <img src="./images/logo.png" alt="">
            <div>
                <h4><?php echo $offre_details_row['titre']; ?></h4>
                <p><i class="fas fa-building"></i><?php echo $user_row['nom_user']; ?></p>
                <p><i class="fas fa-map-marker-alt"></i><?php echo $offre_details_row['ville'].', Algérie'; ?></p>
            </div>
            <button><i class="fas fa-envelope"></i>Contactez Nous</button>
            <div class="contact-informations">
                <a href="./utilisateur-info.php?id_user=<?php echo $user_row['id_user']; ?>"><li><i class="fas fa-user"></i>Voir le profile</li></a>
                <li><i class="fas fa-phone-square-alt"></i><?php echo $user_row['tlph_user']; ?></li>
                <li><i class="fas fa-at"></i><?php echo $user_row['email_user']; ?></li>
            </div>
        </div>
        <div class="offre-middle-description">
            <div>
                <h5>Proffesion</h5>
                <h5>Date d'éxpiration</h5>
            </div>
            <div>
                <p><?php echo $offre_details_row['profession']; ?></p>
                <p><?php echo $offre_details_row['date_expiration']; ?></p>
            </div>
            <div>
                <h5>Sexe</h5>
                <h5>Salaire</h5>
            </div>
            <div>
                <p><?php echo $offre_details_row['sexe']; ?></p>
                <p><?php echo $offre_details_row['salaire']; ?></p>
            </div>
        </div>
        <div class="offre-bottom-description">
            <div class="offre-bottom-description-left">
                <h4>Mission a faire</h4>
                <li><?php echo $offre_details_row['mission_1'].'.'; ?></li>
                <li><?php echo $offre_details_row['mission_2'].'.'; ?></li>
                <li><?php echo $offre_details_row['mission_3'].'.'; ?></li>
                <li><?php echo $offre_details_row['mission_4'].'.'; ?></li>
                
                <h4>Qualité recherché</h4>
                <li><?php echo $offre_details_row['qualite_1'].'.'; ?></li>
                <li><?php echo $offre_details_row['qualite_2'].'.'; ?></li>
                <li><?php echo $offre_details_row['qualite_3'].'.'; ?></li>
                <li><?php echo $offre_details_row['qualite_4'].'.'; ?></li>
                
                <h4>Lieu de travaille</h4>
                <li><?php echo $offre_details_row['ville'].', Algérie' ?></li>
            </div>
            <div class="offre-bottom-description-right">
                <h4>Publicité</h4>
            </div>
        </div>
        <div class="clear-offre"></div>
        <div class="other-offres">
            <h4>Offres similaire : </h4>
        </div>
        <?php 
            $offre_query = "SELECT * FROM recrutements WHERE (titre LIKE '%{$offre_details_row['titre']}%' OR profession LIKE '%{$offre_details_row['profession']}%') AND type = '{$offre_details_row['type']}' AND id_recrtm != {$offre_details_row['id_recrtm']}";
            $offre_result = mysqli_query($conn, $offre_query);
            while ($offre_row = mysqli_fetch_assoc($offre_result)) {
                $offre_user_query = "SELECT * FROM utilisateurs WHERE id_user=".$offre_details_row['id_user'];
                $offre_user_result = mysqli_query($conn, $offre_user_query);
                $offre_user_row = mysqli_fetch_assoc($offre_user_result);
        ?>
        <div class="offre-top-description">
            <img src="./images/logo.png" alt="">
            <div>
                <h4><?php echo $offre_row['titre']; ?></h4>
                <p><i class="fas fa-building"></i><?php echo $offre_user_row['nom_user']; ?></p>
                <p><i class="fas fa-map-marker-alt"></i><?php echo $offre_row['ville'].', Algérie' ?></p>
            </div>
            <a href="./offre.php?r=<?php echo $offre_row['id_recrtm'] ?>">Voir PLus ..</a>
        </div>
        <div class="clear-responsive"></div>
        <?php } ?> 
        <div class="clear-offre"></div>
        <div class="clear-offre"></div>
        <div class="clear-offre"></div>
        <div class="clear-offre"></div>
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

        $('.offre-top-description button').click(function(){
            $('.contact-informations').toggle();
        })
        
    </script>
</body>
</html>