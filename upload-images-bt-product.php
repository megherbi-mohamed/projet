<?php
session_start();
include_once './bdd/connexion.php';
$id_user = htmlspecialchars($_SESSION['user']);
$id_prd = htmlspecialchars($_POST['id_prd']);
$countfiles = count($_FILES['images']['name']);
$upload_location = "bt-produits-media/";
$files_arr = array();
for($index = 0 ; $index < $countfiles; $index++){
    $filename = $_FILES['images']['name'][$index];
    $imageName = time().$index.$id_prd.'.png';
    $path = $upload_location.$imageName;
    $create_images_query = "INSERT INTO bt_produits_media (id_prd,id_user,media_url,etat) VALUES ('$id_prd',{$_SESSION['user']},'$path',1)";
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