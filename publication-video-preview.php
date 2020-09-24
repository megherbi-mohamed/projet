<?php
session_start();
include_once './bdd/connexion.php';
$id_pub = htmlspecialchars($_GET['id_pub']);
$get_media_query = $conn->prepare("SELECT * FROM publications_media WHERE id_pub = '$id_pub' AND id_user = {$_SESSION['user']} AND media_type = 'v'");
$get_media_query->execute();
$i=0;
while ($get_media_row = $get_media_query->fetch(PDO::FETCH_ASSOC)) {
$i++;
?>
<div class='video-preview'>
    <div id='delete_video'>
        <i class='fas fa-times'></i>
    </div>
    <video controls><source src='<?php echo $get_media_row['media_url'] ?>'></video>
</div>
<?php    
} 
?>