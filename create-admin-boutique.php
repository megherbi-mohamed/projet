<?php
include_once './bdd/connexion.php';
$id_btq = htmlspecialchars($_POST['id_btq']);
$matricule_adm = htmlspecialchars($_POST['matricule_adm']);
$nom_adm = htmlspecialchars($_POST['nom_adm']);
$mtp_adm = htmlspecialchars($_POST['mtp_adm']);

$hash_mtp_adm = hash('sha256', $mtp_adm);

$messagerie = htmlspecialchars($_POST['messagerie']);
$notifications = htmlspecialchars($_POST['notifications']);
$modification = htmlspecialchars($_POST['modification']);
$product = htmlspecialchars($_POST['product']);
$categorie = htmlspecialchars($_POST['categorie']);

$creat_madmin_query = "INSERT INTO admin_boutique (id_btq,matricule_adm,nom_adm,mtp_adm,messagerie,notifications,modification,product,categorie) 
VALUES ('$id_btq','$matricule_adm','$nom_adm','$hash_mtp_adm','$messagerie','$notifications','$modification','$product','$categorie')";
if(mysqli_query($conn,$creat_madmin_query)){
    $get_btq_admin_query = "SELECT * FROM admin_boutique WHERE id_btq = $id_btq";
    if ($get_btq_admin_result = mysqli_query($conn,$get_btq_admin_query)) {
        $get_btq_admin_row = mysqli_fetch_assoc($get_btq_admin_result);
    ?>
<div class="boutique-admin-info">
    <div class="boutique-admin-info-top">
        <div class="admin-info-left">
            <p>Admin</p>
            <h4><?php echo $get_btq_admin_row['nom_adm'] ?></h4>
            <div></div>
        </div>
        <div class="admin-info-right">
            <p>Dernière connexion à <span><?php echo $get_btq_admin_row['last_cnx'] ?></span></p>  
        </div>
    </div>
    <hr>
    <div class="boutique-admin-info-bottom">
    <h4>Modifier admin options autorisation</h4>
        <div class="admin-autoisation">
            <input type="hidden" id="messagerie_adm_autrs" value="<?php echo $get_btq_admin_row['messagerie'] ?>">
            <?php 
            if ($get_btq_admin_row['messagerie'] == 1) {
            ?> 
            <i class="fas fa-check etat"></i>
            <?php }else{ ?>
            <i style="color:red" class="fas fa-ban etat"></i>
            <?php } ?>
            <p>Messagerie</p>
            <div>
                <i class="fab fa-facebook-messenger"></i>
            </div>
        </div>
        <div class="admin-autoisation">
            <input type="hidden" id="notifications_adm_autrs" value="<?php echo $get_btq_admin_row['notifications'] ?>">
            <?php 
            if ($get_btq_admin_row['notifications'] == 1) {
            ?> 
            <i class="fas fa-check etat"></i>
            <?php }else{ ?>
            <i style="color:red" class="fas fa-ban etat"></i>
            <?php } ?>
            <p>Notifications</p>
            <div>
                <i class="fas fa-bell"></i>
            </div>
        </div>
        <div class="admin-autoisation">
            <input type="hidden" id="modification_adm_autrs" value="<?php echo $get_btq_admin_row['modification'] ?>">
            <?php 
            if ($get_btq_admin_row['modification'] == 1) {
            ?> 
            <i class="fas fa-check etat"></i>
            <?php }else{ ?>
            <i style="color:red" class="fas fa-ban etat"></i>
            <?php } ?>
            <p>Boutique modification</p>
            <div>
                <i class="fas fa-cog"></i>
            </div>
        </div>
        <div class="admin-autoisation">
            <input type="hidden" id="creation_adm_autrs" value="<?php echo $get_btq_admin_row['product'] ?>">  
            <?php 
            if ($get_btq_admin_row['product'] == 1) {
            ?> 
            <i class="fas fa-check etat"></i>
            <?php }else{ ?>
            <i style="color:red" class="fas fa-ban etat"></i>
            <?php } ?>
            <p>Creation de produit</p>
            <div>
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="admin-autoisation">
            <input type="hidden" id="categorie_adm_autrs" value="<?php echo $get_btq_admin_row['categorie'] ?>">
            <?php 
            if ($get_btq_admin_row['categorie'] == 1) {
            ?> 
            <i class="fas fa-check etat"></i>
            <?php }else{ ?>
            <i style="color:red" class="fas fa-ban etat"></i>
            <?php } ?>
            <p>Creation de categorie</p>
            <div>
                <i class="fas fa-plus"></i>
            </div>
        </div>
    </div>
    <button id="update_boutique_admin">Modifier</button>
</div>    
<?php
    }else{
        echo 0;
    }
}else{
    echo 0;
}
?>