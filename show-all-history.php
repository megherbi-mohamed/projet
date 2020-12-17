<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_user_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
if ($get_session_user_query->execute()) {
    $get_session_user_row = $get_session_user_query->fetch(PDO::FETCH_ASSOC);
    $id_user = $get_session_user_row['id_user'];
    $type_recherche = htmlspecialchars($_POST['type_recherche']);
    $get_history_query = $conn->prepare("SELECT * FROM recherche_historique WHERE id_user = $id_user AND type_rech = '$type_recherche' ORDER BY id_r DESC");
    if ($get_history_query->execute()) {
        if ($type_recherche == 'tout') {
            $h = 0;
            while ($get_history_row = $get_history_query->fetch(PDO::FETCH_ASSOC)) {
            $h++;
?>  
<div id="history_all_text_<?php echo $h ?>"><p><?php echo $get_history_row['text_rech'] ?></p></div>
<?php 
            }
        }
        else if ($type_recherche == 'professionnel') {
            $h = 0;
            while ($get_history_row = $get_history_query->fetch(PDO::FETCH_ASSOC)) {
            $h++;    
?>
<div id="history_professionnel_text_<?php echo $h ?>"><p><?php echo $get_history_row['text_rech'] ?></p></div>
<?php
            }
        }
        else if ($type_recherche == 'boutique') {
            $h = 0;
            while ($get_history_row = $get_history_query->fetch(PDO::FETCH_ASSOC)) {
            $h++;    
?>
<div id="history_boutique_text_<?php echo $h ?>"><p><?php echo $get_history_row['text_rech'] ?></p></div>
<?php
            }
        }
        else if ($type_recherche == 'produit') {
            $h = 0;
            while ($get_history_row = $get_history_query->fetch(PDO::FETCH_ASSOC)) {
            $h++;    
?>
<div id="history_product_text_<?php echo $h ?>"><p><?php echo $get_history_row['text_rech'] ?></p></div>
<?php
            }
        }
        else if ($type_recherche == 'boutdechantier') {
            $h = 0;
            while ($get_history_row = $get_history_query->fetch(PDO::FETCH_ASSOC)) {
            $h++;    
?>
<div id="history_boutdechantier_text_<?php echo $h ?>"><p><?php echo $get_history_row['text_rech'] ?></p></div>
<?php
            }
        }
        else if ($type_recherche == 'promotion') {
            $h = 0;
            while ($get_history_row = $get_history_query->fetch(PDO::FETCH_ASSOC)) {
            $h++;    
?>
<div id="history_promotion_text_<?php echo $h ?>"><p><?php echo $get_history_row['text_rech'] ?></p></div>
<?php
            }
        }
        else if ($type_recherche == 'evenement') {
            $h = 0;
            while ($get_history_row = $get_history_query->fetch(PDO::FETCH_ASSOC)) {
            $h++;    
?>
<div id="history_evenement_text_<?php echo $h ?>"><p><?php echo $get_history_row['text_rech'] ?></p></div>
<?php
            }
        }
    }
    else{
        echo 0;
    }
}
else {
    echo 0;
}
?>