<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_idSender_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_idSender_query->execute();
$get_session_idSender_row = $get_session_idSender_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_idSender_row['id_user'];
$create_pub_query = $conn->prepare("INSERT INTO publications (id_user,etat) VALUES ($id_user,1)");
if ($create_pub_query->execute()) {
    $get_pub_query = $conn->prepare("SELECT id_pub FROM publications WHERE id_user = $id_user AND etat = 1");
    $get_pub_query->execute();
    if($get_pub_row = $get_pub_query->fetch(PDO::FETCH_ASSOC)){
        echo $get_pub_row['id_pub'];
    }
    else{
        echo 0;
    }
}
else{
    echo 0;
}
?>