<?php 
include_once './bdd/connexion.php';
$id_msg = htmlspecialchars($_POST['id_msg']);
$updt_msg_query = $conn->prepare("UPDATE messages SET etat_recever_msg = 0, etat_sender_msg = 0 WHERE id_msg = $id_msg");
if($updt_msg_query->execute()){
    echo 1;
}
else{
    echo 0;
}
?>