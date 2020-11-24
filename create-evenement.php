<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_user_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_user_query->execute();
$get_session_user_row = $get_session_user_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_user_row['id_user'];
$id_evn = htmlspecialchars($_POST['id_evn']);
$titre_evn = htmlspecialchars($_POST['titre_evn']);
$type_evn = htmlspecialchars($_POST['type_evn']);
$description_evn = htmlspecialchars($_POST['description_evn']);
$date_debut_evn = htmlspecialchars($_POST['date_debut_evn']);
$date_fin_evn = htmlspecialchars($_POST['date_fin_evn']);
$nombre_personne_evn = htmlspecialchars($_POST['nombre_personne_evn']);
$convier_amis_evn = htmlspecialchars($_POST['convier_amis_evn']);
$langue_evn = htmlspecialchars($_POST['langue_evn']);
$confidentialite_evn = htmlspecialchars($_POST['confidentialite_evn']);
$tarif_evn = htmlspecialchars($_POST['tarif_evn']);
$ville_evn = htmlspecialchars($_POST['ville_evn']);
$commune_evn = htmlspecialchars($_POST['commune_evn']);
$adresse_evn = htmlspecialchars($_POST['adresse_evn']);
$latitude_evn = htmlspecialchars($_POST['latitude_evn']);
$longitude_evn = htmlspecialchars($_POST['longitude_evn']);
$date_evn =  date("Y-m-d h:i:sa");
$create_evenement_query = $conn->prepare("UPDATE evenements SET titre_evn = '$titre_evn', type_evn = '$type_evn', description_evn = '$description_evn', 
date_debut_evn = '$date_debut_evn', date_fin_evn = '$date_fin_evn', nombre_personne_evn = '$nombre_personne_evn', convier_amis_evn = '$convier_amis_evn', 
langue_evn = '$langue_evn', confidentialite_evn = '$confidentialite_evn', tarif_evn = '$tarif_evn', ville_evn = '$ville_evn', commune_evn = '$commune_evn', 
adresse_evn = '$adresse_evn', latitude_evn = '$latitude_evn', longitude_evn = '$longitude_evn', date_evn = '$date_evn', views_evn = 0, save_evn = 0, etat = 0 WHERE id_evn = $id_evn AND id_user = $id_user");
if ($create_evenement_query->execute()) {
    $update_media_query = $conn->prepare("UPDATE evenements_media SET etat = 0 WHERE id_evn = $id_evn AND id_user = $id_user");
    if ($update_media_query->execute()) {
        echo $id_evn;
    }
    else{
        echo 0;
    }
}
else{
    echo 0;
}
?>