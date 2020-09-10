<?php 
session_start();
include_once './bdd/connexion.php';
$_SESSION['user-info'] = $_GET['id_user'];
if (isset($_SESSION['user'])) {
    $cnx_user_query = "SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['user'];
    $result = mysqli_query($conn, $cnx_user_query);
    $row = mysqli_fetch_assoc($result);

    $msg_query = "SELECT * FROM messages WHERE id_msg IN ( SELECT MAX(id_msg) FROM messages WHERE id_recever = {$row['id_user']} GROUP BY id_sender) ORDER BY id_msg DESC";
    $msg_result = mysqli_query($conn,$msg_query);

    $num_msg_query = "SELECT * FROM messages WHERE id_recever = {$row['id_user']} AND etat_msg = 1 GROUP BY id_sender";    
    $num_msg_result = mysqli_query($conn,$num_msg_query);
    $num_message = 0;
    while ($num_msg_row = mysqli_fetch_assoc($num_msg_result)) {
        $num_message++;
    }
    $etat_message = '';
    if ($num_message > 0) {
        $etat_message = 'active-message-num';
    }else{ $etat_message = '';}

    if (isset($_POST['send_message'])) {

        $num_msg_query = "SELECT * FROM messages WHERE id_recever = {$row['id_user']} AND id_sender = {$_GET['id_user']}
                            OR id_recever = {$_GET['id_user']} AND id_sender = {$row['id_user']}";
        $num_msg_result = mysqli_query($conn,$num_msg_query);

        if (mysqli_num_rows($num_msg_result) == 0) {
            $time = date('H:i:s');
            $send_msg_suery = "INSERT INTO messages (id_sender,id_recever,message,temp_msg,etat_msg) VALUES ({$row['id_user']},{$_GET['id_user']},'Cc','$time',1)";
            mysqli_query($conn,$send_msg_suery);
            header('location: messagerie.php?user='.$_GET['id_user']);
        }
        else{
            header('location: messagerie.php?user='.$_GET['id_user']);
        }
    }
}
// else{ header("location: inscription-connexion.php"); }

$user_info_query = "SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['user-info'];
$user_info_rslt = mysqli_query($conn, $user_info_query);
$user_info_row = mysqli_fetch_assoc($user_info_rslt);

$etat_user = '';
$etat_line = '';

if ($user_info_row['etat_user'] == 'checked') {
    $etat_user = 'etat-online';
    $etat_line = 'disponible';
}else{
    $etat_user = 'etat-offline';
    $etat_line = 'indisponible';
}

if (isset($_SESSION['user']) && $_SESSION['user'] == $_SESSION['user-info']) {
    header('location: ./utilisateur.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css-js/style.css">
    <link rel="stylesheet" href="./css-js/utilisateur.css">
    <link href="./css-js/fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fugaz One">
    <title><?php echo $user_info_row['nom_user'] ?></title>
</head>
<body>
    <?php include './navbar.php';
    if (isset($_SESSION['user'])) { ?>
        <input type="hidden" id="session" value="1">
    <?php }else{ ?>
        <input type="hidden" id="session" value="0">
    <?php } ?>
    <div class="clear"></div>
    <div class="user-profile-container">
        <?php if ($user_info_row['type_user'] == 'professionnel') { 
            include './professionnel-info.php';
        } else if ($user_info_row['type_user'] == 'client'){ 
            include './client-info.php';
        } ?> 
    </div>
    <div id="loader" class="center"></div>
    <!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBEGrApnjX_7GHcNDtF0LR0pgrwxj5j2Q&callback=initUserMap"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="./css-js/main.js"></script>
    <script>
        document.onreadystatechange = function() { 
            if (document.readyState !== "complete") { 
                document.querySelector("body").style.visibility = "hidden"; 
                document.querySelector("#loader").style.visibility = "visible"; 
            } else { 
                document.querySelector("#loader").style.display = "none"; 
                document.querySelector("body").style.visibility = "visible"; 
            } 
        };

        var windowWidth = window.innerWidth;
        if (windowWidth <= 768) {
            if ($('#session').val() == 0) {
                $('.navbar').height(40);
                $('.clear').height(40);
            }
        }
        
        // var backUserButton = document.querySelector('#back_user_button');
        // backUserButton.addEventListener('click',()=>{
        //     window.history.back();
        // })

        var latitudeUser = document.querySelector('#latitude_user');
        var longitudeUser = document.querySelector('#longitude_user');
        function initUserMap() {
            var map = new google.maps.Map(document.getElementById('user_map'), {
                center: new google.maps.LatLng(latitudeUser.value, longitudeUser.value),
                zoom: 14
            });
            var marker = new google.maps.Marker({
                map: map,
                position: new google.maps.LatLng(latitudeUser.value, longitudeUser.value),
                icon : {
                    url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png"
                }
            });
        }

        // var userProfileContainer = document.querySelector('.user-profile-container');
        // userProfileContainer.addEventListener('click', ()=>{
        //     userListMessages.style.display = '';
        //     userListNotifications.style.display = '';
        // });

        $(".user-profile-left-content").mouseover(function(){
            $(this).removeClass('hide-scroll-bar');
        })

        $(".user-profile-left-content").mouseout(function(){
            $(this).addClass('hide-scroll-bar');
        })
        
    </script>
</body>
</html>