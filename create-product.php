<?php 
session_start();
include_once './bdd/connexion.php';
$id_session_btq = htmlspecialchars($_POST['id_btq']);
$get_session_btq_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session_btq' OR id_user_1 = '$id_session_btq' OR id_user_2 = '$id_session_btq' 
                                            OR id_user_3 = '$id_session_btq' OR id_user_4 = '$id_session_btq' OR id_user_5 = '$id_session_btq'");
$get_session_btq_query->execute();
$get_session_btq_row = $get_session_btq_query->fetch(PDO::FETCH_ASSOC);
$id_btq = $get_session_btq_row['id_user'];
$id_prd = htmlspecialchars($_POST['id_prd']);
$nom_prd = htmlspecialchars($_POST['name_prd']);
$reference_prd = htmlspecialchars($_POST['reference_prd']);
$categorie_prd = htmlspecialchars($_POST['categorie_prd']);
$description_prd = htmlspecialchars($_POST['description_prd']);
$caracteristique_prd = htmlspecialchars($_POST['caracteristique_prd']);
$fonctionnalite_prd = htmlspecialchars($_POST['fonctionnalite_prd']);
$avantage_prd = htmlspecialchars($_POST['avantage_prd']);
$quantite_prd = htmlspecialchars($_POST['quantity_prd']);
$prix_prd = htmlspecialchars($_POST['price_prd']);

$message_ntf = 'a ajoutée une nouveau produit';
$date_ntf =  date("Y-m-d h:i:sa");
$type_ntf = 'produit';
$etat_ntf = 0;
$vu_ntf = ',';

$notification_query = $conn->prepare("INSERT INTO publications_notifications (id_pub,id_sender_ntf,id_recever_ntf,message_ntf,etat_ntf,vu_ntf,type_ntf,date_ntf) VALUES (:id_pub,:id_sender_ntf,:id_recever_ntf,:message_ntf,:etat_ntf,:vu_ntf,:type_ntf,:date_ntf)");
$notification_query->bindParam(':id_pub', $id_prd);
$notification_query->bindParam(':id_sender_ntf',$id_btq);
$notification_query->bindParam(':id_recever_ntf',$id_btq);
$notification_query->bindParam(':message_ntf',$message_ntf);
$notification_query->bindParam(':etat_ntf',$etat_ntf);
$notification_query->bindParam(':vu_ntf',$vu_ntf);
$notification_query->bindParam(':type_ntf',$type_ntf);
$notification_query->bindParam(':date_ntf',$date_ntf);

$create_product_query = $conn->prepare("UPDATE produit_boutique SET nom_prd = '$nom_prd', reference_prd = '$reference_prd', categorie_prd = '$categorie_prd',
description_prd = '$description_prd',caracteristique_prd = '$caracteristique_prd', fonctionnalite_prd = '$fonctionnalite_prd', avantage_prd = '$avantage_prd', 
quantite_prd = '$quantite_prd', prix_prd = '$prix_prd', etat = 0 WHERE id_prd = '$id_prd' AND id_btq = '$id_btq'");

if ($create_product_query->execute() && $notification_query->execute()) {
    $update_media_query = $conn->prepare("UPDATE produits_media SET etat = 0 WHERE id_prd = '$id_prd'");
    if ($update_media_query->execute()) {
        $get_product_query = $conn->prepare("SELECT * FROM produit_boutique WHERE id_prd = '$id_prd' AND id_btq = '$id_btq'");
        if ($get_product_query->execute()) {
            $get_product_row = $get_product_query->fetch(PDO::FETCH_ASSOC); 
            $get_product_media_query = $conn->prepare("SELECT * FROM produits_media WHERE id_prd = '$id_prd' LIMIT 1");
            if ($get_product_media_query->execute()) {
                $get_product_media_row = $get_product_media_query->fetch(PDO::FETCH_ASSOC);
                $get_prd_id_query = $conn->prepare("SELECT COUNT(id_prd) as `count` FROM produit_boutique WHERE id_btq = '$id_btq'");
                if ($get_prd_id_query->execute()) {
                    $get_prd_id_row = $get_prd_id_query->fetch(PDO::FETCH_ASSOC);
                    $id = $get_prd_id_row['count'];
?>

<input type="hidden" id="id_prd_<?php echo $id ?>" value="<?php echo $get_product_row['id_prd'] ?>">
<input type="hidden" id="product_tail_<?php echo $id ?>" value="<?php echo $id ?>">
<input type="hidden" id="name_prd_<?php echo $id ?>" value="<?php echo $get_product_row['nom_prd'] ?>">
<input type="hidden" id="reference_prd_<?php echo $id ?>" value="<?php echo $get_product_row['reference_prd'] ?>">
<input type="hidden" id="categorie_prd_<?php echo $id ?>" value="<?php echo $get_product_row['categorie_prd'] ?>">
<input type="hidden" id="description_prd_<?php echo $id ?>" value="<?php echo $get_product_row['description_prd'] ?>">
<input type="hidden" id="quantity_prd_<?php echo $id ?>" value="<?php echo $get_product_row['quantite_prd'] ?>">
<input type="hidden" id="price_prd_<?php echo $id ?>" value="<?php echo $get_product_row['prix_prd'] ?>">
<div class="boutique-product" id="boutique_product_<?php echo $id ?>">
    <div class="product-option-button" id="display_prd_options_button_<?php echo $id ?>">
        <i class="fas fa-ellipsis-v"></i>
    </div>
    <div class="product-options" id="product_options_<?php echo $id ?>">
        <div class="product-option" id="update_product_<?php echo $id ?>">
            <i class="fas fa-pen"></i>
            <div>
                <p>Modifer le produit</p>
            </div>
        </div>
        <div class="product-option" id="delete_product_<?php echo $id ?>">
            <i class="fas fa-trash"></i>
            <div>
                <p>Supprimer le produit</p>
            </div>
        </div>
    </div>
    <div class="boutique-product-img">
        <img src="<?php echo $get_product_media_row['media_url'] ?>" alt="">
    </div>
    <div class="product-description">
        <div class="product-description-top">
            <p><?php echo $get_product_row['description_prd'] ?></p>
        </div>
        <div class="product-description-bottom">
            <h4><?Php echo $get_product_row['prix_prd'].' DA' ?></h4>
        </div>
    </div>
</div>

<?php
                }else{
                    echo 0;
                }
            }else{
                echo 0;
            }
        }else{
            echo 0;
        }
    }else{
        echo 0;
    }
}
else{
    echo 0;
}
?>