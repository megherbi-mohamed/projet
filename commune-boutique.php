<?php
include_once './bdd/connexion.php';
$ville = htmlspecialchars($_GET['v']);
?>
<select id="commune_boutique">
    <?php 
    $commune_query = "SELECT * FROM communes WHERE ville = '$ville'";
    $commune_result = mysqli_query($conn, $commune_query); 
    while ($commune_row = mysqli_fetch_assoc($commune_result)) {
    ?>
    <option value="<?php echo $commune_row['commune'] ?>"><?php echo $commune_row['commune'] ?></option>
    <?php } ?>
</select>