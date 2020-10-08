<?php 
session_start();
include_once './bdd/connexion.php';
$_SESSION['user-info'] = $_GET['id_user'];
if (isset($_SESSION['user'])) {
    $cnx_user_query = $conn->prepare("SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['user']);
    $cnx_user_query->execute();
    $row = $cnx_user_query->fetch(PDO::FETCH_ASSOC);
    $id_user = $row['id_user'];
}
// else{ header("location: inscription-connexion.php"); }
$user_info_query = $conn->prepare("SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['user-info']);
$user_info_query->execute();
$user_info_row = $user_info_query->fetch(PDO::FETCH_ASSOC);
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
    <input type="hidden" id="id_user" value="<?php echo $user_info_row['id_user'] ?>">
    <input type="hidden" id="id_corresponder" value="<?php echo $user_info_row['id_user'] ?>">
    <input type="hidden" id="type_msg" value="userUser">
    <input type="hidden" id="msg_cle" value="<?php echo $user_info_row['id_user'].$row['id_user'] ?>">
    <button id="send_message_button"></button>
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

        //utilisateur info
        $("#follow_button").click(function(e){
            $("body").addClass('body-after');
            if (windowWidth > 768) {
                $("#abonne_user").show();
            }else{
                $("#abonne_user").css('transform','translateY(0)');
            }
        })

        $('#ntf_user_btn').click(function(e){
            e.stopPropagation();
            var etat = $(this).find('i').attr('class');
            var etatBtn = $(this).find('i');
            if (etat == 'fas fa-check etat') {
                $('#notifications_user').val("0");
                etatBtn.replaceWith('<i class="fas fa-ban etat"></i>');
            }
            else{
                $('#notifications_user').val("1");
                etatBtn.replaceWith('<i class="fas fa-check etat"></i>');
            }
        })

        $('#cancel_abonne_user').click(function(e){
            e.stopPropagation();
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $("#abonne_user").hide();
            }else{
                $("#abonne_user").css('transform','');
            }
        });

        $('#cancel_abonne_user_button').click(function(e){
            e.stopPropagation();
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $("#abonne_user").hide();
            }else{
                $("#abonne_user").css('transform','');
            }
        });

        $('#abonne_user').click(function(e){
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $("#abonne_user").hide();
            }else{
                $("#abonne_user").css('transform','');
            }
        });

        $('#abonne_user_container').click(function(e){
            e.stopPropagation();
        });

        $('#abonne_user_button').click(function(e){
            var fd = new FormData();
            var idUser= $('#id_user').val();
            fd.append('id_user',idUser);
            var ntfUser = $('#notifications_user').val();
            fd.append('notifications_user',ntfUser);
            $.ajax({
                url: 'abonne-user.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $('#abonne_user').css('opacity','0.5');
                    $("#loader_abn_user").show();
                },
                success: function(response){
                    if(response != 0){
                        console.log(response);
                        $("#follow_button").replaceWith('<div id="disfollow_button"><p>Disabonner</p><i class="fas fa-user-slash"></i></div>');
                    }
                },
                complete: function(){
                    $('#abonne_user').css('opacity','');
                    $("#loader_abn_user").hide();
                    $("body").removeClass('body-after');
                    if (windowWidth > 768) {
                        $("#abonne_user").hide();
                    }else{
                        $("#abonne_user").css('transform','');
                    }
                }
            });
        });

        $("#disfollow_button").click(function(e){
            $("body").addClass('body-after');
            if (windowWidth > 768) {
                $("#disabonne_user").show();
            }else{
                $("#disabonne_user").css('transform','translateY(0)');
            }
        })

        $('#cancel_disabonne_user').click(function(e){
            e.stopPropagation();
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $("#disabonne_user").hide();
            }else{
                $("#disabonne_user").css('transform','');
            }
        });

        $('#cancel_disabonne_user_button').click(function(e){
            e.stopPropagation();
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $("#disabonne_user").hide();
            }else{
                $("#disabonne_user").css('transform','');
            }
        });

        $('#disabonne_user').click(function(e){
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $("#disabonne_user").hide();
            }else{
                $("#disabonne_user").css('transform','');
            }
        });

        $('#disabonne_user_container').click(function(e){
            e.stopPropagation();
        });

        $('#disabonne_user_button').click(function(e){
            var fd = new FormData();
            var idUser= $('#id_user').val();
            fd.append('id_user',idUser);
            $.ajax({
                url: 'disabonne-user.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $('#disabonne_user').css('opacity','0.5');
                    $("#loader_disabn_user").show();
                },
                success: function(response){
                    if(response != 0){
                        $("#disfollow_button").replaceWith('<div id="follow_button"><p>Abonner</p><i class="fas fa-user-plus"></i></div>');
                    }
                },
                complete: function(){
                    $('#disabonne_user').css('opacity','');
                    $("#loader_disabn_user").hide();
                    $("body").removeClass('body-after');
                    if (windowWidth > 768) {
                        $("#disabonne_user").hide();
                    }else{
                        $("#disabonne_user").css('transform','');
                    }
                }
            });
        });

        $(document).on('click',"#message_button",function() {
            $("body").addClass('body-after');
            if (windowWidth > 768) {
                $("#message_user").show();
            }else{
                $("#message_user").css('transform','translateY(0)');
            }
        })

        $('#cancel_message_user').click(function(e){
            e.stopPropagation();
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $("#message_user").hide();
            }else{
                $("#message_user").css('transform','');
            }
        });

        $('#cancel_message_user_button').click(function(e){
            e.stopPropagation();
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $("#message_user").hide();
            }else{
                $("#message_user").css('transform','');
            }
        });

        $('#message_user').click(function(e){
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $("#message_user").hide();
            }else{
                $("#message_user").css('transform','');
            }
        });

        $('#message_user_container').click(function(e){
            e.stopPropagation();
        });

        $('#message_user_button').click(function(e){
            var fd = new FormData();
            var idCrsp = $('#id_corresponder').val();
            fd.append('id_corresponder',idCrsp);
            var msgCle = $('#msg_cle').val();
            fd.append('msgCle',msgCle);
            $.ajax({
                url: 'send-message-user.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $('#message_user').css('opacity','0.5');
                    $("#loader_msg_user").show();
                },
                success: function(response){
                    if(response != 0){
                        $('#send_message_button').click();
                        if (response == 2) {
                            window.location = 'messagerie.php?user='+idCrsp;
                        }
                        else{
                            console.log(response);
                        }
                    }
                },
                complete: function(){
                    $('#message_user').css('opacity','');
                    $("#loader_msg_user").hide();
                    $("body").removeClass('body-after');
                    if (windowWidth > 768) {
                        $("#message_user").hide();
                    }else{
                        $("#message_user").css('transform','');
                    }
                }
            });
        });

        function updateReceverMessage(userId,senderId){
            var fd = new FormData();
            fd.append('id_user',userId);
            fd.append('id_sender',senderId);
            $.ajax({
                url: 'update-messagerie-recever.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response != 0){

                    }
                }
            });
        } 

        $(".user-profile-left-content").mouseover(function(){
            $(this).removeClass('hide-scroll-bar');
        })

        $(".user-profile-left-content").mouseout(function(){
            $(this).addClass('hide-scroll-bar');
        })

        // add new publications when scroll bottom
        var scrollBottom = 0;         
        $(window).on("scroll", function () {
            if (window.innerHeight + window.pageYOffset >= document.body.scrollHeight) {
                scrollBottom++;
                var fd = new FormData();
                fd.append('offset', scrollBottom);
                $.ajax({
                url: 'load-user-publications.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response != 0){
                        // console.log(response);
                        $('.user-profile-publications').append(response);
                    }else{
                        // alert('err');
                    }
                },
            });
            }
        });
        
        <?php if (isset($_SESSION['user'])) { ?>
        var uid = <?php echo $id_user; ?>;
        var websocket_server = 'ws://<?php echo $_SERVER['HTTP_HOST']; ?>:3030?uid='+uid;
        var websocket = false;
        var js_flood = 0;
        var status_websocket = 0;
        $(document).ready(function() {
            start(websocket_server);
        });
        <?php } ?>
    </script>
    <script src="css-js/websocket.js"></script>
</body>
</html>