<?php
include_once './bdd/connexion.php';
$id_btq = $_POST['id_btq'];
$recover_btq_query = "UPDATE boutiques SET etat_btq = 1 WHERE id_btq = '$id_btq'";
if(mysqli_query($conn, $recover_btq_query)){
    echo 1;
}else{
    echo 0;
}
?>