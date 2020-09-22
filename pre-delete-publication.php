<?php
session_start();
include_once './bdd/connexion.php';
$id_pub = htmlspecialchars($_POST['id_pub']);
$delete_pub_query = "DELETE FROM publications WHERE etat = 1 AND id_user = {$_SESSION['user']}";
if (mysqli_query($conn, $delete_pub_query)) {
    $get_pub_media_query = "SELECT * FROM publications_media WHERE id_pub = '$id_pub' AND etat = 1";
    if($get_pub_media_result = mysqli_query($conn,$get_pub_media_query)){
        while($get_pub_media_row = mysqli_fetch_assoc($get_pub_media_result)){
            unlink($get_pub_media_row['media_url']);
        }
        $delete_pub_media_query = "DELETE FROM publications_media WHERE id_user = {$_SESSION['user']} AND id_pub = '$id_pub' AND etat = 1";
        if (mysqli_query($conn, $delete_pub_media_query)) {
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