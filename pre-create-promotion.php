<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_user_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_user_query->execute();
$get_session_user_row = $get_session_user_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_user_row['id_user'];
$etat = 1;
$create_prm_query = $conn->prepare("INSERT INTO promotions (id_user,etat) VALUES (:id_user,:etat)");
$create_prm_query->bindParam(':id_user',$id_user);
$create_prm_query->bindParam(':etat',$etat);
if ($create_prm_query->execute()) {
    $get_prm_query = $conn->prepare("SELECT id_prm FROM promotions WHERE id_user = $id_user AND etat = 1");
    if($get_prm_query->execute()){
        $get_prm_row = $get_prm_query->fetch(PDO::FETCH_ASSOC);
?>
<div class="create-promotion-container" id="create_promotion_container">
    <div class="create-publication-top">
        <div class="cancel-create-publication-responsive" id="cancel_create_promotion">
            <i class="fas fa-arrow-left"></i>
        </div>
        <h4>Créer une promotion!</h4>
        <div class="cancel-create-publication" id="cancel_create_promotion">
            <i class="fas fa-times"></i>
        </div>
        <div class="create-publication-top-button">
            <div id="loader_create_publication_top_button" class="button-center"></div>
            <button id="next_create_promotion">Suivant</button>
        </div>
    </div>
    <div class="create-publication-bottom">
        <div class="create-promotion-options">
            <div class="create-promotion-option" id="add_promotion_image">
                <div>
                    <P>Ajouter une photo de cette promotion</P>
                    <i class="far fa-images"></i>
                </div>
            </div>
            <div class="create-promotion-option" id="add_promotion_video">
                <div>
                    <P>Ajouter une vidéo de cette promotion</P>
                    <i class="fas fa-video"></i>
                </div>
            </div>
        </div>
        <div class="promotion-images-preview"></div>
        <form enctype="multipart/form-data">
            <input type="file" id="image_promotion" name="image" accept="image/*">
            <input type="button" id="add_promotion_image_button">
        </form>
        <form enctype="multipart/form-data">
            <input type="file" id="video_promotion" name="video" accept="video/*">
            <input type="button" id="add_promotion_video_button">
        </form>
        <div class="promotion-input">
            <input type="text" id="titre_prm" autocomplete="off">
            <span class="titre-prm">Titre *</span>
        </div>
        <div class="promotion-input">
            <span class="categorie-prm">Categorie *</span>
            <select id="categorie_prm">
                <option value="">Categories</option>
                <option id="services" value="services">Services</option>
                <option id="artisants" value="artisants">Artisants</option>
                <option id="transports" value="transports">Transports</option>
                <option id="locations" value="locations">Locations</option>
                <option id="entreprises" value="entreprises">Entreprises</option>
                <option id="detaillons" value="detaillons">Detaillons</option>
                <option id="grossidtes" value="grossidtes">Grossistes</option>
                <option id="fabriquants" value="fabriquants">Fabriquants</option>
                <option id="import-export" value="import-export">Import-Export</option>
            </select>
        </div>
        <div class="promotion-input sous-categorie-promotion">
            <span class="sous-categorie-prm">Sous categorie *</span>
            <select id="sous_categorie_prm">
                <option value="">Sous categories</option>
            </select>
        </div>
        <div class="promotion-input sous-categorie-autre">
            <span class="sous-categorie-prm">Sous categorie *</span>
            <input type="text" id="sous_categorie_prm">
        </div>
        <div class="promotion-input">
            <select id="ville_promotion">
                <option value="">Ville</option>
                <?php 
                $ville_query = $conn->prepare("SELECT * FROM villes");
                $ville_query->execute(); 
                while ($ville_row = $ville_query->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <option value="<?php echo $ville_row['ville'] ?>"><?php echo $ville_row['ville'] ?></option>
                <?php } ?>
            </select>
            <span class="lieu-prm active-promotion-span">Ville *</span>
        </div>
        <div class="promotion-input commune-promotion">
            <select id="commune_promotion">
                <option value="">Commune</option>
            </select>
            <span class="lieu-prm active-promotion-span">Commune *</span>
        </div>
        <div class="promotion-input">
            <input type="text" id="adresse_prm" autocomplete="off">
            <span class="adresse-prm">Adresse *</span>
        </div>
        <div class="promotion-localisation-gps">
            <p>Ajouter une localisation gps (optionnelle)</p>
            <button onclick="getLocation()">Ajouter</button>
            <input type="hidden" id="latitude_prm">
            <input type="hidden" id="longitude_prm">
        </div>
        <div class="promotion-input">
            <input type="datetime-local" id="date_debut_prm">
            <span class="date-debut-prm">Date debut promotion</span>
        </div>
        <div class="promotion-input">
            <input type="datetime-local" id="date_fin_prm">
            <span class="date-fin-prm">Date fin promotion</span>
        </div>
        <div class="promotion-input">
            <textarea id="description_prm"></textarea>
            <span class="description-prm">Description *</span>
        </div>
        <div class="create-promotion-bottom-button">
            <p>Ajouter les details de vos produits</p>
            <div id="loader_create_publication_bottom_button" class="button-center"></div>
            <button id="next_create_promotion">Suivant</button>
        </div>
    </div>
</div>
<input type="hidden" id="id_promotion" value="<?php echo $get_prm_row['id_prm'] ?>">
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