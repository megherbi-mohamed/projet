<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_user_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_user_query->execute();
$get_session_user_row = $get_session_user_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_user_row['id_user'];
$id_prm = htmlspecialchars($_POST['id_prm']);
$get_prm_query = $conn->prepare("SELECT * FROM promotions WHERE id_user = $id_user AND id_prm = $id_prm AND etat = 1");
if($get_prm_query->execute()){
    $get_prm_row = $get_prm_query->fetch(PDO::FETCH_ASSOC);
    $get_promotion_media_query = $conn->prepare("SELECT media_url FROM promotions_media WHERE id_prm = $id_prm");
    if($get_promotion_media_query->execute()){
        $get_promotion_media_row = $get_promotion_media_query->fetch(PDO::FETCH_ASSOC);
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
        <div class="create-promotion-options" style="display:none">
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
        <div class="promotion-images-preview" style="display:block">
            <div class="promotion-image-preview" id="promotion_image_preview">
                <div id="promotion_delete_image_preview">
                    <i class="fas fa-times"></i>
                </div>
                <img src="<?php echo $get_promotion_media_row['media_url'] ?>">
            </div>
        </div>
        <form enctype="multipart/form-data">
            <input type="file" id="image_promotion" name="image" accept="image/*">
            <input type="button" id="add_promotion_image_button">
        </form>
        <form enctype="multipart/form-data">
            <input type="file" id="video_promotion" name="video" accept="video/*">
            <input type="button" id="add_promotion_video_button">
        </form>
        <div class="promotion-input">
            <input type="text" id="titre_prm" autocomplete="off" value="<?php echo $get_prm_row['titre_prm']?>">
            <span class="titre-prm active-promotion-span">Titre *</span>
        </div>
        <div class="promotion-input" id="promotion_categorie_select">
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
        <div class="promotion-input sous-categorie-promotion" id="promotion_profession_select">
            <span class="sous-categorie-prm">Sous categorie *</span>
            <select id="sous_categorie_prm">
                <option value="">Sous categories</option>
            </select>
        </div>
        <div class="promotion-input sous-categorie-autre">
            <span class="sous-categorie-prm">Sous categorie *</span>
            <input type="text" id="sous_categorie_prm">
        </div>
        <div class="promotion-input" id="promotion_ville_select">
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
        <div class="promotion-input commune-promotion" id="promotion_commune_select">
            <select id="commune_promotion">
                <option value="">Commune</option>
            </select>
            <span class="lieu-prm active-promotion-span">Commune *</span>
        </div>
        <div class="promotion-input">
            <input type="text" id="adresse_prm" autocomplete="off" value="<?php echo $get_prm_row['adresse_prm']?>">
            <span class="adresse-prm active-promotion-span">Adresse *</span>
        </div>
        <div class="promotion-localisation-gps">
            <?php if ($get_prm_row['latitude_prm'] == null) { ?>
                <p>Ajouter une localisation gps (optionnelle)</p>
                <button onclick="getLocation()">Ajouter</button>
            <?php } else { ?>
                <p>La position a été bien ajoutée</p>
                <button onclick="getLocation()">Ajouté</button>
            <?php } ?>
            <input type="hidden" id="latitude_prm" value="<?php echo $get_prm_row['latitude_prm']?>">
            <input type="hidden" id="longitude_prm" value="<?php echo $get_prm_row['longitude_prm']?>">
        </div>
        <div class="promotion-input">
            <input type="datetime-local" id="date_debut_prm" value="<?php echo date("Y-m-d\TH:i:s", strtotime($get_prm_row['date_debut_prm'])); ?>">
            <span class="date-debut-prm">Date debut promotion</span>
        </div>
        <div class="promotion-input">
            <input type="datetime-local" id="date_fin_prm" value="<?php echo date("Y-m-d\TH:i:s", strtotime($get_prm_row['date_fin_prm'])); ?>">
            <span class="date-fin-prm">Date fin promotion</span>
        </div>
        <div class="promotion-input">
            <textarea id="description_prm"><?php echo $get_prm_row['description_prm'] ?></textarea>
            <span class="description-prm active-promotion-span">Description</span>
        </div>
        <div class="create-promotion-bottom-button">
            <p>Ajouter les details de vos produits</p>
            <div id="loader_create_publication_bottom_button" class="button-center"></div>
            <button id="next_create_promotion">Suivant</button>
        </div>
    </div>
</div>
<script>
$('#promotion_categorie_select option[value="<?php echo $get_prm_row['categorie_prm'] ?>"]').prop('selected',true);
$('.sous-categorie-promotion').load('categorie-promotion.php?c=<?php echo $get_prm_row['categorie_prm'] ?>');
setTimeout(() => {
    $('#promotion_profession_select option[value="<?php echo $get_prm_row['sous_categorie_prm'] ?>"]').prop('selected',true);
}, 500);

$('#promotion_ville_select option[value="<?php echo $get_prm_row['ville_prm'] ?>"]').prop('selected',true);
$('.commune-promotion').load('commune-promotion.php?v=<?php echo $get_prm_row['ville_prm'] ?>');
setTimeout(() => {
    $('#promotion_commune_select option[value="<?php echo $get_prm_row['commune_prm'] ?>"]').prop('selected',true);
}, 500);
</script>
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