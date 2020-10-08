<?php
include_once './bdd/connexion.php';
if (!empty($_GET['btq'])) {
    $id_btq = $_GET['btq'];
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
