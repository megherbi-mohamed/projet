<?php
session_start();
include_once './bdd/connexion.php';
$id_prd = htmlspecialchars($_GET['id_prd']);
$get_media_query = $conn->prepare("SELECT * FROM bt_produits_media WHERE id_prd = '$id_prd' AND id_user = {$_SESSION['user']}");
$get_media_query->execute();
$i=0;
while ($get_media_row = $get_media_query->fetch(PDO::FETCH_ASSOC)) {
$i++;
?>
<div class='product-image-preview' id='product_image_preview_<?php echo $i ?>'>
    <div id='product_delete_preview_<?php echo $i ?>'>
        <i class='fas fa-times'></i>
    </div>
    <img src='<?php echo $get_media_row['media_url'] ?>'>
</div>
<?php    
} 
?>