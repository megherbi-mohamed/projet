<?php
session_start();
include_once './bdd/connexion.php';
$id_session_btq = htmlspecialchars($_POST['id_btq']);
$get_session_btq_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session_btq' OR id_user_1 = '$id_session_btq' OR id_user_2 = '$id_session_btq' 
                                            OR id_user_3 = '$id_session_btq' OR id_user_4 = '$id_session_btq' OR id_user_5 = '$id_session_btq'");
$get_session_btq_query->execute();
$get_session_btq_row = $get_session_btq_query->fetch(PDO::FETCH_ASSOC);
$id_btq = $get_session_btq_row['id_user'];
$data = htmlspecialchars($_POST['image']);
list($type, $data) = explode(';', $data);
list(, $data)      = explode(',', $data);

$data = base64_decode($data);
$imageName = time().'.png';

$query = $conn->prepare("UPDATE boutiques SET couverture_btq = 'boutique-couverture/$imageName' WHERE id_btq = '$id_btq'");
if($query->execute()){
    if(file_put_contents('boutique-couverture/'.$imageName, $data)){
        echo 'done';
    }else{
        echo 0;
    }
}
?>