<?php
session_start();
include_once './bdd/connexion.php';
$id_user = htmlspecialchars($_SESSION['user']);
$id_pub = htmlspecialchars($_POST['id_pub']);
$media_type = 'v';
$etat = 0;
$upload_location = "publications-media/";
$filename = $_FILES['video']['name'];
$videoName = time().$id_user.'.mp4';
$path = $upload_location.$videoName;
$create_video_query = $conn->prepare("INSERT INTO publications_media (id_pub,id_user,media_type,media_url,etat) VALUES (:id_pub,:id_user,:media_type,:media_url,:etat)");
$create_video_query->bindParam(':id_pub', $id_pub);
$create_video_query->bindParam(':id_user',$id_user);
$create_video_query->bindParam(':media_type', $media_type);
$create_video_query->bindParam(':media_url', $path);
$create_video_query->bindParam(':etat', $etat);
if ($create_video_query->execute()) {
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