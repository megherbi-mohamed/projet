<?php 
session_start();
include_once './bdd/connexion.php';
if (isset($_SESSION['user'])) {
    $id_session = htmlspecialchars($_SESSION['user']);
    $get_session_id_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
    $get_session_id_query->execute();
    $get_session_id_row = $get_session_id_query->fetch(PDO::FETCH_ASSOC);
    $user_session_query = $conn->prepare("SELECT * FROM utilisateurs WHERE id_user = {$get_session_id_row['id_user']}");
    $user_session_query->execute();
    if ($user_session_query->rowCount() > 0) {
        $row = $user_session_query->fetch(PDO::FETCH_ASSOC);
        $id_user = $row['id_user'];
    }
    else{
        header('Location: inscription-connexion');
    }

    if (isset($_GET['btq'])) {
        $id_session_btq = htmlspecialchars($_GET['btq']);
        $get_btq_id_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session_btq' OR id_user_1 = '$id_session_btq' OR id_user_2 = '$id_session_btq' 
                                                OR id_user_3 = '$id_session_btq' OR id_user_4 = '$id_session_btq' OR id_user_5 = '$id_session_btq'");
        $get_btq_id_query->execute();
        $get_btq_id_row = $get_btq_id_query->fetch(PDO::FETCH_ASSOC);
        $btq_session_query = $conn->prepare("SELECT * FROM boutiques WHERE id_btq = {$get_btq_id_row['id_user']}");
        $btq_session_query->execute();
        if ($btq_session_query->rowCount() > 0) {
            $btq_inf_row = $btq_session_query->fetch(PDO::FETCH_ASSOC);
            $uid = $id_session_btq;
            $id_btq = $btq_inf_row['id_btq'];
            
            if ($btq_inf_row['id_createur'] !== $id_user) {
                header('Location: http://localhost/projet/utilisateur/'.$id_session);
                exit;
            }
        }
        else{
            header('Location: http://localhost/projet/utilisateur/'.$id_session);
            exit;
        }

        $num_btq_msg_query = $conn->prepare("SELECT id_msg FROM messages WHERE id_sender = $id_btq AND etat_sender_msg = $id_btq GROUP BY id_recever");    
        $num_btq_msg_query->execute();
        $num_btq_msg_num = $num_btq_msg_query->rowCount();
        $show_btq_message = '';
        if ($num_btq_msg_num > 0) {
            $show_btq_message = 'style="display:block"';
        }

        $num_btq_ntf_query = $conn->prepare("SELECT id_ntf FROM publications_notifications WHERE id_recever_ntf = $id_btq AND etat_ntf = 1 AND id_sender_ntf != $id_btq");    
        $num_btq_ntf_query->execute();
        $num_btq_ntf_num = $num_btq_ntf_query->rowCount();
        $show_btq_notification = '';
        if ($num_btq_ntf_num > 0) {
            $show_btq_notification = 'style="display:block"';
        }
    }
    else{
        header('Location: http://localhost/projet/utilisateur/'.$id_session);
        exit;
    }
}
else if (isset($_SESSION['btq'])) {
    if (isset($_GET['btq'])) {
        if ($_SESSION['btq'] == $_GET['btq']){
            $id_session_btq = htmlspecialchars($_SESSION['btq']);
            $get_btq_id_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session_btq' OR id_user_1 = '$id_session_btq' OR id_user_2 = '$id_session_btq' 
                                                    OR id_user_3 = '$id_session_btq' OR id_user_4 = '$id_session_btq' OR id_user_5 = '$id_session_btq'");
            $get_btq_id_query->execute();
            $get_btq_id_row = $get_btq_id_query->fetch(PDO::FETCH_ASSOC);
            $btq_session_query = $conn->prepare("SELECT * FROM boutiques WHERE id_btq = {$get_session_id_row['id_user']}");
            $btq_session_query->execute();
            if ($btq_session_query->rowCount() > 0) {
                $btq_inf_row = $btq_session_query->fetch(PDO::FETCH_ASSOC);
                $uid = $id_session_btq;
                $id_btq = $btq_inf_row['id_btq'];
            }
            else{
                header('Location: http://localhost/projet/gestion-boutique-connexion');
                exit;
            }
        }

        $num_btq_msg_query = $conn->prepare("SELECT id_msg FROM messages WHERE id_sender = $id_btq AND etat_sender_msg = $id_btq GROUP BY id_recever");    
        $num_btq_msg_query->execute();
        $num_btq_msg_num = $num_btq_msg_query->rowCount();
        $show_btq_message = '';
        if ($num_btq_msg_num > 0) {
            $show_btq_message = 'style="display:block"';
        }

        $num_btq_ntf_query = $conn->prepare("SELECT id_ntf FROM publications_notifications WHERE id_recever_ntf = $id_btq AND etat_ntf = 1 AND id_sender_ntf != $id_btq");    
        $num_btq_ntf_query->execute();
        $num_btq_ntf_num = $num_btq_ntf_query->rowCount();
        $show_btq_notification = '';
        if ($num_btq_ntf_num > 0) {
            $show_btq_notification = 'style="display:block"';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/projet/" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css-js/style.css">
    <link rel="stylesheet" href="css-js/gerer-boutique.css">
    <link rel="stylesheet" href="css-js/croppie.css">
    <link href="css-js/fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fugaz One">
    <title>Gerer bouique</title>
</head>
<body>
    <?php include './navbar.php'; ?>
    <div class="clear"></div>
    <div class="gerer-boutique-recherche-responsive">
        <div class="gerer-boutique-recherche-responsive-container">
            <div class="show-hide-menu" id="show_hide_menu">
                <i class="fas fa-bars"></i>
            </div>
            <div id="back_menu">
                <i class="fas fa-arrow-left"></i>
            </div>
            <div id="gerer_boutique_recherche_responsive">
                <input type="text" id="recherche_text_resp" placeholder="Chercher un produit ..." autocomplete="off">
                <i class="fas fa-search"></i>
            </div>
            <div class="logo-name">
                <h4>Nhannik</h4>
            </div>
            <div id="display_gb_manager_resp">
                <i class="fas fa-cog"></i>
            </div>
            <div id="display_gb_search_bar">
                <i class="fas fa-search"></i>
            </div>
        </div>
    </div>
    <div class="gerer-boutique-left">
        <h2>Gerer vos boutiques</h2>
        <div class="gerer-boutique-recherche">
            <input type="text" id="recherche_text" placeholder="Chercher un produit ..." autocomplete="off">
            <i class="fas fa-search"></i>
        </div>
        <hr>
        <div class="gb-messages-notifications">
            <?php 
            if (isset($_SESSION['btq']) && $get_btq_auth_row['messagerie'] == 1) {
            ?>
            <div class="gb-messages" id="display_gb_messagerie">
                <div>
                    <i class="fab fa-facebook-messenger"></i>
                </div>
                <p>Messages</p>
                <div class="btq-new-msg">
                    <div id="btq_new_msg" <?php echo $show_btq_message ?>>
                        <span><?php echo $num_btq_msg_num; ?></span>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php 
            if (isset($_SESSION['user'])) {
            ?>
            <div class="gb-messages" id="display_gb_messagerie">
                <div>
                    <i class="fab fa-facebook-messenger"></i>
                </div>
                <p>Messages</p>
                <div class="btq-new-msg">
                    <div id="btq_new_msg" <?php echo $show_btq_message ?>>
                        <span><?php echo $num_btq_msg_num; ?></span>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php 
            if (isset($_SESSION['btq']) && $get_btq_auth_row['notifications'] == 1) {
            ?>
            <div class="gb-notifications" id="display_gb_notifications">
                <div>
                    <i class="fas fa-bell"></i>
                </div>
                <p>Notifications</p>
                <div class="btq-new-ntf">
                    <div id="btq_new_ntf" <?php echo $show_btq_notification ?>>
                        <span><?php echo $num_btq_ntf_num; ?></span>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php 
            if (isset($_SESSION['user'])) {
            ?>
            <div class="gb-notifications" id="display_gb_notifications">
                <div>
                    <i class="fas fa-bell"></i>
                </div>
                <p>Notifications</p>
                <div class="btq-new-ntf">
                    <div id="btq_new_ntf" <?php echo $show_btq_notification ?>>
                        <span><?php echo $num_btq_ntf_num; ?></span>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php 
            if (isset($_SESSION['btq']) && $get_btq_auth_row['modification'] == 1) {
            ?>
            <div class="gb-update" id="display_gb_informations">
                <div>
                    <i class="fas fa-cog"></i>
                </div>
                <p>Modifier la boutique</p>
            </div>
            <?php } ?>
            <?php 
            if (isset($_SESSION['user'])) {
            ?>
            <div class="gb-update" id="display_gb_informations">
                <div>
                    <i class="fas fa-cog"></i>
                </div>
                <p>Modifier la boutique</p>
            </div>
            <div class="gb-admin" id="create_gb_admin">
                <div>
                    <i class="fas fa-user-cog"></i>
                    <!-- <i class="fas fa-user-lock"></i> -->
                </div>
                <p>Admin boutique</p>
            </div>
            <?php } ?>
        </div>
        <input type="hidden" id="id_boutique_product" value="<?php echo $id_session_btq ?>">
        <div class="gb-options">
            <?php 
            if (isset($_SESSION['btq']) && $get_btq_auth_row['creation_prd'] == 1) {
            ?>
            <button id="create_prd_button">
                <i class="fas fa-plus"></i>
                Créer un produit
            </button>
            <?php } ?>
            <?php 
            if (isset($_SESSION['user'])) {
            ?>
            <button id="create_prd_button">
                <i class="fas fa-plus"></i>
                Créer un produit
            </button>
            <?php } ?>
            <?php 
            if (isset($_SESSION['btq']) && $get_btq_auth_row['creation_ctg'] == 1) {
            ?>
            <button id="create_ctgr_button">
                <i class="fas fa-plus"></i>
                Créer une catégorie
            </button>
            <?php } ?>
            <?php 
            if (isset($_SESSION['user'])) {
            ?>
            <button id="create_ctgr_button">
                <i class="fas fa-plus"></i>
                Créer une catégorie
            </button>
            <button id="delete_btq_button">
                <i class="fas fa-trash"></i>
                Supprimer la boutique
            </button>
            <?php } ?>
        </div>
        <hr>
        <?php 
        if (isset($_SESSION['btq'])) {
        ?>
        <div class="gerer-boutique-list-boutique">
           <h3>boutique</h3>
           <input type="hidden" id="id_gb_btq_<?php echo $i ?>" value="<?php echo $get_btq_row['id_btq'] ?>">
           <div class="gerer-boutique-boutique" id="gerer_boutique_boutique_<?php echo $i ?>">
               <?php if ($get_btq_row['logo_btq'] != '') { ?>
                   <img src="./<?php echo $get_btq_row['logo_btq'] ?>" alt="">
               <?php }else if($get_btq_row['logo_btq'] == ''){ ?>
                   <img src="./boutique-logo/logo.png" alt="">
               <?php } ?>
               <h4><?php echo $get_btq_row['nom_btq'] ?></h4>
           </div>
        </div>
        <?php } ?>
        <?php 
        if (isset($_SESSION['user'])) {
        ?>
        <div class="gerer-boutique-list-boutique">
            <h3>Vos boutiques</h3>
            <?php 
                $get_list_btq_query = $conn->prepare("SELECT * FROM boutiques WHERE id_createur = $id_user");
                $get_list_btq_query->execute();
                $i=0;
                while($get_list_btq_row = $get_list_btq_query->fetch(PDO::FETCH_ASSOC)){
                $i++;
            ?>
            <input type="hidden" id="id_gb_btq_<?php echo $i ?>" value="<?php echo $get_list_btq_row['id_btq'] ?>">
            <div class="gerer-boutique-boutique" id="gerer_boutique_boutique_<?php echo $i ?>">
                <?php if ($get_list_btq_row['logo_btq'] != '') { ?>
                    <img src="./<?php echo $get_list_btq_row['logo_btq'] ?>" alt="">
                <?php }else if($get_list_btq_row['logo_btq'] == ''){ ?>
                    <img src="./boutique-logo/logo.png" alt="">
                <?php } ?>
                <h4><?php echo $get_list_btq_row['nom_btq'] ?></h4>
            </div>
            <?php } ?>
        </div>
        <?php } ?>
        <hr>
        <div class="gerer-boutique-categories">
            <div class="gerer-boutique-categorie-top">
                <h3>Boutique catégories</h3>
            </div>
            <div class="gerer-boutique-categorie-bottom">
                <?php 
                $get_btq_ctg_query = $conn->prepare("SELECT * FROM boutique_categorie WHERE id_btq = {$btq_inf_row['id_btq']}");
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
                        <?php 
                        if (isset($_SESSION['btq']) && $get_btq_auth_row['modification_ctg'] == 1) {
                        ?>    
                        <div class="categorie-option" id="update_categorie_<?php echo $i ?>">
                            <i class="fas fa-pen"></i>
                            <div>
                                <p>Modifer la categorie</p>
                            </div>
                        </div>
                        <?php } ?>
                        <?php 
                        if (isset($_SESSION['user'])) {
                        ?>
                        <div class="categorie-option" id="update_categorie_<?php echo $i ?>">
                            <i class="fas fa-pen"></i>
                            <div>
                                <p>Modifer la categorie</p>
                            </div>
                        </div>
                        <?php } ?>
                        <?php 
                        if (isset($_SESSION['btq']) && $get_btq_auth_row['suppression_ctg'] == 1) {
                        ?>  
                        <div class="categorie-option" id="delete_categorie_<?php echo $i ?>">
                            <i class="fas fa-trash"></i>
                            <div>
                                <p>Supprimer la categorie</p>
                            </div>
                        </div>  
                        <?php } ?>
                        <?php 
                        if (isset($_SESSION['user'])) {
                        ?>
                        <div class="categorie-option" id="delete_categorie_<?php echo $i ?>">
                            <i class="fas fa-trash"></i>
                            <div>
                                <p>Supprimer la categorie</p>
                            </div>
                        </div> 
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="categorie-options-resp">
        <input type="hidden" id="id_categorie_resp">
        <input type="hidden" id="nom_categorie_resp">
        <div class="categorie-option" id="update_categorie_resp">
            <i class="fas fa-pen"></i>
            <div>
                <p>Modifer la categorie</p>
            </div>
        </div>
        <div class="categorie-option" id="delete_categorie_resp">
            <i class="fas fa-trash"></i>
            <div>
                <p>Supprimer la categorie</p>
            </div>
        </div>  
    </div>
    <div class="gerer-boutique-right">
        <div class="boutique-container">
            <div class="boutique-top">
                <div class="boutique-couverture-logo">
                    <div class="boutique-couverture">
                    <?php if ($btq_inf_row['couverture_btq'] != '') { ?>
                        <img id="couverture_img" src="./<?php echo $btq_inf_row['couverture_btq'] ?>" alt="">
                    <?php }else if($btq_inf_row['couverture_btq'] == ''){ ?>
                        <img id="couverture_img" src="./boutique-couverture/couverture.png" alt="">
                    <?php } ?>
                    <div class="couverture-modification-icon" id="update_boutique_couverture">
                        <i class="fas fa-camera"></i>
                    </div>
                    </div>
                    <div class="boutique-logo">
                    <?php if ($btq_inf_row['logo_btq'] != '') { ?>
                        <img src="./<?php echo $btq_inf_row['logo_btq'] ?>" alt="">
                    <?php }else if($btq_inf_row['logo_btq'] == ''){ ?>
                        <img src="./boutique-logo/logo.png" alt="">
                    <?php } ?>
                    <div class="logo-modification-icon" id="update_boutique_logo">
                        <i class="fas fa-camera"></i>
                    </div>
                    </div>
                </div>
                <div class="boutique-options">
                    <a href="boutique/<?php echo $btq_inf_row['id_btq'] ?>">Voir en tant que visiteur</a>
                    <h3><?php echo $btq_inf_row['nom_btq'] ?></h3>
                </div>   
            </div>
            <div class="boutique-bottom">
            <?php 
            $get_product_query = $conn->prepare("SELECT * FROM produit_boutique WHERE id_btq = '{$btq_inf_row['id_btq']}' ORDER BY id_prd DESC");
            $get_product_query->execute();
            $i = 0;
            while ($get_product_row = $get_product_query->fetch(PDO::FETCH_ASSOC)){
            $i++;
            $get_product_media_query = $conn->prepare("SELECT * FROM produits_media WHERE id_prd = '{$get_product_row['id_prd']}' LIMIT 1");
            $get_product_media_query->execute();
            $get_product_media_row = $get_product_media_query->fetch(PDO::FETCH_ASSOC);
            ?>
            <input type="hidden" id="id_prd_<?php echo $i ?>" value="<?php echo $get_product_row['id_prd'] ?>">
            <input type="hidden" id="product_tail_<?php echo $i ?>" value="<?php echo $i ?>">
            <input type="hidden" id="name_prd_<?php echo $i ?>" value="<?php echo $get_product_row['nom_prd'] ?>">
            <input type="hidden" id="reference_prd_<?php echo $i ?>" value="<?php echo $get_product_row['reference_prd'] ?>">
            <input type="hidden" id="categorie_prd_<?php echo $i ?>" value="<?php echo $get_product_row['categorie_prd'] ?>">
            <input type="hidden" id="description_prd_<?php echo $i ?>" value="<?php echo $get_product_row['description_prd'] ?>">
            <input type="hidden" id="quantity_prd_<?php echo $i ?>" value="<?php echo $get_product_row['quantite_prd'] ?>">
            <input type="hidden" id="price_prd_<?php echo $i ?>" value="<?php echo $get_product_row['prix_prd'] ?>">
            <div class="boutique-product" id="boutique_product_<?php echo $i ?>">
                <div class="product-option-button" id="display_prd_options_button_<?php echo $i ?>">
                    <i class="fas fa-ellipsis-v"></i>
                </div>
                <div class="product-options" id="product_options_<?php echo $i ?>">
                    <div class="product-option" id="update_product_<?php echo $i ?>">
                        <i class="fas fa-pen"></i>
                        <div>
                            <p>Modifer le produit</p>
                        </div>
                    </div>
                    <div class="product-option" id="delete_product_<?php echo $i ?>">
                        <i class="fas fa-trash"></i>
                        <div>
                            <p>Supprimer le produit</p>
                        </div>
                    </div>
                </div>
                <div class="boutique-product-img">
                    <img src="<?php echo $get_product_media_row['media_url'] ?>" alt="">
                </div>
                <div class="product-description">
                    <div class="product-description-top">
                        <p><?php echo $get_product_row['description_prd'] ?></p>
                    </div>
                    <div class="product-description-bottom">
                        <h4><?Php echo $get_product_row['prix_prd'].' DA' ?></h4>
                        <!-- <button id="display_product_details_<?php echo $i ?>">Details</button> -->
                    </div>
                </div>
            </div>
            <?php } ?>
            </div>
        </div>
        <div id="loader_gb_right" class="center-gb-right"></div>
    </div>
    <!-- create product boutique -->
    <div class="create-product" id="create_product">
        <div class="create-product-container">
            <input type="hidden" id="id_product">
            <div class="create-product-top">
                <div class="cancel-create-product-mobile" id="cancel_create_product_resp">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <h4>Créer un produit a vendre!</h4>
                <div class="cancel-create-product" id="cancel_create_product">
                    <i class="fas fa-times"></i>
                </div>
                <button id="crt_prd_btn_resp">Créer</button>
            </div>
            <div class="create-product-bottom">
                <div class="product-input">
                    <input type="text" id="name_product" autocomplete = "off">
                    <span class="name-product">Nom *</span>
                </div>
                <div class="product-input">
                    <input type="text" id="reference_product" autocomplete = "off">
                    <span class="reference-product">Reference *</span>
                </div>
                <div class="product-input">
                    <input type="text" id="categorie_product" autocomplete = "off">
                    <span class="categorie-product">Categorie *</span>
                </div>
                <div class="product-input">
                    <input type="text" id="description_product" autocomplete = "off">
                    <span class="description-product">Description *</span>
                </div>
                <div class="product-input">
                    <input type="text" id="caracteristique_product" autocomplete = "off">
                    <span class="caracteristique-product">Caractéristiques</span>
                </div>
                <div class="product-input">
                    <input type="text" id="fonctionnalite_product" autocomplete = "off">
                    <span class="fonctionnalite-product">Fonctionnalités</span>
                </div>
                <div class="product-input">
                    <input type="text" id="avantage_product" autocomplete = "off">
                    <span class="avantage-product">Avantages</span>
                </div>
                <div class="product-input">
                    <input type="text" id="quantity_product" autocomplete = "off">
                    <span class="quantity-product">Quantite *</span>
                </div>
                <div class="product-input">
                    <input type="text" id="price_product" autocomplete = "off">
                    <span class="price-product">Prix *</span>
                </div>
                <div class="product-images-preview"></div>
                <div class="create-product-options">
                    <P>Ajouter des photos du produit</P>
                    <div id="add_product_image">
                        <i class="far fa-images"></i>
                    </div>
                </div>
                <form enctype="multipart/form-data">
                    <input type="file" id="image_prd" name="images_prd[]" accept="image/*" multiple>
                    <input type="button" id="add_product_image_button">
                </form>
                <button id="create_product_button">Créer</button>
            </div>
            <div id="loader_load" class="center-load"></div>
        </div>
    </div>
    <!-- update product boutique -->
    <div class="update-product" id="update_product">
        <div class="update-product-container">
            <div class="update-product-top">
                <div class="cancel-update-product-mobile" id="cancel_update_product_resp">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <h4>Modifier le produit</h4>
                <div class="cancel-update-product" id="cancel_update_product">
                    <i class="fas fa-times"></i>
                </div>
                <button id="update_product_button_resp">Modifier</button>
            </div>
            <div class="update-product-bottom">
                <input type="hidden" id="id_product_updt">
                <input type="hidden" id="product_tail_updt">
                <div class="product-input">
                    <input type="text" id="updt_name_product" placeholder="Titre">
                    <span>Nom *</span>
                </div>
                <div class="product-input">
                    <input type="text" id="updt_refernce_product" placeholder="Categorie">
                    <span>Reference *</span>
                </div>
                <div class="product-input">
                    <input type="text" id="updt_categorie_product" placeholder="Categorie">
                    <span>Categorie *</span>
                </div>
                <div class="product-input">
                    <input type="text" id="updt_description_product" placeholder="Description">
                    <span>Description *</span>
                </div>
                <div class="product-input">
                    <input type="text" id="updt_caracteristique_product" placeholder="Description">
                    <span>Caractéristiques</span>
                </div>
                <div class="product-input">
                    <input type="text" id="updt_fonctionnalite_product" placeholder="Description">
                    <span>Fonctionnalités</span>
                </div>
                <div class="product-input">
                    <input type="text" id="updt_avantage_product" placeholder="Description">
                    <span>Avantages</span>
                </div>
                <div class="product-input">
                    <input type="text" id="updt_quantity_product" placeholder="Quantité">
                    <span>Quantite *</span>
                </div>
                <div class="product-input">
                    <input type="text" id="updt_price_product" placeholder="Prix">
                    <span>prix *</span>
                </div>
                <div class="product-update-images-preview"></div>
                <div class="update-product-options">
                    <P>Ajouter des photos du produit</P>
                    <div id="update_product_image">
                        <i class="far fa-images"></i>
                    </div>
                </div>
                <form enctype="multipart/form-data">
                    <input type="file" id="image_prd_updt" name="images_prd_updt[]" accept="image/*" multiple>
                    <input type="button" id="update_product_image_button">
                </form>
                <button id="update_product_button">Modifier</button>
            </div>
            <div id="loader_load_updt" class="center-load-updt"></div>
        </div>
    </div>
    <!-- create categorie boutique -->
    <div class="create-categorie" id="create_categorie">
        <div class="create-categorie-container">
            <div class="create-categorie-top">
                <div class="cancel-create-categorie-mobile" id="cancel_create_categorie_resp">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <h4>Créer une catégorie</h4>
                <div class="cancel-create-categorie" id="cancel_create_categorie">
                    <i class="fas fa-times"></i>
                </div>
                <button id="update_categorie_button">Modifier</button>
            </div>
            <div class="create-categorie-bottom">
                <div class="categorie-input">
                    <input type="text" id="nom_categorie_1" placeholder="Nom de catégorie">
                    <div id="add_categorie"><i class="fas fa-plus"></i></div>
                    <span>Categorie</span>
                </div>
                <button id="create_categorie_button">Créer</button>
            </div>
            <div id="loader_load" class="center-load"></div>
        </div>
    </div>
    <!-- update categorie boutique -->
    <div class="update-categorie" id="update_categorie">
        <div class="update-categorie-container" id="update_categorie_container">
            <div class="update-categorie-top">
                <div class="cancel-update-categorie-mobile" id="cancel_update_categorie_resp">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <h4>Modifier la catégorie</h4>
                <div class="cancel-update-categorie" id="cancel_update_categorie">
                    <i class="fas fa-times"></i>
                </div>
                <button id="update_categorie_button">Modifier</button>
            </div>
            <div class="update-categorie-bottom">
                <div class="update-categorie-input">
                    <input type="hidden" id="update_id_categorie">
                    <input type="text" id="update_nom_categorie" placeholder="Nom de catégorie">
                    <span>Categorie</span>
                </div>
                <button id="update_categorie_button">Modifier</button>
            </div>
            <div id="loader_load" class="center-load"></div>
        </div>
    </div>
    <!-- update logo boutique -->
    <div class="boutique-logo-update">
        <div class="boutique-logo-update-container">
            <div class="boutique-logo-update-top">
                <div class="cancel-boutique-logo-update-resp" id="cancel_boutique_logo_update_resp">
                    <i class="fa fa-arrow-left"></i>
                </div>
                <h4>Modifier logo!</h4>
                <div class="cancel-boutique-logo-update" id="cancel_boutique_logo_update">
                    <i class="fas fa-times"></i>
                </div>
                <button class="upload-result-resp">Valider</button>
            </div>
            <div class="panel">
                <div class="row">
                    <div class="image-upload-befor">
                        <div id="upload-demo"></div>
                    </div>
                    <div class="image-upload-option">
                        <button id="find_image_btn">Choissir une image</button>
                        <input type="file" id="upload" accept="image/*">
                        <input type="hidden" id="id_btq_logo" value="<?php echo $btq_inf_row['id_btq'] ?>">
                        <div>
                            <button id="cancel_updt_btq_img_button">Annuler</button>
                            <button class="upload-result">Valider la modification</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="loader_updt_img" class="center"></div>
    </div>
    <!-- update couverture boutique -->
    <div class="boutique-couverture-update">
        <div class="boutique-couverture-update-container">
            <div class="boutique-couverture-update-top">
                <div class="cancel-boutique-couverture-update-resp" id="cancel_boutique_couverture_update_resp">
                    <i class="fa fa-arrow-left"></i>
                </div>
                <h4>Modifier couverture!</h4>
                <div class="cancel-boutique-couverture-update" id="cancel_boutique_couverture_update">
                    <i class="fas fa-times"></i>
                </div>
                <button class="upload-result-couverture-resp">Valider</button>
            </div>
            <div class="panel-couverture">
                <div class="row-couverture">
                    <div class="image-upload-befor">
                        <div id="upload-demo-couverture"></div>
                    </div>
                    <div class="image-upload-option">
                        <button id="find_couverture_btn">Choissir une image</button>
                        <input type="file" id="upload_couverture" accept="image/*">
                        <input type="hidden" id="id_btq_cvrt" value="<?php echo $btq_inf_row['id_btq'] ?>">
                        <div>
                            <button id="cancel_updt_btq_cvrt_button">Annuler</button>
                            <button class="upload-result-couverture">Valider la modification</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="loader_updt_cvrt" class="center"></div>
        </div>
    </div>
    <div class="delete-product" id="delete_product">
        <div class="delete-product-container" id="delete_product_container">
            <input type="hidden" id="product_tail_delete">
            <input type="hidden" id="id_product_delete">
            <div class="delete-product-top">
                <h4>Supprimer le produit ?</h4>
                <div class="cancel-delete-product" id="cancel_delete_product">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="delete-product-middle">
                <p>Voulez vous vraiment Supprimer ce produit ?</p>
            </div>
            <div class="delete-product-bottom">
                <div></div>
                <div></div>
                <button id="cancel_delete_prd_button">Annuler</button>
                <button id="delete_prd_button">Supprimer</button>
            </div>
        </div>
    </div>
    <div class="delete-boutique" id="delete_boutique">
        <div class="delete-boutique-container" id="delete_boutique_container">
            <div class="delete-boutique-top">
                <h4>Supprimer la boutique ?</h4>
                <div class="cancel-delete-boutique" id="cancel_delete_boutique">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="delete-boutique-middle">
                <p>Pour quoi vous voulez Supprimer la boutique ?</p>
                <textarea id="delete_description"></textarea>
            </div>
            <div class="delete-boutique-bottom">
                <div></div>
                <div></div>
                <button id="cancel_delete_btq_button">Annuler</button>
                <button id="delete_boutique_button">Supprimer</button>
            </div>
        </div>
        <div id="loader_delete_btq" class="center"></div>
    </div>
    <div class="gb-delete-alert">
        <p>La suppresion de boutique est en attente de validation par l'administration de NHANNIK!</p>
        <div class="cancel-alert-message">
            <i class="fas fa-times"></i>
        </div>
    </div>
    <div class="delete-categorie" id="delete_categorie">
        <div class="delete-categorie-container" id="delete_categorie_container">
            <input type="hidden" id="id_categorie_delete">
            <div class="delete-categorie-top">
                <h4>Supprimer la categorie ?</h4>
                <div class="cancel-delete-categorie" id="cancel_delete_categorie">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="delete-categorie-middle">
                <p>Voulez vous vraiment Supprimer la categorie ?</p>
            </div>
            <div class="delete-categorie-bottom">
                <div></div>
                <div></div>
                <button id="cancel_delete_ctg_button">Annuler</button>
                <button id="delete_ctg_button">Supprimer</button>
            </div>
        </div>
    </div>
    <div class="product-details">
        <div class="product-details-container"></div>
        <div id="loader_product" class="center-loader-product"></div>
    </div>
    <?php
    $get_senders_query = $conn->prepare("SELECT id_recever,id_sender FROM messages WHERE id_msg IN (SELECT MAX(id_msg) FROM messages WHERE id_recever = '$id_btq' OR id_sender = '$id_btq' GROUP BY msg_cle) ORDER BY id_msg DESC");
    $get_senders_query->execute();
    $get_senders_num = $get_senders_query->rowCount();
    if ($get_senders_num > 0) {
    $get_senders_row = $get_senders_query->fetch(PDO::FETCH_ASSOC);
    if ($get_senders_row['id_sender'] == $id_btq) {
        $last_sender_row = $get_senders_row['id_recever'];
    ?>
    <input type="hidden" id="last_corresponder" value="<?php echo $last_sender_row; ?>">
    <?php } else if ($get_senders_row['id_recever'] == $id_btq){ 
        $last_sender_row = $get_senders_row['id_sender'];
    ?>
    <input type="hidden" id="last_corresponder" value="<?php echo $last_sender_row; ?>">
    <?php }} else { ?>
    <input type="hidden" id="last_corresponder" value="0">
    <?php } ?>
    <input type="hidden" id="type_messagerie" value="boutiqueUser">
    <div id="loader" class="center"></div>
    <!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBEGrApnjX_7GHcNDtF0LR0pgrwxj5j2Q&callback=initBoutiqueMap"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="css-js/main.js"></script>
    <script src="css-js/croppie.js"></script>
    <script>
        document.onreadystatechange = function() { 
            if (document.readyState !== "complete") { 
                document.querySelector("body").style.visibility = "hidden"; 
                document.querySelector("#loader").style.visibility = "visible"; 
            } else { 
                document.querySelector("#loader").style.display = "none"; 
                document.querySelector("body").style.visibility = "visible"; 
                // var idBtq = $('#id_boutique_product').val();
                // history.pushState('boutique','', '/projet/gerer-boutique.php?btq='+idBtq);
                setTimeout(() => {
                    scrolldiv();
                }, 100);
            } 
        };

        // load user new message
        setInterval(() => {
            $('.user-new-msg').load('load-user-new-msg.php');
        }, 2000);
        
        $(window).on('load',function(){
            if (history.state === 'messagerie') {
                hideDivNotfBackg();
                $('#display_gb_messagerie').css('background','#ecedee');
                var fd = new FormData();
                var idBtq = $('#id_boutique_product').val();
                fd.append('id_btq',idBtq);
                var idCrsp = $('#last_corresponder').val();
                $.ajax({
                    url: 'load-boutique-messagerie.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $(".boutique-container").empty();
                        $("#loader_gb_right").show();
                    },
                    success: function(response){
                        if(response != 0){
                            history.replaceState('messagerie','', '/projet/gerer-boutique/'+idBtq+'/'+idCrsp);
                            $('.boutique-container').append(response);
                            scrolldiv();
                        }
                    },
                    complete: function(){
                        $("#loader_gb_right").hide();
                    }
                });
            }
            if(history.state === 'notifications'){
                hideDivNotfBackg();
                $('#display_gb_notifications').css('background','#ecedee');
                var fd = new FormData();
                var idBtq = $('#id_boutique_product').val();
                fd.append('id_btq',idBtq);
                var numNtf = $('#num_ntf').val();
                $.ajax({
                    url: 'load-boutique-notifications.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $(".boutique-container").empty();
                        $("#loader_gb_right").show();
                    },
                    success: function(response){
                        if(response != 0){
                            history.replaceState('notifications','', '/projet/gerer-boutique/'+idBtq+'/notifications');
                            $('.boutique-container').append(response);
                        }
                    },
                    complete: function(){
                        $("#loader_gb_right").hide();
                    }
                });
            }
            if(history.state === 'admin'){
                hideDivNotfBackg();
                $('#create_gb_admin').css('background','#ecedee');
                var fd = new FormData();
                var idBtq = $('#id_boutique_product').val();
                fd.append('id_btq',idBtq);
                $.ajax({
                    url: 'load-boutique-admin.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $(".boutique-container").empty();
                        $("#loader_gb_right").show();
                    },
                    success: function(response){
                        if(response != 0){
                            history.replaceState('admin','', '/projet/gerer-boutique/'+idBtq+'/admin');
                            $('.boutique-container').append(response);
                        }
                    },
                    complete: function(){
                        $("#loader_gb_right").hide();
                    }
                });
            }
            if(history.state === 'boutique'){
                var fd = new FormData();
                var idBtq = $('#id_boutique_product').val();
                fd.append('id_btq',idBtq);
                $.ajax({
                    url: 'load-boutique.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $(".boutique-container").empty();
                        $("#loader_gb_right").show();
                    },
                    success: function(response){
                        if(response != 0){
                            history.replaceState('boutique','', '/projet/gerer-boutique/'+idBtq);
                            $('.boutique-container').append(response);
                            $('#id_boutique_product').val(idBtq);
                        }
                    },
                    complete: function(){
                        $("#loader_gb_right").hide();
                    }
                });
            }
            if(history.state === 'informations'){
                hideDivNotfBackg();
                $('#display_gb_informations').css('background','#ecedee');
                var fd = new FormData();
                var idBtq = $('#id_boutique_product').val();
                fd.append('id_btq',idBtq);
                $.ajax({
                    url: 'load-boutique-informations.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $(".boutique-container").empty();
                        $("#loader_gb_right").show();
                    },
                    success: function(response){
                        if(response != 0){
                            history.replaceState('informations','', '/projet/gerer-boutique/'+idBtq+'/modifications');
                            $('.boutique-container').append(response);
                        }
                    },
                    complete: function(){
                        $("#loader_gb_right").hide();
                    }
                });
            }
        })

        $(window).on('popstate',function(){
            console.log(history.state);
            if (history.state === 'messagerie') {
                hideDivNotfBackg();
                $('#display_gb_messagerie').css('background','#ecedee');
                var fd = new FormData();
                var idBtq = $('#id_boutique_product').val();
                fd.append('id_btq',idBtq);
                var idCrsp = $('#last_corresponder').val();
                $.ajax({
                    url: 'load-boutique-messagerie.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $(".boutique-container").empty();
                        $("#loader_gb_right").show();
                    },
                    success: function(response){
                        if(response != 0){
                            $('.boutique-container').append(response);
                            scrolldiv();
                        }
                    },
                    complete: function(){
                        $("#loader_gb_right").hide();
                    }
                });
            }
            if(history.state === 'notifications'){
                hideDivNotfBackg();
                $('#display_gb_notifications').css('background','#ecedee');
                var fd = new FormData();
                var idBtq = $('#id_boutique_product').val();
                fd.append('id_btq',idBtq);
                $.ajax({
                    url: 'load-boutique-notifications.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $(".boutique-container").empty();
                        $("#loader_gb_right").show();
                    },
                    success: function(response){
                        if(response != 0){
                            $('.boutique-container').append(response);
                        }
                    },
                    complete: function(){
                        $("#loader_gb_right").hide();
                    }
                });
            }
            if(history.state === 'admin'){
                hideDivNotfBackg();
                $('#create_gb_admin').css('background','#ecedee');
                var fd = new FormData();
                var idBtq = $('#id_boutique_product').val();
                fd.append('id_btq',idBtq);
                $.ajax({
                    url: 'load-boutique-admin.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $(".boutique-container").empty();
                        $("#loader_gb_right").show();
                    },
                    success: function(response){
                        if(response != 0){
                            $('.boutique-container').append(response);
                        }
                    },
                    complete: function(){
                        $("#loader_gb_right").hide();
                    }
                });
            }
            if(history.state === 'boutique' || history.state === null){
                var fd = new FormData();
                var idBtq = $('#id_boutique_product').val();
                fd.append('id_btq',idBtq);
                setTimeout(() => {
                    $.ajax({
                        url: 'load-boutique.php',
                        type: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        beforeSend: function(){
                            $(".boutique-container").empty();
                            $("#loader_gb_right").show();
                        },
                        success: function(response){
                            if(response != 0){
                                $('.boutique-container').append(response);
                                $('#id_boutique_product').val(idBtq);
                            }
                        },
                        complete: function(){
                            $("#loader_gb_right").hide();
                        }
                    });
                }, 0);
            }
            if(history.state === 'informations'){
                hideDivNotfBackg();
                $('#display_gb_informations').css('background','#ecedee');
                var fd = new FormData();
                var idBtq = $('#id_boutique_product').val();
                fd.append('id_btq',idBtq);
                setTimeout(() => {
                    $.ajax({
                        url: 'load-boutique-informations.php',
                        type: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        beforeSend: function(){
                            $(".boutique-container").empty();
                            $("#loader_gb_right").show();
                        },
                        success: function(response){
                            if(response != 0){
                                $('.boutique-container').append(response);
                            }
                        },
                        complete: function(){
                            $("#loader_gb_right").hide();
                        }
                    });
                }, 0);
            }
        })

        $(document).on('click',"#update_boutique_logo",function(){
            if (windowWidth < 768) {
                $(".boutique-logo-update").css('transform','translateX(0)');
            }
            else{
                $('body').addClass('body-after');
                $(".boutique-logo-update").css('display','initial');
            }
        });

        $(document).on('click',"#update_boutique_couverture",function(){
            if (windowWidth < 768) {
                $(".boutique-couverture-update").css('transform','translateX(0)');
            }
            else{
                $('body').addClass('body-after');
                $(".boutique-couverture-update").css('display','initial');
            }
        });

        $(".boutique-logo-update").click(function(){
            if (windowWidth < 768) {
                $(".boutique-logo-update").css('transform','');
            }
            else{
                $('body').removeClass('body-after');
                $(".boutique-logo-update").css('display','');
            }
        });

        $(".boutique-couverture-update").click(function(){
            if (windowWidth < 768) {
                $(".boutique-couverture-update").css('transform','');
            }
            else{
                $('body').removeClass('body-after');
                $(".boutique-couverture-update").css('display','');
            }
        });

        $(".boutique-logo-update-container").click(function(e){
            e.stopPropagation();
        });

        $(".boutique-couverture-update-container").click(function(e){
            e.stopPropagation();
        });

        $("#cancel_boutique_logo_update").click(function(){
            if (windowWidth < 768) {
                $(".boutique-logo-update").css('transform','');
            }
            else{
                $('body').removeClass('body-after');
                $(".boutique-logo-update").css('display','');
            }
        });

        $("#cancel_boutique_couverture_update").click(function(){
            if (windowWidth < 768) {
                $(".boutique-couverture-update").css('transform','');
            }
            else{
                $('body').removeClass('body-after');
                $(".boutique-couverture-update").css('display','');
            }
        });

        $("#cancel_updt_btq_img_button").click(function(){
            if (windowWidth < 768) {
                $(".boutique-logo-update").css('transform','');
            }
            else{
                $('body').removeClass('body-after');
                $(".boutique-logo-update").css('display','');
            }
        });

        $("#cancel_updt_btq_cvrt_button").click(function(){
            if (windowWidth < 768) {
                $(".boutique-couverture-update").css('transform','');
            }
            else{
                $('body').removeClass('body-after');
                $(".boutique-couverture-update").css('display','');
            }
        });

        $("#cancel_boutique_logo_update_resp").click(function(){
            $(".boutique-logo-update").css('transform','');
        });

        $("#cancel_boutique_couverture_update_resp").click(function(){
            $(".boutique-couverture-update").css('transform','');
        });

        $("#find_image_btn").click(function(){
            $('#upload').click();
        });

        $("#find_couverture_btn").click(function(){
            $('#upload_couverture').click();
        });
        
        $uploadCrop = $('#upload-demo').croppie({
            enableExif: true,
            viewport: {
                width: 200,
                height: 200,
                type: 'square'
            },
            boundary: {
                width: 250,
                height: 250
            }
        });

        $uploadCropCouverture = $('#upload-demo-couverture').croppie({
            enableExif: true,
            viewport: {
                width: 300,
                height: 180,
                type: 'square'
            },
            boundary: {
                width: 320,
                height: 200
            }
        });

        $('#upload').on('change', function () { 
            var reader = new FileReader();
            reader.onload = function (e) {
                $uploadCrop.croppie('bind', {
                    url: e.target.result
                });
            }
            reader.readAsDataURL(this.files[0]);
        });

        $('#upload_couverture').on('change', function () { 
            var reader = new FileReader();
            reader.onload = function (e) {
                $uploadCropCouverture.croppie('bind', {
                    url: e.target.result
                });
            }
            reader.readAsDataURL(this.files[0]);
        });

        $('.upload-result').on('click', function (ev) {
            $uploadCrop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (resp) {
                $.ajax({
                    url: "update-boutique-logo.php",
                    type: "POST",
                    data: {"image":resp},
                    beforeSend: function(){
                        $('.boutique-logo-update-container').css('opacity','0.5');
                        $("#loader_updt_img").show();
                    },
                    success: function (data) {
                        $('.boutique-logo img').replaceWith("<img src='"+resp+"' alt='logo'>");
                        $('body').removeClass('body-after');
                        $(".boutique-logo-update").css('display','');
                    },
                    complete: function(){
                        $('.boutique-logo-update-container').css('opacity','');
                        $("#loader_updt_img").hide();
                    }
                });
            });
        });

        $('.upload-result-resp').on('click', function (ev) {
            $uploadCrop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (resp) {
                $.ajax({
                    url: "update-boutique-logo.php",
                    type: "POST",
                    data: {"image":resp},
                    beforeSend: function(){
                        $('.boutique-logo-update-container').css('opacity','0.5');
                        $("#loader_updt_img").show();
                    },
                    success: function (data) {
                        $(".boutique-logo-update").css('transform','');
                        setTimeout(() => {
                            $('.boutique-logo img').replaceWith("<img src='"+resp+"' alt='logo'>");
                        }, 400);
                    },
                    complete: function(){
                        $('.boutique-logo-update-container').css('opacity','');
                        $("#loader_updt_img").hide();
                    }
                });
            });
        });

        $('.upload-result-couverture').on('click', function (ev) {
            $uploadCropCouverture.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (resp) {
                $.ajax({
                    url: "update-boutique-couverture.php",
                    type: "POST",
                    data: {"image":resp},
                    beforeSend: function(){
                        $('.boutique-couverture-update-container').css('opacity','0.5');
                        $("#loader_updt_cvrt").show();
                    },
                    success: function (data) {
                        $('.position-couverture img').replaceWith("<img id='couverture_img' src='"+resp+"' alt='logo'>");
                        $('body').removeClass('body-after');
                        $(".boutique-couverture-update").css('display','');
                    },
                    complete: function(){
                        $('.boutique-couverture-update-container').css('opacity','');
                        $("#loader_updt_cvrt").hide();
                    }
                });
            });
        });

        $('.upload-result-couverture-resp').on('click', function (ev) {
            $uploadCropCouverture.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (resp) {
                $.ajax({
                    url: "update-boutique-couverture.php",
                    type: "POST",
                    data: {"image":resp},
                    beforeSend: function(){
                        $('.boutique-couverture-update-container').css('opacity','0.5');
                        $("#loader_updt_cvrt").show();
                    },
                    success: function (data) {
                        $(".boutique-couverture-update").css('transform','');
                        setTimeout(() => {
                            $('.position-couverture img').replaceWith("<img id='couverture_img' src='"+resp+"' alt='logo'>");
                        }, 400);
                    },
                    complete: function(){
                        $('.boutique-couverture-update-container').css('opacity','');
                        $("#loader_updt_cvrt").hide();
                    }
                });
            });
        });

        // create product
        $('#create_prd_button').click(function(){
            var fd = new FormData();
            var idBtq = $('#id_boutique_product').val();
            fd.append('id_btq',idBtq);
            $.ajax({
                url: 'pre-create-product.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response != 0){
                        $('#id_product').val(response);
                        hideCreatePublication();
                        if (windowWidth > 768) {
                            $("body").addClass('body-after');
                            $('.create-product').show();
                            $('.create-product-container').css({'top':'0','transform':'translate(-50%,0%)'});
                        }
                        else{
                            $('.create-product').css('transform','translateX(0)');
                        }
                    }
                }
            });
        });

        $('.create-product-bottom input').on('focus',function(){
            var id = $(this).attr('id');
            if (id == 'name_product') {
                $('.name-product').addClass('active-product-input-span');
            }
            if (id == 'reference_product') {
                $('.reference-product').addClass('active-product-input-span');
            }
            if (id == 'categorie_product') {
                $('.categorie-product').addClass('active-product-input-span');
            }
            if (id == 'description_product') {
                $('.description-product').addClass('active-product-input-span');
            }
            if (id == 'caracteristique_product') {
                $('.caracteristique-product').addClass('active-product-input-span');
            }
            if (id == 'fonctionnalite_product') {
                $('.fonctionnalite-product').addClass('active-product-input-span');
            }
            if (id == 'avantage_product') {
                $('.avantage-product').addClass('active-product-input-span');
            }
            if (id == 'quantity_product') {
                $('.quantity-product').addClass('active-product-input-span');
            }
            if (id == 'price_product') {
                $('.price-product').addClass('active-product-input-span');
            }
        })

        $('#cancel_create_product_resp').click(function(){
            var fd= new FormData();
            var idPrd = $('#id_product').val();
            fd.append('id_prd',idPrd);
            $.ajax({
                url: 'pre-delete-product.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response != 0){
                        $("body").removeClass('body-after');
                        $('.create-product').css('transform','');
                    }    
                }
            });
        })

        $('#cancel_create_product').click(function(){
            var fd = new FormData();
            var idPrd = $('#id_product').val();
            fd.append('id_prd',idPrd);
            $.ajax({
                url: 'pre-delete-product.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response != 0){
                        // console.log(response);
                        $("body").removeClass('body-after');
                        $('.create-product').hide();
                        $('.product-images-preview div').remove();
                        $('.product-images-preview div').remove();
                        $('.create-product-container').css({'top':'','transform':''});
                    }
                    else{
                        // console.log(response);
                    }
                }
            });
        })
        
        $(window).on('beforeunload', function(){
            if ($('#create_product').is(':visible')) {
                var fd= new FormData();
                var idPrd = $('#id_product').val();
                fd.append('id_prd',idPrd);
                $.ajax({
                    url: 'pre-delete-product.php',
                    type: 'post',
                    data: fd,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response){
                        if(response != 0){
                            
                        }    
                    }
                });
            }
        })

        $('#create_product').click(function(e){
            var fd = new FormData();
            var idPrd = $('#id_product').val();
            fd.append('id_prd',idPrd);
            $.ajax({
                url: 'pre-delete-product.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response != 0){
                        $("body").removeClass('body-after');
                        $('.create-product').hide();
                        $('.product-images-preview div').remove();
                        $('.product-images-preview div').remove();
                        $('.create-product-container').css({'top':'','transform':''});
                    }    
                }
            });
        })

        $('.create-product-container').click(function(e){
            e.stopPropagation();
        })

        // create categorie
        $('#create_ctgr_button').click(function(){
            hideCreatePublication();
            if (windowWidth > 768) {
                $("body").addClass('body-after');
                $('.create-categorie').show();
            }else{
                $('.create-categorie').css('transform','translateX(0)');
            }
        });

        $('#cancel_create_categorie_resp').click(function(){
            $("body").removeClass('body-after');
            $('.create-categorie').css('transform','');
            $('.categorie-plus').remove();
        })

        $('#cancel_create_categorie').click(function(){
            $("body").removeClass('body-after');
            $('.create-categorie').hide();
            $('.categorie-plus').remove();
        })

        $('#create_categorie').click(function(e){
            $("body").removeClass('body-after');
            $('.create-categorie').hide();
            $('.categorie-plus').remove();
        })

        $('.create-categorie-container').click(function(e){
            e.stopPropagation();
        })

        var ctg = 1;
        $('.create-categorie-bottom').on('click','[id^="add_categorie"]',function(e){
            ctg++;
            $('#create_categorie_button').before('<div class="categorie-input categorie-plus"><input type="text" id="nom_categorie_'+ctg+'" placeholder="Nom de catégorie"><div id="add_categorie"><i class="fas fa-plus"></i></div><span>Categorie</span></div>');
        })

        $('#create_categorie_button').click(function(){
            var form_data = new FormData();
            var idBtq = $('#id_boutique_product').val();
            form_data.append('id_btq',idBtq);
            var categorieLength = $('.categorie-input').length;
            form_data.append('categorie_length',categorieLength);
            for (let i = 1; i <= categorieLength; i++) {
                var nomCategorie = $('#nom_categorie_'+i).val();
                form_data.append('nom_categorie_'+i,nomCategorie);
            }
            $.ajax({
                url: 'add-boutique-categorie.php', 
                type: 'post',
                data: form_data,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response != 0) {
                        $("body").removeClass('body-after');
                        $('.create-categorie').hide();
                        $('.gerer-boutique-categorie-bottom').empty();
                        $('.gerer-boutique-categorie-bottom').prepend(response);
                        
                        // }
                    }else{
                        // console.log('err');
                    }
                }
            });
        });

        // categorie options
        $(document).on('click','[id^="display_ctg_options_"]',function(e){
            e.stopPropagation();
            id = $(this).attr("id").split("_")[3];
            var idCtg = $('#id_categorie_'+id).val(); 
            var nomCtg = $('#nom_categorie_'+id).val();
            $('#id_categorie_resp').val(idCtg); 
            $('#nom_categorie_resp').val(nomCtg);
            if (windowWidth > 768) {
                $('[id^="categorie_options_"]').hide();
                if ($('#categorie_options_'+id).is(':visible')) {
                    $('#categorie_options_'+id).hide();
                }
                else{
                    $('#categorie_options_'+id).show();
                }
            }else{
                // $('.gerer-boutique-left').css('transform','translateX(0)');
                $("body").addClass('body-after');
                $('.categorie-options-resp').css('transform','translateY(0)');
            }
        });

        // update categorie
        $(document).on('click','[id^="update_categorie_"]',function(e){
            // e.stopPropagation();
            id = $(this).attr("id").split("_")[2];
            $('[id^="categorie_options_"]').hide();
            var idCtg = $('#id_categorie_'+id).val(); 
            var nomCtg = $('#nom_categorie_'+id).val();
            $('#update_id_categorie').val(idCtg); 
            $('#update_nom_categorie').val(nomCtg); 
            $("body").addClass('body-after');
            $('#update_categorie').show();
        });

        $(document).on('click','#update_categorie_resp',function(e){
            // e.stopPropagation();
            var idCtg = $('#id_categorie_resp').val(); 
            var nomCtg = $('#nom_categorie_resp').val();
            $('#update_id_categorie').val(idCtg); 
            $('#update_nom_categorie').val(nomCtg);
            $('#update_categorie').css('transform','translateY(0)');
        });

        $('#update_categorie_button').click(function(){
            var fd = new FormData();
            var idBtq = $('#id_boutique_product').val();
            fd.append('id_btq',idBtq);
            var idCtg = $('#update_id_categorie').val(); 
            fd.append('id_c',idBtq);
            var nomCtg = $('#update_nom_categorie').val();
            fd.append('nom_categorie',idBtq);
            $.ajax({
                url: 'update_categorie.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response != 0){
                        $("body").removeClass('body-after');
                        if (windowWidth > 768) {
                            $('#update_categorie').hide();
                        }else{
                            $('#update_categorie').css('transform','');
                        }
                    }
                }
            });
        });

        $('#update_categorie').click(function(e){
            e.stopPropagation();
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $('#update_categorie').hide();
            }else{
                $('#update_categorie').css('transform','');
            }
        });

        $('#cancel_update_categorie').click(function(e){
            e.stopPropagation();
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $('#update_categorie').hide();
            }else{
                $('#update_categorie').css('transform','');
            }
        });

        $('#cancel_update_categorie_resp').click(function(e){
            e.stopPropagation();
            $('#update_categorie').css('transform','');
        });

        $('#update_categorie').click(function(e){
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $('#update_categorie').hide();
            }else{
                $('#update_categorie').css('transform','');
            }
        });

        $('#update_categorie_container').click(function(e){
            e.stopPropagation();
        });

        // delete categorie
        $(document).on('click','[id^="delete_categorie_"]',function(e){
            // e.stopPropagation();
            id = $(this).attr("id").split("_")[2];
            $('[id^="categorie_options_"]').hide();
            var idCtg = $('#id_categorie_'+id).val(); 
            $('#id_categorie_delete').val(idCtg); 
            $("body").addClass('body-after');
            $('#delete_categorie').show();
        });

        $(document).on('click','#delete_categorie_resp',function(e){
            // e.stopPropagation();
            var idCtg = $('#update_id_categorie').val(); 
            $('#id_categorie_delete').val(idCtg); 
            $("body").addClass('body-after');
            if (windowWidth > 768) {
                $('#delete_categorie').show();
            }else{
                $('#delete_categorie').css('transform','translateY(0)');
            }
        });

        $(document).on('click','#delete_ctg_button',function(){
            var fd = new FormData();
            var idPrd = $('#id_categorie_delete').val();
            fd.append('id_prd',idPrd);
            $.ajax({
                url: 'delete-categorie.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response != 0){
                        $("body").removeClass('body-after');
                        if (windowWidth > 768) {
                            $('#delete_categorie').hide();
                        }else{
                            $('#delete_categorie').css('transform','');
                        }
                    }
                }
            });
        });

        $(document).on('click','#cancel_delete_categorie',function(e){
            e.stopPropagation();
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $('#delete_categorie').hide();
            }else{
                $('#delete_categorie').css('transform','');
            }
        });

        $(document).on('click','#cancel_delete_ctg_button',function(e){
            e.stopPropagation();
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $('#delete_categorie').hide();
            }else{
                $('#delete_categorie').css('transform','');
            }
        });

        $('#delete_categorie').click(function(e){
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $('#delete_categorie').hide();
            }else{
                $('#delete_categorie').css('transform','');
            }
        })

        // upload product image 
        $('#add_product_image').click(function(){
            $('#image_prd').click();
        });

        $('#image_prd').click(function(e){
            e.stopPropagation();
        });

        $('#image_prd').on('change', function () { 
            $('#add_product_image_button').click();
        });

        $('#add_product_image_button').click(function(){
            var form_data = new FormData();
            var idPrd = $('#id_product').val();
            form_data.append('id_prd',idPrd);
            var idBtq = $('#id_boutique_product').val();
            form_data.append('id_btq',idBtq);
            var totalfiles = document.getElementById('image_prd').files.length;
            for (let i = 0; i < totalfiles; i++) {
                form_data.append("images[]", document.getElementById('image_prd').files[i]);
            }
            $.ajax({
                url: 'upload-images-product.php', 
                type: 'post',
                data: form_data,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (response) {
                    if (windowWidth > 768) {
                        $('.create-product-container').css({'top':'0','transform':'translate(-50%,0%)'});
                    }
                    for(let i = 0; i < response.length; i++) {
                        var src = response[i];
                        $('.product-images-preview').append("<div class='product-image-preview' id='product_image_preview_"+i+"'><div id='product_delete_preview_"+i+"'><i class='fas fa-times'></i></div><img src='"+src+"'></div>");
                    }
                }
            });
        });

        // remove product image preview
        $('.product-images-preview').on('click','[id^="product_delete_preview_"]',function(){
            var id = $(this).attr("id").split("_")[3];
            var fd = new FormData();
            var idPrd = $('#id_product').val();
            fd.append('id_prd',idPrd);
            var mediaUrl = $('#product_image_preview_'+id+' img').attr('src');
            fd.append('media_url',mediaUrl);
            $.ajax({
                url: 'delete-image-product-preview.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response != 0){
                        $('#product_image_preview_'+id).remove();
                    }
                }
            });
        });

        // $('#create_product_button').click(function(){
        //     var idBtq = $('#id_boutique_product').val();
        //     var idPrd = $('#id_product').val();
        //     var namePrd = $('#name_product').val();
        //     var referencePrd = $('#reference_product').val();
        //     var categoriePrd = $('#categorie_product').val();
        //     var descriptionPrd = $('#description_product').val();
        //     var caracteristiquePrd = $('#caracteristique_product').val();
        //     var fonctionnalitePrd = $('#fonctionnalite_product').val();
        //     var avantagePrd = $('#avantage_product').val();
        //     var quantityPrd = $('#quantity_product').val();
        //     var pricePrd = $('#price_product').val();

        //     if (namePrd == ''){
        //         $('#name_product').css('border','2px solid red');
        //     }
        //     // else if(referencePrd == ''){
        //     //     $('#name_product').css('border','');
        //     //     $('#reference_product').css('border','2px solid red');
        //     // }
        //     else if(categoriePrd == ''){
        //         $('#name_product').css('border','');
        //         // $('#reference_product').css('border','');
        //         $('#categorie_product').css('border','2px solid red');
        //     }
        //     else if(descriptionPrd == ''){
        //         $('#name_product').css('border','');
        //         // $('#reference_product').css('border','');
        //         $('#categorie_product').css('border','');
        //         $('#description_product').css('border','2px solid red');
        //     }
        //     else if(quantityPrd == ''){
        //         $('#name_product').css('border','');
        //         // $('#reference_product').css('border','');
        //         $('#categorie_product').css('border','');
        //         $('#description_product').css('border','');
        //         $('#quantity_product').css('border','2px solid red');
        //     }
        //     else if(pricePrd == ''){
        //         $('#name_product').css('border','');
        //         // $('#reference_product').css('border','');
        //         $('#categorie_product').css('border','');
        //         $('#description_product').css('border','');
        //         $('#quantity_product').css('border','');
        //         $('#price_product').css('border','2px solid red');
        //     }
        //     else if(namePrd != '' && categoriePrd != '' && descriptionPrd != '' &&
        //             quantityPrd != '' && pricePrd != ''){
        //         var fd = new FormData();
        //         fd.append('id_prd',idPrd);
        //         fd.append('id_btq',idBtq);
        //         fd.append('name_prd',namePrd);
        //         fd.append('reference_prd',referencePrd);
        //         fd.append('categorie_prd',categoriePrd);
        //         fd.append('description_prd',descriptionPrd);
        //         fd.append('caracteristique_prd',caracteristiquePrd);
        //         fd.append('fonctionnalite_prd',fonctionnalitePrd);
        //         fd.append('avantage_prd',avantagePrd);
        //         fd.append('quantity_prd',quantityPrd);
        //         fd.append('price_prd',pricePrd);
        //         $.ajax({
        //             url: 'create-product.php',
        //             type: 'post',
        //             data: fd,
        //             contentType: false,
        //             processData: false,
        //             beforeSend: function(){
        //                 $('.create-product-top').hide();
        //                 $('.create-product-bottom').hide();
        //                 $("#loader_load").show();
        //             },
        //             success: function(response){
        //                 if(response != 0){
        //                     // console.log(response);
        //                     $('.boutique-bottom').prepend(response);
        //                 }
        //             },
        //             complete: function(){
        //                 $("#loader_load").hide();
        //                 $(".create-product").hide();
        //                 $("body").removeClass('body-after');
        //                 $('.create-product-container').css({'top':'','transform':''});
        //                 $('.create-product-top').show();
        //                 $('.create-product-bottom').show();
        //                 $('#name_product').val('');
        //                 $('#reference_product').val('');
        //                 $('#categorie_product').val('');
        //                 $('#description_product').val('');
        //                 $('#quantity_product').val('');
        //                 $('#price_product').val('');
        //                 $('.product-images-preview').empty();
        //             }
        //         });
        //     }
        // });

        // $('#crt_prd_btn_resp').click(function(){
        //     var idBtq = $('#id_boutique_product').val();
        //     var idPrd = $('#id_product').val();
        //     var namePrd = $('#name_product').val();
        //     var referencePrd = $('#reference_product').val();
        //     var categoriePrd = $('#categorie_product').val();
        //     var descriptionPrd = $('#description_product').val();
        //     var caracteristiquePrd = $('#caracteristique_product').val();
        //     var fonctionnalitePrd = $('#fonctionnalite_product').val();
        //     var avantagePrd = $('#avantage_product').val();
        //     var quantityPrd = $('#quantity_product').val();
        //     var pricePrd = $('#price_product').val();

        //     if (namePrd == ''){
        //         $('#name_product').css('border','2px solid red');
        //     }
        //     // else if(referencePrd == ''){
        //     //     $('#name_product').css('border','');
        //     //     $('#reference_product').css('border','2px solid red');
        //     // }
        //     else if(categoriePrd == ''){
        //         $('#name_product').css('border','');
        //         // $('#reference_product').css('border','');
        //         $('#categorie_product').css('border','2px solid red');
        //     }
        //     else if(descriptionPrd == ''){
        //         $('#name_product').css('border','');
        //         // $('#reference_product').css('border','');
        //         $('#categorie_product').css('border','');
        //         $('#description_product').css('border','2px solid red');
        //     }
        //     else if(quantityPrd == ''){
        //         $('#name_product').css('border','');
        //         // $('#reference_product').css('border','');
        //         $('#categorie_product').css('border','');
        //         $('#description_product').css('border','');
        //         $('#quantity_product').css('border','2px solid red');
        //     }
        //     else if(pricePrd == ''){
        //         $('#name_product').css('border','');
        //         // $('#reference_product').css('border','');
        //         $('#categorie_product').css('border','');
        //         $('#description_product').css('border','');
        //         $('#quantity_product').css('border','');
        //         $('#price_product').css('border','2px solid red');
        //     }
        //     else if(namePrd != '' && categoriePrd != '' && descriptionPrd != '' &&
        //             quantityPrd != '' && pricePrd != ''){
        //         var fd = new FormData();
        //         fd.append('id_prd',idPrd);
        //         fd.append('id_btq',idBtq);
        //         fd.append('name_prd',namePrd);
        //         fd.append('reference_prd',referencePrd);
        //         fd.append('categorie_prd',categoriePrd);
        //         fd.append('description_prd',descriptionPrd);
        //         fd.append('caracteristique_prd',caracteristiquePrd);
        //         fd.append('fonctionnalite_prd',fonctionnalitePrd);
        //         fd.append('avantage_prd',avantagePrd);
        //         fd.append('quantity_prd',quantityPrd);
        //         fd.append('price_prd',pricePrd);
        //         $.ajax({
        //             url: 'create-product.php',
        //             type: 'post',
        //             data: fd,
        //             contentType: false,
        //             processData: false,
        //             beforeSend: function(){
        //                 $('.create-product-top').hide();
        //                 $('.create-product-bottom').hide();
        //                 $("#loader_load").show();
        //             },
        //             success: function(response){
        //                 if(response != 0){
        //                     // console.log(response);
        //                     $('.boutique-bottom').prepend(response);
        //                 }
        //             },
        //             complete: function(){
        //                 $("#loader_load").hide();
        //                 $(".create-product").hide();
        //                 $("body").removeClass('body-after');
        //                 $('.create-product-container').css({'top':'','transform':''});
        //                 $('.create-product-top').show();
        //                 $('.create-product-bottom').show();
        //                 $('#name_product').val('');
        //                 $('#reference_product').val('');
        //                 $('#categorie_product').val('');
        //                 $('#description_product').val('');
        //                 $('#quantity_product').val('');
        //                 $('#price_product').val('');
        //                 $('.product-images-preview').empty();
        //             }
        //         });
        //     }
        // });

        // product options
        $(document).on('click','[id^="display_prd_options_button_"]',function(e){
            e.stopPropagation();
            id = $(this).attr("id").split("_")[4];
            if (windowWidth > 768) {
                if ($('#product_options_'+id).is(':visible')) {
                    $('#product_options_'+id).hide();
                }
                else{
                    $('#product_options_'+id).show();
                }
            }else{
                $("body").addClass('body-after');
                $('#product_options_'+id).css('transform','translateY(0)');
            }
        });

        $(document).on('click','[id^="product_options_"]',function(e){
            e.stopPropagation();
            $(this).show();
        });

        // delete product
        $(document).on('click','[id^="delete_product_"]',function(){
            id = $(this).attr("id").split("_")[2];
            var idPrd = $('#id_prd_'+id).val();
            var prdTail = $('#product_tail_'+id).val();
            $('#id_product_delete').val(idPrd);
            $('#product_tail_delete').val(prdTail);
            $("body").addClass('body-after');
            if (windowWidth > 768) {
                $('#delete_product').show();
            }else{
                $('#delete_product').css('transform','translateY(0)');
            }
        });

        $(document).on('click','#delete_prd_button',function(){
            var fd = new FormData();
            var idPrd = $('#id_product_delete').val();
            fd.append('id_prd',idPrd);
            var prdTail = $('#product_tail_delete').val();
            $.ajax({
                url: 'delete-product.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response != 0){
                        $("body").removeClass('body-after');
                        if (windowWidth > 768) {
                            $('#delete_product').hide();
                        }else{
                            $('#delete_product').css('transform','');
                        }
                        $('#boutique_product_'+prdTail).remove();
                    }
                }
            });
        });

        $(document).on('click','#cancel_delete_product',function(e){
            e.stopPropagation();
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $('#delete_product').hide();
            }else{
                $('#delete_product').css('transform','');
            }
        });

        $(document).on('click','#cancel_delete_prd_button',function(e){
            e.stopPropagation();
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $('#delete_product').hide();
            }else{
                $('#delete_product').css('transform','');
            }
        });

        $('#delete_product').click(function(e){
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $('#delete_product').hide();
            }else{
                $('#delete_product').css('transform','');
            }
        });


        // update products 
        $(document).on('click','[id^="update_product_"]',function(){
            id = $(this).attr("id").split("_")[2];
            var idPrd = $('#id_prd_'+id).val(); 
            var prdTail = $('#product_tail_'+id).val();
            var prdName = $('#name_prd_'+id).val();
            var prdReference = $('#reference_prd_'+id).val();
            var prdCategorie = $('#categorie_prd_'+id).val();
            var prdDescription = $('#description_prd_'+id).val();
            var prdQuantite = $('#quantity_prd_'+id).val();
            var prdPrix = $('#price_prd_'+id).val();
            
            $('#id_product_updt').val(idPrd);
            $('#product_tail_updt').val(prdTail);
            $('#updt_name_product').val(prdName);
            $('#updt_refernce_product').val(prdReference);
            $('#updt_categorie_product').val(prdCategorie);
            $('#updt_description_product').val(prdDescription);
            $('#updt_quantity_product').val(prdQuantite);
            $('#updt_price_product').val(prdPrix);

            $('.product-update-images-preview').load('product-images-preview.php?id_prd='+idPrd);

            if (windowWidth <= 768) {
                $('.update-product').css('transform','translateX(0)');
            }
            else{
                $("body").addClass('body-after');
                $('.update-product').show();
                $('.update-product-container').css({'top':'0','transform':'translate(-50%,0%)'});
            }
        });

        $('#cancel_update_product_resp').click(function(){
            $('.update-product').css('transform','');
        })

        $('#cancel_update_product').click(function(e){
            e.stopPropagation();
            $("body").removeClass('body-after');
            $('.update-product').hide();
            $('.update-product-container').css({'top':'','transform':''});
            $('.product-update-images-preview div').remove();
        })

        $('#update_product').click(function(){
            $("body").removeClass('body-after');
            $('.update-product').hide();
            $('.update-product-container').css({'top':'','transform':''});
            $('.product-update-images-preview div').remove();
        })

        //update product image
        $('.update-product-container').click(function(e){
            e.stopPropagation();
        })

        $('#update_product_image').click(function(){
            $('#image_prd_updt').click();
        });

        $('#image_prd_updt').on('change',function(){ 
            $('#update_product_image_button').click();
        });

        $('#update_product_image_button').click(function(){
            var form_data = new FormData();
            var idBtq = $('#id_boutique_product').val();
            form_data.append('id_btq',idBtq);
            var idPrd = $('#id_product_updt').val();
            form_data.append('id_prd',idPrd);
            var totalfiles = document.getElementById('image_prd_updt').files.length;
            for (let i = 0; i < totalfiles; i++) {
                form_data.append("images[]", document.getElementById('image_prd_updt').files[i]);
            }
            $.ajax({
                url: 'upload-images-product.php', 
                type: 'post',
                data: form_data,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (response) {
                    // console.log(response);
                    if (windowWidth > 768) {
                        $('.update-product-container').css({'top':'0','transform':'translate(-50%,0%)'});
                    }
                    for(let i = 0; i < response.length; i++) {
                        var src = response[i];
                        $('.product-update-images-preview').append("<div class='product-image-preview' id='product_image_preview_"+i+"'><div id='product_delete_preview_"+i+"'><i class='fas fa-times'></i></div><img src='"+src+"'></div>");
                    }
                }
            });
        });

        // remove update product images preview
        $('.product-update-images-preview').on('click','[id^="product_delete_preview_"]',function(){
            var id = $(this).attr("id").split("_")[3];
            var fd = new FormData();
            var idBtq = $('#id_boutique_product').val();
            fd.append('id_btq',idBtq);
            var idPrd = $('#id_product_updt').val();
            fd.append('id_prd',idPrd);
            var mediaUrl = $('.product-update-images-preview #product_image_preview_'+id+' img').attr('src');
            fd.append('media_url',mediaUrl);
            $.ajax({
                url: 'update-images-product.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response != 0){
                        $('.product-update-images-preview #product_image_preview_'+id).remove();
                    }
                }
            });
        });

        $('#update_product_button').click(function(){
            var fd = new FormData();
            var idPrd = $('#id_product_updt').val();
            fd.append('id_prd',idPrd);
            var namePrd = $('#updt_name_product').val();
            fd.append('nom_prd',namePrd);
            var referencePrd = $('#updt_refernce_product').val();
            fd.append('reference_prd',referencePrd);
            var categoriePrd = $('#updt_categorie_product').val();
            fd.append('categorie_prd',categoriePrd);
            var descriptionPrd = $('#updt_description_product').val();
            fd.append('description_prd',descriptionPrd);
            var caracteristiquePrd = $('#updt_caracteristique_product').val();
            fd.append('caracteristique_prd',caracteristiquePrd);
            var fonctionnalitePrd = $('#updt_fonctionnalite_product').val();
            fd.append('fonctionnalite_prd',fonctionnalitePrd);
            var descriptionPrd = $('#updt_avantage_product').val();
            fd.append('avantage_prd',descriptionPrd);
            var quantityPrd = $('#updt_quantity_product').val();
            fd.append('quantite_prd',quantityPrd);
            var pricePrd = $('#updt_price_product').val();
            fd.append('prix_prd',pricePrd);
            var id = $('#product_tail_updt').val();
            fd.append('tail_prd',id);
            $.ajax({
                url: 'update-product.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $('.update-product').css('opacity','0.5');
                    $("#loader_load_updt").show();
                },
                success: function(response){
                    if(response != 0){
                        $('#boutique_product_'+id).replaceWith(response);
                    }
                },
                complete: function(){
                    $("#loader_load_updt").hide();
                    $(".update-product").hide();
                    $("body").removeClass('body-after');
                    $('.update-product-container').css({'top':'','transform':''});
                    $('.update-product').css('opacity','');
                }
            });
        });

        $('#update_product_button_resp').click(function(){
            var fd = new FormData();
            var idPrd = $('#id_product_updt').val();
            fd.append('id_prd',idPrd);
            var namePrd = $('#updt_name_product').val();
            fd.append('nom_prd',namePrd);
            var referencePrd = $('#updt_refernce_product').val();
            fd.append('reference_prd',referencePrd);
            var categoriePrd = $('#updt_categorie_product').val();
            fd.append('categorie_prd',categoriePrd);
            var descriptionPrd = $('#updt_description_product').val();
            fd.append('description_prd',descriptionPrd);
            var caracteristiquePrd = $('#updt_caracteristique_product').val();
            fd.append('caracteristique_prd',caracteristiquePrd);
            var fonctionnalitePrd = $('#updt_fonctionnalite_product').val();
            fd.append('fonctionnalite_prd',fonctionnalitePrd);
            var descriptionPrd = $('#updt_avantage_product').val();
            fd.append('avantage_prd',descriptionPrd);
            var quantityPrd = $('#updt_quantity_product').val();
            fd.append('quantite_prd',quantityPrd);
            var pricePrd = $('#updt_price_product').val();
            fd.append('prix_prd',pricePrd);
            var id = $('#product_tail_updt').val();
            fd.append('tail_prd',id);
            $.ajax({
                url: 'update-product.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $('.update-product').css('opacity','0.5');
                    $("#loader_load_updt").show();
                },
                success: function(response){
                    if(response != 0){
                        $('#boutique_product_'+id).replaceWith(response);
                    }
                },
                complete: function(){
                    $("#loader_load_updt").hide();
                    $(".update-product").hide();
                    $("body").removeClass('body-after');
                    $('.update-product-container').css({'top':'','transform':''});
                    $('.update-product').css('opacity','');
                }
            });
        });

        $(document).on('click','[id^="boutique_product_"]',function(){
            var id = $(this).attr("id").split("_")[2];
            var fd = new FormData();
            var idBtq = $('#id_boutique_product').val();
            fd.append('id_btq',idBtq);
            var idPrd = $('#id_prd_'+id).val();
            fd.append('id_prd',idPrd);
            $.ajax({
                url: 'load-gb-product-content.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $("body").addClass('body-after');
                    if (windowWidth > 768) {
                        $(".product-details").show();
                    }else{
                        $(".product-details").css('transform','translateX(0)');
                    }
                    $("#loader_product").show();
                },
                success: function(response){
                    if(response != 0){
                        $('.product-details-container').append(response);
                    }
                },
                complete: function(){
                    $("#loader_product").hide();
                }
            });
        });

        $(document).on('click','#cancel_product_details',function(){
            $("body").removeClass('body-after');
            $(".product-details").hide();
            $('.product-details-container').empty();
        })

        $(document).on('click','#cancel_product_details_resp',function(e){
            // e.stopPropagation();
            $("body").removeClass('body-after');
            $(".product-details").css('transform','');
            setTimeout(() => {
                $('.product-details-container').empty();
            }, 400);
        })

        $(document).on('click','#overview_product_button',function(){
            $("#comment_product_button").removeClass('product-details-bottom-top-active');
            $("#informations_product_button").removeClass('product-details-bottom-top-active');
            $("#overview_product_button").addClass('product-details-bottom-top-active');
            
            $("#comments_product").removeClass('product-details-bottom-bottom-active');
            $("#overview_product").addClass('product-details-bottom-bottom-active');
            $("#informations_product").css('display','');
            
        })
        
        $(document).on('click','#informations_product_button',function(){
            $("#overview_product_button").removeClass('product-details-bottom-top-active');
            $("#informations_product_button").addClass('product-details-bottom-top-active');
            $("#comment_product_button").removeClass('product-details-bottom-top-active');

            $("#overview_product").removeClass('product-details-bottom-bottom-active');
            $("#comments_product").removeClass('product-details-bottom-bottom-active');
            $("#informations_product").css('display','grid');
        })

        $(document).on('click','#comment_product_button',function(){
            $("#overview_product_button").removeClass('product-details-bottom-top-active');
            $("#informations_product_button").removeClass('product-details-bottom-top-active');
            $("#comment_product_button").addClass('product-details-bottom-top-active');

            $("#overview_product").removeClass('product-details-bottom-bottom-active');
            $("#informations_product").removeClass('product-details-bottom-bottom-active');
            $("#comments_product").addClass('product-details-bottom-bottom-active');
            $("#informations_product").css('display','');
        })

        $(document).on('click','.display-modele',function(){
            var urlMedia = $(this).find('img').attr('src');
            $('.display-modele').removeClass('product-details-modele-image-active');
            $(this).addClass('product-details-modele-image-active');
            $(document).find('.product-details-images-top img').replaceWith('<img src="'+urlMedia+'" alt="">');
            
        })
        
        function scrolldiv() {
            $(".boutique-message-right-bottom").prop({
                scrollTop: $('.boutique-message-right-bottom').prop("scrollHeight")
            })
        }

        function hideDivNotfBackg(){
            $('#display_gb_messagerie').css('background','');
            $('#display_gb_notifications').css('background','');
            $('#display_gb_informations').css('background','');
            $('#create_gb_admin').css('background','');
        }

        $(document).on('click','#display_gb_messagerie',function(){
            hideDivNotfBackg();
            $(this).css('background','#ecedee');
            var fd = new FormData();
            var idBtq = $('#id_boutique_product').val();
            fd.append('id_btq',idBtq);
            var idCrsp = $('#last_corresponder').val();
            $.ajax({
                url: 'load-boutique-messagerie.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".boutique-container").empty();
                    $("#loader_gb_right").show();
                },
                success: function(response){
                    if(response != 0){
                        history.pushState('messagerie','', '/projet/gerer-boutique/'+idBtq+'/'+idCrsp);
                        if (windowWidth < 768) {
                            $('.gerer-boutique-left').css('transform','');
                            setTimeout(() => {
                                $('.boutique-container').append(response);
                            }, 400);
                            console.log(1);
                        }
                        else{
                            $('.boutique-container').append(response);
                        }
                        scrolldiv();
                    }
                },
                complete: function(){
                    $("#loader_gb_right").hide();
                }
            });
        })

        // function updateSenderMessage(userId,senderId){
        //     var fd = new FormData();
        //     fd.append('id_user',userId);
        //     fd.append('id_sender',senderId);
        //     $.ajax({
        //         url: 'update-messagerie-sender.php',
        //         type: 'post',
        //         data: fd,
        //         contentType: false,
        //         processData: false,
        //         success: function(response){
        //             if(response != 0){

        //             }
        //         }
        //     });
        // }

        function updateReceverMessage(userId,senderId){
            var fd = new FormData();
            fd.append('id_user',userId);
            fd.append('id_sender',senderId);
            $.ajax({
                url: 'update-messagerie-recever.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response != 0){

                    }
                }
            });
        }

        $(document).on('click','[id^="boutique_corresponder_"]',function(){
            $(this).css('background','#ffffff');
            var id = $(this).attr('id').split('_')[2];
            var fd = new FormData();
            var idBtq = $('#id_boutique_product').val();
            fd.append('id_btq',idBtq);
            var idCrsp = $('#id_corresponder_'+id).val();
            fd.append('id_sender',idCrsp);
            $.ajax({
                url: 'load-boutique-sender-messages.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".boutique-message-right-container").empty();
                    $("#loader_message").show();
                },
                success: function(response){
                    if(response != 0){
                        history.pushState('messagerie','', '/projet/gerer-boutique/'+idBtq+'/'+idCrsp);
                        updateSenderMessage(idCrsp,idBtq);
                        $('.btq-new-msg').load('load-btq-new-msg.php?btq='+idBtq);
                        $('.boutique-message-right-container').append(response);
                        if (windowWidth <= 768) {
                            $('.boutique-message-right').css('transform','translateX(0)');
                        }
                    }
                },
                complete: function(){
                    $("#loader_message").hide();
                    scrolldiv();
                }
            });
        })

        $(document).on('click','#display_gb_notifications',function(){
            hideDivNotfBackg();
            $(this).css('background','#ecedee');
            var fd = new FormData();
            var idBtq = $('#id_boutique_product').val();
            fd.append('id_btq',idBtq);
            var numNtf = $('#num_ntf').val();
            $.ajax({
                url: 'load-boutique-notifications.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".boutique-container").empty();
                    $("#loader_gb_right").show();
                },
                success: function(response){
                    if(response != 0){
                        history.pushState('notifications','', '/projet/gerer-boutique/'+idBtq+'/notifications');
                        if (windowWidth < 768) {
                            $('.gerer-boutique-left').css('transform','');
                            setTimeout(() => {
                                $('.boutique-container').append(response);
                            }, 400);
                            console.log(1);
                        }
                        else{
                            $('.boutique-container').append(response);
                        }
                    }
                },
                complete: function(){
                    $("#loader_gb_right").hide();
                }
            });
        })

        $(document).on('click','#display_gb_informations',function(){
            hideDivNotfBackg();
            $(this).css('background','#ecedee');
            var fd = new FormData();
            var idBtq = $('#id_boutique_product').val();
            fd.append('id_btq',idBtq);
            $.ajax({
                url: 'load-boutique-informations.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".boutique-container").empty();
                    $("#loader_gb_right").show();
                },
                success: function(response){
                    if(response != 0){
                        history.pushState('informations','', '/projet/gerer-boutique/'+idBtq+'/modifications');
                        if (windowWidth < 768) {
                            $('.gerer-boutique-left').css('transform','');
                            setTimeout(() => {
                                $('.boutique-container').append(response);
                            }, 400);
                            console.log(1);
                        }
                        else{
                            $('.boutique-container').append(response);
                        }
                    }
                },
                complete: function(){
                    $("#loader_gb_right").hide();
                }
            });
        })

        // update boutique
        $(document).on('focus','.update-boutique-informations-top input',function(){
            var id = $(this).attr('id');
            if (id == 'adresse_btq') {
                $('.adresse-btq').addClass('btq-span-active');
            }
            if (id == 'email_btq') {
                $('.email-btq').addClass('btq-span-active');
            }
            if (id == 'tlph_btq') {
                $('.tlph-btq').addClass('btq-span-active');
            }
        })
        $(document).on('focus','.update-boutique-informations-top textarea',function(){
            var id = $(this).attr('id');
            if (id == 'dscrp_btq') {
                $('.dscrp-btq').addClass('btq-span-active');
            }
        })

        $(document).on('click','#update_boutique_button',function(){
            var idBtq = $('#id_boutique_product').val();
            var nomBtq = $('#nom_btq').val();
            var villeBtq = $('#ville_btq').val();
            var communeBtq = $('#commune_btq').val();
            var adresseBtq = $('#adresse_btq').val();
            var emailBtq = $('#email_btq').val();
            var tlphBtq = $('#tlph_btq').val();
            var dscrpBtq = $('#dscrp_btq').val();
            if (nomBtq == '') {
                $('#nom_btq').css('border','2px solid red');
            }
            else if(dscrpBtq == ''){
                $('#nom_btq').css('border','');
                $('#dscrp_btq').css('border','2px solid red');
            }
            else{
                $('#nom_btq').css('border','');
                $('#dscrp_btq').css('border','');
                var fd = new FormData();
                fd.append('id_btq',idBtq);
                fd.append('nom_btq',nomBtq);
                fd.append('ville_btq',villeBtq);
                fd.append('commune_btq',communeBtq);
                fd.append('adresse_btq',adresseBtq);
                fd.append('email_btq',emailBtq);
                fd.append('tlph_btq',tlphBtq);
                fd.append('dscrp_btq',dscrpBtq);
                $.ajax({
                    url: 'update-boutique-informations.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $(".update-boutique-informations").css('opacity','0.5');
                        $("#loader_gb_right").show();
                    },
                    success: function(response){
                        if(response != 0){
                            $('.gb-message-alert').css('transform','translateY(0)');
                        }
                    },
                    complete: function(){
                        $("#loader_gb_right").hide();
                        $(".update-boutique-informations").css('opacity','');
                        setTimeout(() => {
                            $('.gb-message-alert').css('transform','');
                        }, 4000);
                    }
                });
            }
        })

        $(document).on('click','.cancel-alert-message',function(){
            $('.gb-message-alert').css('transform','');
        })

        function hideGererBtqBtqBackg(){
            $('.gerer-boutique-boutique').css('background','');
        }
        $(document).on('click','[id^="gerer_boutique_boutique_"]',function(){
            hideGererBtqBtqBackg();
            $(this).css('background','#ecedee');
            var id = $(this).attr('id').split('_')[3];
            var fd = new FormData();
            var idBtq = $('#id_gb_btq_'+id).val();
            fd.append('id_btq',idBtq);
            setTimeout(() => {
                $.ajax({
                    url: 'load-boutique.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $(".boutique-container").empty();
                        $("#loader_gb_right").show();
                    },
                    success: function(response){
                        if(response != 0){
                            history.pushState('boutique','', '/projet/gerer-boutique/'+idBtq);
                            setTimeout(() => {
                                $('.gb-messages-notifications').load('load-boutique-options.php?id_btq='+idBtq);
                                $('.gerer-boutique-categorie-bottom').load('load-boutique-categorie.php?id_btq='+idBtq);
                            }, 100);
                            if (windowWidth < 768) {
                                $('.gerer-boutique-left').css('transform','');
                                setTimeout(() => {
                                    $('.boutique-container').append(response);
                                }, 400);
                                console.log(1);
                            }
                            else{
                                $('.boutique-container').append(response);
                            }
                            $('#id_boutique_product').val(idBtq);
                        }
                    },
                    complete: function(){
                        $("#loader_gb_right").hide();
                    }
                });
            }, 0);
        })

        // admin boutique
        $(document).on('click','#create_gb_admin',function(){
            hideDivNotfBackg();
            $(this).css('background','#ecedee');
            var fd = new FormData();
            var idBtq = $('#id_boutique_product').val();
            fd.append('id_btq',idBtq);
            $.ajax({
                url: 'load-boutique-admin.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".boutique-container").empty();
                    $("#loader_gb_right").show();
                },
                success: function(response){
                    if(response != 0){
                        history.pushState('admin','', '/projet/gerer-boutique/'+idBtq+'/admin');
                        if (windowWidth < 768) {
                            $('.gerer-boutique-left').css('transform','');
                            setTimeout(() => {
                                $('.boutique-container').append(response);
                            }, 400);
                            console.log(1);
                        }
                        else{
                            $('.boutique-container').append(response);
                        }
                    }
                },
                complete: function(){
                    $("#loader_gb_right").hide();
                }
            });
        })

        $(document).on('focus','.create-admin-boutique-top input',function(){
            var id = $(this).attr('id');
            if (id == 'nom_adm') {
                $('.nom-adm').addClass('active-create-admin-span');
            }
            if (id == 'mtp_adm') {
                $('.mtp-adm').addClass('active-create-admin-span');
            }
            if (id == 'cnfrm_mtp_adm') {
                $('.cnfrm-mtp-adm').addClass('active-create-admin-span');
            }
        })

        $(document).on('click','#create_matricule',function(e){
            $.ajax({
                url: 'create-admin-boutique-matricule.php',
                beforeSend: function(){
                    $("#loader_create_matricule").show();
                },
                success: function(response){
                    console.log(response);
                    $('.matricule').addClass('active-create-admin-span');
                    $('#matricule_adm').val(response);
                },
                complete: function(){
                    $("#loader_create_matricule").hide();
                }
            });
        })

        $(document).on('click','.admin-autoisation',function(){
            var etat = $(this).find('.etat');
            if ($(this).find('.etat').attr('class') == 'fas fa-check etat') {
                etat.replaceWith('<i style="color:red" class="fas fa-ban etat"></i>');
                $(this).find('input').val('0');
            }
            else{
                etat.replaceWith('<i class="fas fa-check etat"></i>');
                $(this).find('input').val('1');
            }
        })

        $(document).on('click','#create_boutique_admin',function(e){
            var matriculeAdm = $('#matricule_adm').val();
            var nomAdm = $('#nom_adm').val();
            var mtpAdm = $('#mtp_adm').val();
            var cnfrmMtpAdm = $('#cnfrm_mtp_adm').val();

            if (matriculeAdm == '') {
                $('#matricule_adm').css('border','2px solid red');
            }
            else if (nomAdm == '') {
                $('#matricule_adm').css('border','');
                $('#nom_adm').css('border','2px solid red');
            }
            else if (mtpAdm == '') {
                $('#matricule_adm').css('border','');
                $('#nom_adm').css('border','');
                $('#mtp_adm').css('border','2px solid red');
            }
            else if (cnfrmMtpAdm == '') {
                $('#matricule_adm').css('border','');
                $('#nom_adm').css('border','');
                $('#mtp_adm').css('border','');
                $('#cnfrm_mtp_adm').css('border','2px solid red');
            }
            else if (mtpAdm != '' &&cnfrmMtpAdm != '' && mtpAdm != cnfrmMtpAdm) {
                $('#matricule_adm').css('border','');
                $('#nom_adm').css('border','');
                $('#mtp_adm').css('border','');
                $('#cnfrm_mtp_adm').css('border','2px solid red');
            }
            else{
                $('#matricule_adm').css('border','');
                $('#nom_adm').css('border','');
                $('#mtp_adm').css('border','');
                $('#cnfrm_mtp_adm').css('border','');
                
                var fd = new FormData();
                var idBtq = $('#id_boutique_product').val();
                fd.append('id_btq',idBtq);
                fd.append('matricule_adm',matriculeAdm);
                fd.append('nom_adm',nomAdm);
                fd.append('mtp_adm',mtpAdm);
                var messagerieAdmAutrs = $('#messagerie_adm_autrs').val();
                fd.append('messagerie',messagerieAdmAutrs);
                var notificationsAdmAutrs = $('#notifications_adm_autrs').val();
                fd.append('notifications',notificationsAdmAutrs);
                var modificationAdmAutrs = $('#modification_adm_autrs').val();
                fd.append('modification',modificationAdmAutrs);
                var creationPrdAdmAutrs = $('#creation_prd_adm_autrs').val();
                fd.append('creation_prd',creationPrdAdmAutrs);
                var modificationPrdAdmAutrs = $('#modification_prd_adm_autrs').val();
                fd.append('modification_prd',modificationPrdAdmAutrs);
                var suppressionPrdAdmAutrs = $('#suppression_prd_adm_autrs').val();
                fd.append('suppression_prd',suppressionPrdAdmAutrs);
                var creationCtgAdmAutrs = $('#creation_ctg_adm_autrs').val();
                fd.append('creation_ctg',creationCtgAdmAutrs);
                var modificationCtgAdmAutrs = $('#modification_ctg_adm_autrs').val();
                fd.append('modification_ctg',modificationCtgAdmAutrs);
                var suppressionCtgAdmAutrs = $('#suppression_ctg_adm_autrs').val();
                fd.append('suppression_ctg',suppressionCtgAdmAutrs);
                $.ajax({
                    url: 'create-admin-boutique.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $('.create-admin-boutique').css('opacity','0.4');
                        $("#loader_gb_right").show();
                    },
                    success: function(response){
                        if(response != 0){
                            $(".boutique-container").empty();
                            $('.boutique-container').append(response);
                        }
                    },
                    complete: function(){
                        $("#loader_gb_right").hide();
                    }
                });
            }
        })

        $(document).on('click','#update_boutique_admin',function(e){
            var fd = new FormData();
            var idBtq = $('#id_boutique_product').val();
            fd.append('id_btq',idBtq);
            var messagerieAdmAutrs = $('#messagerie_adm_autrs').val();
            fd.append('messagerie',messagerieAdmAutrs);
            var notificationsAdmAutrs = $('#notifications_adm_autrs').val();
            fd.append('notifications',notificationsAdmAutrs);
            var modificationAdmAutrs = $('#modification_adm_autrs').val();
            fd.append('modification',modificationAdmAutrs);
            var creationPrdAdmAutrs = $('#creation_prd_adm_autrs').val();
            fd.append('creation_prd',creationPrdAdmAutrs);
            var modificationPrdAdmAutrs = $('#modification_prd_adm_autrs').val();
            fd.append('modification_prd',modificationPrdAdmAutrs);
            var suppressionPrdAdmAutrs = $('#suppression_prd_adm_autrs').val();
            fd.append('suppression_prd',suppressionPrdAdmAutrs);
            var creationCtgAdmAutrs = $('#creation_ctg_adm_autrs').val();
            fd.append('creation_ctg',creationCtgAdmAutrs);
            var modificationCtgAdmAutrs = $('#modification_ctg_adm_autrs').val();
            fd.append('modification_ctg',modificationCtgAdmAutrs);
            var suppressionCtgAdmAutrs = $('#suppression_ctg_adm_autrs').val();
            fd.append('suppression_ctg',suppressionCtgAdmAutrs);
            $.ajax({
                url: 'update-admin-boutique.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $('.boutique-admin-info').css('opacity','0.4');
                    $("#loader_gb_right").show();
                },
                success: function(response){
                    if(response != 0){
                        $(".boutique-container").empty();
                        $('.boutique-container').append(response);
                    }
                },
                complete: function(){
                    $('.boutique-admin-info').css('opacity','');
                    $("#loader_gb_right").hide();
                }
            });
        })

        // delete boutique
        $(document).on('click','#delete_btq_button',function(){
            $("body").addClass('body-after');
            if (windowWidth > 768) {
                $('#delete_boutique').show();
            }else{
                $('#delete_boutique').css('transform','translateY(0)');
            }
        });

        $('#delete_boutique_button').click(function(){
            var fd = new FormData();
            var idBtq = $('#id_boutique_product').val();
            fd.append('id_btq',idBtq);
            $.ajax({
                url: 'delete-boutique.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".delete-boutique").css('opacity','0.5');
                    $("#loader_delete_btq").show();
                },
                success: function(response){
                    if(response != 0){
                        $('#delete_boutique').hide();
                        $("body").removeClass('body-after');
                        $('.gb-delete-alert').css('transform','translateY(0)');
                    }
                },
                complete: function(){
                    $("#loader_delete_btq").hide();
                    $(".delete-boutique").css('opacity','');
                    setTimeout(() => {
                        $('.gb-delete-alert').css('transform','');
                    }, 4000);
                }
            });
        });

        $('#cancel_delete_boutique').click(function(e){
            e.stopPropagation();
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $('#delete_boutique').hide();
            }else{
                $('#delete_boutique').css('transform','');
            }
        });

        $('#cancel_delete_btq_button').click(function(e){
            e.stopPropagation();
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $('#delete_boutique').hide();
            }else{
                $('#delete_boutique').css('transform','');
            }
        });

        $('#delete_boutique').click(function(e){
            $("body").removeClass('body-after');
            if (windowWidth > 768) {
                $('#delete_boutique').hide();
            }else{
                $('#delete_boutique').css('transform','');
            }
        });

        $('#delete_boutique_container').click(function(e){
            e.stopPropagation();
        });

        // responsive
        $('#display_gb_manager_resp').click(function(e){
            e.stopPropagation();
            setTimeout(() => {
                $('body').addClass('body-after');
            }, 0);
            $('.gerer-boutique-left').css('transform','translateX(0)');
        })

        $('#gerer_boutique_recherche_responsive').click(function(e){
            e.stopPropagation();
        })

        $('#display_gb_search_bar').click(function(e){
            e.stopPropagation();
            setGererBoutiqueSearchBar();
        })

        $(document).on('click','#back_sender',function(){
            $('.boutique-message-right').css('transform','');
        })

        function updateSenderMessage(userId,senderId){
            var fd = new FormData();
            fd.append('id_user',userId);
            fd.append('id_sender',senderId);
            $.ajax({
                url: 'update-messagerie-sender.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response != 0){

                    }
                }
            });
        }

        $(document).on('keypress',"#recherche_text",function() {
            if (event.which == 13) {
                var fd = new FormData();
                var rechercheText = $('#recherche_text').val();
                fd.append('text',rechercheText);
                var idBtq = $('#id_boutique_product').val();
                fd.append('id_btq',idBtq);
                $.ajax({
                    url: 'recherche-gb-boutique-product.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $(".boutique-container").empty();
                        $("#loader_gb_right").show();
                    },
                    success: function(response){
                        $('.boutique-container').append(response);
                    },
                    complete: function(response){
                        $("#loader_gb_right").hide();
                    }
                });
            }
        });

        $(document).on('keypress',"#recherche_text_resp",function() {
            if (event.which == 13) {
                var fd = new FormData();
                var rechercheText= $('#recherche_text_resp').val();
                fd.append('text',rechercheText);
                var idBtq = $('#id_boutique_product').val();
                fd.append('id_btq',idBtq);
                $.ajax({
                    url: 'recherche-gb-boutique-product.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $(".boutique-container").empty();
                        $("#loader_gb_right").show();
                    },
                    success: function(response){
                        $('.boutique-container').append(response);
                    },
                    complete: function(response){
                        unsetGererBoutiqueSearchBar();
                        $("#loader_gb_right").hide();
                    }
                });
            }
        });

        var uid = <?php echo $uid ?>;
        var websocket_server = 'ws://<?php echo $_SERVER['HTTP_HOST']; ?>:3030?uid='+uid;
        var websocket = false;
        var js_flood = 0;
        var status_websocket = 0;
        $(document).ready(function() {
            start(websocket_server);
        });
    </script>
    <script src="css-js/websocket.js"></script>
</body>
</html>