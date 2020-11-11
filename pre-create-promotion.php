<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_idSender_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_idSender_query->execute();
$get_session_idSender_row = $get_session_idSender_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_idSender_row['id_user'];

$etat = 1;
$create_prm_query = $conn->prepare("INSERT INTO promotions (id_user,etat) VALUES (:id_user,:etat)");
$create_prm_query->bindParam(':id_user',$id_user);
$create_prm_query->bindParam(':etat',$etat);
if ($create_prm_query->execute()) {
    $get_prm_query = $conn->prepare("SELECT id_prm FROM promotions WHERE id_user = $id_user AND etat = 1");
    if($get_prm_query->execute()){
        $get_prm_row = $get_prm_query->fetch(PDO::FETCH_ASSOC);
        $create_prm_prd_query = $conn->prepare("INSERT INTO produit_promotion (id_prm,etat) VALUES (:id_prm,:etat)");
        $create_prm_prd_query->bindParam(':id_prm',$get_prm_row['id_prm']);
        $create_prm_prd_query->bindParam(':etat',$etat);
        if ($create_prm_prd_query->execute()) {
            $get_prm_prd_query = $conn->prepare("SELECT id_prd FROM produit_promotion WHERE id_prm = {$get_prm_row['id_prm']} AND etat = 1");
            if ($get_prm_prd_query->execute()) {
                $get_prm_prd_row = $get_prm_prd_query->fetch(PDO::FETCH_ASSOC);
                echo $get_prm_row['id_prm'].'_'.$get_prm_prd_row['id_prd'];
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
?>