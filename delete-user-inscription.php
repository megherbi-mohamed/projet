<?php 
include_once './bdd/connexion.php';

$id_user = $_POST['id_user'];

$delete_user_query = "DELETE FROM preutilisateurs WHERE id_user = '$id_user'";

if(mysqli_query($conn,$delete_user_query)){
    echo 1;
}
else{
    echo 0;
} 
?>