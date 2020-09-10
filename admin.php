<?php
    session_start();

    include_once './bdd/connexion.php';

    if (isset($_SESSION['admin'])) {
    
        $cnnx_user_query = "SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['admin'];
        $result = mysqli_query($conn, $cnnx_user_query);
        $row = mysqli_fetch_assoc($result);
    }
    else{
        header('Location: acces-admin.php');
    }

    // refuser un preutilisateur
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

    // accepter un preutilisateur
    if (isset($_POST['accepter'])) {
        $id_user = htmlspecialchars($_POST['id_user']);

        $get_pre_user_query = "SELECT * FROM preutilisateurs WHERE id_user = '$id_user'";
        $get_pre_user_result = mysqli_query($conn, $get_pre_user_query);
        $get_pre_user_row = mysqli_fetch_assoc($get_pre_user_result);

        $type_pre_user = $get_pre_user_row['type_user'];
        $nom_pre_user = $get_pre_user_row['nom_user'];
        $email_pre_user = $get_pre_user_row['email_user'];
        $mtp_pre_user = $get_pre_user_row['mtp_user'];

        $acc_user_query = "INSERT INTO utilisateurs (type_user,nom_user,email_user,mtp_user) VALUES ('$type_pre_user','$nom_pre_user','$email_pre_user','$mtp_pre_user')";
        mysqli_query($conn, $acc_user_query);

        $get_user_query = "SELECT id_user FROM utilisateurs WHERE email_user = '$email_pre_user'";
        $get_user_result = mysqli_query($conn, $get_user_query);
        $get_user_row = mysqli_fetch_assoc($get_user_result);

        $id_info_user = $get_user_row['id_user'];
        $information = array("tlph_user", "adresse1_user", "adresse2_user","email_user","ville","pays","latitude_user","longitude_user");

        for ($i=0; $i < 8; $i++) { 
            $info_user_query = "INSERT INTO informations (id_user,information,info_auth) VALUES ('$id_info_user','$information[$i]','0')";
            mysqli_query($conn, $info_user_query);
        }

        $rfs_user_query = "DELETE FROM preutilisateurs WHERE id_user = '$id_user'";
        mysqli_query($conn, $rfs_user_query);

        header('location:'.$_SERVER['REQUEST_URI']);
    }

    $msg = "";
    // creer un sous admin
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

    // supprimer un utilisateur
    if (isset($_POST['supprimer_user'])) {
        $id_user = htmlspecialchars($_POST['id_user']);

        $dlt_user_query = "DELETE FROM utilisateurs WHERE id_user = '$id_user'";
        mysqli_query($conn, $dlt_user_query);

        $dlt_info_user_query .= "DELETE FROM informations WHERE id_user = '$id_user'";
        mysqli_query($conn, $dlt_info_user_query);

        header('location:'.$_SERVER['REQUEST_URI']);
    }

    // modofier les informations d'un utilisateur
    if (isset($_POST['valider_modification'])) {

        $id_user = htmlspecialchars($_POST['id_user']);
        $tlph_user = htmlspecialchars($_POST['tlph_user']);
        $adresse1_user = htmlspecialchars($_POST['adresse1_user']);
        $adresse2_user = htmlspecialchars($_POST['adresse2_user']);
        $ville_user = htmlspecialchars($_POST['ville']);
        $pays_user = htmlspecialchars($_POST['pays']);
        $dscrp_user = htmlspecialchars($_POST['dscrp_user']);
        $latitude_user = htmlspecialchars($_POST['latitude_user']);
        $longitude_user = htmlspecialchars($_POST['longitude_user']);

        $updt_user_query = "UPDATE utilisateurs SET tlph_user='$tlph_user',adresse1_user='$adresse1_user',
        adresse2_user='$adresse2_user',ville='$ville_user',pays='$pays_user',dscrp_user='$dscrp_user',
        latitude_user='$latitude_user', longitude_user='$longitude_user' WHERE id_user = '$id_user'";

        mysqli_query($conn, $updt_user_query);
        
        if (isset($_POST['tlph_user_checkbox'])) {
            $user_info_query = "UPDATE informations SET info_auth = '1' WHERE id_user = '$id_user' AND information = 'tlph_user'";
            mysqli_query($conn, $user_info_query);
        }
        else{
            $user_info_query = "UPDATE informations SET info_auth = '0' WHERE id_user = '$id_user' AND information = 'tlph_user'";
            mysqli_query($conn, $user_info_query);
        }

        if (isset($_POST['adresse1_user_checkbox'])) {
            $user_info_query = "UPDATE informations SET info_auth = '1' WHERE id_user = '$id_user' AND information = 'adresse1_user'";
            mysqli_query($conn, $user_info_query);
        }
        else{
            $user_info_query = "UPDATE informations SET info_auth = '0' WHERE id_user = '$id_user' AND information = 'adresse1_user'";
            mysqli_query($conn, $user_info_query);
        }

        if (isset($_POST['adresse2_user_checkbox'])) {
            $user_info_query = "UPDATE informations SET info_auth = '1' WHERE id_user = '$id_user' AND information = 'adresse2_user'";
            mysqli_query($conn, $user_info_query);
        }
        else{
            $user_info_query = "UPDATE informations SET info_auth = '0' WHERE id_user = '$id_user' AND information = 'adresse2_user'";
            mysqli_query($conn, $user_info_query);
        }

        if (isset($_POST['ville_checkbox'])) {
            $user_info_query = "UPDATE informations SET info_auth = '1' WHERE id_user = '$id_user' AND information = 'ville'";
            mysqli_query($conn, $user_info_query);
        }
        else{
            $user_info_query = "UPDATE informations SET info_auth = '0' WHERE id_user = '$id_user' AND information = 'ville'";
            mysqli_query($conn, $user_info_query);
        }

        if (isset($_POST['pays_checkbox'])) {
            $user_info_query = "UPDATE informations SET info_auth = '1' WHERE id_user = '$id_user' AND information = 'pays'";
            mysqli_query($conn, $user_info_query);
        }
        else{
            $user_info_query = "UPDATE informations SET info_auth = '0' WHERE id_user = '$id_user' AND information = 'pays'";
            mysqli_query($conn, $user_info_query);
        }

        if (isset($_POST['email_user_checkbox'])) {
            $user_info_query = "UPDATE informations SET info_auth = '1' WHERE id_user = '$id_user' AND information = 'email_user'";
            mysqli_query($conn, $user_info_query);
        }
        else{
            $user_info_query = "UPDATE informations SET info_auth = '0' WHERE id_user = '$id_user' AND information = 'email_user'";
            mysqli_query($conn, $user_info_query);
        }

        if (isset($_POST['latitude_user_checkbox'])) {
            $user_info_query = "UPDATE informations SET info_auth = '1' WHERE id_user = '$id_user' AND information = 'latitude_user'";
            mysqli_query($conn, $user_info_query);
        }
        else{
            $user_info_query = "UPDATE informations SET info_auth = '0' WHERE id_user = '$id_user' AND information = 'latitude_user'";
            mysqli_query($conn, $user_info_query);
        }

        if (isset($_POST['longitude_user_checkbox'])) {
            $user_info_query = "UPDATE informations SET info_auth = '1' WHERE id_user = '$id_user' AND information = 'longitude_user'";
            mysqli_query($conn, $user_info_query);
        }
        else{
            $user_info_query = "UPDATE informations SET info_auth = '0' WHERE id_user = '$id_user' AND information = 'longitude_user'";
            mysqli_query($conn, $user_info_query);
        }
        
        header('location:'.$_SERVER['REQUEST_URI']);
    }

    // authorisation pour display les informations
    $tlphCheck = '';
    $adresse1Check = '';
    $adresse2Check = '';
    $emailCheck = '';
    $villeCheck = '';
    $paysCheck = '';
    $latitudeCheck = '';
    $longitudeCheck = '';
    
    // les informations et le nombre d'utilisatuer inscri
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

    $ville_query = "SELECT * FROM villes";
    $ville_result = mysqli_query($conn, $ville_query);

    $option_query = "SELECT * FROM options";
    $option_result = mysqli_query($conn, $option_query);

    $entrp_query = "SELECT * FROM utilisateurs WHERE type_user = 'entreprise'";
    $entrp_result = mysqli_query($conn, $entrp_query);

    $grp_query = "SELECT * FROM utilisateurs WHERE type_user = 'groupe'";
    $grp_result = mysqli_query($conn, $grp_query);

    $indv_query = "SELECT * FROM utilisateurs WHERE type_user = 'individu'";
    $indv_result = mysqli_query($conn, $indv_query);

    $msg_query = "SELECT * FROM messages WHERE id_msg IN ( SELECT MAX(id_msg) FROM messages WHERE id_recever = {$row['id_user']} GROUP BY id_sender) ORDER BY id_msg DESC";
    $msg_result = mysqli_query($conn,$msg_query);

    $num_msg_query = "SELECT * FROM messages WHERE id_recever = {$row['id_user']} AND etat_msg  = 1 GROUP BY id_sender";
    $num_msg_result = mysqli_query($conn,$num_msg_query);
    $num_message = 0;
    while ($num_msg_row = mysqli_fetch_assoc($num_msg_result)) {
        if (isset($_SESSION['senderinfo'])) {
            if ($num_msg_row['id_recever'] == $_SESSION['senderinfo']) {
                $num_message;
            }else{$num_message++;}
        }else {$num_message++;}
    }
    $etat_message = '';
    if ($num_message > 0) {
        $etat_message = 'active-message-num';
        $num_message;
    }else{ $etat_message = '';}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css-js/style.css">
    <link rel="stylesheet" href="./css-js/admin.css">
    <link href="./css-js/fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet">
    <title>Admin Profile</title>
</head>
<body>
    <div class="navbar">
        <div class="navbar-container">
            <div class="logo">
                <img src="./images/logo.png" alt="logo">
            </div>
            <div class="navbar-menu">
                <a href="./index.php">acceuil</a>
                <a href="./promotions.php">promotions</a>
                <a href="./evenements.php">évènements</a>
                <a href="./recrutements.php">recrutement</a>
                <i id="user_list_messages" class="fab fa-facebook-messenger"><span class="<?php echo $etat_message;?>"><?php echo $num_message;?></span></i>
                <i id="user_list_notifications" class="fas fa-flag"><span>0</span></i>
                <a id="user-list-button" class="user-nav-notifications"><?php echo $row['nom_user']; ?> <i class="fa fa-chevron-down"></i>
                <img src="<?php if($row['img_user']==''){echo'./images/profile.jpg';}else{echo './'.$row['img_user'];}?>" alt="profile user"></a>
            </div>
        </div>
        <div class="user-list-dropdown">
            <a href="./admin.php">Profile</a>
            <a href="#">Paramaitre</a>
            <a href="./deconnexion.php">Déconnecter</a>
        </div>
        <div class="user-list-messages">
            <?php 
                while ($msg_row = mysqli_fetch_assoc($msg_result)) {
                $sender_info_query = "SELECT * FROM utilisateurs WHERE id_user = {$msg_row['id_sender']}";
                $sender_info_result = mysqli_query($conn,$sender_info_query);
                $sender_info_row = mysqli_fetch_assoc($sender_info_result);
                $new_sender = '';
                if (isset($_SESSION['senderinfo'])) {
                    if ($msg_row['etat_msg'] == 1 && $msg_row['id_sender'] != $_SESSION['senderinfo']) {
                        $new_sender = 'new-sender'; }
                }elseif ($msg_row['etat_msg'] == 1 && $msg_row['id_sender']){
                    $new_sender = 'new-sender'; }
            ?>
            <a href="./messagerie.php?user=<?php echo $sender_info_row['id_user']; ?>">
            <div class="message <?php echo $new_sender; ?>">
                <img src="./<?php echo $sender_info_row['img_user']; ?>" alt="">
                <div>
                    <p><?php echo $msg_row['message']; ?></p>
                    <p><?php echo $msg_row['temp_msg']; ?>&nbsp;<span><?php echo $sender_info_row['nom_user']; ?></span></p>
                </div>
            </div></a>
            <?php } ?>
        </div>
        <div class="user-list-notifications">
            <div class="notification">
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dolores, soluta!</p>
                <p>il y a 00:00 <span>admin</span></p>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="admin-options">
        <div class="admin-tab-bord">
            <h4>Tableau de bord</h4>
            <ul>
                <a href="admin.php?sous-admin"><li class="active-li-options" id="sous-admin">Gerer les sous admins</li></a>
                <li class="notifications" id="show-more-utilisateurs">Gerer les utilisateurs <i class="fas fa-bell"><p id="user-num"><?php echo $pre_user_num; ?></p></i></li>
                <div class="hide-more-utilisateurs">
                    <a href="admin.php?entreprises"><li class="notifications" id="entreprises">Entreprises <i class="fas fa-bell"><p id="entrp-num"><?php echo $entrp_num; ?></p></i></li></a>
                    <a href="admin.php?groupes"><li class="notifications" id="groupes">Groupes <i class="fas fa-bell"><p id="grp-num"><?php echo $grp_num; ?></p></i></li></a>
                    <a href="admin.php?individus"><li class="notifications" id="individus">Individus <i class="fas fa-bell"><p id="indv-num"><?php echo $indv_num; ?></p></i></li></a>
                </div>
                <a href="admin.php?promotions"><li id="promotions">Promotions</li></a>
                <a href="admin.php?evenements"><li id="evenements">Evenements</li></a>
                <a href="admin.php?recrutements"><li id="recrutements">Recrutements</li></a>
            </ul>
        </div>
        <div class="admin-options-affichage">

            <div id="sous-admin-options" class ="active-div-options admin-options-aff">
                <div class="sous-admin-gestions">
                    <div class="sous-admin-gestion-buttons">
                        <a href="admin.php?sous-admin&gerer-sous-admin" class="sous-admin-gestion-button sous-admin-gestion-button-active" id="gerer-sous-admin">Gerer les sous admin</a>
                        <a href="admin.php?sous-admin&ajouter-sous-admin" class="sous-admin-gestion-button" id="ajouter-sous-admin">Ajouter un sous admin</a>
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
                <div class="entreprises-gestions">
                    <div class="entreprises-gestion-buttons">
                        <a href="admin.php?entreprises&gerer-entreprises" class="entreprises-gestion-button entreprises-gestion-button-active" id="gerer-entreprises">Gerer les entreprises</a>
                        <a href="admin.php?entreprises&accepter-entreprises" class="entreprises-gestion-button" id="accepter-entreprises">Accepter des entreprises</a>
                    </div>
                    <div class="entreprises-gestion-options">
                        <div class="entreprises-gestion-option" id="accepter-entreprises-option">
                            <!-- <h5><?php echo $msg; ?></h5> -->
                            <div class="user-notifications" id="entreprises-accepter-entreprises">
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
                                            <form method="post" action="admin.php?entreprises&accepter-entreprises">
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
                        <div class="entreprises-gestion-option entreprises-gestion-option-active" id="gerer-entreprises-option">
                            <?php
                                while ($entrp_row = mysqli_fetch_assoc($entrp_result)) {

                                    $info_tlph_auth_query = "SELECT * FROM informations WHERE information = 'tlph_user' AND id_user = '{$entrp_row['id_user']}'";
                                    $info_tlph_auth_result = mysqli_query($conn, $info_tlph_auth_query);
                                    $info_tlph_auth_row = mysqli_fetch_assoc($info_tlph_auth_result);

                                    $info_adresse1_auth_query = "SELECT * FROM informations WHERE information = 'adresse1_user' AND id_user = '{$entrp_row['id_user']}'";
                                    $info_adresse1_auth_result = mysqli_query($conn, $info_adresse1_auth_query);
                                    $info_adresse1_auth_row = mysqli_fetch_assoc($info_adresse1_auth_result);

                                    $info_adresse2_auth_query = "SELECT * FROM informations WHERE information = 'adresse2_user' AND id_user = '{$entrp_row['id_user']}'";
                                    $info_adresse2_auth_result = mysqli_query($conn, $info_adresse2_auth_query);
                                    $info_adresse2_auth_row = mysqli_fetch_assoc($info_adresse2_auth_result);

                                    $info_email_auth_query = "SELECT * FROM informations WHERE information = 'email_user' AND id_user = '{$entrp_row['id_user']}'";
                                    $info_email_auth_result = mysqli_query($conn, $info_email_auth_query);
                                    $info_email_auth_row = mysqli_fetch_assoc($info_email_auth_result);

                                    $info_ville_auth_query = "SELECT * FROM informations WHERE information = 'ville' AND id_user = '{$entrp_row['id_user']}'";
                                    $info_ville_auth_result = mysqli_query($conn, $info_ville_auth_query);
                                    $info_ville_auth_row = mysqli_fetch_assoc($info_ville_auth_result);

                                    $info_pays_auth_query = "SELECT * FROM informations WHERE information = 'pays' AND id_user = '{$entrp_row['id_user']}'";
                                    $info_pays_auth_result = mysqli_query($conn, $info_pays_auth_query);
                                    $info_pays_auth_row = mysqli_fetch_assoc($info_pays_auth_result);

                                    $info_latitude_auth_query = "SELECT * FROM informations WHERE information = 'latitude_user' AND id_user = '{$entrp_row['id_user']}'";
                                    $info_latitude_auth_result = mysqli_query($conn, $info_latitude_auth_query);
                                    $info_latitude_auth_row = mysqli_fetch_assoc($info_latitude_auth_result);

                                    $info_longitude_auth_query = "SELECT * FROM informations WHERE information = 'longitude_user' AND id_user = '{$entrp_row['id_user']}'";
                                    $info_longitude_auth_result = mysqli_query($conn, $info_longitude_auth_query);
                                    $info_longitude_auth_row = mysqli_fetch_assoc($info_longitude_auth_result);
                                    
                                    if ($info_tlph_auth_row['info_auth'] == '1') {
                                        $tlphCheck = 'checked';}else{$tlphCheck = '';}
                                        
                                    if ($info_adresse1_auth_row['info_auth'] == '1') {
                                        $adresse1Check = 'checked';}else{$adresse1Check = '';}

                                    if ($info_adresse2_auth_row['info_auth'] == '1') {
                                        $adresse2Check = 'checked';}else{$adresse2Check = '';}

                                    if ($info_email_auth_row['info_auth'] == '1') {
                                        $emailCheck = 'checked';}else{$emailCheck = '';}

                                    if ($info_ville_auth_row['info_auth'] == '1') {
                                        $villeCheck = 'checked';}else{$villeCheck = '';}

                                    if ($info_pays_auth_row['info_auth'] == '1') {
                                        $paysCheck = 'checked';}else{$paysCheck = '';}

                                    if ($info_latitude_auth_row['info_auth'] == '1') {
                                        $latitudeCheck = 'checked';}else{$latitudeCheck = '';}

                                    if ($info_longitude_auth_row['info_auth'] == '1') {
                                        $longitudeCheck = 'checked';}else{$longitudeCheck = '';}
                            ?>
                            <div class="entreprises-informations">
                                <div class="top-entreprises-informations" id="entreprises_informations">
                                    <img src="<?php if($entrp_row['img_user']==''){echo'./images/profile.jpg';}else{echo './'.$entrp_row['img_user'];}?>" alt="logo">
                                    <h4><?php echo $entrp_row['nom_user']; ?></h4>
                                    <form action="admin.php?entreprises&gerer-entreprises" method="post">
                                        <input type="submit" name="supprimer_user" value="Supprimer">
                                        <input type="hidden" name="id_user" value="<?php echo $entrp_row['id_user']; ?>">
                                    </form>
                                    <button id="modifier_entrp">Modifier</button>
                                </div>
                                <div class="bottom-entreprises-informations">
                                    <form action="admin.php?entreprises&gerer-entreprises=<?php echo $entrp_row['id_user']; ?>" method="post">
                                        <div id="gerer_entreprise_4-1">
                                            <div>
                                                <input type="text" name="tlph_user" value="<?php echo $entrp_row['tlph_user']; ?>">
                                                <label class="switch">
                                                    <input name="tlph_user_checkbox" type="checkbox" <?php echo $tlphCheck; ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                            <div>
                                                <input type="text" name="adresse1_user" value="<?php echo $entrp_row['adresse1_user']; ?>">
                                                <label class="switch">
                                                    <input name="adresse1_user_checkbox" type="checkbox" <?php echo $adresse1Check; ?>>
                                                        <span class="slider round"></span>
                                                    </label>
                                            </div>
                                            <div>
                                                <input type="text" name="adresse2_user" value="<?php echo $entrp_row['adresse2_user']; ?>">
                                                <label class="switch">
                                                    <input name="adresse2_user_checkbox" type="checkbox" <?php echo $adresse2Check; ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                            <div>
                                                <input type="text" name="email_user" value="<?php echo $entrp_row['email_user']; ?>">
                                                <label class="switch">
                                                    <input name="email_user_checkbox" type="checkbox" <?php echo $emailCheck; ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div id="gerer_entreprise_4-2">
                                            <div>
                                                <input type="text" name="ville" value="<?php echo $entrp_row['ville']; ?>">
                                                <label class="switch">
                                                    <input name="ville_checkbox" type="checkbox" <?php echo $villeCheck; ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                            <div>
                                                <input type="text" name="pays" value="<?php echo $entrp_row['pays']; ?>">
                                                <label class="switch">
                                                    <input name="pays_checkbox" type="checkbox" <?php echo $paysCheck; ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                            <div>
                                                <input type="text" name="latitude_user" value="<?php echo $entrp_row['latitude_user']; ?>">
                                                <label class="switch">
                                                    <input name="latitude_user_checkbox" type="checkbox" <?php echo $latitudeCheck; ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                            <div>
                                                <input type="text" name="longitude_user" value="<?php echo $entrp_row['longitude_user']; ?>">
                                                <label class="switch">
                                                    <input name="longitude_user_checkbox" type="checkbox" <?php echo $longitudeCheck; ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <textarea name="dscrp_user"><?php echo $entrp_row['dscrp_user']; ?></textarea>
                                        <input type="hidden" id="id_entrp_modificaitions" name="id_user" value="<?php echo $entrp_row['id_user']; ?>">
                                        <input type="submit" id="valider_modification" name="valider_modification" value="Valider">
                                    </form>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin-options-aff" id="groupes-options">
                <div class="groupes-gestions">
                    <div class="groupes-gestion-buttons">
                        <a href="admin.php?groupes&gerer-groupes" class="groupes-gestion-button groupes-gestion-button-active" id="gerer-groupes">Gerer les groupes</a>
                        <a href="admin.php?groupes&accepter-groupes" class="groupes-gestion-button" id="accepter-groupes">Accepter des groupes</a>
                    </div>
                    <div class="groupes-gestion-options">
                        <div class="groupes-gestion-option" id="accepter-groupes-option">
                            <!-- <h5><?php echo $msg; ?></h5> -->
                            <div class="user-notifications" id="groupes-accepter-groupes">
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
                                            <form method="post" action="admin.php?groupes&accepter-groupes">
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
                        <div class="groupes-gestion-option groupes-gestion-option-active" id="gerer-groupes-option">
                            <?php
                                while ($grp_row = mysqli_fetch_assoc($grp_result)) {

                                    $info_tlph_auth_query = "SELECT * FROM informations WHERE information = 'tlph_user' AND id_user = '{$grp_row['id_user']}'";
                                    $info_tlph_auth_result = mysqli_query($conn, $info_tlph_auth_query);
                                    $info_tlph_auth_row = mysqli_fetch_assoc($info_tlph_auth_result);

                                    $info_adresse1_auth_query = "SELECT * FROM informations WHERE information = 'adresse1_user' AND id_user = '{$grp_row['id_user']}'";
                                    $info_adresse1_auth_result = mysqli_query($conn, $info_adresse1_auth_query);
                                    $info_adresse1_auth_row = mysqli_fetch_assoc($info_adresse1_auth_result);

                                    $info_adresse2_auth_query = "SELECT * FROM informations WHERE information = 'adresse2_user' AND id_user = '{$grp_row['id_user']}'";
                                    $info_adresse2_auth_result = mysqli_query($conn, $info_adresse2_auth_query);
                                    $info_adresse2_auth_row = mysqli_fetch_assoc($info_adresse2_auth_result);

                                    $info_email_auth_query = "SELECT * FROM informations WHERE information = 'email_user' AND id_user = '{$grp_row['id_user']}'";
                                    $info_email_auth_result = mysqli_query($conn, $info_email_auth_query);
                                    $info_email_auth_row = mysqli_fetch_assoc($info_email_auth_result);

                                    $info_ville_auth_query = "SELECT * FROM informations WHERE information = 'ville' AND id_user = '{$grp_row['id_user']}'";
                                    $info_ville_auth_result = mysqli_query($conn, $info_ville_auth_query);
                                    $info_ville_auth_row = mysqli_fetch_assoc($info_ville_auth_result);

                                    $info_pays_auth_query = "SELECT * FROM informations WHERE information = 'pays' AND id_user = '{$grp_row['id_user']}'";
                                    $info_pays_auth_result = mysqli_query($conn, $info_pays_auth_query);
                                    $info_pays_auth_row = mysqli_fetch_assoc($info_pays_auth_result);

                                    $info_latitude_auth_query = "SELECT * FROM informations WHERE information = 'latitude_user' AND id_user = '{$grp_row['id_user']}'";
                                    $info_latitude_auth_result = mysqli_query($conn, $info_latitude_auth_query);
                                    $info_latitude_auth_row = mysqli_fetch_assoc($info_latitude_auth_result);

                                    $info_longitude_auth_query = "SELECT * FROM informations WHERE information = 'longitude_user' AND id_user = '{$grp_row['id_user']}'";
                                    $info_longitude_auth_result = mysqli_query($conn, $info_longitude_auth_query);
                                    $info_longitude_auth_row = mysqli_fetch_assoc($info_longitude_auth_result);
                                    
                                    if ($info_tlph_auth_row['info_auth'] == '1') {
                                        $tlphCheck = 'checked';}else{$tlphCheck = '';}
                                        
                                    if ($info_adresse1_auth_row['info_auth'] == '1') {
                                        $adresse1Check = 'checked';}else{$adresse1Check = '';}

                                    if ($info_adresse2_auth_row['info_auth'] == '1') {
                                        $adresse2Check = 'checked';}else{$adresse2Check = '';}

                                    if ($info_email_auth_row['info_auth'] == '1') {
                                        $emailCheck = 'checked';}else{$emailCheck = '';}

                                    if ($info_ville_auth_row['info_auth'] == '1') {
                                        $villeCheck = 'checked';}else{$villeCheck = '';}

                                    if ($info_pays_auth_row['info_auth'] == '1') {
                                        $paysCheck = 'checked';}else{$paysCheck = '';}

                                    if ($info_latitude_auth_row['info_auth'] == '1') {
                                        $latitudeCheck = 'checked';}else{$latitudeCheck = '';}

                                    if ($info_longitude_auth_row['info_auth'] == '1') {
                                        $longitudeCheck = 'checked';}else{$longitudeCheck = '';}
                            ?>
                            <div class="groupes-informations">
                                <div class="top-groupes-informations" id="groupes_informations">
                                    <img src="<?php if($grp_row['img_user']==''){echo'./images/profile.jpg';}else{echo './'.$grp_row['img_user'];}?>" alt="logo">
                                    <h4><?php echo $grp_row['nom_user']; ?></h4>
                                    <form action="admin.php?groupes&gerer-groupes" method="post">
                                        <input type="submit" name="supprimer_user" value="Supprimer">
                                        <input type="hidden" name="id_user" value="<?php echo $grp_row['id_user']; ?>">
                                    </form>
                                    <button id="modifier_grp">Modifier</button>
                                </div>
                                <div class="bottom-groupes-informations">
                                    <form action="admin.php?groupes&gerer-groupes=<?php echo $grp_row['id_user']; ?>" method="post">
                                        <div id="gerer_groupes_4-1">
                                            <div>
                                                <input type="text" name="tlph_user" value="<?php echo $grp_row['tlph_user']; ?>">
                                                <label class="switch">
                                                    <input name="tlph_user_checkbox" type="checkbox" <?php echo $tlphCheck; ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                            <div>
                                                <input type="text" name="adresse1_user" value="<?php echo $grp_row['adresse1_user']; ?>">
                                                <label class="switch">
                                                    <input name="adresse1_user_checkbox" type="checkbox" <?php echo $adresse1Check; ?>>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            <div>
                                                <input type="text" name="adresse2_user" value="<?php echo $grp_row['adresse2_user']; ?>">
                                                <label class="switch">
                                                    <input name="adresse2_user_checkbox" type="checkbox" <?php echo $adresse2Check; ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                            <div>
                                                <input type="text" name="email_user" value="<?php echo $grp_row['email_user']; ?>">
                                                <label class="switch">
                                                    <input name="email_user_checkbox" type="checkbox" <?php echo $emailCheck; ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div id="gerer_groupes_4-2">
                                            <div>
                                                <input type="text" name="ville" value="<?php echo $grp_row['ville']; ?>">
                                                <label class="switch">
                                                    <input name="ville_checkbox" type="checkbox" <?php echo $villeCheck; ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                            <div>
                                                <input type="text" name="pays" value="<?php echo $grp_row['pays']; ?>">
                                                <label class="switch">
                                                    <input name="pays_checkbox" type="checkbox" <?php echo $paysCheck; ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                            <div>
                                                <input type="text" name="latitude_user" value="<?php echo $grp_row['latitude_user']; ?>">
                                                <label class="switch">
                                                    <input name="latitude_user_checkbox" type="checkbox" <?php echo $latitudeCheck; ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                            <div>
                                                <input type="text" name="longitude_user" value="<?php echo $grp_row['longitude_user']; ?>">
                                                <label class="switch">
                                                    <input name="longitude_user_checkbox" type="checkbox" <?php echo $longitudeCheck; ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <textarea name="dscrp_user"><?php echo $grp_row['dscrp_user']; ?></textarea>
                                        <input type="hidden" id="id_grp_modificaitions" name="id_user" value="<?php echo $grp_row['id_user']; ?>">
                                        <input type="submit" id="valider_modification" name="valider_modification" value="Valider">
                                    </form>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin-options-aff" id="individus-options">
                <div class="individus-gestions">
                    <div class="individus-gestion-buttons">
                        <a href="admin.php?individus&gerer-individus" class="individus-gestion-button individus-gestion-button-active" id="gerer-individus">Gerer les individus</a>
                        <a href="admin.php?individus&accepter-individus" class="individus-gestion-button" id="accepter-individus">Accepter des individus</a>
                    </div>
                    <div class="individus-gestion-options">
                        <div class="individus-gestion-option" id="accepter-individus-option">
                            <!-- <h5><?php echo $msg; ?></h5> -->
                            <div class="user-notifications" id="individus-accepter-individus">
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
                                            <form method="post" action="admin.php?individus&accepter-individus">
                                                <input type="hidden" name="id_user" id="id_user" value="<?php echo $pre_indv_row['id_user']; ?>">
                                                <input type="submit" name="accepter" id="accepter" value="Accepter">
                                                <input type="submit" name="refuser" id="refuser" value="Refuser">
                                            </form>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                        <div class="individus-gestion-option individus-gestion-option-active" id="gerer-individus-option">
                            <?php
                                while ($indv_row = mysqli_fetch_assoc($indv_result)) {

                                    $info_tlph_auth_query = "SELECT * FROM informations WHERE information = 'tlph_user' AND id_user = '{$indv_row['id_user']}'";
                                    $info_tlph_auth_result = mysqli_query($conn, $info_tlph_auth_query);
                                    $info_tlph_auth_row = mysqli_fetch_assoc($info_tlph_auth_result);

                                    $info_adresse1_auth_query = "SELECT * FROM informations WHERE information = 'adresse1_user' AND id_user = '{$indv_row['id_user']}'";
                                    $info_adresse1_auth_result = mysqli_query($conn, $info_adresse1_auth_query);
                                    $info_adresse1_auth_row = mysqli_fetch_assoc($info_adresse1_auth_result);

                                    $info_adresse2_auth_query = "SELECT * FROM informations WHERE information = 'adresse2_user' AND id_user = '{$indv_row['id_user']}'";
                                    $info_adresse2_auth_result = mysqli_query($conn, $info_adresse2_auth_query);
                                    $info_adresse2_auth_row = mysqli_fetch_assoc($info_adresse2_auth_result);

                                    $info_email_auth_query = "SELECT * FROM informations WHERE information = 'email_user' AND id_user = '{$indv_row['id_user']}'";
                                    $info_email_auth_result = mysqli_query($conn, $info_email_auth_query);
                                    $info_email_auth_row = mysqli_fetch_assoc($info_email_auth_result);

                                    $info_ville_auth_query = "SELECT * FROM informations WHERE information = 'ville' AND id_user = '{$indv_row['id_user']}'";
                                    $info_ville_auth_result = mysqli_query($conn, $info_ville_auth_query);
                                    $info_ville_auth_row = mysqli_fetch_assoc($info_ville_auth_result);

                                    $info_pays_auth_query = "SELECT * FROM informations WHERE information = 'pays' AND id_user = '{$indv_row['id_user']}'";
                                    $info_pays_auth_result = mysqli_query($conn, $info_pays_auth_query);
                                    $info_pays_auth_row = mysqli_fetch_assoc($info_pays_auth_result);

                                    $info_latitude_auth_query = "SELECT * FROM informations WHERE information = 'latitude_user' AND id_user = '{$indv_row['id_user']}'";
                                    $info_latitude_auth_result = mysqli_query($conn, $info_latitude_auth_query);
                                    $info_latitude_auth_row = mysqli_fetch_assoc($info_latitude_auth_result);

                                    $info_longitude_auth_query = "SELECT * FROM informations WHERE information = 'longitude_user' AND id_user = '{$indv_row['id_user']}'";
                                    $info_longitude_auth_result = mysqli_query($conn, $info_longitude_auth_query);
                                    $info_longitude_auth_row = mysqli_fetch_assoc($info_longitude_auth_result);
                                    
                                    if ($info_tlph_auth_row['info_auth'] == '1') {
                                        $tlphCheck = 'checked';}else{$tlphCheck = '';}
                                        
                                    if ($info_adresse1_auth_row['info_auth'] == '1') {
                                        $adresse1Check = 'checked';}else{$adresse1Check = '';}

                                    if ($info_adresse2_auth_row['info_auth'] == '1') {
                                        $adresse2Check = 'checked';}else{$adresse2Check = '';}

                                    if ($info_email_auth_row['info_auth'] == '1') {
                                        $emailCheck = 'checked';}else{$emailCheck = '';}

                                    if ($info_ville_auth_row['info_auth'] == '1') {
                                        $villeCheck = 'checked';}else{$villeCheck = '';}

                                    if ($info_pays_auth_row['info_auth'] == '1') {
                                        $paysCheck = 'checked';}else{$paysCheck = '';}

                                    if ($info_latitude_auth_row['info_auth'] == '1') {
                                        $latitudeCheck = 'checked';}else{$latitudeCheck = '';}

                                    if ($info_longitude_auth_row['info_auth'] == '1') {
                                        $longitudeCheck = 'checked';}else{$longitudeCheck = '';}
                                ?>
                                <div class="individus-informations">
                                    <div class="top-individus-informations" id="individus_informations">
                                        <img src="<?php if($indv_row['img_user']==''){echo'./images/profile.jpg';}else{echo './'.$indv_row['img_user'];}?>" alt="logo">
                                        <h4><?php echo $indv_row['nom_user']; ?></h4>
                                        <form action="admin.php?individus&gerer-individus" method="post">
                                            <input type="submit" name="supprimer_user" value="Supprimer">
                                            <input type="hidden" name="id_user" value="<?php echo $indv_row['id_user']; ?>">
                                        </form>
                                        <button id="modifier_indv">Modifier</button>
                                    </div>
                                    <div class="bottom-individus-informations">
                                        <form action="admin.php?individus&gerer-individus=<?php echo $indv_row['id_user']; ?>" method="post">
                                            <div id="gerer_individus_4-1">
                                                <div>
                                                    <input type="text" name="tlph_user" value="<?php echo $indv_row['tlph_user']; ?>">
                                                    <label class="switch">
                                                        <input name="tlph_user_checkbox" type="checkbox" <?php echo $tlphCheck; ?>>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <div>
                                                    <input type="text" name="adresse1_user" value="<?php echo $indv_row['adresse1_user']; ?>">
                                                    <label class="switch">
                                                        <input name="adresse1_user_checkbox" type="checkbox" <?php echo $adresse1Check; ?>>
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                <div>
                                                    <input type="text" name="adresse2_user" value="<?php echo $indv_row['adresse2_user']; ?>">
                                                    <label class="switch">
                                                        <input name="adresse2_user_checkbox" type="checkbox" <?php echo $adresse2Check; ?>>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <div>
                                                    <input type="text" name="email_user" value="<?php echo $indv_row['email_user']; ?>">
                                                    <label class="switch">
                                                        <input name="email_user_checkbox" type="checkbox" <?php echo $emailCheck; ?>>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div id="gerer_individus_4-2">
                                                <div>
                                                    <input type="text" name="ville" value="<?php echo $indv_row['ville']; ?>">
                                                    <label class="switch">
                                                        <input name="ville_checkbox" type="checkbox" <?php echo $villeCheck; ?>>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <div>
                                                    <input type="text" name="pays" value="<?php echo $indv_row['pays']; ?>">
                                                    <label class="switch">
                                                        <input name="pays_checkbox" type="checkbox" <?php echo $paysCheck; ?>>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <div>
                                                    <input type="text" name="latitude_user" value="<?php echo $indv_row['latitude_user']; ?>">
                                                    <label class="switch">
                                                        <input name="latitude_user_checkbox" type="checkbox" <?php echo $latitudeCheck; ?>>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <div>
                                                    <input type="text" name="longitude_user" value="<?php echo $indv_row['longitude_user']; ?>">
                                                    <label class="switch">
                                                        <input name="longitude_user_checkbox" type="checkbox" <?php echo $longitudeCheck; ?>>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <textarea name="dscrp_user"><?php echo $indv_row['dscrp_user']; ?></textarea>
                                            <input type="hidden" id="id_indv_modificaitions" name="id_user" value="<?php echo $indv_row['id_user']; ?>">
                                            <input type="submit" id="valider_modification" name="valider_modification" value="Valider">
                                        </form>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="./css-js/main.js"></script>
</body>
</html>