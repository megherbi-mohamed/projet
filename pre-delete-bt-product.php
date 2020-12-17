<?php
include_once './bdd/connexion.php';
$id_prd = htmlspecialchars($_POST['id_prd']);
$delete_prd_query = $conn->prepare("DELETE FROM produit_boutdechantier WHERE id_prd = $id_prd AND etat = 1");
if ($delete_prd_query->execute()) { 
    $get_bt_prd_media_query = $conn->prepare("SELECT * FROM bt_produits_media WHERE id_prd = $id_prd");
    if($get_bt_prd_media_query->execute()) {
        if ($get_bt_prd_media_query->rowCount() > 0) {
            while($get_bt_prd_media_row = $get_bt_prd_media_query->fetch(PDO::FETCH_ASSOC)){
                if ($get_bt_prd_media_row['etat'] == 1) {
                    $id_prd_m = $get_bt_prd_media_row['id_prd_m'];
                    $delete_prd_media_query = $conn->prepare("DELETE FROM bt_produits_media WHERE id_prd = $id_prd AND id_prd_m = $id_prd_m");
                    if ($delete_prd_media_query->execute() && unlink($get_bt_prd_media_row['media_url'])) {
                        echo 1;
                    }
                    else{
                        echo 0;
                        break;
                    }
                }
                else if ($get_bt_prd_media_row['etat'] == 0 && $get_bt_prd_media_row['etat_updt'] == 1) {
                    $id_prd_m = $get_bt_prd_media_row['id_prd_m'];
                    $update_prd_media_query = $conn->prepare("UPDATE bt_produits_media SET etat_updt = 0 WHERE id_prd = $id_prd AND id_prd_m = $id_prd_m");
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
            echo 1;
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