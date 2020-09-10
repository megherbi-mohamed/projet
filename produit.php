<?php 
session_start();
include_once './bdd/connexion.php';
if (isset($_SESSION['user'])) {
    $cnx_user_query = "SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['user'];
    $result = mysqli_query($conn, $cnx_user_query);
    $row = mysqli_fetch_assoc($result);
    $id_user = $row['id_user'];
}
// else{
//     header('Location: inscription-connexion.php');
// }


$prd_inf_query = "SELECT * FROM produit_boutique WHERE id_prd = {$_GET['id_prd']}";
$prd_inf_result = mysqli_query($conn, $prd_inf_query);
$prd_inf_row = mysqli_fetch_assoc($prd_inf_result);

$displayDiv = '';
$displayImg2 = '';
$displayImg3 = '';
$displayImg4 = '';

if($prd_inf_row['image_2'] == ''){
    $displayImg2 = 'display: none';
    $displayDiv = 'display: none';
} 
if($prd_inf_row['image_3'] == ''){
    $displayImg3 = 'display: none';
} 
if($prd_inf_row['image_4'] == ''){
    $displayImg4 = 'display: none';
} 

$displayMdl1 = '';
$displayMdl2 = '';
$displayMdl3 = '';
$displayMdl4 = '';

if($prd_inf_row['modele_1'] == ''){
    $displayMdl1 = 'display: none';
} 
if($prd_inf_row['modele_2'] == ''){
    $displayMdl2 = 'display: none';
} 
if($prd_inf_row['modele_3'] == ''){
    $displayMdl3 = 'display: none';
} 
if($prd_inf_row['modele_4'] == ''){
    $displayMdl4 = 'display: none';
} 

if ($prd_inf_row['id_btq'] != $_GET['id_btq']) {
    header('Location: inscription-connexion.php');
}
else{
    $btq_inf_query = "SELECT * FROM boutiques WHERE id_btq = {$prd_inf_row['id_btq']}";
    $btq_inf_result = mysqli_query($conn, $btq_inf_query);
    $btq_inf_row = mysqli_fetch_assoc($btq_inf_result);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css-js/style.css">
    <link rel="stylesheet" href="./css-js/produit.css">
    <link href="./css-js/fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fugaz One">
    <title>Boutique</title>
</head>
<body>
    <?php include './navbar.php'; ?>
    <?php if (isset($_SESSION['user'])) { ?>
        <input type="hidden" id="session" value="1">
        <div class="clear-session"></div>
    <?php }else{ ?>
        <input type="hidden" id="session" value="0">
        <div class="clear"></div>
    <?php } ?>
    <div class="product-container">
        <div class="product-top">
            <div class="product-top-left">
                <img src="./<?php echo $prd_inf_row['image_1'] ?>" alt="">
                <div>
                    <img class="current-show-image" src="./<?php echo $prd_inf_row['image_1'] ?>" alt="">
                    <img style="<?php echo $displayImg2 ?>" src="./<?php echo $prd_inf_row['image_2'] ?>" alt="">
                    <img style="<?php echo $displayImg3 ?>" src="./<?php echo $prd_inf_row['image_3'] ?>" alt="">
                    <img style="<?php echo $displayImg4 ?>" src="./<?php echo $prd_inf_row['image_4'] ?>" alt="">
                </div>
            </div>
            <div class="produit-top-left-responsive">
                <div>
                    <img src="./<?php echo $prd_inf_row['image_1'] ?>" alt="">
                    <img style="<?php echo $displayImg2 ?>" src="./<?php echo $prd_inf_row['image_2'] ?>" alt="">
                    <img style="<?php echo $displayImg3 ?>" src="./<?php echo $prd_inf_row['image_3'] ?>" alt="">
                    <img style="<?php echo $displayImg4 ?>" src="./<?php echo $prd_inf_row['image_4'] ?>" alt="">
                </div>
                <div class="current-image-product" style="<?php echo $displayDiv ?>">
                    <i class="fa fa-circle"></i>
                    <i style="<?php echo $displayImg2 ?>" class="far fa-circle"></i>
                    <i style="<?php echo $displayImg3 ?>" class="far fa-circle"></i>
                    <i style="<?php echo $displayImg4 ?>" class="far fa-circle"></i>
                </div> 
            </div>
            <div class="product-top-middle">
                <h3><?php echo $prd_inf_row['titre_prd'] ?></h3>
                <p><?php echo $prd_inf_row['dscrp_prd'] ?></p>
                <h4>Prix : <span><?php echo $prd_inf_row['prix_prd'].' DA' ?></span></h4>
                <h4>Quantité : <span><?php echo $prd_inf_row['quantite_prd'].' pcs' ?></span></h4>
                <!-- <p>Modele disponible</p> -->
                <div class="product-modele">
                    <!-- <img class="current-product-modele" src="./<?php echo $prd_inf_row['image_1'] ?>" alt="">
                    <img style="<?php echo $displayMdl1 ?>" src="./<?php echo $prd_inf_row['modele_1'] ?>" alt="">
                    <img style="<?php echo $displayMdl2 ?>" src="./<?php echo $prd_inf_row['modele_2'] ?>" alt="">
                    <img style="<?php echo $displayMdl3 ?>" src="./<?php echo $prd_inf_row['modele_3'] ?>" alt="">
                    <img style="<?php echo $displayMdl4 ?>" src="./<?php echo $prd_inf_row['modele_4'] ?>" alt=""> -->

                    <img class="current-product-modele" src="./<?php echo $prd_inf_row['image_1'] ?>" alt="">
                    <img style="<?php echo $displayImg2 ?>" src="./<?php echo $prd_inf_row['image_2'] ?>" alt="">
                    <img style="<?php echo $displayImg3 ?>" src="./<?php echo $prd_inf_row['image_3'] ?>" alt="">
                    <img style="<?php echo $displayImg4 ?>" src="./<?php echo $prd_inf_row['image_4'] ?>" alt="">
                </div>
                <div>
                    <button><i class="fas fa-phone-alt"></i><?php echo $btq_inf_row['tlph_btq'] ?></button>
                    <form action="save_product_form">
                        <input type="hidden" id="save_prd_id" value="<?php echo $prd_inf_row['id_prd'] ?>">
                        <input type="submit" id="save_now" value="Ajouter au panier">
                    </form>
                </div>
            </div>
            <div class="product-top-right">
                <div>
                    <img src="./<?php echo $btq_inf_row['logo_btq']; ?>" alt="">
                    <h4>Boutique <a href="./boutique.php?id_btq=<?php echo $prd_inf_row['id_btq']; ?>"><?php echo $btq_inf_row['nom_btq'] ?></a></h4>
                </div>
                <div>
                    <?php
                        $tpr1 = 'far fa-star';$tpr2 = 'far fa-star';$tpr3 = 'far fa-star';$tpr4 = 'far fa-star';$tpr5 = 'far fa-star';
                    ?>
                    <h5>Produit noté</h5>
                    <i class="<?php echo $tpr1 ?>"></i>
                    <i class="<?php echo $tpr2 ?>"></i>
                    <i class="<?php echo $tpr3 ?>"></i>
                    <i class="<?php echo $tpr4 ?>"></i>
                    <i class="<?php echo $tpr5 ?>"></i>
                </div>
                <h4>Categorie - <?php echo $prd_inf_row['categorie_prd']; ?></h4>
            </div>
        </div>
        <div class="product-bottom">
            <div class="product-bottom-left">
                <img src="./<?php echo $prd_inf_row['image_1']; ?>" alt="">
                <img src="./<?php echo $prd_inf_row['image_2']; ?>" alt="">
                <img src="./<?php echo $prd_inf_row['image_3']; ?>" alt="">
                <img src="./<?php echo $prd_inf_row['image_4']; ?>" alt="">

                <img src="./<?php echo $prd_inf_row['modele_1']; ?>" alt="">
                <img src="./<?php echo $prd_inf_row['modele_2']; ?>" alt="">
                <img src="./<?php echo $prd_inf_row['modele_3']; ?>" alt="">
                <img src="./<?php echo $prd_inf_row['modele_4']; ?>" alt="">
            </div>
            <div class="product-bottom-right">
                <div class="product-bottom-right-description">
                    <img src="./<?php echo $prd_inf_row['image_1']; ?>" alt="">
                    <div>
                        <h4>Produit</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi, deserunt.</p>
                        <h5>200 DA</h5>
                    </div>
                </div>
                <div class="product-bottom-right-description">
                    <img src="./<?php echo $prd_inf_row['image_1']; ?>" alt="">
                    <div>
                        <h4>Produit</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi, deserunt.</p>
                        <h5>200 DA</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-comment">
            <h3>Commentaires : </h3>
            <form id="product_comment_form">
                <div>
                    <img src="./<?php echo $row['img_user'] ?>" alt="">
                    <input type="hidden" id="id_user_cmnt">
                    <input type="hidden" id="id_prd">
                    <textarea id="product_comment" placeholder="Tapez un commentaire .."></textarea>
                </div>
                <input type="submit" id="comment_now">
            </form>
            <?php ?>
                <div class="product-comment-list">
                    <img src="./" alt="">
                    <p></p>
                </div>
            <?php ?>
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
            if (session == 0) {
                $('.navbar').height(40);
                $('.clear').css('height','40px');
            }
        }
        else{
            $('.clear-session').css('height','60px');
        }
        
        $('.produit-top-left-responsive div:first-child').on('scroll', function () {
            var lastScrollLeft = Math.round($(this).width());
            var currentImage = document.querySelectorAll('.current-image-product i');
            var documentScrollLeft = $(this).scrollLeft();
            
            if (documentScrollLeft == 0) {
            currentImage.forEach(ci => {
                ci.className = 'far fa-circle';
            });
            currentImage[0].className = 'fa fa-circle';
            }
            else if (documentScrollLeft-lastScrollLeft <= 0) {
                currentImage.forEach(ci => {
                    ci.className = 'far fa-circle';
                });
                currentImage[1].className = 'fa fa-circle';
            }
            else if (documentScrollLeft-lastScrollLeft*2 <= 0) {
                currentImage.forEach(ci => {
                    ci.className = 'far fa-circle';
                });
                currentImage[2].className = 'fa fa-circle';
            }
            else if (documentScrollLeft-(lastScrollLeft*2)+lastScrollLeft >= 0) {
                currentImage.forEach(ci => {
                    ci.className = 'far fa-circle';
                });
                currentImage[3].className = 'fa fa-circle';
            }
        });

        var imageDisplay = document.querySelectorAll('.product-top-left div img');
        imageDisplay[0].addEventListener('click',()=>{
            imageDisplay.forEach(img => {
                img.classList.remove("current-show-image");
            });
            imageDisplay[0].classList.add('current-show-image');
            $('.product-top-left > img').remove();
            $('.product-top-left').prepend("<img src='./<?php echo $prd_inf_row['image_1'] ?>' alt=''>")
        });
        imageDisplay[1].addEventListener('click',()=>{
            imageDisplay.forEach(img => {
                img.classList.remove("current-show-image");
            });
            imageDisplay[1].classList.add('current-show-image');
            $('.product-top-left > img').remove();
            $('.product-top-left').prepend("<img src='./<?php echo $prd_inf_row['image_2'] ?>' alt=''>")
        });
        imageDisplay[2].addEventListener('click',()=>{
            imageDisplay.forEach(img => {
                img.classList.remove("current-show-image");
            });
            imageDisplay[2].classList.add('current-show-image');
            $('.product-top-left > img').remove();
            $('.product-top-left').prepend("<img src='./<?php echo $prd_inf_row['image_3'] ?>' alt=''>")
        });
        imageDisplay[3].addEventListener('click',()=>{
            imageDisplay.forEach(img => {
                img.classList.remove("current-show-image");
            });
            imageDisplay[3].classList.add('current-show-image');
            $('.product-top-left > img').remove();
            $('.product-top-left').prepend("<img src='./<?php echo $prd_inf_row['image_4'] ?>' alt=''>")
        });
        
    </script>
</body>
</html>