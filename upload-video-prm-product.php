<?php
include_once './bdd/connexion.php';
$id_prm = htmlspecialchars($_POST['id_prm']);
$id_prd = htmlspecialchars($_POST['id_prd']);
$media_type = 'v';
$etat = 1;
$upload_location = "prm-produits-media/";
$filename = $_FILES['video']['name'];
$videoName = time().$id_prd.'.mp4';
$path = $upload_location.$videoName;
$create_video_query = $conn->prepare("INSERT INTO prm_produits_media (id_prd,id_prm,media_url,media_type,etat) VALUES (:id_prd,:id_prm,:media_url,:media_type,:etat)");
$create_video_query->bindParam(':id_prd',$id_prd);
$create_video_query->bindParam(':id_prm',$id_prm);
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