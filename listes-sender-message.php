<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
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
$msg_query = $conn->prepare("SELECT * FROM messages WHERE id_msg IN ( SELECT MAX(id_msg) FROM messages WHERE id_recever = $id_user GROUP BY id_sender) ORDER BY id_msg DESC");
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
                $last_msg_query = $conn->prepare("SELECT * FROM messages WHERE id_msg IN ( SELECT MAX(id_msg) FROM messages WHERE id_recever = $id_user AND id_sender = {$sender_info_row['id_user']}
                                    OR id_recever = {$sender_info_row['id_user']} AND id_sender = $id_user)");
                $last_msg_query->execute();
                $last_msg_row = $last_msg_query->fetch(PDO::FETCH_ASSOC);
                    echo $last_msg_row['message']; 
        ?></p>
    </div>
</div>
<?php } ?>