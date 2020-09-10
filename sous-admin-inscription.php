<?php 
    session_start();

    include_once './bdd/connexion.php';

    $err_inscr = '';
    $succ_inscr = '';
    $email = '';
    $place_holder = '';

    if (isset($_GET['email'])) {
        $email = $_GET['email'];
    }
    else{
        $place_holder = 'Entrez votre email';
    }

    if (isset($_POST['inscrire'])) {
        $sous_admin_email = htmlspecialchars($_POST['sous_admin_email']);
        $sous_admin_nom = htmlspecialchars($_POST['sous_admin_nom']);
        $sous_admin_mtp = htmlspecialchars($_POST['sous_admin_mtp']);
        $sous_admin_cnfrm = htmlspecialchars($_POST['sous_admin_cnfrm']);
        
        if ($sous_admin_mtp == $sous_admin_cnfrm) {
            $hash_sous_admin_mtp = hash('sha256', $sous_admin_mtp);
            $inscr_sous_admin_query = "INSERT INTO utilisateurs (nom_user,type_user,email_user,mtp_user) 
                            VALUES ('$sous_admin_nom','sous-admin','$sous_admin_email','$hash_sous_admin_mtp')";
            mysqli_query($conn,$inscr_sous_admin_query);
            $succ_inscr = 'SUCCESS INSCRIPTION';
            header('Refresh:3 ; url=acces-admin.php');
        }
        else{
            $err_inscr = 'ERROR INSCRIPTION';
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
    <title>Sous Admin Inscription</title>
</head>
<body>
    <div class="navbar">
        <div class="navbar-container">
            <div class="logo">
                <img src="./images/logo.png" alt="logo">
            </div>
            <div class="navbar-menu">
                <a href="./index.html">acceuil</a>
                <a href="#">promotions</a>
                <a href="#">évènements</a>
                <a href="#">recrutement</a>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="inscription-connexion-container">
        <div class="inscription-connexion">
            <form class="connexion" action="sous-admin-inscription.php" method="post">
                <h4>Merci de completez l'inscription <?php echo $err_inscr; echo $succ_inscr;?></h4>
                <input type="email" name="sous_admin_email" placeholder="<?php echo $place_holder; ?>" value="<?php echo $email; ?>">
                <input type="text" name="sous_admin_nom" placeholder="Entrez votre nom">
                <input type="password" name="sous_admin_mtp" placeholder="Entrez votre mot de passe">
                <input type="password" name="sous_admin_cnfrm" placeholder="Confirmez votre mot de passe">
                <input type="submit" name="inscrire" value="Inscrire">
            </form>
        </div>
    </div>
    <script src="./css-js/main.js"></script>
</body>
</html>