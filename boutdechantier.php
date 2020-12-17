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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/projet/"/>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css-js/style.css">
    <link rel="stylesheet" href="css-js/boutdechantier.css">
    <link href="css-js/fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fugaz One">
    <title>Bout de chantier</title>
</head>
<body>
    <?php include './navbar.php';?>
    <div class="clear"></div>
    <div class="boutdechantier-recherche-responsive">
        <div class="boutdechantier-recherche-responsive-container">
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
    <div class="boutdechantier-left">
        <h2>Bout de chantier</h2>
        <div class="boutdechantier-recherche">
            <input type="text" id="recherche_text" placeholder="Chercher un produit ...">
            <i class="fas fa-search"></i>
        </div>
        <hr>
        <?php if (isset($_SESSION['user'])) { ?>
        <div class="boutdechantier-annonces">
            <div class="display-bt-product-user" id="display_bt_product_user">
                <div>
                    <i class="fas fa-bullhorn"></i>
                </div>
                <p>Vos annonces</p>
                <div class="bt-annonces-notification">
                    <div id="bt_annc_ntf">
                        <span>0</span>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <hr>
        <div class="filter-boutdechantier-options">
            <div class="filter-boutdechantier-button">
                <h4>Filtrer par</h4>
                <button id="reset_boutdechantier_button">Réintialiser</button>
                <button id="filter_boutdechantier_button">Filtrer</button>
            </div>
            <div class="quick-filter-button">
                <button id="today_filter_button">Aujourd'hui</button>
                <button id="week_filter_button">Cette semaine</button>
                <button id="month_filter_button">Ce mois</button>
            </div>
            <div class="filter-boutdechantier" id="display_boutdechantier_categories">
                <div>
                    <i class="fas fa-list-ul"></i>
                </div>
                <p>Categories</p>
            </div>
            <div class="filter-ptomotion-option" id="boutdechantier_categories">
                <div class="filter-boutdechantier-input">
                    <p>Categories</p>
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
            </div>
            <div class="filter-boutdechantier" id="display_boutdechantier_localisation">
                <div>
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <p>Lieu</p>
            </div>
            <div class="filter-ptomotion-option" id="boutdechantier_localisation">
                <div class="filter-boutdechantier-input">
                    <p>Ville</p>
                    <select id="ville_boutdechantier_filter">
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
                <div class="filter-boutdechantier-input commune-boutdechantier-filter"> 
                    <p>Commune</p>
                    <select id="commune_boutdechantier_filter">
                        <option value="">Commune</option>
                    </select>
                </div>
            </div>
        </div>
    </div> 
    <div class="boutdechantier-right">
        <div class="boutdechantier-right-container">
            <div class="boutdechantier-right-top">
                <div class="boutdechantier-right-pub"></div>
                <div class="boutdechantier-right-slider">
                    <div class="boutdechantier-right-slider-img">
                        <img class="current-slide" src="./boutique-logo/logo.png" alt="">
                        <img src="./boutique-logo/logo2.jpg" alt="">
                        <img src="./boutique-logo/logo3.jpg" alt="">
                    </div>
                    <div id="prev_slide">
                        <i class="fas fa-chevron-left"></i>
                    </div>
                    <div id="next_slide">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
                <div class="boutdechantier-right-pub"></div>
            </div>
            <div class="boutdechantier-right-middle"></div>
            <div class="boutdechantier-right-bottom">
                <?php 
                $get_product_query = $conn->prepare("SELECT * FROM produit_boutdechantier ORDER BY date DESC");
                $get_product_query->execute();
                $i = 0;
                while ($get_product_row = $get_product_query->fetch(PDO::FETCH_ASSOC)){
                $i++;
                $get_product_media_query = $conn->prepare("SELECT * FROM bt_produits_media WHERE id_prd = '{$get_product_row['id_prd']}' LIMIT 1");
                $get_product_media_query->execute();
                $get_product_media_row = $get_product_media_query->fetch(PDO::FETCH_ASSOC);
                ?>
                <div class="bt-product">
                    <div class="bt-product-img">
                        <img src="<?php echo $get_product_media_row['media_url'] ?>" alt="">
                    </div>
                    <div class="bt-product-description">
                        <p><?php echo $get_product_row['commune_prd'] ?></p>
                        <h4><?Php echo $get_product_row['prix_prd'].' DA' ?></h4>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <div id="loader_load" class="center"></div>
    </div>
    <div class="bt-product-details">
        <div class="bt-product-details-container">
            <div class="cancel-bt-product-details" id="cancel_bt_product_details">
                <i class="fas fa-times"></i>
            </div>
            <div class="cancel-bt-product-details-resp">
                <div id="cancel_bt_product_details_resp">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <h4>qsfqsf</h4>
            </div>
            <div class="bt-product-details-left">
                <div class="bt-product-details-left-top">
                    <img src="./boutique-logo/logo.png" alt="">
                </div>
                <div class="bt-product-details-left-bottom">
                    <div>
                        <img src="./boutique-logo/logo.png" alt="">
                    </div>
                    <div>
                        <img src="./boutique-logo/logo.png" alt="">
                    </div>
                    <div>
                        <img src="./boutique-logo/logo.png" alt="">
                    </div>
                </div>
            </div>
            <div class="bt-product-details-middle">
                <p>zarzaerat</p>
                <h4>150 da</h4>
                <p>qslkfjoizajf</p>
                <p>categorie</p>
                <p>200 pcs</p>
            </div>
            <div class="bt-product-details-right">
                
            </div>
        </div>
        <div id="loader_bt_prd" class="center"></div>
    </div>
    <!-- update bt product -->
    <div class="create-publication" id="update_bt_product">
        <div class="create-publication-container" id="update_bt_product_container"></div>
        <div id="loader_update_bt_product" class="center"></div>
    </div>
    <div class="delete-product" id="delete_product">
        <div class="delete-product-container" id="delete_product_container">
            <input type="hidden" id="product_tail_delete">
            <input type="hidden" id="id_product_delete">
            <div class="delete-product-top">
                <h4>Supprimer l'annonce ?</h4>
                <div class="cancel-delete-product" id="cancel_delete_product">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="delete-product-middle">
                <p>Voulez vous vraiment Supprimer l'annonce ?</p>
            </div>
            <div class="delete-product-bottom">
                <div></div>
                <div></div>
                <button id="cancel_delete_prd_button">Annuler</button>
                <button id="delete_prd_button">Supprimer</button>
            </div>
        </div>
    </div>
    <div class="gb-message-alert">
        <p>L'annence a été bien renouvelée !</p>
        <div class="cancel-alert-message">
            <i class="fas fa-times"></i>
        </div>
    </div>
    <div id="loader" class="center"></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="css-js/main.js"></script>
    <script>
        document.onreadystatechange = function() { 
            if (document.readyState !== "complete") { 
                document.querySelector("body").style.visibility = "hidden"; 
                document.querySelector("#loader").style.visibility = "visible"; 
            } 
            else { 
                document.querySelector("#loader").style.display = "none"; 
                document.querySelector("body").style.visibility = "visible"; 
            } 
        };
      
        $(window).on('load',function(){
            if (history.state === 'annonces') {
                $('#display_bt_product_user').css('background','#ecedee');
                $.ajax({
                    url: 'laod-user-bt-annonces.php',
                    beforeSend: function(){
                        $(".boutdechantier-right-container").empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        history.replaceState('annonces','', '/projet/boutdechantier/annonces');
                        $('.boutdechantier-right-container').append(response);
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
            }
            if (history.state === 'boutdechantier') {
                $('#display_bt_product_user').css('background','');
                $.ajax({
                    url: 'laod-boutdechantier.php',
                    beforeSend: function(){
                        $(".boutdechantier-right-container").empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        history.replaceState('boutdechantier','', '/projet/boutdechantier');
                        $('.boutdechantier-right-container').append(response);
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
            }

        })

        $(window).on('popstate',function(){
            if (history.state === 'annonces') {
                $('#display_bt_product_user').css('background','#ecedee');
                $.ajax({
                    url: 'laod-user-bt-annonces.php',
                    beforeSend: function(){
                        $(".boutdechantier-right-container").empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        $('.boutdechantier-right-container').append(response);
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
            }
            if (history.state === 'boutdechantier' || history.state === null) {
                $('#display_bt_product_user').css('background','');
                $.ajax({
                    url: 'laod-boutdechantier.php',
                    beforeSend: function(){
                        $(".boutdechantier-right-container").empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        $('.boutdechantier-right-container').append(response);
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
            }
        })

        var slider = document.querySelector('.boutdechantier-right-slider');
        var slides = document.querySelectorAll('.boutdechantier-right-slider img');
        var next = document.querySelector('#next_slide');
        var prev = document.querySelector('#prev_slide');
        var intervalTime = 3000;
        var sildeInterval = setInterval(nextSlide, intervalTime);

        function nextSlide(){
            var current = document.querySelector(".current-slide");
            current.classList.remove("current-slide");
            if (current.nextElementSibling) {
                current.nextElementSibling.classList.add("current-slide");
            }else{
                slides[0].classList.add("current-slide");
            }
        }

        function prevSlide(){
            var current = document.querySelector(".current-slide");
            current.classList.remove("current-slide");
            if (current.previousElementSibling) {
                current.previousElementSibling.classList.add("current-slide");
            }else{
                slides[slides.length-1].classList.add("current-slide");
            }
        }
        
        next.addEventListener('click', ()=>{
            nextSlide();
            clearInterval(sildeInterval);
        });

        prev.addEventListener('click', ()=>{
            prevSlide()
            clearInterval(sildeInterval);
        });

        slider.addEventListener('mouseover', ()=>{
            clearInterval(sildeInterval);
        });

        slider.addEventListener('mouseleave', ()=>{
            sildeInterval = setInterval(nextSlide, intervalTime);
        });

        var btCategorie = document.querySelectorAll('.bt-categorie');
        var btSousCategorie = document.querySelectorAll('.bt-sous-gategorie');
        
        for (let i = 0; i < btCategorie.length; i++) {
            btCategorie[i].addEventListener('click',(e)=>{
                e.stopPropagation();
                btSousCategorie[i].style.transform = 'translateX(0)';
            })
        }

        var returnCategorie = document.querySelectorAll('#return_categorie');
        for (let i = 0; i < returnCategorie.length; i++) {
            returnCategorie[i].addEventListener('click',(e)=>{
                e.stopPropagation();
                btSousCategorie[i].style.transform = '';
            })
        }

        $('#display_categories').click(function(e){
            e.stopPropagation();
            setTimeout(() => {
                $('body').addClass('body-after');
            }, 0);
            $('.boutdechantier-left').css('transform','translateX(0)');
        })

        $(document).on('keypress',"#recherche_text",function() {
            var rechercheText = $(this).val();
            if (event.which == 13) {
                if (rechercheText != '') {
                    rechercheBoutdechantierText (rechercheText);
                }
            }
        });

        function rechercheBoutdechantierText (rechercheText) {
            var typeFilter = 'text';
            var categoriePrd = '';
            var dateDebutPrd = '';
            var dateFinPrd = '';
            var villePrd = '';
            var communePrd = '';
            var fd = new FormData();
            fd.append('type_filter',typeFilter);
            fd.append('text',rechercheText);
            fd.append('categorie_prd',categoriePrd);
            fd.append('date_debut_prd',dateDebutPrd);
            fd.append('date_fin_prd',dateFinPrd);
            fd.append('ville_prd',villePrd);
            fd.append('commune_prd',communePrd);
            $.ajax({
                url: 'filter-boutdechantier.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".boutdechantier-right-container").empty();
                    $("#loader_load").show();
                    history.replaceState(null,'', 'boutdechantier/'+typeFilter+'/'+rechercheText);
                },
                success: function(response){
                    if (response != 0) {
                        if (768 <= windowWidth <= 1250) {
                            hideLeftBoutdechantier ();
                            setTimeout(() => {
                                $('.boutdechantier-right-container').append(response);
                            }, 400);
                        }
                        else{
                            $('.boutdechantier-right-container').append(response);
                        }
                    }
                },
                complete: function(response){
                    $("#loader_load").hide();
                }
            });
        }

        // display user annonces
        $("#display_bt_product_user").on('click',function() {
            console.log('click');
            $(this).css('background','#ecedee');
            $.ajax({
                url: 'laod-user-bt-annonces.php',
                beforeSend: function(){
                    $(".boutdechantier-right-container").empty();
                    $("#loader_load").show();
                },
                success: function(response){
                    history.pushState('annonces','', '/projet/boutdechantier/annonces');
                    if (windowWidth > 1250) {
                        $('.boutdechantier-right-container').append(response);
                    }
                    else{
                        hideLeftBoutdechantier ();
                        setTimeout(() => {
                            $('.boutdechantier-right-container').append(response);
                        }, 400);
                    }
                },
                complete: function(response){
                    $("#loader_load").hide();
                }
            });
        });
        
        $(document).on('click','[id^="update_bt_annc_"]',function(){
            var id = $(this).attr("id").split("_")[3];
            var idPrd = $('#id_prd_'+id).val();
            var tailPrd = $('#tail_prd_'+id).val();
            var fd = new FormData();
            fd.append('id_prd',idPrd); 
            fd.append('tail_prd',tailPrd);
            $.ajax({
                url: 'load-update-bt-product.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    if (windowWidth > 768) {
                        $("body").addClass('body-after');
                        $("body").css('overflow','hidden');
                        $('#update_bt_product').show();
                    }
                    else{
                        $('#update_bt_product').css('transform','translateX(0)'); 
                    }
                    $("#loader_update_bt_product").show();
                },
                success: function(response){
                    console.log(response);
                    if(response != 0){
                        $('#update_bt_product_container').append(response);
                    }   
                },
                complete: function(){
                    $("#loader_update_bt_product").hide();
                }
            });
        });

        // cancel update bt product
        $('#update_bt_product_container').on('click','#cancel_update_bt_product',function(){
            cancelUpdateBtProduct ();
        })

        $('#update_bt_product').click(function(){
            cancelUpdateBtProduct ();
        })

        function cancelUpdateBtProduct () {
            var idPrd = $('#id_bt_product').val();
            var fd = new FormData();
            fd.append('id_prd',idPrd);
            $.ajax({
                url: 'pre-delete-bt-product.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $('#update_bt_product_container').empty();
                    $("#loader_update_bt_product").show();
                },
                success: function(response){
                    console.log(response);
                    if(response != 0){
                    }    
                },
                complete: function(){
                    if (windowWidth > 768) {
                        $("body").removeClass('body-after');
                        $('#update_bt_product').hide();
                    }
                    else{
                        $('#update_bt_product').css('transform','');
                    }
                    $("#loader_update_bt_product").hide();
                }
            });
        }

        // ville bt product
        $('#update_bt_product_container').on('change','#ville_bt_product',function() {
            var ville  = $(this).val();
            if (ville !== '') {
                $('.commune-bt-product').load('commune-bt-product.php?v='+ville);
            }
        })

        // type bt product
        $('#update_bt_product_container').on('change','#type_bt_prd',function() {
            var type  = $(this).val();
            if (type == 'payant') {
                $('.bt-product-price').show();
            }
            else{
                $('.bt-product-price').hide();
            }
        })

        // set bt product image 
        $('#update_bt_product_container').on('click','#add_bt_product_image',function(){
            $('#image_bt_product').val('');
            $('#image_bt_product').click();
        });

        $('#update_bt_product_container').on('click','#image_bt_product',function(e){
            e.stopPropagation();
        });

        $('#update_bt_product_container').on('change','#image_bt_product',function () { 
            $('#add_bt_product_image_button').click();
        });

        $('#update_bt_product_container').on('click','#add_bt_product_image_button',function(e){
            e.stopPropagation();
            var numImg = $('.bt-product-image-preview').length;
            if (numImg > 0) {
                var lastImg = $('.bt-product-image-preview').last().attr('id').split("_")[2];
            }
            else{
                var lastImg = 0;
            }
            var numUpldImg = document.getElementById('image_bt_product').files.length;
            var idPrd = $('#id_bt_product').val();
            var form_data = new FormData();
            form_data.append('id_prd',idPrd);
            for (let i = 0; i < 4 - numImg; i++) {
                form_data.append("images[]", document.getElementById('image_bt_product').files[i]);
            }
            $.ajax({
                url: 'upload-images-bt-product.php', 
                type: 'post',
                data: form_data,
                dataType: 'json',
                contentType: false,
                processData: false,
                beforeSend: function(){
                    if ((numImg + numUpldImg) <= 4) {
                        for(let i = 0; i < numUpldImg; i++) {
                            let id = lastImg + i;
                            $('.bt-product-images-preview').append("<div class='bt-product-image-preview' id='bt_product_image_preview_"+id+"'><div id='loader_bt_prd_img_"+id+"' class='center'></div></div>");
                        }
                    }
                    else if ((numImg + numUpldImg) >= 5) {
                        for(let i = 0; i < (4 - numImg); i++) {
                            let id = lastImg + i;
                            $('.bt-product-images-preview').append("<div class='bt-product-image-preview' id='bt_product_image_preview_"+id+"'><div id='loader_bt_prd_img_"+id+"' class='center'></div></div>");
                        }
                    }
                },
                success: function (response) {
                    for(let i = 0; i < response.length; i++) {
                        var src = response[i];
                        let id = lastImg + i;
                        $('#bt_product_image_preview_'+id).replaceWith("<div class='bt-product-image-preview' id='bt_product_image_preview_"+id+"'><div class='delete-preview' id='bt_product_delete_preview_"+id+"'><i class='fas fa-times'></i></div><img src='"+src+"'></div>");
                    }
                },
                complete: function(){
                    numImg = $('.bt-product-image-preview').length;
                    if (numImg >= 4) {
                        $('.create-bt-product-options').hide();
                    }
                }
            });
        });

        // remove bt product image preview
        $('#update_bt_product_container').on('click','[id^="bt_product_delete_preview_"]',function(){
            var id = $(this).attr("id").split("_")[4];
            var idPrd = $('#id_bt_product').val();
            var mediaUrl = $('#bt_product_image_preview_'+id+' img').attr('src');
            var fd = new FormData();
            fd.append('id_prd',idPrd);
            fd.append('media_url',mediaUrl);
            $.ajax({
                url: 'delete-bt-product-media.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $('#bt_product_image_preview_'+id).replaceWith("<div class='bt-product-image-preview' id='bt_product_image_preview_"+id+"'><div id='loader_bt_prd_img_"+id+"' class='center'></div></div>");
                },
                success: function(response){
                    if(response != 0){
                        $('#bt_product_image_preview_'+id).remove();
                    }
                },
                complete: function(){
                    var numImg = $('.bt-product-image-preview').length;
                    if (numImg < 4) {
                        $('.create-bt-product-options').show();
                    }
                }
            });
        });

        // set publication video 
        $('#update_bt_product_container').on('click','#add_bt_product_video',function(){
            $('#video_bt_product').val('');
            $('#video_bt_product').click();
        })

        $('#update_bt_product_container').on('click','#video_bt_product',function(e){
            e.stopPropagation();
        });

        $('#update_bt_product_container').on('change','#video_bt_product',function () { 
            $('#add_bt_product_video_button').click();
        });

        $('#update_bt_product_container').on('click','#add_bt_product_video_button',function(e){
            e.stopPropagation();
            var idPrd = $('#id_bt_product').val();
            var form_data = new FormData();
            form_data.append('id_prd',idPrd);
            form_data.append("video", $('#video_bt_product')[0].files[0]);
            $.ajax({
                url: 'upload-video-bt-product.php', 
                type: 'post',
                data: form_data,
                dataType: 'json',
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $('.bt-product-video-preview').append("<div class='bt-prd-video-preview' id='bt_product_video_preview'><div id='loader_bt_prd_video' class='center'></div></div>");
                },
                success: function (response) {
                    if (windowWidth > 768) {
                        $('.create-bt-product-container').css({'top':'0','transform':'translate(-50%,0%)'});
                    }
                    $('#bt_product_video_preview').replaceWith("<div class='bt-prd-video-preview' id='bt_product_video_preview'><div class='delete-preview' id='bt_product_delete_video'><i class='fas fa-times'></i></div><video controls><source src='"+response+"'></video></div>");
                },
                complete: function(){
                    var numVideo = $('.bt-prd-video-preview').length;
                    if (numVideo >= 1) {
                        $('.create-bt-product-options').hide();
                    }
                }
            });
        });

        // remove publication video preview
        $('#update_bt_product_container').on('click','#bt_product_delete_video',function(){
            var fd = new FormData();
            var idPrd = $('#id_bt_product').val();
            fd.append('id_prd',idPrd);
            var mediaUrl = $('.bt-prd-video-preview video source').attr('src');
            fd.append('media_url',mediaUrl);
            $.ajax({
                url: 'delete-bt-product-media.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $('#bt_product_video_preview').replaceWith("<div class='bt-prd-video-preview' id='bt_product_video_preview'><div id='loader_bt_prd_video' class='center'></div></div>");
                },
                success: function(response){
                    if(response != 0){
                        $('#bt_product_video_preview').remove();
                    }
                },
                complete: function(){
                    var numVideo = $('.bt-prd-video-preview').length;
                    if (numVideo == 0) {
                        $('.create-bt-product-options').show();
                    }
                }
            });
        });

        // valide create product boutdechantier
        $('#update_bt_product_container').on('click','#update_bt_product_button',function(){
            var idPrd = $('#id_bt_product').val();
            var tailPrd = $('#tail_product').val();
            var namePrd = $('#name_bt_prd').val();
            var categoriePrd = $('#categorie_bt_product').val();
            var descriptionPrd = $('#description_bt_prd').val(); 
            var quantityPrd = $('#quantity_bt_prd').val();
            var typePrd = $('#type_bt_prd').val();
            var pricePrd = $('#price_bt_prd').val();
            var villePrd = $('#ville_bt_product').val();
            var communePrd = $('#commune_bt_product').val();
            var numMedia = $('.bt-product-image-preview').length + $('.bt-prd-video-preview').length;
            if (namePrd == ''){
                $('#name_bt_prd').css('border','2px solid red');
            }
            else if (categoriePrd == ''){
                $('#name_bt_prd').css('border','');
                $('#categorie_bt_prd').css('border','2px solid red');
            }
            else if(typePrd == ''){
                $('#name_bt_prd').css('border','');
                $('#categorie_bt_product').css('border','');
                $('#type_bt_prd').css('border','2px solid red');
            }
            else if(typePrd == 'payant' && pricePrd == ''){
                $('#name_bt_prd').css('border','');
                $('#categorie_bt_product').css('border','');
                $('#type_bt_prd').css('border','');
                $('#price_bt_prd').css('border','2px solid red');
            }
            else if(villePrd == ''){
                $('#name_bt_prd').css('border','');
                $('#categorie_bt_product').css('border','');
                $('#type_bt_prd').css('border','');
                $('#price_bt_prd').css('border','');
                $('#ville_bt_product').css('border','2px solid red');
            }
            else if(communePrd == ''){
                $('#name_bt_prd').css('border','');
                $('#categorie_bt_product').css('border','');
                $('#type_bt_prd').css('border','');
                $('#price_bt_prd').css('border','');
                $('#ville_bt_product').css('border','');
                $('#commune_bt_product').css('border','2px solid red');
            }
            else if(numMedia == 0){
                $('#name_bt_prd').css('border','');
                $('#categorie_bt_product').css('border','');
                $('#type_bt_prd').css('border','');
                $('#price_bt_prd').css('border','');
                $('#ville_bt_product').css('border','');
                $('#commune_bt_product').css('border','');
                $('.create-bt-product-options').css('border','2px solid red');
            }
            else {
                var fd = new FormData();
                fd.append('id_prd',idPrd);
                fd.append('nom_prd',namePrd);
                fd.append('categorie_prd',categoriePrd);
                fd.append('description_prd',descriptionPrd);
                fd.append('quantite_prd',quantityPrd);
                fd.append('type_prd',typePrd);
                fd.append('prix_prd',pricePrd);
                fd.append('ville_prd',villePrd);
                fd.append('commune_prd',communePrd);
                $.ajax({
                    url: 'update-bt-product.php',
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
                            loadBtProduct (idPrd,tailPrd);
                        }
                    }
                });
            }
        });

        function loadBtProduct (idPrd,tailPrd) {
            var fd = new FormData();
            fd.append('id_prd',idPrd);
            fd.append('tail_prd',tailPrd);
            $.ajax({
                url: 'load-bt-product.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    console.log(response);
                    if(response != 0){
                        if (windowWidth > 768) {
                            $("body").removeClass('body-after');
                            $('#update_bt_product_container').css({'top':'','transform':''});
                            $('#update_bt_product').hide();
                            $('#user_bt_annonce_'+tailPrd).replaceWith(response);
                            $('#update_bt_product_container').empty();
                        }
                        else{
                            $('#update_bt_product').css('transform','');
                            setTimeout(() => {
                                $('#user_bt_annonce_'+tailPrd).replaceWith(response);
                                $('#update_bt_product_container').empty();
                            }, 400);
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

        $(document).on('click','[id^="renew_bt_annc_"]',function(){
            var id = $(this).attr("id").split("_")[3];
            var fd = new FormData();
            var idPrd = $('#id_prd_'+id).val();
            fd.append('id_prd',idPrd);
            $.ajax({
                url: 'renew-user-annonce.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $('.user_bt_annonce_'+id).css('opacity','0.5');
                    $('.user_bt_annonce_'+id+' loader_annonce').show();
                },
                success: function(response){
                    if(response != 0){
                        $('.gb-message-alert').css('transform','translateY(0)');
                    }
                },
                complete: function(){
                    $('.user_bt_annonce_'+id).css('opacity','');
                    $('.user_bt_annonce_'+id+' loader_annonce').hide();
                    setTimeout(() => {
                        $('.gb-message-alert').css('transform','');
                    }, 4000);
                }
            });
        });

        $(document).on('click','.cancel-alert-message',function(){
            $('.gb-message-alert').css('transform','');
        })

        // delete annonce
        $(document).on('click','[id^="delete_bt_annc_"]',function(){
            id = $(this).attr("id").split("_")[3];
            var idPrd = $('#id_prd_'+id).val();
            var prdTail = $('#tail_prd_'+id).val();
            $('#id_product_delete').val(idPrd);
            $('#product_tail_delete').val(prdTail);
            $("body").addClass('body-after');
            if (windowWidth > 768) {
                $('#delete_product').show();
            }else{
                $('#delete_product').css('transform','translateY(0)');
            }
        });

        $(document).on('click','#delete_prd_button',function(){
            var fd = new FormData();
            var idPrd = $('#id_product_delete').val();
            fd.append('id_prd',idPrd);
            var prdTail = $('#product_tail_delete').val();
            $.ajax({
                url: 'delete-annonce.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response != 0){
                        $("body").removeClass('body-after');
                        if (windowWidth > 768) {
                            $('#delete_product').hide();
                        }else{
                            $('#delete_product').css('transform','');
                        }
                        $('#user_bt_annonce_'+prdTail).remove();
                    }
                }
            });
        });

        $(document).on('click','#cancel_delete_product',function(e){
            e.stopPropagation();
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $('#delete_product').hide();
            }else{
                $('#delete_product').css('transform','');
            }
        });

        $(document).on('click','#cancel_delete_prd_button',function(e){
            e.stopPropagation();
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $('#delete_product').hide();
            }else{
                $('#delete_product').css('transform','');
            }
        });

        $('#delete_product').click(function(e){
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $('#delete_product').hide();
            }else{
                $('#delete_product').css('transform','');
            }
        });

        var typeFilter = '<?php if (isset($_GET['type'])) { echo $_GET['type']; } else { echo ''; } ?>';
        var rechercheText = '<?php if (isset($_GET['text'])) { echo $_GET['text']; } else { echo ''; } ?>';
        var categoriePrd = '<?php if (isset($_GET['categorie'])) { echo $_GET['categorie']; } else { echo ''; } ?>';
        var dateDebutPrd = '<?php if (isset($_GET['debut'])) { echo $_GET['debut']; } else { echo ''; } ?>';
        var dateFinPrd = '<?php if (isset($_GET['fin'])) { echo $_GET['fin']; } else { echo ''; } ?>';
        var villePrd = '<?php if (isset($_GET['ville'])) { echo $_GET['ville']; } else { echo ''; } ?>';
        var communePrd = '<?php if (isset($_GET['commune'])) { echo $_GET['commune']; } else { echo ''; } ?>';
        $(window).on('load', function(){ 
            if (typeFilter !== '') {
                $('#recherche_text').val(rechercheText);
                var fd = new FormData();
                fd.append('type_filter',typeFilter);
                fd.append('text',rechercheText);
                fd.append('categorie_prd',categoriePrd);
                fd.append('date_debut_prd',dateDebutPrd);
                fd.append('date_fin_prd',dateFinPrd);
                fd.append('ville_prd',villePrd);
                fd.append('commune_prd',communePrd);
                $.ajax({
                    url: 'filter-boutdechantier.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $(".boutdechantier-right-container").empty();
                        $("#loader_load").show();
                        var filter = '';
                        if (typeFilter == 'today' || typeFilter == 'week' || typeFilter == 'month') {
                            history.replaceState(null,'', 'boutdechantier/'+typeFilter);
                        }
                        else if (typeFilter == 'text') {
                            history.replaceState(null,'', 'boutdechantier/'+typeFilter+'/'+rechercheText);
                        }
                        else if (typeFilter == 'filter') {
                            if (categoriePrd != '') { filter = '/'+categoriePrd; } else { filter = filter+'/0'; }
                            if (villePrd != '') { filter = filter+'/'+villePrd; } else { filter = filter+'/0'; }
                            if (communePrd != '') { filter = filter+'/'+communePrd; } else { filter = filter+'/0'; }
                            history.replaceState(null,'', 'boutdechantier/'+typeFilter+filter);
                        }
                    },
                    success: function(response){
                        if (response != 0) {
                            $('.boutdechantier-right-container').append(response);
                        }
                    },
                    complete: function(response){
                        $("#loader_load").hide();
                    }
                });
            }
        })

        $('.boutdechantier-left').click(function(e){
            e.stopPropagation();
        })

        $('#display_boutdechantier_categories').click(function(){
            if ($('#boutdechantier_categories').height() > 0) {
                $('#boutdechantier_categories').css({'max-height':''});
            }
            else{
                $('#boutdechantier_categories').css({'max-height':'127px'});
            }
        })

        $('#display_boutdechantier_localisation').click(function(){
            if ($('#boutdechantier_localisation').height() > 0) {
                $('#boutdechantier_localisation').css({'max-height':''});
            }
            else{ 
                $('#boutdechantier_localisation').css({'max-height':'127px'});
            }
        })

        $('#ville_boutdechantier_filter').on('change',function() {
            var ville  = $(this).val();
            if (ville !== '') {
                $('.commune-boutdechantier-filter').load('commune-filter-boutdechantier.php?v='+ville);
            }
        })

        // filter boutdechantier
        $('#filter_boutdechantier_button').on('click',function() {
            var typeFilter = 'filter';
            var rechercheText = '';
            var categoriePrd = $('#categorie_boutdechantier').val();
            var dateDebutPrd = '';
            var dateFinPrd = '';
            var villePrd = $('#ville_boutdechantier_filter').val();
            var communePrd = $('#commune_boutdechantier_filter').val();
            var fd = new FormData();
            fd.append('type_filter',typeFilter);
            fd.append('text',rechercheText);
            fd.append('categorie_prd',categoriePrd);
            fd.append('date_debut_prd',dateDebutPrd);
            fd.append('date_fin_prd',dateFinPrd);
            fd.append('ville_prd',villePrd);
            fd.append('commune_prd',communePrd);
            $.ajax({
                url: 'filter-boutdechantier.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".boutdechantier-right-container").empty();
                    $("#loader_load").show();
                    var filter = '';
                    if (categoriePrd != '') { filter = '/'+categoriePrd; } else { filter = filter+'/0'; }
                    if (villePrd != '') { filter = filter+'/'+villePrd; } else { filter = filter+'/0'; }
                    if (communePrd != '') { filter = filter+'/'+communePrd; } else { filter = filter+'/0'; }
                    history.replaceState(null,'', 'boutdechantier/'+typeFilter+filter);
                },
                success: function(response){
                    if (response != 0) {
                        if (windowWidth > 1250) {
                            $('.boutdechantier-right-container').append(response);
                        }
                        else{
                            hideLeftBoutdechantier ();
                            setTimeout(() => {
                                $('.boutdechantier-right-container').append(response);
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
            var categoriePrd = '';
            var dateDebutPrd = d.toLocaleDateString();
            var dateFinPrd = '';
            var villePrd = '';
            var communePrd = '';
            var fd = new FormData();
            fd.append('type_filter',typeFilter);
            fd.append('text',rechercheText);
            fd.append('categorie_prd',categoriePrd);
            fd.append('date_debut_prd',dateDebutPrd);
            fd.append('date_fin_prd',dateFinPrd);
            fd.append('ville_prd',villePrd);
            fd.append('commune_prd',communePrd); 
            $.ajax({
                url: 'filter-boutdechantier.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".boutdechantier-right-container").empty();
                    $("#loader_load").show();
                    history.replaceState(null,'', 'boutdechantier/'+typeFilter);
                },
                success: function(response){
                    if (response != 0) {
                        if (windowWidth > 1250) {
                            $('.boutdechantier-right-container').append(response);
                        }
                        else{
                            hideLeftBoutdechantier ();
                            setTimeout(() => {
                                $('.boutdechantier-right-container').append(response);
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
            var categoriePrd = '';
            var dateDebutPrd = firstDay;
            var dateFinPrd = lastDay;
            var villePrd = '';
            var communePrd = '';
            var fd = new FormData();
            fd.append('type_filter',typeFilter);
            fd.append('text',rechercheText);
            fd.append('categorie_prd',categoriePrd);
            fd.append('date_debut_prd',dateDebutPrd);
            fd.append('date_fin_prd',dateFinPrd);
            fd.append('ville_prd',villePrd);
            fd.append('commune_prd',communePrd); 
            $.ajax({
                url: 'filter-boutdechantier.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".boutdechantier-right-container").empty();
                    $("#loader_load").show();
                    history.replaceState(null,'', 'boutdechantier/'+typeFilter);
                },
                success: function(response){
                    if (response != 0) {
                        if (windowWidth > 1250) {
                            $('.boutdechantier-right-container').append(response);
                        }
                        else{
                            hideLeftBoutdechantier ();
                            setTimeout(() => {
                                $('.boutdechantier-right-container').append(response);
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
            var categoriePrd = '';
            var dateDebutPrd = firstDay;
            var dateFinPrd = lastDay;
            var villePrd = '';
            var communePrd = '';
            var fd = new FormData();
            fd.append('type_filter',typeFilter);
            fd.append('text',rechercheText);
            fd.append('categorie_prd',categoriePrd);
            fd.append('date_debut_prd',dateDebutPrd);
            fd.append('date_fin_prd',dateFinPrd);
            fd.append('ville_prd',villePrd);
            fd.append('commune_prd',communePrd); 
            $.ajax({
                url: 'filter-boutdechantier.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".boutdechantier-right-container").empty();
                    $("#loader_load").show();
                    history.replaceState(null,'', 'boutdechantier/'+typeFilter);
                },
                success: function(response){
                    if (response != 0) {
                        if (windowWidth > 1250) {
                            $('.boutdechantier-right-container').append(response);
                        }
                        else{
                            hideLeftBoutdechantier ();
                            setTimeout(() => {
                                $('.boutdechantier-right-container').append(response);
                            }, 400);
                        }
                    }
                },
                complete: function(response){
                    $("#loader_load").hide();
                }
            });
        })

        // reset filter boutdechantier
        $('#reset_boutdechantier_button').on('click',function() {
            var typeFilter = 'filter';
            var rechercheText = '';
            var categoriePrd = '';
            var dateDebutPrd = '';
            var dateFinPrd = '';
            var villePrd = '';
            var communePrd = '';
            var fd = new FormData();
            fd.append('type_filter',typeFilter);
            fd.append('text',rechercheText);
            fd.append('categorie_prd',categoriePrd);
            fd.append('date_debut_prd',dateDebutPrd);
            fd.append('date_fin_prd',dateFinPrd);
            fd.append('ville_prd',villePrd);
            fd.append('commune_prd',communePrd); 
            $.ajax({
                url: 'filter-boutdechantier.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".boutdechantier-right-container").empty();
                    $("#loader_load").show();
                    history.replaceState(null,'', 'boutdechantier/filter/0/0/0');
                },
                success: function(response){
                    if (response != 0) {
                        if (windowWidth >= 1250) {
                            $('.boutdechantier-right-container').append(response);
                        }
                        else{
                            hideLeftBoutdechantier ();
                            setTimeout(() => {
                                $('.boutdechantier-right-container').append(response);
                            }, 400);
                        }
                    }
                },
                complete: function(response){
                    $('#boutdechantier_categories option:eq(0)').prop('selected',true);
                    $('#boutdechantier_localisation option:eq(0)').prop('selected',true);
                    $('.commune-boutdechantier-filter option:eq(0)').prop('selected',true);
                    $("#loader_load").hide();
                }
            });
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