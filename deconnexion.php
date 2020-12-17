<?php
session_start();
include_once './bdd/connexion.php';
if (isset($_SESSION['user'])) {
    session_unset();
    session_destroy();
    ob_start();
    header("location: inscription-connexion");
}
if (isset($_SESSION['btq'])) {
    $id_session_btq = htmlspecialchars($_SESSION['btq']);
    $get_session_btq_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session_btq' OR id_user_1 = '$id_session_btq' OR id_user_2 = '$id_session_btq' 
                                                OR id_user_3 = '$id_session_btq' OR id_user_4 = '$id_session_btq' OR id_user_5 = '$id_session_btq'");
    $get_session_btq_query->execute();
    $get_session_btq_row = $get_session_btq_query->fetch(PDO::FETCH_ASSOC);
    $id_btq = $get_session_btq_row['id_user'];
    $last_connexion_query = $conn->prepare("UPDATE admin_boutique SET etat = 0 WHERE id_btq = $id_btq");
    if ($last_connexion_query->execute()) {
        session_unset();
        session_destroy();
        ob_start();
        header("location: gestion-boutique-connexion");
    }
    else{
        echo 0;
    }
}
?>