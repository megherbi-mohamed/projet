<?php
include_once './bdd/connexion.php';
$categorie = htmlspecialchars($_GET['c']);
?>
<span class="pre-profession-user">Profession *</span>
<select id="pre_profession">
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
<script>
    var sousPreCategories = document.querySelector('#pre_profession');
    sousPreCategories.addEventListener('change', function (e) {
        console.log('change');
        if (e.target.value == 'autre') {
            $('.pre-profession').hide();
            $('.pre-profession-autre').show();
        }
        else{
            $('.pre-profession-autre').hide(); 
            $('.pre-profession').show();
        }
    })
</script>