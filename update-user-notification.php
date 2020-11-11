<?php 
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_idSender_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_idSender_query->execute();
$get_session_idSender_row = $get_session_idSender_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_idSender_row['id_user'];
$id_ntf = htmlspecialchars($_POST['id_ntf']);
$id = ','.$id_user.',';
$verify_vu_ntf_query = $conn->prepare("SELECT vu_ntf FROM publications_notifications WHERE id_ntf = $id_ntf AND vu_ntf LIKE '%$id%'");
$verify_vu_ntf_query->execute();
echo $verify_vu_ntf_count = $verify_vu_ntf_query->rowCount();
if ($verify_vu_ntf_count == 0) {
    $get_vu_ntf_query = $conn->prepare("SELECT vu_ntf,type_ntf FROM publications_notifications WHERE id_ntf = $id_ntf");
    $get_vu_ntf_query->execute();
    $get_vu_ntf_row = $get_vu_ntf_query->fetch(PDO::FETCH_ASSOC);
    $vu_ntf = $get_vu_ntf_row['vu_ntf'].$id_user.',';
    if ($get_vu_ntf_row['type_ntf'] == 'publication' || $get_vu_ntf_row['type_ntf'] == 'produit') {
        $updt_ntf_query = $conn->prepare("UPDATE publications_notifications SET etat_ntf = 0, vu_ntf = '$vu_ntf' WHERE id_ntf = $id_ntf");
        if($updt_ntf_query->execute()){
            echo 1;
        }
        else{
            echo 0;
        }
    }
    else{
        $updt_ntf_query = $conn->prepare("UPDATE publications_notifications SET etat_ntf = 0 WHERE id_ntf = $id_ntf");
        if($updt_ntf_query->execute()){
            echo 1;
        }
        else{
            echo 0;
        }
    }
}
?>