<?php
session_start();
include_once './bdd/connexion.php';
if (isset($_SESSION['user'])) {
    // $id_session = htmlspecialchars($_SESSION['user']);
    // $get_session_user_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
    //                                             OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
    // $get_session_user_query->execute();
    // $get_session_user_row = $get_session_user_query->fetch(PDO::FETCH_ASSOC);
    // $id_user = $get_session_user_row['id_user'];

    // $get_current_sessions_query = $conn->prepare("SELECT session_1,session_2,session_3,session_4,session_5 FROM sessions_active WHERE id_user = $id_user");
    // $get_current_sessions_query->execute();
    // $get_current_sessions_row = $get_current_sessions_query->fetch(PDO::FETCH_ASSOC);
    
    // $session1 = $get_current_sessions_row['session_1'];
    // $session2 = $get_current_sessions_row['session_2'];
    // $session3 = $get_current_sessions_row['session_3'];
    // $session4 = $get_current_sessions_row['session_4'];
    // $session5 = $get_current_sessions_row['session_5'];

    // if ($id_session == $session1) {
    //     $remove_session_user_qeury = $conn->prepare("UPDATE sessions_active SET session_1 = null WHERE id_user = $id_user");
    // }
    // else if ($id_session == $session2) {
    //     $remove_session_user_qeury = $conn->prepare("UPDATE sessions_active SET session_2 = null WHERE id_user = $id_user");
    // }
    // else if ($id_session == $session3) {
    //     $remove_session_user_qeury = $conn->prepare("UPDATE sessions_active SET session_3 = null WHERE id_user = $id_user");
    // }
    // else if ($id_session == $session4) {
    //     $remove_session_user_qeury = $conn->prepare("UPDATE sessions_active SET session_4 = null WHERE id_user = $id_user");
    // }
    // else if ($id_session == $session5) {
    //     $remove_session_user_qeury = $conn->prepare("UPDATE sessions_active SET session_5 = null WHERE id_user = $id_user");
    // }

    // if ($remove_session_user_qeury->execute()) {
        session_unset();
        session_destroy();
        ob_start();
        header("location: inscription-connexion");
    // }

    // if ($remove_session_user_qeury->execute()) {
    //     $get_btq_user_query = $conn->prepare("SELECT id_btq FROM boutiques WHERE id_createur = $id_user");
    //     $get_btq_user_query->execute();
    //     if ($get_btq_user_query->rowCount()) {
    //         while ($get_btq_user_row = $get_btq_user_query->fetch(PDO::FETCH_ASSOC)) {
    //             $id_btq = $get_btq_user_row['id_btq'];

    //             $get_btq_sessions_query = $conn->prepare("SELECT sessions_btq FROM boutiques WHERE id_btq = $id_btq");
    //             $get_btq_sessions_query->execute();
    //             $get_btq_sessions_row = $get_btq_sessions_query->fetch(PDO::FETCH_ASSOC);
    //             $sessionsBtq = $get_btq_sessions_row['sessions_btq'];
                
    //             $get_all_btq_sessions_query = $conn->prepare("SELECT * FROM gerer_connexion WHERE id_user = $id_btq");
    //             $get_all_btq_sessions_query->execute();
    //             $get_all_btq_sessions_row = $get_all_btq_sessions_query->fetch(PDO::FETCH_ASSOC);

    //             $session_btq_1 = ','.$id_session.'0'.$get_all_btq_sessions_row['id_user'].',';
    //             $session_btq_2 = ','.$id_session.'0'.$get_all_btq_sessions_row['id_user_1'].',';
    //             $session_btq_3 = ','.$id_session.'0'.$get_all_btq_sessions_row['id_user_2'].',';
    //             $session_btq_4 = ','.$id_session.'0'.$get_all_btq_sessions_row['id_user_3'].',';
    //             $session_btq_5 = ','.$id_session.'0'.$get_all_btq_sessions_row['id_user_4'].',';
    //             $session_btq_6 = ','.$id_session.'0'.$get_all_btq_sessions_row['id_user_5'].',';
                
    //             if (strpos($sessionsBtq, $session_btq_1) !== false) {
    //                 $sessions_btq = str_replace($session_btq_1, '', $sessionsBtq);
    //                 $remove_session_btq_query = $conn->prepare("UPDATE boutiques SET sessions_btq = '$sessions_btq' WHERE id_btq = $id_btq");
    //                 if ($remove_session_btq_query->execute()) {
    //                     session_unset();
    //                     session_destroy();
    //                     ob_start();
    //                     header("location: inscription-connexion");
    //                 }
    //             }
    //             else if (strpos($sessionsBtq, $session_btq_2) !== false) {
    //                 $sessions_btq = str_replace($session_btq_2, '', $sessionsBtq);
    //                 $remove_session_btq_query = $conn->prepare("UPDATE boutiques SET sessions_btq = '$sessions_btq' WHERE id_btq = $id_btq");
    //                 if ($remove_session_btq_query->execute()) {
    //                     session_unset();
    //                     session_destroy();
    //                     ob_start();
    //                     header("location: inscription-connexion");
    //                 }
    //             }
    //             else if (strpos($sessionsBtq, $session_btq_3) !== false) {
    //                 $sessions_btq = str_replace($session_btq_3, '', $sessionsBtq);
    //                 $remove_session_btq_query = $conn->prepare("UPDATE boutiques SET sessions_btq = '$sessions_btq' WHERE id_btq = $id_btq");
    //                 if ($remove_session_btq_query->execute()) {
    //                     session_unset();
    //                     session_destroy();
    //                     ob_start();
    //                     header("location: inscription-connexion");
    //                 }
    //             }
    //             else if (strpos($sessionsBtq, $session_btq_4) !== false) {
    //                 $sessions_btq = str_replace($session_btq_4, '', $sessionsBtq);
    //                 $remove_session_btq_query = $conn->prepare("UPDATE boutiques SET sessions_btq = '$sessions_btq' WHERE id_btq = $id_btq");
    //                 if ($remove_session_btq_query->execute()) {
    //                     session_unset();
    //                     session_destroy();
    //                     ob_start();
    //                     header("location: inscription-connexion");
    //                 }
    //             }
    //             else if (strpos($sessionsBtq, $session_btq_5) !== false) {
    //                 $sessions_btq = str_replace($session_btq_5, '', $sessionsBtq);
    //                 $remove_session_btq_query = $conn->prepare("UPDATE boutiques SET sessions_btq = '$sessions_btq' WHERE id_btq = $id_btq");
    //                 if ($remove_session_btq_query->execute()) {
    //                     session_unset();
    //                     session_destroy();
    //                     ob_start();
    //                     header("location: inscription-connexion");
    //                 }
    //             }
    //             else if (strpos($sessionsBtq, $session_btq_6) !== false) {
    //                 $sessions_btq = str_replace($session_btq_6, '', $sessionsBtq);
    //                 $remove_session_btq_query = $conn->prepare("UPDATE boutiques SET sessions_btq = '$sessions_btq' WHERE id_btq = $id_btq");
    //                 if ($remove_session_btq_query->execute()) {
    //                     session_unset();
    //                     session_destroy();
    //                     ob_start();
    //                     header("location: inscription-connexion");
    //                 }
    //             }
    //             else{
    //                 echo 0;
    //             }
    //         }
    //     }
    //     else{
    //         session_unset();
    //         session_destroy();
    //         ob_start();
    //         header("location: inscription-connexion");
    //     }
    // }
}
if (isset($_SESSION['btq'])) {
    session_unset();
    session_destroy();
    ob_start();
    header("location: gestion-boutique-connexion");
}
?>