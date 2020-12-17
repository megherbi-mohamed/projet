<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_user_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
if ($get_session_user_query->execute()) {
    $get_session_user_row = $get_session_user_query->fetch(PDO::FETCH_ASSOC);
    $id_user = $get_session_user_row['id_user'];
    $type_recherche = htmlspecialchars($_POST['type_recherche']);
    $delete_history_query = $conn->prepare("DELETE FROM recherche_historique WHERE id_user = $id_user AND type_rech = '$type_recherche'");
    if ($delete_history_query->execute()) {
        echo 1;
    }
    else{
        echo 0;
    }
}
else {
    echo 0;
}
