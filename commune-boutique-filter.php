<?php
include_once './bdd/connexion.php';
$ville = htmlspecialchars($_GET['v']);
?>
<p>Commune</p>
<select id="commune_boutique">
    <option value="">Commune</option>
    <?php 
    $commune_query = $conn->prepare("SELECT * FROM communes WHERE ville = '$ville'");
    $commune_query->execute();
    while ($commune_row = $commune_query->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <option value="<?php echo $commune_row['commune'] ?>"><?php echo $commune_row['commune'] ?></option>
    <?php } ?>
</select>