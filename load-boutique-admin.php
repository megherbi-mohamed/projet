<?php
include_once './bdd/connexion.php';
$id_btq = htmlspecialchars($_POST['id_btq']);
$get_btq_admin_query = "SELECT * FROM admin_boutique WHERE id_btq = $id_btq";
$get_btq_admin_result = mysqli_query($conn,$get_btq_admin_query);
if (mysqli_num_rows($get_btq_admin_result) > 0) {
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
            <span class="nom">Nom</span>
        </div>
        <div>
            <input type="password" id="mtp_adm">
            <span class="mtp">Mot de passe</span>
        </div>
        <div>
            <input type="password" id="cnfrm_mtp_adm">
            <span class="cnfrm-mtp">Mot de passe confirmation</span>
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
            <input type="hidden" id="creation_adm_autrs" value="1">  
            <i class="fas fa-check etat"></i>
            <p>Creation de produit</p>
            <div>
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="admin-autoisation">
            <input type="hidden" id="categorie_adm_autrs" value="1">
            <i class="fas fa-check etat"></i>
            <p>Creation de categorie</p>
            <div>
                <i class="fas fa-plus"></i>
            </div>
        </div>
    </div>
    <button id="create_boutique_admin">Créer</button>
    <!-- <div id="loader_create_admin" class="center-create-admin"></div> -->
</div>
<?php } ?>

