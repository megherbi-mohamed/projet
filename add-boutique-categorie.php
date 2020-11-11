<?php 
include_once './bdd/connexion.php';
$id_session_btq = htmlspecialchars($_POST['id_btq']);
$get_session_btq_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session_btq' OR id_user_1 = '$id_session_btq' OR id_user_2 = '$id_session_btq' 
                                            OR id_user_3 = '$id_session_btq' OR id_user_4 = '$id_session_btq' OR id_user_5 = '$id_session_btq'");
$get_session_btq_query->execute();
$get_session_btq_row = $get_session_btq_query->fetch(PDO::FETCH_ASSOC);
$id_btq = $get_session_btq_row['id_user'];
$categorie_length = htmlspecialchars($_POST['categorie_length']);
for ($i = 1; $i <= $categorie_length; $i++) {
    $categorie =  $_POST['nom_categorie_'.$i];
    $insrt_ctq_query = "INSERT INTO boutique_categorie (id_btq,nom_categorie) VALUES ('$id_btq','$categorie')";
    if(mysqli_query($conn,$insrt_ctq_query)){
        $get_btq_ctg_query = "SELECT * FROM boutique_categorie WHERE id_btq = $id_btq";
        $get_btq_ctg_result = mysqli_query($conn,$get_btq_ctg_query);
        $i=0;
        while ($get_btq_ctg_row = mysqli_fetch_assoc($get_btq_ctg_result)) {
        $i++;
?>
<div class="gerer-boutique-categorie">
    <input type="hidden" id="id_categorie_<?php echo $i ?>" value="<?php echo $get_btq_ctg_row['id_c'] ?>">
    <div class="categorie-logo">
        <h4><?php echo $get_btq_ctg_row['nom_categorie'][0]?></h4> 
    </div>
    <p><?php echo $get_btq_ctg_row['nom_categorie']?></p>
    <i id="display_ctg_options_<?php echo $i ?>" class="fas fa-ellipsis-h"></i>
    <div class="categorie-options" id="categorie_options_<?php echo $i ?>">
        <div class="categorie-option" id="update_categorie_<?php echo $i ?>">
            <i class="fas fa-pen"></i>
            <div>
                <p>Modifer la categorie</p>
            </div>
        </div>
        <div class="categorie-option" id="delete_categorie_<?php echo $i ?>">
            <i class="fas fa-trash"></i>
            <div>
                <p>Supprimer la categorie</p>
            </div>
        </div>  
    </div>
</div>
<?php
        }
    }else{
        echo 0;
    }
}
?>