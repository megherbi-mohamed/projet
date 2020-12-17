<?php 
session_start();
include_once './bdd/connexion.php';
$matricule_adm = htmlspecialchars($_POST['matricule_adm']);
$mtp_adm = htmlspecialchars($_POST['mtp_adm']);
$hash_mtp_adm = hash('sha256', $mtp_adm);
$date = date("Y-m-d h:i:sa");
$cnx_admin_btq_query = $conn->prepare("SELECT id_btq FROM admin_boutique WHERE matricule_adm = '$matricule_adm' AND mtp_adm = '$hash_mtp_adm'");
if ($cnx_admin_btq_query->execute()) {
    if ($cnx_admin_btq_query->rowCount() > 0) {
        $cnx_admin_btq_row = $cnx_admin_btq_query->fetch(PDO::FETCH_ASSOC);
        $id_btq = $cnx_admin_btq_row['id_btq'];
        $get_current_sessions_query = $conn->prepare("SELECT session_1,session_2,session_3,session_4,session_5 FROM sessions_active WHERE id_user = $id_btq");
        if ($get_current_sessions_query->execute()) {
            $get_current_sessions_row = $get_current_sessions_query->fetch(PDO::FETCH_ASSOC);
            $session1 = $get_current_sessions_row['session_1'];
            $session2 = $get_current_sessions_row['session_2'];
            $session3 = $get_current_sessions_row['session_3'];
            $session4 = $get_current_sessions_row['session_4'];
            $session5 = $get_current_sessions_row['session_5'];
            $sessions = array($session1,$session2,$session3,$session4,$session5);
            $get_all_btq_sessions_query = $conn->prepare("SELECT * FROM gerer_connexion WHERE id_user = $id_btq");
            if ($get_all_btq_sessions_query->execute()) {
                $get_all_btq_sessions_row = $get_all_btq_sessions_query->fetch(PDO::FETCH_ASSOC);
                $session_btq_1 = $get_all_btq_sessions_row['id_user_1'];
                $session_btq_2 = $get_all_btq_sessions_row['id_user_2'];
                $session_btq_3 = $get_all_btq_sessions_row['id_user_3'];
                $session_btq_4 = $get_all_btq_sessions_row['id_user_4'];
                $session_btq_5 = $get_all_btq_sessions_row['id_user_5'];
                if (!in_array($session_btq_1, $sessions)) {
                    $last_connexion_query = $conn->prepare("UPDATE admin_boutique SET last_cnx = '$date',etat = 1 WHERE id_btq = $id_btq");
                    if ($last_connexion_query->execute()) {
                        $_SESSION['btq'] = $session_btq_1;
                        echo $session_btq_1;
                    }
                    else{
                        echo 0;
                    }
                }
                else if (!in_array($session_btq_2, $sessions)) {
                    $last_connexion_query = $conn->prepare("UPDATE admin_boutique SET last_cnx = '$date',etat = 1 WHERE id_btq = $id_btq");
                    if ($last_connexion_query->execute()) {
                        $_SESSION['btq'] = $session_btq_2;
                        echo $session_btq_2;
                    }
                    else{
                        echo 0;
                    }
                }
                else if (!in_array($session_btq_3, $sessions)) {
                    $last_connexion_query = $conn->prepare("UPDATE admin_boutique SET last_cnx = '$date',etat = 1 WHERE id_btq = $id_btq");
                    if ($last_connexion_query->execute()) {
                        $_SESSION['btq'] = $session_btq_2;
                        echo $session_btq_2;
                    }
                    else{
                        echo 0;
                    }
                }
                else if (!in_array($session_btq_4, $sessions)) {
                    $last_connexion_query = $conn->prepare("UPDATE admin_boutique SET last_cnx = '$date',etat = 1 WHERE id_btq = $id_btq");
                    if ($last_connexion_query->execute()) {
                        $_SESSION['btq'] = $session_btq_2;
                        echo $session_btq_2;
                    }
                    else{
                        echo 0;
                    }
                }
                else if (!in_array($session_btq_5, $sessions)) {
                    $last_connexion_query = $conn->prepare("UPDATE admin_boutique SET last_cnx = '$date',etat = 1 WHERE id_btq = $id_btq");
                    if ($last_connexion_query->execute()) {
                        $_SESSION['btq'] = $session_btq_2;
                        echo $session_btq_2;
                    }
                    else{
                        echo 0;
                    }
                }
                else{
                    echo 0;
                }
            }
            else{
                echo 0;
            }
        }
        else{
            echo 0;
        }
    }
    else {
        echo 2;
    }
}
else{
    echo 0;
}
?>