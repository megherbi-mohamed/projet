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
        header('Location: inscription-connexion.php');
    }
}
$get_ville_query = $conn->prepare("SELECT ville FROM villes");
$get_ville_query->execute();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/projet/" />
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
    <?php include './navbar.php';?>
    <div class="clear"></div>
    <div class="recherche-recherche-responsive">
        <div class="recherche-recherche-responsive-container">
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
    <div class="recherche-left">
        <h2>Trouver vos besoin</h2>
        <div class="recherche-recherche">
            <input type="text" id="recherche_text" placeholder="Entrez votre recherche ...">
            <i class="fas fa-search"></i>
        </div>
        <hr>
        <div class="filter-recherche-options">
            <div class="filter-recherche" id="display_filter_professionnel">
                <div>
                    <i class="fas fa-user"></i>
                </div>
                <p>Professionnels - entreprises</p>
            </div>
            <div class="filter-options" id="filter_professionnel_options">
                <div class="filter-recherche-buttons">
                    <h4>Filtrer par</h4>
                    <button class="reset-recherche-button" id="reset_professionnel_filter">Réintialiser</button>
                    <button class="filter-recherche-button" id="filter_professionnel">Filtrer</button>
                </div>
                <div class="filter-recherche-input">
                    <p>Categories</p>
                    <select id="categorie_professionnel">
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
                <div class="filter-recherche-input profession-professionnel">
                    <p>Profession</p>
                    <select id="profession_professionnel">
                        <option value="">Professions</option>
                    </select>
                </div>
                <div class="filter-recherche-input">
                    <p>Ville</p>
                    <select id="ville_professionnel">
                        <option value="">Ville</option>
                        <?php 
                        $ville_query = $conn->prepare("SELECT * FROM villes ORDER BY ville ASC");
                        $ville_query->execute(); 
                        while ($ville_row = $ville_query->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <option value="<?php echo $ville_row['ville'] ?>"><?php echo $ville_row['ville'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="filter-recherche-input commune-professionnel"> 
                    <p>Commune</p>
                    <select id="commune_professionnel">
                        <option value="">Commune</option>
                    </select>
                </div>
            </div>
            <div class="filter-recherche" id="display_filter_boutique">
                <div>
                    <i class="fas fa-store"></i>
                </div>
                <p>boutiques</p>
            </div>
            <div class="filter-options" id="filter_boutique_options">
                <div class="filter-recherche-buttons">
                    <h4>Filtrer par</h4>
                    <button class="reset-recherche-button" id="reset_boutique_filter">Réintialiser</button>
                    <button class="filter-recherche-button" id="filter_boutique">Filtrer</button>
                </div>
                <div class="filter-recherche-input">
                    <p>Categories</p>
                    <select id="categorie_boutique">
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
                <div class="filter-recherche-input profession-boutique">
                    <p>Profession</p>
                    <select id="profession_boutique">
                        <option value="">Professions</option>
                    </select>
                </div>
                <div class="filter-recherche-input">
                    <p>Ville</p>
                    <select id="ville_boutique">
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
                <div class="filter-recherche-input commune-boutique"> 
                    <p>Commune</p>
                    <select id="commune_boutique">
                        <option value="">Commune</option>
                    </select>
                </div>
            </div>
            <div class="filter-recherche" id="display_filter_product">
                <div>
                    <i class="fas fa-boxes"></i>
                </div>
                <p>Produits</p>
            </div>
            <!-- <div class="filter-recherche" id="display_filter_boutdechantier">
                <div>
                    <i class="fas fa-store"></i>
                </div>
                <p>boutdechantier</p>
            </div>
            <div class="filter-options" id="filter_boutdechantier_options">
                <div class="filter-recherche-buttons">
                    <h4>Filtrer par</h4>
                    <button class="reset-recherche-button" id="reset_boutdechantier_filter">Réintialiser</button>
                    <button class="filter-recherche-button" id="filter_boutdechantier">Filtrer</button>
                </div>
                <div class="filter-recherche-input">
                    <p>Categorie</p>
                    <select id="categorie_boutdechantier">
                        <option value="">Categories</option>
                        <option value="Outillages">Outillages</option>
                        <option value="Quincalleries">Quincalleries</option>
                        <option value="Peinture et vernis">Peinture et vernis</option>
                        <option value="Revetement mural">Revetement mural</option>
                        <option value="Eléctricité">Eléctricité</option>
                        <option value="Menuiserie et bois">Menuiserie et bois</option>
                        <option value="Portes et fenetres">Portes et fenetres</option>
                        <option value="Cloison et séparation">Cloison et séparation</option>
                        <option value="Isolation">Isolation</option>
                        <option value="Revetements sol">Revetements sol</option>
                        <option value="Matériaux et gros oeuvre">Matériaux et gros oeuvre</option>
                        <option value="Plombrie">Plombrie</option>
                    </select> 
                </div>
                <div class="filter-recherche-input">
                    <p>Ville</p>
                    <select id="ville_boutdechantier">
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
                <div class="filter-recherche-input commune-boutdechantier"> 
                    <p>Commune</p>
                    <select id="commune_boutdechantier">
                        <option value="">Commune</option>
                    </select>
                </div>
            </div> -->
        </div>
    </div>
    <div class="recherche-middle">
        <div class="recherche-middle-content">

        </div>
        <div id="loader_load" class="center"></div>
    </div>
    <div class="recherche-right">
        <div id="map"></div>
        <div id="loader_map" class="center"></div>
    </div>
    <input type="hidden" id="r" value="<?php echo $_GET['r'] ?>">
    <div id="loader" class="center"></div>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBEGrApnjX_7GHcNDtF0LR0pgrwxj5j2Q&callback=initMap"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="./css-js/main.js"></script>
    <script>
        var typeRecherche = '<?php echo $_GET['type_r'] ?>';
        var typeFilter = '<?php echo $_GET['type_f'] ?>';
        var rechercheText = '<?php if (isset($_GET['text'])) { echo $_GET['text']; } else { echo ''; } ?>';
        var categorie = '<?php if (isset($_GET['categorie'])) { echo $_GET['categorie']; } else { echo ''; } ?>';
        var profession = '<?php if (isset($_GET['profession'])) { echo $_GET['profession']; } else { echo ''; } ?>';
        var ville = '<?php if (isset($_GET['ville'])) { echo $_GET['ville']; } else { echo ''; } ?>';
        var commune = '<?php if (isset($_GET['commune'])) { echo $_GET['commune']; } else { echo ''; } ?>';
        
        document.onreadystatechange = function() { 
            if (document.readyState !== "complete") { 
                document.querySelector("body").style.visibility = "hidden"; 
                document.querySelector("#loader").style.visibility = "visible"; 
            } else { 
                document.querySelector("#loader").style.display = "none"; 
                document.querySelector("body").style.visibility = "visible"; 
                var rechercheMap = [typeRecherche,typeFilter,rechercheText,categorie,profession,ville,commune];
                if (typeRecherche == 'tout' || typeRecherche == 'professionnel' || typeRecherche == 'boutique') {
                    initMap.apply(null, rechercheMap); 
                }
            } 
        }; 

        function initMap(a,b,c,d,e,f,g) {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: new google.maps.LatLng(36.638478, 2.947326),
                zoom: 5
            });
            var infoWindow = new google.maps.InfoWindow;
            console.log(a,b,c,d,e,f,g);
            downloadUrl('markers.php?type_r='+a+'&type_f='+b+'&text='+c+'&categorie='+d+'&profession='+e+'&ville='+f+'&commune='+g, function(notifications) {
                var xml = notifications.responseXML;
                var markers = xml.documentElement.getElementsByTagName('marker');
                Array.prototype.forEach.call(markers, function(markerElem) {
                    var type = markerElem.getAttribute('type');
                    var id = markerElem.getAttribute('id');
                    var name = markerElem.getAttribute('nom');
                    var address = markerElem.getAttribute('address');
                    var point = new google.maps.LatLng(
                        parseFloat(markerElem.getAttribute('latitude')),
                        parseFloat(markerElem.getAttribute('longitude'))
                    );
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
                        }
                        else{
                            link.target = '_blank';
                        }
                    }
                    else if( type == 'boutique'){
                        var link = document.createElement('a');
                        link.href = 'boutique.php?id_btq='+id;
                        if (windowWidth <= 768) {
                            link.target = '';
                        }
                        else{
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

            function downloadUrl(url, callback) {
                var request = window.ActiveXObject ?
                    new ActiveXObject('Microsoft.XMLHTTP') :
                    new XMLHttpRequest;
                request.onreadystatechange = function() {
                    if (request.readyState == 4) {
                        $('#map').css('visibility','');
                        $('#loader_map').hide();
                        request.onreadystatechange = doNothing;
                        callback(request, request.status);
                    }
                    else{
                        $('#map').css('visibility','hidden');
                        $('#loader_map').show();
                    }
                };

                request.open('GET', url, true);
                request.send(null);
            }

            function doNothing() {}
            
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

        $('#display_categories').click(function(e){
            e.stopPropagation();
            setTimeout(() => {
                $('body').addClass('body-after');
            }, 0);
            $('.recherche-left').css('transform','translateX(0)');
        })

        function rechercheToutText (rechercheText,typeRecherche) {
            var typeFilter = 'text';
            var categorie = '';
            var profession = '';
            var ville = '';
            var commune = '';
            var rechercheMap = [typeRecherche,typeFilter,rechercheText,categorie,profession,ville,commune];
            var fd = new FormData();
            fd.append('type_recherche',typeRecherche);
            fd.append('type_filter',typeFilter);
            fd.append('text',rechercheText);
            fd.append('categorie_user',categorie);
            fd.append('profession_user',profession);
            fd.append('ville_user',ville);
            fd.append('commune_user',commune);
            $.ajax({
                url: 'filter-recherche.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    history.replaceState(null,'', 'recherche/'+typeRecherche+'/'+typeFilter+'/'+rechercheText);
                    $('.recherche-middle-content').empty();
                    $("#loader_load").show();
                },
                success: function(response){
                    if (response != 0) {
                        if (768 <= windowWidth <= 1250) {
                            hideLeftRecherche ();
                            setTimeout(() => {
                                $('.recherche-middle-content').append(response);
                            }, 400);
                        }
                        else{
                            $('.recherche-middle-content').append(response);
                        }
                        initMap.apply(null, rechercheMap);
                    }
                },
                complete: function(response){
                    $("#loader_load").hide();
                }
            });
        }
        // console.log(typeRecherche);
        $(document).on('keypress',"#recherche_text",function() {
            let typeRecherche = 'tout';
            let rechercheText = $(this).val();
            console.log(typeRecherche);
            if (rechercheText != '') {
                if (event.which == 13) {
                    rechercheToutText (rechercheText,typeRecherche);
                }
            }
        });

        $(window).on('load', function(){ 
            $('#recherche_text').val(rechercheText);
            var fd = new FormData();
            fd.append('type_recherche',typeRecherche);
            fd.append('type_filter',typeFilter);
            fd.append('text',rechercheText);
            fd.append('categorie_user',categorie);
            fd.append('profession_user',profession);
            fd.append('ville_user',ville);
            fd.append('commune_user',commune);
            $.ajax({
                url: 'filter-recherche.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    if (typeFilter == 'text') {
                        history.replaceState(null,'', 'recherche/'+typeRecherche+'/'+typeFilter+'/'+rechercheText);
                    }
                    else if (typeFilter == 'filter') {
                        var filter = '';
                        if (categorie != '') { filter = '/'+categorie; } else { filter = filter+'/0'; }
                        if (profession != '') { filter = filter+'/'+profession; } else { filter = filter+'/0'; }
                        if (ville != '') { filter = filter+'/'+ville; } else { filter = filter+'/0'; }
                        if (commune != '') { filter = filter+'/'+commune; } else { filter = filter+'/0'; }
                        history.replaceState(null,'', 'recherche/'+typeRecherche+'/'+typeFilter+filter);
                    }
                    $('.recherche-middle-content').empty();
                    $("#loader_load").show();
                },
                success: function(response){
                    if (response != 0) {
                        $('.recherche-middle-content').append(response);
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

        $('.recherche-left').click(function(e){
            e.stopPropagation();
        })

        $('#display_filter_professionnel').click(function(){
            if ($('#filter_professionnel_options').height() > 0) {
                $('#filter_professionnel_options').css({'max-height':''});
            }
            else{
                $('#filter_professionnel_options').css({'max-height':'250px'});
            }
        })

        $('#ville_professionnel').on('change',function() {
            var ville  = $(this).val();
            if (ville !== '') {
                $('.commune-professionnel').load('commune-professionnel-filter.php?v='+ville);
            }
        })

        $('#categorie_professionnel').on('change',function() {
            var categorie  = $(this).val();
            if (categorie !== '') {
                $('.profession-professionnel').load('categorie-professionnel-filter.php?c='+categorie);
            }
        })

        // filter recherche
        $('#filter_professionnel').on('click',function() {
            var typeRecherche = 'professionnel';
            var typeFilter = 'filter';
            var rechercheText = '';
            var categorie = $('#categorie_professionnel').val();
            var profession = $('#profession_professionnel').val();
            var ville = $('#ville_professionnel').val();
            var commune = $('#commune_professionnel').val();
            var rechercheMap = [typeRecherche,typeFilter,rechercheText,categorie,profession,ville,commune];
            var fd = new FormData();
            fd.append('type_recherche',typeRecherche);
            fd.append('type_filter',typeFilter);
            fd.append('text',rechercheText);
            fd.append('categorie_user',categorie);
            fd.append('profession_user',profession);
            fd.append('ville_user',ville);
            fd.append('commune_user',commune);
            $.ajax({
                url: 'filter-recherche.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".recherche-middle-content").empty();
                    $("#loader_load").show();
                    var filter = '';
                    if (categorie != '') { filter = '/'+categorie; } else { filter = filter+'/0'; }
                    if (profession != '') { filter = filter+'/'+profession; } else { filter = filter+'/0'; }
                    if (ville != '') { filter = filter+'/'+ville; } else { filter = filter+'/0'; }
                    if (commune != '') { filter = filter+'/'+commune; } else { filter = filter+'/0'; }
                    history.replaceState(null,'', 'recherche/'+typeRecherche+'/'+typeFilter+filter);
                },
                success: function(response){
                    console.log(response);
                    if (response != 0) {
                        if (windowWidth > 1250) {
                            $('.recherche-middle-content').append(response);
                        }
                        else{
                            hideLeftRecherche ();
                            setTimeout(() => {
                                $('.recherche-middle-content').append(response);
                            }, 400);
                        }
                        initMap.apply(null, rechercheMap);
                    }
                },
                complete: function(response){
                    $("#loader_load").hide();
                }
            });
        })

        // reset filter recherche
        $('#reset_professionnel_filter').on('click',function() {
            var typeRecherche = 'professionnel';
            var typeFilter = 'filter';
            var rechercheText = '';
            var categorie = '';
            var profession = '';
            var ville = '';
            var commune = '';
            var rechercheMap = [typeRecherche,typeFilter,rechercheText,categorie,profession,ville,commune];
            var fd = new FormData();
            fd.append('type_recherche',typeRecherche);
            fd.append('type_filter',typeFilter);
            fd.append('text',rechercheText);
            fd.append('categorie_user',categorie);
            fd.append('profession_user',profession);
            fd.append('ville_user',ville);
            fd.append('commune_user',commune);
            $.ajax({
                url: 'filter-recherche.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".recherche-middle-content").empty();
                    $("#loader_load").show();
                    history.replaceState(null,'', 'recherche/professionnel/filter/0/0/0/0');
                },
                success: function(response){
                    if (response != 0) {
                        if (windowWidth > 1250) {
                            $('.recherche-middle-content').append(response);
                        }
                        else{
                            hideLeftRecherche ();
                            setTimeout(() => {
                                $('.recherche-middle-content').append(response);
                            }, 400);
                        }
                        $('#categorie_professionnel option:eq(0)').prop('selected',true);
                        $('#profession_professionnel option:eq(0)').prop('selected',true);
                        $('#ville_professionnel option:eq(0)').prop('selected',true);
                        $('#commune_professionnel option:eq(0)').prop('selected',true);
                        $("#loader_load").hide();
                        initMap.apply(null, rechercheMap);
                    }
                },
                complete: function(response){
                    $("#loader_load").hide();
                }
            });
        })

        $('#display_filter_boutique').click(function(){
            if ($('#filter_boutique_options').height() > 0) {
                $('#filter_boutique_options').css({'max-height':''});
            }
            else{
                $('#filter_boutique_options').css({'max-height':'250px'});
            }
        })

        $('#ville_boutique').on('change',function() {
            var ville  = $(this).val();
            if (ville !== '') {
                $('.commune-boutique').load('commune-boutique-filter.php?v='+ville);
            }
        })

        $('#categorie_boutique').on('change',function() {
            var categorie  = $(this).val();
            if (categorie !== '') {
                $('.profession-boutique').load('categorie-boutique-filter.php?c='+categorie);
            }
        })

        // filter recherche
        $('#filter_boutique').on('click',function() {
            var typeRecherche = 'boutique';
            var typeFilter = 'filter';
            var rechercheText = '';
            var categorie = $('#categorie_boutique').val();
            var profession = $('#profession_boutique').val();
            var ville = $('#ville_boutique').val();
            var commune = $('#commune_boutique').val();
            var rechercheMap = [typeRecherche,typeFilter,rechercheText,categorie,profession,ville,commune];
            var fd = new FormData();
            fd.append('type_recherche',typeRecherche);
            fd.append('type_filter',typeFilter);
            fd.append('text',rechercheText);
            fd.append('categorie_user',categorie);
            fd.append('profession_user',profession);
            fd.append('ville_user',ville);
            fd.append('commune_user',commune);
            $.ajax({
                url: 'filter-recherche.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".recherche-middle-content").empty();
                    $("#loader_load").show();
                    var filter = '';
                    if (categorie != '') { filter = '/'+categorie; } else { filter = filter+'/0'; }
                    if (profession != '') { filter = filter+'/'+profession; } else { filter = filter+'/0'; }
                    if (ville != '') { filter = filter+'/'+ville; } else { filter = filter+'/0'; }
                    if (commune != '') { filter = filter+'/'+commune; } else { filter = filter+'/0'; }
                    history.replaceState(null,'', 'recherche/'+typeRecherche+'/'+typeFilter+filter);
                },
                success: function(response){
                    if (response != 0) {
                        if (windowWidth > 1250) {
                            $('.recherche-middle-content').append(response);
                        }
                        else{
                            hideLeftRecherche ();
                            setTimeout(() => {
                                $('.recherche-middle-content').append(response);
                            }, 400);
                        }
                        initMap.apply(null, rechercheMap);
                    }
                },
                complete: function(response){
                    $("#loader_load").hide();
                }
            });
        })

        // reset filter recherche
        $('#reset_boutique_filter').on('click',function() {
            var typeRecherche = 'boutique';
            var typeFilter = 'filter';
            var rechercheText = '';
            var categorie = '';
            var profession = '';
            var ville = '';
            var commune = '';
            var rechercheMap = [typeRecherche,typeFilter,rechercheText,categorie,profession,ville,commune];
            var fd = new FormData();
            fd.append('type_recherche',typeRecherche);
            fd.append('type_filter',typeFilter);
            fd.append('text',rechercheText);
            fd.append('categorie_user',categorie);
            fd.append('profession_user',profession);
            fd.append('ville_user',ville);
            fd.append('commune_user',commune);
            $.ajax({
                url: 'filter-recherche.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".recherche-middle-content").empty();
                    $("#loader_load").show();
                    history.replaceState(null,'', 'recherche/boutique/filter/0/0/0/0');
                },
                success: function(response){
                    if (response != 0) {
                        if (windowWidth > 1250) {
                            $('.recherche-middle-content').append(response);
                        }
                        else{
                            hideLeftRecherche ();
                            setTimeout(() => {
                                $('.recherche-middle-content').append(response);
                            }, 400);
                        }
                        $('#categorie_boutique option:eq(0)').prop('selected',true);
                        $('#profession_boutique option:eq(0)').prop('selected',true);
                        $('#ville_boutique option:eq(0)').prop('selected',true);
                        $('#commune_boutique option:eq(0)').prop('selected',true);
                        $("#loader_load").hide();
                        initMap.apply(null, rechercheMap);
                    }
                },
                complete: function(response){
                    $("#loader_load").hide();
                }
            });
        })

        $(document).on('click','#show_all_professionnel_result',function() {
            var typeRecherche = 'professionnel';
            var rechercheMap = [typeRecherche,typeFilter,rechercheText,categorie,profession,ville,commune];
            $('#recherche_text').val(rechercheText);
            var fd = new FormData();
            fd.append('type_recherche',typeRecherche);
            fd.append('type_filter',typeFilter);
            fd.append('text',rechercheText);
            fd.append('categorie_user',categorie);
            fd.append('profession_user',profession);
            fd.append('ville_user',ville);
            fd.append('commune_user',commune);
            $.ajax({
                url: 'filter-recherche.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    history.replaceState(null,'', 'recherche/'+typeRecherche+'/'+typeFilter+'/'+rechercheText);
                    $('.recherche-middle-content').empty();
                    $("#loader_load").show();
                },
                success: function(response){
                    $('.recherche-middle-content').append(response);
                    initMap.apply(null, rechercheMap); 
                },
                complete: function(response){
                    $("#loader_load").hide();
                }
            });
        })

        $(document).on('click','[id^="professionnel_overview_"]',function() {
            let id = $(this).attr("id").split('_')[2];
            let idUser = $('#id_professionnel_overview_'+id).val();
            window.location = 'utilisateur/'+idUser;
        })

        $(document).on('click','#show_all_boutique_result',function() {
            var typeRecherche = 'boutique';
            var rechercheMap = [typeRecherche,typeFilter,rechercheText,categorie,profession,ville,commune];
            $('#recherche_text').val(rechercheText);
            var fd = new FormData();
            fd.append('type_recherche',typeRecherche);
            fd.append('type_filter',typeFilter);
            fd.append('text',rechercheText);
            fd.append('categorie_user',categorie);
            fd.append('profession_user',profession);
            fd.append('ville_user',ville);
            fd.append('commune_user',commune);
            $.ajax({
                url: 'filter-recherche.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    history.replaceState(null,'', 'recherche/'+typeRecherche+'/'+typeFilter+'/'+rechercheText);
                    $('.recherche-middle-content').empty();
                    $("#loader_load").show();
                },
                success: function(response){
                    $('.recherche-middle-content').append(response);
                    initMap.apply(null, rechercheMap); 
                },
                complete: function(response){
                    $("#loader_load").hide();
                }
            });
        })

        $(document).on('click','[id^="boutique_overview_"]',function() {
            let id = $(this).attr("id").split('_')[2];
            let idBtq = $('#id_boutique_overview_'+id).val();
            window.location = 'boutique/'+idBtq;
        })

        $(document).on('click','#show_all_product_result',function() {
            var typeRecherche = 'produit';
            var rechercheMap = [typeRecherche,typeFilter,rechercheText,categorie,profession,ville,commune];
            $('#recherche_text').val(rechercheText);
            var fd = new FormData();
            fd.append('type_recherche',typeRecherche);
            fd.append('type_filter',typeFilter);
            fd.append('text',rechercheText);
            fd.append('categorie_user',categorie);
            fd.append('profession_user',profession);
            fd.append('ville_user',ville);
            fd.append('commune_user',commune);
            $.ajax({
                url: 'filter-recherche.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    history.replaceState(null,'', 'recherche/'+typeRecherche+'/'+typeFilter+'/'+rechercheText);
                    $('.recherche-middle-content').empty();
                    $("#loader_load").show();
                },
                success: function(response){
                    $('.recherche-middle-content').append(response);
                    // initMap.apply(null, rechercheMap); 
                },
                complete: function(response){
                    $("#loader_load").hide();
                }
            });
        })

        $(document).on('click','[id^="product_overview_"]',function() {
            let id = $(this).attr("id").split('_')[2];
            let idBtq = $('#id_boutique_product_overview_'+id).val();
            let idPrd = $('#id_product_overview_'+id).val();
            console.log(idBtq+' '+idPrd);
            window.location = 'boutique/'+idBtq+'/'+idPrd;
        })

        $(document).on('click','#show_all_boutdechantier_result',function() {
            // var typefilter = 'text';
            window.location = 'boutdechantier/'+typeFilter+'/'+rechercheText;
        })
    
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