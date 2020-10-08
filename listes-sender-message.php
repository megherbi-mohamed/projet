<?php
session_start();
include_once './bdd/connexion.php';

$msg_query = $conn->prepare("SELECT * FROM messages WHERE id_msg IN ( SELECT MAX(id_msg) FROM messages WHERE id_recever = {$_SESSION['user']} GROUP BY id_sender) ORDER BY id_msg DESC");
$msg_query->execute();
$i = 0;
while ($msg_row = $msg_query->fetch(PDO::FETCH_ASSOC)) {
$sender_info_query = $conn->prepare("SELECT * FROM utilisateurs WHERE id_user = {$msg_row['id_sender']}");
$sender_info_query->execute();
$sender_info_row = $sender_info_query->fetch(PDO::FETCH_ASSOC);
$new_sender = '';
$i++;
if ($msg_row['etat_msg'] == 1) { $new_sender = 'new-sender'; }
else{ $new_sender = '';}
?>
<div class="sender <?php echo $new_sender; ?>" id="<?php echo $sender_info_row['id_user']; ?>">
    <img src="./<?php echo $sender_info_row['img_user']; ?>" alt="">
    <div>
        <h4><?php echo $sender_info_row['nom_user']; ?></h4>
        <p><?php
                $last_msg_query = $conn->prepare("SELECT * FROM messages WHERE id_msg IN ( SELECT MAX(id_msg) FROM messages WHERE id_recever = {$_SESSION['user']} AND id_sender = {$sender_info_row['id_user']}
                                    OR id_recever = {$sender_info_row['id_user']} AND id_sender = {$_SESSION['user']})");
                $last_msg_query->execute();
                $last_msg_row = $last_msg_query->fetch(PDO::FETCH_ASSOC);
                    echo $last_msg_row['message']; 
        ?></p>
    </div>
</div>
<?php } ?>