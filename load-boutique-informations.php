<?php
include_once './bdd/connexion.php';
$id_btq = htmlspecialchars($_POST['id_btq']);
$get_btq_info_query = "SELECT * FROM admin_boutique WHERE id_btq = $id_btq";
$get_btq_info_result = mysqli_query($conn,$get_btq_info_query);
if ($get_btq_info_row = mysqli_fetch_assoc($get_btq_info_result)) {
?>
<div class="gerer-boutique-informations">
    <div class="gerer-boutique-informations-top">
        <h3>Modifier les informations de la boutique!</h3>
    </div>
    <div class="gerer-boutique-informations-bottom">
        <div>
            <?php 
            if ($get_btq_info_row['nom_btq'] == '') {
            ?>    
            <input type="text" id="Nom_btq">
            <span class="nom">Nom</span>
            <?php }else{ ?>
            <input type="text" id="Nom_btq" value="<?php echo $get_btq_info_row['nom_btq'] ?>">
            <?php } ?>
        </div>
        <div>
            <?php 
            if ($get_btq_info_row['nom_btq'] == '') {
            ?>    
            <input type="text" id="Nom_btq">
            <span class="nom">Nom</span>
            <?php }else{ ?>
            <input type="text" id="Nom_btq" value="<?php echo $get_btq_info_row['nom_btq'] ?>">
            <?php } ?>
        </div>
    </div>
</div>
<?php 
}else{
    echo 0;
}
?>