<?php 
    session_start();
    include_once './bdd/connexion.php';
?>
<div class="cancel-hided-publications">
    <div id="cancel_hided_publications_resp">
        <i class="fas fa-arrow-left"></i>
    </div>
    <p>Publications masquées</p>
</div>
<div id="cancel_hided_publications">
    <i class="fas fa-times"></i>
</div>
<div class="user-profile-publications">
    <?php 
    $publication_query = "SELECT * FROM publications WHERE id_user = {$_SESSION['user']} AND masquer_pub = 1 ORDER BY id_pub DESC"; 
    $publication_result = mysqli_query($conn, $publication_query);
    $i=0;
    while($publication_row=mysqli_fetch_assoc($publication_result)){
    $i++; 
    ?>
    <div class="user-publication" id="user_publication_<?php echo $i ?>">
        <div class="user-publication-manage-top" id="remove_hided_pub_button_<?php echo $i ?>">
            <i class="fas fa-eye"></i>
            <p>Démasquer la publication</p>
        </div>
        <input type="hidden" id="id_publication_hide_<?php echo $i ?>" value="<?php echo $publication_row['id_pub'] ?>">
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