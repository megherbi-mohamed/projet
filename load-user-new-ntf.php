<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_idSender_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_idSender_query->execute();
$get_session_idSender_row = $get_session_idSender_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_idSender_row['id_user'];
$id = ','.$id_user.',';
$num_ntf1_query = $conn->prepare("SELECT id_ntf FROM publications_notifications WHERE (type_ntf = 'publication' OR type_ntf = 'produit') AND vu_ntf NOT LIKE '%$id%' AND id_sender_ntf IN (SELECT id_abn_user AS id FROM abonnes WHERE id_user = $id_user) AND (type_ntf = 'publication' OR type_ntf = 'produit') AND id_recever_ntf IN (SELECT id_abn_user AS id FROM abonnes WHERE id_user = $id_user)");    
$num_ntf1_query->execute();
$num_ntf2_query = $conn->prepare("SELECT id_ntf FROM publications_notifications WHERE id_recever_ntf = $id_user AND id_sender_ntf != $id_user AND etat_ntf = 1");    
$num_ntf2_query->execute();
$num_ntf_num = $num_ntf1_query->rowCount() + $num_ntf2_query->rowCount();
$show_notification = '';
if ($num_ntf_num > 0) {
    $show_notification = 'style="display:block"';
}
?>
<div <?php echo $show_notification ?> id="user_new_ntf"><span><?php echo $num_ntf_num; ?></span></div>