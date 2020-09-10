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

    $(document).on('keypress','#message_text',function( event ) {
        if ( event.which == 13 || event.keyCode == 13 ) {
            var mymessage = $(this).val(); //get message text
            if ( mymessage.length > 0 ) {
                if ( js_flood == 0 ) {
                    var to_id = $(document).find('#id_corresponder').val();
                    var msgCle = $(document).find('#msgCle').val();
                    var typeMessagerie = $(document).find('#type_messagerie').val();
                    // console.log('typeMessagerie '+typeMessagerie);
                    // console.log('toid '+to_id);
					var msg = {
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
            event.preventDefault();
        }
    });
    // $('#btn_send_message').click(function() {
    //     var mymessage = $(this).val(); //get message text
    //     var myname = uname; //get user name

    //     if ( mymessage.length > 0 ) {
	// 		if ( js_flood == 0 ) {
	// 			var to_id = $('#chat_with').val();
	// 				var to_name = $('#chat_with option[value="'+to_id+'"]').text();
	// 				var msg = {
	// 					message: mymessage,
    //                     name: myname,
	// 					uid: uid,
	// 					to_id: to_id,
	// 					to_name: to_name
    //                 };
    //             websocket.send(JSON.stringify(msg));
    //             flood_js();
	// 		} else {
	// 			$('#ln').val('');
    //         }
    //     }
    //     var obj = document.getElementById('ln');
    //     obj.value = '';
    //     obj.focus();
    //     event.preventDefault();
    // });
    websocket.onmessage = function(ev) {
		// console.log(ev.data);
        var msg = JSON.parse(ev.data); //PHP sends Json data
        var umsg = msg.message; //message text
        var userId = msg.idRecever; //user name
        var senderId = msg.idSender; //user name
        var cleMsg = msg.msgCle;
        var refreshSender = msg.refreshSender; //user name
        var messagerieType = msg.typeMessagerie; //user name
        var msgCle = $(document).find('#msgCle').val();
        var messagerie = $(document).find('#messagerie').val();
        // var typeMessagerie = $(document).find('#type_messagerie').val();
        // console.log('messagerie '+messagerie);
        if (messagerieType == 'boutiqueUser') {
            if (cleMsg == msgCle) {
                if (refreshSender == 1) {
                    if (messagerie == 'messagerie') {
                        var template_message = $(document).find('#template_left_message').html();
                        var message = template_message.replace('{message}', umsg);
                        $('.messagerie-middle-bottom').append(message);
                    }else if(messagerie == 'boutique'){
                        var boutique_template_message = $(document).find('#boutique_left_message').html();
                        var message_boutique = boutique_template_message.replace('{message}', umsg);
                        $('.boutique-message-right-bottom').append(message_boutique);
                    }
                    updateReceverMessage(userId,senderId);
                }else{
                    // console.log('bpoutique user online');
                    if (userId != uid) {
                        if (messagerie == 'messagerie') {
                            var template_message = $(document).find('#template_right_message').html();
                            var message = template_message.replace('{message}', umsg);
                            $('.messagerie-middle-bottom').append(message);
                        }else if(messagerie == 'boutique'){
                            console.log('messagerie '+messagerie);
                            var boutique_template_message = $(document).find('#boutique_right_message').html();
                            var message_boutique = boutique_template_message.replace('{message}', umsg);
                            $('.boutique-message-right-bottom').append(message_boutique);
                        }
                        updateSenderMessage(userId,senderId);
                        updateReceverMessage(senderId,userId);
                    }else{
                        if (messagerie == 'messagerie') {
                            var template_message = $(document).find('#template_left_message').html();
                            var message = template_message.replace('{message}', umsg);
                            $('.messagerie-middle-bottom').append(message);
                        }else if(messagerie == 'boutique'){
                            var boutique_template_message = $(document).find('#boutique_left_message').html();
                            var message_boutique = boutique_template_message.replace('{message}', umsg);
                            $('.boutique-message-right-bottom').append(message_boutique);
                        }
                        updateReceverMessage(userId,senderId);
                        updateSenderMessage(senderId,userId);
                    }
                }
                scrolldiv();
            }
            setTimeout(() => {
                // $('.user-new-msg').load('load-user-new-msg.php');
                $('.boutique-message-left').load('load-boutique-sender.php?id_btq='+uid);
                $('.messagerie-left').load('load-messagerie-sender.php?id_user='+uid);
            }, 0);
        }else if(messagerieType == 'userUser'){
            if (cleMsg == msgCle) {
                if (refreshSender == 1) {
                    var template_message = $(document).find('#template_left_message').html();
                    var message = template_message.replace('{message}', umsg);
                    $('.messagerie-middle-bottom').append(message);
                    updateReceverMessage(userId,senderId);
                }else{
                    if ( userId != uid ) {
                        // console.log('userId != uid');
                        var template_message = $(document).find('#template_right_message').html();
                        updateSenderMessage(userId,senderId);
                        updateReceverMessage(senderId,userId);
                    } else {
                        // console.log('userId == uid');
                        var template_message = $(document).find('#template_left_message').html();
                        updateReceverMessage(userId,senderId);
                        updateSenderMessage(senderId,userId);
                    }
                    var message = template_message.replace('{message}', umsg);
                    $('.messagerie-middle-bottom').append(message);
                }
                scrolldiv();
            }
            loadUserListMsg();
            $('.user-new-msg').load('load-user-new-msg.php');
            setTimeout(() => {
                $('.messagerie-left').load('load-messagerie-sender.php?id_user='+uid);
            }, 0);
        }
        console.log('onmessage');
        // $('.user-new-msg').load('load-user-new-msg.php');
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