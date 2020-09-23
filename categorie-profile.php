<?php
include_once './bdd/connexion.php';
$categorie = htmlspecialchars($_GET['c']);
?>
<span class="pre-profession-user">Profession *</span>
<select id="pre_profession">
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