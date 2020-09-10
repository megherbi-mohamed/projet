<?php
session_start();
include_once './bdd/connexion.php';
$travailleRating = $_POST['travailleRating'];
$coutRating = $_POST['coutRating'];
$disciplineRating = $_POST['disciplineRating'];
$reputationRating = $_POST['reputationRating'];
$rapiditeRating = $_POST['rapiditeRating'];
$commentRating = $_POST['comment_rating'];
$idActivity = $_POST['id_activity'];
$idUserRat = $_POST['id_user_r'];
$idUser = $_SESSION['user'];
$id = $_POST['id'];
$date = date('Y-m-d');

$rating_activity_query = "UPDATE user_rating SET rapidite='$rapiditeRating',travaille='$travailleRating',discipline='$disciplineRating',cout='$coutRating',reputation='$reputationRating',commentaire='$commentRating',date='$date' WHERE id_user = '$idUserRat' AND id_activity = '$idActivity' AND id_user_r = '$idUser'";
$notification_query = "INSERT INTO notifications (id_sender_n,id_recever_n,id_activity,text_n,etat_n,date_n) VALUE ('$idUser','$idUserRat','$idActivity','Votre activité a été noté par votre offreur. Cliquer pour voire.',1,'$date')";

if(mysqli_query($conn, $rating_activity_query) && mysqli_query($conn, $notification_query)){
    $user_rating_query = "SELECT * FROM user_rating WHERE id_user = '$idUserRat' AND id_activity = '$idActivity' AND id_user_r = '$idUser'"; 
    $user_rating_result = mysqli_query($conn, $user_rating_query);
    $user_rating_row = mysqli_fetch_assoc($user_rating_result);
    $rapidite = $user_rating_row['rapidite'];
    $travaille = $user_rating_row['travaille'];
    $discipline = $user_rating_row['discipline'];
    $cout = $user_rating_row['cout'];
    $reputation = $user_rating_row['reputation'];
    
    $user_rating_details_query = "SELECT id_user,nom_user,img_user FROM utilisateurs WHERE id_user = {$user_rating_row['id_user']}"; 
    $user_rating_details_result = mysqli_query($conn, $user_rating_details_query);
    $user_rating_details_row = mysqli_fetch_assoc($user_rating_details_result);
    
    $cnx_user_query = "SELECT img_user FROM utilisateurs WHERE id_user=".$_SESSION['user'];
    $result = mysqli_query($conn, $cnx_user_query);
    $row = mysqli_fetch_assoc($result);

    $total_r = ($rapidite+$travaille+$discipline+$cout+$reputation)/5;
    $tr1 = 'far fa-star';$tr2 = 'far fa-star';$tr3 = 'far fa-star';$tr4 = 'far fa-star';$tr5 = 'far fa-star';
    if ($total_r >= 20) {$tr1 = 'fas fa-star';}
    if ($total_r >= 40) {$tr2 = 'fas fa-star';}
    if ($total_r >= 60) {$tr3 = 'fas fa-star';}
    if ($total_r >= 80) {$tr4 = 'fas fa-star';}
    if ($total_r == 100) {$tr5 = 'fas fa-star';}

    $t1 = 'far fa-star';$t2 = 'far fa-star';$t3 = 'far fa-star';$t4 = 'far fa-star';$t5 = 'far fa-star';
    if ($travaille >= 20) {$t1 = 'fas fa-star';}
    if ($travaille >= 40) {$t2 = 'fas fa-star';}
    if ($travaille >= 60) {$t3 = 'fas fa-star';}
    if ($travaille >= 80) {$t4 = 'fas fa-star';}
    if ($travaille == 100) {$t5 = 'fas fa-star';}

    $r1 = 'far fa-star';$r2 = 'far fa-star';$r3 = 'far fa-star';$r4 = 'far fa-star';$r5 = 'far fa-star';
    if ($rapidite >= 20) {$r1 = 'fas fa-star';}
    if ($rapidite >= 40) {$r2 = 'fas fa-star';}
    if ($rapidite >= 60) {$r3 = 'fas fa-star';}
    if ($rapidite >= 80) {$r4 = 'fas fa-star';}
    if ($rapidite == 100) {$r5 = 'fas fa-star';}

    $d1 = 'far fa-star';$d2 = 'far fa-star';$d3 = 'far fa-star';$d4 = 'far fa-star';$d5 = 'far fa-star';
    if ($discipline >= 20) {$d1 = 'fas fa-star';}
    if ($discipline >= 40) {$d2 = 'fas fa-star';}
    if ($discipline >= 60) {$d3 = 'fas fa-star';}
    if ($discipline >= 80) {$d4 = 'fas fa-star';}
    if ($discipline == 100) {$d5 = 'fas fa-star';}

    $c1 = 'far fa-star';$c2 = 'far fa-star';$c3 = 'far fa-star';$c4 = 'far fa-star';$c5 = 'far fa-star';
    if ($cout >= 20) {$c1 = 'fas fa-star';}
    if ($cout >= 40) {$c2 = 'fas fa-star';}
    if ($cout >= 60) {$c3 = 'fas fa-star';}
    if ($cout >= 80) {$c4 = 'fas fa-star';}
    if ($cout == 100) {$c5 = 'fas fa-star';}

    $rp1 = 'far fa-star';$rp2 = 'far fa-star';$rp3 = 'far fa-star';$rp4 = 'far fa-star';$rp5 = 'far fa-star';
    if ($reputation >= 20) {$rp1 = 'fas fa-star';}
    if ($reputation >= 40) {$rp2 = 'fas fa-star';}
    if ($reputation >= 60) {$rp3 = 'fas fa-star';}
    if ($reputation >= 80) {$rp4 = 'fas fa-star';}
    if ($reputation == 100) {$rp5 = 'fas fa-star';}

    $displayComment = '';
    if ($commentRating == '') {
        $displayComment = 'display:none';
    }

    echo "
        <div class=user-activite-rating' style='background:#ffffff'>
            <div class='activite-rating-top'>
                <p>Par <a href='./utilisateur-info.php?id_user=".$user_rating_details_row['id_user']."'>".$user_rating_details_row['nom_user']."</a> noté </p>
                <div class='activite-rating'>
                    <i class='$tr1'></i>
                    <i class='$tr2'></i>
                    <i class='$tr3'></i>
                    <i class='$tr4'></i>
                    <i class='$tr5'></i>
                </div>
                <p id='show_rating_details_$id'>Voir plus</p>
            </div>
            <div class='activite-rating-bottom' id='activite_rating_bottom_$id'>
                <div class='travaille-note'>
                    <p>Qualité du travaille</p>
                    <div class='activite-rating-note'>
                        <i class='far fa-star $t1'></i>
                        <i class='far fa-star $t2'></i>
                        <i class='far fa-star $t3'></i>
                        <i class='far fa-star $t4'></i>
                        <i class='far fa-star $t5'></i>
                    </div>
                </div>
                <div class='travaille-note'>
                    <p>Rapidité du travaille</p>
                    <div class='activite-rating-note'>
                        <i class='far fa-star $r1'></i>
                        <i class='far fa-star $r2'></i>
                        <i class='far fa-star $r3'></i>
                        <i class='far fa-star $r4'></i>
                        <i class='far fa-star $r5'></i>
                    </div>
                </div>
                <div class='travaille-note'>
                    <p>Discipline</p>
                    <div class='activite-rating-note'>
                        <i class='far fa-star $d1'></i>
                        <i class='far fa-star $d2'></i>
                        <i class='far fa-star $d3'></i>
                        <i class='far fa-star $d4'></i>
                        <i class='far fa-star $d5'></i>
                    </div>
                </div>
                <div class='travaille-note'>
                    <p>Cout</p>
                    <div class='activite-rating-note'>
                        <i class='far fa-star $c1'></i>
                        <i class='far fa-star $c2'></i>
                        <i class='far fa-star $c3'></i>
                        <i class='far fa-star $c4'></i>
                        <i class='far fa-star $c5'></i>
                    </div>
                </div>
                <div class='travaille-note'>
                    <p>Reputation</p>
                    <div class='activite-rating-note'>
                        <i class='far fa-star $rp1'></i>
                        <i class='far fa-star $rp2'></i>
                        <i class='far fa-star $rp3'></i>
                        <i class='far fa-star $rp4'></i>
                        <i class='far fa-star $rp5'></i>
                    </div>
                </div>
                <div class='rating-commentaire' style='$displayComment'>
                    <img src=./".$row['img_user']." alt=''>
                    <p>".$user_rating_row['commentaire']."</p>
                </div>
            </div>
        </div>
        ";
}
else{
    echo 0;
}