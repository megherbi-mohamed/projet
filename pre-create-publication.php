<?php
session_start();
include_once './bdd/connexion.php';
$create_pub_query = $conn->prepare("INSERT INTO publications (id_user,etat) VALUES ({$_SESSION['user']},1)");
if ($create_pub_query->execute()) {
    $get_pub_query = $conn->prepare("SELECT id_pub FROM publications WHERE id_user = {$_SESSION['user']} AND etat = 1");
    $get_pub_query->execute();
    if($get_pub_row = $get_pub_query->fetch(PDO::FETCH_ASSOC)){
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