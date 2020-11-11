<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_user_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_user_query->execute();
$get_session_user_row = $get_session_user_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_user_row['id_user'];
?>
<div class="select-boutique-product">
    <button id="create_new_promotion_product" style="margin-bottom:10px">Créer un nouveau produit</button>
</div>
<?php
$get_user_boutiques_query = $conn->prepare("SELECT id_btq,nom_btq,logo_btq FROM boutiques WHERE id_createur = $id_user ORDER BY id_btq DESC");
if($get_user_boutiques_query->execute()){
$i = 0;
while ($get_user_boutiques_row = $get_user_boutiques_query->fetch(PDO::FETCH_ASSOC)) {
$i++;
$id_btq = $get_user_boutiques_row['id_btq'];
$nom_btq = $get_user_boutiques_row['nom_btq'];
$logo_btq = $get_user_boutiques_row['logo_btq'];
$img_btq = '';
if ($logo_btq == '') {
    $img_btq = 'boutique-logo/logo.png';
}
else{
    $img_btq = $logo_btq;
}
?>
<div class="user-boutique-promotion" id="user_boutique_promotion_<?php echo $i ?>">
    <input type="hidden" id="id_btq_prm_<?php echo $i ?>" value="<?php echo $id_btq ?>">    
    <img src="<?php echo $img_btq ?>" alt="">
    <p><?php echo $nom_btq ?></p>
</div>
<?php }} else { 
echo 0;
}?>
