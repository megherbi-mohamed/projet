<?php 
session_start();
include_once './bdd/connexion.php';
$id_user = htmlspecialchars($_SESSION['user']);
$id_abn_user = htmlspecialchars($_POST['id_user']);
$disabonne_query = $conn->prepare("DELETE FROM abonnes WHERE id_user = '$id_user' AND id_abn_user = '$id_abn_user'");
$delete_ntf_query = $conn->prepare("DELETE FROM publications_notifications WHERE id_sender_ntf = '$id_user' AND id_recever_ntf = '$id_abn_user' AND type_ntf = 'abonnement'");
if($disabonne_query->execute() && $delete_ntf_query->execute()){
    echo 1;
}
else{
    echo 0;
}
?>