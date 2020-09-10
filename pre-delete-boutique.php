<?php
session_start();
include_once './bdd/connexion.php';
$id_btq = htmlspecialchars($_POST['id_btq']);
$delete_btq_query = "DELETE FROM boutiques WHERE etat = 1 AND id_createur = {$_SESSION['user']}";
if (mysqli_query($conn, $delete_btq_query)) {
    echo 1;
}
else{
    echo 0;
}
?>