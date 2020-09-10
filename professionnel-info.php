<?php 
$user_total_rating_query = "SELECT * FROM user_rating WHERE id_user =".$user_info_row['id_user']; 
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
            <img id="user_couverture" src="<?php if($user_info_row['couverture_user']==''){echo'./images/logo.png';}else{echo './'.$user_info_row['couverture_user'];}?>" alt="logo">
        </div>
        <div class="user-picture">
            <img id="user_img" src="<?php if($user_info_row['img_user']==''){echo'./images/logo.png';}else{echo './'.$user_info_row['img_user'];}?>" alt="logo">
        </div>
    </div>
    <div class="user-rating">
        <div></div>
        <p><?php echo $user_info_row['nom_user']?></p>
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
        <input type="hidden" id="latitude_user" value="<?php echo $user_info_row['latitude_user']; ?>">
        <input type="hidden" id="longitude_user" value="<?php echo $user_info_row['longitude_user']; ?>">
    </div>
    <div class="user-informations" id="user_informations">
        <p>Profession : <span><?php echo $user_info_row['profession_user']; ?></span></p>
        <p>Téléphone : <span><?php echo $user_info_row['tlph_user']; ?></span></p>
        <p>Adresse : <span><?php echo $user_info_row['adresse_user']; ?></span></p>
        <p>Ville : <span><?php echo $user_info_row['ville']; ?></span></p>
    </div>
    <!-- <?php if (!isset($_SESSION['user'])) { ?>
    <i id="back_user_button" class="fas fa-arrow-left"></i>
    <?php } ?> -->
</div> 
<div class="user-profile-middle-content">
    <div class="user-profile-middle-container">
        <div class="user-profile-publications">
            <?php 
                $publication_query = "SELECT * FROM publications WHERE id_user = {$user_info_row['id_user']} AND masquer_pub = 0 ORDER BY id_pub DESC"; 
                $publication_result = mysqli_query($conn, $publication_query);
                $i=0;
                while($publication_row=mysqli_fetch_assoc($publication_result)){
                $i++; 
            ?>
            <!-- <input type="hidden" id="publication_tail_<?php echo $i ?>" value="<?php echo $i ?>"> -->
            <!-- <input type="hidden" id="publication_description_<?php echo $i ?>" value="<?php echo $publication_row['description_pub'] ?>"> -->
            <!-- <input type="hidden" id="publication_lieu_<?php echo $i ?>" value="<?php echo $publication_row['lieu_pub'] ?>"> -->
            <!-- <input type="hidden" id="etat_commentaire_<?php echo $i ?>" value="<?php echo $publication_row['etat_commentaire'] ?>"> -->
            <div class="user-publication" id="user_publication_<?php echo $i ?>">
                <div class="user-publication-top">
                    <div class="user-publication-top-left">
                        <img src="<?php echo $user_info_row['img_user'] ?>" alt="logo">
                        <p><?php echo $user_info_row['nom_user'] ?></p>
                    </div>
                    <div class="user-publication-top-right" id="display_pub_options_button_<?php echo $i ?>">
                        <i class="fas fa-ellipsis-v"></i>
                    </div>
                </div>
                <div class="publication-options" id="publication_options_<?php echo $i ?>">
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
                            if ($num_like_pub_row['id_user'] == $user_info_row['id_user']) { ?>
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
            $btq_query = "SELECT * FROM boutiques WHERE id_createur = {$user_info_row['id_user']}";
            $btq_result = mysqli_query($conn, $btq_query);
            while($btq_row = mysqli_fetch_assoc($btq_result)){
            $j++;
            if ($btq_row['etat_btq'] == 0) { $class_btq = 'unset-btq'; }
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
                        <a href="./boutique.php?id_btq=<?php echo $btq_row['id_btq'] ?>">Voir la boutiqe</a>
                        <button class="delete-boutique-btn" id="delete_boutique_btn_<?php echo $j ?>">Supprimer</button>
                        <p>Récuperer la boutque avant le <span>(<?php echo $btq_row['date_recuperation'] ?>)</span></p>
                        <button class="recover-boutique-btn" id="recover_boutique_btn_<?php echo $j ?>">Récupérer</button>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div> 