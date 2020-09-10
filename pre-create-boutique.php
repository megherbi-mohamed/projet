<?php
session_start();
include_once './bdd/connexion.php';
$create_btq_query = "INSERT INTO boutiques (id_createur,etat) VALUES ({$_SESSION['user']},1)";
if (mysqli_query($conn, $create_btq_query)) {
    $get_btq_query = "SELECT id_btq FROM boutiques WHERE id_createur = {$_SESSION['user']} AND etat = 1";
    $get_btq_result = mysqli_query($conn,$get_btq_query);
    if($get_btq_row = mysqli_fetch_assoc($get_btq_result)){
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