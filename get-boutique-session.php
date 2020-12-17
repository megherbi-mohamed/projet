<?php 
session_start();
include_once './bdd/connexion.php';
$id_btq = htmlspecialchars($_POST['id_btq']);
$id_session = htmlspecialchars($_SESSION['user']);
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
            $insert_reserve_session_query = $conn->prepare("UPDATE sessions_reserves SET session_usr = '$id_session' WHERE session_btq = $session_btq_1");
            if ($insert_reserve_session_query->execute()){
                echo $session_btq_1;
            }
        }
        else if (!in_array($session_btq_2, $sessions)) {
            $insert_reserve_session_query = $conn->prepare("UPDATE sessions_reserves SET session_usr = '$id_session' WHERE session_btq = $session_btq_2");
            if ($insert_reserve_session_query->execute()){
                echo $session_btq_2;
            }
        }
        else if (!in_array($session_btq_3, $sessions)) {
            $insert_reserve_session_query = $conn->prepare("UPDATE sessions_reserves SET session_usr = '$id_session' WHERE session_btq = $session_btq_3");
            if ($insert_reserve_session_query->execute()){
                echo $session_btq_3;
            }
        }
        else if (!in_array($session_btq_4, $sessions)) {
            $insert_reserve_session_query = $conn->prepare("UPDATE sessions_reserves SET session_usr = '$id_session' WHERE session_btq = $session_btq_4");
            if ($insert_reserve_session_query->execute()){
                echo $session_btq_4;
            }
        }
        else if (!in_array($session_btq_5, $sessions)) {
            $insert_reserve_session_query = $conn->prepare("UPDATE sessions_reserves SET session_usr = '$id_session' WHERE session_btq = $session_btq_5");
            if ($insert_reserve_session_query->execute()){
                echo $session_btq_5;
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
?>