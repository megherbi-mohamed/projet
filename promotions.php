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
                <div id="back_menu">
                    <i class="fas fa-arrow-left"></i>
                </div>    
                <div id="promotions_recherche_responsive">
                    <input type="text" id="recherche_text_resp" placeholder="Chercher une promotion ..." autocomplete="off">
                    <i class="fas fa-search"></i>
                </div>
                <div id="display_categories">
                    <i class="fas fa-list"></i>
                </div>
                <div id="display_prm_search_bar">
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
            </div>
            <?php } ?>
            <hr>
            <div class="filter-promotions-options">
                <h3>Filtrer par</h3>
                <div class="filter-promotion" id="display_promotions_categories">
                    <div>
                        <i class="fas fa-list-ul"></i>
                    </div>
                    <p>Categories</p>
                </div>
                <div class="filter-promotion" id="display_promotions_calender">
                    <div>
                        <i class="far fa-calendar-alt"></i>
                    </div>
                    <p>Date</p>
                </div>
            </div>
            <div class="promotion-categories">
                <div class="promotion-categories-top">
                    <div id="back_to_promotion_filter">
                        <i class="fas fa-arrow-left"></i>
                    </div>
                    <p>Retour aux categories</p>
                </div>
                <div class="promotion-categories-bottom">
                    <div class="categorie-promotion">
                        <div class="categorie-promotion-top">
                            <img src="./icons/bureau-icon.png" alt="">
                            <p>Services</p>
                        </div>
                        <div class="categorie-promotion-bottom">
                            <?php 
                            $categories_query = $conn->prepare("SELECT * FROM categories WHERE categories = 'services'");
                            $categories_query->execute();
                            while ($categories_row = $categories_query->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <li class="sous-categorie-promotion"><?php echo $categories_row['sous_categories'] ?></li>
                            <?php } ?>
                        </div>
                    </div>  
                    <div class="categorie-promotion">
                        <div class="categorie-promotion-top">
                            <img src="./icons/service-icon.png" alt="">
                            <p>Artisants</p>
                        </div>
                        <div class="categorie-promotion-bottom">
                            <?php 
                            $categories_query = $conn->prepare("SELECT * FROM categories WHERE categories = 'artisants'");
                            $categories_query->execute();
                            while ($categories_row = $categories_query->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <li class="sous-categorie-promotion"><?php echo $categories_row['sous_categories'] ?></li>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="categorie-promotion">
                        <div class="categorie-promotion-top">
                            <img src="./icons/transport-icon.png" alt="">
                            <p>Transports</p>
                        </div>
                        <div class="categorie-promotion-bottom">
                            <?php 
                            $categories_query = $conn->prepare("SELECT * FROM categories WHERE categories = 'transports'");
                            $categories_query->execute();
                            while ($categories_row = $categories_query->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <li class="sous-categorie-promotion"><?php echo $categories_row['sous_categories'] ?></li>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="categorie-promotion">
                        <div class="categorie-promotion-top">
                            <img src="./icons/service-icon.png" alt="">
                            <p>Locations</p>
                        </div>
                        <div class="categorie-promotion-bottom">
                            <?php 
                            $categories_query = $conn->prepare("SELECT * FROM categories WHERE categories = 'locations'");
                            $categories_query->execute();
                            while ($categories_row = $categories_query->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <li class="sous-categorie-promotion"><?php echo $categories_row['sous_categories'] ?></li>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="categorie-promotion">
                        <div class="categorie-promotion-top">
                            <img src="./icons/entreprise-icon.png" alt="">
                            <p>Entreprises</p>
                        </div>
                        <div class="categorie-promotion-bottom">
                            <?php 
                                $categories_query = $conn->prepare("SELECT * FROM categories WHERE categories = 'entreprises'");
                                $categories_query->execute();
                                while ($categories_row = $categories_query->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <li class="sous-categorie-promotion"><?php echo $categories_row['sous_categories'] ?></li>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="categorie-promotion">
                        <div class="categorie-promotion-top">
                            <img src="./icons/detaillon-icon.png" alt="">
                            <p>Detaillons</p>
                        </div>
                        <div class="categorie-promotion-bottom">
                            <?php 
                                $categories_query = $conn->prepare("SELECT * FROM categories WHERE categories = 'detaillons'");
                                $categories_query->execute();
                                while ($categories_row = $categories_query->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <li class="sous-categorie-promotion"><?php echo $categories_row['sous_categories'] ?></li>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="categorie-promotion">
                        <div class="categorie-promotion-top">
                            <img src="./icons/grossiste-icon.png" alt="">
                            <p>Grossistes</p>
                        </div>
                        <div class="categorie-promotion-bottom">
                            <?php 
                                $categories_query = $conn->prepare("SELECT * FROM categories WHERE categories = 'grossistes'");
                                $categories_query->execute();
                                while ($categories_row = $categories_query->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <li class="sous-categorie-promotion"><?php echo $categories_row['sous_categories'] ?></li>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="categorie-promotion">
                        <div class="categorie-promotion-top">
                            <img src="./icons/fabriquant-icon.png" alt="">
                            <p>Fabriquants</p>
                        </div>
                        <div class="categorie-promotion-bottom">
                            <?php 
                                $categories_query = $conn->prepare("SELECT * FROM categories WHERE categories = 'fabriquants'");
                                $categories_query->execute();
                                while ($categories_row = $categories_query->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <li class="sous-categorie-promotion"><?php echo $categories_row['sous_categories'] ?></li>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="categorie-promotion">
                        <div class="categorie-promotion-top">
                            <img src="./icons/importateur-icon.png" alt="">
                            <p>Import - Export</p>
                        </div>
                        <div class="categorie-promotion-bottom">
                            <?php 
                                $categories_query = $conn->prepare("SELECT * FROM categories WHERE categories = 'import-export'");
                                $categories_query->execute();
                                while ($categories_row = $categories_query->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <li class="sous-categorie-promotion"><?php echo $categories_row['sous_categories'] ?></li>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="promotions-right">
            <div class="promotions-right-container">
                <?php 
                $get_all_promotions_query = $conn->prepare("SELECT * FROM promotions ORDER BY id_prm DESC");
                $get_all_promotions_query->execute();
                $i = 0;
                while ($get_all_promotions_row = $get_all_promotions_query->fetch(PDO::FETCH_ASSOC)) {
                    $i++;
                    $date_debut = $get_all_promotions_row['date_debut_prm'];
                    $date_d = DateTime::createFromFormat("Y-m-d H:i:s", $date_debut);
                    $date_ddp = $date_d->format("d-m");
                    $ddp = date('m F', strtotime($date_ddp));

                    $time_debut = $get_all_promotions_row['date_debut_prm'];
                    $time_d = strtotime($time_debut);
                    $tdp = date('H', $time_d);

                    $date_fin = $get_all_promotions_row['date_fin_prm'];
                    $date_f = DateTime::createFromFormat("Y-m-d H:i:s", $date_fin);
                    $date_dfp = $date_f->format("d-m");
                    $dfp = date('m F', strtotime($date_dfp));

                    $time_fin = $get_all_promotions_row['date_fin_prm'];
                    $time_f = strtotime($time_fin);
                    $tfp = date('H', $time_f);

                    $id_prm = $get_all_promotions_row['id_prm'];
                    $get_promotion_img_query = $conn->prepare("SELECT media_url,media_type FROM promotions_media WHERE id_prm = $id_prm");
                    $get_promotion_img_query->execute();
                    $get_promotion_img_row = $get_promotion_img_query->fetch(PDO::FETCH_ASSOC);
                ?>
                <div class="promotion-overview">
                    <div class="promotion-overview-left">
                        <div>
                            <?php if ($get_promotion_img_row['media_type'] == 'i') { ?>
                                <img src="./<?php echo $get_promotion_img_row['media_url'] ?>" alt="">
                            <?php } else { ?>
                                <!-- video -->
                            <?php } ?>
                            <p id="promotion_participate_<?php echo $i ?>">Participants <span><?php echo $get_all_promotions_row['views_prm'] ?></span></p>
                        </div>
                    </div>
                    <div class="promotion-overview-right">
                        <div class="promotion-overview-right-top">
                            <h3><?php echo $get_all_promotions_row['titre_prm'] ?></h3>
                            <h4>Ajoutée le <span><?php echo $get_all_promotions_row['date_prm'] ?></span></h4>
                        </div>
                        <div class="promotion-overview-right-middle">
                            <p><?php echo $get_all_promotions_row['description_prm'] ?></p>
                            <h4>Commencer le : <span><?php echo $ddp.' à '.$tdp.'h' ?></span>
                            , fin le : <span><?php echo $dfp.' à '.$tfp.'h' ?></span></h4>
                            <p><?php echo $get_all_promotions_row['lieu_prm'] ?>, Algérie</p>
                        </div>
                        <div class="promotion-overview-right-bottom">
                            <input type="hidden" id="latitude_prm_<?php echo $i ?>" value="<?php echo $get_all_promotions_row['latitude_prm'] ?>">
                            <input type="hidden" id="longitude_prm_<?php echo $i ?>" value="<?php echo $get_all_promotions_row['longitude_prm'] ?>">
                            <div id="show_promotion_position_<?php echo $i ?>">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div id="show_promotion_direction_<?php echo $i ?>">
                                <i class="fas fa-directions"></i>
                            </div>
                            <input type="hidden" id="id_promotion_<?php echo $i ?>" value="<?php echo $get_all_promotions_row['id_prm'] ?>">
                            <?php
                            $get_saved_promotion_query = $conn->prepare("SELECT * FROM promotions_enregistres WHERE id_prm = $id_prm");
                            $get_saved_promotion_query->execute();
                            if ($get_saved_promotion_query->rowCount() > 0) {
                                $get_saved_promotion_row = $get_saved_promotion_query->fetch(PDO::FETCH_ASSOC);
                                if ($get_saved_promotion_row['id_user'] == $id_user) { ?>
                                <p>interessé(e)</p>
                                <?php } else { ?>
                                <button id="save_promotion_<?php echo $i ?>">interesser</button>
                                <?php }} else { ?>
                                <button id="save_promotion_<?php echo $i ?>">interesser</button>
                            <?php } ?>
                            <?php
                            $get_saved_promotion_query = $conn->prepare("SELECT * FROM promotions_enregistres WHERE id_prm = $id_prm");
                            $get_saved_promotion_query->execute();
                            if ($get_saved_promotion_query->rowCount() > 0) {
                                $get_saved_promotion_row = $get_saved_promotion_query->fetch(PDO::FETCH_ASSOC);
                                if ($get_saved_promotion_row['id_user'] == $id_user) { ?>
                                <p>participé(e)</p>
                                <?php } else { ?>
                                <button id="updt_view_<?php echo $i ?>">participer</button>
                                <?php }} else { ?>
                                <button id="updt_view_<?php echo $i ?>">participer</button>
                            <?php } ?>
                            <button>Voir details</button>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div id="loader_load" class="center"></div>
        </div>
    </div>
    <div class="promotion-position">
        <div class="promotion-position-container">
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
        <div class="create-publication-container" id="update_promotion_container">
            <div id="loader_update_promotion" class="center"></div>
        </div>
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
            } 
        };

        $(window).on('load',function(){
            if (history.state === 'promotions') {
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
            if (history.state === 'allpromotions') {
                $('#display_promotions_user').css('background','');
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
            if (history.state === 'allpromotions' || history.state === null) {
                $('#display_promotions_user').css('background','');
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
            $(this).css('background','#ecedee');
            $.ajax({
                url: 'load-user-promotions.php',
                beforeSend: function(){
                    $(".promotions-right-container").empty();
                    $("#loader_load").show();
                },
                success: function(response){
                    history.pushState('promotions','', '/projet/promotions/vos-promotions');
                    $('.promotions-right-container').append(response);
                },
                complete: function(response){
                    $("#loader_load").hide();
                }
            });
        })

        $('#back_history').click(function(){
            window.history.back();
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
            if (event.which == 13) {
                var fd = new FormData();
                var rechercheText = $('#recherche_text').val();
                fd.append('text',rechercheText);
                $.ajax({
                    url: 'recherche-promotions.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
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
        });

        $(document).on('keypress',"#recherche_text_resp",function() {
            if (event.which == 13) {
                var fd = new FormData();
                var rechercheText = $('#recherche_text_resp').val();
                fd.append('text',rechercheText);
                $.ajax({
                    url: 'recherche-promotions.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $(".promotions-right-container").empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        $('.promotions-right-container').append(response);
                    },
                    complete: function(response){
                        unsetPromotionsSearchBar();
                        $("#loader_load").hide();
                    }
                });
            }
        });

        $('.promotion-position').click(function(){
            $('body').removeClass('body-after');
            $('.promotion-position').hide();
        })

        $('.promotion-position-container').click(function(e){
            e.stopPropagation();
        })

        $('#cancel_promotion_position').click(function(){
            $('body').removeClass('body-after');
            $('.promotion-position').hide();
        })

        $(document).on('click','[id^="show_promotion_position_"]',function(){
            var id = $(this).attr("id").split("_")[3];
            var latitudePrm = $('#latitude_prm_'+id).val();
            var longitudePrm = $('#longitude_prm_'+id).val();
            $('#latitude_prm').val(latitudePrm);
            $('#longitude_prm').val(longitudePrm);
            $('body').addClass('body-after');
            $('.promotion-position').show();
            setTimeout(() => {
                initPrmMap(latitudePrm,longitudePrm);
            }, 500);
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

        $(document).on('click','[id^="show_promotion_direction_"]',function(){
            var id = $(this).attr("id").split("_")[3];
            var latitudePrm = $('#latitude_prm_'+id).val();
            var longitudePrm = $('#longitude_prm_'+id).val();
            url = "https://maps.google.com/?q="+latitudePrm+","+longitudePrm;
            window.open(url, '_blank');
        })

        $('#show_promotion_direction').click(function(){
            var latitudePrm = $('#latitude_prm').val();
            var longitudePrm = $('#longitude_prm').val();
            url = "https://maps.google.com/?q="+latitudePrm+","+longitudePrm;
            window.open(url, '_blank');
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
                    $("body").addClass('body-after');
                    $("#update_promotion").show();
                    $('#update_promotion_container').css({'top':'10px','transform':'translate(-50%,0%)'});
                    $("#loader_update_promotion").show();
                },
                success: function(response){
                    $('#update_promotion_container').prepend(response);
                },
                complete: function(response){
                    $("#loader_update_promotion").hide();
                }
            });
        });

        $('#update_promotion_container').on('click','#cancel_update_promotion_resp',function(){
            $('#update_promotion').css('transform','');
            $('#update_promotion_container').empty();
            $('#update_promotion_container').append('<div id="loader_update_promotion" class="center"></div>');
        })

        $('#update_promotion_container').on('click','#cancel_update_promotion',function(e){
            e.stopPropagation();
            $("body").removeClass('body-after');
            $('#update_promotion').hide();
            $('#update_promotion_container').empty();
            $('#update_promotion_container').append('<div id="loader_update_promotion" class="center"></div>');
        })

        $('#update_promotion').on('click',function(){
            $("body").removeClass('body-after');
            $('#update_promotion').hide();
            $('#update_promotion_container').empty();
            $('#update_promotion_container').append('<div id="loader_update_promotion" class="center"></div>');
        })

        $(document).on('change','#updt_categorie_prm',function() {
            var categorie  = $(this).val();
            if (categorie !== '') {
                $('.updt-sous-categorie-promotion').load('update-categorie-promotion.php?c='+categorie);
            }
        })

        $(document).on('change','#updt_sous_categorie_prm',function() {
            var profession = $(this).val();
            if (profession == 'autre') {
                $('.updt-sous-categorie-promotion').hide(); 
                $('.updt-sous-categorie-autre').show(); 
            }
        })

        $(document).on('keyup',"#updt_lieu_prm",function(){
            var locationText = document.getElementById("updt_lieu_prm");
            var filter = locationText.value.toUpperCase();
            var location = document.querySelectorAll("#update_promotion_location_item p");
            var locationItem = document.querySelectorAll("#update_promotion_location_item");
            for (let i = 0; i < locationItem.length; i++) {
                txtValue = location[i].textContent || location[i].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    locationItem[i].style.display = "";
                    $('.promotion-preview-location').css('display','initial');
                } else {
                    locationItem[i].style.display = "none";
                }
            }
            if ($(this).val() == '') {
                $('.promotion-preview-location').css('display','');
            }
        });

        $('#update_promotion_container').on('click','#update_promotion_location_item',function(){
            $('.promotion-preview-location').css('display','');
            $("#updt_lieu_prm").val($(this).text());
        })

        // update promotion image 
        $('#update_promotion_container').on('click','#updt_promotion_image',function(){
            $('#update_image_promotion').click();
        });

        $('#update_promotion_container').on('click','#update_image_promotion',function(e){
            e.stopPropagation();
        });

        $('#update_promotion_container').on('change','#update_image_promotion',function (e) { 
            e.stopPropagation();
            $('#updt_promotion_image_button').click();
        });

        $('#update_promotion_container').on('click','#updt_promotion_image_button',function(e){
            e.stopPropagation();
            var form_data = new FormData();
            var idPrm = $('#id_updt_promotion').val();
            form_data.append('id_prm',idPrm);
            var imgPrm = $('#update_image_promotion')[0].files[0];
            form_data.append('image',imgPrm);
            $.ajax({
                url: 'upload-images-promotion.php', 
                type: 'post',
                data: form_data,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (response) {
                    $('.create-promotion-options').hide();
                    $('.promotion-update-images-preview').show();
                    setTimeout(() => {
                        $('.promotion-update-images-preview').append("<div class='promotion-image-preview' id='promotion_image_preview'><div id='promotion_update_image_preview'><i class='fas fa-times'></i></div><img src='"+response+"'></div>");
                    }, 200);
                }
            });
        });

        // remove updated promotion image preview
        $('#update_promotion_container').on('click','#promotion_update_image_preview',function(){
            var fd = new FormData();
            var idPrm = $('#id_updt_promotion').val();
            fd.append('id_prm',idPrm);
            var mediaUrl = $('#promotion_image_preview img').attr('src');
            fd.append('media_url',mediaUrl);
            $.ajax({
                url: 'update-image-promotion-preview.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    console.log(response);
                    if(response != 0){
                        $('.promotion-update-images-preview').hide();
                        $('.create-promotion-options').show();
                        $('#promotion_image_preview').remove();
                    }
                }
            });
        });

        // update video promotion
        $('#update_promotion_container').on('click','#updt_promotion_video',function(){
            $('#update_video_promotion').click();
        });

        $('#update_promotion_container').on('click','#update_video_promotion',function(e){
            e.stopPropagation();
        });

        $('#update_promotion_container').on('click','#update_video_promotion',function (e) { 
            e.stopPropagation();
            $('#updt_promotion_video_button').click();
        });

        $('#update_promotion_container').on('click','#updt_promotion_video_button',function(e){
            e.stopPropagation();
            var form_data = new FormData();
            var idPrm = $('#id_updt_promotion').val();
            form_data.append('id_prm',idPrm);
            var vdoPrm = $('#update_video_promotion')[0].files[0];
            form_data.append('video',vdoPrm);
            $.ajax({
                url: 'upload-video-promotion.php', 
                type: 'post',
                data: form_data,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (response) {
                    $('.create-promotion-options').hide();
                    $('.promotion-update-images-preview').show();
                    setTimeout(() => {
                        $('.promotion-update-images-preview').append("<div class='promotion-video-preview' id='promotion_video_preview'><div id='promotion_update_video_preview'><i class='fas fa-times'></i></div><video controls><source src='"+response+"'></video></div>");
                    }, 200);
                }
            });
        });

        // remove video promotion
        $('#update_promotion_container').on('click','#promotion_update_video_preview',function(){
            var fd = new FormData();
            var idPrm = $('#id_promotion').val();
            fd.append('id_prm',idPrm);
            var mediaUrl = $('#promotion_video_preview video source').attr('src');
            fd.append('media_url',mediaUrl);
            $.ajax({
                url: 'delete-image-promotion-preview.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response != 0){
                        $('.promotion-update-images-preview').hide();
                        $('.create-promotion-options').show();
                        $('#promotion_video_preview').remove();
                    }
                }
            });
        });

        // update promotion product image 
        $('#update_promotion_container').on('click','#updt_promotion_product_image',function(){
            $('#updt_image_promotion_product').click();
        });

        $('#update_promotion_container').on('click','#updt_image_promotion_product',function(e){
            e.stopPropagation();
        });

        $('#update_promotion_container').on('change','#updt_image_promotion_product',function (e) { 
            console.log('click');
            e.stopPropagation();
            $('#updt_promotion_product_image_button').click();
        });

        // add image promotion product
        $('#update_promotion_container').on('click','#updt_promotion_product_image_button',function(e){
            e.stopPropagation();
            console.log('click1');
            var form_data = new FormData();
            var idPrm = $('#id_updt_promotion').val();
            form_data.append('id_prm',idPrm);
            var idPrd = $('#id_updt_promotion_product').val();
            form_data.append('id_prd',idPrd);
            var totalfiles = document.getElementById('updt_image_promotion_product').files.length;
            console.log(totalfiles);
            for (let i = 0; i < totalfiles; i++) {
                form_data.append("images[]", document.getElementById('updt_image_promotion_product').files[i]);
            }
            $.ajax({
                url: 'upload-images-prm-product.php', 
                type: 'post',
                data: form_data,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log(response);
                    for(let i = 0; i < response.length; i++) {
                        var src = response[i];
                        $('.promotion-product-update-images-preview').append("<div class='prm-product-image-preview' id='prm_product_image_preview_"+i+"'><div id='prm_product_update_preview_"+i+"'><i class='fas fa-times'></i></div><img src='"+src+"'></div>");
                    }
                }
            });
        });

        // remove promotion product image preview
        $('#update_promotion_container').on('click','[id^="prm_product_update_preview_"]',function(){
            var id = $(this).attr("id").split("_")[4];
            var form_data = new FormData();
            var idPrd = $('#id_updt_promotion_product').val();
            form_data.append('id_prd',idPrd);
            var mediaUrl = $('#prm_product_image_preview_'+id+' img').attr('src');
            form_data.append('media_url',mediaUrl);
            $.ajax({
                url: 'update-image-prm-product-preview.php', 
                type: 'post',
                data: form_data,
                contentType: false,
                processData: false,
                success: function (response) {
                    $('#prm_product_image_preview_'+id).remove();
                }
            });
        });

        $('#update_promotion_container').on('click','#final_update_promotion_button',function(){
            var idPrm = $('#id_updt_promotion').val();
            var tailPrm = $('#tail_updt_promotion').val();
            var titrePrm = $('#updt_titre_prm').val();
            var categoriePrm = $('#updt_categorie_prm').val();
            var sousCategoriePrm = $('#updt_sous_categorie_prm').val();
            var lieuPrm = $('#updt_lieu_prm').val(); 
            var adressePrm = $('#updt_adresse_prm').val();
            var latitudePrm = $('#updt_latitude_prm').val();
            var longitudePrm = $('#updt_longitude_prm').val();
            var dateDebutPrm = $('#updt_date_debut_prm').val();
            var dateFinPrm = $('#updt_date_fin_prm').val();
            var descriptionPrm = $('#updt_description_prm').val();
            
            var idPrd = $('#id_updt_promotion_product').val();
            var namePrd = $('#updt_name_prm_prd').val();
            var referencePrd = $('#updt_reference_prm_prd').val();
            var quantityPrd = $('#updt_quantity_prm_prd').val();
            var pricePrd = $('#updt_price_prm_prd').val();
            var fonctionalityPrd = $('#updt_fonctionality_prm_prd').val();
            var caracteristicPrd = $('#updt_caracteristic_prm_prd').val();
            var avantagePrd = $('#updt_avantage_prm_prd').val();
            var descriptionPrd = $('#updt_description_prm_prd').val();

            if ($('.promotion-update-images-preview').is(':empty')){
                console.log('empty');
                $('.create-promotion-options').css('border','2px solid red');
            }
            else if (titrePrm == '') {
                $('.create-promotion-options').css('border','');
                $('#updt_titre_prm').css('border','2px solid red');
            }
            else if (categoriePrm == '') {
                $('.create-promotion-options').css('border','');
                $('#updt_titre_prm').css('border','');
                $('#updt_categorie_prm').css('border','2px solid red');
            }
            else if (sousCategoriePrm == '') {
                $('.create-promotion-options').css('border','');
                $('#updt_titre_prm').css('border','');
                $('#updt_categorie_prm').css('border','');
                $('#updt_sous_categorie_prm').css('border','2px solid red');
            }
            else if (lieuPrm == '') {
                $('.create-promotion-options').css('border','');
                $('#updt_titre_prm').css('border','');
                $('#updt_categorie_prm').css('border','');
                $('#updt_sous_categorie_prm').css('border','');
                $('#updt_lieu_prm').css('border','2px solid red');
            }
            else if (adressePrm == '') {
                $('.create-promotion-options').css('border','');
                $('#updt_titre_prm').css('border','');
                $('#updt_categorie_prm').css('border','');
                $('#updt_sous_categorie_prm').css('border','');
                $('#updt_lieu_prm').css('border','');
                $('#updt_adresse_prm').css('border','2px solid red');
            }
            else if (dateDebutPrm == '') {
                $('.create-promotion-options').css('border','');
                $('#updt_titre_prm').css('border','');
                $('#updt_categorie_prm').css('border','');
                $('#updt_sous_categorie_prm').css('border','');
                $('#updt_lieu_prm').css('border','');
                $('#updt_adresse_prm').css('border','');
                $('#updt_date_debut_prm').css('border','2px solid red');
            }
            else if (dateFinPrm == '') {
                $('.create-promotion-options').css('border','');
                $('#updt_titre_prm').css('border','');
                $('#updt_categorie_prm').css('border','');
                $('#updt_sous_categorie_prm').css('border','');
                $('#updt_lieu_prm').css('border','');
                $('#updt_adresse_prm').css('border','');
                $('#updt_date_debut_prm').css('border','');
                $('#updt_date_fin_prm').css('border','2px solid red');
            }
            else if (namePrd == ''){
                $('.create-promotion-options').css('border','');
                $('#updt_titre_prm').css('border','');
                $('#updt_categorie_prm').css('border','');
                $('#updt_sous_categorie_prm').css('border','');
                $('#updt_lieu_prm').css('border','');
                $('#updt_adresse_prm').css('border','');
                $('#updt_date_debut_prm').css('border','');
                $('#updt_date_fin_prm').css('border','');
                $('#updt_name_prm_prd').css('border','2px solid red');
            }
            else if (pricePrd == '0' || pricePrd == null){
                ('.create-promotion-options').css('border','');
                $('#updt_titre_prm').css('border','');
                $('#updt_categorie_prm').css('border','');
                $('#updt_sous_categorie_prm').css('border','');
                $('#updt_lieu_prm').css('border','');
                $('#updt_adresse_prm').css('border','');
                $('#updt_date_debut_prm').css('border','');
                $('#updt_date_fin_prm').css('border','');
                $('#updt_name_prm_prd').css('border','');
                $('#updt_price_prm_prd').css('border','2px solid red');
            }
            else if ($('.promotion-product-update-images-preview').is(':empty')){
                $('.create-promotion-options').css('border','');
                $('#updt_titre_prm').css('border','');
                $('#updt_categorie_prm').css('border','');
                $('#updt_sous_categorie_prm').css('border','');
                $('#updt_lieu_prm').css('border','');
                $('#updt_adresse_prm').css('border','');
                $('#updt_date_debut_prm').css('border','');
                $('#updt_date_fin_prm').css('border','');
                $('#updt_name_prm_prd').css('border','');
                $('#updt_price_prm_prd').css('border','');
                $('.create-promotion-product-options').css('border','2px solid red');
            }
            else{
                $('.create-promotion-product-options').css('border','');
                var fd = new FormData();
                fd.append('id_prm',idPrm);
                fd.append('tail_prm',tailPrm);
                fd.append('titre_prm',titrePrm);
                fd.append('categorie_prm',categoriePrm);
                fd.append('sous_categorie_prm',sousCategoriePrm);
                fd.append('lieu_prm',lieuPrm);
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
                fd.append('prix_prd',pricePrd);
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
                        $(this).css('opacity','.8');
                        $("#loader_update_promotion_button").show();
                    },
                    success: function(response){
                        if(response != 0){
                            console.log(response);
                            $('#promotion_user_overview_'+tailPrm).replaceWith(response);
                        }
                    },
                    complete: function(){
                        $(this).css('opacity','');
                        $("#loader_update_promotion_button").hide();
                        $("#update_promotion").hide();
                        $("body").removeClass('body-after');
                        $('#update_promotion_container').empty();
                        $('#update_promotion_container').append('<div id="loader_update_promotion" class="center"></div>');
                    }
                });
            }
        });

        $('#display_promotions_categories').click(function(){
            $('.promotion-categories').css('transform','translateX(0)');
        })

        $('#back_to_promotion_filter').click(function(){
            $('.promotion-categories').css('transform','');
        })

        var categoriePromotionTop = document.querySelectorAll('.categorie-promotion-top');
        var categoriePromotionBottom = document.querySelectorAll('.categorie-promotion-bottom');
        var clickCategorie = new Array(categoriePromotionTop.length);

        for (let k = 0; k < categoriePromotionTop.length; k++) {
            clickCategorie[k] = 1;
            categoriePromotionTop[k].addEventListener('click',(e)=>{
                e.stopPropagation();
                clickCategorie[k]++;
                if (clickCategorie[k]%2 == 1) {
                    categoriePromotionBottom[k].style.display = "";
                }
                else{
                    hidePrmCategories();
                    categoriePromotionBottom[k].style.display = "initial";
                }
                categoriePromotionTop[k].scrollIntoView();
            }) 
        }

        function hidePrmCategories (){
            categoriePromotionBottom.forEach(c => {
                c.style.display = "";
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