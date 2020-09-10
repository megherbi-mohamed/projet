<?php 
session_start();
include_once './bdd/connexion.php';
if (isset($_SESSION['user'])) {
    $cnx_user_query = "SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['user'];
    $result = mysqli_query($conn, $cnx_user_query);
    $row = mysqli_fetch_assoc($result);
}
else{
    header('Location: inscription-connexion.php');
}
$id_user = $row['id_user'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css-js/style.css">
    <link rel="stylesheet" href="./css-js/offre-demande.css">
    <link href="./css-js/fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet">
    <title> Ajouter offre</title>
</head>
<body>
    <?php include './navbar.php'; ?>
    <div class="clear"></div>
    <div class="offre-demande-container">
        <?php if ($row['type_user'] == 'professionnel') {?>
        <form action="./ajouter-offre.php" method="post" id="ajouter_offre_form">
            <div class="offre-container">
                <h2></h2> 
                <h3>Ajouter une offre</h3>
                <div class="offre-left">
                    <div>
                        <label>Titre d'offre ?</label>
                        <input type="text" name="titre" id="titre" placeholder="Titre d'offre ...">
                    </div>
                    <div>
                        <label>Profession cherche?</label>
                        <select name="profession" id="profession">
                            <option value="">Profession</option>
                            <option value="macon">Maçon</option>
                            <option value="painteur">Painteur</option>
                            <option value="menuisier">Menuisier</option>
                            <option value="plombier">Plombier</option>
                            <option value="chauffagier">Chauffagier</option>
                        </select>
                    </div>
                    <div>
                        <label>Sexe Cherche?</label>
                        <select name="sexe" id="sexe">
                            <option value="">Sexe</option>
                            <option value="homme">Homme</option>
                            <option value="femme">Femme</option>
                        </select>
                    </div>
                    <div>
                        <label>Ville ?</label>
                        <select name="ville" id="ville">
                            <?php
                            $ville_query = "SELECT * FROM villes";
                            $ville_result = mysqli_query($conn, $ville_query);
                            while($ville_row = mysqli_fetch_assoc($ville_result)){ ?>
                                <option value="<?php echo $ville_row['ville']; ?>"><?php echo $ville_row['ville']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div>
                        <label>Salaire ?</label>
                        <input type="text" name="salaire" id="salaire" placeholder="Salaire proposé ...">
                    </div>
                    <div>
                        <label>Date d'éxpiration ?</label>
                        <input type="date" name="date_expiration" id="date_expiration">
                    </div>
                </div>
                <div class="offre-right">
                    <div class="missions">
                        <label>Missions a faire ?</label>
                        <div class="more-missions-options"><input type="text" name="mission_1" id="mission_1" placeholder="Mission a faire ..."><i class="fas fa-plus"></i></div>
                        <div><input type="text" name="mission_2" placeholder="Mission a faire ..."><i class="fas fa-plus"></i></div>
                        <div><input type="text" name="mission_3" placeholder="Mission a faire ..."><i class="fas fa-plus"></i></div>
                        <div><input type="text" name="mission_4" placeholder="Mission a faire ..."></div>
                    </div>
                    <div class="qualites">
                        <label>Qualités recherchés ?</label>
                        <div class="more-qualites-options"><input type="text" name="qualite_1" id="qualite_1" placeholder="Qualité recherché ..."><i class="fas fa-plus"></i></div>
                        <div><input type="text" name="qualite_2" placeholder="Qualité recherché ..."><i class="fas fa-plus"></i></div>
                        <div><input type="text" name="qualite_3" placeholder="Qualité recherché ..."><i class="fas fa-plus"></i></div>
                        <div><input type="text" name="qualite_4" placeholder="Qualité recherché ..."></div>
                    </div>
                </div>
                <input type="submit" value="Valider" id="valider_offre">
            </div>
        </form>
        <?php }else if($row['type_user'] == 'demandeur'){ ?>
        <form action="./ajouter-demande.php" method="post" id="ajouter_demande_form">
            <div class="demande-container">
                <h2></h2>
                <h3>Ajouter une demande</h3>
                <div class="demande-left">
                    <div>
                        <label>Titre de demande ?</label>
                        <input type="text" name="titre_d" id="titre_d" placeholder="Titre d'offre ...">
                    </div>
                    <div>
                        <label>Ville ?</label>
                        <select name="ville_d" id="ville_d">
                            <?php
                            $ville_query = "SELECT * FROM villes";
                            $ville_result = mysqli_query($conn, $ville_query);
                            while($ville_row = mysqli_fetch_assoc($ville_result)){ ?>
                                <option value="<?php echo $ville_row['ville']; ?>"><?php echo $ville_row['ville']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div>
                        <label>Salaire demande ?</label>
                        <input type="text" name="salaire_d" id="salaire_d" placeholder="Salaire proposé ...">
                    </div>
                </div>
                <div class="demande-right">
                    <div class="competences">
                        <label>Vos competences ?</label>
                        <div class="more-missions-options"><input type="text" name="competence_1" id="competence_1" placeholder="Votre competences ..."><i class="fas fa-plus"></i></div>
                        <div><input type="text" name="competence_2" placeholder="Votre competences ..."><i class="fas fa-plus"></i></div>
                        <div><input type="text" name="competence_3" placeholder="Votre competences ..."><i class="fas fa-plus"></i></div>
                        <div><input type="text" name="competence_4" placeholder="Votre competences ..."></div>
                    </div>
                    <div class="travailles">
                        <label>Que vous voulez travailler ?</label>
                        <div class="more-qualites-options"><input type="text" name="travaille_1" id="travaille_1" placeholder="Decription ..."><i class="fas fa-plus"></i></div>
                        <div><input type="text" name="travaille_2" placeholder="Decription ..."><i class="fas fa-plus"></i></div>
                        <div><input type="text" name="travaille_3" placeholder="Decription ..."><i class="fas fa-plus"></i></div>
                        <div><input type="text" name="travaille_4" placeholder="Decription ..."></div>
                    </div>
                </div>
                <input type="submit" value="Valider" id="valider_demande">
            </div>
        </form>
        <?php } ?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="./css-js/main.js"></script>
    <script>
        var mission = document.querySelectorAll('.missions div');
        var moreMission = document.querySelectorAll('.missions div i');

        for (let i = 0; i < moreMission.length; i++) {
            moreMission[i].addEventListener('click',()=>{
                moreMission[i].style.display = 'none';
                mission[i+1].className = 'more-missions-options';
            })
        }

        var qualite = document.querySelectorAll('.qualites div');
        var moreQualite = document.querySelectorAll('.qualites div i');

        for (let i = 0; i < moreQualite.length; i++) {
            moreQualite[i].addEventListener('click',()=>{
                moreQualite[i].style.display = 'none';
                qualite[i+1].className = 'more-qualites-options';
            })
        }

        var competence = document.querySelectorAll('.competences div');
        var moreCompetence = document.querySelectorAll('.competences div i');

        for (let i = 0; i < moreCompetence.length; i++) {
            moreCompetence[i].addEventListener('click',()=>{
                moreCompetence[i].style.display = 'none';
                competence[i+1].className = 'more-missions-options';
            })
        }

        var travaille = document.querySelectorAll('.travailles div');
        var moreTravaille = document.querySelectorAll('.travailles div i');

        for (let i = 0; i < moreTravaille.length; i++) {
            moreTravaille[i].addEventListener('click',()=>{
                moreTravaille[i].style.display = 'none';
                travaille[i+1].className = 'more-qualites-options';
            })
        }

        var windowWidth = window.innerWidth;
        if (windowWidth <= 768) {
            // $('.demande-container').css('transform','translateX(-100%)');
            // $('.demande-container').css('transition','none');
            // $('.offre-container').css('transition','none');
            
            $('.offre-container h4').click(function(){
                $('.offre-container').css('transform','translateX(-100%)');
                $('.demande-container').css('transform','translateX(-100%)');
            })
        }else{
            $('.offre-container h4').click(function(){
                $('.offre-container').css('transform','translateX(-113%)');
                $('.demande-container').css('transform','translateX(-114%)');
            })
        }
        $('.demande-container h4').click(function(){
            $('.demande-container').css('transform','');
            $('.offre-container').css('transform','');
        })
        
        $('#valider_offre').click(function(event){
            event.preventDefault();
            if ($('#titre').val() == '') {
                $('#titre').css('border','2px solid red');
            }
            else if ($('#profession').val() == '') {
                $('#titre').css('border','');
                $('#profession').css('border','2px solid red');
            }
            else if ($('#sexe').val() == '') {
                $('#titre').css('border','');
                $('#profession').css('border','');
                $('#sexe').css('border','2px solid red');
            }
            else if ($('#ville').val() == '') {
                $('#titre').css('border','');
                $('#profession').css('border','');
                $('#sexe').css('border','');
                $('#ville').css('border','2px solid red');
            }
            else if ($('#salaire').val() == '') {
                $('#titre').css('border','');
                $('#profession').css('border','');
                $('#sexe').css('border','');
                $('#ville').css('border','');
                $('#salaire').css('border','2px solid red');
            }
            else if ($('#date_expiration').val() == '') {
                $('#titre').css('border','');
                $('#profession').css('border','');
                $('#sexe').css('border','');
                $('#ville').css('border','');
                $('#salaire').css('border','');
                $('#date_expiration').css('border','2px solid red');
            }
            else if ($('#mission_1').val() == '') {
                $('#titre').css('border','');
                $('#profession').css('border','');
                $('#sexe').css('border','');
                $('#ville').css('border','');
                $('#salaire').css('border','');
                $('#date_expiration').css('border','');
                $('#mission_1').css('border','2px solid red');
            }
            else if ($('#qualite_1').val() == '') {
                $('#titre').css('border','');
                $('#profession').css('border','');
                $('#sexe').css('border','');
                $('#ville').css('border','');
                $('#salaire').css('border','');
                $('#date_expiration').css('border','');
                $('#mission_1').css('border','');
                $('#qualite_1').css('border','2px solid red');
            }
            else{
                $("#ajouter_offre_form").submit();
            }
        })

        $("#ajouter_offre_form").submit(function(event){
            event.preventDefault(); 
            var post_url = $(this).attr("action"); 
            var request_method = $(this).attr("method"); 
            var form_data = $(this).serialize(); 
            
            $.ajax({
                url : post_url,
                type: request_method,
                data : form_data
            }).done(function(response){
                if (response != 0) {
                    $("#ajouter_offre_form")[0].reset();
                    $('.offre-container h2').text("Félécitation, votre offre a été bien ajouté.");
                    $('.offre-container h2').append("<a href='./offre.php?r="+response+"'>Cliquer ici pour voir l'offre</a>");
                    $('.offre-container h2').append("<i id='hide_message' class='fas fa-times'></i>");
                    $('.offre-container h2').css('display','initial');
                }
                else{
                    
                }
            });
        });

        $(document).on('click','#hide_message',function(){
            $('.offre-container h2').css('display','none');
        })

        $('#valider_demande').click(function(event){
            event.preventDefault();

            if ($('#titre_d').val() == '') {
                $('#titre_d').css('border','2px solid red');
            }
            else if ($('#ville_d').val() == '') {
                $('#titre_d').css('border','');
                $('#ville_d').css('border','2px solid red');
            }
            else if ($('#salaire_d').val() == '') {
                $('#titre_d').css('border','');
                $('#ville_d').css('border','');
                $('#salaire_d').css('border','2px solid red');
            }
            else if ($('#competence_1').val() == '') {
                $('#titre_d').css('border','');
                $('#ville_d').css('border','');
                $('#salaire_d').css('border','');
                $('#competence_1').css('border','2px solid red');
            }
            else if ($('#travaille_1').val() == '') {
                $('#titre_d').css('border','');
                $('#ville_d').css('border','');
                $('#salaire_d').css('border','');
                $('#competence_1').css('border','');
                $('#travaille_1').css('border','2px solid red');
            }
            else{
                $("#ajouter_demande_form").submit();
            }
        })

        $("#ajouter_demande_form").submit(function(event){
            event.preventDefault(); 
            var post_url = $(this).attr("action"); 
            var request_method = $(this).attr("method"); 
            var form_data = $(this).serialize(); 
            
            $.ajax({
                url : post_url,
                type: request_method,
                data : form_data
            }).done(function(response){
                if (response != 0) {
                    $("#ajouter_demande_form")[0].reset();
                    $('.demande-container h2').text("Félécitation, votre demande a été bien ajouté.");
                    $('.demande-container h2').append("<a href='./demande.php?r="+response+"'>Cliquer ici pour voir la demande</a>");
                    $('.demande-container h2').append("<i id='hide_message_d' class='fas fa-times'></i>");
                    $('.demande-container h2').css('display','initial');
                }
                else{
                    
                }
            });
        });

        $(document).on('click','#hide_message_d',function(){
            $('.demande-container h2').css('display','none');
        })

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