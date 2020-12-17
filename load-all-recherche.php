<?php
include_once './bdd/connexion.php';
$get_professionnel_query = $conn->prepare("SELECT id_user,nom_entrp_user,img_user,couverture_user,categorie_user,profession_user FROM utilisateurs WHERE type_user = 'professionnel' ORDER BY id_user DESC LIMIT 6");
$get_boutique_query = $conn->prepare("SELECT id_btq,nom_btq,logo_btq,couverture_btq,categorie_btq,sous_categorie_btq FROM boutiques WHERE type_user IS NOT NULL ORDER BY id_btq DESC LIMIT 4");
$get_product_query = $conn->prepare("SELECT nom_prd,prix_prd,media_url FROM produit_boutique,produits_media WHERE produit_boutique.id_prd = produits_media.id_prd LIMIT 8");
$get_boutdechantier_query = $conn->prepare("SELECT nom_prd,prix_prd,media_url FROM produit_boutdechantier,bt_produits_media WHERE produit_boutdechantier.id_prd = bt_produits_media.id_prd LIMIT 8");
if ($get_professionnel_query->execute() && $get_boutique_query->execute() && $get_product_query->execute() && $get_boutdechantier_query->execute()) {
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
        while ($get_professionnel_row = $get_professionnel_query->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <div class="professionnel-overview">
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
        while ($get_boutique_row = $get_boutique_query->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <div class="boutique-overview">
            <img class="boutique-overview-couverture" src="<?php if($get_boutique_row['couverture_btq']==''){echo'./images/logo.png';}else{echo './'.$get_boutique_row['couverture_btq'];}?>" alt="logo">
            <img class="boutique-overview-logo" src="<?php if($get_boutique_row['logo_btq']==''){echo'./images/logo.png';}else{echo './'.$get_boutique_row['logo_btq'];}?>" alt="logo">
            <div>
                <h4><?php echo $get_boutique_row['nom_btq'] ?></h4>
                <p><?php echo $get_boutique_row['categorie'].', '.$get_boutique_row['sous_categorie'] ?></p>
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
        while ($get_product_row = $get_product_query->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <div class="product-overview">
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
        <button id="show_all_product_result">Voir tout</button>
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
?>