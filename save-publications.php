<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_idSender_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_idSender_query->execute();
$get_session_idSender_row = $get_session_idSender_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_idSender_row['id_user'];
$id_pub = htmlspecialchars($_POST['id_pub']);
$save_publication_query = $conn->prepare("INSERT INTO publications_enregistres (id_pub,id_user) VALUES (:id_pub,:id_user)");
$save_publication_query->bindParam(':id_pub', $id_pub);
$save_publication_query->bindParam(':id_user',$id_user);
if ($save_publication_query->execute()) {
    echo 1;
}
else{
    echo 0;
}
?>