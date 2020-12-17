<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_user_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_user_query->execute();
$get_session_user_row = $get_session_user_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_user_row['id_user'];
$nom_user = htmlspecialchars($_POST['nom_user']);
$nom_entrp_user = htmlspecialchars($_POST['nom_entrp_user']);
$categorie_user = htmlspecialchars($_POST['categorie_user']);
$profession_user = htmlspecialchars($_POST['profession_user']);
$ville_user = htmlspecialchars($_POST['ville_user']);
$commune_user = htmlspecialchars($_POST['commune_user']);
$adresse_user = htmlspecialchars($_POST['adresse_user']);
$tlph_user = htmlspecialchars($_POST['tlph_user']);
$description_user = htmlspecialchars($_POST['description_user']);
$latitude_user = htmlspecialchars($_POST['latitude_user']);
$longitude_user = htmlspecialchars($_POST['longitude_user']);

$update_user_query = $conn->prepare("UPDATE utilisateurs SET nom_user=:nom_user,nom_entrp_user=:nom_entrp_user,categorie_user=:categorie_user,profession_user=:profession_user,
ville_user=:ville_user,commune_user=:commune_user,adresse_user=:adresse_user,tlph_user=:tlph_user,description_user=:description_user,latitude_user=:latitude_user,longitude_user=:longitude_user WHERE id_user=:id_user");
$update_user_query->bindParam(':id_user',$id_user);
$update_user_query->bindParam(':nom_user',$nom_user);
$update_user_query->bindParam(':nom_entrp_user',$nom_entrp_user);
$update_user_query->bindParam(':categorie_user',$categorie_user);
$update_user_query->bindParam(':profession_user',$profession_user);
$update_user_query->bindParam(':ville_user',$ville_user);
$update_user_query->bindParam(':commune_user',$commune_user);
$update_user_query->bindParam(':adresse_user',$adresse_user);
$update_user_query->bindParam(':tlph_user',$tlph_user);
$update_user_query->bindParam(':description_user',$description_user);
$update_user_query->bindParam(':latitude_user',$latitude_user);
$update_user_query->bindParam(':longitude_user',$longitude_user);
if ($update_user_query->execute()) {
    echo 1;
}
else{
    echo 0;
}
?>