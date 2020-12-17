<?php
include_once './bdd/connexion.php';
$type_filter = htmlspecialchars($_POST['type_filter']);
$text = htmlspecialchars($_POST['text']);
$categorie_prd = htmlspecialchars($_POST['categorie_prd']);
$debut_prd = htmlspecialchars($_POST['date_debut_prd']);
$fin_prd = htmlspecialchars($_POST['date_fin_prd']);
$ville_prd = htmlspecialchars($_POST['ville_prd']);
$commune_prd = htmlspecialchars($_POST['commune_prd']);
if ($type_filter == 'today') {
    if(!empty($debut_prd)){
        $date_debut_prd = date("Y-m-d", strtotime($debut_prd));
        $get_product_query = $conn->prepare("SELECT * FROM produit_boutdechantier WHERE DATE(date) = '$date_debut_prd' ORDER BY date DESC");
    }
    else{
        echo 0;
    }
}
else if ($type_filter == 'week') {
    if(!empty($debut_prd) && !empty($fin_prd)){
        $date_debut_prd = date("Y-m-d", strtotime($debut_prd));
        $date_fin_prd = date("Y-m-d", strtotime($fin_prd));
        $get_product_query = $conn->prepare("SELECT * FROM produit_boutdechantier WHERE (DATE(date) BETWEEN '$date_debut_prd' AND '$date_fin_prd') ORDER BY date DESC");
    }
    else{
        echo 0;
    }
}
else if ($type_filter == 'month') {
    if(!empty($debut_prd) && !empty($fin_prd)){
        $date_debut_prd = date("Y-m-d", strtotime($debut_prd));
        $date_fin_prd = date("Y-m-d", strtotime($fin_prd));
        $get_product_query = $conn->prepare("SELECT * FROM produit_boutdechantier WHERE (DATE(date) BETWEEN '$date_debut_prd' AND '$date_fin_prd') ORDER BY date DESC");
    }
    else{
        echo 0;
    }
}
else if ($type_filter == 'text') {
    $get_product_query = $conn->prepare("SELECT * FROM produit_boutdechantier WHERE nom_prd LIKE '%$text%' OR description_prd LIKE '%$text%' OR categorie_prd LIKE '%$text%' OR ville_prd LIKE '%$text%' OR commune_prd LIKE '%$text%' ORDER BY date DESC");
}
else if ($type_filter == 'filter') {
    if (!empty($categorie_prd) || !empty($ville_prd) || !empty($commune_prd)) {
        $where = "WHERE ";
        if(!empty($categorie_prd)){
            $where .= "categorie_prd = '$categorie_prd' AND ";
        }
        if(!empty($ville_prd)){
            $where .= "ville_prd = '$ville_prd' AND ";
        }
        if(!empty($commune_prd)){
            $where .= "commune_prd = '$commune_prd' AND ";
        }
        $where .= "ORDER BY date DESC";
        $word = "AND ORDER";
        if(strpos($where, $word) !== false){
            $where_final = str_replace($word,"ORDER",$where);
        } else {
            $where_final = $where;
        }
        $get_product_query = $conn->prepare("SELECT * FROM produit_boutdechantier $where_final");
    }
    else{
        $get_product_query = $conn->prepare("SELECT * FROM produit_boutdechantier ORDER BY date DESC");
    }
}
if ($get_product_query->execute()){
    if ($get_product_query->rowCount() > 0) {
?>
<div class="boutdechantier-right-bottom">
<?php
        $i = 0;
        while ($get_product_row = $get_product_query->fetch(PDO::FETCH_ASSOC)) {
        $i++;
        $get_product_media_query = $conn->prepare("SELECT * FROM bt_produits_media WHERE id_prd = '{$get_product_row['id_prd']}' LIMIT 1");
        $get_product_media_query->execute();
        $get_product_media_row = $get_product_media_query->fetch(PDO::FETCH_ASSOC);
?>
<div class="bt-product">
    <div class="bt-product-img">
        <img src="<?php echo $get_product_media_row['media_url'] ?>" alt="">
    </div>
    <div class="bt-product-description">
        <p><?php echo $get_product_row['commune_prd'] ?></p>
        <h4><?Php echo $get_product_row['prix_prd'].' DA' ?></h4>
    </div>
</div>
<?php
        }
?>
</div>
<?php
    }
    else{
?>
<div class="empty-prm">
    <p>Aucun produit</p>
</div>
<?php
    }
}
else{
    echo 0;
}
?>