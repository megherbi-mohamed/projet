<?php
include_once './bdd/connexion.php';
$text = htmlspecialchars($_POST['r']);
if ($text != '') {
    $rech_user_query = $conn->prepare("SELECT id_user AS id, type_user, nom_entrp_user AS nom, couverture_user AS img, ville_user AS ville, commune_user AS commune, latitude_user AS latitude, longitude_user AS longitude, adresse_user AS adresse, profession_user AS profession FROM utilisateurs WHERE type_user = 'professionnel' AND (nom_user LIKE '%$text%' OR nom_entrp_user LIKE '%$text%' OR profession_user LIKE '%$text%' OR description_user LIKE '%$text%' OR ville_user LIKE '%$text%' OR commune_user LIKE '%$text%')  
    UNION SELECT id_btq AS id, type_user, nom_btq AS nom, couverture_btq AS img, ville_btq AS ville, commune_btq AS commune, latitude_btq AS latitude, longitude_btq AS longitude, adresse_btq AS adresse, sous_categorie AS profession FROM boutiques WHERE type_user IS NOT NULL AND (nom_btq LIKE '%$text%' OR sous_categorie LIKE '%$text%' OR dscrp_btq LIKE '%$text%' OR ville_btq LIKE '%$text%')");
}
else{
    $rech_user_query = $conn->prepare("SELECT id_user AS id, type_user, nom_entrp_user AS nom, couverture_user AS img, ville_user AS ville, commune_user AS ville, latitude_user AS latitude, longitude_user AS longitude, adresse_user AS adresse, profession_user AS profession FROM utilisateurs WHERE type_user = 'professionnel' 
    UNION SELECT id_btq AS id, type_user, nom_btq AS nom, couverture_btq AS img, ville_btq AS ville, commune_btq AS commune, latitude_btq AS latitude, longitude_btq AS longitude, adresse_btq AS adresse, sous_categorie AS profession FROM boutiques WHERE type_user IS NOT NULL");
}   
if ($rech_user_query->execute()) {
    if ($rech_user_query->rowCount() > 0) {
    $i = 0;
    while ($rech_user_row = $rech_user_query->fetch(PDO::FETCH_ASSOC)){ 
        $i++;
        $user_total_rating_query = $conn->prepare("SELECT * FROM user_rating WHERE id_user = {$rech_user_row['id']}"); 
        $user_total_rating_query->execute();
        $tr = 0;$tt = 0;$tc = 0;$td = 0;$trp = 0;$n=1;
        while($user_total_rating_row = $user_total_rating_query->fetch(PDO::FETCH_ASSOC)){
            $tnr = $user_total_rating_row['rapidite'];
            $tnt = $user_total_rating_row['travaille'];
            $tnd = $user_total_rating_row['discipline'];
            $tnc = $user_total_rating_row['cout'];
            $tnrp = $user_total_rating_row['reputation'];

            if ($tnr!=0 && $tnt!=0 && $tnd!=0 && $tnc!=0 && $tnrp!=0) {
                $tr=$tr+$user_total_rating_row['rapidite'];
                $tt=$tt+$user_total_rating_row['travaille'];
                $tc=$tc+$user_total_rating_row['cout'];
                $td=$td+$user_total_rating_row['discipline'];
                $trp=$trp+$user_total_rating_row['reputation'];
                $n++;
            }
        }
        $total_r = ($tr/$n+$tt/$n+$td/$n+$tc/$n+$trp/$n)/5;
        $tr1 = 'far fa-star';$tr2 = 'far fa-star';$tr3 = 'far fa-star';$tr4 = 'far fa-star';$tr5 = 'far fa-star';
        if ($total_r >= 20) {$tr1 = 'fas fa-star';}
        if ($total_r >= 40) {$tr2 = 'fas fa-star';}
        if ($total_r >= 60) {$tr3 = 'fas fa-star';}
        if ($total_r >= 80) {$tr4 = 'fas fa-star';}
        if ($total_r == 100) {$tr5 = 'fas fa-star';}
?>
<div class="search-item">
    <div class="search-item-img">
        <img src="<?php if($rech_user_row['img']==''){echo'./images/profile.png';}else{echo './'.$rech_user_row['img'];}?>" alt="">
    </div>
    <div class="description-item">
        <h4><?php echo $rech_user_row['nom'].', '.$rech_user_row['profession'] ?></h4>
        <div class="item-notation">
            <i class="<?php echo $tr1 ?>"></i>
            <i class="<?php echo $tr2 ?>"></i>
            <i class="<?php echo $tr3 ?>"></i>
            <i class="<?php echo $tr4 ?>"></i>
            <i class="<?php echo $tr5 ?>"></i>
        </div>
        <h5><?php echo $rech_user_row['ville'].', Algérie' ?></h5>
    </div>
    <div class="item-notation-responsive">
        <i class="<?php echo $tr1 ?>"></i>
        <i class="<?php echo $tr2 ?>"></i>
        <i class="<?php echo $tr3 ?>"></i>
        <i class="<?php echo $tr4 ?>"></i>
        <i class="<?php echo $tr5 ?>"></i>
    </div>
    <div class="profile-position">
        <div>
            <i id="display_position_<?php echo $i ?>" class="fas fa-map-marker-alt"></i>
        </div>
        <div>
            <a href="https://maps.google.com/?q=<?php echo $rech_user_row['latitude'] ?>,<?php echo $rech_user_row['longitude'] ?>"><i class="fas fa-directions"></i></a>
        </div>
        <div>
            <?php
            if ($rech_user_row['type_user'] == 'professionnel') { ?>
            <a href="utilisateur/<?php echo $rech_user_row['id'] ?>"><i class="far fa-user-circle"></i></a>
            <?php }else if($rech_user_row['type_user'] == 'boutique'){ ?>
            <a href="boutique/<?php echo $rech_user_row['id'] ?>"><i class="fas fa-store-alt"></i></a>
            <?php } ?>
        </div>
    </div>
    <input id="id_pos_<?php echo $i ?>" type="hidden" value="<?php echo $rech_user_row['id']; ?>">
    <input id="lat_pos_<?php echo $i ?>" type="hidden" value="<?php echo $rech_user_row['latitude']; ?>">
    <input id="lng_pos_<?php echo $i ?>" type="hidden" value="<?php echo $rech_user_row['longitude']; ?>">
    <input id="img_pos_<?php echo $i ?>" type="hidden" value="<?php echo $rech_user_row['img']; ?>">
    <input id="nom_pos_<?php echo $i ?>" type="hidden" value="<?php echo $rech_user_row['nom']; ?>">
    <input id="adrss_pos_<?php echo $i ?>" type="hidden" value="<?php echo $rech_user_row['adresse']; ?>">
</div>
<?php }
    } 
    else { ?>
<div class="empty-msg-ntf">
    <p>Aucun resultat pour (<?php echo $text ?>)</p>
</div>
<?php 
    }
}
else{
    echo 4;
} 
?>
