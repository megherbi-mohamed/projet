<?php
session_start();
include_once './bdd/connexion.php';
$msg_query = $conn->prepare("SELECT * FROM messages WHERE id_msg IN ( SELECT MAX(id_msg) FROM messages WHERE id_recever = '{$_SESSION["user"]}' GROUP BY id_sender) ORDER BY id_msg DESC");
$msg_query->execute();
?>
<div class="user-list-top-message">
<?php 
while ($msg_row = $msg_query->fetch(PDO::FETCH_ASSOC)) {
$sender_info_query = $conn->prepare("SELECT * FROM utilisateurs WHERE id_user = '{$msg_row["id_sender"]}'");
$sender_info_query->execute();
$sender_info_row = $sender_info_result->fetch(PDO::FETCH_ASSOC);
$new_sender = '';
if ($msg_row['etat_msg'] == 1) { $new_sender = 'new-sender'; }
else{ $new_sender = ''; }
?>
<a href="./messagerie.php?user=<?php echo $sender_info_row['id_user']; ?>">
<div class="message <?php echo $new_sender; ?>">
    <img src="./<?php echo $sender_info_row['img_user']; ?>" alt="">
    <div>
        <p><?php
            $last_msg_query = $conn->prepare("SELECT * FROM messages WHERE id_msg IN ( SELECT MAX(id_msg) FROM messages WHERE id_recever = '{$_SESSION["user"]}' AND id_sender = '{$sender_info_row["id_user"]}'
                                OR id_recever = '{$sender_info_row["id_user"]}' AND id_sender = '{$_SESSION["user"]}')");
            $last_msg_query->execute();
            $last_msg_row = $last_msg_query->fetch(PDO::FETCH_ASSOC);
                echo $last_msg_row['message']; 
        ?></p>
        <p><?php echo $msg_row['temp_msg']; ?>&nbsp;<span><?php echo $sender_info_row['nom_user']; ?></span></p>
    </div>
</div>
</a>
<?php } ?>
</div>
<div class="user-list-bottom-message"></div>