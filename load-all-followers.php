<?php 
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_id_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_id_query->execute();
$get_session_id_row = $get_session_id_query->fetch(PDO::FETCH_ASSOC);

$user_session_query = $conn->prepare("SELECT * FROM utilisateurs WHERE id_user = {$get_session_id_row['id_user']}");
$user_session_query->execute();

if ($user_session_query->rowCount() > 0) {
    $row = $user_session_query->fetch(PDO::FETCH_ASSOC);
    $id_user = $row['id_user'];
}
$get_abn_query = $conn->prepare("SELECT * FROM abonnes WHERE id_user = $id_user ORDER BY id_a DESC");
$get_abn_query->execute();
if ($get_abn_query->rowCount() > 0){
?>
<div class="all-user-followers">
<?php
$i = 0;
while ($get_abn_row = $get_abn_query->fetch(PDO::FETCH_ASSOC)) {
$i++;

$get_abn_inf_query = $conn->prepare("SELECT id_user AS id, type_user AS type_u, img_user AS img, nom_user AS nom FROM utilisateurs WHERE id_user = {$get_abn_row['id_abn_user']}
                                    UNION SELECT id_btq AS id, type_user AS type_u,logo_btq AS img, nom_btq AS nom FROM boutiques WHERE id_btq = {$get_abn_row['id_abn_user']}");
$get_abn_inf_query->execute();
$get_abn_inf_row = $get_abn_inf_query->fetch(PDO::FETCH_ASSOC);
?>
<div class="user-follower" id="user_follower_<?php echo $i ?>">
    <div class="user-follower-top">
        <img src="./<?php echo $get_abn_inf_row['img'] ?>" alt="">
        <div>
            <?php if ($get_abn_inf_row['type_u'] == 'professionnel') { ?>
                <i class="far fa-user-circle"></i>
            <?php } else if ($get_abn_inf_row['type_u'] == 'boutique') { ?>
                <i class="fas fa-store-alt"></i>
            <?php } ?>
        </div>
    </div>
    <div class="user-follower-bottom">
        <h4><?php echo $get_abn_inf_row['nom'] ?></h4>
        <div id="disfollow_button_<?php echo $i ?>">
            <p>Disabonner</p>
            <i class="fas fa-user-slash"></i>
            <input type="hidden" id="nom_user_abn_<?php echo $i ?>" value="<?php echo $get_abn_inf_row['nom'] ?>">
            <input type="hidden" id="id_user_abn_<?php echo $i ?>" value="<?php echo $get_abn_inf_row['id'] ?>">
        </div>
        <button id="show_profile_button_<?php echo $i ?>">Voire le profile</button>
    </div>
</div>
<?php } ?>
</div>
<?php
}
else{
    echo '<p style="font-size:.85rem; text-align:center;">Accun abonne(e)</p>';
}
?>