<?php
session_start();
include_once './bdd/connexion.php';
$id_btq = htmlspecialchars($_POST['id_btq']);
$get_btq_ntf_query = $conn->prepare("SELECT * FROM publications_notifications WHERE id_recever_ntf = $id_btq AND id_sender_ntf != $id_btq ORDER BY id_ntf DESC");
$get_btq_ntf_query->execute();
$get_ntf_num = $get_btq_ntf_query->rowCount();
if ($get_ntf_num > 0) {
?>
<div class="boutique-notification">
    <?php 
    $i=0;
    while($get_btq_ntf_row = $get_btq_ntf_query->fetch(PDO::FETCH_ASSOC)){
    $i++;

    $get_sender_info_query = $conn->prepare("SELECT nom_user,img_user FROM utilisateurs WHERE id_user = {$get_btq_ntf_row['id_sender_ntf']}");
    $get_sender_info_query->execute();
    $get_sender_info_row = $get_sender_info_query->fetch(PDO::FETCH_ASSOC);
    
    $new_ntf = '';
    if ($get_btq_ntf_row['etat_ntf'] == 1) {
        $new_ntf = 'background:#ecedee"';
    }
    ?>
    <?php 
    if ($get_btq_ntf_row['type_ntf'] == 'abonnement') {
    ?>
    <input type="hidden" id="id_abn_user_<?php echo $i ?>" value="<?php echo $get_btq_ntf_row['id_sender_ntf'] ?>">
    <input type="hidden" id="id_ntf_<?php echo $i ?>" value="<?php echo $get_btq_ntf_row['id_ntf'] ?>">
    <div class="notification-btq" id="notification_abn_<?php echo $i ?>">
        <div class="notification-btq-container" style="grid-template-columns: 20% 80%; <?php echo $new_ntf ?>">
            <?php if ($get_sender_info_row['img_user'] == '') { ?>
            <img src="./images/profile.png" alt="">
            <?php }else{ ?>
            <img src="<?php echo $get_sender_info_row['img_user'] ?>" alt="">
            <?php } ?>
            <div class="notification-btq-message">
                <p><?php echo $get_sender_info_row['nom_user'].' '.$get_btq_ntf_row['message_ntf']; ?></p>
                <span><?php echo $get_btq_ntf_row['date_ntf'] ?></span>
            </div>
        </div>
    </div>
    <?php } ?>
    <?php } ?>
</div>
<?php }else{ ?>
<div class="empty-msg-ntf">
    <p>Vous n'avez auccune notification</p>
</div>
<?php } ?>