<?php
include_once './bdd/connexion.php';
$ville = htmlspecialchars($_GET['v']);
?>
<select id="commune_evn">
    <?php 
    $commune_query = $conn->prepare("SELECT * FROM communes WHERE ville = '$ville'");
    $commune_query->execute();
    while ($commune_row = $commune_query->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <option value="<?php echo $commune_row['commune'] ?>"><?php echo $commune_row['commune'] ?></option>
    <?php } ?>
</select>
<span class="lieu-evn active-evenement-span">Commune *</span>