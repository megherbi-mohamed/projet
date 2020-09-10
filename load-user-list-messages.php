<?php 
session_start();
include_once './bdd/connexion.php';
$id_user= htmlspecialchars($_POST['id_user']);
$get_msg_query = "SELECT * FROM messages WHERE id_msg IN ( SELECT MAX(id_msg) FROM messages WHERE id_recever = '$id_user' GROUP BY id_sender) ORDER BY id_msg DESC";
$get_msg_result = mysqli_query($conn, $get_msg_query);

$i=0;
while ($get_msg_row = mysqli_fetch_assoc($get_msg_result)) {
$i++;
$get_sender_info_query = "SELECT id_user AS id, nom_user AS nom, img_user AS img FROM utilisateurs WHERE id_user = {$get_msg_row['id_sender']} 
                        UNION SELECT id_btq AS id, nom_btq AS nom, logo_btq AS img FROM boutiques WHERE id_btq = {$get_msg_row['id_sender']}";
$get_sender_info_result = mysqli_query($conn, $get_sender_info_query);
$get_sender_info_row = mysqli_fetch_assoc($get_sender_info_result);

$last_msg_query = "SELECT * FROM messages WHERE id_msg IN ( SELECT MAX(id_msg) FROM messages WHERE id_recever = '$id_user' AND id_sender = {$get_sender_info_row['id']}
                    OR id_recever = {$get_sender_info_row['id']} AND id_sender = '$id_user')";
$last_msg_result = mysqli_query($conn,$last_msg_query);
$last_msg_row = mysqli_fetch_assoc($last_msg_result);

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