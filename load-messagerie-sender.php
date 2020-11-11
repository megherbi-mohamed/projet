<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_GET['id_user']);
$get_session_id_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                        OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_id_query->execute();
$get_session_id_row = $get_session_id_query->fetch(PDO::FETCH_ASSOC);
$user_session_query = $conn->prepare("SELECT * FROM utilisateurs WHERE id_user = {$get_session_id_row['id_user']}");
$user_session_query->execute();
if ($user_session_query->rowCount() > 0) {
    $row = $user_session_query->fetch(PDO::FETCH_ASSOC);
    $id_user = $row['id_user'];
}
?>
<div class="messageire-left-top">
    <div id="back_messagerie_sender">
        <i class="fas fa-arrow-left"></i>
    </div>
    <h4>Messagerie</h4>
    <div></div>
</div>
<?php
$get_msg_query = $conn->prepare("SELECT * FROM messages WHERE id_msg IN (SELECT MAX(id_msg) FROM messages WHERE id_recever = '$id_user' OR id_sender = '$id_user' GROUP BY msg_cle) ORDER BY id_msg DESC");
$get_msg_query->execute();
$i=0;
while($get_msg_row = $get_msg_query->fetch(PDO::FETCH_ASSOC)){
$i++;
if ($get_msg_row['id_recever'] == $id_user) {
    $get_sender_info_query = $conn->prepare("SELECT id_user AS id, nom_user AS nom, img_user AS img FROM utilisateurs WHERE id_user = {$get_msg_row['id_sender']} 
                        UNION SELECT id_btq AS id, nom_btq AS nom, logo_btq AS img FROM boutiques WHERE id_btq = {$get_msg_row['id_sender']}");
    $get_sender_info_query->execute();
    $get_sender_info_row = $get_sender_info_query->fetch(PDO::FETCH_ASSOC);
}
else if ($get_msg_row['id_sender'] == $id_user) {
    $get_sender_info_query = $conn->prepare("SELECT id_user AS id, nom_user AS nom, img_user AS img FROM utilisateurs WHERE id_user = {$get_msg_row['id_recever']} 
                        UNION SELECT id_btq AS id, nom_btq AS nom, logo_btq AS img FROM boutiques WHERE id_btq = {$get_msg_row['id_recever']}");
    $get_sender_info_query->execute();
    $get_sender_info_row = $get_sender_info_query->fetch(PDO::FETCH_ASSOC);
}

$last_msg_query = $conn->prepare("SELECT * FROM messages WHERE id_msg IN ( SELECT MAX(id_msg) FROM messages WHERE id_recever = '$id_user' AND id_sender = {$get_sender_info_row['id']}
                    OR id_recever = {$get_sender_info_row['id']} AND id_sender = '$id_user')");
$last_msg_query->execute();
$last_msg_row = $last_msg_query->fetch(PDO::FETCH_ASSOC);

$new_msg = '';
if ($last_msg_row['etat_recever_msg'] == $id_user || $last_msg_row['etat_sender_msg'] == $id_user) {
    $new_msg = 'style="background:#ecedee"';
}
?>
<input type="hidden" id="id_corresponder_<?php echo $i?>" value="<?php echo $get_sender_info_row['id'] ?>">
<div <?php echo $new_msg; ?> class="messagerie-corresponder" id="messagerie_corresponder_<?php echo $i?>">
    <?php if ($get_sender_info_row['img'] == '') { ?>
    <img src="./images/profile.png" alt="">
    <?php }else{ ?>
    <img src="<?php echo $get_sender_info_row['img'] ?>" alt="">
    <?php } ?>
    <div class="messagerie-corresponder-message">
        <h4><?php echo $get_sender_info_row['nom'] ?></h4>
        <p><?php echo $last_msg_row['message']; ?></p>
        <span><?php echo $last_msg_row['temp_msg'] ?></span>
    </div>
</div>
<?php } ?>