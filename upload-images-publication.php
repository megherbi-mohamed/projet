<?php
session_start();
include_once './bdd/connexion.php';
$id_user = htmlspecialchars($_SESSION['user']);
$id_pub = htmlspecialchars($_POST['id_pub']);
$countfiles = count($_FILES['images']['name']);
$upload_location = "publications-media/";
$files_arr = array();
for($index = 0 ; $index < $countfiles; $index++){
    $filename = $_FILES['images']['name'][$index];
    $imageName = time().$index.$id_user.'.png';
    $path = $upload_location.$imageName;
    $create_images_query = "INSERT INTO publications_media (id_pub,id_user,media_type,media_url,etat) VALUES ('$id_pub',{$_SESSION['user']},'i','$path',1)";
    if (mysqli_query($conn, $create_images_query)) {
        if(move_uploaded_file($_FILES['images']['tmp_name'][$index],$path)){
            $files_arr[] = $path;
        }
        else{
            echo 0;
        }
    }
    else{
        echo 0;
    }
}
echo json_encode($files_arr);
die;
?>