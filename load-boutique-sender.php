<?php
session_start();
include_once './bdd/connexion.php';
$id_btq = htmlspecialchars($_GET['id_btq']);
$get_btq_msg_query = $conn->prepare("SELECT * FROM messages WHERE id_msg IN ( SELECT MAX(id_msg) FROM messages WHERE id_recever = '$id_btq' GROUP BY id_sender) ORDER BY id_msg DESC");
$get_btq_msg_query->execute();
$i=0;
while($get_btq_msg_row = $get_btq_msg_query->fetch(PDO::FETCH_ASSOC)){
$i++;

$get_sender_info_query = $conn->prepare("SELECT id_user AS id, nom_user AS nom, img_user AS img FROM utilisateurs WHERE id_user = {$get_btq_msg_row['id_sender']} 
                        UNION SELECT id_btq AS id, nom_btq AS nom, logo_btq AS img FROM boutiques WHERE id_btq = {$get_btq_msg_row['id_sender']}");
$get_sender_info_query->execute();
$get_sender_info_row = $get_sender_info_query->fetch(PDO::FETCH_ASSOC);

$last_msg_query = $conn->prepare("SELECT * FROM messages WHERE id_msg IN ( SELECT MAX(id_msg) FROM messages WHERE id_recever = '$id_btq' AND id_sender = {$get_sender_info_row['id']}
                    OR id_recever = {$get_sender_info_row['id']} AND id_sender = '$id_btq')");
$last_msg_query->execute();
$last_msg_row = $last_msg_query->fetch(PDO::FETCH_ASSOC);

$new_msg = '';
if ($last_msg_row['etat_recever_msg'] == $id_btq || $last_msg_row['etat_sender_msg'] == $id_btq) {
    $new_msg = 'style="background:#ecedee"';
}
?>
<input type="hidden" id="id_corresponder_<?php echo $i?>" value="<?php echo $get_btq_msg_row['id_sender'] ?>">
<div class="boutique-corresponder" id="boutique_corresponder_<?php echo $i?>">
    <img src="<?php echo $get_sender_info_row['img'] ?>" alt="">
    <div class="boutique-corresponder-message">
        <h4><?php echo $get_sender_info_row['nom'] ?></h4>
        <p><?php echo $last_msg_row['message']; ?></p>
        <span><?php echo $last_msg_row['temp_msg']; ?></span>
    </div>
</div>
<?php } ?>