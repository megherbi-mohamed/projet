<?php 
$user_total_rating_query = $conn->prepare("SELECT * FROM user_rating WHERE id_user =".$user_info_row['id_user']); 
$user_total_rating_query->execute();

$tr = 0;$tt = 0;$tc = 0;$td = 0;$trp = 0;$n=1;
while($user_total_rating_row=$user_total_rating_query->fetch(PDO::FETCH_ASSOC)){
    
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
        <p><?php echo $user_info_row['nom_user']?></p>
        <div>
            <i class="<?php echo $tr1 ?>"></i>
            <i class="<?php echo $tr2 ?>"></i>
            <i class="<?php echo $tr3 ?>"></i>
            <i class="<?php echo $tr4 ?>"></i>
            <i class="<?php echo $tr5 ?>"></i>
        </div>
        <?php 
        $abonne_query = $conn->prepare("SELECT id_a FROM abonnes WHERE id_user = '$id_user' AND id_abn_user = '{$user_info_row['id_user']}'");
        $abonne_query->execute();
        if($abonne_query->rowCount() > 0){
        ?>
        <div id="disfollow_button">
            <p>Disabonner</p>
            <i class="fas fa-user-slash"></i>
        </div>
        <?php }else{?>
        <div id="follow_button">
            <p>Abonner</p>
            <i class="fas fa-user-plus"></i>
        </div> 
        <?php }?>
        <div id="message_button">
            <p>Envoyer un message</p>
            <i class="fab fa-facebook-messenger"></i>
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
            $publication_query = $conn->prepare("SELECT * FROM publications WHERE id_user = {$user_info_row['id_user']} AND masquer_pub = 0 ORDER BY id_pub DESC LIMIT 4"); 
            $publication_query->execute();
            $i=0;
            while($publication_row = $publication_query->fetch(PDO::FETCH_ASSOC)){
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
                    $publication_media_query = $conn->prepare("SELECT * FROM publications_media WHERE id_pub = {$publication_row['id_pub']}"); 
                    $publication_media_query->execute();
                    if ($publication_media_query->rowCount() == 1) { ?>
                    <div class="user-publication-middle-one-view">
                        <?php
                        $publication_media_row=$publication_media_query->fetch(PDO::FETCH_ASSOC);
                        if ($publication_media_row['media_type'] == 'v') { ?>
                        <video controls><source src="./<?php echo $publication_media_row['media_url'] ?>"></video>
                        <?php }else if($publication_media_row['media_type'] == 'i'){ ?>
                        <img src="./<?php echo $publication_media_row['media_url'] ?>" alt="">
                        <?php } ?>
                        <input type="hidden" id="media_updt_<?php echo $i ?>_1" value="<?php echo $publication_media_row['media_url'] ?>">
                        <input type="hidden" id="media_type_<?php echo $i ?>_1" value="<?php echo $publication_media_row['media_type'] ?>">
                    </div>
                    <?php } else if ($publication_media_query->rowCount() == 2) { ?>
                    <div class="user-publication-middle-two-view">
                    <?php $j=0; while($publication_media_row=$publication_media_query->fetch(PDO::FETCH_ASSOC)){ $j++; ?>
                        <div>
                            <input type="hidden" id="media_updt_<?php echo $i ?>_<?php echo $j ?>" value="<?php echo $publication_media_row['media_url'] ?>">
                            <img src="./<?php echo $publication_media_row['media_url'] ?>" alt="">
                        </div>
                    <?php } ?>
                    </div>
                    <?php } else if ($publication_media_query->rowCount() == 3) { ?>
                    <div class="user-publication-middle-three-view">
                    <?php $j=0; while($publication_media_row=$publication_media_query->fetch(PDO::FETCH_ASSOC)){ $j++; ?>
                        <div>
                            <input type="hidden" id="media_updt_<?php echo $i ?>_<?php echo $j ?>" value="<?php echo $publication_media_row['media_url'] ?>">
                            <img src="./<?php echo $publication_media_row['media_url'] ?>" alt="">
                        </div>
                    <?php } ?>
                    </div>
                    <?php } else if ($publication_media_query->rowCount() == 4) { ?>
                    <div class="user-publication-middle-four-view">
                    <?php $j=0; while($publication_media_row=$publication_media_query->fetch(PDO::FETCH_ASSOC)){ $j++; ?>
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
                    $publication_comment_query = $conn->prepare("SELECT * FROM commentaire_publication WHERE id_pub = {$publication_row['id_pub']}"); 
                    $publication_comment_query->execute();
                    $publication_comment_count = $publication_comment_query->rowCount();
                    ?>
                    <div class="user-publication-bottom-top" id="user_publication_bottom_top_<?php echo $i ?>">
                        <div>
                            <?php
                            $num_like_pub_query = $conn->prepare("SELECT id_j,id_user FROM jaime_publication WHERE id_pub = {$publication_row['id_pub']}"); 
                            $num_like_pub_query->execute();
                            $num_like_pub_row = $num_like_pub_query->fetch(PDO::FETCH_ASSOC);
                            $num_like_pub_count = $num_like_pub_query->rowCount();
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
                    while($publication_comment_row = $publication_comment_query->fetch(PDO::FETCH_ASSOC)){
                    $publication_comment_user_query = $conn->prepare("SELECT img_user,nom_user FROM utilisateurs WHERE id_user = {$publication_comment_row['id_user']}");
                    $publication_comment_user_query->execute();
                    $publication_comment_user_row = $publication_comment_user_query->fetch(PDO::FETCH_ASSOC);
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
            $btq_query = $conn->prepare("SELECT * FROM boutiques WHERE id_createur = {$user_info_row['id_user']} AND etat_btq = 1");
            $btq_query->execute();
            while($btq_row = $btq_query->fetch(PDO::FETCH_ASSOC)){
            ?>
            <a href="./boutique.php?btq=<?php echo $btq_row['id_btq'] ?>">
            <div class="user-boutique">
                <?php if ($btq_row['logo_btq'] != '') { ?>
                    <img src="./<?php echo $btq_row['logo_btq'] ?>" alt="">
                <?php }else if($btq_row['logo_btq'] == ''){ ?>
                    <img src="./boutique-logo/logo.png" alt="">
                <?php } ?>
                <div class="user-boutique-options">
                    <h4><?php echo $btq_row['nom_btq'] ?></h4>
                    <div class="user-boutique-option">
                        <div class="user-boutique-messages">
                            <?php 
                            $num_btq_abn_query = $conn->prepare("SELECT id_a FROM abonnes WHERE id_abn_user = {$btq_row['id_btq']}");    
                            $num_btq_abn_query->execute();
                            $num_btq_abn_count = $num_btq_abn_query->rowCount();
                            ?>
                            <p>Abonnés (<?php echo $num_btq_abn_count; ?>)</p>
                        </div>
                        <div></div>
                    </div>
                </div>
            </div>
            </a>
            <?php } ?>
        </div>
    </div>
</div> 
<div class="abonne-user" id="abonne_user">
    <div class="abonne-user-container" id="abonne_user_container">
        <div class="abonne-user-top">
            <h4>Abonner a <?php echo $user_info_row['nom_user'] ?></h4>
            <div class="cancel-abonne-user" id="cancel_abonne_user">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="abonne-user-middle">
            <div id="ntf_user_btn">
                <i class="fas fa-check etat"></i>
                <input type="hidden" id="notifications_user" value="1">
            </div>
            <p>Recever des nouveautées de <?php echo $user_info_row['nom_user'] ?> ?</p>
        </div>
        <div class="abonne-user-bottom">
            <div></div>
            <div></div>
            <button id="cancel_abonne_user_button">Annuler</button>
            <button id="abonne_user_button">Abonner</button>
        </div>
    </div>
    <div id="loader_abn_user" class="center"></div>
</div>
<div class="abonne-user" id="disabonne_user">
    <div class="abonne-user-container" id="disabonne_user_container">
        <div class="abonne-user-top">
            <h4>Disabonner a <?php echo $user_info_row['nom_user'] ?> ?</h4>
            <div class="cancel-abonne-user" id="cancel_disabonne_user">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="abonne-user-middle">
            <p>Voulez vous disabonner a <?php echo $user_info_row['nom_user'] ?> ?</p>
        </div>
        <div class="abonne-user-bottom">
            <div></div>
            <div></div>
            <button id="cancel_disabonne_user_button">Annuler</button>
            <button id="disabonne_user_button">Disbonner</button>
        </div>
    </div>
    <div id="loader_disabn_user" class="center"></div>
</div>
<div class="message-user" id="message_user">
    <div class="message-user-container" id="message_user_container">
        <div class="message-user-top">
            <h4>Envoyer un message a <?php echo $user_info_row['nom_user'] ?></h4>
            <div class="cancel-message-user" id="cancel_message_user">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="message-user-middle">
            <p>Message</p>
            <textarea id="message_text"></textarea>
        </div>
        <div class="message-user-bottom">
            <div></div>
            <div></div>
            <button id="cancel_message_user_button">Annuler</button>
            <button id="message_user_button">Envoyer</button>
        </div>
    </div>
    <div id="loader_msg_user" class="center"></div>
</div>