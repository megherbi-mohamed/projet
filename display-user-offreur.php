<?php
session_start();
include_once './bdd/connexion.php';
$lieu = $_POST['lieu'];
$display_user_query = "SELECT nom_user,img_user FROM utilisateurs WHERE ";

if(mysqli_query($conn, $valide_activity_query)){
    
}
else{
    echo 0;
}
