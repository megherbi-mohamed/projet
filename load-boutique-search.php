<?php
session_start();
include_once './bdd/connexion.php';
if (isset($_SESSION['user'])) {
    $id_session = htmlspecialchars($_SESSION['user']);
    $get_session_user_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                                OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
    if ($get_session_user_query->execute()) {
        $get_session_user_row = $get_session_user_query->fetch(PDO::FETCH_ASSOC);
        $id_user = $get_session_user_row['id_user'];
        $get_historique_query = $conn->prepare("SELECT * FROM recherche_historique WHERE id_user = $id_user AND type_rech = 'boutique' ORDER BY id_r DESC LIMIT 6");
        if ($get_historique_query->execute()) {
            $categories_services_query = $conn->prepare("SELECT * FROM categories WHERE categories = 'services' ORDER BY sous_categories ASC");
            $categories_artisants_query = $conn->prepare("SELECT * FROM categories WHERE categories = 'artisants' ORDER BY sous_categories ASC");
            $categories_transports_query = $conn->prepare("SELECT * FROM categories WHERE categories = 'transports' ORDER BY sous_categories ASC");
            $categories_locations_query = $conn->prepare("SELECT * FROM categories WHERE categories = 'locations' ORDER BY sous_categories ASC");
            $categories_entreprises_query = $conn->prepare("SELECT * FROM categories WHERE categories = 'entreprises' ORDER BY sous_categories ASC");
            $categories_detaillons_query = $conn->prepare("SELECT * FROM categories WHERE categories = 'detaillons' ORDER BY sous_categories ASC");
            $categories_grossistes_query = $conn->prepare("SELECT * FROM categories WHERE categories = 'grossistes' ORDER BY sous_categories ASC");
            $categories_fabriquants_query = $conn->prepare("SELECT * FROM categories WHERE categories = 'fabriquants' ORDER BY sous_categories ASC");
            $categories_importation_query = $conn->prepare("SELECT * FROM categories WHERE categories = 'import-export' ORDER BY sous_categories ASC");
            if ($categories_services_query->execute() && $categories_artisants_query->execute() && $categories_transports_query->execute() && 
            $categories_locations_query->execute() && $categories_entreprises_query->execute() && $categories_detaillons_query->execute() && 
            $categories_grossistes_query->execute() && $categories_fabriquants_query->execute() && $categories_importation_query->execute()) {
                if ($get_historique_query->rowCount() > 0) {
?>
<div class="recherche-historique-option" id="search_boutique_history_option">
    <h4>Historiques de recherche</h4>
    <div id="delete_boutique_search_history">
        <i class="fas fa-trash"></i>
    </div>
</div>
<div class="recherche-tout-historique" id="search_boutique_history">
<?php 
                $h = 0;
                while ($get_historique_row = $get_historique_query->fetch(PDO::FETCH_ASSOC)) {
                $h++;
?>  
    <div id="history_boutique_text_<?php echo $h ?>"><p><?php echo $get_historique_row['text_rech'] ?></p></div>
<?php 
                } 
                if ($get_historique_query->rowCount() == 6) { 
?>
    <div id="show_boutique_history" style="padding:4px 10px;"><i class="fas fa-chevron-down"></i></div>
<?php       
                } 
?>
</div>    
<?php   
            } 
?>
<h4>Catégories des boutiques</h4>
<div class="categorie-recherche-personnalise">
    <div class="categorie-recherche-personnalise-button">
        <img src="icons/bureau-icon.png">
        <p>Services</p>
    </div>
    <div class="sous-categorie-recherche-personnalise">
        <?php 
        while ($categories_services_row = $categories_services_query->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <a href="recherche/boutique/text/<?php echo $categories_services_row['sous_categories'] ?>"><?php echo $categories_services_row['sous_categories'] ?></a>
        <?php } ?>
    </div>
    <div class="categorie-recherche-personnalise-button">
        <img src="icons/service-icon.png" alt="">
        <p>Artisants</p>
    </div>
    <div class="sous-categorie-recherche-personnalise">
        <?php 
        while ($categories_artisants_row = $categories_artisants_query->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <a href="recherche/boutique/text/<?php echo $categories_artisants_row['sous_categories'] ?>"><?php echo $categories_artisants_row['sous_categories'] ?></a>
        <?php } ?>
    </div>
    <div class="categorie-recherche-personnalise-button">
        <img src="icons/transport-icon.png" alt="">
        <p>Transports</p>
    </div>
    <div class="sous-categorie-recherche-personnalise">
        <?php 
        while ($categories_transports_row = $categories_transports_query->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <a href="recherche/boutique/text/<?php echo $categories_transports_row['sous_categories'] ?>"><?php echo $categories_transports_row['sous_categories'] ?></a>
        <?php } ?>
    </div>
    <div class="categorie-recherche-personnalise-button">
        <img src="icons/location-icon.png" alt="">
        <p>Locations</p>
    </div>
    <div class="sous-categorie-recherche-personnalise">
        <?php 
        while ($categories_locations_row = $categories_locations_query->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <a href="recherche/boutique/text/<?php echo $categories_locations_row['sous_categories'] ?>"><?php echo $categories_locations_row['sous_categories'] ?></a>
        <?php } ?>
    </div>
    <div class="categorie-recherche-personnalise-button">
        <img src="icons/entreprise-icon.png" alt="">
        <p>Entreprises</p>
    </div>
    <div class="sous-categorie-recherche-personnalise">
        <?php 
        while ($categories_entreprises_row = $categories_entreprises_query->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <a href="recherche/boutique/text/<?php echo $categories_entreprises_row['sous_categories'] ?>"><?php echo $categories_entreprises_row['sous_categories'] ?></a>
        <?php } ?>
    </div>
    <div class="categorie-recherche-personnalise-button">
        <img src="icons/detaillon-icon.png" alt="">
        <p>Detaillons</p>
    </div>
    <div class="sous-categorie-recherche-personnalise">
        <?php 
        while ($categories_detaillons_row = $categories_detaillons_query->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <a href="recherche/boutique/text/<?php echo $categories_detaillons_row['sous_categories'] ?>"><?php echo $categories_detaillons_row['sous_categories'] ?></a>
        <?php } ?>
    </div>
    <div class="categorie-recherche-personnalise-button">
        <img src="icons/grossiste-icon.png" alt="">
        <p>Grossistes</p>
    </div>
    <div class="sous-categorie-recherche-personnalise">
        <?php 
        while ($categories_grossistes_row = $categories_grossistes_query->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <a href="recherche/boutique/text/<?php echo $categories_grossistes_row['sous_categories'] ?>"><?php echo $categories_grossistes_row['sous_categories'] ?></a>
        <?php } ?>
    </div>
    <div class="categorie-recherche-personnalise-button">
        <img src="icons/fabriquant-icon.png" alt="">
        <p>Fabriquants</p>
    </div>
    <div class="sous-categorie-recherche-personnalise">
        <?php 
        while ($categories_fabriquants_row = $categories_fabriquants_query->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <a href="recherche/boutique/text/<?php echo $categories_fabriquants_row['sous_categories'] ?>"><?php echo $categories_fabriquants_row['sous_categories'] ?></a>
        <?php } ?>
    </div>
    <div class="categorie-recherche-personnalise-button">
        <img src="icons/importateur-icon.png" alt="">
        <p>Import - export</p>
    </div>
    <div class="sous-categorie-recherche-personnalise">
        <?php 
        while ($categories_importation_row = $categories_importation_query->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <a href="recherche/boutique/text/<?php echo $categories_importation_row['sous_categories'] ?>"><?php echo $categories_importation_row['sous_categories'] ?></a>
        <?php } ?>
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
}
else {
    $categories_services_query = $conn->prepare("SELECT * FROM categories WHERE categories = 'services' ORDER BY sous_categories ASC");
    $categories_artisants_query = $conn->prepare("SELECT * FROM categories WHERE categories = 'artisants' ORDER BY sous_categories ASC");
    $categories_transports_query = $conn->prepare("SELECT * FROM categories WHERE categories = 'transports' ORDER BY sous_categories ASC");
    $categories_locations_query = $conn->prepare("SELECT * FROM categories WHERE categories = 'locations' ORDER BY sous_categories ASC");
    $categories_entreprises_query = $conn->prepare("SELECT * FROM categories WHERE categories = 'entreprises' ORDER BY sous_categories ASC");
    $categories_detaillons_query = $conn->prepare("SELECT * FROM categories WHERE categories = 'detaillons' ORDER BY sous_categories ASC");
    $categories_grossistes_query = $conn->prepare("SELECT * FROM categories WHERE categories = 'grossistes' ORDER BY sous_categories ASC");
    $categories_fabriquants_query = $conn->prepare("SELECT * FROM categories WHERE categories = 'fabriquants' ORDER BY sous_categories ASC");
    $categories_importation_query = $conn->prepare("SELECT * FROM categories WHERE categories = 'import-export' ORDER BY sous_categories ASC");
    if ($categories_services_query->execute() && $categories_artisants_query->execute() && $categories_transports_query->execute() && 
    $categories_locations_query->execute() && $categories_entreprises_query->execute() && $categories_detaillons_query->execute() && 
    $categories_grossistes_query->execute() && $categories_fabriquants_query->execute() && $categories_importation_query->execute()) {
?>
<h4>Catégories des boutiques</h4>
<div class="categorie-recherche-personnalise">
    <div class="categorie-recherche-personnalise-button">
        <img src="icons/bureau-icon.png">
        <p>Services</p>
    </div>
    <div class="sous-categorie-recherche-personnalise">
        <?php 
        while ($categories_services_row = $categories_services_query->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <a href="recherche/boutique/text/<?php echo $categories_services_row['sous_categories'] ?>"><?php echo $categories_services_row['sous_categories'] ?></a>
        <?php } ?>
    </div>
    <div class="categorie-recherche-personnalise-button">
        <img src="icons/service-icon.png" alt="">
        <p>Artisants</p>
    </div>
    <div class="sous-categorie-recherche-personnalise">
        <?php 
        while ($categories_artisants_row = $categories_artisants_query->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <a href="recherche/boutique/text/<?php echo $categories_artisants_row['sous_categories'] ?>"><?php echo $categories_artisants_row['sous_categories'] ?></a>
        <?php } ?>
    </div>
    <div class="categorie-recherche-personnalise-button">
        <img src="icons/transport-icon.png" alt="">
        <p>Transports</p>
    </div>
    <div class="sous-categorie-recherche-personnalise">
        <?php 
        while ($categories_transports_row = $categories_transports_query->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <a href="recherche/boutique/text/<?php echo $categories_transports_row['sous_categories'] ?>"><?php echo $categories_transports_row['sous_categories'] ?></a>
        <?php } ?>
    </div>
    <div class="categorie-recherche-personnalise-button">
        <img src="icons/location-icon.png" alt="">
        <p>Locations</p>
    </div>
    <div class="sous-categorie-recherche-personnalise">
        <?php 
        while ($categories_locations_row = $categories_locations_query->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <a href="recherche/boutique/text/<?php echo $categories_locations_row['sous_categories'] ?>"><?php echo $categories_locations_row['sous_categories'] ?></a>
        <?php } ?>
    </div>
    <div class="categorie-recherche-personnalise-button">
        <img src="icons/entreprise-icon.png" alt="">
        <p>Entreprises</p>
    </div>
    <div class="sous-categorie-recherche-personnalise">
        <?php 
        while ($categories_entreprises_row = $categories_entreprises_query->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <a href="recherche/boutique/text/<?php echo $categories_entreprises_row['sous_categories'] ?>"><?php echo $categories_entreprises_row['sous_categories'] ?></a>
        <?php } ?>
    </div>
    <div class="categorie-recherche-personnalise-button">
        <img src="icons/detaillon-icon.png" alt="">
        <p>Detaillons</p>
    </div>
    <div class="sous-categorie-recherche-personnalise">
        <?php 
        while ($categories_detaillons_row = $categories_detaillons_query->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <a href="recherche/boutique/text/<?php echo $categories_detaillons_row['sous_categories'] ?>"><?php echo $categories_detaillons_row['sous_categories'] ?></a>
        <?php } ?>
    </div>
    <div class="categorie-recherche-personnalise-button">
        <img src="icons/grossiste-icon.png" alt="">
        <p>Grossistes</p>
    </div>
    <div class="sous-categorie-recherche-personnalise">
        <?php 
        while ($categories_grossistes_row = $categories_grossistes_query->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <a href="recherche/boutique/text/<?php echo $categories_grossistes_row['sous_categories'] ?>"><?php echo $categories_grossistes_row['sous_categories'] ?></a>
        <?php } ?>
    </div>
    <div class="categorie-recherche-personnalise-button">
        <img src="icons/fabriquant-icon.png" alt="">
        <p>Fabriquants</p>
    </div>
    <div class="sous-categorie-recherche-personnalise">
        <?php 
        while ($categories_fabriquants_row = $categories_fabriquants_query->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <a href="recherche/boutique/text/<?php echo $categories_fabriquants_row['sous_categories'] ?>"><?php echo $categories_fabriquants_row['sous_categories'] ?></a>
        <?php } ?>
    </div>
    <div class="categorie-recherche-personnalise-button">
        <img src="icons/importateur-icon.png" alt="">
        <p>Import - export</p>
    </div>
    <div class="sous-categorie-recherche-personnalise">
        <?php 
        while ($categories_importation_row = $categories_importation_query->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <a href="recherche/boutique/text/<?php echo $categories_importation_row['sous_categories'] ?>"><?php echo $categories_importation_row['sous_categories'] ?></a>
        <?php } ?>
    </div>
</div>
<?php
    }
    else{
        echo 0;
    }
}
?>
<script>
var categorieProfssTop = document.querySelectorAll('.categorie-recherche-personnalise-button');
var categorieProfssBottom = document.querySelectorAll('.sous-categorie-recherche-personnalise');
var clickCategorie = new Array(categorieProfssTop.length);
for (let k = 0; k < categorieProfssTop.length; k++) {
    clickCategorie[k] = 1;
    categorieProfssTop[k].addEventListener('click',(e)=>{
        e.stopPropagation();
        clickCategorie[k]++;
        if (clickCategorie[k]%2 == 1) {
            categorieProfssBottom[k].style.display = "";
        }
        else{
            hideCategories();
            categorieProfssBottom[k].style.display = "initial";
        }
        categorieProfssTop[k].scrollIntoView();
    }) 
}
</script>
