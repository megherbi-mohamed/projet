<?php
include_once './bdd/connexion.php';
$id_pub = htmlspecialchars($_POST['id_pub']);
$delete_pub_query = $conn->prepare("DELETE FROM publications WHERE id_pub = $id_pub AND etat = 1");
if ($delete_pub_query->execute()) {
    $get_pub_media_query = $conn->prepare("SELECT * FROM publications_media WHERE id_pub = $id_pub");
    if($get_pub_media_query->execute()) {
        if ($get_pub_media_query->rowCount() > 0) {
            while($get_pub_media_row = $get_pub_media_query->fetch(PDO::FETCH_ASSOC)){
                if ($get_pub_media_row['etat'] == 1) {
                    $id_pub_m = $get_pub_media_row['id_pub_m'];
                    $delete_pub_media_query = $conn->prepare("DELETE FROM publications_media WHERE id_pub = $id_pub AND id_pub_m = $id_pub_m");
                    if ($delete_pub_media_query->execute() && unlink($get_pub_media_row['media_url'])) {
                        echo 1;
                    }
                    else{
                        echo 0;
                        break;
                    }
                }
                else if ($get_pub_media_row['etat'] == 0 && $get_pub_media_row['etat_updt'] == 1) {
                    $id_pub_m = $get_pub_media_row['id_pub_m'];
                    $update_pub_media_query = $conn->prepare("UPDATE publications_media SET etat_updt = 0 WHERE id_pub = $id_pub AND id_pub_m = $id_pub_m");
                    if ($update_pub_media_query->execute()) {
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