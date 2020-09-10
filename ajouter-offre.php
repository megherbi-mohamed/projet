<?php
session_start();
include_once './bdd/connexion.php';

$titre = $_POST['titre'];
$profession = $_POST['profession'];
$sexe = $_POST['sexe'];
$ville = $_POST['ville'];
$salaire = $_POST['salaire'];
$date_expiration= $_POST['date_expiration'];
$mission_1= $_POST['mission_1'];
$mission_2= $_POST['mission_2'];
$mission_3= $_POST['mission_3'];
$mission_4= $_POST['mission_4'];
$qualite_1= $_POST['qualite_1'];
$qualite_2= $_POST['qualite_2'];
$qualite_3= $_POST['qualite_3'];
$qualite_4= $_POST['qualite_4'];
$date = date('y-m-d');

$insrt_offre_query = "INSERT INTO recrutements (type,id_user,titre,profession,sexe,ville,salaire,date_expiration,mission_1,mission_2,mission_3,mission_4,qualite_1,qualite_2,qualite_3,qualite_4,date,termine) 
                                VALUE ('offre',{$_SESSION['user']},'$titre','$profession','$sexe','$ville','$salaire','$date_expiration','$mission_1','$mission_2','$mission_3','$mission_4','$qualite_1','$qualite_2','$qualite_3','$qualite_4','$date',1)";

if(mysqli_query($conn,$insrt_offre_query)){
    $last_offre_query = "SELECT id_recrtm FROM recrutements WHERE id_recrtm IN (SELECT max(id_recrtm) FROM recrutements WHERE id_user = {$_SESSION['user']})";    
    $last_offre_result = mysqli_query($conn,$last_offre_query);
    $last_offre_row = mysqli_fetch_assoc($last_offre_result);
    echo $last_offre_row['id_recrtm'];

    $user_notification_query = "SELECT id_user FROM utilisateurs WHERE profession_user = '$profession' AND ville = '$ville' AND sexe_user='$sexe'";
    $user_notification_result = mysqli_query($conn,$user_notification_query);
    
    while ($user_notification_row = mysqli_fetch_assoc($user_notification_result)) {
        $send_user_notification_query = "INSERT INTO notifications (id_sender_n,id_recever_n,id_offre,text_n,etat_n,date_n) 
        VALUE ({$_SESSION['user']},{$user_notification_row['id_user']},{$last_offre_row['id_recrtm']},'Une offre pour vous a été ajouté. Cliquer pour voir l offre',1,'$date')";
        mysqli_query($conn,$send_user_notification_query);
    }
}
else{
    echo 0;
}
?>