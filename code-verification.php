<?php 
include_once './bdd/connexion.php';

$id_user = htmlspecialchars($_POST['id_user']);
$code_verification = htmlspecialchars($_POST['code_verification']);

$query = "SELECT code FROM preutilisateurs WHERE id_user = '$id_user'";

if($result = mysqli_query($conn,$query)){
    $row = mysqli_fetch_assoc($result);
    if ($row['code'] == $code_verification) {
        echo $id_user;
    }
    else{
        echo 0;
    }
}
else{
    echo 0;
}
?>