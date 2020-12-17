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
$nom_prd = htmlspecialchars($_POST['nom_prd']);
$reference_prd = htmlspecialchars($_POST['reference_prd']);
$categorie_prd = htmlspecialchars($_POST['categorie_prd']);
$description_prd = htmlspecialchars($_POST['description_prd']);
$caracteristique_prd = htmlspecialchars($_POST['caracteristique_prd']);
$fonctionnalite_prd = htmlspecialchars($_POST['fonctionnalite_prd']);
$avantage_prd = htmlspecialchars($_POST['avantage_prd']);
$quantite_prd = htmlspecialchars($_POST['quantite_prd']);
$prix_prd = htmlspecialchars($_POST['prix_prd']);
$message_ntf = 'a ajoutée un nouveau produit';
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
quantite_prd = '$quantite_prd', prix_prd = '$prix_prd', etat = 0 WHERE id_prd = $id_prd AND id_btq = $id_btq");
if ($create_product_query->execute() && $notification_query->execute()) {
    $get_product_media_query = $conn->prepare("SELECT * FROM produits_media WHERE id_prd = $id_prd");
    if($get_product_media_query->execute()) {
        while($get_product_media_row = $get_product_media_query->fetch(PDO::FETCH_ASSOC)){
            if ($get_product_media_row['etat'] == 1 && $get_product_media_row['etat_updt'] == 1) {
                $id_prd_m = $get_product_media_row['id_prd_m'];
                $delete_prd_media_query = $conn->prepare("DELETE FROM produits_media WHERE id_prd = $id_prd AND id_prd_m = $id_prd_m");
                if ($delete_prd_media_query->execute() && unlink($get_product_media_row['media_url'])) {
                    echo 1;
                }
                else{
                    echo 0;
                    break;
                }
            }
            else if ($get_product_media_row['etat'] == 1 && $get_product_media_row['etat_updt'] == 0) {
                $id_prd_m = $get_product_media_row['id_prd_m'];
                $update_prd_media_query = $conn->prepare("UPDATE produits_media SET etat = 0,etat_updt = 0 WHERE id_prd = $id_prd AND id_prd_m = $id_prd_m");
                if ($update_prd_media_query->execute()) {
                    echo 1;
                }
                else{
                    echo 0;
                    break;
                }
            }
            else{
                echo 1;
            }
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