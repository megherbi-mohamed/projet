<?php 
include_once './bdd/connexion.php';
$id_ntf = htmlspecialchars($_POST['id_ntf']);
$updt_ntf_query = $conn->prepare("UPDATE publications_notifications SET etat_ntf = 0 WHERE id_ntf = $id_ntf");
if($updt_ntf_query->execute()){
    echo 1;
}
else{
    echo 0;
}
?>