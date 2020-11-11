<?php
include_once './bdd/connexion.php';
$id_prm = htmlspecialchars($_POST['id_prm']);
$id_prd = htmlspecialchars($_POST['id_prd']);
$etat = 1;
$countfiles = count($_FILES['images']['name']);
$upload_location = "prm-produits-media/";
$files_arr = array();
for($index = 0 ; $index < $countfiles; $index++){
    $filename = $_FILES['images']['name'][$index];
    $imageName = time().$index.$id_prd.'.png';
    $path = $upload_location.$imageName;
    $create_images_query = $conn->prepare("INSERT INTO prm_produits_media (id_prd,id_prm,media_url,etat) VALUES (:id_prd,:id_prm,:media_url,:etat)");
    $create_images_query->bindParam(':id_prd',$id_prd);
    $create_images_query->bindParam(':id_prm',$id_prm);
    $create_images_query->bindParam(':media_url',$path);
    $create_images_query->bindParam(':etat',$etat);
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