<?php 
session_start();
include_once './bdd/connexion.php';
if (isset($_SESSION['user'])) {
    $cnx_user_query = "SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['user'];
    $result = mysqli_query($conn, $cnx_user_query);
    $row = mysqli_fetch_assoc($result);
    $id_user = $row['id_user'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css-js/style.css">
    <link rel="stylesheet" href="./css-js/boutdechantier.css">
    <link href="./css-js/fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fugaz One">
    <title>Bout de chantier</title>
</head>
<body>
    <?php include './navbar.php';?>
    <div class="clear"></div>
    <div class="boutdechantier-recherche-responsive">
        <div id="back_history">
            <i class="fas fa-arrow-left"></i>
        </div>
        <div id="boutdechantier_recherche_responsive">
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
    <div class="boutdechantier-left">
        <h2>Bout de chantier</h2>
        <div class="boutdechantier-recherche">
            <input type="text" id="recherche_text" placeholder="Entrez votre recherche ...">
            <i class="fas fa-search"></i>
        </div>
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
            
        </div>
    </div>
    <div id="loader" class="center"></div>
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
            var session = $('#session').val();
            if (session != 0) {
                // $('.navbar-right').hide();
            }
            else{}
        }
        else{
            $('.clear-session').css('height','60px');
        }

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

        $('#recherche_text_resp').click(function(e){
            e.stopPropagation();
            setBoutdechantierSearchBar();
        })

        var uid = <?php echo $id_user; ?>;
        var websocket_server = 'ws://<?php echo $_SERVER['HTTP_HOST']; ?>:3030?uid='+uid;
        var websocket = false;
        var js_flood = 0;
        var status_websocket = 0;
        $(document).ready(function() {
            start(websocket_server);
        });
    </script>
    <script src="css-js/websocket.js"></script>
</body>
</html>