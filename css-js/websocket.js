// var websocket = false;
// var js_flood = 0;
// var status_websocket = 0;
// $(document).ready(function() {
//     start(websocket_server);
// });
function waitForSocketConnection(socket, callback){
    setTimeout(
        function () {
            if (socket.readyState === 1) {
                if(callback != null){
                    callback();
                }
                return;
            } else {
                waitForSocketConnection(socket, callback);
            }
        }, 
    5
    ); // wait 5 milisecond for the connection...
}
function start(websocketServerLocation){
    websocket = new WebSocket(websocketServerLocation);
    websocket.onopen = function(ev) {
        status_websocket = 1;
        console.log('open');
    };

    // message notification
    $(document).on('keypress','#message_text',function( event ) {
        if ( event.which == 13 || event.keyCode == 13 ) {
            var mymessage = $(this).val();
            if ( mymessage.length > 0 ) {
                if ( js_flood == 0 ) {
                    var typeNotification = 'message';
                    var to_id = $(document).find('#id_corresponder').val();
                    var msgCle = $(document).find('#msgCle').val();
                    var typeMessagerie = $(document).find('#type_messagerie').val();
					var msg = {
                        typeNotification: typeNotification,
						message: mymessage,
						uid: uid,
                        to_id: to_id,
                        msgCle: msgCle,
                        typeMessagerie: typeMessagerie
                    };
                    websocket.send(JSON.stringify(msg));
                    flood_js();
				} else {
					$('#message_text').val('');
                }
            }
            var obj = document.getElementById('message_text');
            obj.value = '';
            obj.focus();
        }
    });

    $(document).on('click','#send_message_button',function() {
        var mymessage = $('#message_text').val();
        if ( mymessage.length > 0 ) {
            if ( js_flood == 0 ) {
                var typeNotification = 'message';
                var to_id = $(document).find('#id_corresponder').val();
                var msgCle = $(document).find('#msg_cle').val();
                var typeMessagerie = $(document).find('#type_msg').val();
                var msg = {
                    typeNotification: typeNotification,
                    message: mymessage,
                    uid: uid,
                    to_id: to_id,
                    msgCle: msgCle,
                    typeMessagerie: typeMessagerie
                };
                websocket.send(JSON.stringify(msg));
                flood_js();
            } else {
                $('#message_text').val('');
            }
        }
        var obj = document.getElementById('message_text');
        obj.value = '';
        obj.focus();
    });

    $(document).on('click','[id^="like_pub_button_"]',function(){
        var id = $(this).attr("id").split("_")[3];
        var typeNotification = 'like';
        var fd = new FormData();
        var to_id = $(document).find('#id_user').val();
        fd.append('id_recever_ntf',to_id);
        var idPub = $(document).find('#id_pub_'+id).val();
        fd.append('id_pub',idPub);
        $.ajax({
            url: 'like-publication.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                console.log(response);
                if(response != 0){
                    var like = parseInt($('#user_publication_bottom_top_'+id).find('span').text());
                    $('#user_publication_bottom_top_'+id).find('span').text(like+1);
                    $('#like_pub_button_'+id).replaceWith("<i id='dislike_pub_button_"+id+"' class='fas fa-heart'></i>");
                    if ( js_flood == 0 ) {
                        var msg = {
                            typeNotification: typeNotification,
                            // id: id,
                            uid: uid,
                            to_id: to_id,
                            idPub: idPub
                        };
                        websocket.send(JSON.stringify(msg));
                        flood_js();
                    } else {
                        console.log('error');
                    }
                }
            }
        });
    });

    // commentaire notification
    $(document).on('keypress','[id^="commentaire_text_"]',function(event) {
        if (event.which == 13) {
            id = $(this).attr("id").split("_")[2];
            var typeNotification = 'commentaire';
            var fd = new FormData();
            var to_id = $(document).find('#id_user').val();
            fd.append('id_recever_ntf',to_id);
            var idPub = $(document).find('#id_pub_'+id).val();
            fd.append('id_pub',idPub);
            var commentaireText = $(this).val();
            fd.append('commentaire_text',commentaireText);
            var nomUser = $('#commentaire_nom_user_'+id).val();
            var imgUser = $('#commentaire_img_user_'+id).val();
            $.ajax({
                url: 'comment-publication.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response != 0){
                        $('#commentaire_text_'+id).val('');
                        $('#user_publication_bottom_preview_'+id).prepend("<img src='./"+imgUser+"' alt=''><div><h4>"+nomUser+"</h4><p>"+commentaireText+"</p></div>"); 
                        if ( js_flood == 0 ) {
                            var msg = {
                                typeNotification: typeNotification,
                                commentaire: commentaireText,
                                imgUser: imgUser,
                                nomUser: nomUser,
                                uid: uid,
                                to_id: to_id,
                                idPub: idPub
                            };
                            websocket.send(JSON.stringify(msg));
                            flood_js();
                        } else {
                            console.log('error');
                        }
                    }
                }
            });
        }
    });

    // abonnement notification
    $('#abonne_user_button').click(function(e){
        var typeNotification = 'abonnement';
        var fd = new FormData();
        var idUser = $('#id_user').val();
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
                    $("#follow_button").replaceWith('<div id="disfollow_button"><p>Disabonner</p><i class="fas fa-user-slash"></i></div>');
                    if ( js_flood == 0 ) {
                        var msg = {
                            typeNotification: typeNotification,
                            uid: uid,
                            to_id: idUser
                        };
                        websocket.send(JSON.stringify(msg));
                        flood_js();
                    } else {
                        console.log('error');
                    }
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

    $('#abonne_btq_button').click(function(e){
        var typeNotification = 'abonnementBtq';
        var messagerieType = 'boutiqueUser';
        var fd = new FormData();
        var idBtq = $('#id_boutique_product').val();
        fd.append('id_btq',idBtq);
        var ntfBtq = $('#notifications_btq').val();
        fd.append('notifications_btq',ntfBtq);
        $.ajax({
            url: 'abonne-boutique.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            beforeSend: function(){
                $('#abonne_boutique').css('opacity','0.5');
                $("#loader_abn_btq").show();
            },
            success: function(response){
                if(response != 0){
                    $("#follow_button").replaceWith('<div id="disfollow_button"><p>Disabonner</p><i class="fas fa-user-slash"></i></div>');
                    if ( js_flood == 0 ) {
                        var msg = {
                            typeNotification: typeNotification,
                            messagerieType: messagerieType,
                            uid: uid,
                            to_id: idBtq
                        };
                        websocket.send(JSON.stringify(msg));
                        flood_js();
                    } else {
                        console.log('error');
                    }
                }
            },
            complete: function(){
                $('#abonne_boutique').css('opacity','');
                $("#loader_abn_btq").hide();
                $("body").removeClass('body-after');
                if (windowWidth > 768) {
                    $("#abonne_boutique").hide();
                }else{
                    $("#abonne_boutique").css('transform','');
                }
            }
        });
    });

    websocket.onmessage = function(ev) {
        var msg = JSON.parse(ev.data); 
        var typeNotification = msg.typeNotification;
        if (typeNotification == 'message') {
            var umsg = msg.message; 
            var userId = msg.idRecever; 
            var senderId = msg.idSender; 
            var cleMsg = msg.msgCle;
            var refreshSender = msg.refreshSender;
            var messagerieType = msg.typeMessagerie; 
            var msgCle = $(document).find('#msgCle').val();
            var messagerie = $(document).find('#messagerie').val();
            if (messagerieType == 'boutiqueUser') {
                if (cleMsg == msgCle) {
                    if (refreshSender == 1) {
                        if (messagerie == 'messagerie') {
                            var template_message = $(document).find('#template_right_message').html();
                            var message = template_message.replace('{message}', umsg);
                            $('.messagerie-middle-bottom').append(message);
                        }else if(messagerie == 'boutique'){
                            var boutique_template_message = $(document).find('#boutique_right_message').html();
                            var message_boutique = boutique_template_message.replace('{message}', umsg);
                            $('.boutique-message-right-bottom').append(message_boutique);
                        }
                        updateReceverMessage(userId,senderId);
                    }else{
                        if (userId != uid) {
                            if (messagerie == 'messagerie') {
                                var template_message = $(document).find('#template_left_message').html();
                                var message = template_message.replace('{message}', umsg);
                                $('.messagerie-middle-bottom').append(message);
                            }else if(messagerie == 'boutique'){
                                var boutique_template_message = $(document).find('#boutique_left_message').html();
                                var message_boutique = boutique_template_message.replace('{message}', umsg);
                                $('.boutique-message-right-bottom').append(message_boutique);
                            }
                            updateSenderMessage(userId,senderId);
                            updateReceverMessage(senderId,userId);
                        }else{
                            if (messagerie == 'messagerie') {
                                var template_message = $(document).find('#template_right_message').html();
                                var message = template_message.replace('{message}', umsg);
                                $('.messagerie-middle-bottom').append(message);
                            }else if(messagerie == 'boutique'){
                                var boutique_template_message = $(document).find('#boutique_right_message').html();
                                var message_boutique = boutique_template_message.replace('{message}', umsg);
                                $('.boutique-message-right-bottom').append(message_boutique);
                            }
                            updateReceverMessage(userId,senderId);
                            updateSenderMessage(senderId,userId);
                        }
                    }
                    scrolldiv();
                }
                updateReceverMessage(userId,senderId);
                $('.user-new-msg').load('load-user-new-msg.php');
                $('.btq-new-msg').load('load-btq-new-msg.php?btq='+senderId);
                $('.boutique-message-left').load('load-boutique-sender.php?id_btq='+uid);
                $('.messagerie-left').load('load-messagerie-sender.php?id_user='+uid);
            } 
            else if(messagerieType == 'userUser') {
                if (cleMsg == msgCle) {
                    if (refreshSender == 1) {
                        // console.log('1');
                        var template_message = $(document).find('#template_right_message').html();
                        var message = template_message.replace('{message}', umsg);
                        $('.messagerie-middle-bottom').append(message);
                        updateReceverMessage(userId,senderId);
                    }else{
                        // console.log('2');
                        if ( userId != uid ) {
                            var template_message = $(document).find('#template_left_message').html();
                            updateSenderMessage(userId,senderId);
                            updateReceverMessage(senderId,userId);
                        } else {
                            var template_message = $(document).find('#template_right_message').html();
                            updateReceverMessage(userId,senderId);
                            updateSenderMessage(senderId,userId);
                        }
                        var message = template_message.replace('{message}', umsg);
                        $('.messagerie-middle-bottom').append(message);
                    }
                    scrolldiv();
                }
                updateReceverMessage(userId,senderId);
                $('.user-new-msg').load('load-user-new-msg.php');
                setTimeout(() => {
                    $('.messagerie-left').load('load-messagerie-sender.php?id_user='+uid);
                }, 0);
            }
        }
        else if (typeNotification == 'like') {
            // var id = msg.id;
            var toId = msg.to_id;
            var idPub = msg.idPub;
            console.log('idpub '+idPub);
            if (toId != uid) {
                console.log('1');
                var like = parseInt($('.pub-like-'+idPub).find('span').text());
                console.log('like '+like);
                $('.pub-like-'+idPub).find('span').text(like+1);
                $('.user-new-ntf').load('load-user-new-ntf.php');
            } 
        }
        else if (typeNotification == 'commentaire') {
            var toId = msg.to_id;
            var idPub = msg.idPub;
            var nomUser = msg.nom_user;
            var imgUser = msg.img_user;
            var commentaire = msg.commentaire;
            if (toId != uid) {
                $('.pub-comment-'+idPub).prepend("<img src='./"+imgUser+"' alt=''><div><h4>"+nomUser+"</h4><p>"+commentaire+"</p></div>"); 
                $('.user-new-ntf').load('load-user-new-ntf.php');
            } 
        }
        else if (typeNotification == 'abonnement') {
            var id_abn_user = msg.id_abn_user;
            if (id_abn_user == uid) {
                $('.user-new-ntf').load('load-user-new-ntf.php');
            } 
        }
        else if (typeNotification == 'abonnementBtq') {
            var messagerieType = msg.typeMessagerie; 
            if (messagerieType == 'boutiqueUser') {
                var id_abn_user = msg.id_abn_user;
                console.log(id_abn_user);
                if (id_abn_user == uid) {
                    console.log('yes');
                    $('.btq-new-ntf').load('load-btq-new-ntf.php?btq='+id_abn_user);
                } 
            }
        }
    };
    
    websocket.onclose = function(ev){
        if ( status_websocket === 1 ) {
            status_websocket = 0;
            console.log('close');
        }
        setTimeout(function(){start(websocketServerLocation)}, 1000);
    };
    websocket.onerror = function(ev) {
        console.log('Error '+JSON.stringify(ev));
    };
}

function flood_js() {
    var interval_flood = setInterval(function() {
        if ( js_flood == 0 ) {
            js_flood = 1;
        } else {
            js_flood = 0;
            clearInterval(interval_flood);
        }
    }, 300);
}