<?php
include_once './bdd/connexion.php';
$categorie = htmlspecialchars($_GET['c']);
?>
<span class="sous-categorie-prm">Sous categorie *</span>
<select id="sous_categorie_prm">
    <option value="">Sous categories</option>
    <?php 
    $categories_query = $conn->prepare("SELECT * FROM categories WHERE categories = '$categorie'");
    $categories_query->execute();
    while ($categories_row = $categories_query->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <option value="<?php echo $categories_row['sous_categories'] ?>"><?php echo $categories_row['sous_categories'] ?></option>
    <?php } ?>
    <option value="autre">Autres</option>
</select>