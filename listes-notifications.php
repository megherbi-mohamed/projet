<?php
session_start();
include_once './bdd/connexion.php';

$notification_query = "SELECT * FROM notifications WHERE id_recever_n = {$_SESSION['user']} ORDER BY id_n DESC";
$notification_result = mysqli_query($conn,$notification_query);

?>
<div class="user-list-top-notifications">
<?php
while ($notification_row = mysqli_fetch_assoc($notification_result)) {
$notification_user_query = "SELECT * FROM utilisateurs WHERE id_user = {$notification_row['id_sender_n']}";
$notification_user_result = mysqli_query($conn,$notification_user_query);
$notification_user_row = mysqli_fetch_assoc($notification_user_result);
$new_notification = '';
if ($notification_row['etat_n'] == 1) { $new_notification = 'new-notification'; }
else{ $new_notification= ''; }
if ($notification_row['id_offre'] == 0) { ?>
<a href="./utilisateur.php?a=<?php echo $notification_row['id_activity']; ?>">
<?php }else{ ?>
<a href="./offre.php?r=<?php echo $notification_row['id_offre']; ?>">
<?php } ?>
<div class="notification <?php echo $new_notification; ?>">
    <p><?php echo $notification_row['text_n'] ?></p>
    <p><?php echo 'Le '.$notification_row['date_n'].' '; ?><span><?php echo $notification_user_row['nom_user'] ?></span></p>
</div>
</a>
<?php } ?>
</div>
<div class="user-list-bottom-notifications"></div>