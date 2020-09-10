<?php
session_start();
include_once './bdd/connexion.php';
$id_user = htmlspecialchars($_SESSION['user']);
$id_pub = htmlspecialchars($_POST['id_pub']);
$upload_location = "publications-media/";
$filename = $_FILES['video']['name'];
$videoName = time().$id_user.'.mp4';
$path = $upload_location.$videoName;
$create_video_query = "INSERT INTO publications_media (id_pub,id_user,media_type,media_url,etat) VALUES ('$id_pub',{$_SESSION['user']},'v','$path',1)";
if (mysqli_query($conn, $create_video_query)) {
    if(move_uploaded_file($_FILES['video']['tmp_name'],$path)){
        echo json_encode($path);
        die;    
    }
    else{
        echo 0;
    }
}
else{
    echo 0;
}
?>