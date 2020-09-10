<?php
include_once './bdd/connexion.php';
$get_matricule_query = "SELECT matricule_adm FROM admin_boutique";
$get_matricule_result = mysqli_query($conn,$get_matricule_query);
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
while ($get_matricule_row = mysqli_fetch_assoc($get_matricule_result)) {
    if ($get_matricule_row['matricule_adm'] == generateRandomString()) {
        generateRandomString();
    }else{
        echo generateRandomString();
    }
}

?>