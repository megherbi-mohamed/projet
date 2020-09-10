<?php 
session_start();
include_once './bdd/connexion.php';

$id_btq = htmlspecialchars($_POST['id_btq']);
$nom_btq = htmlspecialchars($_POST['nom_btq']);
$email_btq = htmlspecialchars($_POST['email_btq']);
$tlph_btq = htmlspecialchars($_POST['tlph_btq']);
$adresse_btq = htmlspecialchars($_POST['adresse_btq']);
$ville_btq = htmlspecialchars($_POST['ville_btq']);

$query = "SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['user'];
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

$updt_btq_query = "UPDATE boutiques SET nom_btq='$nom_btq',email_btq='$email_btq',tlph_btq='$tlph_btq',
adresse_btq='$adresse_btq',ville_btq='$ville_btq' WHERE id_btq= '$id_btq'";
if(mysqli_query($conn, $updt_btq_query)){

    $btq_inf_query = "SELECT * FROM boutiques WHERE id_btq = '$id_btq'";
    $btq_inf_result = mysqli_query($conn, $btq_inf_query);
    $btq_inf_row = mysqli_fetch_assoc($btq_inf_result);

    echo "
    <div class='boutique-information-top'>
        <div id='modify_btq_inf'>
        <i class='fas fa-pen'></i>
        </div>
        <h3>".$btq_inf_row['nom_btq']."</h3>
        <div>
            <p>Creer par</p>
            <img src='".$row['img_user']."' alt=''>
        </div>
        <p><span>Email : </span>".$btq_inf_row['email_btq']."</p>
        <p><span>N° télph : </span>".$btq_inf_row['tlph_btq']."</p>
        <p><span>Addresse : </span>".$btq_inf_row['adresse_btq']."</p>
        <p><span>Ville : </span>".$btq_inf_row['ville_btq']."</p>
        <p><span>Pays : </span>Algérie</p>
    </div>
    ";
}else{
    echo 0;
}
// header('location:'.$_SERVER['REQUEST_URI']);

?>