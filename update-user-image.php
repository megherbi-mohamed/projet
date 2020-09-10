<?php
session_start();
include_once './bdd/connexion.php';

$idUser = $_SESSION['user'];
$data = $_POST['image'];
list($type, $data) = explode(';', $data);
list(, $data)      = explode(',', $data);

$data = base64_decode($data);
$imageName = time().'.png';

$query = "UPDATE utilisateurs SET img_user = 'images/$imageName' WHERE id_user = '$idUser'";
if(mysqli_query($conn, $query)){
    if(file_put_contents('images/'.$imageName, $data)){
        echo 'done';
    }else{
        echo 0;
    }
}
?>
