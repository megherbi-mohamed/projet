<?php
session_start();
include_once './bdd/connexion.php';
$id_btq = htmlspecialchars($_POST['id_btq']);
$get_btq_ntf_query = "SELECT * FROM notifications WHERE id_recever_ntf = $id_btq";
$get_btq_ntf_result = mysqli_query($conn, $get_btq_ntf_query);
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