<?php 
session_start();
include_once './bdd/connexion.php';
$id_user= htmlspecialchars($_POST['id_user']);
$get_msg_query = $conn->prepare("SELECT * FROM messages WHERE id_msg IN ( SELECT MAX(id_msg) FROM messages WHERE id_recever = '$id_user' GROUP BY id_sender) ORDER BY id_msg DESC");
$get_msg_query->execute();

$i=0;
while ($get_msg_row = $get_msg_query->fetch(PDO::FETCH_ASSOC)) {
$i++;
$get_sender_info_query = $conn->prepare("SELECT id_user AS id, nom_user AS nom, img_user AS img FROM utilisateurs WHERE id_user = {$get_msg_row['id_sender']} 
                        UNION SELECT id_btq AS id, nom_btq AS nom, logo_btq AS img FROM boutiques WHERE id_btq = {$get_msg_row['id_sender']}");
$get_sender_info_query->execute();
$get_sender_info_row = $get_sender_info_query->fetch(PDO::FETCH_ASSOC);

$last_msg_query = $conn->prepare("SELECT * FROM messages WHERE id_msg IN ( SELECT MAX(id_msg) FROM messages WHERE id_recever = '$id_user' AND id_sender = {$get_sender_info_row['id']}
                    OR id_recever = {$get_sender_info_row['id']} AND id_sender = '$id_user')");
$last_msg_query->execute();
$last_msg_row = $last_msg_query->fetch(PDO::FETCH_ASSOC);

$new_msg = '';
if ($last_msg_row['etat_recever_msg'] == $id_user || $last_msg_row['etat_sender_msg'] == $id_user) {
    $new_msg = 'style="background:#ecedee"';
}
?>
<!-- onclick="userNewMsg(<?php echo $get_msg_row['id_recever'] ?>,<?php echo $get_msg_row['id_sender'] ?>)" -->
<a href="./messagerie.php?user=<?php echo $get_sender_info_row['id']; ?>">
<div class="message" id="message_<?php echo $i ?>" <?php echo $new_msg ?>>
<!-- <input type="hidden" id="idSender_<?php echo $i ?>" value="<?php echo $get_msg_row['id_sender'] ?>">    
<input type="hidden" id="idRecever_<?php echo $i ?>" value="<?php echo $get_msg_row['id_recever'] ?>">     -->
<img src="./<?php echo $get_sender_info_row['img']; ?>" alt="">
    <div>
        <h4><?php echo $get_sender_info_row['nom'] ?></h4>
        <p><?php echo $last_msg_row['message']; ?></p>
        <span><?php echo $last_msg_row['temp_msg'] ?></span>
    </div>
</div></a>
<?php } ?>