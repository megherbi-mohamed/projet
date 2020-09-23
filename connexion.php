<?php 
session_start();
include_once './bdd/connexion.php';

$email_user = htmlspecialchars($_POST['email_user']);
$mtp_user = htmlspecialchars($_POST['mtp_user']);
$hash_mtp_user = hash('sha256', $mtp_user);

if (filter_var($email_user, FILTER_VALIDATE_EMAIL)) {
    $cnnx_user_query = $conn->prepare("SELECT * FROM utilisateurs WHERE email_user = '$email_user' AND mtp_user = '$hash_mtp_user'");
    $incrm_cnx_query = $conn->prepare("UPDATE utilisateurs SET cnx_count = cnx_count+1 WHERE email_user = '$email_user' AND mtp_user = '$hash_mtp_user'");
    $incrm_cnx_query->execute();
}
else{
    $cnnx_user_query = $conn->prepare("SELECT * FROM utilisateurs WHERE tlph_user = '$email_user' AND mtp_user = '$hash_mtp_user'");
    $incrm_cnx_query = $conn->prepare("UPDATE utilisateurs SET cnx_count = cnx_count+1 WHERE email_user = '$email_user' AND mtp_user = '$hash_mtp_user'");
    $incrm_cnx_query->execute();
}
$cnnx_user_query->execute();
$count = $cnnx_user_query->rowCount();
$row = $cnnx_user_query->fetch(PDO::FETCH_ASSOC);

if ($count == 1) {
    $_SESSION['user'] = $row['id_user'];
    echo $_SESSION['user'];
}
else{
    echo 0;
}
?>