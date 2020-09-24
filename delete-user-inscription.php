<?php 
include_once './bdd/connexion.php';
$id_user = htmlspecialchars($_POST['id_user']);
$delete_user_query = $conn->prepare("DELETE FROM preutilisateurs WHERE id_user = '$id_user'");
if($delete_user_query->execute()){
    echo 1;
}
else{
    echo 0;
} 
?>