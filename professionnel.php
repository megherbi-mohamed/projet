<?php 
    $user_total_rating_query = "SELECT * FROM user_rating WHERE id_user =  $id_user"; 
    $user_total_rating_result = mysqli_query($conn, $user_total_rating_query);

    $tr = 0;$tt = 0;$tc = 0;$td = 0;$trp = 0;$n=1;
    while($user_total_rating_row=mysqli_fetch_assoc($user_total_rating_result)){
        
        $tnr = $user_total_rating_row['rapidite'];
        $tnt = $user_total_rating_row['travaille'];
        $tnd = $user_total_rating_row['discipline'];
        $tnc = $user_total_rating_row['cout'];
        $tnrp = $user_total_rating_row['reputation'];

        if ($tnr!=0 && $tnt!=0 && $tnd!=0 && $tnc!=0 && $tnrp!=0) {
            $tr=$tr+$user_total_rating_row['rapidite'];
            $tt=$tt+$user_total_rating_row['travaille'];
            $tc=$tc+$user_total_rating_row['cout'];
            $td=$td+$user_total_rating_row['discipline'];
            $trp=$trp+$user_total_rating_row['reputation'];
            $n++;
        }
    }
    
    $total_r = ($tr/$n+$tt/$n+$td/$n+$tc/$n+$trp/$n)/5;
    $tr1 = 'far fa-star';$tr2 = 'far fa-star';$tr3 = 'far fa-star';$tr4 = 'far fa-star';$tr5 = 'far fa-star';
    if ($total_r >= 20) {$tr1 = 'fas fa-star';}
    if ($total_r >= 40) {$tr2 = 'fas fa-star';}
    if ($total_r >= 60) {$tr3 = 'fas fa-star';}
    if ($total_r >= 80) {$tr4 = 'fas fa-star';}
    if ($total_r == 100) {$tr5 = 'fas fa-star';}
?>
<div class="user-profile-left-content hide-scroll-bar">
    <div id="user-profile-left-content-picture">
        <div class="user-profile-left-content-picture-couverture">
            <img id="user_couverture" src="<?php if($row['couverture_user']==''){echo'./images/logo.png';}else{echo './'.$row['couverture_user'];}?>" alt="logo">
            <div class="update-user-couverture" id="update_user_couverture">
                <i class="fas fa-camera"></i>
            </div>
        </div>
        <div class="user-picture">
            <img id="user_img" src="<?php if($row['img_user']==''){echo'./images/logo.png';}else{echo './'.$row['img_user'];}?>" alt="logo">
            <div class="update-user-image" id="update_user_image">
                <i class="fas fa-camera"></i>
            </div>
        </div>
    </div>
    <div class="user-rating">
        <div class="user-disponibility">
            <form action="./etat-user.php" method="post" id="check_form">
                <label class="switch">
                <input id="input_user_checkbox" type="checkbox" <?php echo $row['etat_user']; ?>>
                    <span class="slider round"></span>
                </label>
                <input type="submit" id="check_btn">
            </form>
        </div>
        <p><?php echo $row['nom_user']?></p>
        <div>
            <i class="<?php echo $tr1 ?>"></i>
            <i class="<?php echo $tr2 ?>"></i>
            <i class="<?php echo $tr3 ?>"></i>
            <i class="<?php echo $tr4 ?>"></i>
            <i class="<?php echo $tr5 ?>"></i>
        </div>
    </div>
    <div class="user-map">
        <div id="user_map"></div>
        <input type="hidden" id="latitude_user" value="<?php echo $row['latitude_user']; ?>">
        <input type="hidden" id="longitude_user" value="<?php echo $row['longitude_user']; ?>">
        <!-- <button><i class="fas fa-map-marker-alt"></i>Modifier la position</button> -->
    </div>
    <div class="user-informations" id="user_informations">
        <p>Profession : <span><?php echo $row['profession_user']; ?></span></p>
        <p>Téléphone : <span><?php echo $row['tlph_user']; ?></span></p>
        <p>Adresse : <span><?php echo $row['adresse_user']; ?></span></p>
        <p>Ville : <span><?php echo $row['ville']; ?></span></p>
    </div>
    <div style="display:none" class="modify-user-informations">
        <form action="./update-profile.php" method="post" id="update_profile_form">
            <div>
                <label>Nom et prénom</label>
                <input type="text" name="nom_user" value="<?php echo $row['nom_user'] ?>" autocomplete="off">
            </div>
            <div style="margin-top:10px">
                <label>N° téléphone</label>
                <input type="text" name="tlph_user" value="<?php echo $row['tlph_user'] ?>" autocomplete="off">
            </div>
            <div>
                <label>Age</label>
                <input type="text" name="age_user" value="<?php echo $row['age_user'] ?>" autocomplete="off">
            </div>
            <div>
                <label>Profession</label>
                <input type="text" name="profession_user" value="<?php echo $row['profession_user'] ?>" autocomplete="off">
            </div>
            <div>
                <label>Adresse</label>
                <input type="text" name="adresse_user" value="<?php echo $row['adresse_user'] ?>" autocomplete="off">
            </div>
            <div>
                <label>Ville</label>
                <input type="text" name="ville_user" value="<?php echo $row['ville'] ?>" autocomplete="off">
            </div>
            <div style="margin-top:20px">
                <input type="submit" id="modify_user_inf_btn" value="Valider">
            </div>
        </form>
    </div>
</div>
<div class="user-profile-middle-content">
    <div class="user-profile-middle-container">
        <div class="user-profile-middle-content-pub">
            <h4>Recommendés</h4>
            <div class="user-profile-middle-content-pub-slide-button">
                <div id="slide_left">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <div id="slide_right">
                    <i class="fas fa-arrow-right"></i>
                </div>
            <?php 
                $get_profile_query = "SELECT * FROM utilisateurs WHERE type_user =  'professionnel'"; 
                $get_profile_result = mysqli_query($conn, $get_profile_query);
                while($get_profile_row=mysqli_fetch_assoc($get_profile_result)){
            ?>
            <div class="user-profile-middle-content-pub-profile">
                <img src="<?php if($get_profile_row['couverture_user']==''){echo'./images/logo.png';}else{echo './'.$get_profile_row['couverture_user'];}?>" alt="logo">
                <img src="<?php if($get_profile_row['img_user']==''){echo'./images/logo.png';}else{echo './'.$get_profile_row['img_user'];}?>" alt="logo">
                <div>
                    <p><?php echo $get_profile_row['profession_user']?></p>
                </div>
            </div>
            <?php } ?>
            </div>
        </div>
        <div class="manage-user-publications">
            <div id="show_hided_publications">
                <i class="fas fa-eye-slash"></i>
                <p>Publications masquées</p>
            </div>
            <div id="show_saved_publications">
                <i class="fas fa-bookmark"></i>
                <p>Publications enregistrées</p>
            </div>
        </div>
        <div class="user-profile-publications">
            <?php 
                $publication_query = "SELECT * FROM publications WHERE id_user = {$_SESSION['user']} AND masquer_pub = 0 ORDER BY id_pub DESC LIMIT 1"; 
                $publication_result = mysqli_query($conn, $publication_query);
                $i=0;
                while($publication_row=mysqli_fetch_assoc($publication_result)){
                $i++; 
            ?>
            <input type="hidden" id="publication_tail_<?php echo $i ?>" value="<?php echo $i ?>">
            <input type="hidden" id="publication_description_<?php echo $i ?>" value="<?php echo $publication_row['description_pub'] ?>">
            <input type="hidden" id="publication_lieu_<?php echo $i ?>" value="<?php echo $publication_row['lieu_pub'] ?>">
            <input type="hidden" id="etat_commentaire_<?php echo $i ?>" value="<?php echo $publication_row['etat_commentaire'] ?>">
            <div class="user-publication" id="user_publication_<?php echo $i ?>">
                <div class="user-publication-top">
                    <div class="user-publication-top-left">
                        <img src="<?php echo $row['img_user'] ?>" alt="logo">
                        <p><?php echo $row['nom_user'] ?></p>
                    </div>
                    <div class="user-publication-top-right" id="display_pub_options_button_<?php echo $i ?>">
                        <i class="fas fa-ellipsis-v"></i>
                    </div>
                </div>
                <div class="publication-options" id="publication_options_<?php echo $i ?>">
                    <?php if ($publication_row['etat_commentaire'] == 0) { ?>
                    <div class="publication-option" id="desactive_publication_comment_<?php echo $i ?>">
                        <i class="fas fa-comment-slash"></i>
                        <div>
                            <p>Désactiver les commentaires</p>
                            <p>Masquer temporairement les commentaires</p>
                        </div>
                    </div>
                    <?php }else{ ?>
                    <div class="publication-option" id="active_publication_comment_<?php echo $i ?>">
                        <i class="fas fa-comment-slash"></i>
                        <div>
                            <p>Activer les commentaires</p>
                            <p>Activer les commentaires masquées</p>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="publication-option" id="update_publication_<?php echo $i ?>">
                        <i class="fas fa-pen"></i>
                        <div>
                            <p>Modifer la publication</p>
                            <p>Modifer les photos - vidéo de publication</p>
                        </div>
                    </div>
                    <div class="publication-option" id="hide_publication_<?php echo $i ?>">
                        <i class="fas fa-eye-slash"></i>    
                        <div>
                            <p>Masquer la publication</p>
                            <p>La publication sera masquée temporairement</p>
                        </div>
                    </div>
                    <div class="publication-option" id="delete_publication_<?php echo $i ?>">
                        <i class="fas fa-trash"></i>
                        <div>
                            <p>Supprimer la publication</p>
                            <p>La publication sera supprimée définitivement</p>
                        </div>
                    </div>
                    <div class="publication-option" id="save_publication_<?php echo $i ?>">
                        <i class="fas fa-bookmark"></i>
                        <div>
                            <p>Enregistrer la publication</p>
                            <p>La publication sera enregistrée</p>
                        </div>
                    </div>
                </div>
                <div class="user-publication-middle">
                    <div class="user-publication-middle-description">
                        <p><?php echo $publication_row['description_pub'] ?></p>
                    </div>
                    <?php 
                    $publication_media_query = "SELECT * FROM publications_media WHERE id_pub = {$publication_row['id_pub']}"; 
                    $publication_media_result = mysqli_query($conn, $publication_media_query);
                    if (mysqli_num_rows($publication_media_result) == 1) { ?>
                    <div class="user-publication-middle-one-view">
                        <?php
                        $publication_media_row=mysqli_fetch_assoc($publication_media_result);
                        if ($publication_media_row['media_type'] == 'v') { ?>
                        <video controls><source src="./<?php echo $publication_media_row['media_url'] ?>"></video>
                        <?php }else if($publication_media_row['media_type'] == 'i'){ ?>
                        <img src="./<?php echo $publication_media_row['media_url'] ?>" alt="">
                        <?php } ?>
                        <input type="hidden" id="media_updt_<?php echo $i ?>_1" value="<?php echo $publication_media_row['media_url'] ?>">
                        <input type="hidden" id="media_type_<?php echo $i ?>_1" value="<?php echo $publication_media_row['media_type'] ?>">
                    </div>
                    <?php } else if (mysqli_num_rows($publication_media_result) == 2) { ?>
                    <div class="user-publication-middle-two-view">
                    <?php $j=0; while($publication_media_row=mysqli_fetch_assoc($publication_media_result)){ $j++; ?>
                        <div>
                            <input type="hidden" id="media_updt_<?php echo $i ?>_<?php echo $j ?>" value="<?php echo $publication_media_row['media_url'] ?>">
                            <img src="./<?php echo $publication_media_row['media_url'] ?>" alt="">
                        </div>
                    <?php } ?>
                    </div>
                    <?php } else if (mysqli_num_rows($publication_media_result) == 3) { ?>
                    <div class="user-publication-middle-three-view">
                    <?php $j=0; while($publication_media_row=mysqli_fetch_assoc($publication_media_result)){ $j++; ?>
                        <div>
                            <input type="hidden" id="media_updt_<?php echo $i ?>_<?php echo $j ?>" value="<?php echo $publication_media_row['media_url'] ?>">
                            <img src="./<?php echo $publication_media_row['media_url'] ?>" alt="">
                        </div>
                    <?php } ?>
                    </div>
                    <?php } else if (mysqli_num_rows($publication_media_result) == 4) { ?>
                    <div class="user-publication-middle-four-view">
                    <?php $j=0; while($publication_media_row=mysqli_fetch_assoc($publication_media_result)){ $j++; ?>
                        <div>
                            <input type="hidden" id="media_updt_<?php echo $i ?>_<?php echo $j ?>" value="<?php echo $publication_media_row['media_url'] ?>">
                            <img src="./<?php echo $publication_media_row['media_url'] ?>" alt="">
                        </div>
                    <?php } ?>
                    </div>
                    <?php } ?>
                </div>
                <div class="user-publication-bottom">
                    <?php
                    $publication_comment_query = "SELECT * FROM commentaire_publication WHERE id_pub = {$publication_row['id_pub']}"; 
                    $publication_comment_result = mysqli_query($conn, $publication_comment_query);
                    $publication_comment_count = mysqli_num_rows($publication_comment_result);
                    ?>
                    <div class="user-publication-bottom-top" id="user_publication_bottom_top_<?php echo $i ?>">
                        <div>
                            <?php
                            $num_like_pub_query = "SELECT id_j,id_user FROM jaime_publication WHERE id_pub = {$publication_row['id_pub']}"; 
                            $num_like_pub_result = mysqli_query($conn, $num_like_pub_query);
                            $num_like_pub_row = mysqli_fetch_assoc($num_like_pub_result);
                            $num_like_pub_count = mysqli_num_rows($num_like_pub_result);
                            if ($num_like_pub_count > 0) {
                            if ($num_like_pub_row['id_user'] == $row['id_user']) { ?>
                            <i id="dislike_pub_button_<?php echo $i ?>" class="fas fa-heart"></i>
                            <?php }else{ ?>
                            <i id="like_pub_button_<?php echo $i ?>" class="far fa-heart"></i>
                            <?php }}else { ?>
                            <i id="like_pub_button_<?php echo $i ?>" class="far fa-heart"></i>
                            <?php } ?>
                            <input type="hidden" id="id_pub_<?php echo $i ?>" value="<?php echo $publication_row['id_pub'] ?>">
                            <span><?php echo $num_like_pub_count ?></span>
                        </div>
                        <input type="hidden" id="num_pub_comment_<?php echo $i ?>" value="<?php echo $publication_comment_count ?>">
                        <?php if ($publication_row['etat_commentaire'] == 0) { ?>
                        <button id="diplay_pub_comment_button_<?php echo $i ?>"><?php echo $publication_comment_count ?> Commentaires</button>
                        <?php }else{ ?>
                        <div class="active-comment-button"></div>
                        <?php } ?>
                        <p><?php echo $publication_row['temp_pub'] ?></p>
                    </div>
                    <?php if ($publication_row['etat_commentaire'] == 0) { ?>
                    <div class="user-publication-bottom-bottom" id="user_publication_bottom_bottom_<?php echo $i ?>">
                    <img src="./<?php echo $row['img_user'] ?>" alt="">
                        <input type="text" id="commentaire_text_<?php echo $i ?>" placeholder = "Tapez une commentaire ...">
                        <input type="hidden" id="commentaire_img_user_<?php echo $i ?>" value="<?php echo $row['img_user'] ?>">
                        <input type="hidden" id="commentaire_nom_user_<?php echo $i ?>" value="<?php echo $row['nom_user'] ?>">
                    </div>
                    <?php } ?>
                    <div class="user-publication-bottom-comment" id="user_publication_bottom_comment_<?php echo $i ?>">
                    <?php 
                    while($publication_comment_row = mysqli_fetch_assoc($publication_comment_result)){
                    $publication_comment_user_query = "SELECT img_user,nom_user FROM utilisateurs WHERE id_user = {$publication_comment_row['id_user']}"; 
                    $publication_comment_user_result = mysqli_query($conn, $publication_comment_user_query);
                    $publication_comment_user_row = mysqli_fetch_assoc($publication_comment_user_result);
                    ?>
                    <img src="./<?php echo $publication_comment_user_row['img_user'] ?>" alt="">
                    <div>
                        <h4><?php echo $publication_comment_user_row['nom_user'] ?></h4>
                        <p><?php echo $publication_comment_row['commentaire_text'] ?></p>
                    </div>
                    <?php } ?>
                    </div>
                    <div class="user-publication-bottom-preview" id="user_publication_bottom_preview_<?php echo $i ?>"></div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<div class="user-profile-right-content">
    <div class="user-profile-right-content-pub">
        <h4>Sponsorisés</h4>
        <div>
            <img src="./images/logo.png" alt="">
            <p>Lorem ipsum dolor sit amet.</p>
        </div>
        <div>
            <img src="./images/logo.png" alt="">
            <p>Lorem ipsum dolor sit amet.</p>
        </div>
    </div>
    <hr>
    <div class="user-profile-right-content-boutique">
        <h4>Boutiques</h4>
        <div class="user-boutiques">
            <?php 
            $j = 0;
            $class_btq = '';
            $btq_query = "SELECT * FROM boutiques WHERE id_createur = '$id_user'";
            $btq_result = mysqli_query($conn, $btq_query);
            while($btq_row = mysqli_fetch_assoc($btq_result)){
            $j++;
            if ($btq_row['etat_btq'] == 1) { $class_btq = 'unset-btq'; }
            else{ $class_btq = ''; }
            ?>
            <div class="user-boutique <?php echo $class_btq?>" id="user_boutique_<?php echo $j ?>">
                <?php if ($btq_row['logo_btq'] != '') { ?>
                    <img src="./<?php echo $btq_row['logo_btq'] ?>" alt="">
                <?php }else if($btq_row['logo_btq'] == ''){ ?>
                    <img src="./boutique-logo/logo.png" alt="">
                <?php } ?>
                <div class="user-boutique-options">
                    <h4><?php echo $btq_row['nom_btq'] ?></h4>
                    <div>
                        <input type="hidden" id="nom_btq_<?php echo $j ?>" value="<?php echo $btq_row['nom_btq'] ?>">
                        <input type="hidden" id="id_btq_<?php echo $j ?>" value="<?php echo $btq_row['id_btq'] ?>">
                        <a href="./gerer-boutique.php?btq=<?php echo $btq_row['id_btq'] ?>" onclick="pushState(<?php echo $btq_row['id_btq']?>)">Voir la boutiqe</a>
                        <!-- <button class="delete-boutique-btn" id="delete_boutique_btn_<?php echo $j ?>">Supprimer</button> -->
                        <p>Récuperer la boutque avant le <span>(<?php echo $btq_row['date_recuperation'] ?>)</span></p>
                        <button class="recover-boutique-btn" id="recover_boutique_btn_<?php echo $j ?>">Récupérer</button>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div> 

<div class="user-image-update-container">
    <div class="cancel-user-image-update" id="cancel_user_image_update">
        <i class="fas fa-times"></i>
    </div>
	<div class="panel panel-default">
	    <div class="panel-heading">Modification d'image</div>
        <div class="row">
            <div class="image-upload-befor">
                <div id="upload-demo"></div>
            </div>
            <div class="image-upload-option">
                <button id="find_image_btn">Choissir une image</button>
                <input type="file" id="upload" accept='image/*'>
                <button class="upload-result">Valider la modification</button>
            </div>
        </div>
	</div>
</div>

<div class="user-couverture-update-container">
    <div class="cancel-user-couverture-update" id="cancel_user_couverture_update">
        <i class="fas fa-times"></i>
    </div>
	<div class="panel panel-default">
	    <div class="panel-heading">Modification d'image</div>
        <div class="row">
            <div class="image-upload-befor">
                <div id="upload-demo-couverture"></div>
            </div>
            <div class="image-upload-option">
                <button id="find_couverture_btn">Choissir une image</button>
                <input type="file" id="upload_couverture" accept='image/*'>
                <button class="upload-result-couverture">Valider la modification</button>
            </div>
        </div>
	</div>
</div>