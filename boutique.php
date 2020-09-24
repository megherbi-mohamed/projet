<?php 
session_start();
include_once './bdd/connexion.php';
if (isset($_SESSION['user'])) {
    $cnx_user_query = "SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['user'];
    $result = mysqli_query($conn, $cnx_user_query);
    $row = mysqli_fetch_assoc($result);
    $id_user = $row['id_user'];
}

$btq_inf_query = "SELECT * FROM boutiques WHERE id_btq = {$_GET['btq']}";
$btq_inf_result = mysqli_query($conn, $btq_inf_query);
$btq_inf_row = mysqli_fetch_assoc($btq_inf_result);
$id_createur = $btq_inf_row['id_createur'];

$btq_crtr_query = "SELECT img_user,nom_user FROM utilisateurs WHERE id_user = '$id_createur'";
$btq_crtr_result = mysqli_query($conn, $btq_crtr_query);
$btq_crtr_row = mysqli_fetch_assoc($btq_crtr_result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css-js/style.css">
    <link rel="stylesheet" href="./css-js/boutique.css">
    <link rel="stylesheet" href="./css-js/croppie.css">
    <link href="./css-js/fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fugaz One">
    <title>Boutique</title>
</head>
<body>
    <?php include './navbar.php'; ?>
    <div class="clear"></div>
    <div class="boutique-container">
        <div class="boutique-top">
            <div class="boutique-couverture-logo">
                <div class="boutique-couverture">
                <?php if ($btq_inf_row['couverture_btq'] != '') { ?>
                    <img id="couverture_img" src="./<?php echo $btq_inf_row['couverture_btq'] ?>" alt="">
                <?php }else if($btq_inf_row['couverture_btq'] == ''){ ?>
                    <img id="couverture_img" src="./boutique-couverture/couverture.png" alt="">
                <?php } ?>
                </div>
                <div class="boutique-logo">
                <?php if ($btq_inf_row['logo_btq'] != '') { ?>
                    <img src="./<?php echo $btq_inf_row['logo_btq'] ?>" alt="">
                <?php }else if($btq_inf_row['logo_btq'] == ''){ ?>
                    <img src="./boutique-logo/logo.png" alt="">
                <?php } ?>
                </div>
            </div>
            <div class="boutique-search-responsive">
                <div id="back_history">
                    <i class="fas fa-arrow-left"></i>
                </div>    
                <div id="boutique_search_resp">
                    <input type="text" id="recherche_text_resp" placeholder="Chercher votre produit" autocomplete="off">
                    <i class="fas fa-search"></i>
                </div>
                <div id="display_categories_resp">
                    <i class="fas fa-list"></i>
                </div>
                <div id="display_filter_resp">
                    <i class="fas fa-filter"></i>
                </div>
            </div>
        </div>
        <div class="boutique-options">
            <div class="boutique-name">
                <h3><?php echo $btq_inf_row['nom_btq'] ?></h3>
            </div>
            <!-- <hr> -->
            <div class="boutique-option">
                <?php if (isset($_SESSION['user']) && $_SESSION['user'] !== $btq_inf_row['id_createur']) { ?>
                <div id="follow_button">
                    <p>Abonner-vous</p>
                    <i class="fas fa-user-plus"></i>
                </div>
                <div id="message_button">
                    <p>Envoyer un message</p>
                    <i class="fab fa-facebook-messenger"></i>
                </div>
                <?php } else if (isset($_SESSION['user']) && $_SESSION['user'] == $btq_inf_row['id_createur']) { ?>
                <div id="follow">
                    <p>Abonner-vous</p>
                    <i class="fas fa-user-plus"></i>
                </div>
                <div id="message">
                    <p>Envoyer un message</p>
                    <i class="fab fa-facebook-messenger"></i>
                </div>
                <?php }else if (!isset($_SESSION['user'])) { ?>
                    <div id="connect_follow_button">
                        <p>Abonner-vous</p>
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div id="connect_message_button">
                        <p>Envoyer un message</p>
                        <i class="fab fa-facebook-messenger"></i>
                    </div>
                <?Php } ?>
                <div class="boutique-search">
                    <input type="text" id="recherche_text" placeholder="Chercher votre produit" autocomplete="off">
                    <i class="fas fa-search"></i>
                </div>
                <div id="display_categories">
                    <i class="fas fa-list"></i>
                </div>
                <div id="display_filter">
                    <i class="fas fa-filter"></i>   
                </div>
            </div>
        </div>
        <div class="boutique-bottom">
            <div class="boutique-bottom-left">
                <div class="boutique-informations">
                    <div class="boutique-information">
                        <div>
                            <i class="fas fa-store-alt"></i>
                        </div>
                        <p><?php echo $btq_inf_row['categorie'] ?>, <?php echo $btq_inf_row['sous_categorie'] ?></p>
                    </div>
                    <div class="boutique-information">
                        <div>
                            <i class="fas fa-at"></i>
                        </div>
                        <p><?php echo $btq_inf_row['email_btq'] ?></p>
                    </div>
                    <div class="boutique-information">
                        <div>
                            <i class="fas fa-phone"></i>
                        </div>
                        <p><?php echo $btq_inf_row['tlph_btq'] ?></p>
                    </div>
                    <div class="boutique-information">
                        <div>
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <p><?php echo $btq_inf_row['adresse_btq'] ?>, 
                        <?php echo $btq_inf_row['commune_btq'] ?>, 
                        <?php echo $btq_inf_row['ville_btq'] ?></p>
                    </div>
                </div>
                <div class="boutique-map">
                    <input type="hidden" id="latitude_btq" value="<?php echo $btq_inf_row['latitude_btq'] ?>">
                    <input type="hidden" id="longitude_btq" value="<?php echo $btq_inf_row['longitude_btq'] ?>">
                    <div id="boutique_map"></div>
                </div>
                <div class="boutique-createur">
                    <img src="<?php echo $btq_crtr_row['img_user'] ?>" alt="">
                    <div>
                        <h5>Createur</h5>
                        <p><?php echo $btq_crtr_row['nom_user'] ?></p>
                    </div>
                </div>
            </div>
            <div class="boutique-bottom-left-resp"></div>
            <div class="boutique-bottom-right">
                <div class="boutique-bottom-right-container">
                    <?php 
                    $get_product_query = "SELECT * FROM produit_boutique WHERE id_btq = '{$btq_inf_row['id_btq']}' ORDER BY id_prd DESC";
                    $get_product_result = mysqli_query($conn,$get_product_query);
                    $i = 0;
                    while ($get_product_row = mysqli_fetch_assoc($get_product_result)){
                    $i++;
                    $get_product_media_query = "SELECT * FROM produits_media WHERE id_prd = '{$get_product_row['id_prd']}' LIMIT 1";
                    $get_product_media_result = mysqli_query($conn,$get_product_media_query);
                    $get_product_media_row = mysqli_fetch_assoc($get_product_media_result);
                    ?>
                    <input type="hidden" id="id_prd_<?php echo $i ?>" value="<?php echo $get_product_row['id_prd'] ?>">
                    <div class="boutique-product" id="boutique_product_<?php echo $i ?>">
                        <div class="boutique-product-img">
                            <img src="<?php echo $get_product_media_row['media_url'] ?>" alt="">
                        </div>
                        <div class="product-description">
                            <div class="product-description-top">
                                <p><?php echo $get_product_row['description_prd'] ?></p>
                            </div>
                            <div class="product-description-bottom">
                                <h4><?Php echo $get_product_row['prix_prd'].' DA' ?></h4>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div id="loader_bt_right" class="center"></div>
            </div>
        </div>
    </div>
    <div class="product-details">
        <div class="product-details-container"></div>
        <div id="loader_product" class="center"></div>
    </div>
    <input type="hidden" id="id_boutique_product" value="<?php echo $btq_inf_row['id_btq'] ?>">
    <div id="loader" class="center"></div>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBEGrApnjX_7GHcNDtF0LR0pgrwxj5j2Q&callback=initBtqMap"></script>
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

        var latitudeBtq = document.querySelector('#latitude_btq');
        var longitudeBtq = document.querySelector('#longitude_btq');
        function initBtqMap() {
            var map = new google.maps.Map(document.getElementById('boutique_map'), {
                center: new google.maps.LatLng(latitudeBtq.value, longitudeBtq.value),
                zoom: 14
            });
            var marker = new google.maps.Marker({
                map: map,
                position: new google.maps.LatLng(latitudeBtq.value, longitudeBtq.value),
                icon : {
                    url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png"
                }
            });
        }

        $(document).on('click','[id^="boutique_product_"]',function(){
            var id = $(this).attr("id").split("_")[2];
            var fd = new FormData();
            var idBtq = $('#id_boutique_product').val();
            fd.append('id_btq',idBtq);
            var idPrd = $('#id_prd_'+id).val();
            fd.append('id_prd',idPrd);
            $.ajax({
                url: 'load-product-content.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $("body").addClass('body-after');
                    if (windowWidth > 768) {
                        $(".product-details").show();
                    }else{
                        $(".product-details").css('transform','translateX(0)');
                    }
                    $("#loader_product").show();
                },
                success: function(response){
                    if(response != 0){
                        $('.product-details-container').append(response);
                    }
                },
                complete: function(){
                    $("#loader_product").hide();
                }
            });
        });

        $(document).on('click','#cancel_product_details',function(){
            $("body").removeClass('body-after');
            $(".product-details").hide();
            $('.product-details-container').empty();
        })

        $(document).on('click','#cancel_product_details_resp',function(e){
            e.stopPropagation();
            $("body").removeClass('body-after');
            $(".product-details").css('transform','');
            $('.product-details-container').empty();
        })

        $(document).on('click','#overview_product_button',function(){
            $("#comment_product_button").removeClass('product-details-bottom-top-active');
            $("#informations_product_button").removeClass('product-details-bottom-top-active');
            $("#overview_product_button").addClass('product-details-bottom-top-active');
            
            $("#comments_product").removeClass('product-details-bottom-bottom-active');
            $("#overview_product").addClass('product-details-bottom-bottom-active');
            $("#informations_product").css('display','');
            
        })
        
        $(document).on('click','#informations_product_button',function(){
            $("#overview_product_button").removeClass('product-details-bottom-top-active');
            $("#informations_product_button").addClass('product-details-bottom-top-active');
            $("#comment_product_button").removeClass('product-details-bottom-top-active');

            $("#overview_product").removeClass('product-details-bottom-bottom-active');
            $("#comments_product").removeClass('product-details-bottom-bottom-active');
            $("#informations_product").css('display','grid');
        })

        $(document).on('click','#comment_product_button',function(){
            $("#overview_product_button").removeClass('product-details-bottom-top-active');
            $("#informations_product_button").removeClass('product-details-bottom-top-active');
            $("#comment_product_button").addClass('product-details-bottom-top-active');

            $("#overview_product").removeClass('product-details-bottom-bottom-active');
            $("#informations_product").removeClass('product-details-bottom-bottom-active');
            $("#comments_product").addClass('product-details-bottom-bottom-active');
            $("#informations_product").css('display','');
        })

        $(document).on('click','.display-modele',function(){
            var urlMedia = $(this).find('img').attr('src');
            $('.display-modele').removeClass('product-details-modele-image-active');
            $(this).addClass('product-details-modele-image-active');
            $(document).find('.product-details-images-top img').replaceWith('<img src="'+urlMedia+'" alt="">');
            
        })

        $(window).on("scroll", function () {
            if ($(this).scrollTop() > 380) {
                $('.boutique-options').css({'position':'fixed','margin':'0','top':'70px','left':'50%','transform':'translateX(-50%)','z-index':'150'});
                $('.boutique-bottom-left').css({'position':'fixed','margin':'0','top':'172px','width':'235px'});
                $('.boutique-bottom-right').css({'margin-top':'148px'});
                $('.boutique-bottom-left-resp').show();
            } 
            else {
                $('.boutique-options').css({'position':'','margin':'','top':'','left':'','transform':'','z-index':'150'});
                $('.boutique-bottom-left').css({'position':'','margin':'','top':'','width':''});
                $('.boutique-bottom-right').css({'margin-top':''});
                $('.boutique-bottom-left-resp').hide();
            }
        });

        $(document).on('keypress',"#recherche_text",function() {
            if (event.which == 13) {
                var fd = new FormData();
                var rechercheText = $('#recherche_text').val();
                fd.append('text',rechercheText);
                var idBtq = $('#id_boutique_product').val();
                fd.append('id_btq',idBtq);
                $.ajax({
                    url: 'recherche-boutique-product.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $(".boutique-bottom-right-container").empty();
                        window.scrollTo({
                            top: 420,
                            behavior: 'smooth'
                        });
                        $("#loader_bt_right").show();
                    },
                    success: function(response){
                        $('.boutique-bottom-right-container').append(response);
                    },
                    complete: function(response){
                        $("#loader_bt_right").hide();
                    }
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