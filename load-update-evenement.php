<?php
include_once './bdd/connexion.php';
$tail_evn = htmlspecialchars($_POST['tail_evn']);
$id_evn = htmlspecialchars($_POST['id_evn']);
$get_evenement_query = $conn->prepare("SELECT * FROM evenements WHERE id_evn = $id_evn");
if($get_evenement_query->execute()){
    $get_evenement_row = $get_evenement_query->fetch(PDO::FETCH_ASSOC);
    $get_evenement_media_query = $conn->prepare("SELECT media_url,media_type FROM evenements_media WHERE id_evn = $id_evn");
    if($get_evenement_media_query->execute()){
        $get_evenement_media_row = $get_evenement_media_query->fetch(PDO::FETCH_ASSOC);
?>
<div class="create-publication-top">
    <div class="cancel-create-publication-responsive" id="cancel_update_evenement">
        <i class="fas fa-arrow-left"></i>
    </div>
    <h4>Créer un evenement</h4>
    <div class="cancel-create-publication" id="cancel_update_evenement">
        <i class="fas fa-times"></i>
    </div>
    <div class="create-publication-top-button">
        <div id="loader_create_publication_top_button" class="button-center"></div>
        <button id="final_update_evenement_button">Enregistrer</button>
    </div>
</div>
<input type="hidden" id="id_evenement" value="<?php echo $get_evenement_row['id_evn'] ?>">
<div class="create-publication-bottom">
    <div class="create-evenement-options" style="display:none">
        <div class="create-evenement-option" id="add_evenement_image">
            <div>
                <P>Ajouter une photo de cette evenement</P>
                <i class="far fa-images"></i>
            </div>
        </div>
        <div class="create-evenement-option" id="add_evenement_video">
            <div>
                <P>Ajouter une vidéo de cette evenement</P>
                <i class="fas fa-video"></i>
            </div>
        </div>
    </div>
    <div class="evenement-images-preview" style="display:block">
        <?php if ($get_evenement_media_row['media_type'] == 'i') { ?>
        <div class="evenement-image-preview" id="evenement_image_preview">
            <div id="evenement_delete_image_preview">
                <i class="fas fa-times"></i>
            </div>
            <img src="<?php echo $get_evenement_media_row['media_url'] ?>">
        </div>
        <?php } else { ?>
        <div class="evenement-video-preview" id="evenement_video_preview">
            <div id="evenement_delete_video_preview">
                <i class="fas fa-times"></i>
            </div>
            <video controls><source src="<?php echo $get_evenement_media_row['media_url'] ?>"></video>
        </div>
        <?php } ?>
    </div>
    <form enctype="multipart/form-data">
        <input type="file" id="image_evenement" name="image" accept="image/*">
        <input type="button" id="add_evenement_image_button">
    </form>
    <form enctype="multipart/form-data">
        <input type="file" id="video_evenement" name="video" accept="video/*">
        <input type="button" id="add_evenement_video_button">
    </form>
    <div class="evenement-input">
        <input type="text" id="titre_evn" autocomplete="off" value="<?php echo $get_evenement_row['titre_evn'] ?>">
        <span class="titre-evn active-evenement-span">Titre *</span>
    </div>
    <div class="evenement-input" id="evenement_type_select">
        <select id="type_evn">
            <option value="">Type d'évènement</option>
            <option value="exposition">Exposition</option>
            <option value="foire">Foire</option>
            <option value="presentation">Presentation</option>
            <option value="apprentisage">Apprentisage</option>
            <option value="formation">Formation</option>
            <option value="enchère">Enchère</option>
            <option value="conférence">Conférence</option>
            <option value="séminaire">Séminaire</option>
            <option value="congré">Congré</option>
            <option value="soiré de lancement de produit">Type d'évènement</option>
            <option value="anniversaire de l'entreprise ou de produit">Anniversaire de l'entreprise ou de produit</option>
            <option value="voyage de la récompense">Voyage de la récompense</option>
        </select>
        <span class="type-evn active-evenement-span">Type *</span>
    </div>
    <div class="evenement-input">
        <textarea id="description_evn"><?php echo $get_evenement_row['description_evn'] ?></textarea>
        <span class="description-evn active-evenement-span">Description *</span>
    </div>
    <div class="evenement-input">
        <input type="datetime-local" id="dat_debut_evn" value="<?php echo date("Y-m-d\TH:i:s", strtotime($get_evenement_row['date_debut_evn'])); ?>">
        <span class="date-debut-evn active-evenement-span">Date debut d'évènement *</span>
    </div>
    <div class="evenement-input">
        <input type="datetime-local" id="dat_fin_evn" value="<?php echo date("Y-m-d\TH:i:s", strtotime($get_evenement_row['date_fin_evn'])); ?>">
        <span class="date-fin-evn active-evenement-span">Date fin d'évènement *</span>
    </div>
    <div class="evenement-input">
        <input type="number" id="nombre_personne_evn" placeholder="0" autocomplete="off" value="<?php echo $get_evenement_row['nombre_personne_evn'] ?>">
        <span class="nombre-personne-evn active-evenement-span">Nombre maximum de personne</span>
    </div>
    <div class="evenement-input" id="evenement_covier_amis_select">
        <select id="convier_amis_evn">
            <option value="">Possibilité de convier des amis</option>
            <option value="oui">Oui</option>
            <option value="non">Non</option>
        </select>
        <span class="convier-amis-evn active-evenement-span">Possibilité de convier des amis *</span>
    </div>
    <div class="evenement-input" id="evenement_langue_select">
        <select id="langue_evn">
            <option value="">Langue</option>
            <option value="arabe">Arabe</option>
            <option value="englais">Englais</option>
            <option value="francais">Francais</option>
        </select>
        <span class="langue-evn active-evenement-span">Langue</span>
    </div>
    <div class="evenement-input" id="evenement_confidentialite_select">
        <select id="confidentialite_evn">
            <option value="">Confidentialité</option>
            <option value="public">Public</option>
            <option value="abonnes">Abonnés</option>
        </select>
        <span class="langue-evn active-evenement-span">Confidentialité *</span>
    </div>
    <div class="evenement-input">
        <span class="tarif-evn active-evenement-span">Tarif</span>
        <input type="text" id="tarif_evn" placeholder="0" autocomplete="off" value="<?php echo $get_evenement_row['tarif_evn'] ?>">
    </div>
    <div class="evenement-input" id="evenement_ville_select">
        <select id="ville_evn">
            <option value="">Ville</option>
            <?php 
            $ville_query = $conn->prepare("SELECT * FROM villes");
            $ville_query->execute(); 
            while ($ville_row = $ville_query->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <option value="<?php echo $ville_row['ville'] ?>"><?php echo $ville_row['ville'] ?></option>
            <?php } ?>
        </select>
        <span class="lieu-evn active-evenement-span">Ville *</span>
    </div>
    <div class="evenement-input commune-evenement" id="evenement_commune_select">
        <select id="commune_evn">
            <option value="">Commune</option>
        </select>
        <span class="lieu-evn active-evenement-span">Commune *</span>
    </div>
    <div class="evenement-input">
        <input type="text" id="adresse_evn" autocomplete="off" value="<?php echo $get_evenement_row['adresse_evn'] ?>">
        <span class="adresse-evn active-evenement-span">Adresse *</span>
    </div>
    <div class="evenement-localisation-gps">
        <p>Ajouter une localisation gps (optionnelle)</p>
        <button onclick="getEvenementLocation()">Modifier</button>
        <input type="hidden" id="latitud_evn" value="<?php echo $get_evenement_row['latitude_evn'] ?>">
        <input type="hidden" id="longitud_evn" value="<?php echo $get_evenement_row['longitude_evn'] ?>">
    </div>
    <div class="create-publication-bottom-button">
        <div id="loader_create_publication_bottom_button" class="button-center"></div>
        <button id="final_update_evenement_button">Enregistrer les modification</button>
    </div>
</div>
<script>
$('#evenement_type_select option[value="<?php echo $get_evenement_row['type_evn'] ?>"]').prop('selected',true);
$('#evenement_covier_amis_select option[value="<?php echo $get_evenement_row['convier_amis_evn'] ?>"]').prop('selected',true);
$('#evenement_langue_select option[value="<?php echo $get_evenement_row['langue_evn'] ?>"]').prop('selected',true);
$('#evenement_confidentialite_select option[value="<?php echo $get_evenement_row['confidentialite_evn'] ?>"]').prop('selected',true);
$('#evenement_confidentialite_select option[value="<?php echo $get_evenement_row['confidentialite_evn'] ?>"]').prop('selected',true);
$('#evenement_ville_select option[value="<?php echo $get_evenement_row['ville_evn'] ?>"]').prop('selected',true);
$('.commune-evenement').load('commune-evenement.php?v=<?php echo $get_evenement_row['ville_evn'] ?>');
setTimeout(() => {
    $('#evenement_commune_select option[value="<?php echo $get_evenement_row['commune_evn'] ?>"]').prop('selected',true);
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