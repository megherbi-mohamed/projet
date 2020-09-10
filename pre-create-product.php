<?php
session_start();
include_once './bdd/connexion.php';
$id_btq = htmlspecialchars($_POST['id_btq']);
$create_prd_query = "INSERT INTO produit_boutique (id_btq,id_user,etat) VALUES ('$id_btq',{$_SESSION['user']},1)";
if (mysqli_query($conn, $create_prd_query)) {
    $get_prd_query = "SELECT id_prd FROM produit_boutique WHERE id_btq = '$id_btq' AND etat = 1";
    $get_prd_result = mysqli_query($conn,$get_prd_query);
    if($get_prd_row = mysqli_fetch_assoc($get_prd_result)){
        echo $get_prd_row['id_prd'];
    }
    else{
        echo 0;
    }
}
else{
    echo 0;
}
?>