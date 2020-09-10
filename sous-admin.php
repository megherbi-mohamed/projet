<?php
    session_start();

    include_once './bdd/connexion.php';

    if (isset($_SESSION['sous-admin'])) {
    
        $cnnx_user_query = "SELECT * FROM admins WHERE id_admin=".$_SESSION['sous-admin'];
        $result = mysqli_query($conn, $cnnx_user_query);
        $row = mysqli_fetch_assoc($result);
    }
    else{
        header('Location: acces-admin.php');
    }

    $sous_admin_email = $row['email_admin'];

    $msg_auth = 0;
    $sous_admin_ville_options = "SELECT ville FROM villes WHERE `{$sous_admin_email}` = '1'";
    if (mysqli_query($conn, $sous_admin_ville_options)) {
        $sous_admin_ville_options_result = mysqli_query($conn, $sous_admin_ville_options);
        $sous_admin_ville_options_num = mysqli_num_rows($sous_admin_ville_options_result);
        $sous_admin_ville_options_row = mysqli_fetch_array($sous_admin_ville_options_result, MYSQLI_NUM);
        
    }

    $rfs_succ_msg = '';
    $rfs_err_msg = '';

    if (isset($_POST['refuser'])) {
        $id_user = htmlspecialchars($_POST['id_user']);

        $rfs_user_query = "DELETE FROM preutilisateurs WHERE id_user = '$id_user'";
        $result = mysqli_query($conn, $rfs_user_query);

        if ($result) {
            $rfs_succ_msg = 'supprimé';
            header('location:'.$_SERVER['REQUEST_URI']);
        }else{
            $rfs_err_msg = 'non supprimé'; 
        }
    }

    if (isset($_POST['accepter'])) {
        $id_user = htmlspecialchars($_POST['id_user']);

        $get_user_query = "SELECT * FROM preutilisateurs WHERE id_user = '$id_user'";
        $get_user_result = mysqli_query($conn, $get_user_query);
        $get_user_row = mysqli_fetch_assoc($get_user_result);

        $type_user = $get_user_row['type_user'];
        $nom_user = $get_user_row['nom_user'];
        $email_user = $get_user_row['email_user'];
        $mtp_user = $get_user_row['mtp_user'];

        $acc_user_query = "INSERT INTO utilisateurs (type_user,nom_user,email_user,mtp_user) VALUES ('$type_user','$nom_user','$email_user','$mtp_user')";
        mysqli_query($conn, $acc_user_query);

        $rfs_user_query = "DELETE FROM preutilisateurs WHERE id_user = '$id_user'";
        mysqli_query($conn, $rfs_user_query);

        header('location:'.$_SERVER['REQUEST_URI']);
    }

    $msg = "";
    
    if (isset($_POST['creer_sous_admin'])) {

        $email = $_POST['email_sous_admin'];
        $urlf = 'localhost/projet/sous-admin-inscription.php?email='.$email;
        $subject = "Confirmation d'etape d'inscription pour sous admin".$email;
        $message = '
        <html>
        <head>
        <title>Sous Admin Inscription</title>
        </head>
        <body>
        <p>Here are the birthdays upcoming in August!</p>
        <img src="https://ibb.co/R2bcPL3"  style="text-align:center">
        <a href='.$urlf.' taget="_blank">'.$urlf.'</a>
        </body>
        </html>
        ';
        
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

        if (mail($email,$subject,$message,$headers)) {
            $msg = 'sent';
        }else{
            $msg = 'not sent';
        }

        $crt_clmn_ville_query = "ALTER TABLE villes ADD COLUMN `{$email}` INT(1) NOT NULL AFTER ville";
        mysqli_query($conn, $crt_clmn_ville_query);
        
        foreach ($_POST['ville'] as $v) {
            $ville = mysqli_real_escape_string($conn,$v);
            if (isset($ville)) {
                $insrt_auth_query = "UPDATE villes SET `{$email}` = '1' WHERE ville = '$ville'";
                mysqli_query($conn, $insrt_auth_query);
            }
        }

        $crt_clmn_option_query = "ALTER TABLE options ADD COLUMN `{$email}` INT(1) NOT NULL AFTER options";
        mysqli_query($conn, $crt_clmn_option_query);

        foreach ($_POST['option'] as $op) {
            $option = mysqli_real_escape_string($conn,$op);
            if (isset($option)) {
                $insrt_auth_query = "UPDATE options SET `{$email}` = '1' WHERE options = '$option'";
                mysqli_query($conn, $insrt_auth_query);
            }
        }
    }
    
    $pre_user_query = "SELECT * FROM preutilisateurs";
    $pre_user_result = mysqli_query($conn, $pre_user_query);
    $pre_user_num = mysqli_num_rows($pre_user_result);

    $pre_entrp_query = "SELECT * FROM preutilisateurs WHERE type_user = 'entreprise'";
    $pre_entrp_result = mysqli_query($conn, $pre_entrp_query);
    $entrp_num = mysqli_num_rows($pre_entrp_result);

    $pre_grp_query = "SELECT * FROM preutilisateurs WHERE type_user = 'groupe'";
    $pre_grp_result = mysqli_query($conn, $pre_grp_query);
    $grp_num = mysqli_num_rows($pre_grp_result);

    $pre_indv_query = "SELECT * FROM preutilisateurs WHERE type_user = 'individu'";
    $pre_indv_result = mysqli_query($conn, $pre_indv_query);
    $indv_num = mysqli_num_rows($pre_indv_result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css-js/style.css">
    <title>Admin Profile</title>
</head>
<body>
    <div class="navbar">
        <div class="navbar-container">
            <div class="logo">
                <img src="./images/logo.png" alt="logo">
            </div>
            <div class="navbar-menu">
                <a class="active" href="./index.html">acceuil</a>
                <a href="#">promotions</a>
                <a href="#">évènements</a>
                <a href="#">recrutement</a>
                <a id="user-list-button" class="last-child"><?php echo $row['nom_admin']; ?> <i class="fa fa-chevron-down"></i> <img src="./images/profile.jpg" alt="profile admin"></a>
            </div>
        </div>
        <div class="user-list-dropdown">
            <a href="#">Paramaitre</a>
            <a href="deconnexion.php">Déconnecter</a>
        </div>
    </div>
    <div class="clear"></div>
    <div class="admin-options">
        <div class="admin-tab-bord">
            <h4>Tableau de bord</h4>
            <ul>
                <a id="options" href="sous-admin.php?sous-admin"><li class="active-li-options" id="sous-admin">Gerer les sous admins</li></a>
                <li class="notifications" id="show-more-utilisateurs">Gerer les utilisateurs <i class="fas fa-bell"><p id="user-num"><?php echo $pre_user_num; ?></p></i></li>
                <div class="hide-more-utilisateurs">
                    <a href="sous-admin.php?entreprises"><li class="notifications" id="entreprises">Entreprises <i class="fas fa-bell"><p id="entrp-num"><?php echo $entrp_num; ?></p></i></li></a>
                    <a href="sous-admin.php?groupes"><li class="notifications" id="groupes">Groupes <i class="fas fa-bell"><p id="grp-num"><?php echo $grp_num; ?></p></i></li></a>
                    <a href="sous-admin.php?individus"><li class="notifications" id="individus">Individus <i class="fas fa-bell"><p id="indv-num"><?php echo $indv_num; ?></p></i></li></a>
                </div>
                <a href="sous-admin.php?promotions"><li id="promotions">Promotions</li></a>
                <a href="sous-admin.php?evenements"><li id="evenements">Evenements</li></a>
                <a href="sous-admin.php?recrutements"><li id="recrutements">Recrutements</li></a>
            </ul>
        </div>
        <div class="admin-options-affichage">
            <div id="sous-admin-options" class ="active-div-options admin-options-aff">
        
                <div class="sous-admin-gestions">
                    <div class="sous-admin-gestion-buttons">
                        <a href="sous-admin.php?sous-admin&gerer-sous-admin" class="sous-admin-gestion-button sous-admin-gestion-button-active" id="gerer-sous-admin">Gerer les sous admin</a>
                        <a href="sous-admin.php?sous-admin&ajouter-sous-admin" class="sous-admin-gestion-button" id="ajouter-sous-admin">Ajouter un sous admin</a>
                    </div>
                    <div class="sous-admin-gestion-options">
                        <div class="sous-admin-gestion-option" id="ajouter-sous-admin-option">
                            <h5><?php echo $msg; ?></h5>
                            <div class="sous-admin-gestion-option-ajouter">
                                <form action="admin.php?sous-admin&ajouter-sous-admin" method="post">
                                    <input type="email" name="email_sous_admin" placeholder="Entrez Sous Admin email">
                                    <div class="sous-admin-autorisation">
                                        <div class="sous-admin-autorisation-ville">
                                        <?php 
                                        while ($ville_row = mysqli_fetch_assoc($ville_result)) {
                                        ?>
                                            <div id="check_box_auto_click"><input type="checkbox" id="check_box_ville" name="ville[]" value="<?php echo $ville_row['ville']; ?>"><p><?php echo $ville_row['ville']; ?></p></div>
                                        <?php } ?>    
                                        </div>
                                        <div class="sous-admin-autorisation-tbord">
                                        <?php 
                                        while ($option_row = mysqli_fetch_assoc($option_result)) {
                                        ?>
                                            <div id="check_box_auto_click"><input type="checkbox" id="check_box_ville" name="option[]" value="<?php echo $option_row['options']; ?>"><p><?php echo $option_row['options']; ?></p></div>
                                        <?php } ?> 
                                        </div>
                                    </div>
                                    <input type="submit" id="creer_sous_admin" name="creer_sous_admin" value="Valider">
                                </form>
                            </div>
                        </div>
                        <div class="sous-admin-gestion-option sous-admin-gestion-option-active" id="gerer-sous-admin-option">
                            <h5>Gerer sous admin</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="admin-options-aff" id="entreprises-options">
                <!-- notification.php appel -->
                <h4>Gerer les entreprises</h4>
                <div class="user-notifications">
                    <table>
                        <tr>
                            <th>Type</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Options</th>
                        </tr>
                        <?php 
                            while ($pre_entrp_row = mysqli_fetch_assoc($pre_entrp_result)) {
                        ?>
                        <tr>
                            <td><?php echo $pre_entrp_row['type_user']; ?></td>
                            <td><?php echo $pre_entrp_row['nom_user']; ?></td>
                            <td><?php echo $pre_entrp_row['email_user']; ?></td>
                            <td>
                                <form method="post" action="admin.php?entreprises">
                                    <input type="hidden" name="id_user" id="id_user" value="<?php echo $pre_entrp_row['id_user']; ?>">
                                    <input type="submit" name="accepter" id="accepter" value="Accepter">
                                    <input type="submit" name="refuser" id="refuser" value="Refuser">
                                </form>
                            </td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
            <div class="admin-options-aff" id="groupes-options">
                <!-- notification.php appel -->
                <h4>Gerer les groupes</h4>
                <div class="user-notifications">
                    <table>
                        <tr>
                            <th>Type</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Options</th>
                        </tr>
                        <?php 
                            while ($pre_grp_row = mysqli_fetch_assoc($pre_grp_result)) {
                        ?>
                        <tr>
                            <td><?php echo $pre_grp_row['type_user']; ?></td>
                            <td><?php echo $pre_grp_row['nom_user']; ?></td>
                            <td><?php echo $pre_grp_row['email_user']; ?></td>
                            <td>
                                <form method="post" action="admin.php?groupes">
                                    <input type="hidden" name="id_user" id="id_user" value="<?php echo $pre_grp_row['id_user']; ?>">
                                    <input type="submit" name="accepter" id="accepter" value="Accepter">
                                    <input type="submit" name="refuser" id="refuser" value="Refuser">
                                </form>
                            </td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
            <div class="admin-options-aff" id="individus-options">
               <!-- notification.php appel -->
               <h4>Gerer les individus</h4>
                <div class="user-notifications">
                    <!-- <p><?php echo $rfs_succ_msg; echo $rfs_err_msg; ?></p> -->
                    <table>
                        <tr>
                            <th>Type</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Options</th>
                        </tr>
                        <?php 
                            while ($pre_indv_row = mysqli_fetch_assoc($pre_indv_result)) {
                        ?>
                        <tr>
                            <td><?php echo $pre_indv_row['type_user']; ?></td>
                            <td><?php echo $pre_indv_row['nom_user']; ?></td>
                            <td><?php echo $pre_indv_row['email_user']; ?></td>
                            <td>
                                <form method="post" action="admin.php?individus">
                                    <input type="hidden" name="id_user" id="id_user" value="<?php echo $pre_indv_row['id_user']; ?>">
                                    <input type="submit" name="accepter" id="accepter" value="Accepter">
                                    <input type="submit" name="refuser" id="refuser" value="Refuser">
                                </form>
                            </td>
                        </tr>
                        <?php } ?>
                    </table>
                </div><br>
                <div class="user-notifications">
                    <table>
                        <tr>
                            <th>Type</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Options</th>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="admin-options-aff" id="promotions-options">
                <!-- notification.php appel -->
            </div>
            <div class="admin-options-aff" id="evenements-options">
                <!-- notification.php appel -->
            </div>
            <div class="admin-options-aff" id="recrutements-options">
                <!-- notification.php appel -->
            </div>
        </div>
    </div>
    <script src="./css-js/main.js"></script>
    <script src="https://kit.fontawesome.com/1f49389cd3.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</body>
</html>