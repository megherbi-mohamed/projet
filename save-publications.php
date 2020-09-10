<?php
session_start();
include_once './bdd/connexion.php';
$id_pub = htmlspecialchars($_POST['id_pub']);
$save_publication_query = "INSERT INTO publications_enregistres (id_pub,id_user) VALUES ('$id_pub','{$_SESSION['user']}')";
if (mysqli_query($conn, $save_publication_query)) {
    echo 1;
}
else{
    echo 0;
}
?>