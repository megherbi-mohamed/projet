<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_user_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_user_query->execute();
$get_session_user_row = $get_session_user_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_user_row['id_user'];
$id_btq = htmlspecialchars($_POST['id_btq']);
$id_prm = htmlspecialchars($_POST['id_prm']);
$id_prd = htmlspecialchars($_POST['id_prd']);
$media_url = htmlspecialchars($_POST['media_url']);
$prix_prd = htmlspecialchars($_POST['prix_prd']);
$etat = 1;

$get_product_promotion_query = $conn->prepare("SELECT id_prd_prm FROM produit_boutique_promotion WHERE id_btq_prd = $id_prd AND id_btq = $id_btq");
$get_product_promotion_query->execute();
if ($get_product_promotion_query->rowCount() > 0) {
    $update_product_promotion_query = $conn->prepare("UPDATE produit_boutique_promotion SET media_url = '$media_url', prix_prm_prd = '$prix_prd' WHERE id_btq_prd = $id_prd AND id_btq = $id_btq");
    if ($update_product_promotion_query->execute()) {
        echo 1;
    }
    else{
        echo 0;
    }
}
else{
    $create_product_promotion_query = $conn->prepare("INSERT INTO produit_boutique_promotion (id_user,id_btq,id_prm,id_btq_prd,media_url,prix_prm_prd,etat) VALUES (:id_user,:id_btq,:id_prm,:id_btq_prd,:media_url,:prix_prm_prd,:etat)");
    $create_product_promotion_query->bindParam(':id_user',$id_user);
    $create_product_promotion_query->bindParam(':id_btq',$id_btq);
    $create_product_promotion_query->bindParam(':id_prm',$id_prm);
    $create_product_promotion_query->bindParam(':id_btq_prd',$id_prd);
    $create_product_promotion_query->bindParam(':media_url',$media_url);
    $create_product_promotion_query->bindParam(':prix_prm_prd',$prix_prd);
    $create_product_promotion_query->bindParam(':etat',$etat);
    if ($create_product_promotion_query->execute()) {
       echo 1;
    }
    else{
        echo 0;
    }  
}
?>