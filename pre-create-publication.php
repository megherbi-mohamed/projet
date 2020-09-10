<?php
session_start();
include_once './bdd/connexion.php';
$create_pub_query = "INSERT INTO publications (id_user,etat) VALUES ({$_SESSION['user']},1)";
if (mysqli_query($conn, $create_pub_query)) {
    $get_pub_query = "SELECT id_pub FROM publications WHERE id_user = {$_SESSION['user']} AND etat = 1";
    $get_pub_result = mysqli_query($conn,$get_pub_query);
    if($get_pub_row = mysqli_fetch_assoc($get_pub_result)){
        echo $get_pub_row['id_pub'];
    }
    else{
        echo 0;
    }
}
else{
    echo 0;
}
?>