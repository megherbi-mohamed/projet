<?php 
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_id_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                        OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
if ($get_session_id_query->execute()) {
    $get_session_id_row = $get_session_id_query->fetch(PDO::FETCH_ASSOC);
    $user_session_query = $conn->prepare("SELECT * FROM utilisateurs WHERE id_user = {$get_session_id_row['id_user']}");
    if ($user_session_query->execute()) {
        $row = $user_session_query->fetch(PDO::FETCH_ASSOC);
        $id_user = $row['id_user'];
        $btq_menu_query = $conn->prepare("SELECT * FROM boutiques WHERE id_createur = $id_user");
        if ($btq_menu_query->execute()) {
?>
<div class="user-list-dropdown-top">
    <div id="cancel_user_list_dropdown">
        <i class="fas fa-arrow-left"></i>
    </div>
    <h4>Profile</h4>
</div>
<div class="user-profile" id="display_user_profile">
    <img src="<?php if($row['img_user']==''){echo'./images/profile.png';}else{echo './'.$row['img_user'];}?>" alt="profile user">
    <div>
        <p><?php echo $row['nom_user']; ?></p>
        <p>Voir votre profile</p>
    </div>
</div>
<hr>
<div class="user-menu-boutiques">
    <?php
    $i = 0;
    while($btq_menu_row = $btq_menu_query->fetch(PDO::FETCH_ASSOC)){
    $i++;
    ?>
    <div id="go_gerer_boutique_<?php echo $i ?>">
        <?php if ($btq_menu_row['logo_btq'] != '') { ?>
            <img src="./<?php echo $btq_menu_row['logo_btq'] ?>" alt="">
        <?php }else if($btq_menu_row['logo_btq'] == ''){ ?>
            <img src="./boutique-logo/logo.png" alt="">
        <?php } ?>
        <p><?php echo $btq_menu_row['nom_btq'] ?></p>
        <input type="hidden" id="id_gb_<?php echo $i ?>" value="<?php echo $btq_menu_row['id_btq'] ?>">
    </div>
    <?php } ?>
</div>
<hr>
<div class="user-update-profile" id="display_parametres_profile">
    <div>
        <i class="fas fa-cog"></i>
    </div>
    <p>Paramètres du profile</p>
</div>
<div class="user-feedback">
    <div>
        <i class="fas fa-question-circle"></i>
    </div>
    <div>
        <p>Poser vos questions</p>
        <p>Aidez nous à ameliorer Nhannik</p>
    </div>
</div>
<div class="user-logout">
    <div>
        <i class="fas fa-sign-out-alt"></i>
    </div>
    <p>Se déconnecter</p>
</div>
<?php 
        }
        else{
            echo 0;
        }
    }
    else{
        echo 0;
    }
}
else{
    echo 0;
}
?>