<?php
session_start();
include_once './bdd/connexion.php';

$type = $_GET['type'];
$ville = $_GET['ville'];
$profession = $_GET['profession'];
$sexe = $_GET['sexe'];
$text = $_GET['recherche_text'];

if ($type != '' && $ville != '' && $profession != '' && $sexe != '' && $text == '') {
    $recrtm_query = "SELECT * FROM recrutements WHERE type = '$type' AND ville = '$ville' AND profession = '$profession' AND sexe = '$sexe'";
    $recrtm_result = mysqli_query($conn, $recrtm_query);
}
if ($type != '' && $ville != '' && $profession != '' && $sexe == '' && $text == '') {
    $recrtm_query = "SELECT * FROM recrutements WHERE type = '$type' AND ville = '$ville' AND profession = '$profession'";
    $recrtm_result = mysqli_query($conn, $recrtm_query);
}
if ($type != '' && $ville != '' && $profession == '' && $sexe != '' && $text == '') {
    $recrtm_query = "SELECT * FROM recrutements WHERE type = '$type' AND ville = '$ville' AND sexe = '$sexe'";
    $recrtm_result = mysqli_query($conn, $recrtm_query);
}
if ($type != '' && $ville != '' && $profession == '' && $sexe == '' && $text == '') {
    $recrtm_query = "SELECT * FROM recrutements WHERE type = '$type' AND ville = '$ville'";
    $recrtm_result = mysqli_query($conn, $recrtm_query);
}
if ($type != '' && $ville == '' && $profession != '' && $sexe != '' && $text == '') {
    $recrtm_query = "SELECT * FROM recrutements WHERE type = '$type' AND profession = '$profession' AND sexe = '$sexe'";
    $recrtm_result = mysqli_query($conn, $recrtm_query);
} 
if ($type != '' && $ville == '' && $profession != '' && $sexe == '' && $text == '') {
    $recrtm_query = "SELECT * FROM recrutements WHERE type = '$type' AND profession = '$profession'";
    $recrtm_result = mysqli_query($conn, $recrtm_query);
}
if ($type != '' && $ville == '' && $profession == '' && $sexe != '' && $text == '') {
    $recrtm_query = "SELECT * FROM recrutements WHERE type = '$type' AND sexe = '$sexe'";
    $recrtm_result = mysqli_query($conn, $recrtm_query);
}
if ($type == '' && $ville != '' && $profession == '' && $sexe != '' && $text == '') {
    $recrtm_query = "SELECT * FROM recrutements WHERE ville = '$ville' AND sexe = '$sexe'";
    $recrtm_result = mysqli_query($conn, $recrtm_query);
}
if ($type != '' && $ville == '' && $profession == '' && $sexe == '' && $text == '') {
    $recrtm_query = "SELECT * FROM recrutements WHERE type = '$type'";
    $recrtm_result = mysqli_query($conn, $recrtm_query);
}
if ($type == '' && $ville == '' && $profession == '' && $sexe != '' && $text == '') {
    $recrtm_query = "SELECT * FROM recrutements WHERE sexe = '$sexe'";
    $recrtm_result = mysqli_query($conn, $recrtm_query);
}
if ($type == '' && $ville == '' && $profession != '' && $sexe == '' && $text == '') {
    $recrtm_query = "SELECT * FROM recrutements WHERE profession = '$profession'";
    $recrtm_result = mysqli_query($conn, $recrtm_query);
}
if ($type == '' && $ville != '' && $profession == '' && $sexe == '' && $text == '') {
    $recrtm_query = "SELECT * FROM recrutements WHERE ville = '$ville'";
    $recrtm_result = mysqli_query($conn, $recrtm_query);
}
if ($type == '' && $ville == '' && $profession != '' && $sexe != '' && $text == '') {
    $recrtm_query = "SELECT * FROM recrutements WHERE profession = '$profession' AND sexe = '$sexe'";
    $recrtm_result = mysqli_query($conn, $recrtm_query);
}
if ($type == '' && $ville != '' && $profession != '' && $sexe != '' && $text == '') {
    $recrtm_query = "SELECT * FROM recrutements WHERE ville = '$ville' AND profession = '$profession' AND sexe = '$sexe'";
    $recrtm_result = mysqli_query($conn, $recrtm_query);
}
if ($type == '' && $ville != '' && $profession != '' && $sexe == '' && $text == '') {
    $recrtm_query = "SELECT * FROM recrutements WHERE ville = '$ville' AND profession = '$profession'";
    $recrtm_result = mysqli_query($conn, $recrtm_query);
}
if ($type == '' && $ville == '' && $profession == '' && $sexe == '' && $text != '') {
    $recrtm_query = "SELECT * FROM recrutements WHERE profession LIKE '%$text%' OR type LIKE '%$text%' OR titre LIKE '%$text%' OR ville LIKE '%$text%'";
    $recrtm_result = mysqli_query($conn, $recrtm_query);
}
if ($type == '' && $ville == '' && $profession == '' && $sexe == '' && $text == '') {
    $recrtm_query = "SELECT * FROM recrutements";
    $recrtm_result = mysqli_query($conn, $recrtm_query);
}

?>

<?php while($recrtm_row = mysqli_fetch_assoc($recrtm_result)){ 
    $user_query = "SELECT * FROM utilisateurs WHERE id_user = {$recrtm_row['id_user']}";
    $user_result = mysqli_query($conn, $user_query);
    $user_row = mysqli_fetch_assoc($user_result);
?>
<div class="filtre-result" id="filtre_result">
    <div class="filtre-result-top">
        <img src="./<?php echo $user_row['img_user']; ?>" alt="">
        <div>
            <h4><?php echo $recrtm_row['titre']; ?></h4>
            <p><?php echo $user_row['nom_user'];?></p>
        </div>
        <?php if ($recrtm_row['type'] == 'offre') { ?>
            <a href="./offre.php?r=<?php echo $recrtm_row['id_recrtm']; ?>">Voire plus ..</a>
        <?php }else{ ?>
            <a href="./demande.php?r=<?php echo $recrtm_row['id_recrtm']; ?>">Voire plus ..</a>
        <?php } ?>
    </div>
    <div class="filtre-result-bottom">
        <p><i class="fas fa-map-marker-alt"></i><?php echo $recrtm_row['ville'].', Algérie'; ?></p>
        <p><i class="far fa-clock"></i><?php echo $recrtm_row['date']; ?></p>
        <p><i class="fas fa-briefcase"></i><?php echo $recrtm_row['profession']; ?></p>
    </div>
</div>
<?php }?>