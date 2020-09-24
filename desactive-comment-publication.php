<?php
session_start();
include_once './bdd/connexion.php';
$id_pub = htmlspecialchars($_POST['id_pub']);
$id = htmlspecialchars($_POST['id']);
$desactive_comment_query = $conn->prepare("UPDATE publications SET etat_commentaire = 1 WHERE id_pub = '$id_pub'");
if ($desactive_comment_query->execute()) {
$publication_query = $conn->prepare("SELECT * FROM publications WHERE id_pub = '$id_pub'"); 
$publication_query->execute();
$publication_row = $publication_query->fetch(PDO::FETCH_ASSOC);

$cnx_user_query = $conn->prepare("SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['user']);
$cnx_user_query->execute();
$row = $cnx_user_query->fetch(PDO::FETCH_ASSOC);
?>
<div class="user-publication" id="user_publication_<?php echo $id ?>">
    <div class="user-publication-top">
        <div class="user-publication-top-left">
            <img src="<?php echo $row['img_user'] ?>" alt="logo">
            <p><?php echo $row['nom_user'] ?></p>
        </div>
        <div class="user-publication-top-right" id="display_pub_options_button_<?php echo $id ?>">
            <i class="fas fa-ellipsis-v"></i>
        </div>
    </div>
    <div class="publication-options" id="publication_options_<?php echo $id ?>">
        <div class="publication-option" id="active_publication_comment_<?php echo $id ?>">
            <i class="fas fa-comment-slash"></i>
            <div>
                <p>Activer les commentaires</p>
                <p>Activer les commentaires masquées</p>
            </div>
        </div>
        <div class="publication-option" id="update_publication_<?php echo $id ?>">
            <i class="fas fa-pen"></i>
            <div>
                <p>Modifer la publication</p>
                <p>Modifer les photos - vidéo de publication</p>
            </div>
        </div>
        <div class="publication-option" id="hide_publication_<?php echo $id ?>">
            <i class="fas fa-eye-slash"></i>    
            <div>
                <p>Masquer la publication</p>
                <p>La publication sera masquée temporairement</p>
            </div>
        </div>
        <div class="publication-option" id="delete_publication_<?php echo $id ?>">
            <i class="fas fa-trash"></i>
            <div>
                <p>Supprimer la publication</p>
                <p>La publication sera supprimée définitivement</p>
            </div>
        </div>
        <div class="publication-option" id="save_publication_<?php echo $id ?>">
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
            <input type="hidden" id="media_updt_<?php echo $id ?>_1" value="<?php echo $publication_media_row['media_url'] ?>">
            <input type="hidden" id="media_type_<?php echo $id ?>_1" value="<?php echo $publication_media_row['media_type'] ?>">
        </div>
        <?php } else if ($publication_media_query->rowCount() == 2) { ?>
        <div class="user-publication-middle-two-view">
        <?php $j=0; while($publication_media_row=$publication_media_query->fetch(PDO::FETCH_ASSOC)){ $j++; ?>
            <div>
                <input type="hidden" id="media_updt_<?php echo $id ?>_<?php echo $j ?>" value="<?php echo $publication_media_row['media_url'] ?>">
                <img src="./<?php echo $publication_media_row['media_url'] ?>" alt="">
            </div>
        <?php } ?>
        </div>
        <?php } else if ($publication_media_query->rowCount() == 3) { ?>
        <div class="user-publication-middle-three-view">
        <?php $j=0; while($publication_media_row=$publication_media_query->fetch(PDO::FETCH_ASSOC)){ $j++; ?>
            <div>
                <input type="hidden" id="media_updt_<?php echo $id ?>_<?php echo $j ?>" value="<?php echo $publication_media_row['media_url'] ?>">
                <img src="./<?php echo $publication_media_row['media_url'] ?>" alt="">
            </div>
        <?php } ?>
        </div>
        <?php } else if ($publication_media_query->rowCount() == 4) { ?>
        <div class="user-publication-middle-four-view">
        <?php $j=0; while($publication_media_row=$publication_media_query->fetch(PDO::FETCH_ASSOC)){ $j++; ?>
            <div>
                <input type="hidden" id="media_updt_<?php echo $id ?>_<?php echo $j ?>" value="<?php echo $publication_media_row['media_url'] ?>">
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
        <div class="user-publication-bottom-top" id="user_publication_bottom_top_<?php echo $id ?>">
            <div>
                <?php
                $num_like_pub_query = $conn->prepare("SELECT id_j,id_user FROM jaime_publication WHERE id_pub = '{$publication_row["id_pub"]}'"); 
                $num_like_pub_query->execute();
                $num_like_pub_row = $num_like_pub_query->fetch(PDO::FETCH_ASSOC);
                $num_like_pub_count = $num_like_pub_query->rowCount();
                if ($num_like_pub_count > 0) {
                if ($num_like_pub_row['id_user'] == $row['id_user']) { ?>
                <i id="dislike_pub_button_<?php echo $id ?>" class="fas fa-heart"></i>
                <?php }else{ ?>
                <i id="like_pub_button_<?php echo $id ?>" class="far fa-heart"></i>
                <?php }}else { ?>
                <i id="like_pub_button_<?php echo $id ?>" class="far fa-heart"></i>
                <?php } ?>
                <input type="hidden" id="id_pub_<?php echo $id ?>" value="<?php echo $publication_row['id_pub'] ?>">
                <span><?php echo $num_like_pub_count ?></span>
            </div>
            <div></div>
            <p><?php echo $publication_row['temp_pub'] ?></p>
        </div>
    </div>
</div>
<?php
}
else{
    echo 0;
}
?>