<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_user_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_user_query->execute();
$get_session_user_row = $get_session_user_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_user_row['id_user'];
$type_user = 'boutique';
$etat = 1;
$create_btq_query = $conn->prepare("INSERT INTO boutiques (type_user,id_createur,etat) VALUES (:type_user,:id_createur,:etat)");
$create_btq_query->bindParam(':type_user', $type_user);
$create_btq_query->bindParam(':id_createur', $id_user);
$create_btq_query->bindParam(':etat', $etat);
if ($create_btq_query->execute()) {
    $get_btq_query = $conn->prepare("SELECT id_btq FROM boutiques WHERE id_createur = '$id_user' AND etat = 1");
    if ($get_btq_query->execute()) {
        $get_btq_row = $get_btq_query->fetch(PDO::FETCH_ASSOC);
        $id_btq = $get_btq_row['id_btq'];
?>
<div class="create-publication-top">
    <div class="cancel-create-publication-responsive" id="cancel_create_boutique">
        <i class="fas fa-arrow-left"></i>
    </div>
    <h4>Créer une boutique</h4>
    <div class="cancel-create-publication" id="cancel_create_boutique">
        <i class="fas fa-times"></i>
    </div>
    <div class="create-publication-top-button">
        <div id="loader_create_publication_top_button" class="button-center"></div>
        <button id="create_boutique_button">Publier</button>
    </div>
</div>
<div class="create-publication-bottom create-boutique-bottom">
    <div class="boutique-input">
        <span class="nom-btq">Nom boutique *</span>
        <input type="text" id="nom_boutique" autocomplete="off">
    </div>
    <div class="categories-boutique boutique-input">
        <select id="categorie_boutique">
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
        <span class="categorie-btq">Categorie *</span>
    </div>
    <div class="sous-categorie-boutique boutique-input">
        <select id="sous_categorie_boutique">
            <option value="">Professions</option>
        </select>
        <span class="sous-categori-btq">Profession *</span>
    </div>
    <div class="sous-categorie-autre boutique-input">
        <input type="text" id="sous_categorie_boutique">
        <span class="sous-categorie-btq">Profession *</span>
    </div>
    <div class="boutique-input">
        <select id="ville_boutique">
            <option value="">Ville</option>
            <?php 
            $ville_query = $conn->prepare("SELECT * FROM villes");
            $ville_query->execute(); 
            while ($ville_row = $ville_query->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <option value="<?php echo $ville_row['ville'] ?>"><?php echo $ville_row['ville'] ?></option>
            <?php } ?>
        </select>
        <span class="ville-btq">Ville *</span>
    </div>
    <div class="commune-boutique boutique-input"> 
        <select id="commune_boutique">
            <option value="">Commune</option>
        </select>
        <span class="commun-btq">Commune *</span>
    </div>
    <div class="boutique-input">
        <input type="text" id="adresse_boutique" autocomplete="off"> 
        <span class="adresse-btq">Adresse *</span>
    </div>
    <div class="boutique-input">
        <input type="text" id="email_boutique" autocomplete="off">
        <span class="email-btq">Email *</span>
    </div>
    <div class="boutique-input">
        <input type="text" id="tlph_boutique" autocomplete="off">
        <span class="tlph-btq">Téléphone *</span>
    </div>
    <div class="create-publication-bottom-button">
        <div id="loader_create_publication_bottom_button" class="button-center"></div>
        <button id="create_boutique_button">Créer maintenant</button>
    </div>
</div>
<input type="hidden" id="id_boutique" value="<?php echo $id_btq ?>">
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