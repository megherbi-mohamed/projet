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
$delete_btq_query = $conn->prepare("DELETE FROM boutiques WHERE id_btq = $id_btq AND id_createur = $id_user AND etat = 1");
if ($delete_btq_query->execute()) {
    echo 1;
}
else{
    echo 0;
}
?>