<?php
session_start();
include_once './bdd/connexion.php';
$id_pub = htmlspecialchars($_POST['id_pub']);
$remove_saved_publication_query = "DELETE FROM publications_enregistres WHERE id_pub = '$id_pub' AND id_user = {$_SESSION['user']}";
if (mysqli_query($conn, $remove_saved_publication_query)) {
    echo 1;
}
else{
    echo 0;
}
?>