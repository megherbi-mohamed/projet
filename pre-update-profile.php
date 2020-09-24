<?php 
session_start();
include_once './bdd/connexion.php';

$nom_user = htmlspecialchars($_POST['nom_user']);
$nom_entrp_user = htmlspecialchars($_POST['nom_entrp_user']);
$tlph_user = htmlspecialchars($_POST['tlph_user']);
$email_user = htmlspecialchars($_POST['email_user']);
$adresse_user = htmlspecialchars($_POST['adresse_user']);
$ville_user = htmlspecialchars($_POST['ville_user']);
$categorie_user = htmlspecialchars($_POST['categorie_user']);
$profession_user = htmlspecialchars($_POST['profession_user']);

$updt_user_query = $conn->prepare('UPDATE utilisateurs SET nom_user="'."$nom_user".'" ,nom_entrp_user = "'."$nom_entrp_user".'" ,tlph_user="'."$tlph_user".'",email_user="'."$email_user".'",
adresse_user="'."$adresse_user".'",ville="'."$ville_user".'",categorie_user="'."$categorie_user".'",profession_user="'."$profession_user".'",
cnx_count = 1 WHERE id_user="'."{$_SESSION["user"]}".'"');

if($updt_user_query->execute()){

    $query = $conn->prepare("SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['user']);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);

    echo "
        <div id='user_informations'>
            <p>Profession : <span>".$row['profession_user']."</span></p>
            <p>Téléphone : <span>".$row['tlph_user']."</span></p>
            <p>Adresse : <span>".$row['adresse_user']."</span></p>
            <p>Ville : <span>".$row['ville']."</span></p>
        </div>
    ";
}else{
    echo 0;
}
?>