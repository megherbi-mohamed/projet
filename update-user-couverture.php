<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_user_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_user_query->execute();
$get_session_user_row = $get_session_user_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_user_row['id_user'];
$data = $_POST['image'];
list($type, $data) = explode(';', $data);
list(, $data)      = explode(',', $data);
$data = base64_decode($data);
$imageName = time().'.png';
$query = $conn->prepare("UPDATE utilisateurs SET couverture_user = 'user-couverture/$imageName' WHERE id_user = $id_user");
if($query->execute()){
    if(file_put_contents('user-couverture/'.$imageName, $data)){
        echo 1;
    }else{
        echo 0;
    }
}
?>
