<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_user_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                        OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_user_query->execute();
$get_session_user_row = $get_session_user_query->fetch(PDO::FETCH_ASSOC);
$user_session_query = $conn->prepare("SELECT * FROM utilisateurs WHERE id_user = {$get_session_user_row['id_user']}");
$user_session_query->execute();
$row = $user_session_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_user_row['id_user'];
$etat = 1;
$create_publication_query = $conn->prepare("INSERT INTO publications (id_user,etat) VALUES (:id_user,:etat)");
$create_publication_query->bindParam(':id_user',$id_user);
$create_publication_query->bindParam(':etat',$etat);
if ($create_publication_query->execute()) {
    $get_publication_query = $conn->prepare("SELECT id_pub FROM publications WHERE id_user = $id_user AND etat = 1");
    if($get_publication_query->execute()){
        $get_publication_row = $get_publication_query->fetch(PDO::FETCH_ASSOC);
?>
<div class="create-publication-top">
    <div class="cancel-create-publication-responsive" id="cancel_create_publication">
        <i class="fas fa-arrow-left"></i>
    </div>
    <h4>Créer une publication</h4>
    <div class="cancel-create-publication" id="cancel_create_publication">
        <i class="fas fa-times"></i>
    </div>
    <div class="create-publication-top-button">
        <div id="loader_create_publication_top_button" class="button-center"></div>
        <button id="create_publication_button">Publier</button>
    </div>
</div>
<input type="hidden" id="id_publication" value="<?php echo $get_publication_row['id_pub'] ?>">
<div class="create-publication-bottom">
    <div class="create-publication-location">
        <div>
            <input type="text" id="publication_location_text" placeholder="Entrer un lieu ..." autocomplete="off" value="<?php echo $row['commune_user'] ?>">
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
        <textarea id="publication_description" placeholder="Exprimez vos activités, services ..."></textarea>
    </div>
    <div class="publication-images-preview-container">
        <div class="publication-images-preview"></div>
    </div>
    <div class="publication-video-preview-container">
        <div class="publication-video-preview"></div>
    </div>
    <div class="create-publication-options">
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
        <button id="create_publication_button">Publier</button>
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
?>