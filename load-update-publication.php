<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_user_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
if ($get_session_user_query->execute()) {
    $get_session_user_row = $get_session_user_query->fetch(PDO::FETCH_ASSOC);
    $id_user = $get_session_user_row['id_user'];
    $id_pub = htmlspecialchars($_POST['id_pub']);
    $tail_pub = htmlspecialchars($_POST['tail_pub']);
    $get_publication_query = $conn->prepare("SELECT * FROM publications WHERE id_pub = $id_pub");
    if ($get_publication_query->execute()) {
        $get_publication_row = $get_publication_query->fetch(PDO::FETCH_ASSOC);
        $get_publication_image_query = $conn->prepare("SELECT media_url FROM publications_media WHERE id_pub = $id_pub AND media_type = 'i'");
        $get_publication_video_query = $conn->prepare("SELECT media_url FROM publications_media WHERE id_pub = $id_pub AND media_type = 'v'");
        if ($get_publication_image_query->execute() && $get_publication_video_query->execute()) {
?>
<div class="create-publication-top">
    <div class="cancel-create-publication-responsive" id="cancel_update_publication">
        <i class="fas fa-arrow-left"></i>
    </div>
    <h4>Modifier la publication</h4>
    <div class="cancel-create-publication" id="cancel_update_publication">
        <i class="fas fa-times"></i>
    </div>
    <div class="create-publication-top-button">
        <div id="loader_create_publication_top_button" class="button-center"></div>
        <button id="update_publication_button">Enregistrer</button>
    </div>
</div>
<input type="hidden" id="id_publication" value="<?php echo $id_pub ?>">
<input type="hidden" id="tail_publication" value="<?php echo $tail_pub ?>">
<div class="create-publication-bottom">
    <div class="create-publication-location">
        <div>
            <input type="text" id="publication_location_text" placeholder="Entrer un lieu ..." autocomplete="off" value="<?php echo $get_publication_row['lieu_pub'] ?>">
            <i class="fas fa-map-marker-alt"></i>
        </div>
    </div>
    <div class="publication-preview-location">
        <?php 
            $ville_query = $conn->prepare("SELECT ville AS ville FROM villes UNION SELECT commune AS ville FROM communes");
            $ville_query->execute(); 
            while ($ville_row = $ville_query->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <div id="publication_location_item"><p><?php echo $ville_row['ville']; ?></p></div>
        <?php } ?>    
    </div>
    <div class="create-publication-description">
        <textarea id="publication_description" placeholder="Exprimez vos activités, services ..."><?php echo $get_publication_row['description_pub'] ?></textarea>
    </div>
    <div class="publication-images-preview-container">
        <div class="publication-images-preview">
        <?php
        if ($get_publication_image_query->rowCount() > 0) {
            $i = 0;
            while ($get_publication_image_row = $get_publication_image_query->fetch(PDO::FETCH_ASSOC)) {
            $i++;
        ?>
        <div class="image-preview" id="image_preview_<?php echo $i ?>">
            <div class="delete-preview" id="delete_preview_<?php echo $i ?>">
                <i class="fas fa-times"></i>
            </div>
            <img src="<?php echo $get_publication_image_row['media_url'] ?>">
        </div>
        <?php }} ?>
        </div>
    </div>
    <div class="publication-video-preview-container">
        <div class="publication-video-preview">
        <?php 
        if ($get_publication_video_query->rowCount() > 0) {
            $get_publication_video_row = $get_publication_video_query->fetch(PDO::FETCH_ASSOC);
        ?>
        <div class="video-preview" id="video_preview">
            <div class="delete-preview" id="delete_video">
                <i class="fas fa-times"></i>
            </div>
            <video controls><source src="<?php echo $get_publication_video_row['media_url'] ?>"></video>
        </div>
        <?php } ?>
        </div>
    </div>
    <?php 
    $display = 'style="display:none"';
    if ($get_publication_image_query->rowCount()+$get_publication_video_query->rowCount() < 4) {
        $display = 'style="display:"';
    }
    ?>
    <div class="create-publication-options" <?php echo $display ?>>
        <P>Ajouter des photos ou vidéo</P>
        <div id="add_publication_image">
            <i class="far fa-images"></i>
        </div>
        <div id="add_publication_video">
            <i class="fas fa-video"></i>
        </div>
    </div>
    <form enctype="multipart/form-data">
        <input type="file" id="image" name="images[]" accept="image/*" multiple>
        <input type="button" id="add_publication_image_button">
    </form>
    <form enctype="multipart/form-data">
        <input type="file" id="video" name="video" accept="video/*">
        <input type="button" id="add_publication_video_button">
    </form>
    <div class="create-publication-bottom-button">
        <div id="loader_create_publication_bottom_button" class="button-center"></div>
        <button id="update_publication_button">Enregistrer les modification</button>
    </div>
</div>
<?php 
        }
        else{
            echo 0;
        }
    }
    else{
        echo 0;
    }
}
else{
    echo 0;
}
?>