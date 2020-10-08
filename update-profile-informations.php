<?php
session_start();
include_once './bdd/connexion.php';
$id_user = htmlspecialchars($_SESSION['user']);
$nom_user = htmlspecialchars($_POST['nom_user']);
$nom_entrp_user = htmlspecialchars($_POST['nom_entrp_user']);
$ville_user = htmlspecialchars($_POST['ville_user']);
$commune_user = htmlspecialchars($_POST['commune_user']);
$adresse_user = htmlspecialchars($_POST['adresse_user']);
$tlph_user = htmlspecialchars($_POST['tlph_user']);
$dscrp_user = htmlspecialchars($_POST['dscrp_user']);

echo 1;
?>