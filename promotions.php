<?php 
session_start();
include_once './bdd/connexion.php';
if (isset($_SESSION['user'])) {
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
        header('Location: inscription-connexion');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/projet/"/>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css-js/style.css">
    <link rel="stylesheet" href="css-js/promotions.css">
    <link href="css-js/fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fugaz One">
    <title>Promotions</title>
</head>
<body>
    <?php include './navbar.php'; ?>
    <div class="clear"></div>
    <div class="promotions-recherche-responsive">
        <div class="promotions-recherche-responsive-container">
            <div class="show-hide-menu" id="show_hide_menu">
                <i class="fas fa-bars"></i>
            </div> 
            <div class="logo-name">
                <h4>Nhannik</h4>
            </div> 
            <div id="display_categories">
                <i class="fas fa-filter"></i>
            </div>
            <div id="show_search_bar_rsp">
                <i class="fas fa-search"></i>
            </div>
        </div>
    </div>
    <div class="promotions-left">
        <h2>Promotions</h2>
        <div class="promotions-recherche">
            <input type="text" id="recherche_text" placeholder="Chercher un produit ...">
            <i class="fas fa-search"></i>
        </div>
        <hr>
        <?php if (isset($_SESSION['user'])) { ?>
        <div class="promotions-user">
            <div class="display-promotions-user" id="display_promotions_user">
                <div>
                    <i class="fas fa-ad"></i>
                </div>
                <p>Vos promotions</p>
                <div class="promotions-notification">
                    <div id="promotions_ntf">
                        <span>0</span>
                    </div>
                </div>
            </div>
            <div class="display-promotions-user" id="display_saved_promotions_user">
                <div>
                    <i class="fas fa-bookmark"></i>
                </div>
                <p>Promotions interésantes</p>
                <div class="promotions-notification">
                    <div id="promotions_ntf">
                        <span>0</span>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <hr>
        <div class="filter-promotions-options">
            <div class="filter-promotion-button">
                <h4>Filtrer par</h4>
                <button id="reset_promotion_button">Réintialiser</button>
                <button id="filter_promotion_button">Filtrer</button>
            </div>
            <div class="quick-filter-button">
                <button id="today_filter_button">Aujourd'hui</button>
                <button id="week_filter_button">Cette semaine</button>
                <button id="month_filter_button">Ce mois</button>
            </div>
            <div class="filter-promotion" id="display_promotions_categories">
                <div>
                    <i class="fas fa-list-ul"></i>
                </div>
                <p>Categories</p>
            </div>
            <div class="filter-ptomotion-option" id="promotion_categories">
                <div class="filter-promotion-input">
                    <p>Categories</p>
                    <select id="categorie_promotion">
                        <option value="">Categories</option>
                        <option id="services" value="services">Services</option>
                        <option id="artisants" value="artisants">Artisants</option>
                        <option id="transports" value="transports">Transports</option>
                        <option id="locations" value="locations">Locations</option>
                        <option id="entreprises" value="entreprises">Entreprises</option>
                        <option id="detaillons" value="detaillons">Detaillons</option>
                        <option id="grossidtes" value="grossidtes">Grossistes</option>
                        <option id="fabriquants" value="fabriquants">Fabriquants</option>
                        <option id="import-export" value="import-export">Import-Export</option>
                    </select> 
                </div>
                <div class="filter-promotion-input profession-promotion">
                    <p>Profession</p>
                    <select id="profession_promotion">
                        <option value="">Professions</option>
                    </select>
                </div>
            </div>
            <div class="filter-promotion" id="display_promotions_date">
                <div>
                    <i class="far fa-calendar-alt"></i>
                </div>
                <p>Date</p>
            </div>
            <div class="filter-ptomotion-option" id="promotion_date">
                <div class="filter-promotion-input">
                    <p>Debut promotion</p>
                    <input type="date" id="date_debut_prm">
                </div>
                <div class="filter-promotion-input">
                    <p>Fin promotion</p>
                    <input type="date" id="date_fin_prm">
                </div>
            </div>
            <div class="filter-promotion" id="display_promotions_localisation">
                <div>
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <p>Lieu</p>
            </div>
            <div class="filter-ptomotion-option" id="promotion_localisation">
                <div class="filter-promotion-input">
                    <p>Ville</p>
                    <select id="ville_promotion_filter">
                        <option value="">Ville</option>
                        <?php 
                        $ville_query = $conn->prepare("SELECT * FROM villes");
                        $ville_query->execute(); 
                        while ($ville_row = $ville_query->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <option value="<?php echo $ville_row['ville'] ?>"><?php echo $ville_row['ville'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="filter-promotion-input commune-promotion-filter"> 
                    <p>Commune</p>
                    <select id="commune_promotion_filter">
                        <option value="">Commune</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="promotions-right">
        <div class="promotions-right-container"></div>
        <div id="loader_load" class="center"></div>
    </div>
    <div class="promotion-position">
        <div class="promotion-position-container" id="promotion_position_container">
        <div class="promotion-position-top">
            <div class="cancel-promotion-position-resp" id="cancel_promotion_position_resp">
                <i class="fas fa-arrow-left"></i>
            </div>
            <h4>La position de promotion ()</h4>
            <div class="cancel-promotion-position" id="cancel_promotion_position">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="promotion-position-middle"></div>
        <div class="promotion-position-bottom">
            <p>Voir la direction de cette promotion sur google map</p>
            <button id="show_promotion_direction">Direction <i class="fas fa-directions"></i></button>
            <input type="hidden" id="latitude_prm">
            <input type="hidden" id="longitude_prm">
        </div>
        </div>
        <div id="loader_promotion_position" class="center"></div>
    </div>
    <div class="promotion-video">
        <div class="promotion-video-container" id="promotion_video_container">
            <div class="promotion-video-top">
                <div class="cancel-promotion-video-resp" id="cancel_promotion_video_resp">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <h4>Video</h4>
                <div class="cancel-promotion-video" id="cancel_promotion_video">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="promotion-video-bottom" id="promotion_video_bottom"></div>  
        </div>
    </div>
    <div class="delete-promotion" id="delete_promotion">
        <div class="delete-promotion-container" id="delete_promotion_container">
            <input type="hidden" id="promotion_tail_delete">
            <input type="hidden" id="id_promotion_delete">
            <div class="delete-promotion-top">
                <h4>Supprimer la promotion ?</h4>
                <div class="cancel-delete-promotion" id="cancel_delete_promotion">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="delete-promotion-middle">
                <p>Voulez vous vraiment Supprimer la promotion ?</p>
            </div>
            <div class="delete-promotion-bottom">
                <div></div>
                <div></div>
                <button id="cancel_delete_prm_button">Annuler</button>
                <button id="delete_prm_button">Supprimer</button>
            </div>
        </div>
    </div>
    <div class="create-publication" id="update_promotion">
        <div class="create-publication-container" id="update_promotion_container"></div>
        <div id="loader_update_promotion" class="center"></div>
    </div>
    <div class="promotion-details" id="promotion_details">
        <div class="promotion-details-container" id="promotion_details_container"></div>
        <div class="cancel-promotion-details" id="cancel_promotion_details">
            <i class="fas fa-times"></i>
        </div>  
        <div id="loader_promotion_details" class="center"></div>
    </div>
    <div id="loader" class="center"></div>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBEGrApnjX_7GHcNDtF0LR0pgrwxj5j2Q&callback=initPrmMap"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="css-js/main.js"></script>
    <script>
        document.onreadystatechange = function() { 
            if (document.readyState !== "complete") { 
                document.querySelector("body").style.visibility = "hidden"; 
                document.querySelector("#loader").style.visibility = "visible"; 
            } else { 
                document.querySelector("#loader").style.display = "none"; 
                document.querySelector("body").style.visibility = "visible"; 
                var slashes = pathName.split("/").length-1;
                if (slashes <= 2) {
                    $.ajax({
                        url: 'load-all-promotions.php',
                        beforeSend: function(){
                            $("#loader_load").show();
                        },
                        success: function(response){
                            $('.promotions-right-container').append(response);
                        },
                        complete: function(response){
                            $("#loader_load").hide();
                        }
                    });
                }
            } 
        };

        $(window).on('load',function(){
            if (history.state === 'promotions') {
                $('.display-promotions-user').css('background','');
                $('#display_promotions_user').css('background','#ecedee');
                $.ajax({
                    url: 'load-user-promotions.php',
                    beforeSend: function(){
                        $(".promotions-right-container").empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        history.replaceState('promotions','', '/projet/promotions/vos-promotions');
                        $('.promotions-right-container').append(response);
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
            }
            if (history.state === 'savedpromotions') {
                $('.display-promotions-user').css('background','');
                $('#display_saved_promotions_user').css('background','#ecedee');
                $.ajax({
                    url: 'load-saved-user-promotions.php',
                    beforeSend: function(){
                        $(".promotions-right-container").empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        history.replaceState('savedpromotions','', '/projet/promotions/saved-promotions');
                        $('.promotions-right-container').append(response);
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
            }
            if (history.state === 'allpromotions') {
                $('.display-promotions-user').css('background','');
                $.ajax({
                    url: 'load-all-promotions.php',
                    beforeSend: function(){
                        $(".promotions-right-container").empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        history.replaceState('allpromotions','', '/projet/promotions');
                        $('.promotions-right-container').append(response);
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
            }

        })

        $(window).on('popstate',function(){
            if (history.state === 'promotions') {
                $('.display-promotions-user').css('background','');
                $('#display_promotions_user').css('background','#ecedee');
                $.ajax({
                    url: 'load-user-promotions.php',
                    beforeSend: function(){
                        $(".promotions-right-container").empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        $('.promotions-right-container').append(response);
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
            }
            if (history.state === 'savedpromotions') {
                $('.display-promotions-user').css('background','');
                $('#display_saved_promotions_user').css('background','#ecedee');
                $.ajax({
                    url: 'load-saved-user-promotions.php',
                    beforeSend: function(){
                        $(".promotions-right-container").empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        $('.promotions-right-container').append(response);
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
            }
            if (history.state === 'allpromotions' || history.state === null) {
                $('.display-promotions-user').css('background','');
                $.ajax({
                    url: 'load-all-promotions.php',
                    beforeSend: function(){
                        $(".promotions-right-container").empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        $('.promotions-right-container').append(response);
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
            }
        })

        $('#display_promotions_user').click(function(){
            $('.display-promotions-user').css('background','');
            $(this).css('background','#ecedee');
            $.ajax({
                url: 'load-user-promotions.php',
                beforeSend: function(){
                    $(".promotions-right-container").empty();
                    $("#loader_load").show();
                },
                success: function(response){
                    history.pushState('promotions','', '/projet/promotions/vos-promotions');
                    if (windowWidth < 1250) {
                        hideLeftPromotions ();
                        setTimeout(() => {
                            $('.promotions-right-container').append(response);
                        }, 400);
                    }
                    else{
                        $('.promotions-right-container').append(response);
                    }
                },
                complete: function(response){
                    $("#loader_load").hide();
                }
            });
        })

        $('#display_saved_promotions_user').click(function(){
            $('.display-promotions-user').css('background','');
            $(this).css('background','#ecedee');
            $.ajax({
                url: 'load-saved-user-promotions.php',
                beforeSend: function(){
                    $(".promotions-right-container").empty();
                    $("#loader_load").show();
                },
                success: function(response){
                    history.pushState('savedpromotions','', '/projet/promotions/saved-promotions');
                    if (windowWidth < 1250) {
                        hideLeftPromotions ();
                        setTimeout(() => {
                            $('.promotions-right-container').append(response);
                        }, 400);
                    }
                    else{
                        $('.promotions-right-container').append(response);
                    }
                },
                complete: function(response){
                    $("#loader_load").hide();
                }
            });
        })

        $('#display_categories').click(function(e){
            e.stopPropagation();
            setTimeout(() => {
                $('body').addClass('body-after');
            }, 0);
            $('.promotions-left').css('transform','translateX(0)');
        })

        $('#promotions_recherche_responsive').click(function(e){
            e.stopPropagation();
        })

        $('#display_prm_search_bar').click(function(e){
            e.stopPropagation();
            setPromotionsSearchBar();
        })

        $(document).on('keypress',"#recherche_text",function() {
            var rechercheText = $(this).val();
            if (event.which == 13) {
                if (rechercheText != '') {
                    recherchePromotionsText (rechercheText);
                }
            }
        });

        function recherchePromotionsText (rechercheText) {
            var typeFilter = 'text';
            var categoriePrm = '';
            var professionPrm = '';
            var dateDebutPrm = '';
            var dateFinPrm = '';
            var villePrm = '';
            var communePrm = '';
            var fd = new FormData();
            fd.append('type_filter',typeFilter);
            fd.append('text',rechercheText);
            fd.append('categorie_prm',categoriePrm);
            fd.append('profession_prm',professionPrm);
            fd.append('date_debut_prm',dateDebutPrm);
            fd.append('date_fin_prm',dateFinPrm);
            fd.append('ville_prm',villePrm);
            fd.append('commune_prm',communePrm);
            $.ajax({
            url: 'filter-promotion.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
                beforeSend: function(){
                    $(".promotions-right-container").empty();
                    $("#loader_load").show();
                    history.replaceState(null,'', 'promotions/'+typeFilter+'/'+rechercheText);
                },
                success: function(response){
                    if (768 <= windowWidth <= 1250) {
                        hideLeftPromotions ();
                        setTimeout(() => {
                            $('.promotions-right-container').append(response);
                        }, 400);
                    }
                    else{
                        $('.promotions-right-container').append(response);
                    }
                },
                complete: function(response){
                    $("#loader_load").hide();
                }
            });
        }

        $('.promotion-position').click(function(){
            $('body').removeClass('body-after');
            $('.promotion-position').hide();
        })

        $('.promotion-position-container').click(function(e){
            e.stopPropagation();
        })

        $('.promotion-position-container').on('click','#cancel_promotion_position',function(){
            $('body').removeClass('body-after');
            $('.promotion-position').hide();
        })

        $('.promotion-position-container').on('click','#cancel_promotion_position_resp',function(){
            $('.promotion-position').css('transform','');
        })

        $(document).on('click','[id^="show_promotion_position_"]',function(){
            var id = $(this).attr("id").split("_")[3];
            var latitudePrm = $('#latitude_prm_'+id).val();
            var longitudePrm = $('#longitude_prm_'+id).val();
            $('#latitude_prm').val(latitudePrm);
            $('#longitude_prm').val(longitudePrm);
            if (windowWidth > 768) {
                $('body').addClass('body-after');
                $('.promotion-position').show();
            }
            else{
                $('.promotion-position').css('transform','translateX(0)');
            }
            initPrmMap(latitudePrm, longitudePrm); 
        })

        function initPrmMap(lat,lng) {
            var map = new google.maps.Map(document.querySelector('.promotion-position-middle'), {
            center: new google.maps.LatLng(lat, lng),
            zoom: 14
            });
            var marker = new google.maps.Marker({
                map: map,
                position: new google.maps.LatLng(lat, lng),
                icon : {
                    url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png"
                }
            });
        }

        $('.promotions-right-container').on('click','[id^="show_promotion_direction_"]',function(){
            var id = $(this).attr("id").split("_")[3];
            var latitudePrm = $('#latitude_prm_'+id).val();
            var longitudePrm = $('#longitude_prm_'+id).val();
            url = "https://maps.google.com/?q="+latitudePrm+","+longitudePrm;
            window.open(url, '_blank');
        })

        // display promotion position
        $('#promotion_position_container').on('click','#show_promotion_direction',function(){
            var latitudePrm = $('#latitude_prm').val();
            var longitudePrm = $('#longitude_prm').val();
            url = "https://maps.google.com/?q="+latitudePrm+","+longitudePrm;
            window.open(url, '_blank');
        })

        $('.promotion-video').click(function(){
            $('body').removeClass('body-after');
            $('.promotion-video').hide();
            $('#promotion_video_bottom').empty();
        })

        $('.promotion-video-container').click(function(e){
            e.stopPropagation();
        })

        $('#cancel_promotion_video').on('click',function(){
            $('body').removeClass('body-after');
            $('.promotion-video').hide();
            $('#promotion_video_bottom').empty();
        })

        $('#cancel_promotion_video_resp').on('click',function(){
            $('.promotion-video').css('transform','');
            setTimeout(() => {
                $('#promotion_video_bottom').empty();
            }, 400);
        })

        // show promotion video
        $(document).on('click','[id^="show_promotion_video_"]',function(){
            var id = $(this).attr("id").split("_")[3];
            $('.promotion-video').show();
            $("body").addClass('body-after');
            var src = $('#promotion_video_'+id).find('source').attr('src');
            $('#promotion_video_bottom').append('<video controls><source src="'+src+'"></video>')
        })

        $(document).on('click','[id^="save_promotion_"]',function(){
            var id = $(this).attr("id").split("_")[2];
            var idPrm = $('#id_promotion_'+id).val();
            var fd = new FormData();
            fd.append('id_prm',idPrm);
            $.ajax({
                url: 'save-promotions.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response != 0){
                        $('#save_promotion_'+id).replaceWith('<p>interessé(e)</p>');
                    }
                }
            });
        })

        $(document).on('click','[id^="updt_view_"]',function(){
            var id = $(this).attr("id").split("_")[2];
            var idPrm = $('#id_promotion_'+id).val();
            var fd = new FormData();
            fd.append('id_prm',idPrm);
            $.ajax({
                url: 'updt-promotions-views.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response != 0){
                        var participat = parseInt($('#promotion_participate_'+id).find('span').text());
                        $('#promotion_participate_'+id).find('span').text(participat+1);
                        $('#updt_view_'+id).replaceWith('<p>participé(e)</p>');
                    }
                }
            });
        })

        // show promotion details
        $(document).on('click','[id^="promotion_details_button_"]',function(){
            var id = $(this).attr("id").split("_")[3];
            var idPrm = $('#id_promotion_'+id).val();
            var fd = new FormData();
            fd.append('id_prm',idPrm);
            $.ajax({
                url: 'load-promotion-details.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    if (windowWidth > 768) {
                        $("body").addClass('body-after');
                        $("body").css('overflow','hidden');
                        $("#promotion_details").css('display','grid');
                        $('#promotion_details_container').css('height','calc(100vh - 20px)');
                    }
                    else{
                        $("#promotion_details").css('transform','translateX(0)');
                    }
                    $("#loader_promotion_details").show();
                },
                success: function(response){
                    if (response != 0) {
                        $('#promotion_details_container').css('height','');
                        $('#promotion_details_container').prepend(response);
                    }
                },
                complete: function(){
                    $("#loader_promotion_details").hide();
                }
            });
        })

        // display more boutique product in promotion details
        $(document).on('click','[id^="go_boutique_button_"]',function(){
            var id = $(this).attr("id").split("_")[3];
            var idBtq = $('#id_btq_'+id).val();
            var idPrd = $('#id_btq_prd_'+id).val();
            window.location = 'boutique/'+idBtq+'/'+idPrd;
        })

        // cancel promotion details
        $('#promotion_details_container').on('click','#cancel_promotion_details_resp',function(){
            $("#promotion_details").css('transform','');
            setTimeout(() => {
                $('#promotion_details_container').empty();
            }, 400);
        })

        $('#cancel_promotion_details').click(function(){
            $("body").removeClass('body-after');
            $("body").css('overflow','');
            $("#promotion_details").css('display','');
            $('#promotion_details_container').empty();
        })

        // show promotion createur
        $('#promotion_details_container').on('click','#show_promotion_creator',function(){
            var typePrmCrtr = $('#type_prm_crtr').val();
            var idPrmCrtr = $('#id_prm_crtr').val();
            if (typePrmCrtr == 'user') {
                window.location = 'utilisateur/'+idPrmCrtr;
            }
            else if (typePrmCrtr == 'boutique') {
                window.location = 'boutique/'+idPrmCrtr;
            }
        })

        // show promotion details position
        $(document).on('click','#show_promotion_position',function(){
            console.log('click');
            var latitudePrm = $('#latitude_prm').val();
            var longitudePrm = $('#longitude_prm').val();
            var fd = new FormData();
            fd.append('latitude_prm',latitudePrm);
            fd.append('longitude_prm',longitudePrm);
            $.ajax({
                url: 'load-promotion-position.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    if (windowWidth > 768) {
                        $("#promotion_details").css('display','');
                        $('#promotion_details_container').empty();
                        $('.promotion-position').show();
                    }
                    else{
                        $("#promotion_details").css('transform','');
                        setTimeout(() => {
                            $('#promotion_details_container').empty();
                        }, 400);
                        $('.promotion-position').css('transform','translateX(0)');
                    }
                    $("#loader_promotion_position").show();
                },
                success: function(response){
                    $('#promotion_position_container').append(response);
                },
                complete: function(response){
                    $("#loader_promotion_position").hide();
                }
            });
        })

        // show promotion details direction
        $('#promotion_details_container').on('click','#show_promotion_direction',function(){
            var latitudePrm = $('#latitude_prm').val();
            var longitudePrm = $('#longitude_prm').val();
            url = "https://maps.google.com/?q="+latitudePrm+","+longitudePrm;
            window.open(url, '_blank');
        })

        // change photo product promotion
        $('#promotion_details_container').on('click','.display-modele',function(){
            var urlMedia = $(this).find('img').attr('src');
            $('.display-modele').removeClass('product-details-image-active');
            $(this).addClass('product-details-image-active');
            $('.produit-promotion-details-left-top img').replaceWith('<img src="'+urlMedia+'" alt="">');
            
        })

        // delete promotion
        $(document).on('click','[id^="delete_prm_"]',function(){
            id = $(this).attr("id").split("_")[2];
            var idPrm = $('#id_prm_'+id).val();
            var prmTail = $('#tail_prm_'+id).val();
            $('#id_promotion_delete').val(idPrm);
            $('#promotion_tail_delete').val(prmTail);
            $("body").addClass('body-after');
            if (windowWidth > 768) {
                $('#delete_promotion').show();
            }else{
                $('#delete_promotion').css('transform','translateY(0)');
            }
        });

        $('#delete_promotion_container').click(function(e){
            e.stopPropagation();
        })

        $('#delete_prm_button').click(function(){
            var fd = new FormData();
            var idPrm = $('#id_promotion_delete').val();
            fd.append('id_prm',idPrm);
            var prmTail = $('#promotion_tail_delete').val();
            $.ajax({
                url: 'delete-promotion.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response != 0){
                        $("body").removeClass('body-after');
                        if (windowWidth > 768) {
                            $('#delete_promotion').hide();
                        }else{
                            $('#delete_promotion').css('transform','');
                        }
                        $('#promotion_user_overview_'+prmTail).remove();
                    }
                }
            });
        });

        $('#cancel_delete_promotion').click(function(e){
            e.stopPropagation();
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $('#delete_promotion').hide();
            }else{
                $('#delete_promotion').css('transform','');
            }
        });

        $('#cancel_delete_prm_button').click(function(e){
            e.stopPropagation();
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $('#delete_promotion').hide();
            }else{
                $('#delete_promotion').css('transform','');
            }
        });

        $('#delete_promotion').click(function(e){
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $('#delete_promotion').hide();
            }else{
                $('#delete_promotion').css('transform','');
            }
        });

        // update promotion
        $(document).on('click','[id^="update_prm_"]',function(){
            id = $(this).attr("id").split("_")[2];
            var idPrm = $('#id_prm_'+id).val();
            var tailPrm = $('#tail_prm_'+id).val();
            var idPrd = $('#id_prm_prd_'+id).val();
            var fd = new FormData();
            fd.append('id_prm',idPrm);
            fd.append('tail_prm',tailPrm);
            fd.append('id_prd',idPrd);
            $.ajax({
                url: 'load-update-promotion.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    if (windowWidth > 768) {
                        $("body").addClass('body-after');
                        $("#update_promotion").show();
                        $('#update_promotion_container').css({'top':'0','transform':'translate(-50%,0%)'});
                    }
                    else{
                        $("#update_promotion").css('transform','translateX(0)');
                    }
                    $("#loader_update_promotion").show();
                },
                success: function(response){
                    if (response != 0) {
                        $('#update_promotion_container').prepend(response);
                    }
                },
                complete: function(response){
                    $('.create-promotion-product-bottom').css('height','auto');
                    $("#loader_update_promotion").hide();
                }
            });
        });

        $('#update_promotion_container').on('click','#cancel_update_promotion',function(e){
            cancelUpdatePromotion ();
        })

        $('#update_promotion').on('click',function(){
            cancelUpdatePromotion ();
        })

        function cancelUpdatePromotion () {
            var fd = new FormData();
            var idPrm = $('#id_updt_promotion').val();
            fd.append('id_prm',idPrm);
            $.ajax({
                url: 'pre-delete-promotion.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $('#update_promotion_container').empty();
                    $("#loader_update_promotion").show();
                },
                success: function(response){
                    console.log(response);
                    if(response != 0){
                    }    
                },
                complete: function(){
                    if (windowWidth > 768) {
                        $("body").removeClass('body-after');
                        $('#update_promotion').hide();
                    }
                    else{
                        $('#update_promotion').css('transform','');
                    }
                    $("#loader_update_promotion").hide();
                }
            });
        }

        $(document).on('change','#categorie_prm',function() {
            var categorie  = $(this).val();
            if (categorie !== '') {
                $('.updt-sous-categorie-promotion').load('update-categorie-promotion.php?c='+categorie);
            }
        })

        $(document).on('change','#sous_categorie_prm',function() {
            var profession = $(this).val();
            if (profession == 'autre') {
                $('.updt-sous-categorie-promotion').hide(); 
                $('.updt-sous-categorie-autre').show(); 
            }
        })

        // select promotion ville and commune
        $("#update_promotion_container").on('change','#ville_promotion',function() {
            var ville  = $(this).val();
            if (ville !== '') {
                $('.commune-promotion').load('commune-promotion.php?v='+ville);
            }
        })

        // upload promotion image 
        $("#update_promotion_container").on('click','#add_promotion_image',function(){
            $('#image_promotion').val('');
            $('#image_promotion').click();
        });

        $("#update_promotion_container").on('click','#image_promotion',function(e){
            e.stopPropagation();
        });

        $("#update_promotion_container").on('change','#image_promotion',function () { 
            $('#add_promotion_image_button').click();
        });

        // add image promotion
        $("#update_promotion_container").on('click','#add_promotion_image_button',function(e){
            e.stopPropagation();
            var idPrm = $('#id_updt_promotion').val();
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
        $('#update_promotion_container').on('click','#promotion_delete_image_preview',function(){
            var idPrm = $('#id_updt_promotion').val();
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
        $('#update_promotion_container').on('click','#add_promotion_video',function(){
            $('#video_promotion').val('');
            $('#video_promotion').click();
        });

        $('#update_promotion_container').on('click','#video_promotion',function(e){
            e.stopPropagation();
        });

        $('#update_promotion_container').on('change','#video_promotion',function () { 
            $('#add_promotion_video_button').click();
        });

        $('#update_promotion_container').on('click','#add_promotion_video_button',function(e){
            e.stopPropagation();
            var idPrm = $('#id_updt_promotion').val();
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
        $('#update_promotion_container').on('click','#promotion_delete_video_preview',function(){
            var idPrm = $('#id_updt_promotion').val();
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

        // upload promotion product image 
        $('#update_promotion_container').on('click','#add_promotion_product_image',function(){
            $('#image_promotion_product').val('');
            $('#image_promotion_product').click();
        });

        $('#update_promotion_container').on('click','#image_promotion_product',function(e){
            e.stopPropagation();
        });

        $('#update_promotion_container').on('change','#image_promotion_product',function(e){
            $('#add_promotion_product_image_button').click();
        });

        // set promotion product image
        $('#update_promotion_container').on('click','#add_promotion_product_image_button',function(e){
            e.stopPropagation();
            var numImg = $('.prm-product-image-preview').length;
            if (numImg > 0) {
                var lastImg = $('.prm-product-image-preview').last().attr('id').split("_")[2];
            }
            else{
                var lastImg = 0;
            }
            var numUpldImg = document.getElementById('image_promotion_product').files.length;
            var idPrm = $('#id_updt_promotion').val();
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
        $('#update_promotion_container').on('click','[id^="prm_product_delete_preview_"]',function(){
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
        $('#update_promotion_container').on('click','#add_promotion_product_video',function(){
            $('#video_promotion_product').val('');
            $('#video_promotion_product').click();
        })

        $('#update_promotion_container').on('click','#video_promotion_product',function(e){
            e.stopPropagation();
        });

        $('#update_promotion_container').on('change','#video_promotion_product',function () { 
            $('#add_promotion_product_video_button').click();
        });

        $('#update_promotion_container').on('click','#add_promotion_product_video_button',function(e){
            e.stopPropagation();
            var idPrm = $('#id_updt_promotion').val();
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
        $('#update_promotion_container').on('click','#prm_product_delete_video',function(){
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

        var typeFilter = '<?php if (isset($_GET['type'])) { echo $_GET['type']; } else { echo ''; } ?>';
        var rechercheText = '<?php if (isset($_GET['text'])) { echo $_GET['text']; } else { echo ''; } ?>';
        var categoriePrm = '<?php if (isset($_GET['categorie'])) { echo $_GET['categorie']; } else { echo ''; } ?>';
        var professionPrm = '<?php if (isset($_GET['profession'])) { echo $_GET['profession']; } else { echo ''; } ?>';
        var dateDebutPrm = '<?php if (isset($_GET['debut'])) { echo $_GET['debut']; } else { echo ''; } ?>';
        var dateFinPrm = '<?php if (isset($_GET['fin'])) { echo $_GET['fin']; } else { echo ''; } ?>';
        var villePrm = '<?php if (isset($_GET['ville'])) { echo $_GET['ville']; } else { echo ''; } ?>';
        var communePrm = '<?php if (isset($_GET['commune'])) { echo $_GET['commune']; } else { echo ''; } ?>';
        $(window).on('load', function(){ 
            if (typeFilter !== '') {
                if (typeFilter == 'today') {
                    var d = new Date();
                    dateDebutPrm = d.toLocaleDateString(); 
                }
                else if (typeFilter == 'week') {
                    let week = getFirstLastDayWeek();
                    let firstDay = week.first_date, lastDay = week.last_date;
                    dateDebutPrm = firstDay;
                    dateFinPrm = lastDay;
                }
                else if (typeFilter == 'month') {
                    var date = new Date(), y = date.getFullYear(), m = date.getMonth();
                    var firstDay = new Date(y, m, 1).toLocaleDateString();
                    var lastDay = new Date(y, m + 1, 0).toLocaleDateString();
                    dateDebutPrm = firstDay;
                    dateFinPrm = lastDay;
                }
                $('#recherche_text').val(rechercheText);
                var fd = new FormData();
                fd.append('type_filter',typeFilter);
                fd.append('text',rechercheText);
                fd.append('categorie_prm',categoriePrm);
                fd.append('profession_prm',professionPrm);
                fd.append('date_debut_prm',dateDebutPrm);
                fd.append('date_fin_prm',dateFinPrm);
                fd.append('ville_prm',villePrm);
                fd.append('commune_prm',communePrm);
                $.ajax({
                    url: 'filter-promotion.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $(".promotions-right-container").empty();
                        $("#loader_load").show();
                        var filter = '';
                        if (typeFilter == 'today' || typeFilter == 'week' || typeFilter == 'month') {
                            history.replaceState(null,'', 'promotions/'+typeFilter);
                        }
                        else if (typeFilter == 'text') {
                            history.replaceState(null,'', 'promotions/'+typeFilter+'/'+rechercheText);
                        }
                        else if (typeFilter == 'filter') {
                            if (categoriePrm != '') { filter = '/'+categoriePrm; } else { filter = filter+'/0'; }
                            if (professionPrm != '') { filter = filter+'/'+professionPrm; } else { filter = filter+'/0'; }
                            if (dateDebutPrm != '') { filter = filter+'/'+dateDebutPrm; } else { filter = filter+'/0'; }
                            if (dateFinPrm != '') { filter = filter+'/'+dateFinPrm; } else { filter = filter+'/0'; }
                            if (villePrm != '') { filter = filter+'/'+villePrm; } else { filter = filter+'/0'; }
                            if (communePrm != '') { filter = filter+'/'+communePrm; } else { filter = filter+'/0'; }
                            history.replaceState(null,'', 'promotions/'+typeFilter+filter);
                        }
                    },
                    success: function(response){
                        if (response != 0) {
                            $('.promotions-right-container').append(response);
                        }
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
            }
        })

        $('.promotions-left').click(function(e){
            e.stopPropagation();
        })

        $('#display_promotions_categories').click(function(){
            if ($('#promotion_categories').height() > 0) {
                $('#promotion_categories').css({'max-height':''});
            }
            else{
                $('#promotion_categories').css({'max-height':'127px'});
            }
        })

        $('#display_promotions_date').click(function(){
            if ($('#promotion_date').height() > 0) {
                $('#promotion_date').css({'max-height':''});
            }
            else{
                $('#promotion_date').css({'max-height':'127px'});
            }
        })

        $('#display_promotions_localisation').click(function(){
            if ($('#promotion_localisation').height() > 0) {
                $('#promotion_localisation').css({'max-height':''});
            }
            else{ 
                $('#promotion_localisation').css({'max-height':'127px'});
            }
        })

        $('#ville_promotion_filter').on('change',function() {
            var ville  = $(this).val();
            if (ville !== '') {
                $('.commune-promotion-filter').load('commune-filter-promotion.php?v='+ville);
            }
        })

        $('#categorie_promotion').on('change',function() {
            var categorie  = $(this).val();
            if (categorie !== '') {
                $('.profession-promotion').load('categorie-filter-promotion.php?c='+categorie);
            }
        })

        // filter promotions
        $('#filter_promotion_button').on('click',function() {
            var typeFilter = 'filter';
            var rechercheText = '';
            var categoriePrm = $('#categorie_promotion').val();
            var professionPrm = $('#profession_promotion').val();
            var dateDebutPrm = $('#date_debut_prm').val();
            var dateFinPrm = $('#date_fin_prm').val();
            var villePrm = $('#ville_promotion_filter').val();
            var communePrm = $('#commune_promotion_filter').val();
            var fd = new FormData();
            fd.append('type_filter',typeFilter);
            fd.append('text',rechercheText);
            fd.append('categorie_prm',categoriePrm);
            fd.append('profession_prm',professionPrm);
            fd.append('date_debut_prm',dateDebutPrm);
            fd.append('date_fin_prm',dateFinPrm);
            fd.append('ville_prm',villePrm);
            fd.append('commune_prm',communePrm);
            $.ajax({
                url: 'filter-promotion.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".promotions-right-container").empty();
                    $("#loader_load").show();
                    var filter = '';
                    if (categoriePrm != '') { filter = '/'+categoriePrm; } else { filter = filter+'/0'; }
                    if (professionPrm != '') { filter = filter+'/'+professionPrm; } else { filter = filter+'/0'; }
                    if (dateDebutPrm != '') { filter = filter+'/'+dateDebutPrm; } else { filter = filter+'/0'; }
                    if (dateFinPrm != '') { filter = filter+'/'+dateFinPrm; } else { filter = filter+'/0'; }
                    if (villePrm != '') { filter = filter+'/'+villePrm; } else { filter = filter+'/0'; }
                    if (communePrm != '') { filter = filter+'/'+communePrm; } else { filter = filter+'/0'; }
                    history.replaceState(null,'', 'promotions/'+typeFilter+filter);
                },
                success: function(response){
                    if (response != 0) {
                        if (windowWidth > 1250) {
                            $('.promotions-right-container').append(response);
                        }
                        else{
                            hideLeftPromotions ();
                            setTimeout(() => {
                                $('.promotions-right-container').append(response);
                            }, 400);
                        }
                    }
                },
                complete: function(response){
                    $("#loader_load").hide();
                }
            });
        })

        $('#today_filter_button').on('click',function() {
            var typeFilter = 'today';
            var rechercheText = '';
            var d = new Date();
            var categoriePrm = '';
            var professionPrm = '';
            var dateDebutPrm = d.toLocaleDateString();
            var dateFinPrm = '';
            var villePrm = '';
            var communePrm = '';
            var fd = new FormData();
            fd.append('type_filter',typeFilter);
            fd.append('text',rechercheText);
            fd.append('categorie_prm',categoriePrm);
            fd.append('profession_prm',professionPrm);
            fd.append('date_debut_prm',dateDebutPrm);
            fd.append('date_fin_prm',dateFinPrm);
            fd.append('ville_prm',villePrm);
            fd.append('commune_prm',communePrm); 
            $.ajax({
                url: 'filter-promotion.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".promotions-right-container").empty();
                    $("#loader_load").show();
                    history.replaceState(null,'', 'promotions/'+typeFilter);
                },
                success: function(response){
                    if (response != 0) {
                        if (windowWidth > 1250) {
                            $('.promotions-right-container').append(response);
                        }
                        else{
                            hideLeftPromotions ();
                            setTimeout(() => {
                                $('.promotions-right-container').append(response);
                            }, 400);
                        }
                    }
                },
                complete: function(response){
                    $("#loader_load").hide();
                }
            });
        })

        function getFirstLastDayWeek () {
            var weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
            var date = new Date;
            var day = weekday[date.getDay()];

            if (day == "Sunday") {
                var first_date = new Date(date.setDate(date.getDate())).toLocaleDateString();
                var last_date = new Date(date.setDate(date.getDate() + 6)).toLocaleDateString();
            }
            else if (day == "Monday") {
                var first_date = new Date(date.setDate(date.getDate() - 1)).toLocaleDateString();
                var last_date = new Date(date.setDate(date.getDate() + 6)).toLocaleDateString();
            }
            else if (day == "Tuesday") {
                var first_date = new Date(date.setDate(date.getDate() - 2)).toLocaleDateString();
                var last_date = new Date(date.setDate(date.getDate() + 6)).toLocaleDateString();
            }
            else if (day == "Wednesday") {
                var first_date = new Date(date.setDate(date.getDate() - 3)).toLocaleDateString();
                var last_date = new Date(date.setDate(date.getDate() + 6)).toLocaleDateString();
            }
            else if (day == "Thursday") {
                var first_date = new Date(date.setDate(date.getDate() - 4)).toLocaleDateString();
                var last_date = new Date(date.setDate(date.getDate() + 6)).toLocaleDateString();
            }
            else if (day == "Friday") {
                var first_date = new Date(date.setDate(date.getDate() - 5)).toLocaleDateString();
                var last_date = new Date(date.setDate(date.getDate()) + 6).toLocaleDateString();
            }
            else if (day == "Saturday") {
                var first_date = new Date(date.setDate(date.getDate() - 6)).toLocaleDateString();
                var last_date = new Date(date.setDate(date.getDate()) + 6).toLocaleDateString();
            }
            return {first_date, last_date};
        }

        $('#week_filter_button').on('click',function() {
            let week = getFirstLastDayWeek();
            let firstDay = week.first_date, lastDay = week.last_date;
            var typeFilter = 'week';
            var rechercheText = '';
            var d = new Date();
            var categoriePrm = '';
            var professionPrm = '';
            var dateDebutPrm = firstDay;
            var dateFinPrm = lastDay;
            var villePrm = '';
            var communePrm = '';
            var fd = new FormData();
            fd.append('type_filter',typeFilter);
            fd.append('text',rechercheText);
            fd.append('categorie_prm',categoriePrm);
            fd.append('profession_prm',professionPrm);
            fd.append('date_debut_prm',dateDebutPrm);
            fd.append('date_fin_prm',dateFinPrm);
            fd.append('ville_prm',villePrm);
            fd.append('commune_prm',communePrm); 
            $.ajax({
                url: 'filter-promotion.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".promotions-right-container").empty();
                    $("#loader_load").show();
                    history.replaceState(null,'', 'promotions/'+typeFilter);
                },
                success: function(response){
                    if (response != 0) {
                        if (windowWidth > 1250) {
                            $('.promotions-right-container').append(response);
                        }
                        else{
                            hideLeftPromotions ();
                            setTimeout(() => {
                                $('.promotions-right-container').append(response);
                            }, 400);
                        }
                    }
                },
                complete: function(response){
                    $("#loader_load").hide();
                }
            });
        })

        $('#month_filter_button').on('click',function() {
            var date = new Date(), y = date.getFullYear(), m = date.getMonth();
            var firstDay = new Date(y, m, 1).toLocaleDateString();
            var lastDay = new Date(y, m + 1, 0).toLocaleDateString();
            var typeFilter = 'month';
            var rechercheText = '';
            var d = new Date();
            var categoriePrm = '';
            var professionPrm = '';
            var dateDebutPrm = firstDay;
            var dateFinPrm = lastDay;
            var villePrm = '';
            var communePrm = '';
            var fd = new FormData();
            fd.append('type_filter',typeFilter);
            fd.append('text',rechercheText);
            fd.append('categorie_prm',categoriePrm);
            fd.append('profession_prm',professionPrm);
            fd.append('date_debut_prm',dateDebutPrm);
            fd.append('date_fin_prm',dateFinPrm);
            fd.append('ville_prm',villePrm);
            fd.append('commune_prm',communePrm); 
            $.ajax({
                url: 'filter-promotion.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".promotions-right-container").empty();
                    $("#loader_load").show();
                    history.replaceState(null,'', 'promotions/'+typeFilter);
                },
                success: function(response){
                    if (response != 0) {
                        if (windowWidth > 1250) {
                            $('.promotions-right-container').append(response);
                        }
                        else{
                            hideLeftPromotions ();
                            setTimeout(() => {
                                $('.promotions-right-container').append(response);
                            }, 400);
                        }
                    }
                },
                complete: function(response){
                    $("#loader_load").hide();
                }
            });
        })

        // reset filter promotions
        $('#reset_promotion_button').on('click',function() {
            var typeFilter = 'filter';
            var rechercheText = '';
            var categoriePrm = '';
            var professionPrm = '';
            var dateDebutPrm = '';
            var dateFinPrm = '';
            var villePrm = '';
            var communePrm = '';
            var fd = new FormData();
            fd.append('type_filter',typeFilter);
            fd.append('text',rechercheText);
            fd.append('categorie_prm',categoriePrm);
            fd.append('profession_prm',professionPrm);
            fd.append('date_debut_prm',dateDebutPrm);
            fd.append('date_fin_prm',dateFinPrm);
            fd.append('ville_prm',villePrm);
            fd.append('commune_prm',communePrm); 
            $.ajax({
                url: 'filter-promotion.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".promotions-right-container").empty();
                    $("#loader_load").show();
                    history.replaceState(null,'', 'promotions/filter/0/0/0/0/0/0');
                },
                success: function(response){
                    if (response != 0) {
                        if (windowWidth > 1250) {
                            $('.promotions-right-container').append(response);
                        }
                        else{
                            hideLeftPromotions ();
                            setTimeout(() => {
                                $('.promotions-right-container').append(response);
                            }, 400);
                        }
                    }
                },
                complete: function(response){
                    $('#promotion_categories option:eq(0)').prop('selected',true);
                    $('.profession-promotion option:eq(0)').prop('selected',true);
                    $('#promotion_localisation option:eq(0)').prop('selected',true);
                    $('.commune-promotion-filter option:eq(0)').prop('selected',true);
                    $("#loader_load").hide();
                }
            });
        })

        // update product promotion overview
        $('#update_promotion_container').on('click','[id^="product_promotion_overview_"]',function(){
            var id = $(this).attr("id").split("_")[3];
            var idPrd = $('#id_prd_ovrw_'+id).val();
            var idPrm = $('#id_updt_promotion').val();
            var fd = new FormData();
            fd.append('id_prd',idPrd);
            fd.append('id_prm',idPrm);
            $.ajax({
                url: 'update-promotion-product-update.php',
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
                        $('#create_promotion_product_bottom_container').prepend(response);
                    }
                },
                complete: function(){
                    $("#loader_create_promotion_product_bottom").hide();
                }
            });
        }) 

        // load user promotion to create product promotion
        $('#update_promotion_container').on('click','#select_promotion_product',function(){
            $.ajax({
                url: 'load-user-promotion-promotion.php',
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

        // load product promotion to create product promotion
        $('#update_promotion_container').on('click','[id^="user_promotion_promotion_"]',function(){
            id = $(this).attr("id").split("_")[3];
            var idBtq = $('#id_btq_prm_'+id).val();
            var idPrm = $('#id_updt_promotion').val();
            var fd = new FormData();
            fd.append('id_btq',idBtq);
            fd.append('id_prm',idPrm);
            $.ajax({
                url: 'load-product-promotion-promotion.php',
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

        // back to user promotions
        $('#update_promotion_container').on('click','#back_to_promotion_user_promotion',function(){
            $.ajax({
                url: 'load-user-promotion-promotion.php',
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

        // load form to create new product promotion
        $('#update_promotion_container').on('click','#create_new_promotion_product',function(){
            var idPrm = $('#id_updt_promotion').val();
            var fd = new FormData();
            fd.append('id_prm',idPrm);
            $.ajax({
                url: 'create-new-product-promotion-update.php',
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
        $('#update_promotion_container').on('click','[id^="product_promotion_promotion_details_"]',function(){
            var id = $(this).attr("id").split("_")[4];
            var idPrm = $('#id_updt_promotion').val();
            var idPrd = $('#id_prd_prm_'+id).val();
            var idBtq = $('#id_btq_prm').val();
            var fd = new FormData();
            fd.append('id_prm',idPrm);
            fd.append('id_prd',idPrd);
            fd.append('id_btq',idBtq);
            $.ajax({
                url: 'load-product-promotion-promotion-details.php',
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

        // back to promotion product
        $('#update_promotion_container').on('click','#back_to_promotion_product_promotion',function(){
            var idBtq = $('#id_btq_prm').val();
            var idPrm = $('#id_updt_promotion').val();
            var fd = new FormData();
            fd.append('id_btq',idBtq);
            fd.append('id_prm',idPrm);
            $.ajax({
                url: 'load-product-promotion-promotion.php',
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

        // select product image for product promotion
        $('#update_promotion_container').on('click','[id^="promotion_product_image_"]',function(){
            $('.promotion-product-image').removeClass('selected-product-promotion-image');
            $('.promotion-product-image i').remove();
            $('.promotion-product-image img').css('opacity','');
            $(this).addClass('selected-product-promotion-image');
            $(this).append('<i class="fas fa-check etat"></i>');
            $(this).find('img').css('opacity','.6');
        })

        function backToPromotionProductPromotion(idBtq,idPrm){
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

        // create product promotion promotion 
        $('#update_promotion_container').on('click','#valide_product_promotion',function(){
            var idPrm = $('#id_updt_promotion').val();
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
                        console.log(response);
                        if(response != 0){
                            backToPromotionProductPromotion(idBtq,idPrm);
                        }
                    },
                    complete: function(){
                        $("#loader_create_promotion_product_button").hide();
                    }
                });
            }
        })

        // delete product promotion promotion
        $('#update_promotion_container').on('click','[id^="delete_product_promotion_promotion_"]',function(){
            var id = $(this).attr("id").split("_")[4];
            var idPrm = $('#id_updt_promotion').val();
            var idPrd = $('#id_prd_prm_'+id).val();
            var idBtq = $('#id_btq_prm').val();
            var fd = new FormData();
            fd.append('id_prm',idPrm);
            fd.append('id_prd',idPrd);
            fd.append('id_btq',idBtq);
            $.ajax({
                url: 'delete-product-promotion-promotion.php',
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
                        backToPromotionProductPromotion(idBtq,idPrm);
                    }
                },
                complete: function(){
                    $("#loader_create_promotion_product_bottom").hide();
                }
            });
        })

        // update product boutique promotion overview
        $('#update_promotion_container').on('click','[id^="product_boutique_promotion_overview_"]',function(){
            var id = $(this).attr("id").split("_")[4];
            var idPrm = $('#id_updt_promotion').val();
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

        // update product promotion promotion overview
        $('#update_promotion_container').on('click','[id^="product_promotion_promotion_overview_"]',function(){
            var id = $(this).attr("id").split("_")[4];
            var idPrm = $('#id_updt_promotion').val();
            var idPrd = $('#id_prd_btq_ovrw_'+id).val();
            var idBtq = $('#id_btq_prd_ovrw_'+id).val();
            var fd = new FormData();
            fd.append('id_prm',idPrm);
            fd.append('id_prd',idPrd);
            fd.append('id_btq',idBtq);
            $.ajax({
                url: 'load-product-promotion-promotion-details.php',
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

        // cancel product promotion overview
        $('#update_promotion_container').on('click','#cancel_product_promotion_overview',function(){
            var idPrm = $('#id_updt_promotion').val();
            var fd = new FormData();
            fd.append('id_prm',idPrm);
            $.ajax({
                url: 'create-new-product-promotion-update.php',
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

        // delete product promotion overview
        $('#update_promotion_container').on('click','#delete_product_promotion_overview',function(){
            var idPrd = $('#id_promotion_product').val();
            var idPrm = $('#id_updt_promotion').val();
            var fd = new FormData();
            fd.append('id_prd',idPrd);
            fd.append('id_prm',idPrm);
            $.ajax({
                url: 'delete-promotion-product-overview-update.php',
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
        
        // create other promotion product
        $('#update_promotion_container').on('click','#add_new_product_promotion',function(){
            var idPrm = $('#id_updt_promotion').val();
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
            else if ($('.promotion-product-images-preview').is(':empty')){
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
                    url: 'add-new-product-promotion-update.php',
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
        })

        // load user boutique to create product promotion
        $('#update_promotion_container').on('click','#select_boutique_product',function(){
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
        $('#update_promotion_container').on('click','[id^="user_boutique_promotion_"]',function(){
            id = $(this).attr("id").split("_")[3];
            var idBtq = $('#id_btq_prm_'+id).val();
            var idPrm = $('#id_updt_promotion').val();
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

        // delete product boutique promotion
        $('#update_promotion_container').on('click','[id^="delete_product_boutique_promotion_"]',function(){
            var id = $(this).attr("id").split("_")[4];
            var idPrm = $('#id_updt_promotion').val();
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

        // load product details to create product promotion
        $('#update_promotion_container').on('click','[id^="product_boutique_promotion_details_"]',function(){
            var id = $(this).attr("id").split("_")[4];
            var idPrm = $('#id_updt_promotion').val();
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
        $('#update_promotion_container').on('click','#back_to_boutique_product_promotion',function(){
            var idBtq = $('#id_btq_prm').val();
            var idPrm = $('#id_updt_promotion').val();
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

        // back to user boutiques
        $('#update_promotion_container').on('click','#back_to_boutique_user_promotion',function(){
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

        // final update promotion
        $('#update_promotion_container').on('click','#final_update_promotion_button',function(){
            var idPrm = $('#id_updt_promotion').val();
            var tailPrm = $('#tail_updt_promotion').val();
            var titrePrm = $('#updt_titre_prm').val();
            var categoriePrm = $('#categorie_prm').val();
            var sousCategoriePrm = $('#sous_categorie_prm').val();
            var villePrm = $('#ville_promotion').val();
            var communePrm = $('#commune_promotion').val();  
            var adressePrm = $('#updt_adresse_prm').val();
            var latitudePrm = $('#updt_latitude_prm').val();
            var longitudePrm = $('#updt_longitude_prm').val();
            var dateDebutPrm = $('#updt_date_debut_prm').val();
            var dateFinPrm = $('#updt_date_fin_prm').val();
            var descriptionPrm = $('#updt_description_prm').val();
            var namePrd = $('#name_prm_prd').val();
            var oldPricePrd = $('#old_price_prm_prd').val();
            var newPricePrd = $('#new_price_prm_prd').val();
            if ($('.promotion-update-images-preview').is(':empty')){
                $('.create-promotion-options').css('border','2px solid red');
            }
            else if (titrePrm == '') {
                $('.create-promotion-options').css('border','');
                $('#updt_titre_prm').css('border','2px solid red');
            }
            else if (categoriePrm == '') {
                $('.create-promotion-options').css('border','');
                $('#updt_titre_prm').css('border','');
                $('#categorie_prm').css('border','2px solid red');
            }
            else if (sousCategoriePrm == '') {
                $('.create-promotion-options').css('border','');
                $('#updt_titre_prm').css('border','');
                $('#categorie_prm').css('border','');
                $('#sous_categorie_prm').css('border','2px solid red');
            }
            else if (villePrm == '') {
                $('.create-promotion-options').css('border','');
                $('#updt_titre_prm').css('border','');
                $('#categorie_prm').css('border','');
                $('#sous_categorie_prm').css('border','');
                $('#ville_promotion').css('border','2px solid red');
            }
            else if (communePrm == '') {
                $('.create-promotion-options').css('border','');
                $('#updt_titre_prm').css('border','');
                $('#categorie_prm').css('border','');
                $('#sous_categorie_prm').css('border','');
                $('#ville_promotion').css('border','');
                $('#commune_promotion').css('border','2px solid red');
            }
            else if (adressePrm == '') {
                $('.create-promotion-options').css('border','');
                $('#updt_titre_prm').css('border','');
                $('#categorie_prm').css('border','');
                $('#sous_categorie_prm').css('border','');
                $('#ville_promotion').css('border','');
                $('#commune_promotion').css('border','');
                $('#updt_adresse_prm').css('border','2px solid red');
            }
            else if (dateDebutPrm == '') {
                $('.create-promotion-options').css('border','');
                $('#updt_titre_prm').css('border','');
                $('#categorie_prm').css('border','');
                $('#sous_categorie_prm').css('border','');
                $('#ville_promotion').css('border','');
                $('#commune_promotion').css('border','');
                $('#updt_adresse_prm').css('border','');
                $('#updt_date_debut_prm').css('border','2px solid red');
            }
            else if (dateFinPrm == '') {
                $('.create-promotion-options').css('border','');
                $('#updt_titre_prm').css('border','');
                $('#categorie_prm').css('border','');
                $('#sous_categorie_prm').css('border','');
                $('#ville_promotion').css('border','');
                $('#commune_promotion').css('border','');
                $('#updt_adresse_prm').css('border','');
                $('#updt_date_debut_prm').css('border','');
                $('#updt_date_fin_prm').css('border','2px solid red');
            }
            else if (descriptionPrm == '') {
                $('.create-promotion-options').css('border','');
                $('#updt_titre_prm').css('border','');
                $('#categorie_prm').css('border','');
                $('#sous_categorie_prm').css('border','');
                $('#ville_promotion').css('border','');
                $('#commune_promotion').css('border','');
                $('#updt_adresse_prm').css('border','');
                $('#updt_date_debut_prm').css('border','');
                $('#updt_date_fin_prm').css('border','');
                $('#updt_description_prm').css('border','2px solid red');
            }
            else{
                $('#updt_description_prm').css('border','');
                var fd = new FormData();
                fd.append('id_prm',idPrm);
                $.ajax({
                    url: 'verify-promotion-product-created.php',
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
                                    updatePromotion(idPrm);
                                }
                            }
                            else{
                                updatePromotion(idPrm);
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

        function updatePromotion (idPrm) {
            var tailPrm = $('#tail_updt_promotion').val();
            var titrePrm = $('#updt_titre_prm').val();
            var categoriePrm = $('#categorie_prm').val();
            var sousCategoriePrm = $('#sous_categorie_prm').val();
            var villePrm = $('#ville_promotion').val(); 
            var communePrm = $('#commune_promotion').val();
            var adressePrm = $('#updt_adresse_prm').val();
            var latitudePrm = $('#updt_latitude_prm').val();
            var longitudePrm = $('#updt_longitude_prm').val();
            var dateDebutPrm = $('#updt_date_debut_prm').val();
            var dateFinPrm = $('#updt_date_fin_prm').val();
            var descriptionPrm = $('#updt_description_prm').val();

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
            fd.append('tail_prm',tailPrm);
            fd.append('titre_prm',titrePrm);
            fd.append('categorie_prm',categoriePrm);
            fd.append('sous_categorie_prm',sousCategoriePrm);
            fd.append('ville_prm',villePrm);
            fd.append('commune_prm',communePrm);
            fd.append('adresse_prm',adressePrm);
            fd.append('latitude_prm',latitudePrm);
            fd.append('longitude_prm',longitudePrm);
            fd.append('date_debut_prm',dateDebutPrm);
            fd.append('date_fin_prm',dateFinPrm);
            fd.append('description_prm',descriptionPrm);

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
                url: 'update-promotion.php',
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
                        if (windowWidth > 768) {
                            $("#update_promotion").hide();
                            $("body").removeClass('body-after');
                        }
                        else{
                            $("#update_promotion").css('transform','');
                        }
                        setTimeout(() => {
                            $("#update_promotion_container").empty();
                        }, 400);
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

        <?php if (isset($_SESSION['user'])) { ?>
        var uid = <?php echo $uid; ?>;
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