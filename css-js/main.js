var pathName = window.location.pathname;

// acces admin et sous admin acces change la forme
if (pathName == '/projet/acces-admin.php' || pathName == '/projet/sous-admin-inscription.php') {
    var inscriptionConnexion = document.querySelector('.inscription-connexion');
    inscriptionConnexion.style.gridTemplateColumns = '1fr';
}

var checkBoxAutoClick = document.querySelectorAll('#check_box_auto_click');
var checkBoxVille = document.querySelectorAll('#check_box_ville');
var clickCheckBox = 0;

for (let i = 0; i < checkBoxAutoClick.length; i++) {
    checkBoxAutoClick[i].addEventListener('click',(e)=>{
        checkBoxVille[i].click();
    })
}

var sousAdmin = document.querySelector('#options');
if (pathName == '/projet/sous-admin.php') {
    sousAdmin.classList.add('hide-option');
    adminShowOptions[0].classList.add('active-li-options');
}

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
    window.location = './utilisateur.php';
});

$(document).on('click',".user-logout",function() {
    window.location = './deconnexion.php';
});

$(document).on('click',"#inscription_connexion_button",function() {
    window.location = './inscription-connexion.php';
});

// load navbar nitifications
$('#user_list_messages').click(function(e){
    e.stopPropagation();
    $('.user-list-messages').show();
    $('.user-create-options').hide();
    $('.user-list-notifications').hide();
    $('.user-list-dropdown').hide();
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
    loadUserListMsg();
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
            $('.user-list-top-message').empty();
            $('.user-list-top-message').append(response);
        },
        complete: function(){
            $("#loader_list_message").hide();
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
    var idUserProfile = $('#id_user_porfile').val();

    // $(document).on('click',".profile-image-desktop",function() {
    //     window.location = './utilisateur.php';
    // });
    
    $('#back_history_button').click(function(){
        window.history.back();
    })

    homeButton.addEventListener('click',()=>{
        window.location = './index.php';
    })
    boutdechantierButton.addEventListener('click',()=>{
        window.location = './boutdechantier.php';
    })
    categoriesButton.addEventListener('click',()=>{
        window.location = './categories.php';
    })
    // recrutementsButton.addEventListener('click',()=>{
    //     window.location = './recrutements.php';
    // })
    promotionsButton.addEventListener('click',()=>{
        window.location = './promotions.php';
    })
    evenementsButton.addEventListener('click',()=>{
            window.location = './evenements.php';
    })

    $('.show-hide-menu').click(function(e){
        e.stopPropagation();
        $('.hide-menu').css('transform','translateX(0)');
        unsetBoutdechantierSearchBar();
        unsetRechercheSearchBar();
        unsetGererBoutiqueSearchBar();
        $('.boutdechantier-left').css('transform','');
        $('.recherche-left').css('transform','');
        $('.gerer-boutique-left').css('transform','');
        $('body').addClass('body-after');
        $('.navbar-right').addClass('navbar-right-after');
        $('.navbar').css('box-shadow','none');
        $('.navbar').css('-webkit-box-shadow','none');
        $('.user-list-notifications').hide();
        $('.user-create-options').hide();
        $('.user-list-messages').hide();
        $('.user-list-dropdown').hide();
    });

    $('.hide-menu').click(function(e){
        e.stopPropagation();
    });

    $('.show-search-bar-rsp').click(function(e){
        e.stopPropagation();
        $('.categorie-professionnel').css('transform','translateX(0)');
        $('.hide-menu').css('transform','');
        $('.boutdechantier-left').css('transform','');
        $('.recherche-left').css('transform','');
        $('.gerer-boutique-left').css('transform','');
        unsetBoutdechantierSearchBar();
        unsetRechercheSearchBar();
        unsetGererBoutiqueSearchBar();
        $('body').removeClass('body-after');
        $('.navbar-right').removeClass('navbar-right-after');
        $('.navbar').css('box-shadow','');
        $('.navbar').css('-webkit-box-shadow','');
        $('.user-list-messages').hide();
        $('.user-create-options').hide();
        $('.user-list-notifications').hide();
        $('.user-list-dropdown').hide();
    });

    $('.categorie-professionnel').click(function(e){
        e.stopPropagation();
    })

    $('body').click(function(){
        $('.hide-menu').css('transform','');
        $('.boutdechantier-left').css('transform','');
        $('.recherche-left').css('transform','');
        $('.gerer-boutique-left').css('transform','');
        unsetBoutdechantierSearchBar();
        unsetRechercheSearchBar();
        unsetGererBoutiqueSearchBar();
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
        window.location = 'recherche.php?r='+rechercheText;
    }
});

// $('#categorie_search_btn').click(function(){
//     var rechercheText = $('#categorie_search').val();
//     window.location = 'recherche.php?r='+rechercheText;
// });

$('#categorie_search_button').click(function(e){
    e.stopPropagation();
    $('.categorie-professionnel').show();
    $('.user-create-options').hide();
    $('.user-list-messages').hide();
    $('.user-list-notifications').hide();
    $('.user-list-dropdown').hide();
})

$('#search_bar_button').click(function(e){
    e.stopPropagation();
    $('.categorie-professionnel').show();
    $('.user-create-options').hide();
    $('.user-list-messages').hide();
    $('.user-list-notifications').hide();
    $('.user-list-dropdown').hide();
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
    $('.user-list-messages').hide();
    $('.user-create-options').hide();
    $('.user-list-notifications').hide();
    $('.user-list-dropdown').hide();
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
    $('[id^="publication_options_"]').hide();
    if (windowWidth > 768) {
        $('[id^="product_options_"]').hide();
    }
    else{
        $('.product-options').css('transform','');
    }
    $('#hide_publication').css('transform','');
    $('#delete_publication').css('transform','');
    $('#save_publication').css('transform','');
    hideCategories();
    // $('.user-list-top-message').empty();
    if (windowWidth > 768) {
        $('[id^="categorie_options_"]').hide();
    }
    else{
        $('.categorie-options-resp').css('transform','');
    }
});

$('#cancel_search_bar').click(function(){
    $('.categorie-search-bar').css('transform','');
})

// list dropdown 
$('#user_list_button').click(function(e){
    e.stopPropagation();
    $('.user-list-dropdown').show();
    $('.user-create-options').hide();
    $('.user-list-messages').hide();
    $('.user-list-notifications').hide();
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
});

// list dropdown messages
// $('#user_list_messages').click(function(e){
//     e.stopPropagation();
//     $('.user-list-messages').show();
//     $('.user-create-options').hide();
//     $('.user-list-notifications').hide();
//     $('.user-list-dropdown').hide();
//     $('.categorie-professionnel').hide();
//     $('.categorie-search-bar').css('z-index','');
//     $('.categorie-search-bar i').show();
//     $('#categorie_search').css('width','');
//     $('#categorie_search').css('padding','');
//     $('#categorie_search').css('margin-left','');
//     hideCategories();
// });

// list dropdown messages
$('#user_list_notifications').click(function(e){
    e.stopPropagation();
    $('.user-list-notifications').show();
    $('.user-create-options').hide();
    $('.user-list-messages').hide();
    $('.user-list-dropdown').hide();
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
});

// list dropdown create options
$('#create_new').click(function(e){
    e.stopPropagation();
    $('.user-create-options').show();
    $('.user-list-notifications').hide();
    $('.user-list-messages').hide();
    $('.user-list-dropdown').hide();
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
});

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
        cp.style.display = "";
    });
}

// create publication
$('#create_pub_button').click(function(){
    $('#publication_description').focus();
    $.ajax({
        url: 'pre-create-publication.php',
        type: 'post',
        success: function(response){
            if(response != 0){
                $('#id_publication').val(response);
                hideCreatePublication();
                $("body").addClass('body-after');
                $('#create_publication').show();
            }   
        }
    });
});

$('#cancel_create_publication_resp').click(function(){
    var fd= new FormData();
    var idPub = $('#id_publication').val();
    fd.append('id_pub',idPub);
    $.ajax({
        url: 'pre-delete-publication.php',
        type: 'post',
        data: fd,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(response){
            if(response != 0){
                createPublication[0].style.transform = "";
            }    
        }
    });
})

$('#cancel_create_publication').click(function(){
    var fd = new FormData();
    var idPub = $('#id_publication').val();
    fd.append('id_pub',idPub);
    $.ajax({
        url: 'pre-delete-publication.php',
        type: 'post',
        data: fd,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(response){
            if(response != 0){
                $("body").removeClass('body-after');
                createPublication[0].style.display = "";
                $('.publication-images-preview div').remove();
                $('.publication-video-preview div').remove();
                $('.create-publication-container').css({'top':'','transform':''});
            }    
        }
    });
})

$(window).on('beforeunload', function(){
    if ($('#create_publication').is(':visible')) {
        var fd= new FormData();
        var idPub = $('#id_publication').val();
        fd.append('id_pub',idPub);
        $.ajax({
            url: 'pre-delete-publication.php',
            type: 'post',
            data: fd,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response){
                if(response != 0){
                    // $("body").removeClass('body-after');
                    // hideCreatePublication();
                    // $('.publication-images-preview div').remove();
                    // $('.publication-video-preview div').remove();
                    // $('.create-publication-container').css({'top':'','transform':''});
                }    
            }
        });
    }
    if ($('#create_boutique').is(':visible')) {
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
                    // $("body").removeClass('body-after');
                    // $('#create_boutique').hide();
                    // $('.create-publication-container').css({'top':'','transform':''});
                }    
            }
        });
    }
});

$('#create_publication').click(function(){
    $.ajax({
        url: 'pre-delete-publication.php',
        type: 'post',
        success: function(response){
            if(response != 0){
                $("body").removeClass('body-after');
                $('#create_publication').hide();
                $('.publication-images-preview div').remove();
                $('.publication-video-preview div').remove();
                $('.create-publication-container').css({'top':'','transform':''});
            }    
        }
    });
})

// publication action
$("#publication_location_text").on('keyup',function(){
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

var locationItem = document.querySelectorAll("#publication_location_item");
var locationName = document.querySelector("#publication_location_text");
var locationText = document.querySelectorAll("#publication_location_item p");

for (let i = 0; i < locationItem.length; i++) {
    locationItem[i].addEventListener('click',()=>{
        $('.publication-preview-location').css('display','');
        locationName.value = locationText[i].textContent;
    });
}

$(".create-publication-bottom form").click(function(e){
    e.stopPropagation();
})

$('#publication_description').bind('input propertychange', function() {
    if ($('#publication_description').val() !== '') {
        $('.create-publication-bottom button').css('background','rgb(137, 218, 238)');
        $('.create-publication-bottom button').css('cursor','pointer');
    }
    else{
        $('.create-publication-bottom button').css('background','');
        $('.create-publication-bottom button').css('cursor','');
    }
});

// upload publication image 
$('#add_publication_image').click(function(){
    $('#image').click();
});

$('#image').click(function(e){
    e.stopPropagation();
});

$('#image').on('change', function () { 
    $('#add_publication_image_button').click();
});

$('#add_publication_image_button').click(function(){
    var form_data = new FormData();
    var idPub = $('#id_publication').val();
    form_data.append('id_pub',idPub);
    var totalfiles = document.getElementById('image').files.length;
    for (let i = 0; i < totalfiles; i++) {
        form_data.append("images[]", document.getElementById('image').files[i]);
    }
    $.ajax({
        url: 'upload-images-publication.php', 
        type: 'post',
        data: form_data,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function (response) {
            if (windowWidth > 768) {
                $('.create-publication-container').css({'top':'0','transform':'translate(-50%,0%)'});
            }
            for(let i = 0; i < response.length; i++) {
                var src = response[i];
                $('.publication-images-preview').append("<div class='image-preview' id='image_preview_"+i+"'><div id='delete_preview_"+i+"'><i class='fas fa-times'></i></div><img src='"+src+"'></div>");
            }
        }
    });
});

// upload publication video 
$('#add_publication_video').click(function(){
    $('#video').click();
})

$('#video').click(function(e){
    e.stopPropagation();
});

$('#video').on('change', function () { 
    $('#add_publication_video_button').click();
});

$('#add_publication_video_button').click(function(){
    var form_data = new FormData();
    var idPub = $('#id_publication').val();
    form_data.append('id_pub',idPub);
    form_data.append("video", $('#video')[0].files[0]);
    $.ajax({
        url: 'upload-video-publication.php', 
        type: 'post',
        data: form_data,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function (response) {
            if (windowWidth > 768) {
                $('.create-publication-container').css({'top':'0','transform':'translate(-50%,0%)'});
            }
            $('.publication-video-preview').append("<div class='video-preview'><div id='delete_video'><i class='fas fa-times'></i></div><video controls><source src='"+response+"'></video></div>");
        }
    });
});

// remove publication image preview
$('.publication-images-preview').on('click','[id^="delete_preview_"]',function(){
    var id = $(this).attr("id").split("_")[2];
    var fd = new FormData();
    var idPub = $('#id_publication').val();
    fd.append('id_pub',idPub);
    var mediaUrl = $('#image_preview_'+id+' img').attr('src');
    fd.append('media_url',mediaUrl);
    $.ajax({
        url: 'delete-image-preview.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        success: function(response){
            if(response != 0){
                $('#image_preview_'+id).remove();
            }
        }
    });
});

// remove publication video preview
$('.publication-video-preview').on('click','#delete_video',function(){
    var fd = new FormData();
    var idPub = $('#id_publication').val();
    fd.append('id_pub',idPub);
    var mediaUrl = $('.video-preview video source').attr('src');
    fd.append('media_url',mediaUrl);
    $.ajax({
        url: 'delete-video-preview.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        success: function(response){
            if(response != 0){
                $('.video-preview').remove();
            }
        }
    });
});

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
        success: function (response) {
            console.log(response);
            if (windowWidth > 768) {
                $('.update-publication-container').css({'top':'0','transform':'translate(-50%,0%)'});
            }
            for(let i = 0; i < response.length; i++) {
                var src = response[i];
                $('.publication-update-images-preview').append("<div class='image-preview' id='image_preview_"+i+"'><div id='delete_preview_"+i+"'><i class='fas fa-times'></i></div><img src='"+src+"'></div>");
            }
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
        success: function (response) {
            if (windowWidth > 768) {
                $('.update-publication-container').css({'top':'0','transform':'translate(-50%,0%)'});
            }
            $('.publication-update-video-preview').append("<div class='video-preview'><div id='delete_video'><i class='fas fa-times'></i></div><video controls><source src='"+response+"'></video></div>");
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

// update publications 
$(document).on('click','[id^="update_publication_"]',function(){
    id = $(this).attr("id").split("_")[2];
    var idPub = $('#id_pub_'+id).val(); 
    var publicationTail = $('#publication_tail_'+id).val();
    var publicationDescription = $('#publication_description_'+id).val();
    var publicationLieu = $('#publication_lieu_'+id).val();
    var etatCommentaire = $('#etat_commentaire_'+id).val();
    
    $('#id_publication_updt').val(idPub);
    $('#publication_tail_updt').val(publicationTail);
    $('#publication_location_text_updt').val(publicationLieu);
    $('#publication_description_updt').val(publicationDescription);
    $('#etat_commentaire_updt').val(etatCommentaire);

    $('.publication-update-images-preview').load('publication-images-preview.php?id_pub='+idPub);
    $('.publication-update-video-preview').load('publication-video-preview.php?id_pub='+idPub);

    if (windowWidth <= 768) {
        $('.update-publication').css('transform','translateX(0)');
    }
    else{
        $("body").addClass('body-after');
        $('.update-publication').show();
        $('.update-publication-container').css({'top':'0','transform':'translate(-50%,0%)'});
    }
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

// valide create publication
$('#create_publication_button').click(function(){
    if ($('#publication_description').val() !== '') {
        var fd = new FormData();
        var idPubLieu = $('#publication_location_text').val();
        fd.append('lieu_pub',idPubLieu);
        var idPub = $('#id_publication').val();
        fd.append('id_pub',idPub);
        var descriptionPub = $('#publication_description').val();
        fd.append('description_pub',descriptionPub);
        $.ajax({
            url: 'create-publication.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                if(response != 0){
                    $("body").removeClass('body-after');
                    hideCreatePublication();
                    $('.publication-images-preview div').remove();
                    $('.publication-video-preview div').remove();
                    $('.create-publication-container').css({'top':'','transform':''});
                    window.location.href = "./utilisateur.php?p="+response;
                }
            }
        });
    }
});

// valide update publication
$('#update_publication_button').click(function(){
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
                    $("body").removeClass('body-after');
                    $('.update-publication').hide();
                    $('.update-publication-container').css({'top':'','transform':''});
                    $('#user_publication_'+id).replaceWith(response);
                }
            }
        });
    // }
});

// publication options
$(document).on('click','[id^="display_pub_options_button_"]',function(){
    // e.stopPropagation();
    id = $(this).attr("id").split("_")[4];
    if ($('#publication_options_'+id).is(':visible')) {
        $('#publication_options_'+id).hide();
    }
    else{
        $('#publication_options_'+id).show();
    }
});

$(document).on('click','[id^="publication_options_"]',function(e){
    e.stopPropagation();
    $(this).show();
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

// like publication
$(document).on('click','[id^="like_pub_button_"]',function(){
    id = $(this).attr("id").split("_")[3];
    var fd = new FormData();
    var idPub = $('#id_pub_'+id).val();
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
    id = $(this).attr("id").split("_")[4];
    if ($('#user_publication_bottom_comment_'+id).is(':visible')) {
        $('#user_publication_bottom_comment_'+id).css('display','');
    }
    else{
        $('#user_publication_bottom_comment_'+id).css('display','grid');
    }
});

// commentaire publication
$(document).on('keypress','[id^="commentaire_text_"]',function(event) {
    if (event.which == 13) {
        id = $(this).attr("id").split("_")[2];
        var fd = new FormData();
        var idPub = $('#id_pub_'+id).val();
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
                }
            }
        });
    }
});

function setBoutdechantierSearchBar(){
    $('.boutdechantier-recherche-responsive').css({'grid-template-columns':'1fr','text-align':'center'});
    $('#boutdechantier_recherche_responsive input').css({'width':'92%','margin-left':'0'});
    $('#boutdechantier_recherche_responsive i').css('left','25px');
    $('#back_history').hide();
    $('#display_categories').hide();
    $('#display_filter').hide();
}

function unsetBoutdechantierSearchBar(){
    $('.boutdechantier-recherche-responsive').css({'grid-template-columns':'','text-align':''});
    $('#boutdechantier_recherche_responsive input').css({'width':'','margin-left':''});
    $('#boutdechantier_recherche_responsive i').css('left','');
    $('#back_history').show();
    $('#display_categories').show();
    $('#display_filter').show();
}

function setRechercheSearchBar(){
    $('.recherche-recherche-responsive').css({'grid-template-columns':'1fr','text-align':'center'});
    $('#recherche_recherche_responsive input').css({'width':'92%','margin-left':'0'});
    $('#recherche_recherche_responsive i').css('left','25px');
    $('#back_history').hide();
    $('#display_categories').hide();
    $('#display_filter').hide();
}

function unsetRechercheSearchBar(){
    $('.recherche-recherche-responsive').css({'grid-template-columns':'','text-align':''});
    $('#recherche_recherche_responsive input').css({'width':'','margin-left':''});
    $('#recherche_recherche_responsive i').css('left','');
    $('#back_history').show();
    $('#display_categories').show();
    $('#display_filter').show();
}

function setGererBoutiqueSearchBar(){
    $('.gerer-boutique-recherche-responsive').css({'grid-template-columns':'1fr','text-align':'center'});
    $('#gerer_boutique_recherche_responsive input').css({'width':'92%','margin-left':'0'});
    $('#gerer_boutique_recherche_responsive i').css('left','25px');
    $('#back_history').hide();
    $('#display_gb_manager_resp').hide();
    $('#display_gb_messages_resp').hide();
    $('#display_gb_notifications_resp').hide();
}

function unsetGererBoutiqueSearchBar(){
    $('.gerer-boutique-recherche-responsive').css({'grid-template-columns':'','text-align':''});
    $('#gerer_boutique_recherche_responsive input').css({'width':'','margin-left':''});
    $('#gerer_boutique_recherche_responsive i').css('left','');
    $('#back_history').show();
    $('#display_gb_manager_resp').show();
    $('#display_gb_messages_resp').show();
    $('#display_gb_notifications_resp').show();
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
                    $('#hide_publication').show();
                }else{
                    $('#hide_publication').css('transform','translateY(0)');
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
    $.ajax({
        url: 'pre-create-boutique.php',
        type: 'post',
        success: function(response){
            if(response != 0){
                $('#id_boutique').val(response);
                hideCreatePublication();
                $("body").addClass('body-after');
                $('#create_boutique').show();
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

var villeBoutique = document.querySelector('#ville_boutique');
villeBoutique.addEventListener('change', function (e) {
    if (e.target.value !== '') {
        var ville = e.target.value;
        $('.commune-boutique').load('commune-boutique.php?v='+ville);
    }
})

var categoriesBoutique = document.querySelector('#categorie_boutique');
categoriesBoutique.addEventListener('change', function (e) {
    if (e.target.value !== '') {
        var categorie = e.target.value;
        $('.sous-categorie-boutique').load('categorie.php?c='+categorie);
    }
})

var SousCategoriesBoutique = document.querySelector('#sous_categorie_boutique');
SousCategoriesBoutique.addEventListener('change', function (e) {
    if (e.target.value == 'autre') {
        $('.sous-categorie-autre').show();
    }
    else{
        $('.sous-categorie-autre').hide();
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
            success: function(response){
                if(response != 0){
                    window.location = 'boutique.php?btq='+response;
                }else{
                    alert('err');
                }
            },
        });
    }
})