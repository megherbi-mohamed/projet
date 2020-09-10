<?php
session_start();
include_once './bdd/connexion.php';
$id_pub = htmlspecialchars($_POST['id_pub']);
$id = htmlspecialchars($_POST['id']);
$desactive_comment_query = "UPDATE publications SET etat_commentaire = 0 WHERE id_pub = '$id_pub'";
if (mysqli_query($conn, $desactive_comment_query)) {
$publication_query = "SELECT * FROM publications WHERE id_pub = '$id_pub'"; 
$publication_result = mysqli_query($conn, $publication_query);
$publication_row=mysqli_fetch_assoc($publication_result);

$cnx_user_query = "SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['user'];
$result = mysqli_query($conn, $cnx_user_query);
$row = mysqli_fetch_assoc($result);
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
        <div class="publication-option" id="desactive_publication_comment_<?php echo $id ?>">
            <i class="fas fa-comment-slash"></i>
            <div>
                <p>Désactiver les commentaires</p>
                <p>Masquer temporairement les commentaires</p>
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
        </div>
        <?php } else if (mysqli_num_rows($publication_media_result) == 2) { ?>
        <div class="user-publication-middle-two-view">
        <?php while($publication_media_row=mysqli_fetch_assoc($publication_media_result)){ ?>
            <div>
                <img src="./<?php echo $publication_media_row['media_url'] ?>" alt="">
            </div>
        <?php } ?>
        </div>
        <?php } else if (mysqli_num_rows($publication_media_result) == 3) { ?>
        <div class="user-publication-middle-three-view">
        <?php while($publication_media_row=mysqli_fetch_assoc($publication_media_result)){ ?>
            <div>
                <img src="./<?php echo $publication_media_row['media_url'] ?>" alt="">
            </div>
        <?php } ?>
        </div>
        <?php } else if (mysqli_num_rows($publication_media_result) == 4) { ?>
        <div class="user-publication-middle-four-view">
        <?php while($publication_media_row=mysqli_fetch_assoc($publication_media_result)){ ?>
            <div>
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
        <div class="user-publication-bottom-top" id="user_publication_bottom_top_<?php echo $id ?>">
            <div>
                <?php
                $num_like_pub_query = "SELECT id_j,id_user FROM jaime_publication WHERE id_pub = {$publication_row['id_pub']}"; 
                $num_like_pub_result = mysqli_query($conn, $num_like_pub_query);
                $num_like_pub_row = mysqli_fetch_assoc($num_like_pub_result);
                $num_like_pub_count = mysqli_num_rows($num_like_pub_result);
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
            <input type="hidden" id="num_pub_comment_<?php echo $id ?>" value="<?php echo $publication_comment_count ?>">
            <button id="diplay_pub_comment_button_<?php echo $id ?>"><?php echo $publication_comment_count ?> Commentaires</button>
            <p><?php echo $publication_row['temp_pub'] ?></p>
        </div>
        <div class="user-publication-bottom-bottom" id="user_publication_bottom_bottom_<?php echo $id ?>">
        <img src="./<?php echo $row['img_user'] ?>" alt="">
            <input type="text" id="commentaire_text_<?php echo $id ?>" placeholder = "Tapez une commentaire ...">
            <input type="hidden" id="commentaire_img_user_<?php echo $id ?>" value="<?php echo $row['img_user'] ?>">
            <input type="hidden" id="commentaire_nom_user_<?php echo $id ?>" value="<?php echo $row['nom_user'] ?>">
        </div>
        <div class="user-publication-bottom-comment" id="user_publication_bottom_comment_<?php echo $id ?>">
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
        <div class="user-publication-bottom-preview" id="user_publication_bottom_preview_<?php echo $id ?>"></div>
    </div>
</div>
<?php 
} else{
    echo 0;
}
?>