<?php 
session_start();
include_once './bdd/connexion.php';
if (!empty($_GET['id_btq'])) {
    $id_btq = htmlspecialchars($_GET['id_btq']);

    $num_btq_msg_query = "SELECT id_msg FROM messages WHERE id_sender = $id_btq AND etat_sender_msg = $id_btq GROUP BY id_recever";    
    $num_btq_msg_result = mysqli_query($conn,$num_btq_msg_query);
    $num_btq_msg_row = mysqli_num_rows($num_btq_msg_result);
    $show_btq_message = '';
    if ($num_btq_msg_row > 0) {
        $show_btq_message = 'style="display:block"';
    }

$get_btq_ctg_query = "SELECT * FROM boutique_categorie WHERE id_btq = $id_btq";
$get_btq_ctg_result = mysqli_query($conn,$get_btq_ctg_query);
$i=0;
while ($get_btq_ctg_row = mysqli_fetch_assoc($get_btq_ctg_result)) {
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