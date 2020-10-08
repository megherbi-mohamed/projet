<?php
include_once './bdd/connexion.php';
session_start();
$id_user = htmlspecialchars($_SESSION['user']);
$num_ntf_query = $conn->prepare("SELECT id_ntf FROM publications_notifications WHERE id_recever_ntf = $id_user AND etat_ntf = 1");    
$num_ntf_query->execute();
$num_ntf_num = $num_ntf_query->rowCount();
$show_notification = '';
if ($num_ntf_num > 0) {
    $show_notification = 'style="display:block"';
}
?>
<div <?php echo $show_notification ?> id="user_new_ntf"><span><?php echo $num_ntf_num; ?></span></div>