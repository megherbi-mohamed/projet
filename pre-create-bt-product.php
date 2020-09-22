<?php
session_start();
include_once './bdd/connexion.php';
$id_user = htmlspecialchars($_SESSION['user']);
$delete_bt_prd_query = "INSERT INTO produit_boutdechantier (id_user,etat) VALUES ('$id_user',1)";
if (mysqli_query($conn, $delete_bt_prd_query)) {
    $get_bt_prd_query = "SELECT id_prd FROM produit_boutdechantier WHERE id_user = $id_user AND etat = 1";
    $get_bt_prd_result = mysqli_query($conn,$get_bt_prd_query);
    if($get_bt_prd_row = mysqli_fetch_assoc($get_bt_prd_result)){
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