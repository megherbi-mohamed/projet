<?php
include_once './bdd/connexion.php';
$categorie = htmlspecialchars($_GET['c']);
?>
<select id="sous_categorie_boutique">
    <option value="">Professions</option>
    <?php 
    $categories_query = $conn->prepare("SELECT * FROM categories WHERE categories = '$categorie'");
    $categories_query->execute();
    while ($categories_row = $categories_query->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <option value="<?php echo $categories_row['sous_categories'] ?>"><?php echo $categories_row['sous_categories'] ?></option>
    <?php } ?>
    <option value="autre">Autres</option>
</select>
<span class="sous-categori-btq">Profession *</span>