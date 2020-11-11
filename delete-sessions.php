<?php 
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_user_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_user_query->execute();
$get_session_user_row = $get_session_user_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_user_row['id_user'];

$get_current_sessions_query = $conn->prepare("SELECT sessions_user FROM utilisateurs WHERE id_user = $id_user");
$get_current_sessions_query->execute();
$get_current_sessions_row = $get_current_sessions_query->fetch(PDO::FETCH_ASSOC);

$sessions = $get_current_sessions_row['sessions_user'];
$session = ','.$id_session.',';
$session_user = str_replace($session, '', $sessions);

$remove_session_user_qeury = $conn->prepare("UPDATE utilisateurs SET sessions_user = '$session_user' WHERE id_user = $id_user");

if ($remove_session_user_qeury->execute()) {
    $get_btq_user_query = $conn->prepare("SELECT id_btq FROM boutiques WHERE id_createur = $id_user");
    $get_btq_user_query->execute();
    while ($get_btq_user_row = $get_btq_user_query->fetch(PDO::FETCH_ASSOC)) {
        $id_btq = $get_btq_user_row['id_btq'];

        $get_btq_sessions_query = $conn->prepare("SELECT sessions_btq FROM boutiques WHERE id_btq = $id_btq");
        $get_btq_sessions_query->execute();
        $get_btq_sessions_row = $get_btq_sessions_query->fetch(PDO::FETCH_ASSOC);
        $sessionsBtq = $get_btq_sessions_row['sessions_btq'];
        
        $get_all_btq_sessions_query = $conn->prepare("SELECT * FROM gerer_connexion WHERE id_user = $id_btq");
        $get_all_btq_sessions_query->execute();
        $get_all_btq_sessions_row = $get_all_btq_sessions_query->fetch(PDO::FETCH_ASSOC);

        $session_btq_1 = ','.$id_session.'0'.$get_all_btq_sessions_row['id_user'].',';
        $session_btq_2 = ','.$id_session.'0'.$get_all_btq_sessions_row['id_user_1'].',';
        $session_btq_3 = ','.$id_session.'0'.$get_all_btq_sessions_row['id_user_2'].',';
        $session_btq_4 = ','.$id_session.'0'.$get_all_btq_sessions_row['id_user_3'].',';
        $session_btq_5 = ','.$id_session.'0'.$get_all_btq_sessions_row['id_user_4'].',';
        $session_btq_6 = ','.$id_session.'0'.$get_all_btq_sessions_row['id_user_5'].',';
        
        if (strpos($sessionsBtq, $session_btq_1) !== false) {
            $sessions_btq = str_replace($session_btq_1, '', $sessionsBtq);
            $remove_session_btq_query = $conn->prepare("UPDATE boutiques SET sessions_btq = '$sessions_btq' WHERE id_btq = $id_btq");
            if ($remove_session_btq_query->execute()) {
                session_unset();
                session_destroy();
                ob_start();
                header("location: inscription-connexion");
            }
        }
        else if (strpos($sessionsBtq, $session_btq_2) !== false) {
            $sessions_btq = str_replace($session_btq_2, '', $sessionsBtq);
            $remove_session_btq_query = $conn->prepare("UPDATE boutiques SET sessions_btq = '$sessions_btq' WHERE id_btq = $id_btq");
            if ($remove_session_btq_query->execute()) {
                session_unset();
                session_destroy();
                ob_start();
                header("location: inscription-connexion");
            }
        }
        else if (strpos($sessionsBtq, $session_btq_3) !== false) {
            $sessions_btq = str_replace($session_btq_3, '', $sessionsBtq);
            $remove_session_btq_query = $conn->prepare("UPDATE boutiques SET sessions_btq = '$sessions_btq' WHERE id_btq = $id_btq");
            if ($remove_session_btq_query->execute()) {
                session_unset();
                session_destroy();
                ob_start();
                header("location: inscription-connexion");
            }
        }
        else if (strpos($sessionsBtq, $session_btq_4) !== false) {
            $sessions_btq = str_replace($session_btq_4, '', $sessionsBtq);
            $remove_session_btq_query = $conn->prepare("UPDATE boutiques SET sessions_btq = '$sessions_btq' WHERE id_btq = $id_btq");
            if ($remove_session_btq_query->execute()) {
                session_unset();
                session_destroy();
                ob_start();
                header("location: inscription-connexion");
            }
        }
        else if (strpos($sessionsBtq, $session_btq_5) !== false) {
            $sessions_btq = str_replace($session_btq_5, '', $sessionsBtq);
            $remove_session_btq_query = $conn->prepare("UPDATE boutiques SET sessions_btq = '$sessions_btq' WHERE id_btq = $id_btq");
            if ($remove_session_btq_query->execute()) {
                session_unset();
                session_destroy();
                ob_start();
                header("location: inscription-connexion");
            }
        }
        else if (strpos($sessionsBtq, $session_btq_6) !== false) {
            $sessions_btq = str_replace($session_btq_6, '', $sessionsBtq);
            $remove_session_btq_query = $conn->prepare("UPDATE boutiques SET sessions_btq = '$sessions_btq' WHERE id_btq = $id_btq");
            if ($remove_session_btq_query->execute()) {
                session_unset();
                session_destroy();
                ob_start();
                header("location: inscription-connexion");
            }
        }
        else{
            echo 0;
        }
    }
}
?>