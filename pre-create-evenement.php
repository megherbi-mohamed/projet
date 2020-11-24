<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_user_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_user_query->execute();
$get_session_user_row = $get_session_user_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_user_row['id_user'];
$create_evenement_query = $conn->prepare("INSERT INTO evenements (id_user,etat) VALUES ($id_user,1)");
if ($create_evenement_query->execute()) {
    $get_evenement_query = $conn->prepare("SELECT id_evn FROM evenements WHERE id_user = $id_user AND etat = 1");
    if($get_evenement_query->execute()){
        $get_evenement_row = $get_evenement_query->fetch(PDO::FETCH_ASSOC);
?>
<div class="create-publication-top">
    <div class="cancel-create-publication-responsive" id="cancel_create_evenement">
        <i class="fas fa-arrow-left"></i>
    </div>
    <h4>Créer un evenement</h4>
    <div class="cancel-create-publication" id="cancel_create_evenement">
        <i class="fas fa-times"></i>
    </div>
    <div class="create-publication-top-button">
        <div id="loader_create_publication_top_button" class="button-center"></div>
        <button id="final_create_evenement_button">Créer</button>
    </div>
</div>
<input type="hidden" id="id_evenement" value="<?php echo $get_evenement_row['id_evn'] ?>">
<div class="create-publication-bottom">
    <div class="create-evenement-options">
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
    <div class="evenement-images-preview"></div>
    <form enctype="multipart/form-data">
        <input type="file" id="image_evenement" name="image" accept="image/*">
        <input type="button" id="add_evenement_image_button">
    </form>
    <form enctype="multipart/form-data">
        <input type="file" id="video_evenement" name="video" accept="video/*">
        <input type="button" id="add_evenement_video_button">
    </form>
    <div class="evenement-input">
        <input type="text" id="titre_evn" autocomplete="off">
        <span class="titre-evn">Titre *</span>
    </div>
    <div class="evenement-input">
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
        <textarea id="description_evn"></textarea>
        <span class="description-evn">Description *</span>
    </div>
    <div class="evenement-input">
        <input type="datetime-local" id="date_debut_evn">
        <span class="date-debut-evn active-evenement-span">Date debut d'évènement *</span>
    </div>
    <div class="evenement-input">
        <input type="datetime-local" id="date_fin_evn">
        <span class="date-fin-evn active-evenement-span">Date fin d'évènement *</span>
    </div>
    <div class="evenement-input">
        <input type="number" id="nombre_personne_evn" placeholder="0" autocomplete="off">
        <span class="nombre-personne-evn active-evenement-span">Nombre maximum de personne</span>
    </div>
    <div class="evenement-input">
        <select id="convier_amis_evn">
            <option value="">Possibilité de convier des amis</option>
            <option value="oui">Oui</option>
            <option value="non">Non</option>
        </select>
        <span class="convier-amis-evn active-evenement-span">Possibilité de convier des amis *</span>
    </div>
    <div class="evenement-input">
        <select id="langue_evn">
            <option value="">Langue</option>
            <option value="arabe">Arabe</option>
            <option value="englais">Englais</option>
            <option value="francais">Francais</option>
        </select>
        <span class="langue-evn active-evenement-span">Langue</span>
    </div>
    <div class="evenement-input">
        <select id="confidentialite_evn">
            <option value="">Confidentialité</option>
            <option value="public">Public</option>
            <option value="abonnes">Abonnés</option>
        </select>
        <span class="langue-evn active-evenement-span">Confidentialité *</span>
    </div>
    <div class="evenement-input">
        <input type="text" id="tarif_evn" placeholder="0" autocomplete="off">
        <span class="tarif-evn active-evenement-span">Tarif</span>
    </div>
    <div class="evenement-input">
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
    <div class="evenement-input commune-evenement">
        <select id="commune_evn">
            <option value="">Commune</option>
        </select>
        <span class="lieu-evn active-evenement-span">Commune *</span>
    </div>
    <div class="evenement-input">
        <input type="text" id="adresse_evn" autocomplete="off">
        <span class="adresse-evn">Adresse *</span>
    </div>
    <div class="evenement-localisation-gps">
        <p>Ajouter une localisation gps (optionnelle)</p>
        <button onclick="getEvenementLocation()">Ajouter</button>
        <input type="hidden" id="latitude_evn">
        <input type="hidden" id="longitude_evn">
    </div>
    <div class="create-publication-bottom-button">
        <div id="loader_create_publication_bottom_button" class="button-center"></div>
        <button id="final_create_evenement_button">Créer maintenant</button>
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