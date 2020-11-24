<?php
session_start();
include_once './bdd/connexion.php';
$id_evn = htmlspecialchars($_POST['id_evn']);
$delete_evenement_query = $conn->prepare("DELETE FROM evenements WHERE id_evn = $id_evn");
if ($delete_evenement_query->execute()) {
    $get_evenement_media_query = $conn->prepare("SELECT media_url FROM evenements_media WHERE id_evn = $id_evn");
    if ($get_evenement_media_query->execute()) {
        while ($get_evenement_media_row = $get_evenement_media_query->fetch(PDO::FETCH_ASSOC)) {
            unlink($get_evenement_media_row['media_url']);
        }
        $delete_evenement_media_query = $conn->prepare("DELETE FROM evenements_media WHERE id_evn = $id_evn");
        if ($delete_evenement_media_query->execute()) {
            echo 1;
        }
        else{
            echo 0;
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