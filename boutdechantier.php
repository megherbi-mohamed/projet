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
            <div id="back_menu">
                <i class="fas fa-arrow-left"></i>
            </div>    
            <div id="boutdechantier_recherche_responsive">
                <input type="text" id="recherche_text_resp" placeholder="Chercher un produit ...">
                <i class="fas fa-search"></i>
            </div>
            <div id="display_categories">
                <i class="fas fa-list"></i>
            </div>
            <!-- <div id="display_filter">
                <i class="fas fa-filter"></i>
            </div> -->
            <div id="display_bt_search_bar">
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
        <div class="boutdechantier-categories">
            <div class="boutdechantier-categorie-top">
                <h3>Catégories</h3>
            </div>
            <div class="boutdechantier-categorie-bottom">
                <div class="bt-categorie">
                    <div>
                        <img src="./icons/outillage-icon.png" alt="">
                    </div>
                    <p>Outillages</p>
                </div>
                <div class="bt-categorie">
                    <div>
                        <img src="./icons/quincallerie-icon.png" alt="">
                    </div>
                    <p>Quincalleries</p>
                </div>
                <div class="bt-categorie">
                    <div>
                        <img src="./icons/outillage-icon.png" alt="">
                    </div>
                    <p>Matériel et équipement</p>
                </div>
                <div class="bt-categorie">
                    <div>
                        <img src="./icons/peinture-vernis-icon.png" alt="">
                    </div>
                    <p>Peinture et vernis</p>
                </div>
                <div class="bt-categorie">
                    <div>
                        <img src="./icons/revetement-mural-icon.png" alt="">
                    </div>
                    <p>Revetement mural</p>
                </div>
                <div class="bt-categorie">
                    <div>
                        <img src="./icons/electricite-icon.png" alt="">
                    </div>
                    <p>Eléctricité</p>
                </div>
                <div class="bt-categorie">
                    <div>
                        <img src="./icons/menuiserie-bois-icon.png" alt="">
                    </div>
                    <p>Menuiserie et bois</p>
                </div>
                <div class="bt-categorie">
                    <div>
                        <img src="./icons/porte-fenetre-icon.png" alt="">
                    </div>
                    <p>Portes et fenetres</p>
                </div>
                <div class="bt-categorie">
                    <div>
                        <img src="./icons/outillage-icon.png" alt="">
                    </div>
                    <p>Cloison et séparation</p>
                </div>
                <div class="bt-categorie">
                    <div>
                        <img src="./icons/isolation-icon.png" alt="">
                    </div>
                    <p>Isolation</p>
                </div>
                <div class="bt-categorie">
                    <div>
                        <img src="./icons/revetemet-sol-icon.png" alt="">
                    </div>
                    <p>Revetements sol</p>
                </div>
                <div class="bt-categorie">
                    <div>
                        <img src="./icons/outillage-icon.png" alt="">
                    </div>
                    <p>Matériaux et gros oeuvre</p>
                </div>
                <div class="bt-categorie">
                    <div>
                        <img src="./icons/plombrie-icon.png" alt="">
                    </div>
                    <p>Plombrie</p>
                </div>
            </div>
        </div>
        <div class="bt-sous-gategorie">
            <div class="bt-sous-gategorie-top">
                <div id="return_categorie">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <h3>Outillages</h3>
                <div>
                    <img src="./icons/outillage-icon.png" alt="">
                </div>
            </div>
            <div class="bt-sous-gategorie-bottom">

            </div>
        </div>
        <div class="bt-sous-gategorie">
            <div class="bt-sous-gategorie-top">
                <div id="return_categorie">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <h3>Quincalleries</h3>
                <div>
                    <img src="./icons/quincallerie-icon.png" alt="">
                </div>
            </div>
            <div class="bt-sous-gategorie-bottom">

            </div>
        </div>
        <div class="bt-sous-gategorie">
            <div class="bt-sous-gategorie-top">
                <div id="return_categorie">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <h3>Matériel et équipement</h3>
                <div>
                    <img src="./icons/outillage-icon.png" alt="">
                </div>
            </div>
            <div class="bt-sous-gategorie-bottom">

            </div>
        </div>
        <div class="bt-sous-gategorie">
            <div class="bt-sous-gategorie-top">
                <div id="return_categorie">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <h3>Peinture et vernis</h3>
                <div>
                    <img src="./icons/peinture-vernis-icon.png" alt="">
                </div>
            </div>
            <div class="bt-sous-gategorie-bottom">

            </div>
        </div>
        <div class="bt-sous-gategorie">
            <div class="bt-sous-gategorie-top">
                <div id="return_categorie">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <h3>Revetement mural</h3>
                <div>
                    <img src="./icons/revetement-mural-icon.png" alt="">
                </div>
            </div>
            <div class="bt-sous-gategorie-bottom">

            </div>
        </div>
        <div class="bt-sous-gategorie">
            <div class="bt-sous-gategorie-top">
                <div id="return_categorie">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <h3>Eléctricité</h3>
                <div>
                    <img src="./icons/electricite-icon.png" alt="">
                </div>
            </div>
            <div class="bt-sous-gategorie-bottom">

            </div>
        </div>
        <div class="bt-sous-gategorie">
            <div class="bt-sous-gategorie-top">
                <div id="return_categorie">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <h3>Menuiserie et bois</h3>
                <div>
                    <img src="./icons/menuiserie-bois-icon.png" alt="">
                </div>
            </div>
            <div class="bt-sous-gategorie-bottom">

            </div>
        </div>
        <div class="bt-sous-gategorie">
            <div class="bt-sous-gategorie-top">
                <div id="return_categorie">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <h3>Portes et fenetres</h3>
                <div>
                    <img src="./icons/porte-fenetre-icon.png" alt="">
                </div>
            </div>
            <div class="bt-sous-gategorie-bottom">

            </div>
        </div>
        <div class="bt-sous-gategorie">
            <div class="bt-sous-gategorie-top">
                <div id="return_categorie">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <h3>Cloison et séparation</h3>
                <div>
                    <img src="./icons/outillage-icon.png" alt="">
                </div>
            </div>
            <div class="bt-sous-gategorie-bottom">

            </div>
        </div>
        <div class="bt-sous-gategorie">
            <div class="bt-sous-gategorie-top">
                <div id="return_categorie">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <h3>Isolation</h3>
                <div>
                    <img src="./icons/isolation-icon.png" alt="">
                </div>
            </div>
            <div class="bt-sous-gategorie-bottom">

            </div>
        </div>
        <div class="bt-sous-gategorie">
            <div class="bt-sous-gategorie-top">
                <div id="return_categorie">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <h3>Revetements sol</h3>
                <div>
                    <img src="./icons/revetemet-sol-icon.png" alt="">
                </div>
            </div>
            <div class="bt-sous-gategorie-bottom">

            </div>
        </div>
        <div class="bt-sous-gategorie">
            <div class="bt-sous-gategorie-top">
                <div id="return_categorie">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <h3>Matériaux et gros oeuvre</h3>
                <div>
                    <img src="./icons/outillage-icon.png" alt="">
                </div>
            </div>
            <div class="bt-sous-gategorie-bottom">
                
            </div>
        </div>
        <div class="bt-sous-gategorie">
            <div class="bt-sous-gategorie-top">
                <div id="return_categorie"> 
                    <i class="fas fa-arrow-left"></i>
                </div>
                <h3>Plombrie</h3>
                <div>
                    <img src="./icons/plombrie-icon.png" alt="">
                </div>
            </div>
            <div class="bt-sous-gategorie-bottom">
                
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
                        <p><?php echo $get_product_row['lieu_prd'] ?></p>
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
    <div class="update-product" id="update_product">
        <div class="update-product-container">
            <div class="update-product-top">
                <div class="cancel-update-product-mobile" id="cancel_update_product_resp">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <h4>Modifier l'annonce</h4>
                <div class="cancel-update-product" id="cancel_update_product">
                    <i class="fas fa-times"></i>
                </div>
                <button id="update_product_button_resp">Modifier</button>
            </div>
            <div class="update-product-bottom">
                <input type="hidden" id="id_product_updt">
                <input type="hidden" id="product_tail_updt">
                <div class="product-input">
                    <input type="text" id="updt_name_bt_prd">
                    <span class="name-bt-prd active-updt-bt-prd-span">Titre *</span>
                </div>
                <div class="product-input">
                    <input type="text" id="updt_categorie_bt_prd">
                    <span class="categorie-bt-prd active-updt-bt-prd-span">Categorie</span>
                </div>
                <div class="product-input">
                    <input type="text" id="updt_description_bt_prd">
                    <span class="description-bt-prd active-updt-bt-prd-span">Description</span>
                </div>
                <div class="product-input">
                    <input type="number" id="updt_quantity_bt_prd">
                    <span class="quanntite-bt-prd">Quantite *</span>
                </div>
                <div class="product-input">
                    <select id="updt_type_bt_prd">
                        <option value="payant">Payant</option>
                        <option value="gratuit">Gratuit</option>
                    </select>
                    <span class="type-bt-prd">Type *</span>
                </div>
                <div class="product-input">
                    <input type="text" step="000000.00" id="updt_price_bt_prd" value="0">
                    <span class="price-bt-prd">Prix *</span>
                </div>
                <div class="product-update-images-preview"></div>
                <div class="update-product-options">
                    <P>Ajouter des photos</P>
                    <div id="update_product_image">
                        <i class="far fa-images"></i>
                    </div>
                </div>
                <form enctype="multipart/form-data">
                    <input type="file" id="image_prd_updt" name="images_prd_updt[]" accept="image/*" multiple>
                    <input type="button" id="update_product_image_button">
                </form>
                <button id="update_product_button">Enregistrer la modification</button>
            </div>
            <div id="loader_load_updt" class="center"></div>
        </div>
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
            $('.boutdechantier-left').css('transform','translateX(0)');
        })

        $('#boutdechantier_recherche_responsive').click(function(e){
            e.stopPropagation();
        })

        $('#display_bt_search_bar').click(function(e){
            e.stopPropagation();
            setBoutdechantierSearchBar();
        })

        $(document).on('keypress',"#recherche_text",function() {
            if (event.which == 13) {
                var fd = new FormData();
                var rechercheText = $('#recherche_text').val();
                fd.append('text',rechercheText);
                $.ajax({
                    url: 'recherche-boutdechantier-product.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
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
        });

        $(document).on('keypress',"#recherche_text_resp",function() {
            if (event.which == 13) {
                var fd = new FormData();
                var rechercheText = $('#recherche_text_resp').val();
                fd.append('text',rechercheText);
                $.ajax({
                    url: 'recherche-boutdechantier-product.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $(".boutdechantier-right-container").empty();
                        $("#loader_load").show();
                    },
                    success: function(response){
                        $('.boutdechantier-right-container').append(response);
                    },
                    complete: function(response){
                        unsetBoutdechantierSearchBar();
                        $("#loader_load").hide();
                    }
                });
            }
        });

        // display user annonces
        $(document).on('click',"#display_bt_product_user",function() {
            $(this).css('background','#ecedee');
            $.ajax({
                url: 'laod-user-bt-annonces.php',
                beforeSend: function(){
                    $(".boutdechantier-right-container").empty();
                    $("#loader_load").show();
                },
                success: function(response){
                    history.pushState('annonces','', '/projet/boutdechantier/annonces');
                    $('.boutdechantier-right-container').append(response);
                },
                complete: function(response){
                    $("#loader_load").hide();
                }
            });
        });

        // update boutdechantier annonce
        $(document).on('focus','.update-product-bottom input',function(){
            var id = $(this).attr('id');
            if (id == 'updt_lieu_bt_prd') {
                $('.lieu-bt-prd').addClass('active-updt-bt-prd-span');
            }
            if (id == 'updt_name_bt_prd') {
                $('.name-bt-prd').addClass('active-updt-bt-prd-span');
            }
            if (id == 'updt_categorie_bt_prd') {
                $('.categorie-bt-prd').addClass('active-updt-bt-prd-span');
            }
            if (id == 'updt_description_bt_prd') {
                $('.description-bt-prd').addClass('active-updt-bt-prd-span');
            }
        })
        
        $(document).on('click','[id^="update_bt_annc_"]',function(){
            id = $(this).attr("id").split("_")[3];
            var idPrd = $('#id_prd_'+id).val(); 
            var prdTail = $('#tail_prd_'+id).val();
            var prdName = $('#name_prd_'+id).val();
            var prdCategorie = $('#categorie_prd_'+id).val();
            var prdDescription = $('#description_prd_'+id).val();
            var prdQuantite = $('#quantity_prd_'+id).val();
            var prdType = $('#type_prd_'+id).val();
            var prdPrix = $('#price_prd_'+id).val();
            
            $('#id_product_updt').val(idPrd);
            $('#product_tail_updt').val(prdTail);
            $('#updt_name_bt_prd').val(prdName);
            $('#updt_categorie_bt_prd').val(prdCategorie);
            $('#updt_description_bt_prd').val(prdDescription);
            $('#updt_quantity_bt_prd').val(prdQuantite);
            $('#updt_type_bt_prd').val(prdType);
            $('#updt_price_bt_prd').val(prdPrix);

            $('.product-update-images-preview').load('bt-product-images-preview.php?id_prd='+idPrd);

            if (windowWidth <= 768) {
                $('.update-product').css('transform','translateX(0)');
            }
            else{
                $("body").addClass('body-after');
                $('.update-product').show();
                $('.update-product-container').css({'top':'0','transform':'translate(-50%,0%)'});
            }
        });

        $('#cancel_update_product_resp').click(function(){
            $('.update-product').css('transform','');
        })

        $('#cancel_update_product').click(function(e){
            e.stopPropagation();
            $("body").removeClass('body-after');
            $('.update-product').hide();
            $('.update-product-container').css({'top':'','transform':''});
            $('.product-update-images-preview div').remove();
        })

        $('#update_product').click(function(){
            $("body").removeClass('body-after');
            $('.update-product').hide();
            $('.update-product-container').css({'top':'','transform':''});
            $('.product-update-images-preview div').remove();
        })

        //update product image
        $('.update-product-container').click(function(e){
            e.stopPropagation();
        })

        $('#update_product_image').click(function(){
            $('#image_prd_updt').click();
        });

        $('#image_prd_updt').on('change',function(){ 
            $('#update_product_image_button').click();
        });

        $('#update_product_image_button').click(function(){
            var form_data = new FormData();
            var idBtq = $('#id_boutique_product').val();
            form_data.append('id_btq',idBtq);
            var idPrd = $('#id_product_updt').val();
            form_data.append('id_prd',idPrd);
            var totalfiles = document.getElementById('image_prd_updt').files.length;
            for (let i = 0; i < totalfiles; i++) {
                form_data.append("images[]", document.getElementById('image_prd_updt').files[i]);
            }
            $.ajax({
                url: 'upload-images-bt-product.php', 
                type: 'post',
                data: form_data,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (response) {
                    // console.log(response);
                    if (windowWidth > 768) {
                        $('.update-product-container').css({'top':'0','transform':'translate(-50%,0%)'});
                    }
                    for(let i = 0; i < response.length; i++) {
                        var src = response[i];
                        $('.product-update-images-preview').append("<div class='product-image-preview' id='product_image_preview_"+i+"'><div id='product_delete_preview_"+i+"'><i class='fas fa-times'></i></div><img src='"+src+"'></div>");
                    }
                }
            });
        });

        // remove update product images preview
        $('.product-update-images-preview').on('click','[id^="product_delete_preview_"]',function(){
            var id = $(this).attr("id").split("_")[3];
            var fd = new FormData();
            var idBtq = $('#id_boutique_product').val();
            fd.append('id_btq',idBtq);
            var idPrd = $('#id_product_updt').val();
            fd.append('id_prd',idPrd);
            var mediaUrl = $('.product-update-images-preview #product_image_preview_'+id+' img').attr('src');
            fd.append('media_url',mediaUrl);
            $.ajax({
                url: 'update-images-bt-product.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response != 0){
                        $('.product-update-images-preview #product_image_preview_'+id).remove();
                    }
                }
            });
        });

        $('#update_product_button').click(function(){
            console.log('click');
            var fd = new FormData();
            var idPrd = $('#id_product_updt').val();
            fd.append('id_prd',idPrd);
            var namePrd = $('#updt_name_bt_prd').val();
            fd.append('nom_prd',namePrd);
            var categoriePrd = $('#updt_categorie_bt_prd').val();
            fd.append('categorie_prd',categoriePrd);
            var descriptionPrd = $('#updt_description_bt_prd').val();
            fd.append('description_prd',descriptionPrd);
            var quantityPrd = $('#updt_quantity_bt_prd').val();
            fd.append('quantite_prd',quantityPrd);
            var typePrd = $('#updt_type_bt_prd').val();
            fd.append('type_prd',typePrd);
            var pricePrd = $('#updt_price_bt_prd').val();
            fd.append('prix_prd',pricePrd);
            var id = $('#product_tail_updt').val();
            fd.append('tail_prd',id);
            $.ajax({
                url: 'update-bt-product.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $('.update-product').css('opacity','0.5');
                    $("#loader_load_updt").show();
                },
                success: function(response){
                    if(response != 0){
                        $('#user_bt_annonce_'+id).replaceWith(response);
                    }
                },
                complete: function(){
                    $("#loader_load_updt").hide();
                    $(".update-product").hide();
                    $("body").removeClass('body-after');
                    $('.update-product-container').css({'top':'','transform':''});
                    $('.update-product').css('opacity','');
                }
            });
        });

        $('#update_product_button_resp').click(function(){
            console.log('click');
            var fd = new FormData();
            var idPrd = $('#id_product_updt').val();
            fd.append('id_prd',idPrd);
            var namePrd = $('#updt_name_bt_prd').val();
            fd.append('nom_prd',namePrd);
            var categoriePrd = $('#updt_categorie_bt_prd').val();
            fd.append('categorie_prd',categoriePrd);
            var descriptionPrd = $('#updt_description_bt_prd').val();
            fd.append('description_prd',descriptionPrd);
            var quantityPrd = $('#updt_quantity_bt_prd').val();
            fd.append('quantite_prd',quantityPrd);
            var typePrd = $('#updt_type_bt_prd').val();
            fd.append('type_prd',typePrd);
            var pricePrd = $('#updt_price_bt_prd').val();
            fd.append('prix_prd',pricePrd);
            var id = $('#product_tail_updt').val();
            fd.append('tail_prd',id);
            $.ajax({
                url: 'update-bt-product.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $('.update-product').css('opacity','0.5');
                    $("#loader_load_updt").show();
                },
                success: function(response){
                    if(response != 0){
                        $('#user_bt_annonce_'+id).replaceWith(response);
                    }
                },
                complete: function(){
                    $("#loader_load_updt").hide();
                    $(".update-product").hide();
                    $("body").removeClass('body-after');
                    $('.update-product-container').css({'top':'','transform':''});
                    $('.update-product').css('opacity','');
                }
            });
        });

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