<?php 
session_start();
include_once './bdd/connexion.php';
$id_session_btq = htmlspecialchars($_POST['id_btq']);
$get_session_btq_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session_btq' OR id_user_1 = '$id_session_btq' OR id_user_2 = '$id_session_btq' 
                                            OR id_user_3 = '$id_session_btq' OR id_user_4 = '$id_session_btq' OR id_user_5 = '$id_session_btq'");
$get_session_btq_query->execute();
$get_session_btq_row = $get_session_btq_query->fetch(PDO::FETCH_ASSOC);
$id_btq = $get_session_btq_row['id_user'];
$nom_btq = htmlspecialchars($_POST['nom_btq']);
$ville_btq = htmlspecialchars($_POST['ville_btq']);
$commune_btq = htmlspecialchars($_POST['commune_btq']);
$adresse_btq = htmlspecialchars($_POST['adresse_btq']);
$email_btq = htmlspecialchars($_POST['email_btq']);
$tlph_btq = htmlspecialchars($_POST['tlph_btq']);
$dscrp_btq = htmlspecialchars($_POST['dscrp_btq']);

echo 1;
?>