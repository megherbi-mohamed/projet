<?php
session_start();
include_once './bdd/connexion.php';
$id_btq = htmlspecialchars($_POST['id_btq']);
$nom_btq = htmlspecialchars($_POST['nom_btq']);
$categorie = htmlspecialchars($_POST['categorie']);
$sous_categorie = htmlspecialchars($_POST['sous_categorie']);
$ville_btq = htmlspecialchars($_POST['ville_btq']);
$commune_btq = htmlspecialchars($_POST['commune_btq']);
$adresse_btq = htmlspecialchars($_POST['adresse_btq']);
$email_btq = htmlspecialchars($_POST['email_btq']);
$tlph_btq = htmlspecialchars($_POST['tlph_btq']);
$date =  date("Y-m-d");
$create_btq_query = "UPDATE boutiques SET nom_btq = '$nom_btq', categorie = '$categorie', sous_categorie = '$sous_categorie',
                    ville_btq = '$ville_btq', commune_btq = '$commune_btq', adresse_btq = '$adresse_btq', email_btq = '$email_btq',
                    tlph_btq = '$tlph_btq', etat = 0, date = '$date' WHERE id_btq = '$id_btq' AND id_createur = {$_SESSION['user']} AND etat = 1";
if(mysqli_query($conn, $create_btq_query)){
    $id_btq_query = "SELECT id_btq FROM boutiques WHERE id_btq = '$id_btq' AND id_createur = {$_SESSION['user']}";
    $id_btq_result = mysqli_query($conn, $id_btq_query);
    $id_btq_row = mysqli_fetch_assoc($id_btq_result);

    echo $id_btq_row['id_btq'];
}
else{
    echo 0;
}

?>