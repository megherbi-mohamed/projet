<?php
include_once './bdd/connexion.php';
$type_recherche = htmlspecialchars($_POST['type_recherche']);
$type_filter = htmlspecialchars($_POST['type_filter']);
$text = htmlspecialchars($_POST['text']);
$categorie = htmlspecialchars($_POST['categorie_user']);
$profession = htmlspecialchars($_POST['profession_user']);;
$ville = htmlspecialchars($_POST['ville_user']);
$commune = htmlspecialchars($_POST['commune_user']);
if ($type_recherche == 'tout') {
    if ($text != '') {
        $get_professionnel_query = $conn->prepare("SELECT id_user,nom_entrp_user,img_user,couverture_user,categorie_user,profession_user FROM utilisateurs WHERE type_user = 'professionnel' AND (nom_entrp_user LIKE '%$text%' OR categorie_user LIKE '%$text%' OR profession_user LIKE '%$text%' OR description_user LIKE '%$text%' OR ville_user LIKE '%$text%' OR commune_user LIKE '%$text%') ORDER BY id_user DESC LIMIT 6");
        $get_boutique_query = $conn->prepare("SELECT id_btq,nom_btq,logo_btq,couverture_btq,categorie_btq,sous_categorie_btq FROM boutiques WHERE type_user IS NOT NULL AND (nom_btq LIKE '%$text%' OR categorie_btq LIKE '%$text%' OR sous_categorie_btq LIKE '%$text%' OR description_btq LIKE '%$text%' OR ville_btq LIKE '%$text%' OR commune_btq LIKE '%$text%') ORDER BY id_btq DESC LIMIT 4");
        $get_product_query = $conn->prepare("SELECT produit_boutique.id_prd,produit_boutique.id_btq,nom_prd,prix_prd,media_url FROM produit_boutique,produits_media WHERE produit_boutique.id_prd = produits_media.id_prd AND (nom_prd LIKE '%$text%' OR description_prd LIKE '%$text%' OR categorie_prd LIKE '%$text%') AND id_prd_m IN (SELECT MIN(id_prd_m) FROM produits_media GROUP BY id_prd) LIMIT 8");
        $get_boutdechantier_query = $conn->prepare("SELECT nom_prd,prix_prd,media_url FROM produit_boutdechantier,bt_produits_media WHERE produit_boutdechantier.id_prd = bt_produits_media.id_prd AND (nom_prd LIKE '%$text%' OR description_prd LIKE '%$text%' OR categorie_prd LIKE '%$text%') AND id_prd_m IN (SELECT MIN(id_prd_m) FROM bt_produits_media GROUP BY id_prd) LIMIT 8");
        // $get_promotion_query = $conn->prepare("SELECT id_prm,titre_prm,date_debut_prm,date_fin_prm,ville_prm,commune_prm FROM promotions WHERE titre_prm LIKE '%$text%' OR categorie_prm LIKE '%$text%' OR sous_categorie_prm LIKE '%$text%' OR description_prm LIKE '%$text%' OR ville_prm LIKE '%$text%' OR commune_prm LIKE '%$text%' ORDER BY id_prm DESC LIMIT 4");
        // $get_evenement_query = $conn->prepare("SELECT id_evn,titre_evn,date_debut_evn,date_fin_evn,ville_evn,commune_evn FROM evenements WHERE titre_evn LIKE '%$text%' OR type_evn LIKE '%$text%' OR description_evn LIKE '%$text%' OR ville_evn LIKE '%$text%' OR commune_evn LIKE '%$text%' ORDER BY id_evn DESC LIMIT 4");
        if ($get_professionnel_query->execute() && $get_boutique_query->execute() && $get_product_query->execute() && $get_boutdechantier_query->execute()) {
            // $get_promotion_row = $get_promotion_query->fetch(PDO::FETCH_ASSOC);
            // $get_evenement_row = $get_evenement_query->fetch(PDO::FETCH_ASSOC);
?>
<div class="all-search-result-overview">
    <div class="all-search-result-overview-top">
        <div class="all-search-result-overview-top-left">
            <div>
                <i class="fas fa-user"></i>
            </div>
            <h4>Professionnels - entreprises</h4>
        </div>
        <button id="show_all_professionnel_result">Voir tout</button>
    </div>
    <div class="professionnel-search-result-overview-bottom">
        <?php 
        $p = 0;
        while ($get_professionnel_row = $get_professionnel_query->fetch(PDO::FETCH_ASSOC)) {
        $p++;
        ?>
        <input type="hidden" id="id_professionnel_overview_<?php echo $p ?>" value="<?php echo $get_professionnel_row['id_user'] ?>">
        <div class="professionnel-overview" id="professionnel_overview_<?php echo $p ?>">
            <img class="professionnel-overview-couverture" src="<?php if($get_professionnel_row['couverture_user']==''){echo'./images/logo.png';}else{echo './'.$get_professionnel_row['couverture_user'];}?>" alt="logo">
            <img class="professionnel-overview-logo" src="<?php if($get_professionnel_row['img_user']==''){echo'./images/logo.png';}else{echo './'.$get_professionnel_row['img_user'];}?>" alt="logo">
            <div>
                <h4><?php echo $get_professionnel_row['nom_entrp_user'] ?></h4>
                <p><?php echo $get_professionnel_row['categorie_user'].', '.$get_professionnel_row['profession_user'] ?></p>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<div class="all-search-result-overview">
    <div class="all-search-result-overview-top">
        <div class="all-search-result-overview-top-left">
            <div>
                <i class="fas fa-store-alt"></i>
            </div>
            <h4>Boutiques</h4>
        </div>
        <button id="show_all_boutique_result">Voir tout</button>
    </div>
    <div class="boutique-search-result-overview-bottom">
        <?php 
        $b = 0;
        while ($get_boutique_row = $get_boutique_query->fetch(PDO::FETCH_ASSOC)) {
        $b++;
        ?>
        <input type="hidden" id="id_boutique_overview_<?php echo $b ?>" value="<?php echo $get_boutique_row['id_btq'] ?>">
        <div class="boutique-overview" id="boutique_overview_<?php echo $b ?>">
            <img class="boutique-overview-couverture" src="<?php if($get_boutique_row['couverture_btq']==''){echo'./images/logo.png';}else{echo './'.$get_boutique_row['couverture_btq'];}?>" alt="logo">
            <img class="boutique-overview-logo" src="<?php if($get_boutique_row['logo_btq']==''){echo'./images/logo.png';}else{echo './'.$get_boutique_row['logo_btq'];}?>" alt="logo">
            <div>
                <h4><?php echo $get_boutique_row['nom_btq'] ?></h4>
                <p><?php echo $get_boutique_row['categorie_btq'].', '.$get_boutique_row['sous_categorie_btq'] ?></p>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<div class="all-search-result-overview">
    <div class="all-search-result-overview-top">
        <div class="all-search-result-overview-top-left">
            <div>
                <i class="fas fa-boxes"></i>
            </div>
            <h4>Produits boutiques</h4>
        </div>
        <button id="show_all_product_result">Voir tout</button>
    </div>
    <div class="product-search-result-overview-bottom">
        <?php 
        $pr = 0;
        while ($get_product_row = $get_product_query->fetch(PDO::FETCH_ASSOC)) {
        $pr++;
        ?>
        <input type="hidden" id="id_product_overview_<?php echo $pr ?>" value="<?php echo $get_product_row['id_prd'] ?>">
        <input type="hidden" id="id_boutique_product_overview_<?php echo $pr ?>" value="<?php echo $get_product_row['id_btq'] ?>">
        <div class="product-overview" id="product_overview_<?php echo $pr ?>">
            <img class="product-overview-image" src="<?php if($get_product_row['media_url']==''){echo'./images/logo.png';}else{echo './'.$get_product_row['media_url'];}?>" alt="logo">
            <div>
                <h4><?php echo $get_product_row['prix_prd'] ?> <span>.Da</span></h4>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<div class="all-search-result-overview">
    <div class="all-search-result-overview-top">
        <div class="all-search-result-overview-top-left">
            <div>
                <i class="fas fa-store"></i>
            </div>
            <h4>Produits boutdechantier</h4>
        </div>
        <button id="show_all_boutdechantier_result">Voir tout</button>
    </div>
    <div class="product-search-result-overview-bottom">
        <?php 
        while ($get_boutdechantier_row = $get_boutdechantier_query->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <div class="product-overview">
            <img class="product-overview-image" src="<?php if($get_boutdechantier_row['media_url']==''){echo'./images/logo.png';}else{echo './'.$get_boutdechantier_row['media_url'];}?>" alt="logo">
            <div>
                <h4><?php echo $get_boutdechantier_row['prix_prd'] ?> <span>.Da</span></h4>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<?php
        }
        else{
            echo 0;
        }
    }
}
else if ($type_recherche == 'professionnel') {
    if ($type_filter == 'text') {
        if ($text != '') {
            $get_professionnel_query = $conn->prepare("SELECT * FROM utilisateurs WHERE type_user = 'professionnel' AND (nom_entrp_user LIKE '%$text%' OR profession_user LIKE '%$text%' OR description_user LIKE '%$text%' OR ville_user LIKE '%$text%' OR commune_user LIKE '%$text%') ORDER BY id_user DESC");
            if ($get_professionnel_query->execute()) {
                $i = 0;
                while ($get_professionnel_row =  $get_professionnel_query->fetch(PDO::FETCH_ASSOC)) {
                    $i++;
                    $user_total_rating_query = $conn->prepare("SELECT * FROM user_rating WHERE id_user = {$get_professionnel_row['id_user']}"); 
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
    <div class="search-item-left">
        <img src="<?php if($get_professionnel_row['couverture_user']==''){echo'./images/profile.png';}else{echo './'.$get_professionnel_row['img_user'];}?>" alt="">
    </div>
    <div class="search-item-right">
        <h4><?php echo $get_professionnel_row['nom_user'] ?></h4>
        <h5><i class="fas fa-map-marker-alt" style="margin-left:2px"></i><?php echo $get_professionnel_row['ville_user'].', '.$get_professionnel_row['commune_user'] ?></h5>
        <p><i class="fas fa-briefcase"></i><?php echo $get_professionnel_row['categorie_user'].', '?><span><?php echo $get_professionnel_row['profession_user'] ?></span></p>
        <div class="profile-position">
            <div class="item-notation">
                <i class="<?php echo $tr1 ?>"></i>
                <i class="<?php echo $tr2 ?>"></i>
                <i class="<?php echo $tr3 ?>"></i>
                <i class="<?php echo $tr4 ?>"></i>
                <i class="<?php echo $tr5 ?>"></i>
            </div>
            <div class="recherche-rdirection-button" id="display_position_<?php echo $i ?>">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="recherche-rdirection-button">
                <a href="https://maps.google.com/?q=<?php echo $get_professionnel_row['latitude_user'].','.$get_professionnel_row['longitude_user'] ?>"><i class="fas fa-directions"></i></a>
            </div>
            <div class="recherche-rdirection-button">
                <a href="utilisateur/<?php echo $get_professionnel_row['id_user'] ?>"><i class="far fa-user-circle"></i></a>
            </div>
        </div>
    </div>
    <div class="search-item-rsponsive">
        <h5><i class="fas fa-map-marker-alt" style="margin-left:2px"></i><?php echo $get_professionnel_row['ville_user'].', '.$get_professionnel_row['commune_user'] ?></h5>
        <p><i class="fas fa-briefcase"></i><?php echo $get_professionnel_row['categorie_user'].', '?><span><?php echo $get_professionnel_row['profession_user'] ?></span></p>
    </div>
    <input id="id_pos_<?php echo $i ?>" type="hidden" value="<?php echo $get_professionnel_row['id_user']; ?>">
    <input id="lat_pos_<?php echo $i ?>" type="hidden" value="<?php echo $get_professionnel_row['latitude_user']; ?>">
    <input id="lng_pos_<?php echo $i ?>" type="hidden" value="<?php echo $get_professionnel_row['longitude_user']; ?>">
    <input id="img_pos_<?php echo $i ?>" type="hidden" value="<?php echo $get_professionnel_row['img_user']; ?>">
    <input id="nom_pos_<?php echo $i ?>" type="hidden" value="<?php echo $get_professionnel_row['nom_user']; ?>">
    <input id="adrss_pos_<?php echo $i ?>" type="hidden" value="<?php echo $get_professionnel_row['adresse_user']; ?>">
</div>
<?php
                }
            }
            else{
                echo 0;
            }
        }
    }
    else if ($type_filter == 'filter') {
        if (!empty($categorie) || !empty($profession) || !empty($ville) || !empty($commune)) {
            $where_professionnel = "WHERE type_user = 'professionnel' AND ";
            if(!empty($categorie)){
                $where_professionnel .= "categorie_user = '$categorie' AND ";
            }
            if(!empty($profession)){
                $where_professionnel .= "profession_user = '$profession' AND ";
            }
            if(!empty($ville)){
                $where_professionnel .= "ville_user = '$ville' AND ";
            }
            if(!empty($commune)){
                $where_professionnel .= "commune_user = '$commune' AND ";
            }
            $where_professionnel .= "ORDER BY id_user DESC";
            $word = "AND ORDER";
            if(strpos($where_professionnel, $word) !== false){
                $where_professionnel_final = str_replace($word,"ORDER",$where_professionnel);
            } else {
                $where_professionnel_final = $where_professionnel;
            }
            $get_professionnel_query = $conn->prepare("SELECT * FROM utilisateurs $where_professionnel_final");
        }
        else{
            $get_professionnel_query = $conn->prepare("SELECT * FROM utilisateurs WHERE type_user = 'professionnel' ORDER BY id_user DESC");
        }
        if ($get_professionnel_query->execute()) {
            $i = 0;
            while ($get_professionnel_row = $get_professionnel_query->fetch(PDO::FETCH_ASSOC)) {
                $i++;
                $user_total_rating_query = $conn->prepare("SELECT * FROM user_rating WHERE id_user = {$get_professionnel_row['id_user']}"); 
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
    <div class="search-item-left">
        <img src="<?php if($get_professionnel_row['couverture_user']==''){echo'./images/profile.png';}else{echo './'.$get_professionnel_row['img_user'];}?>" alt="">
    </div>
    <div class="search-item-right">
        <h4><?php echo $get_professionnel_row['nom_user'] ?></h4>
        <h5><i class="fas fa-map-marker-alt" style="margin-left:2px"></i><?php echo $get_professionnel_row['ville_user'].', '.$get_professionnel_row['commune_user'] ?></h5>
        <p><i class="fas fa-briefcase"></i><?php echo $get_professionnel_row['categorie_user'].', '?><span><?php echo $get_professionnel_row['profession_user'] ?></span></p>
        <div class="profile-position">
            <div class="item-notation">
                <i class="<?php echo $tr1 ?>"></i>
                <i class="<?php echo $tr2 ?>"></i>
                <i class="<?php echo $tr3 ?>"></i>
                <i class="<?php echo $tr4 ?>"></i>
                <i class="<?php echo $tr5 ?>"></i>
            </div>
            <div class="recherche-rdirection-button" id="display_position_<?php echo $i ?>">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="recherche-rdirection-button">
                <a href="https://maps.google.com/?q=<?php echo $get_professionnel_row['latitude_user'].','.$get_professionnel_row['longitude_user'] ?>"><i class="fas fa-directions"></i></a>
            </div>
            <div class="recherche-rdirection-button">
                <a href="utilisateur/<?php echo $get_professionnel_row['id_user'] ?>"><i class="far fa-user-circle"></i></a>
            </div>
        </div>
    </div>
    <div class="search-item-rsponsive">
        <h5><i class="fas fa-map-marker-alt" style="margin-left:2px"></i><?php echo $get_professionnel_row['ville_user'].', '.$get_professionnel_row['commune_user'] ?></h5>
        <p><i class="fas fa-briefcase"></i><?php echo $get_professionnel_row['categorie_user'].', '?><span><?php echo $get_professionnel_row['profession_user'] ?></span></p>
    </div>
    <input id="id_pos_<?php echo $i ?>" type="hidden" value="<?php echo $get_professionnel_row['id_user']; ?>">
    <input id="lat_pos_<?php echo $i ?>" type="hidden" value="<?php echo $get_professionnel_row['latitude_user']; ?>">
    <input id="lng_pos_<?php echo $i ?>" type="hidden" value="<?php echo $get_professionnel_row['longitude_user']; ?>">
    <input id="img_pos_<?php echo $i ?>" type="hidden" value="<?php echo $get_professionnel_row['img_user']; ?>">
    <input id="nom_pos_<?php echo $i ?>" type="hidden" value="<?php echo $get_professionnel_row['nom_user']; ?>">
    <input id="adrss_pos_<?php echo $i ?>" type="hidden" value="<?php echo $get_professionnel_row['adresse_user']; ?>">
</div>
<?php
            }
        }
        else{
            echo 0;
        }
    }
}
else if ($type_recherche == 'boutique') {
    if ($type_filter == 'text') {
        if ($text != '') {
            $get_boutique_query = $conn->prepare("SELECT * FROM boutiques WHERE type_user IS NOT NULL AND (nom_btq LIKE '%$text%' OR categorie_btq LIKE '%$text%' OR sous_categorie_btq LIKE '%$text%' OR description_btq LIKE '%$text%' OR ville_btq LIKE '%$text%' OR commune_btq LIKE '%$text%') ORDER BY id_btq DESC");
            if ($get_boutique_query->execute()) {
                $i = 0;
                while ($get_boutique_row = $get_boutique_query->fetch(PDO::FETCH_ASSOC)) {
                    $i++;
                    $user_total_rating_query = $conn->prepare("SELECT * FROM user_rating WHERE id_user = {$get_boutique_row['id_btq']}"); 
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
    <div class="search-item-left">
        <img src="<?php if($get_boutique_row['couverture_btq']==''){echo'./images/profile.png';}else{echo './'.$get_boutique_row['couverture_btq'];}?>" alt="">
    </div>
    <div class="search-item-right">
        <h4><?php echo $get_boutique_row['nom_btq'] ?></h4>
        <h5><i class="fas fa-map-marker-alt" style="margin-left:2px"></i><?php echo $get_boutique_row['ville_btq'].', '.$get_boutique_row['commune_btq'] ?></h5>
        <p><i class="fas fa-briefcase"></i><?php echo $get_boutique_row['categorie_btq'].', '?><span><?php echo $get_boutique_row['sous_categorie_btq'] ?></span></p>
        <div class="profile-position">
            <div class="item-notation">
                <i class="<?php echo $tr1 ?>"></i>
                <i class="<?php echo $tr2 ?>"></i>
                <i class="<?php echo $tr3 ?>"></i>
                <i class="<?php echo $tr4 ?>"></i>
                <i class="<?php echo $tr5 ?>"></i>
            </div>
            <div class="recherche-rdirection-button" id="display_position_<?php echo $i ?>">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="recherche-rdirection-button">
                <a href="https://maps.google.com/?q=<?php echo $get_boutique_row['latitude_btq'] ?>,<?php echo $get_boutique_row['longitude_btq'] ?>"><i class="fas fa-directions"></i></a>
            </div>
            <div class="recherche-rdirection-button">
                <a href="boutique/<?php echo $get_boutique_row['id_btq'] ?>"><i class="fas fa-store-alt"></i></a>
            </div>
        </div>
    </div>
    <div class="search-item-rsponsive">
        <h5><i class="fas fa-map-marker-alt" style="margin-left:2px"></i><?php echo $get_boutique_row['ville_btq'].', '.$get_boutique_row['commune_btq'] ?></h5>
        <p><i class="fas fa-briefcase"></i><?php echo $get_boutique_row['categorie_btq'].', '?><span><?php echo $get_boutique_row['sous_categorie_btq'] ?></span></p>
    </div>
    <input id="id_pos_<?php echo $i ?>" type="hidden" value="<?php echo $get_boutique_row['id_btq']; ?>">
    <input id="lat_pos_<?php echo $i ?>" type="hidden" value="<?php echo $get_boutique_row['latitude_btq']; ?>">
    <input id="lng_pos_<?php echo $i ?>" type="hidden" value="<?php echo $get_boutique_row['longitude_btq']; ?>">
    <input id="img_pos_<?php echo $i ?>" type="hidden" value="<?php echo $get_boutique_row['couverture_btq']; ?>">
    <input id="nom_pos_<?php echo $i ?>" type="hidden" value="<?php echo $get_boutique_row['nom_btq']; ?>">
    <input id="adrss_pos_<?php echo $i ?>" type="hidden" value="<?php echo $get_boutique_row['adresse_btq']; ?>">
</div>
<?php
                }
            }
            else{
                echo 0;
            }
        }
    }
    else if ($type_filter == 'filter') {
        if (!empty($categorie) || !empty($profession) || !empty($ville) || !empty($commune)) {
            $where_boutique = "WHERE type_user IS NOT NULL AND ";
            if(!empty($categorie)){
                $where_boutique .= "categorie_btq = '$categorie' AND ";
            }
            if(!empty($profession)){
                $where_boutique .= "sous_categorie_btq = '$profession' AND ";
            }
            if(!empty($ville)){
                $where_boutique .= "ville_btq = '$ville' AND ";
            }
            if(!empty($commune)){
                $where_boutique .= "commune_btq = '$commune' AND ";
            }
            $where_boutique .= "ORDER BY id_btq DESC";
            $word = "AND ORDER";
            if(strpos($where_boutique, $word) !== false){
                $where_boutique_final = str_replace($word,"ORDER",$where_boutique);
            } else {
                $where_boutique_final = $where_boutique;
            }
            $get_boutique_query = $conn->prepare("SELECT * FROM boutiques $where_boutique_final");
        }
        else{
            $get_boutique_query = $conn->prepare("SELECT * FROM boutiques WHERE type_user IS NOT NULL");
        }
        if ($get_boutique_query->execute()) {
            $i = 0;
            while ($get_boutique_row = $get_boutique_query->fetch(PDO::FETCH_ASSOC)) {
                $i++;
                $user_total_rating_query = $conn->prepare("SELECT * FROM user_rating WHERE id_user = {$get_boutique_row['id_btq']}"); 
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
    <div class="search-item-left">
        <img src="<?php if($get_boutique_row['couverture_btq']==''){echo'./images/profile.png';}else{echo './'.$get_boutique_row['couverture_btq'];}?>" alt="">
    </div>
    <div class="search-item-right">
        <h4><?php echo $get_boutique_row['nom_btq'] ?></h4>
        <h5><i class="fas fa-map-marker-alt" style="margin-left:2px"></i><?php echo $get_boutique_row['ville_btq'].', '.$get_boutique_row['commune_btq'] ?></h5>
        <p><i class="fas fa-briefcase"></i><?php echo $get_boutique_row['categorie_btq'].', '?><span><?php echo $get_boutique_row['sous_categorie_btq'] ?></span></p>
        <div class="profile-position">
            <div class="item-notation">
                <i class="<?php echo $tr1 ?>"></i>
                <i class="<?php echo $tr2 ?>"></i>
                <i class="<?php echo $tr3 ?>"></i>
                <i class="<?php echo $tr4 ?>"></i>
                <i class="<?php echo $tr5 ?>"></i>
            </div>
            <div class="recherche-rdirection-button" id="display_position_<?php echo $i ?>">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="recherche-rdirection-button">
                <a href="https://maps.google.com/?q=<?php echo $get_boutique_row['latitude_btq'] ?>,<?php echo $get_boutique_row['longitude_btq'] ?>"><i class="fas fa-directions"></i></a>
            </div>
            <div class="recherche-rdirection-button">
                <a href="boutique/<?php echo $get_boutique_row['id_btq'] ?>"><i class="fas fa-store-alt"></i></a>
            </div>
        </div>
    </div>
    <div class="search-item-rsponsive">
        <h5><i class="fas fa-map-marker-alt" style="margin-left:2px"></i><?php echo $get_boutique_row['ville_btq'].', '.$get_boutique_row['commune_btq'] ?></h5>
        <p><i class="fas fa-briefcase"></i><?php echo $get_boutique_row['categorie_btq'].', '?><span><?php echo $get_boutique_row['sous_categorie_btq'] ?></span></p>
    </div>
    <input id="id_pos_<?php echo $i ?>" type="hidden" value="<?php echo $get_boutique_row['id_btq']; ?>">
    <input id="lat_pos_<?php echo $i ?>" type="hidden" value="<?php echo $get_boutique_row['latitude_btq']; ?>">
    <input id="lng_pos_<?php echo $i ?>" type="hidden" value="<?php echo $get_boutique_row['longitude_btq']; ?>">
    <input id="img_pos_<?php echo $i ?>" type="hidden" value="<?php echo $get_boutique_row['couverture_btq']; ?>">
    <input id="nom_pos_<?php echo $i ?>" type="hidden" value="<?php echo $get_boutique_row['nom_btq']; ?>">
    <input id="adrss_pos_<?php echo $i ?>" type="hidden" value="<?php echo $get_boutique_row['adresse_btq']; ?>">
</div>
<?php
            }
        }
        else{
            echo 0;
        }
    }
}
else if ($type_recherche == 'produit') {
    $get_product_query = $conn->prepare("SELECT nom_prd,prix_prd,media_url FROM produit_boutique,produits_media WHERE produit_boutique.id_prd = produits_media.id_prd AND (nom_prd LIKE '%$text%' OR description_prd LIKE '%$text%' OR categorie_prd LIKE '%$text%') AND id_prd_m IN (SELECT MIN(id_prd_m) FROM produits_media GROUP BY id_prd)");
    if ($get_product_query->execute()) {
?>
<div class="all-search-boutique-product">
    <?php 
    while ($get_product_row = $get_product_query->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <div class="product-overview" style="width:140px">
        <img class="product-overview-image" src="<?php if($get_product_row['media_url']==''){echo'./images/logo.png';}else{echo './'.$get_product_row['media_url'];}?>" alt="logo">
        <div>
            <h4><?php echo $get_product_row['prix_prd'] ?> <span>.Da</span></h4>
        </div>
    </div>
    <?php } ?>
</div>
<?php
    }
    else {
        echo 0;
    }
}
else if ($type_recherche == 'promotion') {
    echo 'promotion';
}
else if ($type_recherche == 'evenement') {
    echo 'evenement';
}
?>