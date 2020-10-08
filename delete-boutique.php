<?php
include_once './bdd/connexion.php';
$id_btq = $_POST['id_btq'];
$pre_date = date('Y-m-d');
$date = strtotime("+15 day", strtotime($pre_date));
$date_recuperation = date('Y-m-d',$date);

$delete_btq_query = $conn->prepare("UPDATE boutiques SET etat_btq = 0, date_recuperation = '$date_recuperation' WHERE id_btq = '$id_btq'");
if($delete_btq_query->execute()){
    echo $date_recuperation;
}else{
    echo 0;
}
?>