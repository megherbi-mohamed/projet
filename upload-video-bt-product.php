<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_idSender_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_idSender_query->execute();
$get_session_idSender_row = $get_session_idSender_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_idSender_row['id_user'];
$id_prd = htmlspecialchars($_POST['id_prd']);
$media_type = 'v';
$etat = 1;
$etat_updt = 0;
$upload_location = "bt-produits-media/";
$filename = $_FILES['video']['name'];
$videoName = time().$id_prd.'.mp4';
$path = $upload_location.$videoName;
$create_video_query = $conn->prepare("INSERT INTO bt_produits_media (id_prd,id_user,media_url,media_type,etat,etat_updt) VALUES (:id_prd,:id_user,:media_url,:media_type,:etat,:etat_updt)");
$create_video_query->bindParam(':id_prd',$id_prd);
$create_video_query->bindParam(':id_user',$id_user);
$create_video_query->bindParam(':media_url',$path);
$create_video_query->bindParam(':media_type',$media_type);
$create_video_query->bindParam(':etat',$etat);
$create_video_query->bindParam(':etat_updt',$etat_updt);
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