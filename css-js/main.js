// delete sessions user when browser close
// window.onbeforeunload = function (event) {
    // $.ajax({
    //     url: 'delete-sessions.php',
    //     success: function(response){
    //     },
    // });
    // event.returnValue = "Write something clever here..";
// }; 
// window.addEventListener("beforeunload", function (e) {
//     var confirmationMessage = "Warning! Do not close, save first";
    
//     (e || window.event).returnValue = confirmationMessage; //Gecko + IE
//     sendkeylog(confirmationMessage);
//     return confirmationMessage; 
// })

// cancel create when refresh page
$(window).on('beforeunload', function(){
    if ($('#create_publication').is(':visible')) {
        cancelCreatePublication ();
    }
    if ($('#create_boutique').is(':visible')) {
        var fd= new FormData();
        var idBtq = $('#id_boutique').val();
        fd.append('id_btq',idBtq);
        $.ajax({
            url: 'pre-delete-boutique.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                if(response != 0){
                    // $("body").removeClass('body-after');
                    // $('#create_boutique').hide();
                    // $('.create-publication-container').css({'top':'','transform':''});
                }    
            }
        });
    }
    if ($('#create_promotion').is(':visible')) {
        cancelCreatePromotion ();
    }
    if ($('#create_evenement').is(':visible')) {
        cancelCreateEvenement ();
    }
});

// create publication
$('#pre_create_publication').click(function(){
    $.ajax({
        url: 'pre-create-publication.php',
        type: 'post',
        beforeSend: function(){
            hideCreatePublication();
            if (windowWidth > 768) {
                $("body").addClass('body-after');
                $("body").css('overflow','hidden');
                $('#create_publication').show();
            }
            else{
                $('#create_publication').css('transform','translateX(0)'); 
            }
            $("#loader_create_publication").show();
        },
        success: function(response){
            if(response != 0){
                $('#create_publication_container').append(response);
            }   
        },
        complete: function(){
            $("#loader_create_publication").hide();
        }
    });
});

// cancel create publication
$('#create_publication_container').on('click','#cancel_create_publication',function(){
    cancelCreatePublication ();
})

$('#create_publication').click(function(){
    cancelCreatePublication ();
})

function cancelCreatePublication () {
    var fd = new FormData();
    var idPub = $('#id_publication').val();
    fd.append('id_pub',idPub);
    $.ajax({
        url: 'pre-delete-publication.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('#create_publication_container').empty();
            $("#loader_create_publication").show();
        },
        success: function(response){
            if(response != 0){
                if (windowWidth > 768) {
                    $("body").removeClass('body-after');
                    $("#create_publication").hide();
                }
                else{
                    $('#create_publication').css('transform',''); 
                }
            }    
        },
        complete: function(){
            $("#loader_create_publication").hide();
        }
    });
}

// set publication location
$('#create_publication_container').on('keyup',"#publication_location_text",function(){
    var locationText = document.getElementById("publication_location_text");
    var filter = locationText.value.toUpperCase();
    var location = document.querySelectorAll("#publication_location_item p");
    var locationItem= document.querySelectorAll("#publication_location_item");
    for (let i = 0; i < locationItem.length; i++) {
        txtValue = location[i].textContent || location[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            locationItem[i].style.display = "";
            $('.publication-preview-location').css('display','initial');
        } else {
            locationItem[i].style.display = "none";
        }
    }
    if ($(this).val() == '') {
        $('.publication-preview-location').css('display','');
    }
}); 

$('#create_publication_container').on('click',"#publication_location_item",function(){
    $('.publication-preview-location').css('display','');
    var locationText = $(this).find('p').text();
    console.log(locationText);
    $('#publication_location_text').val(locationText);
})

// set publication image 
$('#create_publication_container').on('click','#add_publication_image',function(){
    $('#image').val('');
    $('#image').click();
});

$('#create_publication_container').on('click','#image',function(e){
    e.stopPropagation();
});

$('#create_publication_container').on('change','#image',function () { 
    $('#add_publication_image_button').click();
});

$('#create_publication_container').on('click','#add_publication_image_button',function(e){
    e.stopPropagation();
    var numImg = $('.image-preview').length;
    if (numImg > 0) {
        var lastImg = $('.image-preview').last().attr('id').split("_")[2];
    }
    else{
        var lastImg = 0;
    }
    var numUpldImg = document.getElementById('image').files.length;
    var idPub = $('#id_publication').val();
    var form_data = new FormData();
    form_data.append('id_pub',idPub);
    for (let i = 0; i < 4 - numImg; i++) {
        form_data.append("images[]", document.getElementById('image').files[i]);
    }
    $.ajax({
        url: 'upload-images-publication.php', 
        type: 'post',
        data: form_data,
        dataType: 'json',
        contentType: false,
        processData: false,
        beforeSend: function(){
            if ((numImg + numUpldImg) <= 4) {
                for(let i = 0; i < numUpldImg; i++) {
                    let id = lastImg + i;
                    $('.publication-images-preview').append("<div class='image-preview' id='image_preview_"+id+"'><div id='loader_pub_img_"+id+"' class='center'></div></div>");
                }
            }
            else if ((numImg + numUpldImg) >= 5) {
                for(let i = 0; i < (4 - numImg); i++) {
                    let id = lastImg + i;
                    $('.publication-images-preview').append("<div class='image-preview' id='image_preview_"+id+"'><div id='loader_pub_img_"+id+"' class='center'></div></div>");
                }
            }
        },
        success: function (response) {
            for(let i = 0; i < response.length; i++) {
                var src = response[i];
                let id = lastImg + i;
                $('#image_preview_'+id).replaceWith("<div class='image-preview' id='image_preview_"+id+"'><div class='delete-preview' id='delete_preview_"+id+"'><i class='fas fa-times'></i></div><img src='"+src+"'></div>");
            }
        },
        complete: function(){
            numImg = $('.image-preview').length;
            if (numImg >= 4) {
                $('.create-publication-options').hide();
            }
        }
    });
});

// remove publication image preview
$('#create_publication_container').on('click','[id^="delete_preview_"]',function(){
    var id = $(this).attr("id").split("_")[2];
    var idPub = $('#id_publication').val();
    var mediaUrl = $('#image_preview_'+id+' img').attr('src');
    var fd = new FormData();
    fd.append('id_pub',idPub);
    fd.append('media_url',mediaUrl);
    $.ajax({
        url: 'delete-publication-media.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('#image_preview_'+id).replaceWith("<div class='image-preview' id='image_preview_"+id+"'><div id='loader_pub_img_"+id+"' class='center'></div></div>");
        },
        success: function(response){
            if(response != 0){
                $('#image_preview_'+id).remove();
            }
        },
        complete: function(){
            var numImg = $('.image-preview').length;
            if (numImg < 4) {
                $('.create-publication-options').show();
            }
        }
    });
});

// set publication video 
$('#create_publication_container').on('click','#add_publication_video',function(){
    $('#video').val('');
    $('#video').click();
})

$('#create_publication_container').on('click','#video',function(e){
    e.stopPropagation();
});

$('#create_publication_container').on('change','#video',function () { 
    $('#add_publication_video_button').click();
});

$('#create_publication_container').on('click','#add_publication_video_button',function(e){
    e.stopPropagation();
    var idPub = $('#id_publication').val();
    var form_data = new FormData();
    form_data.append('id_pub',idPub);
    form_data.append("video", $('#video')[0].files[0]);
    $.ajax({
        url: 'upload-video-publication.php', 
        type: 'post',
        data: form_data,
        dataType: 'json',
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('.publication-video-preview').append("<div class='video-preview' id='video_preview'><div id='loader_pub_video' class='center'></div></div>");
        },
        success: function (response) {
            if (windowWidth > 768) {
                $('.create-publication-container').css({'top':'0','transform':'translate(-50%,0%)'});
            }
            $('#video_preview').replaceWith("<div class='video-preview' id='video_preview'><div class='delete-preview' id='delete_video'><i class='fas fa-times'></i></div><video controls><source src='"+response+"'></video></div>");
        },
        complete: function(){
            var numVideo = $('.video-preview').length;
            if (numVideo >= 1) {
                $('.create-publication-options').hide();
            }
        }
    });
});

// remove publication video preview
$('#create_publication_container').on('click','#delete_video',function(){
    var fd = new FormData();
    var idPub = $('#id_publication').val();
    fd.append('id_pub',idPub);
    var mediaUrl = $('.video-preview video source').attr('src');
    fd.append('media_url',mediaUrl);
    $.ajax({
        url: 'delete-publication-media.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('#video_preview').replaceWith("<div class='video-preview' id='video_preview'><div id='loader_pub_video' class='center'></div></div>");
        },
        success: function(response){
            if(response != 0){
                $('#video_preview').remove();
            }
        },
        complete: function(){
            var numVideo = $('.video-preview').length;
            if (numVideo == 0) {
                $('.create-publication-options').show();
            }
        }
    });
});

// update publications 
$(document).on('click','[id^="update_publication_"]',function(){
    var id = $(this).attr("id").split("_")[2];
    var idPub = $('#id_pub_'+id).val();
    var tailPub = $('#publication_tail_'+id).val();
    var fd = new FormData();
    fd.append('id_pub',idPub); 
    fd.append('tail_pub',tailPub);
    $.ajax({
        url: 'load-update-publication.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function(){
            if (windowWidth > 768) {
                $("body").addClass('body-after');
                $("body").css('overflow','hidden');
                $('#update_publication').show();
            }
            else{
                $('#update_publication').css('transform','translateX(0)'); 
            }
            $("#loader_update_publication").show();
        },
        success: function(response){
            if(response != 0){
                $('#update_publication_container').append(response);
            }   
        },
        complete: function(){
            $("#loader_update_publication").hide();
        }
    });
});

// cancel create publication
$('#update_publication_container').on('click','#cancel_create_publication',function(){
    cancelUpdatePublication ();
})

$('#update_publication').click(function(){
    cancelUpdatePublication ();
})

function cancelUpdatePublication () {
    if (windowWidth > 768) {
        $("body").removeClass('body-after');
        $("body").css('overflow','');
        $('#update_publication_container').empty();
        $('#update_publication').hide();
    }
    else{
        $('#update_publication').css('transform','');
        setTimeout(() => {
            $('#update_publication_container').empty();
        }, 400); 
    }
}

// update publication location
$('#update_publication_container').on('keyup',"#publication_location_text",function(){
    var locationText = document.getElementById("publication_location_text");
    var filter = locationText.value.toUpperCase();
    var location = document.querySelectorAll("#publication_location_item p");
    var locationItem= document.querySelectorAll("#publication_location_item");
    for (let i = 0; i < locationItem.length; i++) {
        txtValue = location[i].textContent || location[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            locationItem[i].style.display = "";
            $('.publication-preview-location').css('display','initial');
        } else {
            locationItem[i].style.display = "none";
        }
    }
    if ($(this).val() == '') {
        $('.publication-preview-location').css('display','');
    }
}); 

$('#update_publication_container').on('click',"#publication_location_item",function(){
    $('.publication-preview-location').css('display','');
    var locationText = $(this).find('p').text();
    console.log(locationText);
    $('#publication_location_text').val(locationText);
})

// update publication image 
$('#update_publication_container').on('click','#add_publication_image',function(){
    $('#image').click();
});

$('#update_publication_container').on('click','#image',function(e){
    e.stopPropagation();
});

$('#update_publication_container').on('change','#image',function () { 
    $('#add_publication_image_button').click();
});

$('#update_publication_container').on('click','#add_publication_image_button',function(e){
    e.stopPropagation();
    var numImg = $('.image-preview').length;
    if (numImg > 0) {
        var lastImg = $('.image-preview').last().attr('id').split("_")[2];
    }
    else{
        var lastImg = 0;
    }
    var numUpldImg = document.getElementById('image').files.length;
    var idPub = $('#id_publication').val();
    var form_data = new FormData();
    form_data.append('id_pub',idPub);
    for (let i = 0; i < 4 - numImg; i++) {
        form_data.append("images[]", document.getElementById('image').files[i]);
    }
    $.ajax({
        url: 'upload-images-publication.php', 
        type: 'post',
        data: form_data,
        dataType: 'json',
        contentType: false,
        processData: false,
        beforeSend: function(){
            for(let i = 0; i < numUpldImg; i++) {
                let id = lastImg + i;
                $('.publication-images-preview').append("<div class='image-preview' id='image_preview_"+id+"'><div id='loader_pub_img_"+id+"' class='center'></div></div>");
            }
        },
        success: function (response) {
            for(let i = 0; i < response.length; i++) {
                var src = response[i];
                let id = lastImg + i;
                $('#image_preview_'+id).replaceWith("<div class='image-preview' id='image_preview_"+id+"'><div class='delete-preview' id='delete_preview_"+id+"'><i class='fas fa-times'></i></div><img src='"+src+"'></div>");
            }
        },
        complete: function(){
            numImg = $('.image-preview').length;
            if (numImg >= 4) {
                $('.create-publication-options').hide();
            }
        }
    });
});

// remove publication image preview
$('#update_publication_container').on('click','[id^="delete_preview_"]',function(){
    var id = $(this).attr("id").split("_")[2];
    var idPub = $('#id_publication').val();
    var mediaUrl = $('#image_preview_'+id+' img').attr('src');
    var fd = new FormData();
    fd.append('id_pub',idPub);
    fd.append('media_url',mediaUrl);
    $.ajax({
        url: 'delete-image-publication-preview.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('#image_preview_'+id).replaceWith("<div class='image-preview' id='image_preview_"+id+"'><div id='loader_pub_img_"+id+"' class='center'></div></div>");
        },
        success: function(response){
            if(response != 0){
                $('#image_preview_'+id).remove();
            }
        },
        complete: function(){
            var numImg = $('.image-preview').length;
            if (numImg < 4) {
                $('.create-publication-options').show();
            }
        }
    });
});

// update publication video 
$('#update_publication_container').on('click','#add_publication_video',function(){
    $('#video').click();
})

$('#update_publication_container').on('click','#video',function(e){
    e.stopPropagation();
});

$('#update_publication_container').on('change','#video',function () { 
    $('#add_publication_video_button').click();
});

$('#update_publication_container').on('click','#add_publication_video_button',function(e){
    e.stopPropagation();
    var idPub = $('#id_publication').val();
    var fd = new FormData();
    fd.append('id_pub',idPub);
    fd.append("video", $('#video')[0].files[0]);
    $.ajax({
        url: 'upload-video-publication.php', 
        type: 'post',
        data: fd,
        dataType: 'json',
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('.publication-video-preview').append("<div class='video-preview' id='video_preview'><div id='loader_pub_video' class='center'></div></div>");
        },
        success: function (response) {
            if (windowWidth > 768) {
                $('.create-publication-container').css({'top':'0','transform':'translate(-50%,0%)'});
            }
            $('#video_preview').replaceWith("<div class='video-preview' id='video_preview'><div class='delete-preview' id='delete_video'><i class='fas fa-times'></i></div><video controls><source src='"+response+"'></video></div>");
        },
        complete: function(){
            var numVideo = $('.video-preview').length;
            if (numVideo >= 1) {
                $('.create-publication-options').hide();
            }
        }
    });
});

// remove publication video preview
$('#update_publication_container').on('click','#delete_video',function(){
    var fd = new FormData();
    var idPub = $('#id_publication').val();
    fd.append('id_pub',idPub);
    var mediaUrl = $('.video-preview video source').attr('src');
    fd.append('media_url',mediaUrl);
    $.ajax({
        url: 'delete-video-publication-preview.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('#video_preview').replaceWith("<div class='video-preview' id='video_preview'><div id='loader_pub_video' class='center'></div></div>");
        },
        success: function(response){
            if(response != 0){
                $('#video_preview').remove();
            }
        },
        complete: function(){
            var numVideo = $('.video-preview').length;
            if (numVideo == 0) {
                $('.create-publication-options').show();
            }
        }
    });
});

$('#update_publication_container').on('click','#update_publication_button',function(){
    var idPub = $('#id_publication').val();
    var lieuPub = $('#publication_location_text').val();
    var descriptionPub = $('#publication_description').val();
    var tailPub = $('#tail_publication').val();
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
        fd.append('tail_pub',tailPub);
        $.ajax({
            url: 'update-publication.php',
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
                if(response != 0){
                    if (windowWidth > 768) {
                        $("body").removeClass('body-after');
                        $('#update_publication_container').css({'top':'','transform':''});
                        $('#update_publication').hide();
                        $('#user_publication_'+id).replaceWith(response);
                    }
                    else{
                        $('#update_publication').css('transform','');
                        setTimeout(() => {
                            $('#user_publication_'+id).replaceWith(response);
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

//___________________________________________________________________________

var pathName = window.location.pathname;

$('#inscription_button').click(function(){
    $(".inscription")[0].scrollIntoView({behavior: "smooth"});
});

var categorieProfssTop = document.querySelectorAll('.categorie-profss-top');
var categorieProfssBottom = document.querySelectorAll('.categorie-profss-bottom');
var clickCategorie = new Array(categorieProfssTop.length);

for (let k = 0; k < categorieProfssTop.length; k++) {
    clickCategorie[k] = 1;
    categorieProfssTop[k].addEventListener('click',(e)=>{
        e.stopPropagation();
        clickCategorie[k]++;
        if (clickCategorie[k]%2 == 1) {
            categorieProfssBottom[k].style.display = "";
        }
        else{
            hideCategories();
            categorieProfssBottom[k].style.display = "initial";
        }
        categorieProfssTop[k].scrollIntoView();
    }) 
}

function hideCategories (){
    categorieProfssBottom.forEach(c => {
        c.style.display = "";
    });
}

$(document).on('click',".profile-image-desktop",function() {
    var idUser = $('#id_session_porfile').val();
    window.location = 'utilisateur/'+idUser;
});

$(document).on('click',".profile-btq-desktop",function() {
    var idBtq = $('#id_btq_adm').val();
    window.location = './gerer-boutique.php?btq='+idBtq;
});

$(".user-logout").click(function() {
    if (windowWidth < 768) {
        $('.user-list-dropdown').css('transform','');
        setTimeout(() => {
            window.location = 'deconnexion.php';
        }, 200);
    }
    else{
        window.location = 'deconnexion.php';

    }
});

$(document).on('click',"#btq_logout",function() {
    window.location = 'deconnexion.php';
});

$(document).on('click',"#gestion_boutique_button",function() {
    window.location = 'gestion-boutique-connexion.php';
});

$("#gestion_boutique_button_responsive").click(function() {
    $('.hide-menu').css('transform','');
    setTimeout(() => {
        window.location = 'gestion-boutique-connexion';
    }, 400);
});

$(document).on('click',"#inscription_connexion_button",function() {
    window.location = 'inscription-connexion';
});

$("#inscription_connexion_button_responsive").click(function() {
    $('.hide-menu').css('transform','');
    setTimeout(() => {
        window.location = 'inscription-connexion';
    }, 400);
});

$('#display_user_profile').click(function() {
    var idUser = $('#id_session_porfile').val();
    if (windowWidth < 768) {
        $('.user-list-dropdown').css('transform','');
    }
    else{
        $('.user-list-dropdown').hide();
    }
    setTimeout(() => {
        window.location = 'utilisateur/'+idUser;
    }, 200);
});
$('#display_parametres_profile').click(function() {
    if (windowWidth < 768) {
        $('.user-list-dropdown').css('transform','');
    }
    else{
        $('.user-list-dropdown').hide();
    }
    setTimeout(() => {
        window.location = 'profile-parametres/parametres';
    }, 200);
});

// load user messages
$('#user_list_messages').click(function(e){
    e.stopPropagation();
    $('.user-new-ntf').load('load-user-new-ntf.php');
    if (windowWidth > 768) {
        $('.user-list-dropdown').hide();
        $('.user-create-options').hide();
        $('.user-list-messages').show();
        $('.user-list-notifications').hide();
        $('.categorie-professionnel').hide();
    }else{
        $('.user-list-dropdown').css('transform','');
        $('.user-create-options').css('transform','');
        $('.user-list-messages').css('transform','translateY(0)');
        $('.user-list-notifications').css('transform','');
        $('.categorie-professionnel').css('transform','');
    }
    $('.categorie-search-bar').css('z-index','');
    $('.categorie-search-bar i').show();
    $('#categorie_search').css('width','');
    $('#categorie_search').css('padding','');
    $('#categorie_search').css('margin-left','');
    hideCategories();
    loadUserListMsg();
})

$('.user-list-messages').click(function(e){
    e.stopPropagation();
})

$('#cancel_user_list_messages').click(function(){
    $('.user-list-messages').css('transform','');
})

function loadUserListMsg(){
    var fd = new FormData();
    var idUser = $('#id_user_porfile').val();
    fd.append('id_user',idUser);
    $.ajax({
        url: 'load-user-list-messages.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $("#loader_list_message").show();
        },
        success: function(response){
            $('.user-list-bottom-message').empty();
            $('.user-list-bottom-message').append(response);
        },
        complete: function(){
            $("#loader_list_message").hide();
        }
    });
}

// load user notifications
$('#user_list_notifications').click(function(e){
    e.stopPropagation();
    if (windowWidth > 768) {
        $('.user-list-dropdown').hide();
        $('.user-create-options').hide();
        $('.user-list-messages').hide();
        $('.user-list-notifications').show();
        $('.categorie-professionnel').hide();
    }else{
        $('.user-list-dropdown').css('transform','');
        $('.user-create-options').css('transform','');
        $('.user-list-messages').css('transform','');
        $('.user-list-notifications').css('transform','translateY(0)');
        $('.categorie-professionnel').css('transform','');
    }
    $('.categorie-search-bar').css('z-index','');
    $('.categorie-search-bar i').show();
    $('#categorie_search').css('width','');
    $('#categorie_search').css('padding','');
    $('#categorie_search').css('margin-left','');
    hideCategories();
    loadUserListNtf();
})

$('.user-list-notifications').click(function(e){
    e.stopPropagation();
})

$('#cancel_user_list_notifications').click(function(){
    $('.user-list-notifications').css('transform','');
})

function loadUserListNtf(){
    var fd = new FormData();
    var idUser = $('#id_user_porfile').val();
    fd.append('id_user',idUser);
    $.ajax({
        url: 'load-user-list-notifications.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $("#loader_list_notification").show();
        },
        success: function(response){
            $('.user-list-bottom-notifications').empty();
            $('.user-list-bottom-notifications').append(response);
        },
        complete: function(){
            $("#loader_list_notification").hide();
        }
    });
}

// function userNewMsg(idRecever,idSender){
//     console.log(idRecever+' '+idSender);
//     updateSenderMessage(idRecever,idSender);
//     updateReceverMessage(idSender,idRecever);
// }

// responsivity
var windowWidth = window.innerWidth;
if (windowWidth <= 768) {

    var profileButton = document.querySelector('#profile_button');
    // var createNew = document.querySelector('#create_new');
    // var recrutementsButton = document.querySelector('#recrutements_button');
    var boutdechantierButton = document.querySelector('#boutdechantier_button');
    var categoriesButton = document.querySelector('#categories_button');
    var promotionsButton = document.querySelector('#promotions_button');
    var homeButton = document.querySelector('#home_button');
    var evenementsButton = document.querySelector('#evenements_button');
    var demandeOffreButton = document.querySelector('#demande_offre_button');

    var ajouterEvenementButton = document.querySelector('#ajouter_evenement_button');
    var ajouterOffreDemandeButton = document.querySelector('#ajouter_offre_demande_button');
    var createGroupeButton = document.querySelector('#create_groupe_button');
    
    $('#back_history_button').click(function(){
        window.history.back();
    })

    homeButton.addEventListener('click',()=>{
        $('.hide-menu').css('transform','');
        setTimeout(() => {
            window.location = 'index.php';
        }, 400);
    })
    boutdechantierButton.addEventListener('click',()=>{
        $('.hide-menu').css('transform','');
        setTimeout(() => {
            window.location = 'boutdechantier.php';
        }, 400);
    })
    categoriesButton.addEventListener('click',()=>{
        $('.hide-menu').css('transform','');
        setTimeout(() => {
            window.location = 'categories.php';
        }, 400);
    })
    // recrutementsButton.addEventListener('click',()=>{
    //     window.location = './recrutements.php';
    // })
    promotionsButton.addEventListener('click',()=>{
        $('.hide-menu').css('transform','');
        setTimeout(() => {
            window.location = 'promotions.php';
        }, 400);
    })
    evenementsButton.addEventListener('click',()=>{
        $('.hide-menu').css('transform','');
        setTimeout(() => {
            window.location = 'evenements.php';
        }, 400);
    })

    $('.show-hide-menu').click(function(e){
        e.stopPropagation();
        $('.hide-menu').css('transform','translateX(0)');
        unsetBoutdechantierSearchBar();
        unsetRechercheSearchBar();
        unsetGererBoutiqueSearchBar();
        unsetBoutiqueSearchBar();
        unsetPromotionsSearchBar();
        unsetEvenementsSearchBar();
        $('.boutdechantier-left').css('transform','');
        $('.promotions-left').css('transform','');
        $('.evenements-left').css('transform','');
        $('.recherche-left').css('transform','');
        $('.gerer-boutique-left').css('transform','');
        $('body').addClass('body-after');
        $('.navbar-right').addClass('navbar-right-after');
        $('.navbar').css('box-shadow','none');
        $('.navbar').css('-webkit-box-shadow','none');
        if (windowWidth < 768) {
            $('.user-list-dropdown').css('transform','');
            $('.user-create-options').css('transform','');
            $('.user-list-messages').css('transform','');
            $('.user-list-notifications').css('transform','');
        }
        else{
            $('.user-list-dropdown').hide();
            $('.user-create-options').hide();
            $('.user-list-messages').hide();
            $('.user-list-notifications').hide();
        }
        
    });

    $('.hide-menu').click(function(e){
        e.stopPropagation();
    });

    $('.show-search-bar-rsp').click(function(e){
        e.stopPropagation();
        $('.categorie-professionnel').css('transform','translateX(0)');
        $('.hide-menu').css('transform','');
        $('.boutdechantier-left').css('transform','');
        $('.promotions-left').css('transform','');
        $('.evenements-left').css('transform','');
        $('.recherche-left').css('transform','');
        $('.gerer-boutique-left').css('transform','');
        unsetBoutdechantierSearchBar();
        unsetRechercheSearchBar();
        unsetGererBoutiqueSearchBar();
        unsetBoutiqueSearchBar();
        unsetPromotionsSearchBar();
        unsetEvenementsSearchBar();
        $('body').removeClass('body-after');
        $('.navbar-right').removeClass('navbar-right-after');
        $('.navbar').css('box-shadow','');
        $('.navbar').css('-webkit-box-shadow','');
        if (windowWidth < 768) {
            $('.user-list-dropdown').css('transform','');
            $('.user-create-options').css('transform','');
            $('.user-list-messages').css('transform','');
            $('.user-list-notifications').css('transform','');
        }
        else{
            $('.user-list-dropdown').hide();
            $('.user-create-options').hide();
            $('.user-list-messages').hide();
            $('.user-list-notifications').hide();
        }
    });

    $('.categorie-professionnel').click(function(e){
        e.stopPropagation();
    })

    $('body').click(function(){
        $('.hide-menu').css('transform','');
        $('.boutdechantier-left').css('transform','');
        $('.promotions-left').css('transform','');
        $('.evenements-left').css('transform','');
        $('.recherche-left').css('transform','');
        $('.gerer-boutique-left').css('transform','');
        unsetBoutdechantierSearchBar();
        unsetRechercheSearchBar();
        unsetGererBoutiqueSearchBar();
        unsetBoutiqueSearchBar();
        unsetPromotionsSearchBar();
        unsetEvenementsSearchBar();
        $('body').removeClass('body-after');
        $('.navbar').css('box-shadow','');
        $('.navbar').css('-webkit-box-shadow','');
    });

    var createOptionsButton = document.querySelectorAll(".create-option");
    var createPublication = document.querySelectorAll(".create-publication");
    for (let i = 0; i < createOptionsButton.length; i++) {
        createOptionsButton[i].addEventListener('click',()=>{
            createPublication[i].style.transform = "translateX(0)";
        });
    }

    var cancelCreateMobileButton = document.querySelectorAll(".cancel-create-mobile");
    for (let i = 0; i < cancelCreateMobileButton.length; i++) {
        cancelCreateMobileButton[i].addEventListener('click',()=>{
            createPublication[i].style.transform = "";
        });
    }


}

$(document).on('keypress',"#categorie_search",function(event) {
    if (event.which == 13) {
        var rechercheText = $(this).val();
        if (windowWidth > 768) {
            window.location = 'recherche/'+rechercheText;
        }else{
            $('.categorie-professionnel').css('transform','');
            setTimeout(() => {
                window.location = 'recherche/'+rechercheText;
            }, 400);
        }
    }
});

// $('#categorie_search_btn').click(function(){
//     var rechercheText = $('#categorie_search').val();
//     window.location = 'recherche.php?r='+rechercheText;
// });

$('#categorie_search_button').click(function(e){
    e.stopPropagation();
    $('.categorie-professionnel').show();
    if (windowWidth > 768) {
        $('.user-list-dropdown').hide();
        $('.user-create-options').hide();
        $('.user-list-messages').hide();
        $('.user-list-notifications').hide();
    }else{
        $('.user-list-dropdown').css('transform','');
        $('.user-create-options').css('transform','');
        $('.user-list-messages').css('transform','');
        $('.user-list-notifications').css('transform','');
    }
})

$('#search_bar_button').click(function(e){
    e.stopPropagation();
    $('.categorie-professionnel').show();
    $('#categorie_search').focus();
    if (windowWidth > 768) {
        $('.user-list-dropdown').hide();
        $('.user-create-options').hide();
        $('.user-list-messages').hdie();
        $('.user-list-notifications').hide();
    }else{
        $('.user-list-dropdown').css('transform','');
        $('.user-create-options').css('transform','');
        $('.user-list-messages').css('transform','');
        $('.user-list-notifications').css('transform','');
    }
})

$('[id^="go_gerer_boutique_"]').click(function(e){
    var id = $(this).attr("id").split("_")[3];
    var fd = new FormData();
    var idBtq = $('#id_gb_'+id).val();
    fd.append('id_btq',idBtq);
    $.ajax({
        url: 'get-boutique-session.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        success: function(response){
            if(response != 0){
                if (windowWidth > 768) {
                    window.location = 'gerer-boutique/'+response;
                }
                else{
                    $('.user-list-dropdown').css('transform','');
                    setTimeout(() => {
                        window.location = 'gerer-boutique/'+response;
                    }, 200);
                }
            }
        }
    });
})

$('#categorie_search').click(function(e){
    e.stopPropagation();
})

$('#cancel_search_bar').click(function(){
    if (windowWidth > 768) {
        $('.categorie-professionnel').hide();
    }else{
        $('.categorie-professionnel').css('transform','');
    }
    $('.categorie-search-bar').css('z-index','');
    $('.categorie-search-bar i').show();
    $('#categorie_search').css('width','');
    $('#categorie_search').css('padding','');
    $('#categorie_search').css('margin-left','');
    hideCategories();
})

$('body').click(function(){
    $('.hide-menu').css('transform','');
    $('.navbar-right').removeClass('navbar-right-after');
    if (windowWidth > 768) {
        $('.user-list-dropdown').hide();
        $('.user-create-options').hide();
        $('.user-list-messages').hide();
        $('.user-list-notifications').hide();
    }else{
        $('.user-list-dropdown').css('transform','');
        $('.user-create-options').css('transform','');
        $('.user-list-messages').css('transform','');
        $('.user-list-notifications').css('transform','');
    }
    if (windowWidth > 768) {
        $('.categorie-professionnel').hide();
    }else{
        $('.categorie-professionnel').css('transform','');
    }
    $('.categorie-search-bar').css('z-index','');
    $('.categorie-search-bar i').show();
    $('#categorie_search').css('width','');
    $('#categorie_search').css('padding','');
    $('#categorie_search').css('margin-left','');
    if (windowWidth > 768) {
        $('[id^="product_options_"]').hide();
        $('[id^="publication_options_"]').hide();
    }
    else{
        $('.product-options').css('transform','');
        $('[id^="publication_options_"]').css('transform','');
        $("#abonne_boutique").css('transform','');
        $("#disabonne_boutique").css('transform','');
        $("#message_boutique").css('transform','');
        $('.parametres-profile-left').css('transform','');
    }
    $('#hide_publication').css('transform','');
    $('#delete_publication').css('transform','');
    $('#save_publication').css('transform','');
    hideCategories();
    if (windowWidth > 768) {
        $('[id^="categorie_options_"]').hide();
    }
    else{
        $('.categorie-options-resp').css('transform','');
        $('.display-user-publications-comments').css('transform','');
    }
});

$('#cancel_search_bar').click(function(){
    $('.categorie-search-bar').css('transform','');
})

// list dropdown 
$('#user_list_button').click(function(e){
    e.stopPropagation();
    if (windowWidth > 768) {
        $('.user-list-dropdown').show();
        $('.user-create-options').hide();
        $('.user-list-messages').hide();
        $('.user-list-notifications').hide();
        $('.categorie-professionnel').hide();
    }else{
        $('.user-list-dropdown').css('transform','translateY(0)');
        $('.user-create-options').css('transform','');
        $('.user-list-messages').css('transform','');
        $('.user-list-notifications').css('transform','');
        $('.categorie-professionnel').css('transform','');
    }
    $('.categorie-search-bar').css('z-index','');
    $('.categorie-search-bar i').show();
    $('#categorie_search').css('width','');
    $('#categorie_search').css('padding','');
    $('#categorie_search').css('margin-left','');
    hideCategories();
});

$('.user-list-dropdown').click(function(e){
    e.stopPropagation();
})

$('#cancel_user_list_dropdown').click(function(){
    $('.user-list-dropdown').css('transform','');
})

// list dropdown create options
$('#create_new').click(function(e){
    e.stopPropagation();
    if (windowWidth > 768) {
        $('.user-list-dropdown').hide();
        $('.user-create-options').show();
        $('.user-list-messages').hide();
        $('.user-list-notifications').hide();
        $('.categorie-professionnel').hide();
    }else{
        $('.user-list-dropdown').css('transform','');
        $('.user-create-options').css('transform','translateY(0)');
        $('.user-list-messages').css('transform','');
        $('.user-list-notifications').css('transform','');
        $('.categorie-professionnel').css('transform','');
    }
    $('.categorie-search-bar').css('z-index','');
    $('.categorie-search-bar i').show();
    $('#categorie_search').css('width','');
    $('#categorie_search').css('padding','');
    $('#categorie_search').css('margin-left','');
    hideCategories();
});

$('.user-create-options').click(function(e){
    e.stopPropagation();
})

$('#cancel_user_create_options').click(function(){
    $('.user-create-options').css('transform','');
})

var createOptionsButton = document.querySelectorAll(".create-option");
var createPublication = document.querySelectorAll(".create-publication");

var createPublicationContainer = document.querySelectorAll('.create-publication-container');
for (let i = 0; i < createPublicationContainer.length; i++) {
    createPublicationContainer[i].addEventListener('click',(e)=>{
        e.stopPropagation();
    });  
}

function hideCreatePublication (){
    createPublication.forEach(cp => {
        if (windowWidth > 768) {
            cp.style.display = "";
            $('.user-create-options').hide();
        }
        else{
            cp.style.transform = '';
            $('.user-create-options').css('transform','');
        }
    });

}

// create publication

// publication action








//update publication image
$('.update-publication-container').click(function(e){
    e.stopPropagation();
})

$('#update_publication_image').click(function(){
    $('#image_updt').click();
});

$('#image_updt').on('change',function(){ 
    $('#update_publication_image_button').click();
});

$('#update_publication_image_button').click(function(){
    var form_data = new FormData();
    var idPub = $('#id_publication_updt').val();
    form_data.append('id_pub',idPub);
    var totalfiles = document.getElementById('image_updt').files.length;
    for (let i = 0; i < totalfiles; i++) {
        form_data.append("images[]", document.getElementById('image_updt').files[i]);
    }
    $.ajax({
        url: 'upload-images-publication.php', 
        type: 'post',
        data: form_data,
        dataType: 'json',
        contentType: false,
        processData: false,
        beforeSend: function(){
            $("#loader_pub_img").show();
        },
        success: function (response) {
            console.log(response);
            if (windowWidth > 768) {
                $('.update-publication-container').css({'top':'0','transform':'translate(-50%,0%)'});
            }
            for(let i = 0; i < response.length; i++) {
                var src = response[i];
                $('.publication-update-images-preview').append("<div class='image-preview' id='image_preview_"+i+"'><div id='delete_preview_"+i+"'><i class='fas fa-times'></i></div><img src='"+src+"'></div>");
            }
        },
        complete: function(){
            $("#loader_pub_img").hide();
        }
    });
});

// update publication video
$('#update_publication_video').click(function(){
    $('#video_updt').click();
})

$('#video_updt').on('change', function () { 
    $('#update_publication_video_button').click();
});

$('#update_publication_video_button').click(function(){
    var form_data = new FormData();
    var idPub = $('#id_publication_updt').val();
    form_data.append('id_pub',idPub);
    form_data.append("video", $('#video_updt')[0].files[0]);
    $.ajax({
        url: 'upload-video-publication.php', 
        type: 'post',
        data: form_data,
        dataType: 'json',
        contentType: false,
        processData: false,
        beforeSend: function(){
            $("#loader_pub_img").show();
        },
        success: function (response) {
            if (windowWidth > 768) {
                $('.update-publication-container').css({'top':'0','transform':'translate(-50%,0%)'});
            }
            $('.publication-update-video-preview').append("<div class='video-preview'><div id='delete_video'><i class='fas fa-times'></i></div><video controls><source src='"+response+"'></video></div>");
        },
        complete: function(){
            $("#loader_pub_img").hide();
        }
    });
});

// remove update publication images preview
$('.publication-update-images-preview').on('click','[id^="delete_preview_"]',function(){
    var id = $(this).attr("id").split("_")[2];
    var fd = new FormData();
    var idPub = $('#id_publication_updt').val();
    fd.append('id_pub',idPub);
    var mediaUrl = $('.publication-update-images-preview #image_preview_'+id+' img').attr('src');
    fd.append('media_url',mediaUrl);
    $.ajax({
        url: 'update-images-preview.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        success: function(response){
            if(response != 0){
                $('.publication-update-images-preview #image_preview_'+id).remove();
            }
        }
    });
});

// remove update publication video preview
$('.publication-update-video-preview').on('click','#delete_video',function(){
    var fd = new FormData();
    var idPub = $('#id_publication_updt').val();
    fd.append('id_pub',idPub);
    console.log(idPub);
    var mediaUrl = $('.publication-update-video-preview .video-preview video source').attr('src');
    fd.append('media_url',mediaUrl);
    console.log(mediaUrl);
    $.ajax({
        url: 'update-video-preview.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        success: function(response){
            console.log(response);
            if(response != 0){
                $('.publication-update-video-preview .video-preview').remove();
            }
        }
    });
});



$('#cancel_update_publication_resp').click(function(){
    $('.update-publication').css('transform','');
})

$('#cancel_update_publication').click(function(){
    $("body").removeClass('body-after');
    $('.update-publication').hide();
    $('.update-publication-container').css({'top':'','transform':''});
    $('.publication-update-images-preview div').remove();
    $('.publication-update-video-preview div').remove();
})



$('#update_publication_button_resp').click(function(){
    // if ($('#publication_description').val() !== '') {
        var fd = new FormData();
        var idPubLieu = $('#publication_location_text_updt').val();
        fd.append('lieu_pub',idPubLieu);
        var idPub = $('#id_publication_updt').val();
        fd.append('id_pub',idPub);
        var id = $('#publication_tail_updt').val();
        fd.append('id',id);
        var descriptionPub = $('#publication_description_updt').val();
        fd.append('description_pub',descriptionPub);
        var etatCommentaire = $('#etat_commentaire_updt').val();
        fd.append('etat_commentaire',etatCommentaire);

        $.ajax({
            url: 'update-publication.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                if(response != 0){
                    $('.update-publication').css('transform','');
                    $('#user_publication_'+id).replaceWith(response);
                }
            }
        });
    // }
});

// publication options
$(document).on('click','[id^="display_pub_options_button_"]',function(){
    id = $(this).attr("id").split("_")[4];
    if (windowWidth > 768) {
        if ($('#publication_options_'+id).is(':visible')) {
            $('#publication_options_'+id).hide();
        }
        else{
            $('#publication_options_'+id).show();
        }
    }else{
        $("body").addClass('body-after');
        $('#publication_options_'+id).css('transform','translateY(0)');
    }
});

$(document).on('click','[id^="publication_options_"]',function(e){
    e.stopPropagation();
    // $(this).show();
});

// disactive publications comments
$(document).on('click','[id^="desactive_publication_comment_"]',function(){
    id = $(this).attr("id").split("_")[3];
    var fd = new FormData();
    var idPub = $('#id_pub_'+id).val();
    fd.append('id_pub',idPub);
    var publicationTail = $('#publication_tail_'+id).val();
    fd.append('id',publicationTail);
    $.ajax({
        url: 'desactive-comment-publication.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        success: function(response){
            if(response != 0){
                $('#user_publication_'+id).replaceWith(response);
            }
        }
    });
});

// active publications comments
$(document).on('click','[id^="active_publication_comment_"]',function(){
    id = $(this).attr("id").split("_")[3];
    var fd = new FormData();
    var idPub = $('#id_pub_'+id).val();
    fd.append('id_pub',idPub);
    var publicationTail = $('#publication_tail_'+id).val();
    fd.append('id',publicationTail);
    $.ajax({
        url: 'active-comment-publication.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        success: function(response){
            if(response != 0){
                $('#user_publication_'+id).replaceWith(response);
            }
        }
    });
});

// dislike publication
$(document).on('click','[id^="dislike_pub_button_"]',function(){
    id = $(this).attr("id").split("_")[3];
    var fd = new FormData();
    var idPub = $('#id_pub_'+id).val();
    fd.append('id_pub',idPub);
    $.ajax({
        url: 'dislike-publication.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        success: function(response){
            if(response != 0){
                var like = parseInt($('#user_publication_bottom_top_'+id).find('span').text());
                $('#user_publication_bottom_top_'+id).find('span').text(like-1);
                $('#dislike_pub_button_'+id).replaceWith("<i id='like_pub_button_"+id+"' class='far fa-heart'></i>");
            }
        }
    });
});

// display publication comment
$(document).on('click','[id^="diplay_pub_comment_button_"]',function(){
    var id = $(this).attr("id").split("_")[4];
    var idPub = $('#id_pub_'+id).val();
    if (windowWidth > 768) {
        if ($('#user_publication_bottom_comment_'+id).is(':visible')) {
            $('#user_publication_bottom_comment_'+id).css('display','');
        }
        else{
            $('#user_publication_bottom_comment_'+id).css('display','grid');
        }
    }
    else{
        $('.display-user-publications-comments').css('transform','translateY(0)')
        var fd = new FormData();
        fd.append('id_pub', idPub);
        var idUser = $('#id_user').val();
        fd.append('id_user', idUser);
        fd.append('id', id);
        $.ajax({
            url: 'load-user-publications-comments.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            beforeSend: function(){
                $("body").addClass('body-after');
                $('body').css('overflow','hidden');
                $('#loader_comments').show();
                $('.display-user-publications-comments-container').empty();
            },
            success: function(response){
                $('.display-user-publications-comments-container').append(response);
            },
            complete: function(){
                $('#loader_comments').hide();
            },
        });
    }
});

$('.display-user-publications-comments').click(function(e){
    e.stopPropagation();
})

$('#hide_pub_comments').click(function(e){
    $('body').css('overflow','');
    $("body").removeClass('body-after');
    $('.display-user-publications-comments').css('transform','');
})

$(document).on('click','[id^="user_publication_bottom_bottom_"]',function(e){
    var id = $(this).attr("id").split("_")[4];
    var idPub = $('#id_pub_'+id).val();
    if (windowWidth > 768) {
        if ($('#user_publication_bottom_comment_'+id).is(':visible')) {
            $('#user_publication_bottom_comment_'+id).css('display','');
        }
        else{
            $('#user_publication_bottom_comment_'+id).css('display','grid');
        }
    }
    else{
        $("body").addClass('body-after');
        $('.display-user-publications-comments').css('transform','translateY(0)')
        var fd = new FormData();
        fd.append('id_pub', idPub);
        var idUser = $('#id_user').val();
        fd.append('id_user', idUser);
        fd.append('id', id);
        $.ajax({
            url: 'load-user-publications-comments.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            beforeSend: function(){
                $('#loader_comments').show();
                $('.display-user-publications-comments-container').empty();
            },
            success: function(response){
                $('.display-user-publications-comments-container').append(response);
            },
            complete: function(){
                $('#loader_comments').hide();
            },
        });
    }
});

function setBoutdechantierSearchBar(){
    $('.navbar-right').hide();
    $('.show-hide-menu').hide();
    $('.logo-name').hide();
    $('#display_categories').hide();
    $('#display_bt_search_bar').hide();
    $('.boutdechantier-recherche-responsive').css('z-index','55');
    $('.boutdechantier-recherche-responsive-container').css('grid-template-columns','12% 88%');
    $('#back_menu').show();
    $('#boutdechantier_recherche_responsive').show();
    setTimeout(() => {
        $('body').addClass('body-after');
        $('#recherche_text_resp').focus();
    }, 0);
}

function unsetBoutdechantierSearchBar(){
    $('.navbar-right').show();
    $('.show-hide-menu').show();
    $('.logo-name').show();
    $('#display_categories').show();
    $('#display_bt_search_bar').show();
    $('.boutdechantier-recherche-responsive').css('z-index','');
    $('.boutdechantier-recherche-responsive-container').css('grid-template-columns','');
    $('#back_menu').hide();
    $('#boutdechantier_recherche_responsive').hide();
    $('body').removeClass('body-after');
    $('#recherche_text_resp').blur();
}

function setRechercheSearchBar(){
    $('.navbar-right').hide();
    $('.show-hide-menu').hide();
    $('.logo-name').hide();
    $('#display_categories').hide();
    $('#display_rech_search_bar').hide();
    $('.recherche-recherche-responsive').css('z-index','55');
    $('.recherche-recherche-responsive-container').css('grid-template-columns','12% 88%');
    $('#back_menu').show();
    $('#recherche_recherche_responsive').show();
    setTimeout(() => {
        $('body').addClass('body-after');
        $('#recherche_text_resp').focus();
    }, 0);
}

function unsetRechercheSearchBar(){
    $('.navbar-right').show();
    $('.show-hide-menu').show();
    $('.logo-name').show();
    $('#display_categories').show();
    $('#display_rech_search_bar').show();
    $('.recherche-recherche-responsive').css('z-index','');
    $('.recherche-recherche-responsive-container').css('grid-template-columns','');
    $('#back_menu').hide();
    $('#recherche_recherche_responsive').hide();
    $('body').removeClass('body-after');
    $('#recherche_text_resp').blur();
}

function setGererBoutiqueSearchBar(){
    $('.navbar-right').hide();
    $('.show-hide-menu').hide();
    $('.logo-name').hide();
    $('#display_gb_manager_resp').hide();
    $('#display_gb_search_bar').hide();
    $('.gerer-boutique-recherche-responsive').css('z-index','55');
    $('.gerer-boutique-recherche-responsive-container').css('grid-template-columns','12% 88%');
    $('#back_menu').show();
    $('#gerer_boutique_recherche_responsive').show();
    setTimeout(() => {
        $('body').addClass('body-after');
        $('#recherche_text_resp').focus();
    }, 0);
}

function unsetGererBoutiqueSearchBar(){
    $('.navbar-right').show();
    $('.show-hide-menu').show();
    $('.logo-name').show();
    $('#display_gb_manager_resp').show();
    $('#display_gb_search_bar').show();
    $('.gerer-boutique-recherche-responsive').css('z-index','');
    $('.gerer-boutique-recherche-responsive-container').css('grid-template-columns','');
    $('#back_menu').hide();
    $('#gerer_boutique_recherche_responsive').hide();
    $('body').removeClass('body-after');
    $('#recherche_text_resp').blur();
}

function setBoutiqueSearchBar(){
    $('.navbar-right').hide();
    $('.show-hide-menu').hide();
    $('.logo-name').hide();
    $('#display_categories_resp').hide();
    $('#display_btq_search_bar').hide();
    $('.boutique-search-responsive').css('z-index','55');
    $('.boutique-search-responsive-container').css('grid-template-columns','12% 88%');
    $('#back_menu').show();
    $('#boutique_search_responsive').show();
    setTimeout(() => {
        $('body').addClass('body-after');
        $('#recherche_text_resp').focus();
    }, 0);
}

function unsetBoutiqueSearchBar(){
    $('.navbar-right').show();
    $('.show-hide-menu').show();
    $('.logo-name').show();
    $('#display_categories_resp').show();
    $('#display_prm_search_bar').show();
    $('.boutique-search-responsive').css('z-index','');
    $('.boutique-search-responsive-container').css('grid-template-columns','');
    $('#back_menu').hide();
    $('#boutique_search_responsive').hide();
    $('body').removeClass('body-after');
    $('#recherche_text_resp').blur();
}

function setPromotionsSearchBar(){
    $('.navbar-right').hide();
    $('.show-hide-menu').hide();
    $('.logo-name').hide();
    $('#display_categories').hide();
    $('#display_prm_search_bar').hide();
    $('.promotions-recherche-responsive').css('z-index','55');
    $('.promotions-recherche-responsive-container').css('grid-template-columns','12% 88%');
    $('#back_menu').show();
    $('#promotions_recherche_responsive').show();
    setTimeout(() => {
        $('body').addClass('body-after');
        $('#recherche_text_resp').focus();
    }, 0);
}

function unsetPromotionsSearchBar(){
    $('.navbar-right').show();
    $('.show-hide-menu').show();
    $('.logo-name').show();
    $('#display_categories').show();
    $('#display_prm_search_bar').show();
    $('.promotions-recherche-responsive').css('z-index','');
    $('.promotions-recherche-responsive-container').css('grid-template-columns','');
    $('#back_menu').hide();
    $('#promotions_recherche_responsive').hide();
    $('body').removeClass('body-after');
    $('#recherche_text_resp').blur();
}

function setEvenementsSearchBar(){
    $('.navbar-right').hide();
    $('.show-hide-menu').hide();
    $('.logo-name').hide();
    $('#display_categories').hide();
    $('#display_evn_search_bar').hide();
    $('.evenements-recherche-responsive').css('z-index','55');
    $('.evenements-recherche-responsive-container').css('grid-template-columns','12% 88%');
    $('#back_menu').show();
    $('#evenements_recherche_responsive').show();
    setTimeout(() => {
        $('body').addClass('body-after');
        $('#recherche_text').focus();
    }, 0);
}

function unsetEvenementsSearchBar(){
    $('.navbar-right').show();
    $('.show-hide-menu').show();
    $('.logo-name').show();
    $('#display_categories').show();
    $('#display_evn_search_bar').show();
    $('.evenements-recherche-responsive').css('z-index','');
    $('.evenements-recherche-responsive-container').css('grid-template-columns','');
    $('#back_menu').hide();
    $('#evenements_recherche_responsive').hide();
    $('body').removeClass('body-after');
    $('#recherche_text').blur();
}

// hide publications
$(document).on('click','[id^="hide_publication_"]',function(){
    id = $(this).attr("id").split("_")[2];
    var idPub = $('#id_pub_'+id).val();
    var pubTail = $('#publication_tail_'+id).val();
    $('#id_publication_hide').val(idPub);
    $('#publication_tail_hide').val(pubTail);
    $("body").addClass('body-after');
    if (windowWidth > 768) {
        $('#hide_publication').show();
    }else{
        $('#hide_publication').css('transform','translateY(0)');
    }
});

$(document).on('click','#hide_pub_button',function(){
    console.log('click');
    var fd = new FormData();
    var idPub = $('#id_publication_hide').val();
    fd.append('id_pub',idPub);
    var pubTail = $('#publication_tail_hide').val();
    $.ajax({
        url: 'hide-publication.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        success: function(response){
            if(response != 0){
                console.log(response);
                $("body").removeClass('body-after');
                if (windowWidth > 768) {
                    $('#hide_publication').hide();
                }else{
                    $('#hide_publication').css('transform','');
                }
                $('#user_publication_'+pubTail).remove();
            }
        }
    });
});

$(document).on('click','#cancel_hide_publication',function(e){
    e.stopPropagation();
    $("body").removeClass('body-after');
    if (windowWidth > 768) {
        $('#hide_publication').hide();
    }else{
        $('#hide_publication').css('transform','');
    }
});

$(document).on('click','#cancel_hide_pub_button',function(e){
    e.stopPropagation();
    $("body").removeClass('body-after');
    if (windowWidth > 768) {
        $('#hide_publication').hide();
    }else{
        $('#hide_publication').css('transform','');
    }
});

$('#hide_publication').click(function(e){
    $("body").removeClass('body-after');
    if (windowWidth > 768) {
        $('#hide_publication').hide();
    }else{
        $('#hide_publication').css('transform','');
    }
});

// delete publications
$(document).on('click','[id^="delete_publication_"]',function(){
    id = $(this).attr("id").split("_")[2];
    var idPub = $('#id_pub_'+id).val();
    var pubTail = $('#publication_tail_'+id).val();
    $('#id_publication_delete').val(idPub);
    $('#publication_tail_delete').val(pubTail);
    $("body").addClass('body-after');
    if (windowWidth > 768) {
        $('#delete_publication').show();
    }else{
        $('#delete_publication').css('transform','translateY(0)');
    }
});

$(document).on('click','#delete_pub_button',function(){
    var fd = new FormData();
    var idPub = $('#id_publication_delete').val();
    fd.append('id_pub',idPub);
    var pubTail = $('#publication_tail_delete').val();
    $.ajax({
        url: 'delete-publication.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        success: function(response){
            if(response != 0){
                $("body").removeClass('body-after');
                if (windowWidth > 768) {
                    $('#delete_publication').hide();
                }else{
                    $('#delete_publication').css('transform','');
                }
                $('#user_publication_'+pubTail).remove();
            }
        }
    });
});

$(document).on('click','#cancel_delete_publication',function(e){
    e.stopPropagation();
    $("body").removeClass('body-after');
    if (windowWidth > 768) {
        $('#delete_publication').hide();
    }else{
        $('#delete_publication').css('transform','');
    }
});

$(document).on('click','#cancel_delete_pub_button',function(e){
    e.stopPropagation();
    $("body").removeClass('body-after');
    if (windowWidth > 768) {
        $('#delete_publication').hide();
    }else{
        $('#delete_publication').css('transform','');
    }
});

$('#delete_publication').click(function(e){
    $("body").removeClass('body-after');
    if (windowWidth > 768) {
        $('#delete_publication').hide();
    }else{
        $('#delete_publication').css('transform','');
    }
});

// save publications
$(document).on('click','[id^="save_publication_"]',function(){
    id = $(this).attr("id").split("_")[2];
    var idPub = $('#id_pub_'+id).val();
    $('#id_publication_save').val(idPub);
    $("body").addClass('body-after');
    if (windowWidth > 768) {
        $('#save_publication').show();
    }else{
        $('#save_publication').css('transform','translateY(0)');
    }
});

$(document).on('click','#save_pub_button',function(){
    var fd = new FormData();
    var idPub = $('#id_publication_save').val();
    fd.append('id_pub',idPub);
    $.ajax({
        url: 'save-publications.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        success: function(response){
            if(response != 0){
                $("body").removeClass('body-after');
                if (windowWidth > 768) {
                    $('#save_publication').hide();
                }else{
                    $('#save_publication').css('transform','');
                }
            }
        }
    });
});

$(document).on('click','#cancel_save_publication',function(e){
    e.stopPropagation();
    $("body").removeClass('body-after');
    if (windowWidth > 768) {
        $('#save_publication').hide();
    }else{
        $('#save_publication').css('transform','');
    }
});

$(document).on('click','#cancel_save_pub_button',function(e){
    e.stopPropagation();
    $("body").removeClass('body-after');
    if (windowWidth > 768) {
        $('#save_publication').hide();
    }else{
        $('#save_publication').css('transform','');
    }
});

$('#save_publication').click(function(e){
    $("body").removeClass('body-after');
    if (windowWidth > 768) {
        $('#save_publication').hide();
    }else{
        $('#save_publication').css('transform','');
    }
});

// create boutique
$('#create_btq_button').click(function(){
    console.log('click');
    $.ajax({
        url: 'pre-create-boutique.php',
        type: 'post',
        success: function(response){
            if(response != 0){
                $('#id_boutique').val(response);
                hideCreatePublication();
                if (windowWidth > 768) {
                    $("body").addClass('body-after');
                    $('#create_boutique').show();
                }
                else{
                    $('#create_boutique').css('transform','translateX(0)');
                }
            }   
        }
    });
})

$('#cancel_create_boutique_resp').click(function(){
    var fd= new FormData();
    var idBtq = $('#id_boutique').val();
    fd.append('id_btq',idBtq);
    $.ajax({
        url: 'pre-delete-boutique.php',
        type: 'post',
        data: fd,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(response){
            if(response != 0){
                createPublication[1].style.transform = "";
                $('#nom_boutique').val("");
                $('#categorie_boutique').val("");
                $('#sous_categorie_boutique').val("");
                $('#ville_boutique').val("");
                $('.create-boutique-bottom #commune_boutique').val("");
                $('#adresse_boutique').val("");
                $('#email_boutique').val("");
                $('#tlph_boutique').val("");

                $('#nom_boutique').css("border","");
                $('#categorie_boutique').css("border","");
                $('#sous_categorie_boutique').css("border","");
                $('#ville_boutique').css("border","");
                $('.create-boutique-bottom #commune_boutique').css("border","");
                $('#adresse_boutique').css("border","");
                $('#email_boutique').css("border","");
                $('#tlph_boutique').css("border","");
            }    
        }
    });
})

$('#cancel_create_boutique').click(function(){
    var fd = new FormData();
    var idBtq = $('#id_boutique').val();
    fd.append('id_btq',idBtq);
    $.ajax({
        url: 'pre-delete-boutique.php',
        type: 'post',
        data: fd,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(response){
            if(response != 0){
                $("body").removeClass('body-after');
                createPublication[1].style.display = "";
                $('#nom_boutique').val("");
                $('#categorie_boutique').val("");
                $('#sous_categorie_boutique').val("");
                $('#ville_boutique').val("");
                $('.create-boutique-bottom #commune_boutique').val("");
                $('#adresse_boutique').val("");
                $('#email_boutique').val("");
                $('#tlph_boutique').val("");

                $('#nom_boutique').css("border","");
                $('#categorie_boutique').css("border","");
                $('#sous_categorie_boutique').css("border","");
                $('#ville_boutique').css("border","");
                $('.create-boutique-bottom #commune_boutique').css("border","");
                $('#adresse_boutique').css("border","");
                $('#email_boutique').css("border","");
                $('#tlph_boutique').css("border","");
                // $('.create-publication-container').css({'top':'','transform':''});
            }    
        }
    });
})

$('#create_boutique').click(function(){
    $.ajax({
        url: 'pre-delete-boutique.php',
        type: 'post',
        success: function(response){
            if(response != 0){
                $("body").removeClass('body-after');
                $('#create_boutique').hide();
                $('#nom_boutique').val("");
                $('#categorie_boutique').val("");
                $('#sous_categorie_boutique').val("");
                $('#ville_boutique').val("");
                $('.create-boutique-bottom #commune_boutique').val("");
                $('#adresse_boutique').val("");
                $('#email_boutique').val("");
                $('#tlph_boutique').val("");

                $('#nom_boutique').css("border","");
                $('#categorie_boutique').css("border","");
                $('#sous_categorie_boutique').css("border","");
                $('#ville_boutique').css("border","");
                $('.create-boutique-bottom #commune_boutique').css("border","");
                $('#adresse_boutique').css("border","");
                $('#email_boutique').css("border","");
                $('#tlph_boutique').css("border","");
                // $('.create-publication-container').css({'top':'','transform':''});
            }    
        }
    });
})

$(document).on('focus','.create-boutique-bottom input',function(){
    var id = $(this).attr('id');
    if (id == 'nom_boutique') {
        $('.nom-btq').addClass('active-create-btq-span');
    }
    if (id == 'sous_categorie_boutique') {
        $('.sous-categorie-btq').addClass('active-create-btq-span');
    }
    if (id == 'adresse_boutique') {
        $('.adresse-btq').addClass('active-create-btq-span');
    }
    if (id == 'email_boutique') {
        $('.email-btq').addClass('active-create-btq-span');
    }
    if (id == 'tlph_boutique') {
        $('.tlph-btq').addClass('active-create-btq-span');
    }
})

$('#ville_boutique').on('change',function() {
    var ville  = $(this).val();
    if (ville !== '') {
        $('.commune-boutique').load('commune-boutique.php?v='+ville);
    }
})

$('#categorie_boutique').on('change',function() {
    var categorie  = $(this).val();
    if (categorie !== '') {
        $('.sous-categorie-boutique').load('categorie.php?c='+categorie);
    }
})

$(document).on('change','#sous_categorie_boutique',function() {
    var profession = $(this).val();
    if ($('.sous-categorie-autre').is(':visible')) {}
    else {
        if (profession == 'autre') {
            $('.sous-categorie-autre').show(); 
        }
        else {
            $('.sous-categorie-autre').hide();
        }
    }
})

$('#create_boutique_button').click(function(event){
    // event.preventDefault(); 
    var idBtq = $('#id_boutique').val();
    var nomBoutique = $('#nom_boutique').val();
    var categorieBoutique = $('#categorie_boutique').val();
    var sousCategorieBoutique = $('#sous_categorie_boutique').val();
    var villeBoutique = $('#ville_boutique').val();
    var communeBoutique = $('#commune_boutique').val();
    var adresseBoutique = $('#adresse_boutique').val();
    var emailBoutique = $('#email_boutique').val();
    var tlphBoutique = $('#tlph_boutique').val();
    
    if (nomBoutique == '') {
        $('#nom_boutique').css("border","2px solid red");
    }
    else if (categorieBoutique == '') {
        $('#nom_boutique').css("border","");
        $('#categorie_boutique').css("border","2px solid red");
    }
    else if (sousCategorieBoutique == '') {
        $('#nom_boutique').css("border","");
        $('#categorie_boutique').css("border","");
        $('#sous_categorie_boutique').css("border","2px solid red");
    }
    else if (villeBoutique == '') {
        $('#nom_boutique').css("border","");
        $('#categorie_boutique').css("border","");
        $('#sous_categorie_boutique').css("border","");
        $('#ville_boutique').css("border","2px solid red");
    }
    else if (communeBoutique == '') {
        $('#nom_boutique').css("border","");
        $('#categorie_boutique').css("border","");
        $('#sous_categorie_boutique').css("border","");
        $('#ville_boutique').css("border","");
        $('.create-boutique-bottom #commune_boutique').css("border","2px solid red");
    }
    else if (adresseBoutique == '') {
        $('#nom_boutique').css("border","");
        $('#categorie_boutique').css("border","");
        $('#sous_categorie_boutique').css("border","");
        $('#ville_boutique').css("border","");
        $('.create-boutique-bottom #commune_boutique').css("border","");
        $('#adresse_boutique').css("border","2px solid red");
    }
    else if (emailBoutique !== '' && !validateEmail(emailBoutique)) {
        $('#nom_boutique').css("border","");
        $('#categorie_boutique').css("border","");
        $('#sous_categorie_boutique').css("border","");
        $('#ville_boutique').css("border","");
        $('.create-boutique-bottom #commune_boutique').css("border","");
        $('#adresse_boutique').css("border","");
        $('#email_boutique').css("border","2px solid red");
    }
    else if (tlphBoutique !== '' && !validatePhone(tlphBoutique)) {
        $('#nom_boutique').css("border","");
        $('#categorie_boutique').css("border","");
        $('#sous_categorie_boutique').css("border","");
        $('#ville_boutique').css("border","");
        $('.create-boutique-bottom #commune_boutique').css("border","");
        $('#adresse_boutique').css("border","");
        $('#email_boutique').css("border","");
        $('#tlph_boutique').css("border","2px solid red");
    }
    else if (nomBoutique != '' && categorieBoutique != '' &&
        sousCategorieBoutique != '' && villeBoutique != '' && 
        communeBoutique != '' && adresseBoutique != '') {
        $('#tlph_boutique').css("border","");
        var fd = new FormData();
        fd.append('id_btq',idBtq);
        fd.append('nom_btq',nomBoutique);
        fd.append('categorie',categorieBoutique);
        fd.append('sous_categorie',sousCategorieBoutique);
        fd.append('ville_btq',villeBoutique);
        fd.append('commune_btq',communeBoutique);
        fd.append('adresse_btq',adresseBoutique);
        fd.append('email_btq',emailBoutique);
        fd.append('tlph_btq',tlphBoutique);
        $.ajax({
            url: 'create-boutique.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            beforeSend: function(){
                $("#loader_create_btq").show();
                $('#create_boutique').css('opacity','0.5');
            },
            success: function(response){
                if(response != 0){
                    window.location = 'gerer-boutique/'+response;
                }else{
                    alert('err');
                }
            },
            complete: function(){
                $("#loader_create_btq").hide();
                $('#create_boutique').css('opacity','');
            }
        });
    }
})

$('#create_boutique_button_resp').click(function(event){
    // event.preventDefault(); 
    var idBtq = $('#id_boutique').val();
    var nomBoutique = $('#nom_boutique').val();
    var categorieBoutique = $('#categorie_boutique').val();
    var sousCategorieBoutique = $('#sous_categorie_boutique').val();
    var villeBoutique = $('#ville_boutique').val();
    var communeBoutique = $('#commune_boutique').val();
    var adresseBoutique = $('#adresse_boutique').val();
    var emailBoutique = $('#email_boutique').val();
    var tlphBoutique = $('#tlph_boutique').val();
    
    if (nomBoutique == '') {
        $('#nom_boutique').css("border","2px solid red");
    }
    else if (categorieBoutique == '') {
        $('#nom_boutique').css("border","");
        $('#categorie_boutique').css("border","2px solid red");
    }
    else if (sousCategorieBoutique == '') {
        $('#nom_boutique').css("border","");
        $('#categorie_boutique').css("border","");
        $('#sous_categorie_boutique').css("border","2px solid red");
    }
    else if (villeBoutique == '') {
        $('#nom_boutique').css("border","");
        $('#categorie_boutique').css("border","");
        $('#sous_categorie_boutique').css("border","");
        $('#ville_boutique').css("border","2px solid red");
    }
    else if (communeBoutique == '') {
        $('#nom_boutique').css("border","");
        $('#categorie_boutique').css("border","");
        $('#sous_categorie_boutique').css("border","");
        $('#ville_boutique').css("border","");
        $('.create-boutique-bottom #commune_boutique').css("border","2px solid red");
    }
    else if (adresseBoutique == '') {
        $('#nom_boutique').css("border","");
        $('#categorie_boutique').css("border","");
        $('#sous_categorie_boutique').css("border","");
        $('#ville_boutique').css("border","");
        $('.create-boutique-bottom #commune_boutique').css("border","");
        $('#adresse_boutique').css("border","2px solid red");
    }
    else if (emailBoutique !== '' && !validateEmail(emailBoutique)) {
        $('#nom_boutique').css("border","");
        $('#categorie_boutique').css("border","");
        $('#sous_categorie_boutique').css("border","");
        $('#ville_boutique').css("border","");
        $('.create-boutique-bottom #commune_boutique').css("border","");
        $('#adresse_boutique').css("border","");
        $('#email_boutique').css("border","2px solid red");
    }
    else if (tlphBoutique !== '' && !validatePhone(tlphBoutique)) {
        $('#nom_boutique').css("border","");
        $('#categorie_boutique').css("border","");
        $('#sous_categorie_boutique').css("border","");
        $('#ville_boutique').css("border","");
        $('.create-boutique-bottom #commune_boutique').css("border","");
        $('#adresse_boutique').css("border","");
        $('#email_boutique').css("border","");
        $('#tlph_boutique').css("border","2px solid red");
    }
    else if (nomBoutique != '' && categorieBoutique != '' &&
        sousCategorieBoutique != '' && villeBoutique != '' && 
        communeBoutique != '' && adresseBoutique != '') {
        $('#tlph_boutique').css("border","");
        
        var fd = new FormData();
        fd.append('id_btq',idBtq);
        fd.append('nom_btq',nomBoutique);
        fd.append('categorie',categorieBoutique);
        fd.append('sous_categorie',sousCategorieBoutique);
        fd.append('ville_btq',villeBoutique);
        fd.append('commune_btq',communeBoutique);
        fd.append('adresse_btq',adresseBoutique);
        fd.append('email_btq',emailBoutique);
        fd.append('tlph_btq',tlphBoutique);

        $.ajax({
            url: 'create-boutique.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                if(response != 0){
                    if (windowWidth > 768) {
                        window.location = 'gerer-boutique.php?btq='+response;
                    }
                    else{
                        $('#create_boutique').css('transform','');
                        setTimeout(() => {
                            window.location = 'gerer-boutique.php?btq='+response;
                        }, 300);
                    }
                }else{
                    alert('err');
                }
            },
        });
    }
})

// create boutdechantier product
$('#create_bt_prd_button').click(function(){
    $.ajax({
        url: 'pre-create-bt-product.php',
        type: 'post',
        success: function(response){
            console.log(response);
            if(response != 0){
                $('#id_bt_prd').val(response);
                hideCreatePublication();
                if (windowWidth > 768) {
                    $("body").addClass('body-after');
                    $('#create_bt_product').show();
                }
                else{
                    $('#create_bt_product').css('transform','translateX(0)');
                }
            }   
        }
    });
})

$('#cancel_create_bt_prd_resp').click(function(){
    var fd= new FormData();
    var idPrd= $('#id_bt_prd').val();
    fd.append('id_prd',idPrd);
    $.ajax({
        url: 'pre-delete-bt-prd.php',
        type: 'post',
        data: fd,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(response){
            if(response != 0){
                $("body").removeClass('body-after');
                createPublication[2].style.transform = "";
                $('#lieu-bt-prd').val("");
                $('#name-bt-prd').val("");
                $('#categorie_bt_prd').val("");
                $('#description_bt_prd').val("");
                $('#quantity_bt_prd').val("0");
                $('#price_bt_prd').val("0");

                $('#lieu-bt-prd').css("border","");
                $('#name-bt-prd').css("border","");
                $('#categorie_bt_prd').css("border","");
                $('#description_bt_prd').css("border","");
                $('#quantity_bt_prd').css("border","");
                $('#price_bt_prd').css("border","");

                $('.bt-product-input span').removeClass('active-create-bt-prd-span');
            }    
        }
    });
})

$('#cancel_create_bt_prd').click(function(){
    var fd= new FormData();
    var idPrd= $('#id_bt_prd').val();
    fd.append('id_prd',idPrd);
    $.ajax({
        url: 'pre-delete-bt-prd.php',
        type: 'post',
        data: fd,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(response){
            if(response != 0){
                $("body").removeClass('body-after');
                createPublication[2].style.display = "";
                $('#lieu-bt-prd').val("");
                $('#name-bt-prd').val("");
                $('#categorie_bt_prd').val("");
                $('#description_bt_prd').val("");
                $('#quantity_bt_prd').val("0");
                $('#price_bt_prd').val("0");

                $('#lieu-bt-prd').css("border","");
                $('#name-bt-prd').css("border","");
                $('#categorie_bt_prd').css("border","");
                $('#description_bt_prd').css("border","");
                $('#quantity_bt_prd').css("border","");
                $('#price_bt_prd').css("border","");

                $('.bt-product-input span').removeClass('active-create-bt-prd-span');
            }    
        }
    });
})

$('#create_bt_product').click(function(){
    var fd= new FormData();
    var idPrd= $('#id_bt_prd').val();
    fd.append('id_prd',idPrd);
    $.ajax({
        url: 'pre-delete-bt-prd.php',
        type: 'post',
        data: fd,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(response){
            if(response != 0){
                $("body").removeClass('body-after');
                createPublication[2].style.display = "";
                $('#lieu-bt-prd').val("");
                $('#name-bt-prd').val("");
                $('#categorie_bt_prd').val("");
                $('#description_bt_prd').val("");
                $('#quantity_bt_prd').val("0");
                $('#price_bt_prd').val("0");

                $('#lieu-bt-prd').css("border","");
                $('#name-bt-prd').css("border","");
                $('#categorie_bt_prd').css("border","");
                $('#description_bt_prd').css("border","");
                $('#quantity_bt_prd').css("border","");
                $('#price_bt_prd').css("border","");

                $('.bt-product-input span').removeClass('active-create-bt-prd-span');
            }    
        }
    });
})

$(document).on('focus','.create-publication-bottom input',function(){
    var id = $(this).attr('id');
    if (id == 'lieu_bt_prd') {
        $('.lieu-bt-prd').addClass('active-create-bt-prd-span');
    }
    if (id == 'name_bt_prd') {
        $('.name-bt-prd').addClass('active-create-bt-prd-span');
    }
    if (id == 'categorie_bt_prd') {
        $('.categorie-bt-prd').addClass('active-create-bt-prd-span');
    }
    if (id == 'description_bt_prd') {
        $('.description-bt-prd').addClass('active-create-bt-prd-span');
    }
})

$("#lieu_bt_prd").on('keyup',function(){
    var locationText = document.getElementById("lieu_bt_prd");
    var filter = locationText.value.toUpperCase();
    var location = document.querySelectorAll("#bt_prd_location_item p");
    var locationItem= document.querySelectorAll("#bt_prd_location_item");
    for (let i = 0; i < locationItem.length; i++) {
        txtValue = location[i].textContent || location[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            locationItem[i].style.display = "";
            $('.bt-prd-preview-location').css('display','initial');
        } else {
            locationItem[i].style.display = "none";
        }
    }
    if ($(this).val() == '') {
        $('.bt-prd-preview-location').css('display','');
    }
});

var locationPrdItem = document.querySelectorAll("#bt_prd_location_item");
var locationPrdName = document.querySelector("#lieu_bt_prd");
var locationPrdText = document.querySelectorAll("#bt_prd_location_item p");

for (let i = 0; i < locationPrdItem.length; i++) {
    locationPrdItem[i].addEventListener('click',()=>{
        $('.bt-prd-preview-location').css('display','');
        locationPrdName.value = locationPrdText[i].textContent;
    });
}

 // upload product image 
$('#add_bt_product_image').click(function(){
    $('#image_bt_prd').click();
});

$('#image_bt_prd').click(function(e){
    e.stopPropagation();
});

$('#image_bt_prd').on('change', function () { 
    $('#add_bt_product_image_button').click();
});

$('#add_bt_product_image_button').click(function(){
    var form_data = new FormData();
    var idPrd = $('#id_bt_prd').val();
    form_data.append('id_prd',idPrd);
    var totalfiles = document.getElementById('image_bt_prd').files.length;
    for (let i = 0; i < totalfiles; i++) {
        form_data.append("images[]", document.getElementById('image_bt_prd').files[i]);
    }
    $.ajax({
        url: 'upload-images-bt-product.php', 
        type: 'post',
        data: form_data,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function (response) {
            if (windowWidth > 768) {
                $('.create-publication-container').css({'top':'10px','transform':'translate(-50%,0%)'});
            }
            for(let i = 0; i < response.length; i++) {
                var src = response[i];
                $('.bt-product-images-preview').append("<div class='bt-product-image-preview' id='bt_product_image_preview_"+i+"'><div id='bt_product_delete_preview_"+i+"'><i class='fas fa-times'></i></div><img src='"+src+"'></div>");
            }
        }
    });
});

// remove product image preview
$('.bt-product-images-preview').on('click','[id^="bt_product_delete_preview_"]',function(){
    var id = $(this).attr("id").split("_")[4];
    var fd = new FormData();
    var idPrd = $('#id_bt_prd').val();
    fd.append('id_prd',idPrd);
    var mediaUrl = $('#bt_product_image_preview_'+id+' img').attr('src');
    fd.append('media_url',mediaUrl);
    $.ajax({
        url: 'delete-image-bt-product-preview.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        success: function(response){
            if(response != 0){
                $('#bt_product_image_preview_'+id).remove();
            }
        }
    });
});

// valide create product boutdechantier
$('#create_bt_product_button').click(function(){
    var idPrd = $('#id_bt_prd').val();
    var lieuPrd = $('#lieu_bt_prd').val();
    var namePrd = $('#name_bt_prd').val();
    var categoriePrd = $('#categorie_bt_prd').val();
    var descriptionPrd = $('#description_bt_prd').val(); 
    var quantityPrd = $('#quantity_bt_prd').val();
    var typePrd = $('#type_bt_prd').val();
    var pricePrd = $('#price_bt_prd').val();

    if (lieuPrd == ''){
        $('#lieu-bt-prd').css('border','2px solid red');
    }
    else if (namePrd == ''){
        $('#lieu-bt-prd').css('border','');
        $('#name_product').css('border','2px solid red');
    }
    else if(descriptionPrd == ''){
        $('#lieu-bt-prd').css('border','');
        $('#name-bt-prd').css('border','');
        // $('#categorie-bt-prd').css('border','');
        $('#description-bt-prd').css('border','2px solid red');
    }
    // else if(categoriePrd == ''){
    //     $('#lieu-bt-prd').css('border','');
    //     $('#name_product').css('border','');
    //     $('#categorie_product').css('border','2px solid red');
    // }
    else if(quantityPrd == ''){
        $('#lieu-bt-prd').css('border','');
        $('#name-bt-prd').css('border','');
        // $('#categorie-bt-prd').css('border','');
        $('#description-bt-prd').css('border','');
        $('#quantity_bt_prd').css('border','2px solid red');
    }
    // else if(typePrd == ''){
    //     $('#lieu-bt-prd').css('border','');
    //     $('#name-bt-prd').css('border','');
    //     // $('#categorie-bt-prd').css('border','');
    //     $('#description-bt-prd').css('border','');
    //     $('#quantity_bt_prd').css('border','');
    //     $('#type_bt_prd').css('border','2px solid red');
    // }
    else if(pricePrd == ''){
        $('#lieu-bt-prd').css('border','');
        $('#name-bt-prd').css('border','');
        // $('#categorie-bt-prd').css('border','');
        $('#description-bt-prd').css('border','');
        $('#quantity_bt_prd').css('border','');
        // $('#type_bt_prd').css('border','');
        $('#price-bt-prd').css('border','2px solid red');
    }
    else if(lieuPrd != '' && namePrd != '' && descriptionPrd != '' &&
            quantityPrd != '' && pricePrd != ''){
        $('#price-bt-prd').css('border','');
        var fd = new FormData();
        fd.append('id_prd',idPrd);
        fd.append('lieu_prd',lieuPrd);
        fd.append('nom_prd',namePrd);
        fd.append('categorie_prd',categoriePrd);
        fd.append('description_prd',descriptionPrd);
        fd.append('quantity_prd',quantityPrd);
        fd.append('type_prd',typePrd);
        fd.append('price_prd',pricePrd);
        $.ajax({
            url: 'create-bt-product.php',
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
                    console.log(response);
                }
            },
            complete: function(){
                $("#loader_load").hide();
                createPublication[2].style.display = "";
                $("body").removeClass('body-after');
                $('.create-product-container').css({'top':'','transform':''});
                $('.create-product-top').show();
                $('.create-product-bottom').show();
                $('#name_bt_prd').val('');
                $('#lieu_bt_prd').val('');
                $('#categorie_bt_prd').val('');
                $('#description_bt_prd').val('');
                $('#quantity_bt_prd').val('');
                $('#price_bt_prd').val('');
                $('.bt-product-images-preview').empty();
            }
        });
    }
});

$('#create_bt_product_button_resp').click(function(){
    var idPrd = $('#id_bt_prd').val();
    var lieuPrd = $('#lieu_bt_prd').val();
    var namePrd = $('#name_bt_prd').val();
    var categoriePrd = $('#categorie_bt_prd').val();
    var descriptionPrd = $('#description_bt_prd').val(); 
    var quantityPrd = $('#quantity_bt_prd').val();
    var typePrd = $('#type_bt_prd').val();
    var pricePrd = $('#price_bt_prd').val();

    if (lieuPrd == ''){
        $('#lieu-bt-prd').css('border','2px solid red');
    }
    else if (namePrd == ''){
        $('#lieu-bt-prd').css('border','');
        $('#name_product').css('border','2px solid red');
    }
    else if(descriptionPrd == ''){
        $('#lieu-bt-prd').css('border','');
        $('#name-bt-prd').css('border','');
        // $('#categorie-bt-prd').css('border','');
        $('#description-bt-prd').css('border','2px solid red');
    }
    // else if(categoriePrd == ''){
    //     $('#lieu-bt-prd').css('border','');
    //     $('#name_product').css('border','');
    //     $('#categorie_product').css('border','2px solid red');
    // }
    else if(quantityPrd == ''){
        $('#lieu-bt-prd').css('border','');
        $('#name-bt-prd').css('border','');
        // $('#categorie-bt-prd').css('border','');
        $('#description-bt-prd').css('border','');
        $('#quantity_bt_prd').css('border','2px solid red');
    }
    // else if(typePrd == ''){
    //     $('#lieu-bt-prd').css('border','');
    //     $('#name-bt-prd').css('border','');
    //     // $('#categorie-bt-prd').css('border','');
    //     $('#description-bt-prd').css('border','');
    //     $('#quantity_bt_prd').css('border','');
    //     $('#type_bt_prd').css('border','2px solid red');
    // }
    else if(pricePrd == ''){
        $('#lieu-bt-prd').css('border','');
        $('#name-bt-prd').css('border','');
        // $('#categorie-bt-prd').css('border','');
        $('#description-bt-prd').css('border','');
        $('#quantity_bt_prd').css('border','');
        // $('#type_bt_prd').css('border','');
        $('#price-bt-prd').css('border','2px solid red');
    }
    else if(lieuPrd != '' && namePrd != '' && descriptionPrd != '' &&
            quantityPrd != '' && pricePrd != ''){
        $('#price-bt-prd').css('border','');
        var fd = new FormData();
        fd.append('id_prd',idPrd);
        fd.append('lieu_prd',lieuPrd);
        fd.append('nom_prd',namePrd);
        fd.append('categorie_prd',categoriePrd);
        fd.append('description_prd',descriptionPrd);
        fd.append('quantity_prd',quantityPrd);
        fd.append('type_prd',typePrd);
        fd.append('price_prd',pricePrd);
        $.ajax({
            url: 'create-bt-product.php',
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
                    console.log(response);
                }
            },
            complete: function(){
                $("#loader_load").hide();
                createPublication[2].style.display = "";
                $("body").removeClass('body-after');
                $('.create-product-container').css({'top':'','transform':''});
                $('.create-product-top').show();
                $('.create-product-bottom').show();
                $('#name_bt_prd').val('');
                $('#lieu_bt_prd').val('');
                $('#categorie_bt_prd').val('');
                $('#description_bt_prd').val('');
                $('#quantity_bt_prd').val('');
                $('#price_bt_prd').val('');
                $('.bt-product-images-preview').empty();
            }
        });
    }
});

// create promotion
$('#create_promotion_button').click(function(){
    $.ajax({
        url: 'pre-create-promotion.php',
        type: 'post',
        beforeSend: function(){
            hideCreatePublication();
            if (windowWidth > 768) {
                $("body").addClass('body-after');
                $('#create_promotion').show();
            }
            else{
                $('#create_promotion').css('transform','translateX(0)');
            }
            $("#loader_create_promotion").show();
        },
        success: function(response){
            if(response != 0){
                $('#create_global_promotion_container').prepend(response);
            }   
        },
        complete: function(){
            $("#loader_create_promotion").hide();
        }
    });
})

$('#create_global_promotion_container').click(function(e){
    e.stopPropagation();
})

$('#create_global_promotion_container').on('click','#cancel_create_promotion',function(){
    cancelCreatePromotion ();
})

$('#create_promotion').click(function(){
    cancelCreatePromotion ();
})

function cancelCreatePromotion () {
    var fd = new FormData();
    var idPrm = $('#id_promotion').val();
    fd.append('id_prm',idPrm);
    $.ajax({
        url: 'pre-delete-promotion.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('#create_global_promotion_container').empty();
            $("#loader_create_promotion").show();
        },
        success: function(response){
            if(response != 0){
                if (windowWidth > 768) {
                    $("body").removeClass('body-after');
                    $('#create_promotion').hide();
                }
                else{
                    $('#create_promotion').css('transform','');
                }
            }    
        },
        complete: function(){
            $("#loader_create_promotion").hide();
        }
    });
}

$(document).on('focus','.create-publication-bottom input',function(){
    var id = $(this).attr('id');
    if (id == 'titre_prm') {
        $('.titre-prm').addClass('active-promotion-span');
    }
    if (id == 'adresse_prm') {
        $('.adresse-prm').addClass('active-promotion-span');
    }
    if (id == 'name_prm_prd') {
        $('.name-prm-prd').addClass('active-promotion-span');
    }
    if (id == 'reference_prm_prd' || id == 'updt_reference_prm_prd') {
        $('.reference-prm-prd').addClass('active-promotion-span');
    }
    if (id == 'fonctionality_prm_prd' || id == 'updt_fonctionality_prm_prd') {
        $('.fonctionality-prm-prd').addClass('active-promotion-span');
    }
    if (id == 'caracteristic_prm_prd' || id == 'updt_caracteristic_prm_prd') {
        $('.caracteristic-prm-prd').addClass('active-promotion-span');
    }
    if (id == 'avantage_prm_prd' || id == 'updt_avantage_prm_prd') {
        $('.avantage-prm-prd').addClass('active-promotion-span');
    }
})

$(document).on('focus','.create-publication-bottom textarea',function(){
    var id = $(this).attr('id');
    if (id == 'description_prm' || id == 'updt_description_prm') {
        $('.description-prm').addClass('active-promotion-span');
    }
    if (id == 'description_prm_prd' || id == 'updt_description_prm_prd') {
        $('.description-prm-prd').addClass('active-promotion-span');
    }
})

// select promotion ville and commune
$("#create_global_promotion_container").on('change','#ville_promotion',function() {
    var ville  = $(this).val();
    if (ville !== '') {
        $('.commune-promotion').load('commune-promotion.php?v='+ville);
    }
})

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(getPosition, showError);
    } else { 
        $('.promotion-localisation-gps p').text("La geolocation ne support pas cette navigateur.");
        $('.update-promotion-localisation-gps p').text("La geolocation ne support pas cette navigateur.");
    }
}

function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
        $('.promotion-localisation-gps p').text("User denied the request for Geolocation.")
        break;
        case error.POSITION_UNAVAILABLE:
        $('.promotion-localisation-gps p').text("Location information is unavailable.")
        break;
        case error.TIMEOUT:
        $('.promotion-localisation-gps p').text("The request to get user location timed out.")
        break;
        case error.UNKNOWN_ERROR:
        $('.promotion-localisation-gps p').text("An unknown error occurred.")
        break;
    }
}

function getPosition(position) {
    var latitudePrm = position.coords.latitude;
    var longitudePrm = position.coords.longitude;
    $('#latitude_prm').val(latitudePrm);
    $('#longitude_prm').val(longitudePrm);
    $('.promotion-localisation-gps p').text('La position a été bien ajoutée');
    $('.promotion-localisation-gps button').text('Ajoutée');

    $('#updt_latitude_prm').val(latitudePrm);
    $('#updt_longitude_prm').val(longitudePrm);
    $('.update-promotion-localisation-gps p').text('La position a été bien modifiée');
    $('.update-promotion-localisation-gps button').text('modifiée');
}

$("#create_global_promotion_container").on('change','#categorie_prm',function() {
    var categorie  = $(this).val();
    if (categorie !== '') {
        $('.sous-categorie-promotion').load('categorie-promotion.php?c='+categorie);
    }
})

$(document).on('change','#sous_categorie_prm',function() {
    var profession = $(this).val();
    if (profession == 'autre') {
        $('.sous-categorie-promotion').hide(); 
        $('.sous-categorie-autre').show(); 
    }
})

// upload promotion image 
$("#create_global_promotion_container").on('click','#add_promotion_image',function(){
    $('#image_promotion').val('');
    $('#image_promotion').click();
});

$("#create_global_promotion_container").on('click','#image_promotion',function(e){
    e.stopPropagation();
});

$("#create_global_promotion_container").on('change','#image_promotion',function () { 
    $('#add_promotion_image_button').click();
});

// add image promotion
$("#create_global_promotion_container").on('click','#add_promotion_image_button',function(){
    var idPrm = $('#id_promotion').val();
    var imgPrm = $('#image_promotion')[0].files[0];
    var form_data = new FormData();
    form_data.append('id_prm',idPrm);
    form_data.append('image',imgPrm);
    $.ajax({
        url: 'upload-images-promotion.php', 
        type: 'post',
        data: form_data,
        dataType: 'json',
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('.create-promotion-options').hide();
            $('.promotion-images-preview').show();
            $('.promotion-images-preview').append("<div id='loader_promotion_image' class='center'></div>");
        },
        success: function (response) {
            $('.promotion-images-preview').append("<div class='promotion-image-preview' id='promotion_image_preview'><div id='promotion_delete_image_preview'><i class='fas fa-times'></i></div><img src='"+response+"'></div>");
        },
        complete: function(){
            $('#loader_promotion_image').remove();
        }
    });
});

// remove promotion image preview
$('#create_global_promotion_container').on('click','#promotion_delete_image_preview',function(){
    var idPrm = $('#id_promotion').val();
    var mediaUrl = $('#promotion_image_preview img').attr('src');
    var fd = new FormData();
    fd.append('id_prm',idPrm);
    fd.append('media_url',mediaUrl);
    $.ajax({
        url: 'delete-promotion-media.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('#promotion_image_preview').remove();
            $('.promotion-images-preview').append("<div id='loader_promotion_image' class='center'></div>");
        },
        success: function(response){
            if(response != 0){
                $('.promotion-images-preview').hide();
                $('.create-promotion-options').show();
            }
        },
        complete: function(){
            $('#loader_promotion_image').remove();
        }
    });
});

// add video promotion
$('#create_global_promotion_container').on('click','#add_promotion_video',function(){
    $('#video_promotion').val('');
    $('#video_promotion').click();
});

$('#create_global_promotion_container').on('click','#video_promotion',function(e){
    e.stopPropagation();
});

$('#create_global_promotion_container').on('change','#video_promotion',function () { 
    $('#add_promotion_video_button').click();
});

$('#create_global_promotion_container').on('click','#add_promotion_video_button',function(){
    var idPrm = $('#id_promotion').val();
    var videoPrm = $('#video_promotion')[0].files[0];
    var fd = new FormData();
    fd.append('id_prm',idPrm);
    fd.append('video',videoPrm);
    console.log('click');
    $.ajax({
        url: 'upload-video-promotion.php',
        type: 'post',
        data: fd,
        dataType: 'json',
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('.create-promotion-options').hide();
            $('.promotion-images-preview').show();
            $('.promotion-images-preview').append("<div id='loader_promotion_image' class='center'></div>");
        },
        success: function(response){
            $('.promotion-images-preview').append("<div class='promotion-video-preview' id='promotion_video_preview'><div id='promotion_delete_video_preview'><i class='fas fa-times'></i></div><video controls><source src='"+response+"'></video></div>");
        },
        complete: function(){
            $('#loader_promotion_image').remove();
        }
    });
});

// remove video promotion
$('#create_global_promotion_container').on('click','#promotion_delete_video_preview',function(){
    var idPrm = $('#id_promotion').val();
    var mediaUrl = $('#promotion_video_preview video source').attr('src');
    var fd = new FormData();
    fd.append('id_prm',idPrm);
    fd.append('media_url',mediaUrl);
    $.ajax({
        url: 'delete-promotion-media.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('#promotion_video_preview').remove();
            $('.promotion-images-preview').append("<div id='loader_promotion_image' class='center'></div>");
        },
        success: function(response){
            if(response != 0){
                $('.promotion-images-preview').hide();
                $('.create-promotion-options').show();
            }
        },
        complete: function(){
            $('#loader_promotion_image').remove();
        }
    });
});

$('#create_global_promotion_container').on('click','#next_create_promotion',function(){
    var idPrm = $('#id_promotion').val();
    var titrePrm = $('#titre_prm').val();
    var categoriePrm = $('#categorie_prm').val();
    var sousCategoriePrm = $('#sous_categorie_prm').val();
    var villePrm = $('#ville_promotion').val(); 
    var communePrm = $('#commune_promotion').val();
    var adressePrm = $('#adresse_prm').val();
    var latitudePrm = $('#latitude_prm').val();
    var longitudePrm = $('#longitude_prm').val();
    var dateDebutPrm = $('#date_debut_prm').val();
    var dateFinPrm = $('#date_fin_prm').val();
    var descriptionPrm = $('#description_prm').val();

    if ($('.promotion-images-preview').is(':empty')){
        $('.create-promotion-options').css('border','2px solid red');
    }
    else if (titrePrm == '') {
        $('.create-promotion-options').css('border','');
        $('#titre_prm').css('border','2px solid red');
    }
    else if (categoriePrm == '') {
        $('.create-promotion-options').css('border','');
        $('#titre_prm').css('border','');
        $('#categorie_prm').css('border','2px solid red');
    }
    else if (sousCategoriePrm == '') {
        $('.create-promotion-options').css('border','');
        $('#titre_prm').css('border','');
        $('#categorie_prm').css('border','');
        $('#sous_categorie_prm').css('border','2px solid red');
    }
    else if (villePrm == '') {
        $('.create-promotion-options').css('border','');
        $('#titre_prm').css('border','');
        $('#categorie_prm').css('border','');
        $('#sous_categorie_prm').css('border','');
        $('#ville_promotion').css('border','2px solid red');
    }
    else if (communePrm == '') {
        $('.create-promotion-options').css('border','');
        $('#titre_prm').css('border','');
        $('#categorie_prm').css('border','');
        $('#sous_categorie_prm').css('border','');
        $('#ville_promotion').css('border','');
        $('#commune_promotion').css('border','2px solid red');
    }
    else if (adressePrm == '') {
        $('.create-promotion-options').css('border','');
        $('#titre_prm').css('border','');
        $('#categorie_prm').css('border','');
        $('#sous_categorie_prm').css('border','');
        $('#ville_promotion').css('border','');
        $('#commune_promotion').css('border','');
        $('#adresse_prm').css('border','2px solid red');
    }
    else if (dateDebutPrm == '') {
        $('.create-promotion-options').css('border','');
        $('#titre_prm').css('border','');
        $('#categorie_prm').css('border','');
        $('#sous_categorie_prm').css('border','');
        $('#ville_promotion').css('border','');
        $('#commune_promotion').css('border','');
        $('#adresse_prm').css('border','');
        $('#date_debut_prm').css('border','2px solid red');
    }
    else if (dateFinPrm == '') {
        $('.create-promotion-options').css('border','');
        $('#titre_prm').css('border','');
        $('#categorie_prm').css('border','');
        $('#sous_categorie_prm').css('border','');
        $('#ville_promotion').css('border','');
        $('#commune_promotion').css('border','');
        $('#adresse_prm').css('border','');
        $('#date_debut_prm').css('border','');
        $('#date_fin_prm').css('border','2px solid red');
    }
    else if (descriptionPrm == '') {
        $('.create-promotion-options').css('border','');
        $('#titre_prm').css('border','');
        $('#categorie_prm').css('border','');
        $('#sous_categorie_prm').css('border','');
        $('#ville_promotion').css('border','');
        $('#commune_promotion').css('border','');
        $('#adresse_prm').css('border','');
        $('#date_debut_prm').css('border','');
        $('#date_fin_prm').css('border','');
        $('#description_prm').css('border','2px solid red');
    }
    else{
        $('#description_prm').css('border','');
        var fd = new FormData();
        fd.append('id_prm',idPrm);
        fd.append('titre_prm',titrePrm);
        fd.append('categorie_prm',categoriePrm);
        fd.append('sous_categorie_prm',sousCategoriePrm);
        fd.append('ville_promotion',villePrm);
        fd.append('commune_promotion',communePrm);
        fd.append('adresse_prm',adressePrm);
        fd.append('latitude_prm',latitudePrm);
        fd.append('longitude_prm',longitudePrm);
        fd.append('date_debut_prm',dateDebutPrm);
        fd.append('date_fin_prm',dateFinPrm);
        fd.append('description_prm',descriptionPrm);
        $.ajax({
            url: 'load-create-product-promotion.php',
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
                if(response != 0){
                    $('#create_promotion').scrollTop(0); 
                    $('#create_promotion_container').remove();
                    $('#create_global_promotion_container').prepend(response);
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
})

// create other promotion product
$('#create_global_promotion_container').on('click','#add_new_product_promotion',function(){
    var idPrm = $('#id_promotion').val();
    var idPrd = $('#id_promotion_product').val();
    var namePrd = $('#name_prm_prd').val();
    var referencePrd = $('#reference_prm_prd').val();
    var quantityPrd = $('#quantity_prm_prd').val();
    var oldPricePrd = $('#old_price_prm_prd').val();
    var newPricePrd = $('#new_price_prm_prd').val();
    var fonctionalityPrd = $('#fonctionality_prm_prd').val();
    var caracteristicPrd = $('#caracteristic_prm_prd').val();
    var avantagePrd = $('#avantage_prm_prd').val();
    var descriptionPrd = $('#description_prm_prd').val();
    if (namePrd == ''){
        $('#name_prm_prd').css('border','2px solid red');
    }
    else if (oldPricePrd == '0'){
        $('#name_prm_prd').css('border','');
        $('#old_price_prm_prd').css('border','2px solid red');
    }
    else if (newPricePrd == '0'){
        $('#name_prm_prd').css('border','');
        $('#old_price_prm_prd').css('border','');
        $('#new_price_prm_prd').css('border','2px solid red');
    }
    else if ($('.promotion-product-images-preview').is(':empty') && 
            $('.promotion-product-video-preview').is(':empty')){
        $('#name_prm_prd').css('border','');
        $('#old_price_prm_prd').css('border','');
        $('#new_price_prm_prd').css('border','');
        $('.create-promotion-product-options').css('border','2px solid red');
    }
    else{
        $('.create-promotion-product-options').css('border','');
        var fd = new FormData();
        fd.append('id_prm',idPrm);
        fd.append('id_prd',idPrd);
        fd.append('nom_prd',namePrd);
        fd.append('reference_prd',referencePrd);
        fd.append('quantite_prd',quantityPrd);
        fd.append('ancien_prix_prd',oldPricePrd);
        fd.append('nouveau_prix_prd',newPricePrd);
        fd.append('fonctionalites_prd',fonctionalityPrd);
        fd.append('caracteristiques_prd',caracteristicPrd);
        fd.append('avantages_prd',avantagePrd);
        fd.append('description_prd',descriptionPrd);
        $.ajax({
            url: 'add-new-product-promotion.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            beforeSend: function(){
                $('#create_promotion_product_container').remove();
                $("#loader_create_promotion").show();
            },
            success: function(response){
                if(response != 0){
                    $('#create_global_promotion_container').prepend(response);
                }    
            },
            complete: function(){
                $("#loader_create_promotion").hide();
            }
        });
    }
})

// choose create or select product promotion
// cancel product promotion overview
$('#create_global_promotion_container').on('click','#cancel_product_promotion_overview',function(){
    var idPrm = $('#id_promotion').val();
    var fd = new FormData();
    fd.append('id_prm',idPrm);
    $.ajax({
        url: 'create-new-product-promotion.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('#create_promotion_product_container').remove();
            $("#loader_create_promotion").show();
        },
        success: function(response){
            if(response != 0){
                $('#create_global_promotion_container').prepend(response);
            }
        },
        complete: function(){
            $("#loader_create_promotion").hide();
        }
    });
}) 

// delete product promotion overview
$('#create_global_promotion_container').on('click','#delete_product_promotion_overview',function(){
    var idPrd = $('#id_promotion_product').val();
    var idPrm = $('#id_promotion').val();
    var fd = new FormData();
    fd.append('id_prd',idPrd);
    fd.append('id_prm',idPrm);
    $.ajax({
        url: 'delete-promotion-product-overview.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('#create_promotion_product_container').remove();
            $("#loader_create_promotion").show();
        },
        success: function(response){
            if(response != 0){
                $('#create_global_promotion_container').prepend(response);
            }
        },
        complete: function(){
            $("#loader_create_promotion").hide();
        }
    });
}) 

// update product promotion overview
$('#create_global_promotion_container').on('click','[id^="product_promotion_overview_"]',function(){
    var id = $(this).attr("id").split("_")[3];
    var idPrd = $('#id_prd_ovrw_'+id).val();
    var idPrm = $('#id_promotion').val();
    var fd = new FormData();
    fd.append('id_prd',idPrd);
    fd.append('id_prm',idPrm);
    $.ajax({
        url: 'update-promotion-product-overview.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('#create_promotion_product_container').empty();
            $("#loader_create_promotion").show();
        },
        success: function(response){
            if(response != 0){
                $('#create_promotion_product_container').append(response);
            }
        },
        complete: function(){
            $("#loader_create_promotion").hide();
        }
    });
}) 

// update product boutique promotion overview
$('#create_global_promotion_container').on('click','[id^="product_boutique_promotion_overview_"]',function(){
    var id = $(this).attr("id").split("_")[4];
    var idPrm = $('#id_promotion').val();
    var idPrd = $('#id_prd_btq_ovrw_'+id).val();
    var idBtq = $('#id_btq_prd_ovrw_'+id).val();
    var fd = new FormData();
    fd.append('id_prm',idPrm);
    fd.append('id_prd',idPrd);
    fd.append('id_btq',idBtq);
    $.ajax({
        url: 'load-product-boutique-promotion-details.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('#create_promotion_product_bottom_container').empty();
            $("#loader_create_promotion_product_bottom").show();
        },
        success: function(response){
            if(response != 0){
                $('#create_promotion_product_bottom_container').append(response);
            }
        },
        complete: function(){
            $("#loader_create_promotion_product_bottom").hide();
        }
    });
}) 

// load user boutique to create product promotion
$('#create_global_promotion_container').on('click','#select_boutique_product',function(){
    $.ajax({
        url: 'load-user-boutique-promotion.php',
        type: 'post',
        beforeSend: function(){
            $('#create_promotion_product_bottom_container').empty();
            $("#loader_create_promotion_product_bottom").show();
        },
        success: function(response){
            if(response != 0){
                $('#create_promotion_product_bottom_container').append(response);
            }
        },
        complete: function(){
            $("#loader_create_promotion_product_bottom").hide();
        }
    });
})

// back to user boutiques
$('#create_global_promotion_container').on('click','#back_to_boutique_user_promotion',function(){
    $.ajax({
        url: 'load-user-boutique-promotion.php',
        type: 'post',
        beforeSend: function(){
            $('#create_promotion_product_bottom_container').empty();
            $("#loader_create_promotion_product_bottom").show();
        },
        success: function(response){
            if(response != 0){
                $('#create_promotion_product_bottom_container').append(response);
            }
        },
        complete: function(){
            $("#loader_create_promotion_product_bottom").hide();
        }
    });
})

// load product boutique to create product promotion
$('#create_global_promotion_container').on('click','[id^="user_boutique_promotion_"]',function(){
    id = $(this).attr("id").split("_")[3];
    var idBtq = $('#id_btq_prm_'+id).val();
    var idPrm = $('#id_promotion').val();
    var fd = new FormData();
    fd.append('id_btq',idBtq);
    fd.append('id_prm',idPrm);
    $.ajax({
        url: 'load-product-boutique-promotion.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('#create_promotion_product_bottom_container').empty();
            $("#loader_create_promotion_product_bottom").show();
        },
        success: function(response){
            if(response != 0){
                $('#create_promotion_product_bottom_container').append(response);
            }
        },
        complete: function(){
            $("#loader_create_promotion_product_bottom").hide();
        }
    });
})

// load product details to create product promotion
$('#create_global_promotion_container').on('click','[id^="product_boutique_promotion_details_"]',function(){
    var id = $(this).attr("id").split("_")[4];
    var idPrm = $('#id_promotion').val();
    var idPrd = $('#id_prd_prm_'+id).val();
    var idBtq = $('#id_btq_prm').val();
    var fd = new FormData();
    fd.append('id_prm',idPrm);
    fd.append('id_prd',idPrd);
    fd.append('id_btq',idBtq);
    $.ajax({
        url: 'load-product-boutique-promotion-details.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('#create_promotion_product_bottom_container').empty();
            $("#loader_create_promotion_product_bottom").show();
        },
        success: function(response){
            if(response != 0){
                $('#create_promotion_product_bottom_container').append(response);
            }
        },
        complete: function(){
            $("#loader_create_promotion_product_bottom").hide();
        }
    });
})

// back to boutique product
$('#create_global_promotion_container').on('click','#back_to_boutique_product_promotion',function(){
    var idBtq = $('#id_btq_prm').val();
    var idPrm = $('#id_promotion').val();
    var fd = new FormData();
    fd.append('id_btq',idBtq);
    fd.append('id_prm',idPrm);
    $.ajax({
        url: 'load-product-boutique-promotion.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('#create_promotion_product_bottom_container').empty();
            $("#loader_create_promotion_product_bottom").show();
        },
        success: function(response){
            if(response != 0){
                $('#create_promotion_product_bottom_container').append(response);
            }
        },
        complete: function(){
            $("#loader_create_promotion_product_bottom").hide();
        }
    });
})

function backToBoutiqueProductPromotion(idBtq,idPrm){
    var fd = new FormData();
    fd.append('id_btq',idBtq);
    fd.append('id_prm',idPrm);
    $.ajax({
        url: 'load-product-boutique-promotion.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('#create_promotion_product_bottom_container').empty();
            $("#loader_create_promotion_product_bottom").show();
        },
        success: function(response){
            console.log(response);
            if(response != 0){
                $('#create_promotion_product_bottom_container').append(response);
            }
        },
        complete: function(){
            $("#loader_create_promotion_product_bottom").hide();
        }
    });
}

// select product image for product promotion
$('#create_global_promotion_container').on('click','[id^="promotion_product_image_"]',function(){
    $('.promotion-product-image').removeClass('selected-product-promotion-image');
    $('.promotion-product-image i').remove();
    $('.promotion-product-image img').css('opacity','');
    $(this).addClass('selected-product-promotion-image');
    $(this).append('<i class="fas fa-check etat"></i>');
    $(this).find('img').css('opacity','.6');
})

// create product boutique promotion 
$('#create_global_promotion_container').on('click','#valide_product_promotion',function(){
    var idPrm = $('#id_promotion').val();
    var idBtq = $('#id_btq_prm').val();
    var idPrd = $('#id_prm_prd').val();
    var pricePrd = $('#prm_price_prd').val();
    var mediaUrl = $('.selected-product-promotion-image img').attr('src');
    if (pricePrd == 0 || pricePrd == '') {
        $('#prm_price_prd').css('border','2px solid red');
    }
    else if (!$('.selected-product-promotion-image')[0]) {
        $('.select-image-alert-message').show();
    }
    else{
        var fd = new FormData();
        fd.append('id_prm',idPrm);
        fd.append('id_btq',idBtq);
        fd.append('id_prd',idPrd);
        fd.append('prix_prd',pricePrd);
        fd.append('media_url',mediaUrl);
        $.ajax({
            url: 'create-product-boutique-promotion.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            beforeSend: function(){
                $('#create_promotion_product_bottom_container').empty();
                $("#loader_create_promotion_product_button").show();
            },
            success: function(response){
                if(response != 0){
                    backToBoutiqueProductPromotion(idBtq,idPrm);
                }
            },
            complete: function(){
                $("#loader_create_promotion_product_button").hide();
            }
        });
    }
})

// delete product boutique promotion
$('#create_global_promotion_container').on('click','[id^="delete_product_boutique_promotion_"]',function(){
    var id = $(this).attr("id").split("_")[4];
    var idPrm = $('#id_promotion').val();
    var idPrd = $('#id_prd_prm_'+id).val();
    var idBtq = $('#id_btq_prm').val();
    var fd = new FormData();
    fd.append('id_prm',idPrm);
    fd.append('id_prd',idPrd);
    fd.append('id_btq',idBtq);
    $.ajax({
        url: 'delete-product-boutique-promotion.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('#create_promotion_product_bottom_container').empty();
            $("#loader_create_promotion_product_bottom").show();
        },
        success: function(response){
            if(response != 0){
                backToBoutiqueProductPromotion(idBtq,idPrm);
            }
        },
        complete: function(){
            $("#loader_create_promotion_product_bottom").hide();
        }
    });
})

// load form to create new product promotion
$('#create_global_promotion_container').on('click','#create_new_promotion_product',function(){
    var idPrm = $('#id_promotion').val();
    var fd = new FormData();
    fd.append('id_prm',idPrm);
    $.ajax({
        url: 'create-new-product-promotion.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('#create_promotion_product_container').remove();
            $('#create_promotion_container').remove();
            $("#loader_create_promotion").show();
        },
        success: function(response){
            if(response != 0){
                $('#create_global_promotion_container').prepend(response);
            }    
        },
        complete: function(){
            $("#loader_create_promotion").hide();
        }
    });
})

// create promotion product
$('#create_global_promotion_container').on('click','.create-promotion-product-container',function(e){
    e.stopPropagation();
})

$('#create_global_promotion_container').on('click','#cancel_create_promotion_product',function(e){
    var idPrm = $('#id_promotion').val();
    var fd = new FormData();
    fd.append('id_prm',idPrm);
    $.ajax({
        url: 'load-create-promotion.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('#create_promotion_product_container').remove();
            $("#loader_create_promotion").show();
        },
        success: function(response){
            if(response != 0){
                $('#create_global_promotion_container').prepend(response);
            }    
        },
        complete: function(){
            $("#loader_create_promotion").hide();
        }
    });
})

// upload promotion product image 
$('#create_global_promotion_container').on('click','#add_promotion_product_image',function(){
    $('#video_promotion_product').val('');
    $('#image_promotion_product').click();
});

$('#create_global_promotion_container').on('click','#image_promotion_product',function(e){
    e.stopPropagation();
});

$('#create_global_promotion_container').on('change','#image_promotion_product',function(e){
    $('#add_promotion_product_image_button').click();
});

// set promotion product image
$('#create_global_promotion_container').on('click','#add_promotion_product_image_button',function(e){
    e.stopPropagation();
    var numImg = $('.prm-product-image-preview').length;
    if (numImg > 0) {
        var lastImg = $('.prm-product-image-preview').last().attr('id').split("_")[2];
    }
    else{
        var lastImg = 0;
    }
    var numUpldImg = document.getElementById('image_promotion_product').files.length;
    var idPrm = $('#id_promotion').val();
    var idPrd = $('#id_promotion_product').val();
    var form_data = new FormData();
    form_data.append('id_prd',idPrd);
    form_data.append('id_prm',idPrm);
    for (let i = 0; i < 4 - numImg; i++) {
        form_data.append("images[]", document.getElementById('image_promotion_product').files[i]);
    }
    $.ajax({
        url: 'upload-images-prm-product.php', 
        type: 'post',
        data: form_data,
        dataType: 'json',
        contentType: false,
        processData: false,
        beforeSend: function(){
            if ((numImg + numUpldImg) <= 4) {
                for(let i = 0; i < numUpldImg; i++) {
                    let id = lastImg + i;
                    $('.promotion-product-images-preview').append("<div class='prm-product-image-preview' id='prm_product_image_preview_"+id+"'><div id='loader_prm_prd_img_"+id+"' class='center'></div></div>");
                }
            }
            else if ((numImg + numUpldImg) >= 5) {
                for(let i = 0; i < (4 - numImg); i++) {
                    let id = lastImg + i;
                    $('.promotion-product-images-preview').append("<div class='prm-product-image-preview' id='prm_product_image_preview_"+id+"'><div id='loader_prm_prd_img_"+id+"' class='center'></div></div>");
                }
            }
        },
        success: function (response) {
            for(let i = 0; i < response.length; i++) {
                var src = response[i];
                let id = lastImg + i;
                $('#prm_product_image_preview_'+id).replaceWith("<div class='prm-product-image-preview' id='prm_product_image_preview_"+id+"'><div class='delete-preview' id='prm_product_delete_preview_"+id+"'><i class='fas fa-times'></i></div><img src='"+src+"'></div>");
            }
        },
        complete: function(){
            numImg = $('.prm-product-image-preview').length;
            if (numImg >= 4) {
                $('.create-promotion-product-options').hide();
            }
        }
    });
});

// remove promotion product image preview
$('#create_global_promotion_container').on('click','[id^="prm_product_delete_preview_"]',function(){
    var id = $(this).attr("id").split("_")[4];
    var idPrd = $('#id_promotion_product').val();
    var mediaUrl = $('#prm_product_image_preview_'+id+' img').attr('src');
    var form_data = new FormData();
    form_data.append('id_prd',idPrd);
    form_data.append('media_url',mediaUrl);
    $.ajax({
        url: 'delete-promotion-product-media.php', 
        type: 'post',
        data: form_data,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('#prm_product_image_preview_'+id).replaceWith("<div class='prm-product-image-preview' id='prm_product_image_preview_"+id+"'><div id='loader_prm_prd_img_"+id+"' class='center'></div></div>");
        },
        success: function (response) {
            if(response != 0){
                $('#prm_product_image_preview_'+id).remove();
            }
        },
        complete: function(){
            var numImg = $('.prm-product-image-preview').length;
            if (numImg < 4) {
                $('.create-promotion-product-options').show();
            }
        }
    });
});

// set promotion product video 
$('#create_global_promotion_container').on('click','#add_promotion_product_video',function(){
    $('#video_promotion_product').val('');
    $('#video_promotion_product').click();
})

$('#create_global_promotion_container').on('click','#video_promotion_product',function(e){
    e.stopPropagation();
});

$('#create_global_promotion_container').on('change','#video_promotion_product',function () { 
    $('#add_promotion_product_video_button').click();
});

$('#create_global_promotion_container').on('click','#add_promotion_product_video_button',function(e){
    e.stopPropagation();
    var idPrm = $('#id_promotion').val();
    var idPrd = $('#id_promotion_product').val();
    var form_data = new FormData();
    form_data.append('id_prd',idPrd);
    form_data.append('id_prm',idPrm);
    form_data.append("video", $('#video_promotion_product')[0].files[0]);
    $.ajax({
        url: 'upload-video-prm-product.php', 
        type: 'post',
        data: form_data,
        dataType: 'json',
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('.promotion-product-video-preview').append("<div class='prm-product-video-preview' id='prm_product_video_preview'><div id='loader_pub_video' class='center'></div></div>");
        },
        success: function (response) {
            $('#prm_product_video_preview').replaceWith("<div class='prm-product-video-preview' id='prm_product_video_preview'><div class='delete-preview' id='prm_product_delete_video'><i class='fas fa-times'></i></div><video controls><source src='"+response+"'></video></div>");
        },
        complete: function(){
            var numVideo = $('.prm-product-video-preview').length;
            if (numVideo >= 1) {
                $('.create-promotion-product-options').hide();
            }
        }
    });
});

// remove promotion product video preview
$('#create_global_promotion_container').on('click','#prm_product_delete_video',function(){
    var idPrd = $('#id_promotion_product').val();
    var mediaUrl = $('.prm-product-video-preview video source').attr('src');
    var fd = new FormData();
    fd.append('id_prd',idPrd);
    fd.append('media_url',mediaUrl);
    $.ajax({
        url: 'delete-promotion-product-media.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('#prm_product_video_preview').replaceWith("<div class='prm-product-video-preview' id='prm_product_video_preview'><div id='loader_pub_video' class='center'></div></div>");
        },
        success: function(response){
            if(response != 0){
                $('#prm_product_video_preview').remove();
            }
        },
        complete: function(){
            var numVideo = $('.prm-product-video-preview').length;
            if (numVideo == 0) {
                $('.create-promotion-product-options').show();
            }
        }
    });
});

// valide create promotion
$('#create_global_promotion_container').on('click','#final_create_promotion_button',function(){
    var idPrm = $('#id_promotion').val();
    var namePrd = $('#name_prm_prd').val();
    var oldPricePrd = $('#old_price_prm_prd').val();
    var newPricePrd = $('#new_price_prm_prd').val();
    var fd = new FormData();
    fd.append('id_prm',idPrm);
    $.ajax({
        url: 'verify-promotion-product-created.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $(this).css('opacity','.8');
            $("#loader_create_promotion_button").show();
        },
        success: function(response){
            if(response != 100){
                if (response == 0) {
                    if (namePrd == ''){
                        $('#name_prm_prd').css('border','2px solid red');
                    }
                    else if (oldPricePrd == '0'){
                        $('#name_prm_prd').css('border','');
                        $('#old_price_prm_prd').css('border','2px solid red');
                    }
                    else if (newPricePrd == '0'){
                        $('#name_prm_prd').css('border','');
                        $('#old_price_prm_prd').css('border','');
                        $('#new_price_prm_prd').css('border','2px solid red');
                    }
                    else if ($('.promotion-product-images-preview').is(':empty')){
                        $('#name_prm_prd').css('border','');
                        $('#old_price_prm_prd').css('border','');
                        $('#new_price_prm_prd').css('border','');
                        $('.create-promotion-product-options').css('border','2px solid red');
                    }
                    else{
                        $('.create-promotion-product-options').css('border','');
                        createPromotion(idPrm);
                    }
                }
                else{
                    createPromotion(idPrm);
                }
            }
        },
        complete: function(){
            $(this).css('opacity','');
            $("#loader_create_promotion_button").hide();
        }
    });
});

function createPromotion (idPrm) {
    var idPrd = $('#id_promotion_product').val();
    var namePrd = $('#name_prm_prd').val();
    var referencePrd = $('#reference_prm_prd').val();
    var quantityPrd = $('#quantity_prm_prd').val();
    var oldPricePrd = $('#old_price_prm_prd').val();
    var newPricePrd = $('#new_price_prm_prd').val();
    var fonctionalityPrd = $('#fonctionality_prm_prd').val();
    var caracteristicPrd = $('#caracteristic_prm_prd').val();
    var avantagePrd = $('#avantage_prm_prd').val();
    var descriptionPrd = $('#description_prm_prd').val();
    var fd = new FormData();
    fd.append('id_prm',idPrm);
    fd.append('id_prd',idPrd);
    fd.append('nom_prd',namePrd);
    fd.append('reference_prd',referencePrd);
    fd.append('quantite_prd',quantityPrd);
    fd.append('ancien_prix_prd',oldPricePrd);
    fd.append('nouveau_prix_prd',newPricePrd);
    fd.append('fonctionalites_prd',fonctionalityPrd);
    fd.append('caracteristiques_prd',caracteristicPrd);
    fd.append('avantages_prd',avantagePrd);
    fd.append('description_prd',descriptionPrd);
    $.ajax({
        url: 'create-promotion.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function(){
            if (windowWidth > 768) {
                $("#loader_create_publication_bottom_button").show();
            }
            else{
                $("#loader_create_publication_top_button").show();
            }
        },
        success: function(response){
            if(response != 0){
                if (windowWidth > 768) {
                    $("#create_promotion").hide();
                    $("body").removeClass('body-after');
                }
                else{
                    $("#create_promotion").css('transform','');
                }
            }
        },
        complete: function(){
            if (windowWidth > 768) {
                $("#loader_create_publication_bottom_button").hide();
            }
            else{
                $("#loader_create_publication_top_button").hide();
            }
        }
    });
}

// create evenement
$('#create_evenement_button').click(function(){
    $.ajax({
        url: 'pre-create-evenement.php',
        type: 'post',
        beforeSend: function(){
            hideCreatePublication();
            if (windowWidth > 768) {
                $("body").addClass('body-after');
                $('#create_evenement').show();
            }
            else{
                $('#create_evenement').css('transform','translateX(0)');
            }
            $("#loader_create_evenement").show();
        },
        success: function(response){
            if(response != 0){
                $('#create_evenement_container').prepend(response);
            }   
        },
        complete: function(){
            $("#loader_create_evenement").hide();
        }
    });
})

$('#create_evenement_container').click(function(e){
    e.stopPropagation();
})

$('#create_evenement_container').on('click','#cancel_create_evenement',function(){
    cancelCreateEvenement ();
})

$('#create_evenement').click(function(){
    cancelCreateEvenement ();
})

function cancelCreateEvenement () {
    var fd = new FormData();
    var idPrm = $('#id_evenement').val();
    fd.append('id_prm',idPrm);
    $.ajax({
        url: 'pre-delete-evenement.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('#create_evenement_container').empty();
            $("#loader_create_evenement").show();
        },
        success: function(response){
            if(response != 0){
                if (windowWidth > 768) {
                    $("body").removeClass('body-after');
                    $('#create_evenement').hide();
                }
                else{
                    $('#create_evenement').css('transform','');
                }
            }    
        },
        complete: function(){
            $("#loader_create_evenement").hide();
        }
    });
}

$(document).on('focus','.create-publication-bottom input',function(){
    var id = $(this).attr('id');
    if (id == 'titre_evn') {
        $('.titre-evn').addClass('active-evenement-span');
    }
    if (id == 'adresse_evn') {
        $('.adresse-evn').addClass('active-evenement-span');
    }
})

$(document).on('focus','.create-publication-bottom textarea',function(){
    var id = $(this).attr('id');
    if (id == 'description_evn') {
        $('.description-evn').addClass('active-evenement-span');
    }
})

// select promotion ville and commune
$("#create_evenement_container").on('change','#ville_evn',function() {
    var ville  = $(this).val();
    if (ville !== '') {
        $('.commune-evenement').load('commune-evenement.php?v='+ville);
    }
})

function getEvenementLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(getEvenementPosition, showError);
    } else { 
        $('.evenement-localisation-gps p').text("La geolocation ne support pas cette navigateur.");
    }
}

function getEvenementPosition(position) {
    var latitudeEvn = position.coords.latitude;
    var longitudeEvn = position.coords.longitude;
    $('#latitude_evn').val(latitudeEvn);
    $('#longitude_evn').val(longitudeEvn);
    $('.evenement-localisation-gps p').text('La position a été bien ajoutée');
    $('.evenement-localisation-gps button').text('Ajoutée');
}

// upload evenement image 
$("#create_evenement_container").on('click','#add_evenement_image',function(){
    $('#image_evenement').val('');
    $('#image_evenement').click();
});

$("#create_evenement_container").on('click','#image_evenement',function(e){
    e.stopPropagation();
});

$("#create_evenement_container").on('change','#image_evenement',function () { 
    $('#add_evenement_image_button').click();
});

// add image evenement
$("#create_evenement_container").on('click','#add_evenement_image_button',function(){
    var idEvn = $('#id_evenement').val();
    var imgEvn = $('#image_evenement')[0].files[0];
    var form_data = new FormData();
    form_data.append('id_evn',idEvn);
    form_data.append('image',imgEvn);
    $.ajax({
        url: 'upload-images-evenement.php', 
        type: 'post',
        data: form_data,
        dataType: 'json',
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('.create-evenement-options').hide();
            $('.evenement-images-preview').show();
            $('.evenement-images-preview').append("<div id='loader_evenement_image' class='center'></div>");
        },
        success: function (response) {
            console.log(response);
            $('.evenement-images-preview').append("<div class='evenement-image-preview' id='evenement_image_preview'><div id='evenement_delete_image_preview'><i class='fas fa-times'></i></div><img src='"+response+"'></div>");
        },
        complete: function(){
            $('#loader_evenement_image').remove();
        }
    });
});

// remove evenement image preview
$('#create_evenement_container').on('click','#evenement_delete_image_preview',function(){
    var idEvn = $('#id_evenement').val();
    var mediaUrl = $('#evenement_image_preview img').attr('src');
    var fd = new FormData();
    fd.append('id_evn',idEvn);
    fd.append('media_url',mediaUrl);
    $.ajax({
        url: 'delete-evenement-media.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('#evenement_image_preview').remove();
            $('.evenement-images-preview').append("<div id='loader_evenement_image' class='center'></div>");
        },
        success: function(response){
            if(response != 0){
                $('.evenement-images-preview').hide();
                $('.create-evenement-options').show();
            }
        },
        complete: function(){
            $('#loader_evenement_image').remove();
        }
    });
});

// add video evenement
$('#create_evenement_container').on('click','#add_evenement_video',function(){
    $('#video_evenement').val('');
    $('#video_evenement').click();
});

$('#create_evenement_container').on('click','#video_evenement',function(e){
    e.stopPropagation();
});

$('#create_evenement_container').on('change','#video_evenement',function () { 
    $('#add_evenement_video_button').click();
});

$('#create_evenement_container').on('click','#add_evenement_video_button',function(){
    var idEvn = $('#id_evenement').val();
    var videoEvn = $('#video_evenement')[0].files[0];
    var fd = new FormData();
    fd.append('id_evn',idEvn);
    fd.append('video',videoEvn);
    console.log('click');
    $.ajax({
        url: 'upload-video-evenement.php',
        type: 'post',
        data: fd,
        dataType: 'json',
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('.create-evenement-options').hide();
            $('.evenement-images-preview').show();
            $('.evenement-images-preview').append("<div id='loader_evenement_image' class='center'></div>");
        },
        success: function(response){
            $('.evenement-images-preview').append("<div class='evenement-video-preview' id='evenement_video_preview'><div id='evenement_delete_video_preview'><i class='fas fa-times'></i></div><video controls><source src='"+response+"'></video></div>");
        },
        complete: function(){
            $('#loader_evenement_image').remove();
        }
    });
});

// remove video evenement
$('#create_evenement_container').on('click','#evenement_delete_video_preview',function(){
    var idEvn = $('#id_evenement').val();
    var mediaUrl = $('#evenement_video_preview video source').attr('src');
    var fd = new FormData();
    fd.append('id_evn',idEvn);
    fd.append('media_url',mediaUrl);
    $.ajax({
        url: 'delete-evenement-media.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('#evenement_video_preview').remove();
            $('.evenement-images-preview').append("<div id='loader_evenement_image' class='center'></div>");
        },
        success: function(response){
            if(response != 0){
                $('.evenement-images-preview').hide();
                $('.create-evenement-options').show();
            }
        },
        complete: function(){
            $('#loader_evenement_image').remove();
        }
    });
});

// valide create evenement
$('#create_evenement_container').on('click','#final_create_evenement_button',function(){
    var idEvn = $('#id_evenement').val();
    var titreEvn = $('#titre_evn').val();
    var typeEvn = $('#type_evn').val();
    var descriptionEvn = $('#description_evn').val();
    var dateDebutEvn = $('#date_debut_evn').val();
    var dateFinEvn = $('#date_debut_evn').val();
    var nombrePersonneEvn = $('#nombre_personne_evn').val();
    var convierAmisEvn = $('#convier_amis_evn').val();
    var langueEvn = $('#langue_evn').val();
    var confidentialiteEvn = $('#confidentialite_evn').val();
    var tarifEvn = $('#tarif_evn').val();
    var villeEvn = $('#ville_evn').val();
    var communeEvn = $('#commune_evn').val();
    var adresseEvn = $('#adresse_evn').val();
    var latitudeEvn = $('#latitude_evn').val();
    var longitudeEvn = $('#longitude_evn').val();
    var fd = new FormData();
    fd.append('id_evn', idEvn);
    fd.append('titre_evn', titreEvn);
    fd.append('type_evn', typeEvn);
    fd.append('description_evn', descriptionEvn);
    fd.append('date_debut_evn', dateDebutEvn);
    fd.append('date_fin_evn', dateFinEvn);
    fd.append('nombre_personne_evn', nombrePersonneEvn);
    fd.append('convier_amis_evn', convierAmisEvn);
    fd.append('langue_evn', langueEvn);
    fd.append('confidentialite_evn', confidentialiteEvn);
    fd.append('tarif_evn', tarifEvn);
    fd.append('ville_evn', villeEvn);
    fd.append('commune_evn', communeEvn);
    fd.append('adresse_evn', adresseEvn);
    fd.append('latitude_evn', latitudeEvn);
    fd.append('longitude_evn', longitudeEvn);
    if (titreEvn == '') {
        $('#titre_evn').css('border','2px solid red');
    }
    else if (typeEvn == '') {
        $('#titre_evn').css('border','');
        $('#type_evn').css('border','2px solid red');
    }
    else if (descriptionEvn == '') {
        $('#titre_evn').css('border','');
        $('#type_evn').css('border','');
        $('#description_evn').css('border','2px solid red');
    }
    else if (dateDebutEvn == '') {
        $('#titre_evn').css('border','');
        $('#type_evn').css('border','');
        $('#description_evn').css('border','');
        $('#date_debut_evn').css('border','2px solid red');
    }
    else if (dateFinEvn == '') {
        $('#titre_evn').css('border','');
        $('#type_evn').css('border','');
        $('#description_evn').css('border','');
        $('#date_debut_evn').css('border','');
        $('#date_fin_evn').css('border','2px solid red');
    }
    else if (confidentialiteEvn == '') {
        $('#titre_evn').css('border','');
        $('#type_evn').css('border','');
        $('#description_evn').css('border','');
        $('#date_debut_evn').css('border','');
        $('#date_fin_evn').css('border','');
        $('#confidentialite_evn').css('border','2px solid red');
    }
    else if (villeEvn == '') {
        $('#titre_evn').css('border','');
        $('#type_evn').css('border','');
        $('#description_evn').css('border','');
        $('#date_debut_evn').css('border','');
        $('#date_fin_evn').css('border','');
        $('#confidentialite_evn').css('border','');
        $('#ville_evn').css('border','2px solid red');
    }
    else if (communeEvn == '') {
        $('#titre_evn').css('border','');
        $('#type_evn').css('border','');
        $('#description_evn').css('border','');
        $('#date_debut_evn').css('border','');
        $('#date_fin_evn').css('border','');
        $('#confidentialite_evn').css('border','');
        $('#ville_evn').css('border','');
        $('#commune_evn').css('border','2px solid red');
    }
    else if (adresseEvn == '') {
        $('#titre_evn').css('border','');
        $('#type_evn').css('border','');
        $('#description_evn').css('border','');
        $('#date_debut_evn').css('border','');
        $('#date_fin_evn').css('border','');
        $('#confidentialite_evn').css('border','');
        $('#ville_evn').css('border','');
        $('#commune_evn').css('border','');
        $('#adresse_evn').css('border','2px solid red');
    }
    else{
        $.ajax({
            url: 'create-evenement.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            beforeSend: function(){
                if (windowWidth > 768) {
                    $("#loader_create_publication_bottom_button").show();
                }
                else{
                    $("#loader_create_publication_top_button").show();
                }
            },
            success: function(response){
                console.log(response);
                if(response != 0){
                    if (windowWidth > 768) {
                        $("#create_evenement").hide();
                        $("body").removeClass('body-after');
                    }
                    else{
                        $("#create_evenement").css('transform','');
                    }
                }
            },
            complete: function(){
                if (windowWidth > 768) {
                    $("#loader_create_publication_bottom_button").hide();
                }
                else{
                    $("#loader_create_publication_top_button").hide();
                }
            }
        });
    }
})