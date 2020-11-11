<?php
session_start();
include_once './bdd/connexion.php';
if (!empty($_SESSION['user'])) {
    $id_session = htmlspecialchars($_SESSION['user']);
    $get_session_id_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
    $get_session_id_query->execute();
    $get_session_id_row = $get_session_id_query->fetch(PDO::FETCH_ASSOC);
    $user_session_query = $conn->prepare("SELECT * FROM utilisateurs WHERE id_user = {$get_session_id_row['id_user']}");
    $user_session_query->execute();
    if ($user_session_query->rowCount() > 0) {
        $row = $user_session_query->fetch(PDO::FETCH_ASSOC);
        $uid = $id_session;
        $id_user = $row['id_user'];
    }
    else{
        header('Location: inscription-connexion.php');
    }
    if (!empty($_GET['user'])) {
        $id_sender = $_GET['user'];
        $get_sender_msg_query = $conn->prepare("SELECT id_recever,id_sender,message,date_format(temp_msg,'%H:%i') as temp_msg FROM messages WHERE 
        id_recever = '$id_user' AND id_sender = '$id_sender' OR id_recever = '$id_sender' AND id_sender = '$id_user'");
        $get_sender_msg_query->execute();
        
        $get_last_sender_info_query = $conn->prepare("SELECT id_user AS id, nom_user AS nom, img_user AS img FROM utilisateurs WHERE id_user = $id_sender UNION SELECT id_btq AS id, nom_btq AS nom, logo_btq AS img FROM boutiques WHERE id_btq = $id_sender");
        $get_last_sender_info_query->execute();
        $get_last_sender_info_row = $get_last_sender_info_query->fetch(PDO::FETCH_ASSOC);
    }
}
else{header('location : insecription-connexion.php');}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/projet/"/>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <link rel="stylesheet" href="./css-js/style.css">
    <link rel="stylesheet" href="./css-js/messagerie.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fugaz One">
    <link href="./css-js/fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet">
    <title>Messagerie</title>
</head>
<body>
    <?php include './navbar.php' ?>
    <div class="clear"></div>
    <div class="messagerie-container">
        <div class="messagerie-left">
            <div class="messageire-left-top">
                <div id="back_messagerie_sender">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <h4>Messagerie</h4>
                <div></div>
            </div>
            <?php
            $get_msg_query = $conn->prepare("SELECT * FROM messages WHERE id_msg IN (SELECT MAX(id_msg) FROM messages WHERE id_recever = '$id_user' OR id_sender = '$id_user' GROUP BY msg_cle) ORDER BY id_msg DESC");
            $get_msg_query->execute();
            $i=0;
            while($get_msg_row = $get_msg_query->fetch(PDO::FETCH_ASSOC)){
            $i++;
            if ($get_msg_row['id_recever'] == $id_user) {
                $get_sender_info_query = $conn->prepare("SELECT id_user AS id, nom_user AS nom, img_user AS img FROM utilisateurs WHERE id_user = {$get_msg_row['id_sender']} 
                                    UNION SELECT id_btq AS id, nom_btq AS nom, logo_btq AS img FROM boutiques WHERE id_btq = {$get_msg_row['id_sender']}");
                $get_sender_info_query->execute();
                $get_sender_info_row = $get_sender_info_query->fetch(PDO::FETCH_ASSOC);
            }
            else if ($get_msg_row['id_sender'] == $id_user) {
                $get_sender_info_query = $conn->prepare("SELECT id_user AS id, nom_user AS nom, img_user AS img FROM utilisateurs WHERE id_user = {$get_msg_row['id_recever']} 
                                    UNION SELECT id_btq AS id, nom_btq AS nom, logo_btq AS img FROM boutiques WHERE id_btq = {$get_msg_row['id_recever']}");
                $get_sender_info_query->execute();
                $get_sender_info_row = $get_sender_info_query->fetch(PDO::FETCH_ASSOC);
            }
            
            $last_msg_query = $conn->prepare("SELECT * FROM messages WHERE id_msg IN ( SELECT MAX(id_msg) FROM messages WHERE id_recever = '$id_user' AND id_sender = {$get_sender_info_row['id']}
                                OR id_recever = {$get_sender_info_row['id']} AND id_sender = '$id_user')");
            $last_msg_query->execute();
            $last_msg_row = $last_msg_query->fetch(PDO::FETCH_ASSOC);
            $new_msg = '';
            if ($last_msg_row['etat_recever_msg'] == $id_user || $last_msg_row['etat_sender_msg'] == $id_user) {
                $new_msg = 'style="background:#ecedee"';
            }
            ?>
            <input type="hidden" id="id_corresponder_<?php echo $i?>" value="<?php echo $get_sender_info_row['id'] ?>">
            <div <?php echo $new_msg; ?> class="messagerie-corresponder" id="messagerie_corresponder_<?php echo $i?>">
                <?php if ($get_sender_info_row['img'] == '') { ?>
                <img src="./images/profile.png" alt="">
                <?php }else{ ?>
                <img src="<?php echo $get_sender_info_row['img'] ?>" alt="">
                <?php } ?>
                <div class="messagerie-corresponder-message">
                    <h4><?php echo $get_sender_info_row['nom'] ?></h4>
                    <p><?php echo $last_msg_row['message']; ?></p>
                    <span><?php echo $last_msg_row['temp_msg'] ?></span>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="messagerie-middle">
            <div class="messagerie-middle-container">
                <div class="messagerie-middle-top">
                    <div id="display_list_chat_resp">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="corresponder-info">
                        <input type="hidden" id="id_corresponder" value="<?php echo $get_last_sender_info_row['id'] ?>">
                        <?php if ($get_last_sender_info_row['img'] == '') { ?>
                        <img src="./images/profile.png" alt="">
                        <?php }else{ ?>
                        <img src="<?php echo $get_last_sender_info_row['img'] ?>" alt="">
                        <?php } ?>
                        <h5><?php echo $get_last_sender_info_row['nom'] ?></h5>
                    </div>
                    <div id="display_corresponder_info">
                        <i class="fas fa-info"></i>
                    </div>
                </div>
                <div class="messagerie-middle-bottom" id="message_box">
                <?php
                while($get_sender_msg_row = $get_sender_msg_query->fetch(PDO::FETCH_ASSOC)){
                    if ($get_sender_msg_row['id_recever'] == $id_user) { ?>
                        <div class="message-right">
                            <div>
                                <p><?php echo $get_sender_msg_row['message'] ?></p>
                            </div>
                        </div>
                    <?php }else{ ?>
                        <div class="message-left">
                            <div>    
                                <p><?php echo $get_sender_msg_row['message'] ?></p>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
                </div>
                <div class="send-message-messagerie">
                    <input type="text" id="message_text" placeholder="Ecriver un message ..">
                    <div id="send_message_button">
                        <img src="./icons/send-message-icon.png" alt="">
                    </div>
                </div>
                <?php 
                $get_message_key_query = $conn->prepare("SELECT message_cle FROM messages_cles WHERE id_recever = $id_user AND id_sender = $id_sender OR id_recever = $id_sender AND id_sender = $id_user");
                $get_message_key_query->execute();
                $get_message_key_row = $get_message_key_query->fetch(PDO::FETCH_ASSOC);
                ?>
                <input type="hidden" id="msgCle" value="<?php echo $get_message_key_row['message_cle']; ?>">
                <?php
                $verify_user_query = $conn->prepare("SELECT id_user FROM utilisateurs WHERE id_user = $id_sender AND type_user != NULL");
                $verify_user_query->execute();
                if ($verify_user_query->rowCount() > 0) {
                ?>
                <input type="hidden" id="type_messagerie" value="userUser">
                <?php } else { ?>
                <input type="hidden" id="type_messagerie" value="boutiqueUser">
                <?php } ?>
                <input type="hidden" id="messagerie" value="messagerie">
            </div>
            <div id="loader_message" class="center-message"></div>
        </div>
        <div class="messagerie-right">
            <div class="messagerie-right-container">
            <div class="messageire-right-top">
                <div id="back_messagerie_info_sender">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <h4>User info</h4>
               <div></div>
            </div>

            </div>
            <div id="loader_sender_info" class="center-sender-info"></div>
        </div>
    </div>
    <div id="template_left_message" style="display:none">
        <div class="message-left">
            <div>
                <p>{message}</p>
            </div>
        </div>
    </div>
    <div id="template_right_message" style="display: none">
        <div class="message-right">
            <div>    
                <p>{message}</p>
            </div>
        </div>
    </div>
    <div id="loader" class="center"></div>
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
                setTimeout(() => {
                    scrolldiv();
                }, 100);
            } 
        };

        function scrolldiv() {
            $(".messagerie-middle-bottom").prop({
                scrollTop: $('.messagerie-middle-bottom').prop("scrollHeight")
            })
        }

        function updateSenderMessage(userId,senderId){
            var fd = new FormData();
            fd.append('id_user',userId);
            fd.append('id_sender',senderId);
            $.ajax({
                url: 'update-messagerie-sender.php',
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

        $(document).on('click','[id^="messagerie_corresponder_"]',function(){
            $(this).css('background','#ffffff');
            var id = $(this).attr('id').split('_')[2];
            var fd = new FormData();
            var idUser = <?php echo $id_user; ?>;
            fd.append('id_user',idUser);
            var idCrsp = $('#id_corresponder_'+id).val();
            fd.append('id_sender',idCrsp);
            $.ajax({
                url: 'load-messagerie-sender-messages.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".messagerie-middle-container").empty();
                    $("#loader_message").show();
                },
                success: function(response){
                    if(response != 0){
                        history.replaceState(null,'', '/projet/messagerie/'+idCrsp);
                        updateSenderMessage(idCrsp,idUser);
                        $('.user-new-msg').load('load-user-new-msg.php');
                        $('.messagerie-middle-container').append(response);
                        if (windowWidth <= 786) {
                            $('.messagerie-left').css('transform','');
                            setTimeout(() => {
                                $('.messagerie-middle').css('z-index','150');
                            }, 200);
                        }
                    }
                },
                complete: function(){
                    $("#loader_message").hide();
                    scrolldiv();
                }
            });
        })

        $(document).on('click','#display_list_chat_resp',function(){
            $('.messagerie-middle').css('z-index','10');
            $('.messagerie-left').css('transform','translateX(0)');
        })

        $(document).on('click','#display_corresponder_info',function(){
            $('.messagerie-middle').css('z-index','10');
            $('.messagerie-right').css('transform','translateX(0)');
        })

        $(document).on('click','#back_messagerie_sender',function(){
            setTimeout(() => {
                $('.messagerie-middle').css('z-index','150');
            }, 200);
            $('.messagerie-left').css('transform','');
        })

        $(document).on('click','#back_messagerie_info_sender',function(){
            setTimeout(() => {
                $('.messagerie-middle').css('z-index','150');
            }, 200);
            $('.messagerie-right').css('transform','');
        })
        // if (windowWidth <= 768) {
        //     $(document).on('focus','#message_text',function(){
        //         // $('.navbar-right').hide();
        //         $('.messagerie-middle-bottom').css('height','calc(100vh - 202px)');
        //     })

        //     $(document).on('click','.messagerie-middle-bottom',function(){
        //         setTimeout(() => {
        //             $('.navbar-right').show();
        //         }, 200);
        //         $('.messagerie-middle-bottom').css('height','');
        //     })
        // }
        
        var uid = <?php echo $uid; ?>;
        $(document).on('beforunload',function(){
            $('.messagerie-left').load('load-messagerie-sender.php?id_user='+uid);
        })
        var websocket_server = 'ws://<?php echo $_SERVER['HTTP_HOST']; ?>:3030?uid='+uid;
        var websocket = false;
        var js_flood = 0;
        var status_websocket = 0;
        $(document).ready(function() {
            start(websocket_server);
        });
    </script>
    <script src="css-js/websocket.js"></script>
</body>
</html>