<?php
session_start();
include_once './bdd/connexion.php';
$id_pub = htmlspecialchars($_POST['id_pub']);
$delete_pub_query = $conn->prepare("DELETE FROM publications WHERE etat = 1 AND id_user = {$_SESSION['user']}");
if ($delete_pub_query->execute()) {
    $get_pub_media_query = $conn->prepare("SELECT * FROM publications_media WHERE id_pub = '$id_pub' AND etat = 1");
    if($get_pub_media_query->execute()){
        while($get_pub_media_row = $get_pub_media_query->fetch(PDO::FETCH_ASSOC)){
            unlink($get_pub_media_row['media_url']);
        }
        $delete_pub_media_query = $conn->prepare("DELETE FROM publications_media WHERE id_user = {$_SESSION['user']} AND id_pub = '$id_pub' AND etat = 1");
        if ($delete_pub_media_query->execute()) {
            echo 1;
        }
        else{
            echo 0;
        }
    }else{
        echo 0;
    }
}
else{
    echo 0;
}
?>