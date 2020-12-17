<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_user_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_user_query->execute();
$get_session_user_row = $get_session_user_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_user_row['id_user'];
$id_prm = htmlspecialchars($_POST['id_prm']);
$etat = 1;
$etat_updt = 0;
$media_type = 'v';
$upload_location = "promotion-media/";
$filename = $_FILES['video']['name'];
$videoName = time().$id_prm.'.mp4';
$path = $upload_location.$videoName;
$create_video_query = $conn->prepare("INSERT INTO promotions_media (id_prm,id_user,media_url,media_type,etat,etat_updt) VALUES (:id_prm,:id_user,:media_url,:media_type,:etat,:etat_updt)");
$create_video_query->bindParam(':id_prm',$id_prm);
$create_video_query->bindParam(':id_user',$id_user);
$create_video_query->bindParam(':media_url',$path);
$create_video_query->bindParam(':media_type',$media_type);
$create_video_query->bindParam(':etat',$etat);
$create_video_query->bindParam(':etat_updt',$etat_updt);
if ($create_video_query->execute()) {
    if(move_uploaded_file($_FILES['video']['tmp_name'],$path)){
        echo json_encode($path);
    }
    else{
        echo 0;
    }
}
else{
    echo 0;
}
?>