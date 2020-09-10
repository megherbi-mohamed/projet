<?php
session_start();
include_once './bdd/connexion.php';

$cnx_user_query = "SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['user'];
$result = mysqli_query($conn, $cnx_user_query);
$row = mysqli_fetch_assoc($result);

$profession = $row['profession_user'];
$sexe = $row['sexe_user'];

$titre = $_POST['titre_d'];
$ville = $_POST['ville_d'];
$salaire = $_POST['salaire_d'];
$competence_1= $_POST['competence_1'];
$competence_2= $_POST['competence_2'];
$competence_3= $_POST['competence_3'];
$competence_4= $_POST['competence_4'];
$travaille_1= $_POST['travaille_1'];
$travaille_2= $_POST['travaille_2'];
$travaille_3= $_POST['travaille_3'];
$travaille_4= $_POST['travaille_4'];
$date = date('y-m-d');

$insrt_demande_query = "INSERT INTO recrutements (type,id_user,titre,profession,sexe,ville,salaire,mission_1,mission_2,mission_3,mission_4,qualite_1,qualite_2,qualite_3,qualite_4,date) 
                                VALUE ('demande',{$_SESSION['user']},'$titre','$profession','$sexe','$ville','$salaire','$competence_1','$competence_2','$competence_3','$competence_4','$travaille_1','$travaille_2','$travaille_3','$travaille_4','$date')";
if(mysqli_query($conn,$insrt_demande_query)){
    $last_demande_query = "SELECT id_recrtm FROM recrutements WHERE id_recrtm IN (SELECT max(id_recrtm) FROM recrutements WHERE id_user = {$_SESSION['user']})";    
    $last_demande_result = mysqli_query($conn,$last_demande_query);
    $last_demande_row = mysqli_fetch_assoc($last_demande_result);
    echo $last_demande_row['id_recrtm'];
}
else{
    echo 0;
}
?>