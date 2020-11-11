<?php 
session_start();
include_once './bdd/connexion.php';

$email_user = $_POST['email_user'];
$mtp_user = $_POST['mtp_user'];
$hash_mtp_user = hash('sha256', $mtp_user);

if (filter_var($email_user, FILTER_VALIDATE_EMAIL)) {
    $cnnx_user_query = $conn->prepare("SELECT * FROM utilisateurs WHERE email_user = '$email_user' AND mtp_user = '$hash_mtp_user'");
    $incrm_cnx_query = $conn->prepare("UPDATE utilisateurs SET cnx_count = cnx_count+1 WHERE email_user = '$email_user' AND mtp_user = '$hash_mtp_user'");
    $incrm_cnx_query->execute();
}
else{
    $cnnx_user_query = $conn->prepare("SELECT * FROM utilisateurs WHERE tlph_user = '$email_user' AND mtp_user = '$hash_mtp_user'");
    $incrm_cnx_query = $conn->prepare("UPDATE utilisateurs SET cnx_count = cnx_count+1 WHERE email_user = '$email_user' AND mtp_user = '$hash_mtp_user'");
    $incrm_cnx_query->execute();
}

$cnnx_user_query->execute();
$count = $cnnx_user_query->rowCount();
$row = $cnnx_user_query->fetch(PDO::FETCH_ASSOC);

if ($count == 1) {
    $id_user = $row['id_user'];

    // get online user 
    $get_user_sessions_query = $conn->prepare("SELECT CASE WHEN session_5 IS NOT NULL THEN 5 WHEN session_4 IS NOT NULL THEN 4 WHEN session_3 IS NOT NULL THEN 3 WHEN session_2 IS NOT NULL THEN 2 WHEN session_1 IS NOT NULL THEN 1 END AS sessions_user FROM sessions_active WHERE id_user = $id_user");
    $get_user_sessions_query->execute();
    $get_user_sessions_row = $get_user_sessions_query->fetch(PDO::FETCH_ASSOC);
    $sessions_user = $get_user_sessions_row['sessions_user'];   
    
    // get online boutique
    $get_first_btq_query = $conn->prepare("SELECT id_btq FROM boutiques WHERE id_createur = $id_user");
    $get_first_btq_query->execute();
    $sessions_btq = 0;
    while ($get_first_btq_row = $get_first_btq_query->fetch(PDO::FETCH_ASSOC)) {
        $id_btq = $get_first_btq_row['id_btq'];
        $get_btq_sessions_query = $conn->prepare("SELECT CASE WHEN session_5 IS NOT NULL THEN 5 WHEN session_4 IS NOT NULL THEN 4 WHEN session_3 IS NOT NULL THEN 3 WHEN session_2 IS NOT NULL THEN 2 WHEN session_1 IS NOT NULL THEN 1 END AS sessions_btq FROM sessions_active WHERE id_user = $id_btq");
        $get_btq_sessions_query->execute();
        $get_btq_sessions_row = $get_btq_sessions_query->fetch(PDO::FETCH_ASSOC);
        $sessions_btq = $get_btq_sessions_row['sessions_btq'];
        $sessions_btq =+ $sessions_btq;
    }
    
    $all_sessions = $sessions_user + $sessions_btq;

    $get_all_sessions_query = $conn->prepare("SELECT * FROM gerer_connexion WHERE id_user = $id_user");
    $get_all_sessions_query->execute();
    $get_all_sessions_row = $get_all_sessions_query->fetch(PDO::FETCH_ASSOC);
    
    $session_1 = $get_all_sessions_row['id_user_1'];
    $session_2 = $get_all_sessions_row['id_user_2'];
    $session_3 = $get_all_sessions_row['id_user_3'];
    $session_4 = $get_all_sessions_row['id_user_4'];
    $session_5 = $get_all_sessions_row['id_user_5'];

    $get_current_sessions_query = $conn->prepare("SELECT session_1,session_2,session_3,session_4,session_5 FROM sessions_active WHERE id_user = $id_user");
    $get_current_sessions_query->execute();
    $get_current_sessions_row = $get_current_sessions_query->fetch(PDO::FETCH_ASSOC);
    
    $session1 = $get_current_sessions_row['session_1'];
    $session2 = $get_current_sessions_row['session_2'];
    $session3 = $get_current_sessions_row['session_3'];
    $session4 = $get_current_sessions_row['session_4'];
    $session5 = $get_current_sessions_row['session_5'];
    
    $sessions = array($session1,$session2,$session3,$session4,$session5);

    // verify reserved session
    $get_btq_user_query = $conn->prepare("SELECT id_btq FROM boutiques WHERE id_createur = $id_user");
    $get_btq_user_query->execute();
    $reserved_session = array();
    while ($get_btq_user_row = $get_btq_user_query->fetch(PDO::FETCH_ASSOC)) {
        $id_btq = $get_btq_user_row['id_btq'];
        $get_btq_sessions_query = $conn->prepare("SELECT * FROM gerer_connexion WHERE id_user = $id_btq");
        $get_btq_sessions_query->execute();
        $get_btq_sessions_row = $get_btq_sessions_query->fetch(PDO::FETCH_ASSOC);
        $session_btq_1 = $get_btq_sessions_row['id_user_1'];
        $session_btq_2 = $get_btq_sessions_row['id_user_2'];
        $session_btq_3 = $get_btq_sessions_row['id_user_3'];
        $session_btq_4 = $get_btq_sessions_row['id_user_4'];
        $session_btq_5 = $get_btq_sessions_row['id_user_5'];

        $get_reserved_session_query = $conn->prepare("SELECT session_usr FROM sessions_reserves WHERE 
        (session_btq = $session_btq_1 OR session_btq = $session_btq_2 OR
        session_btq = $session_btq_3 OR session_btq = $session_btq_4 OR
        session_btq = $session_btq_5) AND session_usr IS NOT NULL");
        $get_reserved_session_query->execute();
        while ($get_reserved_session_row = $get_reserved_session_query->fetch(PDO::FETCH_ASSOC)) {
            $session_usr = $get_reserved_session_row['session_usr'];
            array_push($reserved_session, $session_usr);
        }
    }

    if (!in_array($session_1, $sessions) && !in_array($session_1, $reserved_session)) {
        $_SESSION['user'] = $session_1;
        echo $_SESSION['user'];
    }
    else if (!in_array($session_2, $sessions) && !in_array($session_2, $reserved_session)) {
        $_SESSION['user'] = $session_2;
        echo $_SESSION['user'];
    }
    else if (!in_array($session_3, $sessions) && !in_array($session_3, $reserved_session)) {
        $_SESSION['user'] = $session_3;
        echo $_SESSION['user'];
    }
    else if (!in_array($session_4, $sessions) && !in_array($session_4, $reserved_session)) {
        $_SESSION['user'] = $session_4;
        echo $_SESSION['user'];
    }
    else if (!in_array($session_5, $sessions) && !in_array($session_5, $reserved_session)) {
        $_SESSION['user'] = $session_5;
        echo $_SESSION['user'];
    }
    else{
        echo 0;
    }
}
else{
    echo 0;
}
?>