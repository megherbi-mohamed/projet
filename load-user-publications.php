<?php
session_start();
include_once './bdd/connexion.php'; 
$cnx_user_query = $conn->prepare("SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['user']);
$cnx_user_query->execute();
$row = $cnx_user_query->fetch(PDO::FETCH_ASSOC);

$ofst = htmlspecialchars($_POST['offset']);
$offset = ((int)$ofst)*1;
$publication_query = $conn->prepare("SELECT * FROM publications WHERE id_user = '{$_SESSION["user"]}' AND masquer_pub = 0 ORDER BY id_pub DESC LIMIT 1 OFFSET $offset"); 
$publication_query->execute();
$i=$offset;
while($publication_row = $publication_query->fetch(PDO::FETCH_ASSOC)){
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
        $publication_media_query = $conn->prepare("SELECT * FROM publications_media WHERE id_pub = '{$publication_row["id_pub"]}'"); 
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
        $publication_comment_query = $conn->prepare("SELECT * FROM commentaire_publication WHERE id_pub = '{$publication_row["id_pub"]}'"); 
        $publication_comment_query->execute();
        $publication_comment_count = $publication_comment_query->rowCount();
        ?>
        <div class="user-publication-bottom-top" id="user_publication_bottom_top_<?php echo $i ?>">
            <div>
                <?php
                $num_like_pub_query = $conn->prepare("SELECT id_j,id_user FROM jaime_publication WHERE id_pub = '{$publication_row["id_pub"]}'"); 
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
        $publication_comment_user_query = $conn->prepare("SELECT img_user,nom_user FROM utilisateurs WHERE id_user = '{$publication_comment_row["id_user"]}'");
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