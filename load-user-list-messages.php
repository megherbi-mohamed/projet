<?php 
session_start();
include_once './bdd/connexion.php';
$id_user= htmlspecialchars($_POST['id_user']);
$get_msg_query = $conn->prepare("SELECT id_sender,id_recever FROM messages WHERE id_msg IN (SELECT MAX(id_msg) FROM messages WHERE id_recever = '$id_user' OR id_sender = '$id_user' GROUP BY msg_cle) ORDER BY id_msg DESC");
$get_msg_query->execute();

if ($get_msg_query->rowCount() > 0) {

$get_last_sender_query = $conn->prepare("SELECT id_sender,id_recever FROM messages WHERE id_msg IN (SELECT MAX(id_msg) FROM messages WHERE id_recever = '$id_user' OR id_sender = '$id_user' GROUP BY msg_cle) ORDER BY id_msg DESC LIMIT 1");
$get_last_sender_query->execute();
$get_last_sender_row = $get_last_sender_query->fetch(PDO::FETCH_ASSOC);
if ($get_last_sender_row['id_sender'] == $id_user) {
    $last_sender = $get_last_sender_row['id_recever'];
}
else if ($get_last_sender_row['id_recever'] == $id_user){
    $last_sender = $get_last_sender_row['id_sender'];
}

$i=0;
while ($get_msg_row = $get_msg_query->fetch(PDO::FETCH_ASSOC)) {
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
<input type="hidden" id="id_msg_<?php echo $i?>" value="<?php echo $last_msg_row['id_msg'] ?>">
<input type="hidden" id="id_crsp_<?php echo $i ?>" value="<?php echo $get_sender_info_row['id'] ?>">
<div class="message" id="message_<?php echo $i ?>" <?php echo $new_msg ?>>
    <?php if ($get_sender_info_row['img'] == '') { ?>
    <img src="./images/profile.png" alt="">
    <?php }else{ ?>
    <img src="<?php echo $get_sender_info_row['img'] ?>" alt="">
    <?php } ?>
    <div>
        <h4><?php echo $get_sender_info_row['nom'] ?></h4>
        <p><?php echo $last_msg_row['message']; ?></p>
        <span><?php echo $last_msg_row['temp_msg'] ?></span>
    </div>
</div>
<?php } ?>
<div style="color:#000;text-decoration:none;margin-top:10px;text-align:center;width:100%;font-size:.9rem;font-weight:bold">
    <a href="messagerie/<?php echo $last_sender; ?>">Afficher tout les messages</a>
</div>
<?php 
} 
else{
    echo '<p style="font-size:.85rem; text-align:center;">Accune conversation</p>';
}
?>
<script>
    $('[id^="message_"]').click(function(e){
        var id = $(this).attr('id').split('_')[1];
        var fd = new FormData();
        var idMsg = $('#id_msg_'+id).val();
        fd.append('id_msg',idMsg);
        $.ajax({
            url: 'update-user-message.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                console.log(response);
                if(response != 0){
                    $('.user-new-msg').load('load-user-new-msg.php');
                }
            }
        });
        var idCrsp = $('#id_crsp_'+id).val();
        if (windowWidth < 768) {
            $('.user-list-messages').css('transform','');
            setTimeout(() => {
                window.location = 'messagerie/'+idCrsp;
            }, 400);
        }
        else{
            window.location = 'messagerie/'+idCrsp;
        }
    });
</script>