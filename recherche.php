<?php
session_start();
include_once './bdd/connexion.php';
if (isset($_SESSION['user'])) {
    $cnx_user_query = "SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['user'];
    $result = mysqli_query($conn, $cnx_user_query);
    $row = mysqli_fetch_assoc($result);
    $id_user = $row['id_user'];
}
$text = '';
if (isset($_GET['r'])) {
    $text = $_GET['r'];
    if ($text != '') {
        $rech_user_query = "SELECT id_user AS id, type_user,nom_entrp_user AS nom, couverture_user AS img, ville AS ville, latitude_user AS latitude, longitude_user AS longitude, adresse_user AS adresse, profession_user AS profession, dscrp_user AS dscrp FROM utilisateurs WHERE type_user = 'professionnel' AND nom_entrp_user LIKE '%$text%' OR profession_user LIKE '%$text%' OR dscrp_user LIKE '%$text%' OR ville LIKE '%$text%' 
        UNION SELECT id_btq AS id, type_user, nom_btq AS nom, couverture_btq AS img, ville_btq AS ville, latitude_btq AS latitude, longitude_btq AS longitude, adresse_btq AS adresse, sous_categorie AS profession, dscrp_btq AS dscrp FROM boutiques WHERE nom_btq LIKE '%$text%' OR sous_categorie LIKE '%$text%' OR dscrp_btq LIKE '%$text%' OR ville_btq LIKE '%$text%'";
        $rech_user_result = mysqli_query($conn, $rech_user_query);
    }
    else{
        $rech_user_query = "SELECT id_user AS id, type_user, nom_entrp_user AS nom, couverture_user AS img, ville AS ville, latitude_user AS latitude, longitude_user AS longitude, adresse_user AS adresse, profession_user AS profession, dscrp_user AS dscrp FROM utilisateurs WHERE type_user = 'professionnel' 
        UNION SELECT id_btq AS id, type_user, nom_btq AS nom, couverture_btq AS img, ville_btq AS ville, latitude_btq AS latitude, longitude_btq AS longitude, adresse_btq AS adresse, sous_categorie AS profession, dscrp_btq AS dscrp FROM boutiques";
        $rech_user_result = mysqli_query($conn, $rech_user_query);
    }  
}
else{
    $rech_user_query = "SELECT id_user AS id, type_user, nom_entrp_user AS nom, couverture_user AS img, ville AS ville, latitude_user AS latitude, longitude_user AS longitude, adresse_user AS adresse, profession_user AS profession, dscrp_user AS dscrp FROM utilisateurs WHERE type_user = 'professionnel' 
    UNION SELECT id_btq AS id, type_user, nom_btq AS nom, couverture_btq AS img, ville_btq AS ville, latitude_btq AS latitude, longitude_btq AS longitude, adresse_btq AS adresse, sous_categorie AS profession, dscrp_btq AS dscrp FROM boutiques";
    $rech_user_result = mysqli_query($conn, $rech_user_query);
}
  
$get_ville_query = "SELECT ville FROM villes";
$get_ville_result = mysqli_query($conn, $get_ville_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css-js/style.css">
    <link rel="stylesheet" href="./css-js/recherche.css">
    <link href="./css-js/fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fugaz One">
    <title>Recherche</title>
</head>
<body>
    <?php include './navbar.php'; ?>
    <div class="clear"></div>
    <div class="recherche-recherche-responsive">
        <div id="back_history">
            <i class="fas fa-arrow-left"></i>
        </div>
        <div id="recherche_recherche_responsive">
            <input type="text" id="recherche_text_resp" placeholder="Entrez votre recherche ...">
            <i class="fas fa-search"></i>
        </div>
        <div id="display_categories">
            <i class="fas fa-list"></i>
        </div>
        <div id="display_filter">
            <i class="fas fa-filter"></i>
        </div>
    </div>
    <div class="recherche-left">
        <h2>Trouver vos besoin</h2>
        <div class="recherche-recherche">
            <input type="text" id="recherche_text" placeholder="Entrez votre recherche ...">
            <i class="fas fa-search"></i>
        </div>
        <hr>
        <div class="recherche-categories">
            <div class="recherche-categorie-top">
                <h3>Catégories</h3>
            </div>
            <div class="recherche-categorie-bottom">
                <div class="rc-categorie">
                    <div>
                        <img src="./icons/bureau-icon.png" alt="">
                    </div>
                    <p>Services</p>
                </div>
                <div class="rc-categorie">
                    <div>
                        <img src="./icons/service-icon.png" alt="">
                    </div>
                    <p>Artisants</p>
                </div>
                <div class="rc-categorie">
                    <div>
                        <img src="./icons/transport-icon.png" alt="">
                    </div>
                    <p>Transports</p>
                </div>
                <div class="rc-categorie">
                    <div>
                        <img src="./icons/service-icon.png" alt="">
                    </div>
                    <p>Locations</p>
                </div>
                <div class="rc-categorie">
                    <div>
                        <img src="./icons/entreprise-icon.png" alt="">
                    </div>
                    <p>Entreprises</p>
                </div>
                <div class="rc-categorie">
                    <div>
                        <img src="./icons/detaillon-icon.png" alt="">
                    </div>
                    <p>Detaillons</p>
                </div>
                <div class="rc-categorie">
                    <div>
                        <img src="./icons/grossiste-icon.png" alt="">
                    </div>
                    <p>Grossistes</p>
                </div>
                <div class="rc-categorie">
                    <div>
                        <img src="./icons/fabriquant-icon.png" alt="">
                    </div>
                    <p>Fabriquants</p>
                </div>
                <div class="rc-categorie">
                    <div>
                        <img src="./icons/importateur-icon.png" alt="">
                    </div>
                    <p>Import - Export</p>
                </div>
            </div>
        </div>
        <div class="rc-sous-gategorie">
            <div class="rc-sous-gategorie-top">
                <div id="return_categorie">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <h3>Services</h3>
                <div>
                    <img src="./icons/bureau-icon.png" alt="">
                </div>
            </div>
            <div class="rc-sous-gategorie-bottom">
                <?php 
                $categories_query = "SELECT * FROM categories WHERE categories = 'services'";
                $categories_result = mysqli_query($conn,$categories_query);
                while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                ?>
                <li class="sous-categorie"><?php echo $categories_row['sous_categories'] ?></li>
                <?php } ?>
            </div>
        </div>
        <div class="rc-sous-gategorie">
            <div class="rc-sous-gategorie-top">
                <div id="return_categorie">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <h3>Artisantss</h3>
                <div>
                    <img src="./icons/service-icon.png" alt="">
                </div>
            </div>
            <div class="rc-sous-gategorie-bottom">
                <?php 
                $categories_query = "SELECT * FROM categories WHERE categories = 'artisants'";
                $categories_result = mysqli_query($conn,$categories_query);
                while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                ?>
                <li class="sous-categorie"><?php echo $categories_row['sous_categories'] ?></li>
                <?php } ?>
            </div>
        </div>
        <div class="rc-sous-gategorie">
            <div class="rc-sous-gategorie-top">
                <div id="return_categorie">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <h3>Transports</h3>
                <div>
                    <img src="./icons/transport-icon.png" alt="">
                </div>
            </div>
            <div class="rc-sous-gategorie-bottom">
                <?php 
                $categories_query = "SELECT * FROM categories WHERE categories = 'transports'";
                $categories_result = mysqli_query($conn,$categories_query);
                while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                ?>
                <li class="sous-categorie"><?php echo $categories_row['sous_categories'] ?></li>
                <?php } ?>
            </div>
        </div>
        <div class="rc-sous-gategorie">
            <div class="rc-sous-gategorie-top">
                <div id="return_categorie">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <h3>Locations</h3>
                <div>
                    <img src="./icons/service-icon.png" alt="">
                </div>
            </div>
            <div class="rc-sous-gategorie-bottom">
                <?php 
                $categories_query = "SELECT * FROM categories WHERE categories = 'locations'";
                $categories_result = mysqli_query($conn,$categories_query);
                while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                ?>
                <li class="sous-categorie"><?php echo $categories_row['sous_categories'] ?></li>
                <?php } ?>
            </div>
        </div>
        <div class="rc-sous-gategorie">
            <div class="rc-sous-gategorie-top">
                <div id="return_categorie">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <h3>Entreprises</h3>
                <div>
                    <img src="./icons/entreprise-icon.png" alt="">
                </div>
            </div>
            <div class="rc-sous-gategorie-bottom">
                <?php 
                $categories_query = "SELECT * FROM categories WHERE categories = 'entreprises'";
                $categories_result = mysqli_query($conn,$categories_query);
                while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                ?>
                <li class="sous-categorie"><?php echo $categories_row['sous_categories'] ?></li>
                <?php } ?>
            </div>
        </div>
        <div class="rc-sous-gategorie">
            <div class="rc-sous-gategorie-top">
                <div id="return_categorie">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <h3>Detaillons</h3>
                <div>
                    <img src="./icons/detaillon-icon.png" alt="">
                </div>
            </div>
            <div class="rc-sous-gategorie-bottom">
                <?php 
                $categories_query = "SELECT * FROM categories WHERE categories = 'detaillons'";
                $categories_result = mysqli_query($conn,$categories_query);
                while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                ?>
                <li class="sous-categorie"><?php echo $categories_row['sous_categories'] ?></li>
                <?php } ?>
            </div>
        </div>
        <div class="rc-sous-gategorie">
            <div class="rc-sous-gategorie-top">
                <div id="return_categorie">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <h3>Grossistes</h3>
                <div>
                    <img src="./icons/grossiste-icon.png" alt="">
                </div>
            </div>
            <div class="rc-sous-gategorie-bottom">
                <?php 
                $categories_query = "SELECT * FROM categories WHERE categories = 'grossistes'";
                $categories_result = mysqli_query($conn,$categories_query);
                while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                ?>
                <li class="sous-categorie"><?php echo $categories_row['sous_categories'] ?></li>
                <?php } ?>
            </div>
        </div>
        <div class="rc-sous-gategorie">
            <div class="rc-sous-gategorie-top">
                <div id="return_categorie">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <h3>Fabriquants</h3>
                <div>
                    <img src="./icons/fabriquant-icon.png" alt="">
                </div>
            </div>
            <div class="rc-sous-gategorie-bottom">
                <?php 
                $categories_query = "SELECT * FROM categories WHERE categories = 'fabriquants'";
                $categories_result = mysqli_query($conn,$categories_query);
                while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                ?>
                <li class="sous-categorie"><?php echo $categories_row['sous_categories'] ?></li>
                <?php } ?>
            </div>
        </div>
        <div class="rc-sous-gategorie">
            <div class="rc-sous-gategorie-top">
                <div id="return_categorie">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <h3>Import - Export</h3>
                <div>
                    <img src="./icons/importateur-icon.png" alt="">
                </div>
            </div>
            <div class="rc-sous-gategorie-bottom">
                <?php 
                $categories_query = "SELECT * FROM categories WHERE categories = 'import-export'";
                $categories_result = mysqli_query($conn,$categories_query);
                while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                ?>
                <li class="sous-categorie"><?php echo $categories_row['sous_categories'] ?></li>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="recherche-middle">
        <div class="recherche-middle-content"></div>
        <div id="loader_load" class="center-load"></div>
    </div>
    <div class="recherche-right">
        <div id="map"></div>
        <!-- <div id="loader_load" class="center-load"></div> -->
    </div>
    <input type="hidden" id="r" value="<?php echo $_GET['r'] ?>">
    <div id="loader" class="center"></div>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBEGrApnjX_7GHcNDtF0LR0pgrwxj5j2Q&callback=initMap"></script>
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

        var windowWidth = window.innerWidth;
        if (windowWidth <= 768) {
            $('.footer').css('display','none');
        }
        else{}

        function initMap(text) {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: new google.maps.LatLng(36.638478, 2.947326),
                zoom: 5
            });
            var infoWindow = new google.maps.InfoWindow;

            downloadUrl('markers.php?r='+text, function(notifications) {
            var xml = notifications.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            Array.prototype.forEach.call(markers, function(markerElem) {
                var type = markerElem.getAttribute('type');
                var id = markerElem.getAttribute('id');
                var name = markerElem.getAttribute('nom');
                var address = markerElem.getAttribute('address');
                var point = new google.maps.LatLng(
                    parseFloat(markerElem.getAttribute('latitude')),
                    parseFloat(markerElem.getAttribute('longitude')));
                var image = markerElem.getAttribute('image');
                
                var infowincontent = document.createElement('div');

                var logo = document.createElement('img');
                logo.src = './'+image;
                logo.width = 40;
                logo.height = 40;
                infowincontent.appendChild(logo);

                infowincontent.appendChild(document.createElement('br'));

                var strong = document.createElement('strong');
                strong.textContent = name
                infowincontent.appendChild(strong);

                infowincontent.appendChild(document.createElement('br'));

                var text = document.createElement('text');
                text.textContent = address
                infowincontent.appendChild(text);

                infowincontent.appendChild(document.createElement('br'));
                
                if (type == 'user') {
                    var link = document.createElement('a');
                    link.href = 'utilisateur-info.php?id_user='+id;
                    if (windowWidth <= 768) {
                        link.target = '';
                    }else{
                        link.target = '_blank';
                    }
                }
                else if( type == 'boutique'){
                    var link = document.createElement('a');
                    link.href = 'boutique.php?id_btq='+id;
                    if (windowWidth <= 768) {
                        link.target = '';
                    }else{
                        link.target = '_blank';
                    }
                }
                
                var windowWidth = window.innerWidth;
                link.textContent = name
                infowincontent.appendChild(link);
                
                var marker = new google.maps.Marker({
                    map: map,
                    position: point,
                    icon : {
                        url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png"
                    }
                });
                marker.addListener('click', function() {
                    infoWindow.setContent(infowincontent);
                    infoWindow.open(map, marker);
                });
            });
            });
            
            $(document).on('click','[id^="display_position_"]',function() {
                var id = $(this).attr("id").split("_")[2];
                var idPos = $('#id_pos_'+id).val();
                var imgPos = $('#img_pos_'+id).val();
                var nomPos = $('#nom_pos_'+id).val();
                var adrssPos = $('#adrss_pos_'+id).val();
                var latPos = $('#lat_pos_'+id).val();
                var lngPos = $('#lng_pos_'+id).val();

                $('#map').css('transform','');
                $('.search-filter-bar-fixed').css('transform','');
                $('.all-search').css('transform','');
                map.panTo(new google.maps.LatLng(latPos, lngPos))
                map.setZoom(10)
                marker = new google.maps.Marker({
                    map: map,
                    position: new google.maps.LatLng(latPos, lngPos),
                    icon : {
                        url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png"
                    }
                });
                var infowincontent = document.createElement('div');
                var logo = document.createElement('img');
                logo.src = './'+imgPos;
                logo.width = 40;
                logo.height = 40;
                infowincontent.appendChild(logo);
                infowincontent.appendChild(document.createElement('br'));
                var strong = document.createElement('strong');
                strong.textContent = nomPos
                infowincontent.appendChild(strong);
                infowincontent.appendChild(document.createElement('br'));
                var text = document.createElement('text');
                text.textContent = adrssPos
                infowincontent.appendChild(text);
                infowincontent.appendChild(document.createElement('br'));
                var link = document.createElement('a');
                link.href = 'utilisateur-info.php?id_user='+idPos;
                if (windowWidth <= 768) {
                    link.target = '';
                }else{
                    link.target = '_blank';
                }
                link.textContent = nomPos
                infowincontent.appendChild(link);
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
            });

            $(document).on('click','[id^="display_pos_btq_"]',function() {
                var idBtq = $(this).attr("id").split("_")[3];
                $('#map').css('transform','');
                $('.search-filter-bar-fixed').css('transform','');
                $('.all-search').css('transform','');
                
                var idPosBtq = $('#id_pos_btq_'+idBtq).val();
                var imgPosBtq = $('#img_pos_btq_'+idBtq).val();
                var nomPosBtq = $('#nom_pos_btq_'+idBtq).val();
                var adrssPosBtq = $('#adrss_pos_btq_'+idBtq).val();
                var latPosBtq = $('#lat_pos_btq_'+idBtq).val();
                var lngPosBtq = $('#lng_pos_btq_'+idBtq).val();

                map.panTo(new google.maps.LatLng(latPosBtq, lngPosBtq))
                map.setZoom(10)
                marker = new google.maps.Marker({
                    map: map,
                    position: new google.maps.LatLng(latPosBtq, lngPosBtq),
                    icon : {
                        url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png"
                    }
                });
                var infowincontent = document.createElement('div');
                var logo = document.createElement('img');
                logo.src = './'+imgPosBtq;
                logo.width = 40;
                logo.height = 40;
                infowincontent.appendChild(logo);
                infowincontent.appendChild(document.createElement('br'));
                var strong = document.createElement('strong');
                strong.textContent = nomPosBtq
                infowincontent.appendChild(strong);
                infowincontent.appendChild(document.createElement('br'));
                var text = document.createElement('text');
                text.textContent = adrssPosBtq
                infowincontent.appendChild(text);
                infowincontent.appendChild(document.createElement('br'));
                var link = document.createElement('a');
                link.href = 'boutique.php?id_btq='+idPosBtq;
                if (windowWidth <= 768) {
                    link.target = '';
                }else{
                    link.target = '_blank';
                }
                link.textContent = nomPosBtq
                infowincontent.appendChild(link);
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
            });
        }
        function downloadUrl(url, callback) {
            var request = window.ActiveXObject ?
                new ActiveXObject('Microsoft.XMLHTTP') :
                new XMLHttpRequest;

            request.onreadystatechange = function() {
                if (request.readyState == 4) {
                request.onreadystatechange = doNothing;
                callback(request, request.status);
                }
            };

            request.open('GET', url, true);
            request.send(null);
        }
        function doNothing() {}

        var rcCategorie = document.querySelectorAll('.rc-categorie');
        var rcSousCategorie = document.querySelectorAll('.rc-sous-gategorie');

        for (let i = 0; i < rcCategorie.length; i++) {
            rcCategorie[i].addEventListener('click',(e)=>{
                e.stopPropagation();
                rcSousCategorie[i].style.transform = 'translateX(0)';
            })
        }

        var returnCategorie = document.querySelectorAll('#return_categorie');
        for (let i = 0; i < returnCategorie.length; i++) {
            returnCategorie[i].addEventListener('click',(e)=>{
                e.stopPropagation();
                rcSousCategorie[i].style.transform = '';
            })
        }

        $('#back_history').click(function(){
            window.history.back();
        })

        $('.bt-sous-gategorie-top').click(function(e){
            e.stopPropagation();
        })

        $('#display_categories').click(function(e){
            e.stopPropagation();
            setTimeout(() => {
                $('body').addClass('body-after');
            }, 0);
            $('.recherche-left').css('transform','translateX(0)');
        })

        $('#recherche_text_resp').click(function(e){
            e.stopPropagation();
            // setBoutdechantierSearchBar();
        })

        $(document).on('keypress',"#recherche_text",function() {
            if (event.which == 13) {
                var rechercheText = $('#recherche_text').val();
                var fd = new FormData();
                fd.append('r',rechercheText);
                $.ajax({
                    url: 'recherche-professionnel.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        history.replaceState(null,'', './recherche.php?r='+rechercheText);
                        $('.recherche-middle-content').empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        $('.recherche-middle-content').append(response);
                        if (typeof google === 'object' && typeof google.maps === 'object') {
                            initMap(rechercheText);
                        }else{
                            setTimeout(() => {
                                initMap(rechercheText);
                            }, 2000);
                        }
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
                // if (typeof google === 'object' && typeof google.maps === 'object') {
                //     initMap(rechercheText);
                // }else{
                //     setTimeout(() => {
                //         initMap(rechercheText);
                //     }, 2000);
                // }
            }
        });

        $(document).on('keypress',"#recherche_text_resp",function() {
            if (event.which == 13) {
                var rechercheTextRsp = $('#recherche_text_resp').val();
                var fd = new FormData();
                fd.append('r',rechercheTextRsp);
                $.ajax({
                    url: 'recherche-professionnel.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        history.replaceState(null,'', './recherche.php?r='+rechercheTextRsp);
                        $('.recherche-middle-content').empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        $('.recherche-middle-content').append(response);
                        if (typeof google === 'object' && typeof google.maps === 'object') {
                            initMap(rechercheTextRsp);
                        }else{
                            setTimeout(() => {
                                initMap(rechercheTextRsp);
                            }, 2000);
                        }
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
            }
        });

        $('#recherche_text_resp').click(function(e){
            e.stopPropagation();
            setRechercheSearchBar();
        })


        $(document).ready(function(){
            var rechercheText = $('#r').val();
            $('#recherche_text').val(rechercheText);
            $('#recherche_text_resp').val(rechercheText);
            var fd = new FormData();
            fd.append('r',rechercheText);
            $.ajax({
                url: 'recherche-professionnel.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    history.replaceState(null,'', './recherche.php?r='+rechercheText);
                    $('.recherche-middle-content').empty();
                    $("#loader_load").show();
                },
                success: function(response){
                    $('.recherche-middle-content').append(response);
                    if (typeof google === 'object' && typeof google.maps === 'object') {
                        initMap(rechercheText);
                    }else{
                        setTimeout(() => {
                            initMap(rechercheText);
                        }, 2000);
                    }
                },
                complete: function(response){
                    $("#loader_load").hide();
                }
            });
        });

        $(window).on('beforeunload', function(){
            var rechercheText = $('#r').val();
            $('#recherche_text').val(rechercheText);
            $('#recherche_text_resp').val(rechercheText);
            var fd = new FormData();
            fd.append('r',rechercheText);
            $.ajax({
                url: 'recherche-professionnel.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    history.replaceState(null,'', './recherche.php?r='+rechercheText);
                    $('.recherche-middle-content').empty();
                    $("#loader_load").show();
                },
                success: function(response){
                    $('.recherche-middle-content').append(response);
                    if (typeof google === 'object' && typeof google.maps === 'object') {
                        initMap(rechercheText);
                    }else{
                        setTimeout(() => {
                            initMap(rechercheText);
                        }, 2000);
                    }
                },
                complete: function(response){
                    $("#loader_load").hide();
                }
            });
        });

        $(document).on('click',".sous-categorie",function() {
            var fd = new FormData();
            var rechercheText = $(this).text();
            fd.append('r',rechercheText);
            $.ajax({
                url: 'recherche-professionnel.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    history.replaceState(null,'', './recherche.php?r='+rechercheText);
                    $('.recherche-middle-content').empty();
                    $("#loader_load").show();
                },
                success: function(response){
                    $('.recherche-middle-content').append(response);
                    if (typeof google === 'object' && typeof google.maps === 'object') {
                        initMap(rechercheText);
                    }else{
                        setTimeout(() => {
                            initMap(rechercheText);
                        }, 2000);
                    }
                },
                complete: function(response){
                    $("#loader_load").hide();
                }
            });
        });

        if (windowWidth <= 768) {
            var lastScrollTop = 0;
            $('.recherche-middle').scroll(function(event){
            var st = $(this).scrollTop();
                if (st > lastScrollTop){
                    $('.recherche-right').css('transform','translateY(-200px)');
                    $(this).css('transform','translateY(-200px)');
                    $(this).css('height','calc(100vh - 80px)');
                } else {
                    $('.recherche-right').css('transform','');
                    $(this).css('transform','');
                    $(this).css('height','');
                }
                lastScrollTop = st;
            });
        }
    
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