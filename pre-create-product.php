<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_idSender_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_idSender_query->execute();
$get_session_idSender_row = $get_session_idSender_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_idSender_row['id_user'];

$id_session_btq = htmlspecialchars($_POST['id_btq']);
$get_session_btq_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session_btq' OR id_user_1 = '$id_session_btq' OR id_user_2 = '$id_session_btq' 
                                            OR id_user_3 = '$id_session_btq' OR id_user_4 = '$id_session_btq' OR id_user_5 = '$id_session_btq'");
$get_session_btq_query->execute();
$get_session_btq_row = $get_session_btq_query->fetch(PDO::FETCH_ASSOC);
$id_btq = $get_session_btq_row['id_user'];

$etat = 1;
$create_prd_query = $conn->prepare("INSERT INTO produit_boutique (id_btq,id_user,etat) VALUES (:id_btq,:id_user,:etat)");
$create_prd_query->bindParam(':id_btq',$id_btq);
$create_prd_query->bindParam(':id_user',$id_user);
$create_prd_query->bindParam(':etat',$etat);
if ($create_prd_query->execute()) {
    $get_prd_query = $conn->prepare("SELECT id_prd FROM produit_boutique WHERE id_btq = '$id_btq' AND etat = 1");
    $get_prd_query->execute();
    if($get_prd_row = $get_prd_query->fetch(PDO::FETCH_ASSOC)){
        echo $get_prd_row['id_prd'];
    }
    else{
        echo 0;
    }
}
else{
    echo 0;
}
?>