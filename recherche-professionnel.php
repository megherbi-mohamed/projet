<?php
include_once './bdd/connexion.php';

// if (isset($_GET['r'])) {
    $text = htmlspecialchars($_POST['r']);
    if ($text != '') {
        $rech_user_query = "SELECT * FROM utilisateurs WHERE type_user = 'professionnel' AND nom_user LIKE '%$text%' OR profession_user LIKE '%$text%' OR dscrp_user LIKE '%$text%' OR ville LIKE '%$text%'";
        $rech_user_result = mysqli_query($conn, $rech_user_query);
        $rech_user_num = mysqli_num_rows($rech_user_result);
    }
    else{
        $rech_user_query = "SELECT * FROM utilisateurs WHERE type_user = 'professionnel'";
        $rech_user_result = mysqli_query($conn, $rech_user_query);
        $rech_user_num = mysqli_num_rows($rech_user_result);
    }  
// }
// else{
//     $rech_user_query = "SELECT * FROM utilisateurs WHERE type_user = 'professionnel'";
//     $rech_user_result = mysqli_query($conn, $rech_user_query);
//     $rech_user_num = mysqli_num_rows($rech_user_result);
// }
  
// if (isset($_GET['r'])) {
    // $text = $_GET['r'];
    if ($text != '') {
        $rech_btq_query = "SELECT * FROM boutiques WHERE etat_btq = 0 AND (nom_btq LIKE '%$text%' OR categorie LIKE '%$text%' OR sous_categorie LIKE '%$text%' OR ville_btq LIKE '%$text%' OR dscrp_btq LIKE '%$text%')";
        $rech_btq_result = mysqli_query($conn, $rech_btq_query);
    }
    else{
        $rech_btq_query = "SELECT * FROM boutiques WHERE etat_btq = 0";
        $rech_btq_result = mysqli_query($conn, $rech_btq_query);
    }
// }
// else{
//     $rech_btq_query = "SELECT * FROM boutiques WHERE etat_btq = 0";
//     $rech_btq_result = mysqli_query($conn, $rech_btq_query);
// }

?>

<?php
$i = 0;
while ($rech_user_row = mysqli_fetch_assoc($rech_user_result)){ 
$i++;
    $user_total_rating_query = "SELECT * FROM user_rating WHERE id_user = {$rech_user_row['id_user']}"; 
    $user_total_rating_result = mysqli_query($conn, $user_total_rating_query);

    $tr = 0;$tt = 0;$tc = 0;$td = 0;$trp = 0;$n=1;
    while($user_total_rating_row=mysqli_fetch_assoc($user_total_rating_result)){
        
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
        <img src="<?php if($rech_user_row['couverture_user']==''){echo'./images/profile.png';}else{echo './'.$rech_user_row['couverture_user'];}?>" alt="">
    </div>
    <div class="description-item">
        <h4><?php echo $rech_user_row['nom_user'].', '.$rech_user_row['profession_user'] ?></h4>
        <div class="item-notation">
            <i class="<?php echo $tr1 ?>"></i>
            <i class="<?php echo $tr2 ?>"></i>
            <i class="<?php echo $tr3 ?>"></i>
            <i class="<?php echo $tr4 ?>"></i>
            <i class="<?php echo $tr5 ?>"></i>
        </div>
        <h5><?php echo $rech_user_row['ville'].', Algérie' ?></h5>
    </div>
    <!-- <p><?php echo $rech_user_row['dscrp_user'] ?></p> -->
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
            <a href="https://maps.google.com/?q=<?php echo $rech_user_row['latitude_user'] ?>,<?php echo $rech_user_row['longitude_user'] ?>"><i class="fas fa-directions"></i></a>
        </div>
        <div>
            <a href="./utilisateur-info.php?id_user=<?php echo $rech_user_row['id_user'] ?>"><i class="far fa-user-circle"></i></a>
        </div>
    </div>
    <input id="id_pos_<?php echo $i ?>" type="hidden" value="<?php echo $rech_user_row['id_user']; ?>">
    <input id="lat_pos_<?php echo $i ?>" type="hidden" value="<?php echo $rech_user_row['latitude_user']; ?>">
    <input id="lng_pos_<?php echo $i ?>" type="hidden" value="<?php echo $rech_user_row['longitude_user']; ?>">
    <input id="img_pos_<?php echo $i ?>" type="hidden" value="<?php echo $rech_user_row['img_user']; ?>">
    <input id="nom_pos_<?php echo $i ?>" type="hidden" value="<?php echo $rech_user_row['nom_user']; ?>">
    <input id="adrss_pos_<?php echo $i ?>" type="hidden" value="<?php echo $rech_user_row['adresse_user']; ?>">
</div>
<?php } ?>

<?php
$j = $rech_user_num;
while ($rech_btq_row = mysqli_fetch_assoc($rech_btq_result)){ 
$j++;    
?>
<div class="search-item">
    <div class="search-item-img">
        <img src="<?php if($rech_btq_row['couverture_btq']==''){echo'./images/profile.png';}else{echo './'.$rech_btq_row['couverture_btq'];}?>" alt="">
    </div>
    <div class="description-item">
        <h4><?php echo $rech_btq_row['nom_btq'].', '.$rech_btq_row['sous_categorie'] ?></h4>
        <div class="item-notation">
            <i class="far fa-star"></i>
            <i class="far fa-star"></i>
            <i class="far fa-star"></i>
            <i class="far fa-star"></i>
            <i class="far fa-star"></i>
        </div>
        <h5><?php echo $rech_btq_row['ville_btq'].', Algérie' ?></h5>
    </div>
    <!-- <p><?php echo $rech_btq_row['dscrp_btq'] ?></p> -->
    <div class="item-notation-responsive">
        <i class="far fa-star"></i>
        <i class="far fa-star"></i>
        <i class="far fa-star"></i>
        <i class="far fa-star"></i>
        <i class="far fa-star"></i>
    </div>
    <div class="profile-position">
        <div>
            <i id="display_pos_btq_<?php echo $j ?>" class="fas fa-map-marker-alt"></i>
        </div>
        <div>
            <a href="https://maps.google.com/?q=<?php echo $rech_btq_row['latitude_user'] ?>,<?php echo $rech_btq_row['longitude_user'] ?>"><i class="fas fa-directions"></i></a>
        </div>
        <div>
            <a href="./boutique.php?id_btq=<?php echo $rech_btq_row['id_btq'] ?>"><i class="fas fa-store-alt"></i></a>
        </div>
    </div>
    <input id="id_pos_btq_<?php echo $j ?>" type="hidden" value="<?php echo $rech_btq_row['id_btq']; ?>">
    <input id="lat_pos_btq_<?php echo $j ?>" type="hidden" value="<?php echo $rech_btq_row['latitude_btq']; ?>">
    <input id="lng_pos_btq_<?php echo $j ?>" type="hidden" value="<?php echo $rech_btq_row['longitude_btq']; ?>">
    <input id="img_pos_btq_<?php echo $j ?>" type="hidden" value="<?php echo $rech_btq_row['logo_btq']; ?>">
    <input id="nom_pos_btq_<?php echo $j ?>" type="hidden" value="<?php echo $rech_btq_row['nom_btq']; ?>">
    <input id="adrss_pos_btq_<?php echo $j ?>" type="hidden" value="<?php echo $rech_btq_row['adresse_btq']; ?>">
</div>
<?php } ?>