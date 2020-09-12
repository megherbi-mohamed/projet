<?php 
session_start();
include_once './bdd/connexion.php';
$id_btq = htmlspecialchars($_POST['id_btq']);
$nom_btq = htmlspecialchars($_POST['nom_btq']);
$ville_btq = htmlspecialchars($_POST['ville_btq']);
$commune_btq = htmlspecialchars($_POST['commune_btq']);
$adresse_btq = htmlspecialchars($_POST['adresse_btq']);
$email_btq = htmlspecialchars($_POST['email_btq']);
$tlph_btq = htmlspecialchars($_POST['tlph_btq']);
$dscrp_btq = htmlspecialchars($_POST['dscrp_btq']);

echo 1;
?>