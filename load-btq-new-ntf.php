<?php
include_once './bdd/connexion.php';
if (!empty($_GET['btq'])) {
    $id_session = htmlspecialchars($_GET['btq']);
    $get_session_btq_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                                OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
    $get_session_btq_query->execute();
    $get_session_btq_row = $get_session_btq_query->fetch(PDO::FETCH_ASSOC);
    $id_btq = $get_session_btq_row['id_user'];
    $num_ntf_query = $conn->prepare("SELECT id_ntf FROM publications_notifications WHERE id_recever_ntf = $id_btq AND etat_ntf = 1");    
    $num_ntf_query->execute();
    $num_ntf_num = $num_ntf_query->rowCount();
    $show_btq_notification = '';
    if ($num_ntf_num > 0) {
        $show_btq_notification = 'style="display:block"';
    }  
}
?>
<div <?php echo $show_btq_notification ?> id="btq_new_ntf"><span><?php echo $num_ntf_num; ?></span></div>
