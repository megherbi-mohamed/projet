<?php
include_once './bdd/connexion.php';
$id_evn = htmlspecialchars($_POST['id_evn']);
$titre_evn = htmlspecialchars($_POST['titre_evn']);
$type_evn = htmlspecialchars($_POST['type_evn']);
$description_evn = htmlspecialchars($_POST['description_evn']);
$date_debut_evn = htmlspecialchars($_POST['date_debut_evn']);
$date_fin_evn = htmlspecialchars($_POST['date_fin_evn']);
$nombre_personne_evn = htmlspecialchars($_POST['nombre_personne_evn']);
$convier_amis_evn = htmlspecialchars($_POST['convier_amis_evn']);
$langue_evn = htmlspecialchars($_POST['langue_evn']);
$confidentialite_evn = htmlspecialchars($_POST['confidentialite_evn']);
$tarif_evn = htmlspecialchars($_POST['tarif_evn']);
$ville_evn = htmlspecialchars($_POST['ville_evn']);
$commune_evn = htmlspecialchars($_POST['commune_evn']);
$adresse_evn = htmlspecialchars($_POST['adresse_evn']);
$latitude_evn = htmlspecialchars($_POST['latitude_evn']);
$longitude_evn = htmlspecialchars($_POST['longitude_evn']);
$date_evn =  date("Y-m-d h:i:sa");
$create_evenement_query = $conn->prepare("UPDATE evenements SET titre_evn = '$titre_evn', type_evn = '$type_evn', description_evn = '$description_evn', 
date_debut_evn = '$date_debut_evn', date_fin_evn = '$date_fin_evn', nombre_personne_evn = '$nombre_personne_evn', convier_amis_evn = '$convier_amis_evn', 
langue_evn = '$langue_evn', confidentialite_evn = '$confidentialite_evn', tarif_evn = '$tarif_evn', ville_evn = '$ville_evn', commune_evn = '$commune_evn', 
adresse_evn = '$adresse_evn', latitude_evn = '$latitude_evn', longitude_evn = '$longitude_evn', date_evn = '$date_evn', views_evn = 0, save_evn = 0, etat = 0 WHERE id_evn = $id_evn");
if ($create_evenement_query->execute()) {
    $get_evn_media_query = $conn->prepare("SELECT * FROM evenements_media WHERE id_evn = $id_evn");
    if($get_evn_media_query->execute()) {
        while($get_evn_media_row = $get_evn_media_query->fetch(PDO::FETCH_ASSOC)){
            if ($get_evn_media_row['etat'] == 1 && $get_evn_media_row['etat_updt'] == 1) {
                $id_evn_m = $get_evn_media_row['id_evn_m'];
                $delete_evn_media_query = $conn->prepare("DELETE FROM evenements_media WHERE id_evn = $id_evn AND id_evn_m = $id_evn_m");
                if ($delete_evn_media_query->execute() && unlink($get_evn_media_row['media_url'])) {
                    echo 1;
                }
                else{
                    echo 0;
                    break;
                }
            }
            else if ($get_evn_media_row['etat'] == 1 && $get_evn_media_row['etat_updt'] == 0) {
                $id_evn_m = $get_evn_media_row['id_evn_m'];
                $update_evn_media_query = $conn->prepare("UPDATE evenements_media SET etat = 0,etat_updt = 0 WHERE id_evn = $id_evn AND id_evn_m = $id_evn_m");
                if ($update_evn_media_query->execute()) {
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