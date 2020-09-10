<?php 
    session_start();
    include_once './bdd/connexion.php';
    if (isset($_SESSION['user'])) {
        $cnx_user_query = "SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['user'];
        $result = mysqli_query($conn, $cnx_user_query);
        $row = mysqli_fetch_assoc($result);
    }else{ header("location: inscription-connexion.php"); }

    if (isset($_GET['ofr'])) {
        $recrtm_query = "SELECT * FROM recrutements WHERE id_user=".$_GET['ofr'];
        $recrtm_result = mysqli_query($conn, $recrtm_query);
    }else{
        $recrtm_query = "SELECT * FROM recrutements";
        $recrtm_result = mysqli_query($conn, $recrtm_query);
    }

    $ville_query = "SELECT * FROM villes";
    $ville_result = mysqli_query($conn, $ville_query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css-js/style.css">
    <link rel="stylesheet" href="./css-js/recrutements.css">
    <link href="./css-js/fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet">
    <title>Recrutments</title>
</head>
<body>
    <?php include './navbar.php'; ?>
    <div class="clear"></div>
    <div class="recrutements">
        <div class="filtre-result-recrutement">
            <div class="filtre-recrutement">
                <div class="filtre-recrutement-titre">
                    <h4>Filtrez par</h4>
                    <button id="unchecked_button">Reintialisez</button>
                </div>
                <p><i class="fas fa-plus"></i>Demande / Offre</p>
                <div id="type" class="filtre-list">
                    <h6><input class="type" value="demande" type="checkbox">Demande d'emploie </h6>
                    <h6><input class="type" value="offre" type="checkbox">Offre d'emploie </h6>
                </div>
                <p><i class="fas fa-plus"></i>Lieu</p>
                <div id="ville" class="filtre-list filtre-list-ville">
                    <?php while($ville_row = mysqli_fetch_assoc($ville_result)){?>
                    <h6><input class="ville" value="<?php echo $ville_row['ville']; ?>" type="checkbox"><?php echo $ville_row['ville']; ?></h6>
                    <?php } ?>
                </div>
                <p><i class="fas fa-plus"></i>Métier / Profession</p>
                <div id="profession" class="filtre-list">
                    <h6><input class="profession" type="checkbox" value="maçon">Macon </h6>
                    <h6><input class="profession" type="checkbox" value="peinteur">Peinteur </h6>
                    <h6><input class="profession" type="checkbox" value="menuisier">Menuisier </h6>
                    <h6><input class="profession" type="checkbox" value="plombier">Plombier </h6>
                    <h6><input class="profession" type="checkbox" value="chauffagier">Chauffagier </h6>
                </div>
                <p><i class="fas fa-plus"></i>Sexe</p>
                <div id="sexe" class="filtre-list">
                    <h6><input class="sexe" type="checkbox" value="homme">Homme </h6>
                    <h6><input class="sexe" type="checkbox" value="femme">Femme </h6>
                </div>
                <div>
                    <button type="submit" id="filtrer" name="filtrer">Filtrer</button>
                </div>
            </div>
            <div class="filtre-tout-result">
                <div class="search-recrutement">
                    <i id="show_filtre_options" class="fas fa-filter"></i>
                    <div>
                    <input type="text" id="recherche_text" autocomplete="off" placeholder="Trouvez une offre ou demande">
                    <button id="rechercher" name="rechercher"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                <div class="clear-result">
                    <?php while($recrtm_row = mysqli_fetch_assoc($recrtm_result)){ 
                        $user_query = "SELECT * FROM utilisateurs WHERE id_user = {$recrtm_row['id_user']}";
                        $user_result = mysqli_query($conn, $user_query);
                        $user_row = mysqli_fetch_assoc($user_result);
                    ?>
                    <div class="filtre-result" id="filtre_result">
                        <div class="filtre-result-top">
                            <img src="./<?php echo $user_row['img_user']; ?>" alt="">
                            <div>
                                <h4><?php echo $recrtm_row['titre']; ?></h4>
                                <p><?php echo $user_row['nom_user'];?></p>
                            </div>
                            <?php if ($recrtm_row['type'] == 'offre') { ?>
                                <div class="offre-information">
                                    <a href="./offre.php?r=<?php echo $recrtm_row['id_recrtm']; ?>"><i class="fas fa-briefcase"></i><i class="fas fa-info-circle"></i></a>
                                </div>
                                <?php }else{ ?>
                                <div class="offre-information">
                                    <a href="./demande.php?r=<?php echo $recrtm_row['id_recrtm']; ?>"><i class="fas fa-briefcase"></i><i class="fas fa-info-circle"></i></a>
                                </div>
                                <?php } ?>
                        </div>
                        <div class="filtre-result-bottom">
                            <p><i class="fas fa-map-marker-alt"></i><?php echo $recrtm_row['ville'].', Algérie'; ?></p>
                            <p><i class="far fa-clock"></i><?php echo $recrtm_row['date']; ?></p>
                            <p><i class="fas fa-hard-hat"></i><?php echo $recrtm_row['profession']; ?></p>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="./css-js/main.js"></script>
    <script>
        var windowWidth = window.innerWidth;
        if (windowWidth <= 768) {
            $('body').css('overflowY','hidden');
        }

        var filtreList = document.querySelectorAll('.filtre-list');
        var filtreButton = document.querySelectorAll('.filtre-recrutement p');
        var filtreButtonStyle = document.querySelectorAll('.filtre-recrutement i');
        var click = new Array(4);
        for (let i = 0; i < filtreList.length; i++) {
            click[i] = 0;
            filtreButton[i].addEventListener('click',()=>{
                click[i]++;
                if (click[i]%2 == 1) {
                    filtreButtonStyle[i].classList.remove('fa-plus');
                    filtreButtonStyle[i].classList.add('fa-minus');
                    filtreList[i].classList.add('active-filtre-list');
                }
                else{
                    filtreButtonStyle[i].classList.remove('fa-minus');
                    filtreButtonStyle[i].classList.add('fa-plus');
                    filtreList[i].classList.remove('active-filtre-list');
                }
            })  
        }

        // check & uncheck type
        var typeCheckbox = document.querySelectorAll('#type input');
        for (let i = 0; i < typeCheckbox.length; i++) {
            typeCheckbox[i].addEventListener('click',()=>{
                uncheckedType();
                typeCheckbox[i].checked = true;
            })
        }
        function uncheckedType(){
            typeCheckbox.forEach(input => {
                if (input.checked == true) {
                    input.checked = false;
                }
            });
        }

        // check & uncheck ville
        var villeCheckbox = document.querySelectorAll('#ville input');
        for (let i = 0; i < villeCheckbox.length; i++) {
            villeCheckbox[i].addEventListener('click',()=>{
                uncheckedVille();
                villeCheckbox[i].checked = true;
            })
        }
        function uncheckedVille(){
            villeCheckbox.forEach(input => {
                if (input.checked == true) {
                    input.checked = false;
                }
            });
        }

        // check & uncheck profession
        var professionCheckbox = document.querySelectorAll('#profession input');
        for (let i = 0; i < professionCheckbox.length; i++) {
            professionCheckbox[i].addEventListener('click',()=>{
                uncheckedProfession();
                professionCheckbox[i].checked = true;
            })
        }
        function uncheckedProfession(){
            professionCheckbox.forEach(input => {
                if (input.checked == true) {
                    input.checked = false;
                }
            });
        }

        // check & uncheck sexe
        var sexeCheckbox = document.querySelectorAll('#sexe input');
        for (let i = 0; i < sexeCheckbox.length; i++) {
            sexeCheckbox[i].addEventListener('click',()=>{
                uncheckedSexe();
                sexeCheckbox[i].checked = true;
            })
        }
        function uncheckedSexe(){
            sexeCheckbox.forEach(input => {
                if (input.checked == true) {
                    input.checked = false;
                }
            });
        }

        var showFiltreOptionsButton = document.querySelector('#show_filtre_options');
        var filtreOptionsResposive = document.querySelector('.filtre-recrutement');
        var filtreToutResult = document.querySelector('.clear-result');
        showFiltreOptionsButton.addEventListener('click',()=>{
            filtreOptionsResposive.style.transform = 'translateX(0)';
        })
        filtreToutResult.addEventListener('click',()=>{
            filtreOptionsResposive.style.transform = '';
        })

        $('#unchecked_button').click(function(){
            $('input.type').each(function(){
                $(this).prop("checked", false);
            })
            $('input.ville').each(function(){
                $(this).prop("checked", false);
            })
            $('input.profession').each(function(){
                $(this).prop("checked", false);
            })
            $('input.sexe').each(function(){
                $(this).prop("checked", false);
            })
            setTimeout(() => {
                $('.clear-result').load('filtre.php?type=&ville=&profession=&sexe=&recherche_text');
            }, 500);
        })

        $('#rechercher').click(function(){
            $('input.type').each(function(){
                $(this).prop("checked", false);
            })
            $('input.ville').each(function(){
                $(this).prop("checked", false);
            })
            $('input.profession').each(function(){
                $(this).prop("checked", false);
            })
            $('input.sexe').each(function(){
                $(this).prop("checked", false);
            })

            var rechercheText = $('#recherche_text').val();
            setTimeout(() => {
                $('.clear-result').load('filtre.php?type=&ville=&profession=&sexe=&recherche_text='+rechercheText);
            }, 500);
        })

        $('#filtrer').click(function(){
            var typer='',viller='',professionr='',sexer='';
            $('input.type').each(function(){
                if($(this).is(':checked')) {
                    typer = $(this).val();
                }
            })
            $('input.ville').each(function(){
                if($(this).is(':checked')) {
                    viller = $(this).val();
                }
            })
            $('input.profession').each(function(){
                if($(this).is(':checked')) {
                    professionr = $(this).val();
                }
            })
            $('input.sexe').each(function(){
                if($(this).is(':checked')) {
                    sexer = $(this).val();
                }
            })
            filtreOptionsResposive.style.transform = '';
            // history.replaceState(null,'', './recrutements.php');
            setTimeout(() => {
                $('.clear-result').load('filtre.php?type='+typer+'&ville='+viller+'&profession='+professionr+'&sexe='+sexer+'&recherche_text=');
            }, 500);
        });

        var modifyProfileButton = document.querySelector('#modify_profile_button');
        var modifyProfile = document.querySelector('#modify_profile');

        modifyProfileButton.addEventListener('click',()=>{
            window.location = './utilisateur.php?modifier-profile';
        });

        modifyProfile.addEventListener('click',()=>{
            window.location = './utilisateur.php?modifier-profile';
        });

    </script>
</body>
</html>