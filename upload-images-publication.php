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
    $etat = 1;
    $type = "i";
    $create_images_query = $conn->prepare("INSERT INTO publications_media (id_pub,id_user,media_type,media_url,etat) VALUES (:id_pub, :id_user, :media_type, :media_url, :etat)");
    $create_images_query->bindParam(':id_pub', $id_pub);
    $create_images_query->bindParam(':id_user', $_SESSION['user']);
    $create_images_query->bindParam(':media_type', $type);
    $create_images_query->bindParam(':media_url', $path);
    $create_images_query->bindParam(':etat', $etat);
    if ($create_images_query->execute()) {
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