<?php
include_once './bdd/connexion.php';
$id_prd = htmlspecialchars($_POST['id_prd']);
$delete_prd_query = $conn->prepare("DELETE FROM produit_boutique WHERE id_prd = $id_prd AND etat = 1");
if ($delete_prd_query->execute()) { 
    $get_prd_media_query = $conn->prepare("SELECT * FROM produits_media WHERE id_prd = $id_prd");
    if($get_prd_media_query->execute()) {
        if ($get_prd_media_query->rowCount() > 0) {
            while($get_prd_media_row = $get_prd_media_query->fetch(PDO::FETCH_ASSOC)){
                if ($get_prd_media_row['etat'] == 1) {
                    $id_prd_m = $get_prd_media_row['id_prd_m'];
                    $delete_prd_media_query = $conn->prepare("DELETE FROM produits_media WHERE id_prd = $id_prd AND id_prd_m = $id_prd_m");
                    if ($delete_prd_media_query->execute() && unlink($get_prd_media_row['media_url'])) {
                        echo 1;
                    }
                    else{
                        echo 0;
                        break;
                    }
                }
                else if ($get_prd_media_row['etat'] == 0 && $get_prd_media_row['etat_updt'] == 1) {
                    $id_prd_m = $get_prd_media_row['id_prd_m'];
                    $update_prd_media_query = $conn->prepare("UPDATE produits_media SET etat_updt = 0 WHERE id_prd = $id_prd AND id_prd_m = $id_prd_m");
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