<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_idSender_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_idSender_query->execute();
$get_session_idSender_row = $get_session_idSender_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_idSender_row['id_user'];
$id_prm = htmlspecialchars($_POST['id_prm']);
$id_prd = htmlspecialchars($_POST['id_prd']);
$delete_prm_query = $conn->prepare("DELETE FROM promotions WHERE etat = 1 AND id_user = $id_user AND id_prm = $id_prm");
$delete_prm_prd_query = $conn->prepare("DELETE FROM produit_promotion WHERE etat = 1 AND id_prm = $id_prm AND id_prd = $id_prd");
if ($delete_prm_query->execute() && $delete_prm_prd_query->execute()) { 
    $get_promotion_media_query = $conn->prepare("SELECT media_url FROM promotions_media WHERE id_prm = '$id_prm' AND etat = 1");
    $get_promotion_prd_media_query = $conn->prepare("SELECT media_url FROM prm_produits_media WHERE id_prd = '$id_prd' AND etat = 1");
    if($get_promotion_media_query->execute() && $get_promotion_prd_media_query->execute()){
        while($get_promotion_media_row = $get_promotion_media_query->fetch(PDO::FETCH_ASSOC)){
            unlink($get_promotion_media_row['media_url']);
        }
        while($get_promotion_prd_media_row = $get_promotion_prd_media_query->fetch(PDO::FETCH_ASSOC)){
            unlink($get_promotion_prd_media_row['media_url']);
        }
        $delete_promotion_media_query = $conn->prepare("DELETE FROM promotions_media WHERE id_prm = '$id_prm' AND etat = 1");
        $delete_promotion_prd_media_query = $conn->prepare("DELETE FROM prm_produits_media WHERE id_prd = '$id_prd' AND etat = 1");
        if ($delete_promotion_media_query->execute() && $delete_promotion_prd_media_query->execute()) {
            echo 1;
        }
        else{
            echo 0;
        }
    }else{
        echo 0;
    }
}
else{
    echo 0;
}
?>