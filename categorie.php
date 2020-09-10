<?php
include_once './bdd/connexion.php';
$categorie = htmlspecialchars($_GET['c']);
?>
<select id="sous_categorie_boutique">
    <option value="">Professions</option>
    <?php 
        $categories_query = "SELECT * FROM categories WHERE categories = '$categorie'";
        $categories_result = mysqli_query($conn,$categories_query);
        while ($categories_row = mysqli_fetch_assoc($categories_result)) {
    ?>
    <option value="<?php echo $categories_row['sous_categories'] ?>"><?php echo $categories_row['sous_categories'] ?></option>
    <?php } ?>
    <option value="autre">Autres</option>
</select>