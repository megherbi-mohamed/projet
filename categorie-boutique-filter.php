<?php
include_once './bdd/connexion.php';
$categorie = htmlspecialchars($_GET['c']);
?>
<p>Profession</p>
<select id="profession_boutique">
    <option value="">Professions</option>
    <?php 
    $categories_query = $conn->prepare("SELECT * FROM categories WHERE categories = '$categorie'");
    $categories_query->execute();
    while ($categories_row = $categories_query->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <option value="<?php echo $categories_row['sous_categories'] ?>"><?php echo $categories_row['sous_categories'] ?></option>
    <?php } ?>
</select>