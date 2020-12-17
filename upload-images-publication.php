<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_idSender_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_idSender_query->execute();
$get_session_idSender_row = $get_session_idSender_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_idSender_row['id_user'];
$id_pub = htmlspecialchars($_POST['id_pub']);
$media_type = 'i';
$etat = 1;
$etat_updt = 0;
$countfiles = count($_FILES['images']['name']);
$upload_location = "publications-media/";
$files_arr = array();
for($index = 0 ; $index < $countfiles; $index++){
    $filename = $_FILES['images']['name'][$index];
    $imageName = time().$index.$id_pub.'.png';
    $path = $upload_location.$imageName;
    $create_images_query = $conn->prepare("INSERT INTO publications_media (id_pub,id_user,media_type,media_url,etat,etat_updt) VALUES (:id_pub,:id_user,:media_type,:media_url,:etat,:etat_updt)");
    $create_images_query->bindParam(':id_pub', $id_pub);
    $create_images_query->bindParam(':id_user',$id_user);
    $create_images_query->bindParam(':media_type', $media_type);
    $create_images_query->bindParam(':media_url', $path);
    $create_images_query->bindParam(':etat', $etat);
    $create_images_query->bindParam(':etat_updt',$etat_updt);
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