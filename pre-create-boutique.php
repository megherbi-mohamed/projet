<?php
session_start();
include_once './bdd/connexion.php';
$id_user = htmlspecialchars($_SESSION['user']);
$type_user = 'boutique';
$etat = 1;
$create_btq_query = $conn->prepare("INSERT INTO boutiques (type_user,id_createur,etat) VALUES (:type_user,:id_createur,:etat)");
$create_btq_query->bindParam(':type_user', $type_user);
$create_btq_query->bindParam(':id_createur', $id_user);
$create_btq_query->bindParam(':etat', $etat);
if ($create_btq_query->execute()) {
    $get_btq_query = $conn->prepare("SELECT id_btq FROM boutiques WHERE id_createur = '$id_user' AND etat = 1");
    $get_btq_query->execute();
    if($get_btq_row = $get_btq_query->fetch(PDO::FETCH_ASSOC)){
        echo $get_btq_row['id_btq'];
    }
    else{
        echo 0;
    }
}
else{
    echo 0;
}
?>