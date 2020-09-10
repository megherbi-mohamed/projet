<?php
session_start();
include_once './bdd/connexion.php';
$id_pub = htmlspecialchars($_POST['id_pub']);
$lieu_pub = htmlspecialchars($_POST['lieu_pub']);
$description_pub = htmlspecialchars($_POST['description_pub']);

// $d=mktime(11, 14, 54, 8, 12, 2014);
$temp_pub =  date("Y-m-d h:i:sa");

$create_pub_query = "UPDATE publications SET lieu_pub = '$lieu_pub', description_pub = '$description_pub', temp_pub = '$temp_pub',etat = 0, masquer_pub = 0, etat_commentaire = 0 WHERE id_pub = '$id_pub' AND id_user = {$_SESSION['user']}";
if (mysqli_query($conn, $create_pub_query)) {
    $update_media_query = "UPDATE publications_media SET etat = 0 WHERE id_pub = '$id_pub' AND id_user = {$_SESSION['user']}";
    if (mysqli_query($conn, $update_media_query)) {
        echo $id_pub;
    }
    else{
        echo 0;
    }
}
else{
    echo 0;
}
?>