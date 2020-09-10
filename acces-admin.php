<?php 
    session_start();

    include_once './bdd/connexion.php';

    $err_cnnx = '';
    $succ_cnnx = '';

    if (isset($_POST['connecter'])) {
        $email_admin = htmlspecialchars($_POST['email_admin']);
        $mtp_admin = htmlspecialchars($_POST['mtp_admin']);

        $hash_mtp_admin = hash('sha256', $mtp_admin);
        
        $cnnx_user_query = "SELECT * FROM utilisateurs WHERE type_user = 'admin' AND email_user = '$email_admin 'AND mtp_user = '$hash_mtp_admin'";
        $result = mysqli_query($conn, $cnnx_user_query);
        $count = mysqli_num_rows($result);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

        if ($count == 1) {
            if ($row['type_user'] == 'admin') {
                $_SESSION['admin'] = $row['id_user'];
                $succ_cnnx = 'LOGIN SUCCESS';
                header('Location: admin.php');
            }
            if ($row['type_user'] == 'sous-admin') {
                $_SESSION['sous-admin'] = $row['id_user'];
                $succ_cnnx = 'LOGIN SUCCESS';
                header('Location: sous-admin.php');
            }
        }
        else{
            $err_cnnx = 'INVALID EMAIL OR ADDRESS';
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
    <title>Acces Admins</title>
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
            <form class="connexion" action="acces-admin.php" method="post">
                <h4>admins connexion <?php echo $err_cnnx; echo $succ_cnnx;?></h4>
                <input type="email" name="email_admin" placeholder="Entrez votre email">
                <input type="password" name="mtp_admin" placeholder="Entrez votre mot de passe">
                <a href="#">Mot de passe oublié ?</a>
                <input type="submit" name="connecter" value="connecter">
            </form>
        </div>
    </div>
    <script src="./css-js/main.js"></script>
</body>
</html>