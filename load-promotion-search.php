<?php
session_start();
include_once './bdd/connexion.php';
if (isset($_SESSION['user'])) {
    $id_session = htmlspecialchars($_SESSION['user']);
    $get_session_user_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                                OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
    if ($get_session_user_query->execute()) {
        $get_session_user_row = $get_session_user_query->fetch(PDO::FETCH_ASSOC);
        $id_user = $get_session_user_row['id_user'];
        $get_historique_query = $conn->prepare("SELECT * FROM recherche_historique WHERE id_user = $id_user AND type_rech = 'promotion' ORDER BY id_r DESC LIMIT 6");
        if ($get_historique_query->execute()) {
            if ($get_historique_query->rowCount() > 0) {
?>
<div class="recherche-historique-option" id="search_promotion_history_option">
    <h4>Historiques de recherche</h4>
    <div id="delete_promotion_search_history">
        <i class="fas fa-trash"></i>
    </div>
</div>
<div class="recherche-tout-historique" id="search_promotion_history">
<?php 
                $h = 0;
                while ($get_historique_row = $get_historique_query->fetch(PDO::FETCH_ASSOC)) {
                $h++;
?>  
    <div id="history_promotion_text_<?php echo $h ?>"><p><?php echo $get_historique_row['text_rech'] ?></p></div>
<?php 
                } 
                if ($get_historique_query->rowCount() == 6) { 
?>
    <div id="show_promotion_history" style="padding:4px 10px;"><i class="fas fa-chevron-down"></i></div>
<?php       
                } 
            }
?>
</div>
<h4>Catégories des promotions</h4>
<?php
        }
        else{
            echo 0;
        }
    }
    else{
        echo 0;
    }
}
else{
?>
<h4>Catégories des promotions</h4>
<?php
}
?>