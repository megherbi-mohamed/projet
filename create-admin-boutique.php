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
$creation_prd = htmlspecialchars($_POST['creation_prd']);
$modification_prd = htmlspecialchars($_POST['modification_prd']);
$suppression_prd = htmlspecialchars($_POST['suppression_prd']);
$creation_ctg = htmlspecialchars($_POST['creation_ctg']);
$modification_ctg = htmlspecialchars($_POST['modification_ctg']);
$suppression_ctg = htmlspecialchars($_POST['suppression_ctg']);

$creat_madmin_query = $conn->prepare("INSERT INTO admin_boutique (id_btq,matricule_adm,nom_adm,mtp_adm,messagerie,notifications,modification,creation_prd,modification_prd,suppression_prd,creation_ctg,modification_ctg,suppression_ctg) 
VALUES (:id_btq,:matricule_adm,:nom_adm,:mtp_adm,:messagerie,:notifications,:modification,:creation_prd,:modification_prd,:suppression_prd,:creation_ctg,:modification_ctg,:suppression_ctg)");
$creat_madmin_query->bindParam(':id_btq', $id_btq);
$creat_madmin_query->bindParam(':matricule_adm', $matricule_adm);
$creat_madmin_query->bindParam(':nom_adm', $nom_adm);
$creat_madmin_query->bindParam(':mtp_adm', $hash_mtp_adm);
$creat_madmin_query->bindParam(':messagerie', $messagerie);
$creat_madmin_query->bindParam(':notifications', $notifications);
$creat_madmin_query->bindParam(':modification', $modification);
$creat_madmin_query->bindParam(':creation_prd', $creation_prd);
$creat_madmin_query->bindParam(':modification_prd', $modification_prd);
$creat_madmin_query->bindParam(':suppression_prd', $suppression_prd);
$creat_madmin_query->bindParam(':creation_ctg', $creation_ctg);
$creat_madmin_query->bindParam(':modification_ctg', $modification_ctg);
$creat_madmin_query->bindParam(':suppression_ctg', $suppression_ctg);
if($creat_madmin_query->execute()){
    $get_btq_admin_query = $conn->prepare("SELECT * FROM admin_boutique WHERE id_btq = $id_btq");
    if ($get_btq_admin_query->execute()) {
        $get_btq_admin_row = $get_btq_admin_query->fetch(PDO::FETCH_ASSOC);
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
            <input type="hidden" id="creation_prd_adm_autrs" value="<?php echo $get_btq_admin_row['creation_prd'] ?>">  
            <?php 
            if ($get_btq_admin_row['creation_prd'] == 1) {
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
            <input type="hidden" id="modification_prd_adm_autrs" value="<?php echo $get_btq_admin_row['modification_prd'] ?>">  
            <?php 
            if ($get_btq_admin_row['modification_prd'] == 1) {
            ?> 
            <i class="fas fa-check etat"></i>
            <?php }else{ ?>
            <i style="color:red" class="fas fa-ban etat"></i>
            <?php } ?>
            <p>Modification de produit</p>
            <div>
                <i class="fas fa-pen"></i>
            </div>
        </div>
        <div class="admin-autoisation">
            <input type="hidden" id="suppression_prd_adm_autrs" value="<?php echo $get_btq_admin_row['suppression_prd'] ?>">  
            <?php 
            if ($get_btq_admin_row['suppression_prd'] == 1) {
            ?> 
            <i class="fas fa-check etat"></i>
            <?php }else{ ?>
            <i style="color:red" class="fas fa-ban etat"></i>
            <?php } ?>
            <p>Suppression de produit</p>
            <div>
                <i class="fas fa-trash"></i>
            </div>
        </div>
        <div class="admin-autoisation">
            <input type="hidden" id="creation_ctg_adm_autrs" value="<?php echo $get_btq_admin_row['creation_ctg'] ?>">
            <?php 
            if ($get_btq_admin_row['creation_ctg'] == 1) {
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
        <div class="admin-autoisation">
            <input type="hidden" id="modification_ctg_adm_autrs" value="<?php echo $get_btq_admin_row['modification_ctg'] ?>">
            <?php 
            if ($get_btq_admin_row['modification_ctg'] == 1) {
            ?> 
            <i class="fas fa-check etat"></i>
            <?php }else{ ?>
            <i style="color:red" class="fas fa-ban etat"></i>
            <?php } ?>
            <p>Modification de categorie</p>
            <div>
                <i class="fas fa-pen"></i>
            </div>
        </div>
        <div class="admin-autoisation">
            <input type="hidden" id="suppression_ctg_adm_autrs" value="<?php echo $get_btq_admin_row['suppression_ctg'] ?>">
            <?php 
            if ($get_btq_admin_row['suppression_ctg'] == 1) {
            ?> 
            <i class="fas fa-check etat"></i>
            <?php }else{ ?>
            <i style="color:red" class="fas fa-ban etat"></i>
            <?php } ?>
            <p>Suppression de categorie</p>
            <div>
                <i class="fas fa-trash"></i>
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