<?php
session_start();
include_once './bdd/connexion.php';
$id_btq = htmlspecialchars($_POST['id_btq']);
$get_btq_ntf_query = "SELECT * FROM notifications WHERE id_recever_ntf = $id_btq";
$get_btq_ntf_result = mysqli_query($conn, $get_btq_ntf_query);
$get_ntf_num = mysqli_num_rows($get_btq_ntf_result);
if ($get_ntf_num > 0) {
?>
<div class="boutique-notification">
    <?php 
    $i=0;
    while($get_btq_ntf_row = mysqli_fetch_assoc($get_btq_ntf_result)){
    $i++;
    ?>
    <div class="notification">
        
    </div>
    <?php } ?>
</div>
<?php }else{ ?>
<div class="empty-msg-ntf">
    <p>Vous n'avez auccune notificatio</p>
</div>
<?php } ?>