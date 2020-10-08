<?php 
session_start();
include_once './bdd/connexion.php';
if (!empty($_GET['id_btq'])) {
    $id_btq = htmlspecialchars($_GET['id_btq']);
    $get_btq_ctg_query = $conn->prepare("SELECT * FROM boutique_categorie WHERE id_btq = $id_btq");
    $get_btq_ctg_query->execute();
    $i=0;
    while ($get_btq_ctg_row = $get_btq_ctg_query->fetch(PDO::FETCH_ASSOC)) {
    $i++;
?>
<div class="gerer-boutique-categorie">
    <input type="hidden" id="id_categorie_<?php echo $i ?>" value="<?php echo $get_btq_ctg_row['id_c'] ?>">
    <input type="hidden" id="nom_categorie_<?php echo $i ?>" value="<?php echo $get_btq_ctg_row['nom_categorie'] ?>">
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
<?php }} ?>