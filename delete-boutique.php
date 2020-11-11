<?php
include_once './bdd/connexion.php';
$id_session_btq = htmlspecialchars($_POST['id_btq']);
$get_session_btq_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session_btq' OR id_user_1 = '$id_session_btq' OR id_user_2 = '$id_session_btq' 
                                            OR id_user_3 = '$id_session_btq' OR id_user_4 = '$id_session_btq' OR id_user_5 = '$id_session_btq'");
$get_session_btq_query->execute();
$get_session_btq_row = $get_session_btq_query->fetch(PDO::FETCH_ASSOC);
$id_btq = $get_session_btq_row['id_user'];
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