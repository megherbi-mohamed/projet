<?php
session_start();
include_once './bdd/connexion.php';
$id_user = htmlspecialchars($_SESSION['user']);
$delete_bt_prd_query = $conn->prepare("INSERT INTO produit_boutdechantier (id_user,etat) VALUES ('$id_user',1)");
if ($delete_bt_prd_query->execute()) {
    $get_bt_prd_query = $conn->prepare("SELECT id_prd FROM produit_boutdechantier WHERE id_user = '$id_user' AND etat = 1");
    $get_bt_prd_query->execute();
    if($get_bt_prd_row = $get_bt_prd_query->fetch(PDO::FETCH_ASSOC)){
        echo $get_bt_prd_row['id_prd'];
    }
    else{
        echo 0;
    }
}
else{
    echo 0;
}
?>