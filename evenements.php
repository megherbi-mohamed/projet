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
    <link rel="stylesheet" href="css-js/evenements.css">
    <link href="css-js/fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fugaz One">
    <title>Evenements</title>
</head>
<body>
<?php include './navbar.php'; ?>
    <div class="clear"></div>
    <div class="evenements-recherche-responsive">
        <div class="evenements-recherche-responsive-container">
            <div class="show-hide-menu" id="show_hide_menu">
                <i class="fas fa-bars"></i>
            </div> 
            <div class="logo-name">
                <h4>Nhannik</h4>
            </div> 
            <div id="back_menu">
                <i class="fas fa-arrow-left"></i>
            </div>    
            <div id="evenements_recherche_responsive">
                <input type="text" id="recherche_text_resp" placeholder="Chercher une evenement ..." autocomplete="off">
                <i class="fas fa-search"></i>
            </div>
            <div id="display_categories">
                <i class="fas fa-sliders-h"></i>
            </div>
            <div id="display_evn_search_bar">
                <i class="fas fa-search"></i>
            </div>
        </div>
    </div>
    <div class="evenements-left">
        <h2>evenements</h2>
        <div class="evenements-recherche">
            <input type="text" id="recherche_text" placeholder="Chercher un produit ...">
            <i class="fas fa-search"></i>
        </div>
        <hr>
        <?php if (isset($_SESSION['user'])) { ?>
        <div class="evenements-user">
            <div class="display-evenements-user" id="display_evenements_user">
                <div>
                    <i class="far fa-calendar-check"></i>
                </div>
                <p>Vos evenements</p>
                <div class="evenements-notification">
                    <div id="evenements_ntf">
                        <span>0</span>
                    </div>
                </div>
            </div>
            <div class="display-evenements-user" id="display_saved_evenements_user">
                <div>
                    <i class="fas fa-bookmark"></i>
                </div>
                <p>evenements interésantes</p>
                <div class="evenements-notification">
                    <div id="evenements_ntf">
                        <span>0</span>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <hr>
        <div class="filter-evenements-options">
            <div class="filter-evenement-button">
                <h4>Filtrer par</h4>
                <button id="reset_evenement_button">Réintialiser</button>
                <button id="filter_evenement_button">Filtrer</button>
            </div>
            <div class="quick-filter-button">
                <button id="today_filter_button">Aujourd'hui</button>
                <button id="week_filter_button">Cette semaine</button>
                <button id="month_filter_button">Ce mois</button>
            </div>
            <div class="filter-evenement" id="display_evenements_date">
                <div>
                    <i class="far fa-calendar-alt"></i>
                </div>
                <p>Date</p>
            </div>
            <div class="filter-ptomotion-option" id="evenement_date">
                <div class="filter-evenement-input">
                    <p>Debut d'évènement</p>
                    <input type="date" id="date_debut_evn">
                </div>
                <div class="filter-evenement-input">
                    <p>Fin d'évènement</p>
                    <input type="date" id="date_fin_evn">
                </div>
            </div>
            <div class="filter-evenement" id="display_evenements_localisation">
                <div>
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <p>Lieu</p>
            </div>
            <div class="filter-ptomotion-option" id="evenement_localisation">
                <div class="filter-evenement-input">
                    <p>Ville</p>
                    <select id="ville_evenement_filter">
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
                <div class="filter-evenement-input commune-evenement-filter"> 
                    <p>Commune</p>
                    <select id="commune_evenement_filter">
                        <option value="">Commune</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="evenements-right">
        <div class="evenements-right-container"></div>
        <div id="loader_load" class="center"></div>
    </div>
    <div class="evenement-position">
        <div class="evenement-position-container" id="evenement_position_container">
            <div class="evenement-position-top">
                <div class="cancel-evenement-position-resp" id="cancel_evenement_position_resp">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <h4>La position d'évènement ()</h4>
                <div class="cancel-evenement-position" id="cancel_evenement_position">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="evenement-position-middle"></div>
            <div class="evenement-position-bottom">
                <p>Voir la direction de cette evenement sur google map</p>
                <button id="show_evenement_direction">Direction <i class="fas fa-directions"></i></button>
                <input type="hidden" id="latitude_evn">
                <input type="hidden" id="longitude_evn">
            </div>
        </div>
    </div>
    <div class="evenement-video">
        <div class="evenement-video-container" id="evenement_video_container">
            <div class="evenement-video-top">
                <div class="cancel-evenement-video-resp" id="cancel_evenement_video_resp">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <h4>Video</h4>
                <div class="cancel-evenement-video" id="cancel_evenement_video">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="evenement-video-bottom" id="evenement_video_bottom"></div>  
        </div>
    </div>
    <div class="delete-evenement" id="delete_evenement">
        <div class="delete-evenement-container" id="delete_evenement_container">
            <input type="hidden" id="evenement_tail_delete">
            <input type="hidden" id="id_evenement_delete">
            <div class="delete-evenement-top">
                <h4>Supprimer l'évènement ?</h4>
                <div class="cancel-delete-evenement" id="cancel_delete_evenement">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="delete-evenement-middle">
                <p>Voulez vous vraiment Supprimer l'évènement ?</p>
            </div>
            <div class="delete-evenement-bottom">
                <div></div>
                <div></div>
                <button id="cancel_delete_evn_button">Annuler</button>
                <button id="delete_evn_button">Supprimer</button>
            </div>
        </div>
    </div>
    <div class="create-publication" id="update_evenement">
        <div class="create-publication-container" id="update_evenement_container"></div>
        <div id="loader_update_evenement" class="center"></div>
    </div>
    <div class="evenement-details" id="evenement_details">
        <div class="evenement-details-container" id="evenement_details_container"></div>
        <div class="cancel-evenement-details" id="cancel_evenement_details">
            <i class="fas fa-times"></i>
        </div>  
        <div id="loader_evenement_details" class="center"></div>
    </div>
    <div id="loader" class="center"></div>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBEGrApnjX_7GHcNDtF0LR0pgrwxj5j2Q&callback=initevnMap"></script>
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
                $.ajax({
                    url: 'load-all-evenements.php',
                    beforeSend: function(){
                        $("#loader_load").show();
                    },
                    success: function(response){
                        $('.evenements-right-container').append(response);
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
            } 
        };

        $(window).on('load',function(){
            if (history.state === 'evenements') {
                $('.display-evenements-user').css('background','');
                $('#display_evenements_user').css('background','#ecedee');
                $.ajax({
                    url: 'load-user-evenements.php',
                    beforeSend: function(){
                        $(".evenements-right-container").empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        history.replaceState('evenements','', '/projet/evenements/vos-evenements');
                        $('.evenements-right-container').append(response);
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
            }
            if (history.state === 'savedevenements') {
                $('.display-evenements-user').css('background','');
                $('#display_saved_evenements_user').css('background','#ecedee');
                $.ajax({
                    url: 'load-saved-user-evenements.php',
                    beforeSend: function(){
                        $(".evenements-right-container").empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        history.replaceState('savedevenements','', '/projet/evenements/saved-evenements');
                        $('.evenements-right-container').append(response);
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
            }
            if (history.state === 'allevenements') {
                $('.display-evenements-user').css('background','');
                $.ajax({
                    url: 'load-all-evenements.php',
                    beforeSend: function(){
                        $(".evenements-right-container").empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        history.replaceState('allevenements','', '/projet/evenements');
                        $('.evenements-right-container').append(response);
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
            }

        })

        $(window).on('popstate',function(){
            if (history.state === 'evenements') {
                $('.display-evenements-user').css('background','');
                $('#display_evenements_user').css('background','#ecedee');
                $.ajax({
                    url: 'load-user-evenements.php',
                    beforeSend: function(){
                        $(".evenements-right-container").empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        $('.evenements-right-container').append(response);
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
            }
            if (history.state === 'savedevenements') {
                $('.display-evenements-user').css('background','');
                $('#display_saved_evenements_user').css('background','#ecedee');
                $.ajax({
                    url: 'load-saved-user-evenements.php',
                    beforeSend: function(){
                        $(".evenements-right-container").empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        $('.evenements-right-container').append(response);
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
            }
            if (history.state === 'allevenements' || history.state === null) {
                $('.display-evenements-user').css('background','');
                $.ajax({
                    url: 'load-all-evenements.php',
                    beforeSend: function(){
                        $(".evenements-right-container").empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        $('.evenements-right-container').append(response);
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
            }
        })

        // display user evenements
        $('#display_evenements_user').click(function(){
            $('.display-evenements-user').css('background','');
            $(this).css('background','#ecedee');
            $.ajax({
                url: 'load-user-evenements.php',
                beforeSend: function(){
                    $(".evenements-right-container").empty();
                    $("#loader_load").show();
                },
                success: function(response){
                    history.pushState('evenements','', '/projet/evenements/vos-evenements');
                    if (windowWidth < 768) {
                        $('.evenements-left').css('transform','');
                        $("body").removeClass('body-after');
                        setTimeout(() => {
                            $('.evenements-right-container').append(response);
                        }, 400);
                    }
                    else{
                        $('.evenements-right-container').append(response);
                    }
                },
                complete: function(response){
                    $("#loader_load").hide();
                }
            });
        })

        // display saved user evenements
        $('#display_saved_evenements_user').click(function(){
            $('.display-evenements-user').css('background','');
            $(this).css('background','#ecedee');
            $.ajax({
                url: 'load-saved-user-evenements.php',
                beforeSend: function(){
                    $(".evenements-right-container").empty();
                    $("#loader_load").show();
                },
                success: function(response){
                    history.pushState('savedevenements','', '/projet/evenements/saved-evenements');
                    if (windowWidth < 768) {
                        $('.evenements-left').css('transform','');
                        $("body").removeClass('body-after');
                        setTimeout(() => {
                            $('.evenements-right-container').append(response);
                        }, 400);
                    }
                    else{
                        $('.evenements-right-container').append(response);
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
            $('.evenements-left').css('transform','translateX(0)');
        })

        $('#evenements_recherche_responsive').click(function(e){
            e.stopPropagation();
        })

        $('#display_evn_search_bar').click(function(e){
            e.stopPropagation();
            setEvenementsSearchBar();
        })

        // searche for evenements
        $(document).on('keypress',"#recherche_text",function() {
            if (event.which == 13) {
                var fd = new FormData();
                var rechercheText = $('#recherche_text').val();
                fd.append('text',rechercheText);
                $.ajax({
                    url: 'recherche-evenements.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $(".evenements-right-container").empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        $('.evenements-right-container').append(response);
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
            }
        });

        $(document).on('keypress',"#recherche_text_resp",function() {
            if (event.which == 13) {
                var fd = new FormData();
                var rechercheText = $('#recherche_text_resp').val();
                fd.append('text',rechercheText);
                $.ajax({
                    url: 'recherche-evenements.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $(".evenements-right-container").empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        $('.evenements-right-container').append(response);
                    },
                    complete: function(response){
                        unsetEvenementsSearchBar();
                        $("#loader_load").hide();
                    }
                });
            }
        });

        // display evenement position
        $('.evenement-position').click(function(){
            $('body').removeClass('body-after');
            $('.evenement-position').hide();
        })

        $('.evenement-position-container').click(function(e){
            e.stopPropagation();
        })

        $('.evenement-position-container').on('click','#cancel_evenement_position',function(){
            $('body').removeClass('body-after');
            $('.evenement-position').hide();
        })

        $('.evenement-position-container').on('click','#cancel_evenement_position_resp',function(){
            $('.evenement-position').css('transform','');
        })

        $(document).on('click','[id^="show_evenement_position_"]',function(){
            var id = $(this).attr("id").split("_")[3];
            var latitudeEvn = $('#latitude_evn_'+id).val();
            var longitudeEvn = $('#longitude_evn_'+id).val();
            $('#latitude_evn').val(latitudeEvn);
            $('#longitude_evn').val(longitudeEvn);
            if (windowWidth > 768) {
                $('body').addClass('body-after');
                $('.evenement-position').show();
            }
            else{
                $('.evenement-position').css('transform','translateX(0)');
            }
            initevnMap(latitudeEvn, longitudeEvn);   
        })

        function initevnMap(lat,lng) {
            var map = new google.maps.Map(document.querySelector('.evenement-position-middle'), {
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

        $('.evenements-right-container').on('click','[id^="show_evenement_direction_"]',function(){
            var id = $(this).attr("id").split("_")[3];
            var latitudeEvn = $('#latitude_evn_'+id).val();
            var longitudeEvn = $('#longitude_evn_'+id).val();
            url = "https://maps.google.com/?q="+latitudeEvn+","+longitudeEvn;
            window.open(url, '_blank');
        })

        $('#evenement_position_container').on('click','#show_evenement_direction',function(){
            var latitudeEvn = $('#latitude_evn').val();
            var longitudeEvn = $('#longitude_evn').val();
            url = "https://maps.google.com/?q="+latitudeEvn+","+longitudeEvn;
            window.open(url, '_blank');
        })

        // display evenement video
        $('.evenement-video').click(function(){
            $('body').removeClass('body-after');
            $('.evenement-video').hide();
            $('#evenement_video_bottom').empty();
        })

        $('.evenement-video-container').click(function(e){
            e.stopPropagation();
        })

        $('#cancel_evenement_video').on('click',function(){
            $('body').removeClass('body-after');
            $('.evenement-video').hide();
            $('#evenement_video_bottom').empty();
        })

        $('#cancel_evenement_video_resp').on('click',function(){
            $('.evenement-video').css('transform','');
            setTimeout(() => {
                $('#evenement_video_bottom').empty();
            }, 400);
        })

        $(document).on('click','[id^="show_evenement_video_"]',function(){
            var id = $(this).attr("id").split("_")[3];
            $('.evenement-video').show();
            $("body").addClass('body-after');
            var src = $('#evenement_video_'+id).find('source').attr('src');
            $('#evenement_video_bottom').append('<video controls><source src="'+src+'"></video>')
        })

        // delete evenement
        $(document).on('click','[id^="delete_evn_"]',function(){
            id = $(this).attr("id").split("_")[2];
            var idEvn = $('#id_evn_'+id).val();
            var evnTail = $('#tail_evn_'+id).val();
            $('#id_evenement_delete').val(idEvn);
            $('#evenement_tail_delete').val(evnTail);
            $("body").addClass('body-after');
            if (windowWidth > 768) {
                $('#delete_evenement').show();
            }else{
                $('#delete_evenement').css('transform','translateY(0)');
            }
        });

        $('#delete_evenement_container').click(function(e){
            e.stopPropagation();
        })

        $('#delete_evn_button').click(function(){
            var fd = new FormData();
            var idEvn = $('#id_evenement_delete').val();
            fd.append('id_evn',idEvn);
            var evnTail = $('#evenement_tail_delete').val();
            $.ajax({
                url: 'delete-evenement.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response != 0){
                        $("body").removeClass('body-after');
                        if (windowWidth > 768) {
                            $('#delete_evenement').hide();
                        }else{
                            $('#delete_evenement').css('transform','');
                        }
                        $('#evenement_user_overview_'+evnTail).remove();
                    }
                }
            });
        });

        $('#cancel_delete_evenement').click(function(e){
            e.stopPropagation();
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $('#delete_evenement').hide();
            }else{
                $('#delete_evenement').css('transform','');
            }
        });

        $('#cancel_delete_evn_button').click(function(e){
            e.stopPropagation();
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $('#delete_evenement').hide();
            }else{
                $('#delete_evenement').css('transform','');
            }
        });

        $('#delete_evenement').click(function(e){
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $('#delete_evenement').hide();
            }else{
                $('#delete_evenement').css('transform','');
            }
        });

        // filter evenements
        $('.evenements-left').click(function(e){
            e.stopPropagation();
        })

        $('#display_evenements_date').click(function(){
            if ($('#evenement_date').height() > 0) {
                $('#evenement_date').css({'max-height':''});
            }
            else{
                $('#evenement_date').css({'max-height':'127px'});
            }
        })

        $('#display_evenements_localisation').click(function(){
            if ($('#evenement_localisation').height() > 0) {
                $('#evenement_localisation').css({'max-height':''});
            }
            else{ 
                $('#evenement_localisation').css({'max-height':'127px'});
            }
        })

        $('#ville_evenement_filter').on('change',function() {
            var ville  = $(this).val();
            if (ville !== '') {
                $('.commune-evenement-filter').load('commune-filter-evenement.php?v='+ville);
            }
        })
        
        $('#filter_evenement_button').on('click',function() {
            var typeFilter = 'all';
            var dateDebutEvn = $('#date_debut_evn').val();
            var dateFinEvn = $('#date_fin_evn').val();
            var villeEvn = $('#ville_evenement_filter').val();
            var communeEvn = $('#commune_evenement_filter').val();
            var fd = new FormData();
            fd.append('type_filter',typeFilter);
            fd.append('date_debut_evn',dateDebutEvn);
            fd.append('date_fin_evn',dateFinEvn);
            fd.append('ville_evn',villeEvn);
            fd.append('commune_evn',communeEvn);
            $.ajax({
                url: 'filter-evenement.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".evenements-right-container").empty();
                    $("#loader_load").show();
                },
                success: function(response){
                    if (response != 0) {
                        if (windowWidth > 768) {
                            $('.evenements-right-container').append(response);
                        }
                        else{
                            $('.evenements-left').css('transform','');
                            $("body").removeClass('body-after');
                            setTimeout(() => {
                                $('.evenements-right-container').append(response);
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
            var d = new Date();
            var dateDebutEvn = d.toLocaleDateString();
            var dateFinEvn = '';
            var villeEvn = '';
            var communeEvn = '';
            var fd = new FormData();
            fd.append('type_filter',typeFilter);
            fd.append('date_debut_evn',dateDebutEvn);
            fd.append('date_fin_evn',dateFinEvn);
            fd.append('ville_evn',villeEvn);
            fd.append('commune_evn',communeEvn); 
            $.ajax({
                url: 'filter-evenement.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".evenements-right-container").empty();
                    $("#loader_load").show();
                },
                success: function(response){
                    if (response != 0) {
                        if (windowWidth > 768) {
                            $('.evenements-right-container').append(response);
                        }
                        else{
                            $('.evenements-left').css('transform','');
                            $("body").removeClass('body-after');
                            setTimeout(() => {
                                $('.evenements-right-container').append(response);
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
            var d = new Date();
            var dateDebutEvn = firstDay;
            var dateFinEvn = lastDay;
            var villeEvn = '';
            var communeEvn = '';
            var fd = new FormData();
            fd.append('type_filter',typeFilter);
            fd.append('date_debut_evn',dateDebutEvn);
            fd.append('date_fin_evn',dateFinEvn);
            fd.append('ville_evn',villeEvn);
            fd.append('commune_evn',communeEvn); 
            $.ajax({
                url: 'filter-evenement.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".evenements-right-container").empty();
                    $("#loader_load").show();
                },
                success: function(response){
                    if (response != 0) {
                        if (windowWidth > 768) {
                            $('.evenements-right-container').append(response);
                        }
                        else{
                            $('.evenements-left').css('transform','');
                            $("body").removeClass('body-after');
                            setTimeout(() => {
                                $('.evenements-right-container').append(response);
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
            var d = new Date();
            var dateDebutEvn = firstDay;
            var dateFinEvn = lastDay;
            var villeEvn = '';
            var communeEvn = '';
            var fd = new FormData();
            fd.append('type_filter',typeFilter);
            fd.append('date_debut_evn',dateDebutEvn);
            fd.append('date_fin_evn',dateFinEvn);
            fd.append('ville_evn',villeEvn);
            fd.append('commune_evn',communeEvn); 
            $.ajax({
                url: 'filter-evenement.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".evenements-right-container").empty();
                    $("#loader_load").show();
                },
                success: function(response){
                    if (response != 0) {
                        if (windowWidth > 768) {
                            $('.evenements-right-container').append(response);
                        }
                        else{
                            $('.evenements-left').css('transform','');
                            $("body").removeClass('body-after');
                            setTimeout(() => {
                                $('.evenements-right-container').append(response);
                            }, 400);
                        }
                    }
                },
                complete: function(response){
                    $("#loader_load").hide();
                }
            });
        })

        // reset filter evenements
        $('#reset_evenement_button').on('click',function() {
            $.ajax({
                url: 'load-all-evenements.php',
                beforeSend: function(){
                    $(".evenements-right-container").empty();
                    $("#loader_load").show();
                },
                success: function(response){
                    if (response != 0) {
                        $('.evenements-right-container').append(response);
                    }
                },
                complete: function(response){
                    $('#evenement_localisation option:eq(0)').prop('selected',true);
                    $('.commune-evenement-filter option:eq(0)').prop('selected',true);
                    $("#loader_load").hide();
                }
            });
        })

        // save evenement
        $(document).on('click','[id^="save_evenement_"]',function(){
            var id = $(this).attr("id").split("_")[2];
            var idEvn = $('#id_evenement_'+id).val();
            var fd = new FormData();
            fd.append('id_evn',idEvn);
            $.ajax({
                url: 'save-evenements.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response != 0){
                        $('#save_evenement_'+id).replaceWith('<p>interessé(e)</p>');
                    }
                }
            });
        })

        // update evenement view
        $(document).on('click','[id^="updt_view_"]',function(){
            var id = $(this).attr("id").split("_")[2];
            var idEvn = $('#id_evenement_'+id).val();
            var fd = new FormData();
            fd.append('id_evn',idEvn);
            $.ajax({
                url: 'updt-evenements-views.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response != 0){
                        var participat = parseInt($('#evenement_participate_'+id).find('span').text());
                        $('#evenement_participate_'+id).find('span').text(participat+1);
                        $('#updt_view_'+id).replaceWith('<p>participé(e)</p>');
                    }
                }
            });
        })

        // show evenement details
        $(document).on('click','[id^="evenement_details_button_"]',function(){
            var id = $(this).attr("id").split("_")[3];
            var idEvn = $('#id_evenement_'+id).val();
            var fd = new FormData();
            fd.append('id_evn',idEvn);
            $.ajax({
                url: 'load-evenement-details.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    if (windowWidth > 768) {
                        $("body").addClass('body-after');
                        $("body").css('overflow','hidden');
                        $("#evenement_details").css('display','grid');
                        $('#evenement_details_container').css('height','calc(100vh - 20px)');
                    }
                    else{
                        $("#evenement_details").css('transform','translateX(0)');
                    }
                    $("#loader_evenement_details").show();
                },
                success: function(response){
                    if (response != 0) {
                        $('#evenement_details_container').css('height','');
                        $('#evenement_details_container').prepend(response);
                    }
                },
                complete: function(){
                    $("#loader_evenement_details").hide();
                }
            });
        })

    </script>
</body>
</html>