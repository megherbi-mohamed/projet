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

    // create publication notification
    $('#create_publication_container').on('click','#create_publication_button',function(){
        var typeNotification = 'publication';
        var lieuPub = $('#publication_location_text').val();
        var idPub = $('#id_publication').val();
        var descriptionPub = $('#publication_description').val();
        var idUser = $('#id_session_porfile').val();
        var numMedia = $('.image-preview').length + $('.video-preview').length;
        if (lieuPub == '') {
            $('#publication_location_text').css('border','2px solid red');
        }
        else if (numMedia == 0) {
            $('#publication_location_text').css('border','');
            $('.create-publication-options').css('border','2px solid red');
        }
        else{
            var fd = new FormData();
            fd.append('id_pub',idPub);
            fd.append('lieu_pub',lieuPub);
            fd.append('description_pub',descriptionPub);
            $.ajax({
                url: 'create-publication.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    if (windowWidth > 768) {
                        $("#loader_create_publication_top_button").show();
                    }
                    else{
                        $("#loader_create_publication_bottom_button").show();
                    }
                },
                success: function(response){
                    console.log(response);
                    if(response != 0){
                        if ( js_flood == 0 ) {
                            var msg = {
                                typeNotification: typeNotification,
                                uid: uid
                            };
                            websocket.send(JSON.stringify(msg));
                            flood_js();
                        } else {
                            console.log('error');
                        }
                        if (windowWidth > 768) {
                            $("body").removeClass('body-after');
                            $('#create_publication_container').css({'top':'','transform':''});
                            $('#create_publication').hide();
                            window.location.href = "utilisateur/"+idUser;
                        }
                        else{
                            $('#create_publication').css('transform','');
                            setTimeout(() => {
                                window.location.href = "utilisateur/"+idUser;
                            }, 400);
                        }
                    }
                },
                complete: function(){
                    if (windowWidth > 768) {
                        $("#loader_create_publication_top_button").hide();
                    }
                    else{
                        $("#loader_create_publication_bottom_button").hide();
                    }
                }
            });
        }
    });

    // like publication notification
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
                if(response != 0){
                    var like = parseInt($('#user_publication_bottom_top_'+id).find('span').text());
                    $('#user_publication_bottom_top_'+id).find('span').text(like+1);
                    $('#like_pub_button_'+id).replaceWith("<i id='dislike_pub_button_"+id+"' class='fas fa-heart'></i>");
                    if ( js_flood == 0 ) {
                        var msg = {
                            typeNotification: typeNotification,
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

    // commentaire publication notification
    $(document).on('keypress','[id^="commentaire_text_"]',function(event) {
        var commentaireText = $(this).val();
        if (event.which == 13) {
            if (commentaireText !== '') {
                var id = $(this).attr("id").split("_")[2];
                var typeNotification = 'commentaire';
                var fd = new FormData();
                var to_id = $(document).find('#id_user').val();
                fd.append('id_recever_ntf',to_id);
                var idPub = $(document).find('#id_pub_'+id).val();
                fd.append('id_pub',idPub);
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
                            $('[id^="commentaire_text_"]').val('');
                            $('[id^="commentaire_text_"]').blur();
                            if (windowWidth > 768) {
                                $('#user_publication_bottom_preview_'+id).prepend("<img src='./"+imgUser+"' alt=''><div><h4>"+nomUser+"</h4><p>"+commentaireText+"</p></div>"); 
                            }
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
        }
    });

    // // commentaire publication notification
    // $(document).on('keypress','#send_comment_button',function(event) {
    //     var commentaireText = $('#commentaire_pub_text').val();
    //     if (event.which == 13) {
    //         if (commentaireText !== '') {
    //             var id = $(this).attr("id").split("_")[2];
    //             var typeNotification = 'commentaire';
    //             var fd = new FormData();
    //             var to_id = $(document).find('#id_user').val();
    //             fd.append('id_recever_ntf',to_id);
    //             var idPub = $(document).find('#id_pub').val();
    //             fd.append('id_pub',idPub);
    //             fd.append('commentaire_text',commentaireText);
    //             var nomUser = $('#commentaire_nom_user').val();
    //             var imgUser = $('#commentaire_img_user').val();
    //             $.ajax({
    //                 url: 'comment-publication.php',
    //                 type: 'post',
    //                 data: fd,
    //                 contentType: false,
    //                 processData: false,
    //                 success: function(response){
    //                     if(response != 0){
    //                         $('[id^="commentaire_pub_text"]').val('');
    //                         $('[id^="commentaire_pub_text"]').blur();
    //                         if (windowWidth > 768) {
    //                             $('#user_publication_bottom_preview_'+id).prepend("<img src='./"+imgUser+"' alt=''><div><h4>"+nomUser+"</h4><p>"+commentaireText+"</p></div>"); 
    //                         }
    //                         if ( js_flood == 0 ) {
    //                             var msg = {
    //                                 typeNotification: typeNotification,
    //                                 commentaire: commentaireText,
    //                                 imgUser: imgUser,
    //                                 nomUser: nomUser,
    //                                 uid: uid,
    //                                 to_id: to_id,
    //                                 idPub: idPub
    //                             };
    //                             websocket.send(JSON.stringify(msg));
    //                             flood_js();
    //                         } else {
    //                             console.log('error');
    //                         }
    //                     }
    //                 }
    //             });
    //         }
    //     }
    // });

    $('#send_comment_button').click(function(event) {
        var commentaireText = $('#commentaire_pub_text').val();
        if (commentaireText !== '') {
            var typeNotification = 'commentaire';
            var fd = new FormData();
            var to_id = $(document).find('#id_user').val();
            fd.append('id_recever_ntf',to_id);
            var idPub = $(document).find('#id_pub').val();
            fd.append('id_pub',idPub);
            fd.append('commentaire_text',commentaireText);
            var nomUser = $('#commentaire_nom_user').val();
            var imgUser = $('#commentaire_img_user').val();
            $.ajax({
                url: 'comment-publication.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response != 0){
                        $('#commentaire_pub_text').val('');
                        $('#commentaire_pub_text').blur();
                        if (windowWidth < 768) {
                            $('.display-user-publications-comments-container').prepend("<div class='publicaiton-comment'><img src='./"+imgUser+"' alt=''><div><h4>"+nomUser+"</h4><p>"+commentaireText+"</p></div></div>"); 
                        }
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

    // follow user notification
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

    // follow boutique notfication
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

    // create product notification
    $('#create_product_button').click(function(){
        var typeNotification = 'produit';
        var idBtq = $('#id_boutique_product').val();
        var idPrd = $('#id_product').val();
        var namePrd = $('#name_product').val();
        var referencePrd = $('#reference_product').val();
        var categoriePrd = $('#categorie_product').val();
        var descriptionPrd = $('#description_product').val();
        var caracteristiquePrd = $('#caracteristique_product').val();
        var fonctionnalitePrd = $('#fonctionnalite_product').val();
        var avantagePrd = $('#avantage_product').val();
        var quantityPrd = $('#quantity_product').val();
        var pricePrd = $('#price_product').val();

        if (namePrd == ''){
            $('#name_product').css('border','2px solid red');
        }
        // else if(referencePrd == ''){
        //     $('#name_product').css('border','');
        //     $('#reference_product').css('border','2px solid red');
        // }
        else if(categoriePrd == ''){
            $('#name_product').css('border','');
            // $('#reference_product').css('border','');
            $('#categorie_product').css('border','2px solid red');
        }
        else if(descriptionPrd == ''){
            $('#name_product').css('border','');
            // $('#reference_product').css('border','');
            $('#categorie_product').css('border','');
            $('#description_product').css('border','2px solid red');
        }
        else if(quantityPrd == ''){
            $('#name_product').css('border','');
            // $('#reference_product').css('border','');
            $('#categorie_product').css('border','');
            $('#description_product').css('border','');
            $('#quantity_product').css('border','2px solid red');
        }
        else if(pricePrd == ''){
            $('#name_product').css('border','');
            // $('#reference_product').css('border','');
            $('#categorie_product').css('border','');
            $('#description_product').css('border','');
            $('#quantity_product').css('border','');
            $('#price_product').css('border','2px solid red');
        }
        else if(namePrd != '' && categoriePrd != '' && descriptionPrd != '' &&
            quantityPrd != '' && pricePrd != ''){
            var fd = new FormData();
            fd.append('id_prd',idPrd);
            fd.append('id_btq',idBtq);
            fd.append('name_prd',namePrd);
            fd.append('reference_prd',referencePrd);
            fd.append('categorie_prd',categoriePrd);
            fd.append('description_prd',descriptionPrd);
            fd.append('caracteristique_prd',caracteristiquePrd);
            fd.append('fonctionnalite_prd',fonctionnalitePrd);
            fd.append('avantage_prd',avantagePrd);
            fd.append('quantity_prd',quantityPrd);
            fd.append('price_prd',pricePrd);
            $.ajax({
                url: 'create-product.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $('.create-product-top').hide();
                    $('.create-product-bottom').hide();
                    $("#loader_load").show();
                },
                success: function(response){
                    if(response != 0){
                        $('.boutique-bottom').prepend(response);
                        if ( js_flood == 0 ) {
                            var msg = {
                                typeNotification: typeNotification,
                                uid: uid
                            };
                            websocket.send(JSON.stringify(msg));
                            flood_js();
                        } else {
                            console.log('error');
                        }
                    }
                },
                complete: function(){
                    $("#loader_load").hide();
                    $(".create-product").hide();
                    $("body").removeClass('body-after');
                    $('.create-product-container').css({'top':'','transform':''});
                    $('.create-product-top').show();
                    $('.create-product-bottom').show();
                    $('#name_product').val('');
                    $('#reference_product').val('');
                    $('#categorie_product').val('');
                    $('#description_product').val('');
                    $('#quantity_product').val('');
                    $('#price_product').val('');
                    $('.product-images-preview').empty();
                }
            });
        }
    });

    $('#crt_prd_btn_resp').click(function(){
        var typeNotification = 'produit';
        var idBtq = $('#id_boutique_product').val();
        var idPrd = $('#id_product').val();
        var namePrd = $('#name_product').val();
        var referencePrd = $('#reference_product').val();
        var categoriePrd = $('#categorie_product').val();
        var descriptionPrd = $('#description_product').val();
        var caracteristiquePrd = $('#caracteristique_product').val();
        var fonctionnalitePrd = $('#fonctionnalite_product').val();
        var avantagePrd = $('#avantage_product').val();
        var quantityPrd = $('#quantity_product').val();
        var pricePrd = $('#price_product').val();

        if (namePrd == ''){
            $('#name_product').css('border','2px solid red');
        }
        // else if(referencePrd == ''){
        //     $('#name_product').css('border','');
        //     $('#reference_product').css('border','2px solid red');
        // }
        else if(categoriePrd == ''){
            $('#name_product').css('border','');
            // $('#reference_product').css('border','');
            $('#categorie_product').css('border','2px solid red');
        }
        else if(descriptionPrd == ''){
            $('#name_product').css('border','');
            // $('#reference_product').css('border','');
            $('#categorie_product').css('border','');
            $('#description_product').css('border','2px solid red');
        }
        else if(quantityPrd == ''){
            $('#name_product').css('border','');
            // $('#reference_product').css('border','');
            $('#categorie_product').css('border','');
            $('#description_product').css('border','');
            $('#quantity_product').css('border','2px solid red');
        }
        else if(pricePrd == ''){
            $('#name_product').css('border','');
            // $('#reference_product').css('border','');
            $('#categorie_product').css('border','');
            $('#description_product').css('border','');
            $('#quantity_product').css('border','');
            $('#price_product').css('border','2px solid red');
        }
        else if(namePrd != '' && categoriePrd != '' && descriptionPrd != '' &&
            quantityPrd != '' && pricePrd != ''){
            var fd = new FormData();
            fd.append('id_prd',idPrd);
            fd.append('id_btq',idBtq);
            fd.append('name_prd',namePrd);
            fd.append('reference_prd',referencePrd);
            fd.append('categorie_prd',categoriePrd);
            fd.append('description_prd',descriptionPrd);
            fd.append('caracteristique_prd',caracteristiquePrd);
            fd.append('fonctionnalite_prd',fonctionnalitePrd);
            fd.append('avantage_prd',avantagePrd);
            fd.append('quantity_prd',quantityPrd);
            fd.append('price_prd',pricePrd);
            $.ajax({
                url: 'create-product.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $('.create-product-top').hide();
                    $('.create-product-bottom').hide();
                    $("#loader_load").show();
                },
                success: function(response){
                    if(response != 0){
                        $('.boutique-bottom').prepend(response);
                        if ( js_flood == 0 ) {
                            var msg = {
                                typeNotification: typeNotification,
                                uid: uid
                            };
                            websocket.send(JSON.stringify(msg));
                            flood_js();
                        } else {
                            console.log('error');
                        }
                    }
                },
                complete: function(){
                    $("#loader_load").hide();
                    $(".create-product").hide();
                    $("body").removeClass('body-after');
                    $('.create-product-container').css({'top':'','transform':''});
                    $('.create-product-top').show();
                    $('.create-product-bottom').show();
                    $('#name_product').val('');
                    $('#reference_product').val('');
                    $('#categorie_product').val('');
                    $('#description_product').val('');
                    $('#quantity_product').val('');
                    $('#price_product').val('');
                    $('.product-images-preview').empty();
                }
            });
        }
    });

    // commentaire product notification
    $(document).on('keypress','#commentaire_prd_text',function(event) {
        if (event.which == 13) {
            var typeNotification = 'commentaireBtq';
            var fd = new FormData();
            var idUserComment = $(document).find('#id_user_comment').val();
            fd.append('id_user',idUserComment);
            var to_id = $(document).find('#id_boutique_product').val();
            fd.append('id_btq',to_id);
            console.log(to_id);
            var idPrd = $(document).find('#id_prd').val();
            fd.append('id_prd',idPrd);
            var commentaireText = $(this).val();
            fd.append('commentaire_text',commentaireText);
            var nomUser = $('#commentaire_nom_user').val();
            var imgUser = $('#commentaire_img_user').val();
            $.ajax({
                url: 'comment-product.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response != 0){
                        $('#commentaire_text').val('');
                        $('#product_comments_preview').prepend("<img src='./"+imgUser+"' alt=''><div><h4>"+nomUser+"</h4><p>"+commentaireText+"</p></div>"); 
                        if ( js_flood == 0 ) {
                            var msg = {
                                typeNotification: typeNotification,
                                uid: uid,
                                to_id: to_id
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

    websocket.onmessage = function(ev) {
        var msg = JSON.parse(ev.data); 
        var typeNotification = msg.typeNotification;
        if (typeNotification == 'message') {
            var umsg = msg.message; 
            var userId = msg.idRecever; 
            var senderId = msg.idSender; 
            var cleMsg = msg.msgCle;
            var messagerieType = msg.typeMessagerie; 
            var msgCle = $(document).find('#msgCle').val();
            var messagerie = $(document).find('#messagerie').val();
            if (messagerieType == 'boutiqueUser') {
                if (cleMsg == msgCle) {
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
                    scrolldiv();
                }
                else{
                    updateReceverMessage(userId,senderId);
                }
                $('.user-new-msg').load('load-user-new-msg.php');
                $('.btq-new-msg').load('load-btq-new-msg.php?btq='+senderId);
                $('.boutique-message-left').load('load-boutique-sender.php?id_btq='+uid);
                $('.messagerie-left').load('load-messagerie-sender.php?id_user='+uid);
            } 
            else if(messagerieType == 'userUser') {
                if (cleMsg == msgCle) {
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
                    scrolldiv();
                }
                else{
                    updateReceverMessage(userId,senderId);
                }
                $('.user-new-msg').load('load-user-new-msg.php');
                setTimeout(() => {
                    $('.messagerie-left').load('load-messagerie-sender.php?id_user='+uid);
                }, 0);
            }
        }
        else if (typeNotification == 'publication') {
            var toId = msg.to_id;
            if (toId == uid) {
                $('.user-new-ntf').load('load-user-new-ntf.php');
            } 
        }
        else if (typeNotification == 'like') {
            var toId = msg.to_id;
            var idPub = msg.idPub;
            if (toId == uid) {
                var like = parseInt($('.pub-like-'+idPub).find('span').text());
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
            if (toId == uid) {
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
            // var messagerieType = msg.typeMessagerie; 
            // if (messagerieType == 'boutiqueUser') {
                var id_abn_user = msg.id_abn_user;
                if (id_abn_user == uid) {
                    $('.btq-new-ntf').load('load-btq-new-ntf.php?btq='+id_abn_user);
                } 
            // }
        }
        else if (typeNotification == 'produit') {
            var toId = msg.to_id;
            if (toId == uid) {
                $('.user-new-ntf').load('load-user-new-ntf.php');
            } 
        }
        else if (typeNotification == 'commentaireBtq') {
            var toId = msg.to_id;
            if (toId == uid) {
                $('.btq-new-ntf').load('load-btq-new-ntf.php?btq='+toId);
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