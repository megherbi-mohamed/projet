<?php 
session_start();
include_once './bdd/connexion.php';
$matricule_adm = htmlspecialchars($_POST['matricule_adm']);
$mtp_adm = htmlspecialchars($_POST['mtp_adm']);
$hash_mtp_adm = hash('sha256', $mtp_adm);

$cnx_admin_btq_query = "SELECT * FROM admin_boutique";
$cnx_admin_btq_result = mysqli_query($conn, $cnx_admin_btq_query);
$cnx_admin_btq_count = mysqli_num_rows($cnx_admin_btq_result);
$cnx_admin_btq_row = mysqli_fetch_assoc($cnx_admin_btq_result);

// if ($cnx_admin_btq_count > 1) {
    if ($matricule_adm  !== $cnx_admin_btq_row['matricule_adm']) {
        echo 1;
    }
    else if ($hash_mtp_adm !== $cnx_admin_btq_row['mtp_adm'] && 
    $matricule_adm  == $cnx_admin_btq_row['matricule_adm']) {
        echo 2;
    }
    else if ($hash_mtp_adm == $cnx_admin_btq_row['mtp_adm'] && 
    $matricule_adm  == $cnx_admin_btq_row['matricule_adm']) {
        $_SESSION['btq'] = $cnx_admin_btq_row['id_btq'];
        echo $_SESSION['btq'];
    }
// }
else{
    echo 0;
}
?>