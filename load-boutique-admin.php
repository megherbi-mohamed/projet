<?php
include_once './bdd/connexion.php';
$id_session_btq = htmlspecialchars($_POST['id_btq']);
$get_session_btq_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session_btq' OR id_user_1 = '$id_session_btq' OR id_user_2 = '$id_session_btq' 
                                            OR id_user_3 = '$id_session_btq' OR id_user_4 = '$id_session_btq' OR id_user_5 = '$id_session_btq'");
$get_session_btq_query->execute();
$get_session_btq_row = $get_session_btq_query->fetch(PDO::FETCH_ASSOC);
$id_btq = $get_session_btq_row['id_user'];
$get_btq_admin_query = $conn->prepare("SELECT * FROM admin_boutique WHERE id_btq = $id_btq");
$get_btq_admin_query->execute();
if ($get_btq_admin_query->rowCount() > 0) {
    $get_btq_admin_row = $get_btq_admin_query->fetch(PDO::FETCH_ASSOC);
?>
<div class="boutique-admin-info">
    <div class="boutique-admin-info-top">
        <div class="admin-info-left">
            <p>Admin</p>
            <h4><?php echo $get_btq_admin_row['nom_adm'] ?></h4>
            <?php if ($get_btq_admin_row['etat'] == 1) { ?>
                <div style="background:green"></div>
            <?php } else { ?>
                <div></div>
            <?php } ?>
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
    <div class="create-publication-bottom-button">
        <div id="loader_create_publication_bottom_button" style="top:20px" class="button-center"></div>
        <button id="update_boutique_admin">Enregistrer les modifications</button>
    </div>
</div>
<?php }else{ ?>
<div class="create-admin-boutique">
    <h3>Créer un admin pur votre boutique!</h3>
    <div class="create-admin-boutique-top">
        <div class="matricule-admin">
            <div>
                <input type="text" id="matricule_adm" placeholder="Matricule">
                <!-- <span class="matricule">Admin matricule</span> -->
                <div id="loader_create_matricule" class="center-create-matricule"></div>
            </div>
            <button id="create_matricule">Créer matricule</button>
        </div>
        <div>
            <input type="text" id="nom_adm">
            <span class="nom-adm">Nom *</span>
        </div>
        <div>
            <input type="password" id="mtp_adm">
            <span class="mtp-adm">Mot de passe *</span>
        </div>
        <div>
            <input type="password" id="cnfrm_mtp_adm">
            <span class="cnfrm-mtp-adm">Mot de passe confirmation *</span>
        </div>
    </div>
    <hr>
    <div class="create-admin-boutique-bottom">
        <h4>Admin options autorisation</h4>
        <div class="admin-autoisation">
            <input type="hidden" id="messagerie_adm_autrs" value="1">
            <i class="fas fa-check etat"></i>
            <p>Messagerie</p>
            <div>
                <i class="fab fa-facebook-messenger"></i>
            </div>
        </div>
        <div class="admin-autoisation">
            <input type="hidden" id="notifications_adm_autrs" value="1">
            <i class="fas fa-check etat"></i>
            <p>Notifications</p>
            <div>
                <i class="fas fa-bell"></i>
            </div>
        </div>
        <div class="admin-autoisation">
            <input type="hidden" id="modification_adm_autrs" value="1">
            <i class="fas fa-check etat"></i>
            <p>Boutique modification</p>
            <div>
                <i class="fas fa-cog"></i>
            </div>
        </div>
        <div class="admin-autoisation">
            <input type="hidden" id="creation_prd_adm_autrs" value="1">  
            <i class="fas fa-check etat"></i>
            <p>Creation de produit</p>
            <div>
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="admin-autoisation">
            <input type="hidden" id="modification_prd_adm_autrs" value="1">  
            <i class="fas fa-check etat"></i>
            <p>Modification de produit</p>
            <div>
                <i class="fas fa-pen"></i>
            </div>
        </div>
        <div class="admin-autoisation">
            <input type="hidden" id="suppression_prd_adm_autrs" value="1">  
            <i class="fas fa-check etat"></i>
            <p>Suppression de produit</p>
            <div>
                <i class="fas fa-trash"></i>
            </div>
        </div>
        <div class="admin-autoisation">
            <input type="hidden" id="creation_ctg_adm_autrs" value="1">
            <i class="fas fa-check etat"></i>
            <p>Creation de categorie</p>
            <div>
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="admin-autoisation">
            <input type="hidden" id="modification_ctg_adm_autrs" value="1">
            <i class="fas fa-check etat"></i>
            <p>Modification de categorie</p>
            <div>
                <i class="fas fa-pen"></i>
            </div>
        </div>
        <div class="admin-autoisation">
            <input type="hidden" id="suppression_ctg_adm_autrs" value="1">
            <i class="fas fa-check etat"></i>
            <p>Suppression de categorie</p>
            <div>
                <i class="fas fa-trash"></i>
            </div>
        </div>
    </div>
    <div class="create-publication-bottom-button">
        <div id="loader_create_publication_bottom_button" style="top:20px" class="button-center"></div>
        <button id="create_boutique_admin">Créer</button>
    </div>
</div>
<?php } ?>

