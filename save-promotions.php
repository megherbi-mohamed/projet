<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_user_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_user_query->execute();
$get_session_user_row = $get_session_user_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_user_row['id_user'];
$id_prm = htmlspecialchars($_POST['id_prm']);
$save_promotion_query = $conn->prepare("INSERT INTO promotions_enregistres (id_prm,id_user) VALUES (:id_prm,:id_user)");
$save_promotion_query->bindParam(':id_prm', $id_prm);
$save_promotion_query->bindParam(':id_user',$id_user);
$add_promotion_save_query = $conn->prepare("UPDATE promotions SET save_prm = save_prm + 1 WHERE id_prm = $id_prm");
if ($save_promotion_query->execute() && $add_promotion_save_query->execute()) {
    echo 1;
}
else{
    echo 0;
}
?>