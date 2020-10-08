<?php
include_once './bdd/connexion.php';
$get_matricule_query = $conn->prepare("SELECT matricule_adm FROM admin_boutique");
$get_matricule_query->execute();
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
if ($get_matricule_query->rowCount() > 0) {
    while ($get_matricule_row = $get_matricule_query->fetch(PDO::FETCH_ASSOC)) {
        if ($get_matricule_row['matricule_adm'] == generateRandomString()) {
            generateRandomString();
        }else{
            echo generateRandomString();
        }
    }
}
else{
    echo generateRandomString();
}

?>