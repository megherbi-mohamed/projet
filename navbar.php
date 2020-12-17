<?php 
$indexActive = ''; $indexRespActive = ''; $indexActiveResponsive = '';
$promotionsActive = ''; $promotionsRespActive = ''; $promotionsActiveResponsive = '';
$evenementsActive = ''; $evenementsRespActive = ''; $evenementsActiveResponsive = '';
$boutdechantierActive = ''; $boutdechantierRespActive = ''; $boutdechantierActiveResponsive = '';
$utilisateurActive = '';
// $recrutementsActive = '';
if ($_SERVER['REQUEST_URI'] == '/projet/index') {
    $indexActive = 'active';
    $indexActiveResponsive = 'active-navbar-icon';
    $indexRespActive = 'hide-menu-left-list-active';
}
elseif ($_SERVER['REQUEST_URI'] == '/projet/promotions') {
    $promotionsActive = 'active';
    $promotionsActiveResponsive = 'active-navbar-icon';
    $promotionsRespActive = 'hide-menu-left-list-active';
}
elseif ($_SERVER['REQUEST_URI'] == '/projet/evenements') {
    $evenementsActive = 'active';
    $evenementsActiveResponsive = 'active-navbar-icon';
    $evenementsRespActive = 'hide-menu-left-list-active';
}
elseif ($_SERVER['REQUEST_URI'] == '/projet/boutdechantier') {
    $boutdechantierActive = 'active';
    $boutdechantierActiveResponsive = 'active-navbar-icon';
    $boutdechantierRespActive = 'hide-menu-left-list-active';
}
// elseif ($_SERVER['REQUEST_URI'] == '/projet/recrutements.php'|| $_SERVER['REQUEST_URI'] == '/projet/offre.php') {
//     $recrutementsActive = 'active';
// }
elseif ($_SERVER['REQUEST_URI'] == '/projet/offre.php') {
    $offreActive = 'active';
}
elseif ($_SERVER['REQUEST_URI'] == '/projet/utilisateur') {
    $utilisateurActive = 'profile-image-desktop-active';
}

if (isset($_SESSION['user'])) {

    $num_msg_query = $conn->prepare("SELECT id_msg FROM messages WHERE id_sender = '$id_user' AND etat_sender_msg = '$id_user' GROUP BY id_recever");    
    $num_msg_query->execute();
    $num_msg_row = $num_msg_query->rowCount();
    $show_message = '';
    if ($num_msg_row > 0) {
        $show_message = 'style="display:block"';
    }

    $id = ','.$id_user.',';
    $num_ntf1_query = $conn->prepare("SELECT id_ntf FROM publications_notifications WHERE (type_ntf = 'publication' OR type_ntf = 'produit') AND vu_ntf NOT LIKE '%$id%' AND id_sender_ntf IN (SELECT id_abn_user AS id FROM abonnes WHERE id_user = $id_user) AND (type_ntf = 'publication' OR type_ntf = 'produit') AND id_recever_ntf IN (SELECT id_abn_user AS id FROM abonnes WHERE id_user = $id_user)");    
    $num_ntf1_query->execute();

    $num_ntf2_query = $conn->prepare("SELECT id_ntf FROM publications_notifications WHERE id_recever_ntf = $id_user AND id_sender_ntf != $id_user AND etat_ntf = 1");    
    $num_ntf2_query->execute();

    $num_ntf_row = $num_ntf1_query->rowCount() + $num_ntf2_query->rowCount();
    $show_notification = '';
    if ($num_ntf_row > 0) {
        $show_notification = 'style="display:block"';
    }

    $num_prd_query = $conn->prepare("SELECT id FROM produit_panier WHERE id_user = '{$row["id_user"]}'");    
    $num_prd_query->execute();
    $num_prd = $num_prd_query->rowCount();
    $etat_panier = '';
    if ($num_prd > 0) {
        $etat_panier = 'active-panier-num';
    }else{ $etat_panier = ''; }
}
?>
<?php $session='1'; if(!isset($_SESSION['user'])){$session='0';}?> 
<input type="hidden" id="vs" value="<?php echo $session;?>">
<?php if (isset($_SESSION['user'])){ ?>
<div class="hide-menu">
    <div class="hide-menu-left">
        <div class="hide-menu-logo">
            <h4>Nhannik</h4>
        </div>
        <div class="hide-menu-left-list <?php echo $indexRespActive ?>" id="home_button"><div><i class="fas fa-home"></i></div><p>acceuil</p></div>
        <!-- <div class="hide-menu-left-list" id="categories_button"><div><i class="fas fa-list"></i></div><p>categories</p></div> -->
        <div class="hide-menu-left-list <?php echo $boutdechantierRespActive ?>" id="boutdechantier_button"><div><i class="fas fa-store"></i></div><p>bout de chantier</p></div>
        <!-- <div class="hide-menu-left-list" id="recrutements_button"><div><i class="fas fa-briefcase"></i></div><p>recrutements</p></div> -->
        <div class="hide-menu-left-list <?php echo $promotionsRespActive ?>" id="promotions_button"><div><i class="fas fa-tag"></i></div><p>promotions</p></div>
        <div class="hide-menu-left-list <?php echo $evenementsRespActive ?>" id="evenements_button"><div><i class="far fa-calendar-check"></i></div><p>évènements</p></div>
        <div class="hide-menu-footer">
            <h4>Nhannik &copy; 2020</h4>
        </div>
    </div>
</div>
<div class="navbar">
    <div class="navbar-container">
        <div class="navbar-left">
            <div class="show-hide-menu" id="show_hide_menu">
                <i  class="fas fa-bars"></i>
            </div>
            <div class="logo-name">
                <h4>Nhannik</h4>
            </div>
            <div class="show-search-bar-rsp" id="show_search_bar_rsp">
                <i  class="fas fa-search"></i>
            </div>
            <div class="categorie-search-bar">
                <input type="text" id="categorie_search_button" placeholder="Saisissez votre recherche" autocomplete="off">
                <div id="search_bar_button">
                    <i class="fas fa-search"></i>
                </div>
                <?php 
                $numUrlPart = substr_count($_SERVER['REQUEST_URI'],'/');
                if ($numUrlPart == 2) {
                    $url = explode('/', $_SERVER['REQUEST_URI'], 2)[1];
                }
                else if ($numUrlPart >= 3) {
                    $url = 'projet/'.explode('/', $_SERVER['REQUEST_URI'], -1)[2];
                }
                if ($url == 'projet/profile-parametres') { ?>
                <div id="parameters_profile_button">
                    <i class="fas fa-cog"></i>
                </div>
                <?php } else if ($url == 'projet/evenements') { ?>
                <div id="parameters_evenements_button">
                    <i class="fas fa-filter"></i>
                </div>
                <?php } else if ($url == 'projet/promotions') { ?>
                <div id="parameters_promotions_button">
                    <i class="fas fa-filter"></i>
                </div>
                <?php } else if ($url == 'projet/gerer-boutique') { ?>
                <div id="parameters_gererboutique_button">
                    <i class="fas fa-cog"></i>
                </div>
                <?php } else if ($url == 'projet/boutdechantier') { ?>
                <div id="parameters_boutdechantier_button">
                    <i class="fas fa-filter"></i>
                </div>
                <?php } else if ($url == 'projet/recherche') {?>
                <div id="parameters_recherche_button">
                    <i class="fas fa-filter"></i>
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="navbar-middle">
            <div><a class="<?php echo $indexActive; ?>" href="index">acceuil</a></div>
            <div><a class="<?php echo $boutdechantierActive; ?>" href="boutdechantier">Bout de chantier</a></div>
            <div><a class="<?php echo $promotionsActive; ?>" href="promotions">promotions</a></div>
            <div><a class="<?php echo $evenementsActive; ?>" href="evenements">évènements</a></div>
            <!-- <a class="<?php echo $recrutementsActive; ?>" href="./recrutements.php">recrutement</a> -->
        </div>
        <div class="navbar-middle-responsive">
            <a href="index"><div  class="<?php echo $indexActiveResponsive; ?>" id="go_home"><i class="fas fa-home"></i></div></a>
            <a href="boutdechantier"><div class="<?php echo $boutdechantierActiveResponsive; ?>" id="go_boutdechantier"><i class="fas fa-store"></i></div></a>
            <a href="promotions"><div class="<?php echo $promotionsActiveResponsive; ?>" id="go_promotions"><i class="fas fa-tag"></i></div></a>
            <a href="evenements"><div class="<?php echo $evenementsActiveResponsive; ?>" id="go_evenements"><i class="far fa-calendar-check"></i></div></a>
        </div>
        <div class="navbar-right">
            <div class="profile-image-desktop <?php echo $utilisateurActive ?>">
                <img src="<?php if($row['img_user']==''){echo'./images/profile.png';}else{echo './'.$row['img_user'];}?>" alt="profile user">
                <p><?php echo $row['nom_user']; ?></p>
            </div>
            <div class="navbar-right-icon" id="create_new"><i class="fas fa-plus"></i></div>
            <div class="navbar-right-icon" id="user_list_messages"><i class="fab fa-facebook-messenger"></i><div class="user-new-msg"><div <?php echo $show_message ?> id="user_new_msg"><span><?php echo $num_msg_row; ?></span></div></div></div>
            <div class="navbar-right-icon" id="user_list_notifications"><i class="fas fa-bell"></i><div class="user-new-ntf"><div <?php echo $show_notification ?> id="user_new_ntf"><span><?php echo $num_ntf_row; ?></span></div></div></div>
            <div class="navbar-right-icon" id="user_list_panier"><i class="fas fa-shopping-basket"></i></div>
            <div class="navbar-right-icon" id="user_list_button" class="user-nav-notifications"><i style="font-size:1.4rem;top:40%" class="fas fa-sort-down"></i></div>
            <input type="hidden" id="id_user_porfile" value="<?php echo $id_user ?>">
            <input type="hidden" id="id_session_porfile" value="<?php echo $id_session ?>">
        </div>
    </div>
</div>
<div class="categorie-professionnel">
    <?php if ($url == 'projet/recherche' || $url == 'projet/gerer-boutique' || $url == 'projet/boutique' || $url == 'projet/utilisateur' || $url == 'projet/index') { ?>
    <div class="categorie-recherche-tout" id="categorie_recherche_tout" style="visibility:visible;transform:translate(0)">
    <?php } else { ?>    
    <div class="categorie-recherche-tout" id="categorie_recherche_tout">
    <?php } ?> 
        <div class="categorie-professionnel-top">
            <div class="cancel-categorie-recherche" id="cancel_recherche_tout">
                <i class="fas fa-arrow-left"></i>
            </div>
            <div class="categorie-search-bar-rspsv">
                <input type="text" id="recherche_tout_text" placeholder="Recherche dans toutes les categories" autocomplete="off">
                <i class="fas fa-search"></i>
                <div id="loader_recherche_text" class="center"></div>
            </div>
        </div>
        <div class="categorie-professionnel-bottom">
            <div class="categorie-professionnel-bottom-container" id="recherche_tout_container"></div>
            <div id="loader_search_all" class="center"></div>
        </div>
    </div>
    <div class="categorie-recherche-tout" id="categorie_recherche_professionnel">
        <div class="categorie-professionnel-top">
            <div class="cancel-categorie-recherche" id="cancel_recherche_other_search">
                <i class="fas fa-arrow-left"></i>
            </div>
            <div class="categorie-search-bar-rspsv">
                <input type="text" id="recherche_professionnel_text" placeholder="Rechercher - professionnels ou entreprises" autocomplete="off">
                <i class="fas fa-search"></i>
                <div id="loader_professionnel_recherche_text" class="center"></div>
            </div>
        </div>
        <div class="categorie-professionnel-bottom">
            <div class="categorie-professionnel-bottom-container" id="recherche_professionnel_container"></div>
            <div id="loader_search_professionnel" class="center"></div>
        </div>
    </div>
    <div class="categorie-recherche-tout" id="categorie_recherche_boutique">
        <div class="categorie-professionnel-top">
            <div class="cancel-categorie-recherche" id="cancel_recherche_other_search">
                <i class="fas fa-arrow-left"></i>
            </div>
            <div class="categorie-search-bar-rspsv">
                <input type="text" id="recherche_boutique_text" placeholder="Rechercher - boutiques" autocomplete="off">
                <i class="fas fa-search"></i>
                <div id="loader_boutique_recherche_text" class="center"></div>
            </div>
        </div>
        <div class="categorie-professionnel-bottom">
            <div class="categorie-professionnel-bottom-container" id="recherche_boutique_container"></div>
            <div id="loader_search_boutique" class="center"></div>
        </div>
    </div>
    <div class="categorie-recherche-tout" id="categorie_recherche_product">
        <div class="categorie-professionnel-top">
            <div class="cancel-categorie-recherche" id="cancel_recherche_other_search">
                <i class="fas fa-arrow-left"></i>
            </div>
            <div class="categorie-search-bar-rspsv">
                <input type="text" id="recherche_product_text" placeholder="Rechercher - produits boutique" autocomplete="off">
                <i class="fas fa-search"></i>
                <div id="loader_product_recherche_text" class="center"></div>
            </div>
        </div>
        <div class="categorie-professionnel-bottom">
            <div class="categorie-professionnel-bottom-container" id="recherche_product_container"></div>
            <div id="loader_search_product" class="center"></div>
        </div>
    </div>
    <?php if ($url == 'projet/boutdechantier') { ?>
    <div class="categorie-recherche-tout" id="categorie_recherche_boutdechantier" style="visibility:visible;transform:translate(0)">
    <?php } else { ?>    
    <div class="categorie-recherche-tout" id="categorie_recherche_boutdechantier">
    <?php } ?> 
        <div class="categorie-professionnel-top">
            <div class="cancel-categorie-recherche" id="cancel_recherche_other_search">
                <i class="fas fa-arrow-left"></i>
            </div>
            <div class="categorie-search-bar-rspsv">
                <input type="text" id="recherche_boutdechantier_text" placeholder="Rechercher - produits bout de chantier" autocomplete="off">
                <i class="fas fa-search"></i>
                <div id="loader_boutdechantier_recherche_text" class="center"></div>
            </div>
        </div>
        <div class="categorie-professionnel-bottom">
            <div class="categorie-professionnel-bottom-container" id="recherche_boutdechantier_container"></div>
            <div id="loader_search_boutdechantier" class="center"></div>
        </div>
    </div>
    <?php if ($url == 'projet/promotions') { ?>
    <div class="categorie-recherche-tout" id="categorie_recherche_promotion" style="visibility:visible;transform:translate(0)">
    <?php } else { ?>    
    <div class="categorie-recherche-tout" id="categorie_recherche_promotion">
    <?php } ?>
        <div class="categorie-professionnel-top">
            <div class="cancel-categorie-recherche" id="cancel_recherche_other_search">
                <i class="fas fa-arrow-left"></i>
            </div>
            <div class="categorie-search-bar-rspsv">
                <input type="text" id="recherche_promotion_text" placeholder="Recherchs - promotions" autocomplete="off">
                <i class="fas fa-search"></i>
                <div id="loader_promotion_recherche_text" class="center"></div>
            </div>
        </div>
        <div class="categorie-professionnel-bottom">
            <div class="categorie-professionnel-bottom-container" id="recherche_promotion_container"></div>
            <div id="loader_search_promotion" class="center"></div>
        </div>
    </div>
    <?php if ($url == 'projet/evenements') { ?>
    <div class="categorie-recherche-tout" id="categorie_recherche_evenement" style="visibility:visible;transform:translate(0)">
    <?php } else { ?>    
    <div class="categorie-recherche-tout" id="categorie_recherche_evenement">
    <?php } ?>
        <div class="categorie-professionnel-top">
            <div class="cancel-categorie-recherche" id="cancel_recherche_other_search">
                <i class="fas fa-arrow-left"></i>
            </div>
            <div class="categorie-search-bar-rspsv">
                <input type="text" id="recherche_evenement_text" placeholder="Rechercher - evenements" autocomplete="off">
                <i class="fas fa-search"></i>
            </div>
        </div>
        <div class="categorie-professionnel-bottom">
            <div class="categorie-professionnel-bottom-container" id="recherche_evenement_container"></div>
            <div id="loader_search_evenement" class="center"></div>
        </div>
    </div>
</div>
<div class="user-list-dropdown">
    <div class="user-list-dropdown-container"></div>
    <div id="loader_dropdown_list" class="center"></div>
</div>
<div class="user-list-messages">
    <div class="user-list-messages-top">
        <div id="cancel_user_list_messages">
            <i class="fas fa-arrow-left"></i>
        </div>
        <h4>Messages</h4>
    </div>
    <div class="user-list-bottom-message"></div>
    <div id="loader_list_message" class="center"></div>
</div>
<div class="user-list-notifications">
    <div class="user-list-notifications-top">
        <div id="cancel_user_list_notifications">
            <i class="fas fa-arrow-left"></i>
        </div>
        <h4>Notifications</h4>
    </div>
    <div class="user-list-bottom-notifications"></div>
    <div id="loader_list_notification" class="center"></div>
</div>
<div class="user-create-options">
    <div class="user-create-options-top">
        <div id="cancel_user_create_options">
            <i class="fas fa-arrow-left"></i>
        </div>
        <h4>Créer</h4>
    </div>
    <h4 class="create-h4">Créer</h4>
    <div class="create-option" id="pre_create_publication">
        <div>
            <i class="far fa-edit"></i>
        </div>
        <div>
            <p>Publication</p>
            <p>Partager vos activités et vos services ...</p>
        </div>
    </div>
    <div class="create-option" id="create_btq_button">
        <div>
            <i class="fas fa-store-alt"></i>
        </div>
        <div>
            <p>Boutique</p>
            <p>Crées vos boutiques personnalisées</p>
        </div>
    </div>
    <div class="create-option" id="create_bt_prd_button">
        <div>
            <i class="fas fa-store"></i>
        </div>
        <div>
            <p>Bout de chantier</p>
            <p>Créer un produit a vendre ou gratuit sur bout de chantier</p>
        </div>
    </div>
    <!-- <div class="create-option">
        <div>
            <i class="fas fa-bullhorn"></i>
        </div>
        <div>
            <p>Offre d'emploie</p>
            <p>Créer une offre d'emploie</p>
        </div>
    </div>
    <div class="create-option">
        <div>
            <i class="fas fa-bullhorn"></i>
        </div>
        <div>
            <p>demande d'emploie</p>
            <p>Créer une demande d'emploie</p>
        </div>
    </div> -->
    <div class="create-option" id="create_promotion_button">
        <div>
            <i class="fas fa-tag"></i>
        </div>
        <div>
            <p>promotion</p>
            <p>Créer une promotion</p>
        </div>
    </div>
    <div class="create-option" id="create_evenement_button">
        <div>
            <i class="far fa-calendar-check"></i>
        </div>
        <div>
            <p>évenement</p>
            <p>Créer un evènement</p>
        </div>
    </div>
    <div id="loader_create_button" class="center"></div>
</div>
<!-- create pulication -->
<div class="create-publication" id="create_publication">
    <div class="create-publication-container" id="create_publication_container"></div>
    <div id="loader_create_publication" class="center"></div>
</div>
<!-- update publication -->
<div class="create-publication" id="update_publication">
    <div class="create-publication-container" id="update_publication_container"></div>
    <div id="loader_update_publication" class="center"></div>
</div>
<!-- create boutique -->
<div class="create-publication" id="create_boutique">
    <div class="create-publication-container" id="create_boutique_container"></div>
    <div id="loader_create_boutique" class="center"></div>
</div>
<!-- create bt product -->
<div class="create-publication" id="create_bt_product">
    <div class="create-publication-container" id="create_bt_product_container"></div>
    <div id="loader_create_bt_product" class="center"></div>
</div>
<!-- create promotion -->
<div class="create-publication" id="create_promotion">
    <div class="create-global-promotion-container" id="create_global_promotion_container"></div>
    <div id="loader_create_promotion" class="center"></div>
</div>
<!-- create evenement -->
<div class="create-publication" id="create_evenement">
    <div class="create-publication-container" id="create_evenement_container"></div>
    <div id="loader_create_evenement" class="center"></div>
</div>
<div class="delete-hide-publication" id="hide_publication">
    <div class="delete-hide-publication-container" id="hide_publication_container">
        <input type="hidden" id="publication_tail_hide">
        <input type="hidden" id="id_publication_hide">
        <div class="delete-hide-publication-top">
            <h4>Masquer la publication ?</h4>
            <div class="cancel-delete-hide-publication" id="cancel_hide_publication">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="delete-hide-publication-middle">
            <p>Voulez vous vraiment masuqer cette publication ?</p>
            </div>
        <div class="delete-hide-publication-bottom">
            <div></div>
            <div></div>
            <button id="cancel_hide_pub_button">Annuler</button>
            <button id="hide_pub_button">Masquer</button>
        </div>
    </div>
</div>
<div class="delete-hide-publication" id="delete_publication">
    <div class="delete-hide-publication-container" id="delete_publication_container">
        <input type="hidden" id="publication_tail_delete">
        <input type="hidden" id="id_publication_delete">
        <div class="delete-hide-publication-top">
            <h4>Supprimer la publication ?</h4>
            <div class="cancel-delete-hide-publication" id="cancel_delete_publication">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="delete-hide-publication-middle">
            <p>Voulez vous vraiment Supprimer cette publication ?</p>
        </div>
        <div class="delete-hide-publication-bottom">
            <div></div>
            <div></div>
            <button id="cancel_delete_pub_button">Annuler</button>
            <button id="delete_pub_button">Supprimer</button>
        </div>
    </div>
</div>
<div class="delete-hide-publication" id="save_publication">
    <div class="delete-hide-publication-container" id="save_publication_container">
        <input type="hidden" id="publication_tail_save">
        <input type="hidden" id="id_publication_save">
        <div class="delete-hide-publication-top">
            <h4>Enregistrer la publication ?</h4>
            <div class="cancel-delete-hide-publication" id="cancel_save_publication">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="delete-hide-publication-middle">
            <p>Vous pouvez regarder cette publication plus tard.</p>
        </div>
        <div class="delete-hide-publication-bottom">
            <div></div>
            <div></div>
            <button id="cancel_save_pub_button">Annuler</button>
            <button id="save_pub_button">Enregistrer</button>
        </div>
    </div>
</div>
<div class="delete-hide-publication" id="delete_history">
    <div class="delete-hide-publication-container" id="delete_history_container">
        <input type="hidden" id="type_recherche">
        <div class="delete-hide-publication-top">
            <h4>Supprimer l'historiques ?</h4>
            <div class="cancel-delete-hide-publication" id="cancel_delete_history">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="delete-hide-publication-middle">
            <p>Voulez vous vraiment Supprimer l'historiques ?</p>
        </div>
        <div class="delete-hide-publication-bottom">
            <div></div>
            <div></div>
            <button id="cancel_delete_history_button">Annuler</button>
            <button id="delete_history_button">Supprimer</button>
        </div>
    </div>
</div>
<?php } else if (isset($_SESSION['btq'])) { ?>
<div class="navbar">
    <div class="navbar-container">
        <div class="navbar-left">
            <div class="logo-name">
                <h4>Nhannik</h4>
            </div>
            <div id="parameters_gererboutique_button">
                <i class="fas fa-cog"></i>
            </div>
        </div>
        <div class="navbar-middle"></div>
        <div class="navbar-middle-responsive"></div>
        <div class="navbar-right">
            <div class="profile-btq-desktop">
                <img src="<?php if($btq_inf_row['logo_btq']==''){echo'./images/profile.png';}else{echo './'.$btq_inf_row['logo_btq'];}?>" alt="btq_img">
                <p style="color:#000;width:100px"><?php echo $btq_inf_row['nom_btq']; ?></p>
            </div>
            <div class="btq-deconnexion-button" id="btq_logout">
                <p>Deconnexion</p>
            </div>
            <input type="hidden" id="id_btq_adm" value="<?php echo $_SESSION['btq'] ?>">
        </div>
    </div>
</div>
<input type="hidden" id="ville_boutique">
<input type="hidden" id="categorie_boutique">
<input type="hidden" id="sous_categorie_boutique">
<?php } else { ?>
    <div class="hide-menu">
    <div class="hide-menu-left">
        <div class="hide-menu-logo">
            <h4>Nhannik</h4>
        </div>
        <div class="hide-menu-left-list <?php echo $indexRespActive ?>" id="home_button"><div><i class="fas fa-home"></i></div><p>acceuil</p></div>
        <!-- <div class="hide-menu-left-list" id="categories_button"><div><i class="fas fa-list"></i></div><p>categories</p></div> -->
        <div class="hide-menu-left-list <?php echo $boutdechantierRespActive ?>" id="boutdechantier_button"><div><i class="fas fa-store"></i></div><p>bout de chantier</p></div>
        <!-- <div class="hide-menu-left-list" id="recrutements_button"><div><i class="fas fa-briefcase"></i></div><p>recrutements</p></div> -->
        <div class="hide-menu-left-list <?php echo $promotionsRespActive ?>" id="promotions_button"><div><i class="fas fa-tag"></i></div><p>promotions</p></div>
        <div class="hide-menu-left-list <?php echo $evenementsRespActive ?>" id="evenements_button"><div><i class="far fa-calendar-check"></i></div><p>évènements</p></div>
        <div class="hide-menu-login">
            <div id="gestion_boutique_button_responsive">
                <p>Gerer boutique</p>
            </div>
            <div id="inscription_connexion_button_responsive">
                <p>Inscrire/Connecter</p>
            </div>
        </div>
        <div class="hide-menu-footer">
            <h4>Nhannik &copy; 2020</h4>
        </div>
    </div>
</div>
<div class="navbar">
    <div class="navbar-container">
        <div class="navbar-left">
            <div class="show-hide-menu" id="show_hide_menu">
                <i class="fas fa-bars"></i>
            </div>
            <div class="logo-name">
                <h4>Nhannik</h4>
            </div>
            <div class="show-search-bar-rsp" id="show_search_bar_rsp">
                <i class="fas fa-search"></i>
            </div>
            <div class="categorie-search-bar">
                <input type="text" id="categorie_search_button" placeholder="Saisissez votre recherche" autocomplete="off">
                <div id="search_bar_button">
                    <i class="fas fa-search"></i>
                </div>
                <?php 
                $numUrlPart = substr_count($_SERVER['REQUEST_URI'],'/');
                if ($numUrlPart == 2) {
                    $url = explode('/', $_SERVER['REQUEST_URI'], 2)[1];
                }
                else if ($numUrlPart >= 3) {
                    $url = 'projet/'.explode('/', $_SERVER['REQUEST_URI'], -1)[2];
                }
                if ($url == 'projet/profile-parametres') { ?>
                <div id="parameters_profile_button">
                    <i class="fas fa-cog"></i>
                </div>
                <?php } else if ($url == 'projet/evenements') { ?>
                <div id="parameters_evenements_button">
                    <i class="fas fa-filter"></i>
                </div>
                <?php } else if ($url == 'projet/promotions') { ?>
                <div id="parameters_promotions_button">
                    <i class="fas fa-filter"></i>
                </div>
                <?php } else if ($url == 'projet/gerer-boutique') { ?>
                <div id="parameters_gererboutique_button">
                    <i class="fas fa-cog"></i>
                </div>
                <?php } else if ($url == 'projet/boutdechantier') { ?>
                <div id="parameters_boutdechantier_button">
                    <i class="fas fa-filter"></i>
                </div>
                <?php } else if ($url == 'projet/recherche') {?>
                <div id="parameters_recherche_button">
                    <i class="fas fa-filter"></i>
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="navbar-middle">
            <div><a class="<?php echo $indexActive; ?>" href="index">acceuil</a></div>
            <div><a class="<?php echo $boutdechantierActive; ?>" href="boutdechantier">Bout de chantier</a></div>
            <div><a class="<?php echo $promotionsActive; ?>" href="promotions">promotions</a></div>
            <div><a class="<?php echo $evenementsActive; ?>" href="evenements">évènements</a></div>
            <!-- <a class="<?php echo $recrutementsActive; ?>" href="./recrutements.php">recrutement</a> -->
        </div>
        <div class="navbar-middle-responsive">
            <a href="index"><div  class="<?php echo $indexActiveResponsive; ?>" id="go_home"><i class="fas fa-home"></i></div></a>
            <a href="boutdechantier"><div class="<?php echo $boutdechantierActiveResponsive; ?>" id="go_boutdechantier"><i class="fas fa-store"></i></div></a>
            <a href="promotions"><div class="<?php echo $promotionsActiveResponsive; ?>" id="go_promotions"><i class="fas fa-tag"></i></div></a>
            <a href="evenements"><div class="<?php echo $evenementsActiveResponsive; ?>" id="go_evenements"><i class="far fa-calendar-check"></i></div></a>
        </div>
        <div class="navbar-right-login">
            <div id="gestion_boutique_button">
                <!-- <i class="fas fa-store-alt"></i> -->
                <p>Gerer boutique</p>
            </div>
            <div id="inscription_connexion_button">
                <!-- <i class="fas fa-sign-in-alt"></i> -->
                <p>Inscrire/Connecter</p>
            </div>
        </div>
    </div>
</div>
<div class="categorie-professionnel">
    <?php if ($url == 'projet/inscription-connexion' || $url == 'projet/gestion-boutique-connexion' || $url == 'projet/recherche' || $url == 'projet/gerer-boutique' || $url == 'projet/boutique' || $url == 'projet/utilisateur' || $url == 'projet/index') { ?>
    <div class="categorie-recherche-tout" id="categorie_recherche_tout" style="visibility:visible;transform:translate(0)">
    <?php } else { ?>    
    <div class="categorie-recherche-tout" id="categorie_recherche_tout">
    <?php } ?> 
        <div class="categorie-professionnel-top">
            <div class="cancel-categorie-recherche" id="cancel_recherche_tout">
                <i class="fas fa-arrow-left"></i>
            </div>
            <div class="categorie-search-bar-rspsv">
                <input type="text" id="recherche_tout_text" placeholder="Recherche dans toutes les categories" autocomplete="off">
                <i class="fas fa-search"></i>
                <div id="loader_recherche_text" class="center"></div>
            </div>
        </div>
        <div class="categorie-professionnel-bottom">
            <div class="categorie-professionnel-bottom-container" id="recherche_tout_container"></div>
            <div id="loader_search_all" class="center"></div>
        </div>
    </div>
    <div class="categorie-recherche-tout" id="categorie_recherche_professionnel">
        <div class="categorie-professionnel-top">
            <div class="cancel-categorie-recherche" id="cancel_recherche_other_search">
                <i class="fas fa-arrow-left"></i>
            </div>
            <div class="categorie-search-bar-rspsv">
                <input type="text" id="recherche_professionnel_text" placeholder="Rechercher - professionnels ou entreprises" autocomplete="off">
                <i class="fas fa-search"></i>
                <div id="loader_professionnel_recherche_text" class="center"></div>
            </div>
        </div>
        <div class="categorie-professionnel-bottom">
            <div class="categorie-professionnel-bottom-container" id="recherche_professionnel_container"></div>
            <div id="loader_search_professionnel" class="center"></div>
        </div>
    </div>
    <div class="categorie-recherche-tout" id="categorie_recherche_boutique">
        <div class="categorie-professionnel-top">
            <div class="cancel-categorie-recherche" id="cancel_recherche_other_search">
                <i class="fas fa-arrow-left"></i>
            </div>
            <div class="categorie-search-bar-rspsv">
                <input type="text" id="recherche_boutique_text" placeholder="Rechercher - boutiques" autocomplete="off">
                <i class="fas fa-search"></i>
                <div id="loader_boutique_recherche_text" class="center"></div>
            </div>
        </div>
        <div class="categorie-professionnel-bottom">
            <div class="categorie-professionnel-bottom-container" id="recherche_boutique_container"></div>
            <div id="loader_search_boutique" class="center"></div>
        </div>
    </div>
    <div class="categorie-recherche-tout" id="categorie_recherche_product">
        <div class="categorie-professionnel-top">
            <div class="cancel-categorie-recherche" id="cancel_recherche_other_search">
                <i class="fas fa-arrow-left"></i>
            </div>
            <div class="categorie-search-bar-rspsv">
                <input type="text" id="recherche_product_text" placeholder="Rechercher - produits boutique" autocomplete="off">
                <i class="fas fa-search"></i>
                <div id="loader_product_recherche_text" class="center"></div>
            </div>
        </div>
        <div class="categorie-professionnel-bottom">
            <div class="categorie-professionnel-bottom-container" id="recherche_product_container"></div>
            <div id="loader_search_product" class="center"></div>
        </div>
    </div>
    <?php if ($url == 'projet/boutdechantier') { ?>
    <div class="categorie-recherche-tout" id="categorie_recherche_boutdechantier" style="visibility:visible;transform:translate(0)">
    <?php } else { ?>    
    <div class="categorie-recherche-tout" id="categorie_recherche_boutdechantier">
    <?php } ?> 
        <div class="categorie-professionnel-top">
            <div class="cancel-categorie-recherche" id="cancel_recherche_other_search">
                <i class="fas fa-arrow-left"></i>
            </div>
            <div class="categorie-search-bar-rspsv">
                <input type="text" id="recherche_boutdechantier_text" placeholder="Rechercher - produits bout de chantier" autocomplete="off">
                <i class="fas fa-search"></i>
                <div id="loader_boutdechantier_recherche_text" class="center"></div>
            </div>
        </div>
        <div class="categorie-professionnel-bottom">
            <div class="categorie-professionnel-bottom-container" id="recherche_boutdechantier_container"></div>
            <div id="loader_search_boutdechantier" class="center"></div>
        </div>
    </div>
    <?php if ($url == 'projet/promotions') { ?>
    <div class="categorie-recherche-tout" id="categorie_recherche_promotion" style="visibility:visible;transform:translate(0)">
    <?php } else { ?>    
    <div class="categorie-recherche-tout" id="categorie_recherche_promotion">
    <?php } ?>
        <div class="categorie-professionnel-top">
            <div class="cancel-categorie-recherche" id="cancel_recherche_other_search">
                <i class="fas fa-arrow-left"></i>
            </div>
            <div class="categorie-search-bar-rspsv">
                <input type="text" id="recherche_promotion_text" placeholder="Recherchs - promotions" autocomplete="off">
                <i class="fas fa-search"></i>
                <div id="loader_promotion_recherche_text" class="center"></div>
            </div>
        </div>
        <div class="categorie-professionnel-bottom">
            <div class="categorie-professionnel-bottom-container" id="recherche_promotion_container"></div>
            <div id="loader_search_promotion" class="center"></div>
        </div>
    </div>
    <?php if ($url == 'projet/evenements') { ?>
    <div class="categorie-recherche-tout" id="categorie_recherche_evenement" style="visibility:visible;transform:translate(0)">
    <?php } else { ?>    
    <div class="categorie-recherche-tout" id="categorie_recherche_evenement">
    <?php } ?>
        <div class="categorie-professionnel-top">
            <div class="cancel-categorie-recherche" id="cancel_recherche_other_search">
                <i class="fas fa-arrow-left"></i>
            </div>
            <div class="categorie-search-bar-rspsv">
                <input type="text" id="recherche_evenement_text" placeholder="Rechercher - evenements" autocomplete="off">
                <i class="fas fa-search"></i>
            </div>
        </div>
        <div class="categorie-professionnel-bottom">
            <div class="categorie-professionnel-bottom-container" id="recherche_evenement_container"></div>
            <div id="loader_search_evenement" class="center"></div>
        </div>
    </div>
</div>
<input type="hidden" id="ville_boutique">
<input type="hidden" id="categorie_boutique">
<input type="hidden" id="sous_categorie_boutique">
<div class="user-list-dropdown" style="display:none">
    <a id="modify_profile"><i class="fas fa-cog"></i>Paramaitre</a>
    <a id="create_boutique_button"><i class="fas fa-plus"></i>Creer une boutique<span>Pro</span></a>
</div>
<div class="user-list-messages" style="display:none">
</div>
<div class="user-list-notifications" style="display:none">
</div>
<?php } ?>