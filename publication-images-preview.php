<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_idSender_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_idSender_query->execute();
$get_session_idSender_row = $get_session_idSender_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_idSender_row['id_user'];
$id_pub = htmlspecialchars($_GET['id_pub']);
$get_media_query = $conn->prepare("SELECT * FROM publications_media WHERE id_pub = '$id_pub' AND id_user = $id_user AND media_type = 'i'");
$get_media_query->execute();
$i=0;
while ($get_media_row = $get_media_query->fetch(PDO::FETCH_ASSOC)) {
$i++;
?>
<div class='image-preview' id='image_preview_<?php echo $i ?>'>
    <div id='delete_preview_<?php echo $i ?>'>
        <i class='fas fa-times'></i>
    </div>
    <img src='<?php echo $get_media_row['media_url'] ?>'>
</div>
<?php    
} 
?>