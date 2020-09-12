<?php 
    $indexActive = '';
    $promotionsActive = '';
    $evenementsActive = '';
    $boutdechantierActive = '';
    $utilisateurActive = '';
    // $recrutementsActive = '';

    if ($_SERVER['REQUEST_URI'] == '/projet/index.php') {
        $indexActive = 'active';
    }
    elseif ($_SERVER['REQUEST_URI'] == '/projet/promotions.php') {
        $promotionsActive = 'active';
    }
    elseif ($_SERVER['REQUEST_URI'] == '/projet/evenements.php' || $_SERVER['REQUEST_URI'] == '/projet/evenement-details.php') {
        $evenementsActive = 'active';
    }
    elseif ($_SERVER['REQUEST_URI'] == '/projet/boutdechantier.php') {
        $boutdechantierActive = 'active';
    }
    // elseif ($_SERVER['REQUEST_URI'] == '/projet/recrutements.php'|| $_SERVER['REQUEST_URI'] == '/projet/offre.php') {
    //     $recrutementsActive = 'active';
    // }
    elseif ($_SERVER['REQUEST_URI'] == '/projet/offre.php') {
        $offreActive = 'active';
    }
    elseif ($_SERVER['REQUEST_URI'] == '/projet/utilisateur.php') {
        $utilisateurActive = 'profile-image-desktop-active';
    }

    if (isset($_SESSION['user'])) {

        $msg_query = "SELECT * FROM messages WHERE id_msg IN ( SELECT MAX(id_msg) FROM messages WHERE id_recever = {$row['id_user']} GROUP BY id_sender) ORDER BY id_msg DESC";
        $navbar_msg_result = mysqli_query($conn,$msg_query);

        $notification_query = "SELECT * FROM notifications WHERE id_recever_n = {$_SESSION['user']} ORDER BY id_n DESC";
        $notification_result = mysqli_query($conn,$notification_query);

        $num_msg_query = "SELECT id_msg FROM messages WHERE id_sender = $id_user AND etat_sender_msg = $id_user GROUP BY id_recever";    
        $num_msg_result = mysqli_query($conn,$num_msg_query);
        $num_msg_row = mysqli_num_rows($num_msg_result);
        $show_message = '';
        if ($num_msg_row > 0) {
            $show_message = 'style="display:block"';
        }

        $num_notf_query = "SELECT id_ntf FROM notifications WHERE id_recever_ntf = {$row['id_user']} AND etat_ntf = 1";    
        $num_notf_result = mysqli_query($conn,$num_notf_query);
        $num_notification = 0;
        while ($num_ntf_row = mysqli_fetch_assoc($num_notf_result)) {
            $num_notification++;
        }
        $etat_notification = '';
        if ($num_notification > 0) {
            $etat_notification = 'active-notification-num';
        }else{ $etat_notification = '';}

        $num_prd_query = "SELECT id FROM produit_panier WHERE id_user = {$row['id_user']}";    
        $num_prd_result = mysqli_query($conn,$num_prd_query);
        $num_prd = mysqli_num_rows($num_prd_result);
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
        <div id="home_button"><i class="fas fa-home"></i><p>acceuil</p></div>
        <div id="categories_button"><i class="fas fa-list"></i><p>categories</p></div>
        <div id="boutdechantier_button"><i class="fas fa-tools"></i><p>bout de chantier</p></div>
        <div id="recrutements_button"><i class="fas fa-briefcase"></i><p>recrutements</p></div>
        <div id="promotions_button"><i class="fas fa-ad"></i><p>promotions</p></div>
        <div id="evenements_button"><i class="far fa-calendar-check"></i><p>évènements</p></div>
        <h4>Nhanik &copy; 2020</h4>
    </div>
</div>
<div class="navbar">
    <div class="navbar-container">
        <div class="navbar-left">
            <div class="show-hide-menu">
                <i id="show_hide_menu" class="fas fa-bars"></i>
            </div>
            <div class="logo-name">
                <h4>Nhannik</h4>
            </div>
            <div class="show-search-bar-rsp">
                <i id="show_search_bar_rsp" class="fas fa-search"></i>
            </div>
            <div class="categorie-search-bar">
                <input type="text" id="categorie_search_button" placeholder="Saisissez votre recherche" autocomplete="off">
                <div id="search_bar_button">
                    <i class="fas fa-search"></i>
                </div>
            </div>
        </div>
        <div class="navbar-middle">
            <div><a class="<?php echo $indexActive; ?>" href="./index.php">acceuil</a></div>
            <div><a class="<?php echo $boutdechantierActive; ?>" href="./boutdechantier.php">Bout de chantier</a></div>
            <div><a class="<?php echo $promotionsActive; ?>" href="./promotions.php">promotions</a></div>
            <div><a class="<?php echo $evenementsActive; ?>" href="./evenements.php">évènements</a></div>
            <!-- <a class="<?php echo $recrutementsActive; ?>" href="./recrutements.php">recrutement</a> -->
        </div>
        <div class="navbar-right">
            <div class="profile-image-desktop <?php echo $utilisateurActive ?>">
                <img src="<?php if($row['img_user']==''){echo'./images/profile.png';}else{echo './'.$row['img_user'];}?>" alt="profile user">
                <p><?php echo $row['nom_user']; ?></p>
            </div>
            <div class="navbar-right-icon" id="create_new"><i class="fas fa-plus"></i></div>
            <div class="navbar-right-icon" id="user_list_messages"><i class="fab fa-facebook-messenger"></i><div class="user-new-msg"><div <?php echo $show_message ?> id="user_new_msg"><span><?php echo $num_msg_row; ?></span></div></div></div>
            <div class="navbar-right-icon" id="user_list_notifications"><i class="fas fa-bell"></i></div>
            <div class="navbar-right-icon" id="user_list_panier"><i class="fas fa-shopping-basket"></i></div>
            <div class="navbar-right-icon" id="user_list_button" class="user-nav-notifications"><i style="font-size:1.4rem;top:40%" class="fas fa-sort-down"></i></div>
            <input type="hidden" id="id_user_porfile" value="<?php echo $id_user ?>">
        </div>
    </div>
</div>
<div class="categorie-professionnel">
    <div class="categorie-professionnel-top">
        <div id="cancel_search_bar">
            <i class="fas fa-arrow-left"></i>
        </div>
        <div class="categorie-search-bar-rspsv">
            <input type="text" id="categorie_search" placeholder="Saisissez votre recherche" autocomplete="off">
            <i class="fas fa-search"></i>
            <button style="display:none" id="categorie_search_btn"></button>
        </div>
    </div>
    <div class="categorie-professionnel-bottom">
        <div class="categorie-professionnel-bottom-top">
            <div class="categorie-profss">
                <div class="categorie-profss-top">
                    <img src="./icons/bureau-icon.png" alt="">
                    <p>Services</p>
                </div>
                <div class="categorie-profss-bottom">
                    <?php 
                    $categories_query = "SELECT * FROM categories WHERE categories = 'services'";
                    $categories_result = mysqli_query($conn,$categories_query);
                    while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                    ?>
                    <a href="./recherche.php?r=<?php echo $categories_row['sous_categories'] ?>"><li><?php echo $categories_row['sous_categories'] ?></li></a>
                    <?php } ?>
                </div>
            </div>  
            <div class="categorie-profss">
                <div class="categorie-profss-top">
                    <img src="./icons/service-icon.png" alt="">
                    <p>Artisants</p>
                </div>
                <div class="categorie-profss-bottom">
                    <?php 
                    $categories_query = "SELECT * FROM categories WHERE categories = 'artisants'";
                    $categories_result = mysqli_query($conn,$categories_query);
                    while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                    ?>
                    <a href="./recherche.php?r=<?php echo $categories_row['sous_categories'] ?>"><li><?php echo $categories_row['sous_categories'] ?></li></a>
                    <?php } ?>
                </div>
            </div>
            <div class="categorie-profss">
                <div class="categorie-profss-top">
                    <img src="./icons/transport-icon.png" alt="">
                    <p>Transports</p>
                </div>
                <div class="categorie-profss-bottom">
                    <?php 
                    $categories_query = "SELECT * FROM categories WHERE categories = 'transports'";
                    $categories_result = mysqli_query($conn,$categories_query);
                    while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                    ?>
                    <a href="./recherche.php?r=<?php echo $categories_row['sous_categories'] ?>"><li><?php echo $categories_row['sous_categories'] ?></li></a>
                    <?php } ?>
                </div>
            </div>
            <div class="categorie-profss">
                <div class="categorie-profss-top">
                    <img src="./icons/service-icon.png" alt="">
                    <p>Locations</p>
                </div>
                <div class="categorie-profss-bottom">
                    <?php 
                    $categories_query = "SELECT * FROM categories WHERE categories = 'locations'";
                    $categories_result = mysqli_query($conn,$categories_query);
                    while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                    ?>
                    <a href="./recherche.php?r=<?php echo $categories_row['sous_categories'] ?>"><li><?php echo $categories_row['sous_categories'] ?></li></a>
                    <?php } ?>
                </div>
            </div>
            <div class="categorie-profss">
                <div class="categorie-profss-top">
                    <img src="./icons/entreprise-icon.png" alt="">
                    <p>Entreprises</p>
                </div>
                <div class="categorie-profss-bottom">
                    <?php 
                        $categories_query = "SELECT * FROM categories WHERE categories = 'entreprises'";
                        $categories_result = mysqli_query($conn,$categories_query);
                        while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                        ?>
                        <a href="./recherche.php?r=<?php echo $categories_row['sous_categories'] ?>"><li><?php echo $categories_row['sous_categories'] ?></li></a>
                    <?php } ?>
                </div>
            </div>
            <div class="categorie-profss">
                <div class="categorie-profss-top">
                    <img src="./icons/detaillon-icon.png" alt="">
                    <p>Detaillons</p>
                </div>
                <div class="categorie-profss-bottom">
                    <?php 
                        $categories_query = "SELECT * FROM categories WHERE categories = 'detaillons'";
                        $categories_result = mysqli_query($conn,$categories_query);
                        while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                        ?>
                        <a href="./recherche.php?r=<?php echo $categories_row['sous_categories'] ?>"><li><?php echo $categories_row['sous_categories'] ?></li></a>
                    <?php } ?>
                </div>
            </div>
            <div class="categorie-profss">
                <div class="categorie-profss-top">
                    <img src="./icons/grossiste-icon.png" alt="">
                    <p>Grossistes</p>
                </div>
                <div class="categorie-profss-bottom">
                    <?php 
                        $categories_query = "SELECT * FROM categories WHERE categories = 'grossistes'";
                        $categories_result = mysqli_query($conn,$categories_query);
                        while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                        ?>
                        <a href="./recherche.php?r=<?php echo $categories_row['sous_categories'] ?>"><li><?php echo $categories_row['sous_categories'] ?></li></a>
                    <?php } ?>
                </div>
            </div>
            <div class="categorie-profss">
                <div class="categorie-profss-top">
                    <img src="./icons/fabriquant-icon.png" alt="">
                    <p>Fabriquants</p>
                </div>
                <div class="categorie-profss-bottom">
                    <?php 
                        $categories_query = "SELECT * FROM categories WHERE categories = 'fabriquants'";
                        $categories_result = mysqli_query($conn,$categories_query);
                        while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                        ?>
                        <a href="./recherche.php?r=<?php echo $categories_row['sous_categories'] ?>"><li><?php echo $categories_row['sous_categories'] ?></li></a>
                    <?php } ?>
                </div>
            </div>
            <div class="categorie-profss">
                <div class="categorie-profss-top">
                    <img src="./icons/importateur-icon.png" alt="">
                    <p>Import - Export</p>
                </div>
                <div class="categorie-profss-bottom">
                    <?php 
                        $categories_query = "SELECT * FROM categories WHERE categories = 'import-export'";
                        $categories_result = mysqli_query($conn,$categories_query);
                        while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                        ?>
                        <a href="./recherche.php?r=<?php echo $categories_row['sous_categories'] ?>"><li><?php echo $categories_row['sous_categories'] ?></li></a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="categorie-professionnel-bottom-bottom"></div>
    </div>
</div>
<div class="user-list-dropdown">
    <div class="user-profile">
        <img src="<?php if($row['img_user']==''){echo'./images/profile.png';}else{echo './'.$row['img_user'];}?>" alt="profile user">
        <div>
            <p><?php echo $row['nom_user']; ?></p>
            <p>Voir votre profile</p>
        </div>
    </div>
    <hr>
    <div class="user-feedback">
        <div>
            <i class="fas fa-question-circle"></i>
        </div>
        <div>
            <p>Poser vos questions</p>
            <p>Aidez nous à ameliorer Nhannik</p>
        </div>
    </div>
    <div class="user-update-profile">
        <div>
            <i class="fas fa-cog"></i>
        </div>
        <p>Paramètres du profile</p>
    </div>
    <div class="user-logout">
        <div>
            <i class="fas fa-sign-out-alt"></i>
        </div>
        <p>Se déconnecter</p>
    </div>
</div>
<div class="user-list-messages">
    <div class="user-list-top-message"></div>
    <div id="loader_list_message" class="center-loader-list-message"></div>
</div>
<div class="user-list-notifications">
    <div class="user-list-top-notifications">
        <?php
        while ($notification_row = mysqli_fetch_assoc($notification_result)) {
        $notification_user_query = "SELECT * FROM utilisateurs WHERE id_user = {$notification_row['id_sender_n']}";
        $notification_user_result = mysqli_query($conn,$notification_user_query);
        $notification_user_row = mysqli_fetch_assoc($notification_user_result);
        $new_notification = '';
        if ($notification_row['etat_n'] == 1) { $new_notification = 'new-notification'; }
        else{ $new_notification= ''; }
        if ($notification_row['id_offre'] == 0) { ?>
        <a href="./utilisateur.php?a=<?php echo $notification_row['id_activity']; ?>">
        <?php }else{ ?>
        <a href="./offre.php?r=<?php echo $notification_row['id_offre']; ?>">
        <?php } ?>
        <div class="notification <?php echo $new_notification; ?>">
            <p><?php echo $notification_row['text_n'] ?></p>
            <p><?php echo 'Le '.$notification_row['date_n'].' '; ?><span><?php echo $notification_user_row['nom_user'] ?></span></p>
        </div>
        </a>
        <?php } ?>
    </div>
    <div class="user-list-bottom-notifications"></div>
</div>
<div class="user-create-options">
    <h4>Créer</h4>
    <div class="create-option" id="create_pub_button">
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
    <div class="create-option">
        <div>
            <i class="fas fa-tag"></i>
        </div>
        <div>
            <p>Bout de chantier</p>
            <p>Créer un produit a vendre ou gratuit sur bout de chantier</p>
        </div>
    </div>
    <div class="create-option">
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
    </div>
    <div class="create-option">
        <div>
            <i class="fas fa-ad"></i>
        </div>
        <div>
            <p>promotion</p>
            <p>Créer une promotion</p>
        </div>
    </div>
    <div class="create-option">
        <div>
            <i class="far fa-calendar-check"></i>
        </div>
        <div>
            <p>évenement</p>
            <p>Créer un evènement</p>
        </div>
    </div>
</div>
<div class="create-publication" id="create_publication">
    <div class="create-publication-container">
        <input type="hidden" id="id_publication">
        <div class="create-publication-top">
            <div class="cancel-create-mobile" id="cancel_create_publication_resp">
                <i class="fas fa-arrow-left"></i>
            </div>
            <h4>Créer une publication</h4>
            <div class="cancel-create" id="cancel_create_publication">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="create-publication-bottom">
            <div class="create-publication-location">
                <div>
                    <input type="text" id="publication_location_text" placeholder="Entrer un lieu ...">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
            </div>
            <div class="publication-preview-location">
                <?php 
                   $ville_query = "SELECT * FROM villes";
                   $ville_result = mysqli_query($conn, $ville_query); 
                   while ($ville_row = mysqli_fetch_assoc($ville_result)) {
                ?>
                <div id="publication_location_item"><p><?php echo $ville_row['ville']; ?></p></div>
                <?php } ?>    
            </div>
            <div class="create-publication-description">
                <textarea id="publication_description" placeholder="Exprimez vos activités, services ..."></textarea>
            </div>
            <div class="publication-images-preview-container">
                <div class="publication-images-preview"></div>
                <div id="loader_pub_img" class="center"></div>
            </div>
            <div class="publication-video-preview-container">
                <div class="publication-video-preview"></div>
                <div id="loader_pub_img" class="center"></div>
            </div>
            <div class="create-publication-options">
                <P>Ajouter des photos ou vidéo</P>
                <div id="add_publication_image">
                    <i class="far fa-images"></i>
                </div>
                <div id="add_publication_video">
                    <i class="fas fa-video"></i>
                </div>
            </div>
            <form enctype="multipart/form-data">
                <input type="file" id="image" name="images[]" accept="image/*" multiple>
                <input type="button" id="add_publication_image_button">
            </form>
            <form enctype="multipart/form-data">
                <input type="file" id="video" name="video" accept="video/*">
                <input type="button" id="add_publication_video_button">
            </form>
            <button id="create_publication_button">Publier</button>
        </div>
    </div>
</div>
<div class="create-publication" id="create_boutique">
    <div class="create-publication-container">
        <input type="hidden" id="id_boutique">
        <div class="create-publication-top">
            <div class="cancel-create-mobile" id="cancel_create_boutique_resp">
                <i class="fas fa-arrow-left"></i>
            </div>
            <h4>Créer votre Boutique maintenant !</h4>
            <div class="cancel-create" id="cancel_create_boutique">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="create-publication-bottom create-boutique-bottom">
            <div>
                <input type="text" id="nom_boutique" placeholder="Nom du boutique">
            </div>
            <div class="categories-boutique">
                <select id="categorie_boutique">
                    <option value="">Categories</option>
                    <option id="services" value="services">Services</option>
                    <option id="artisants" value="artisants">Artisants</option>
                    <option id="transports" value="transports">Transports</option>
                    <option id="locations" value="locations">Locations</option>
                    <option id="entreprises" value="entreprises">Entreprises</option>
                    <option id="detaillons" value="detaillons">Detaillons</option>
                    <option id="grossidtes" value="grossidtes">Grossistes</option>
                    <option id="fabriquants" value="fabriquants">Fabriquants</option>
                    <option id="import-export" value="import-export">Import-Export</option>
                </select>
            </div>
            <div class="sous-categorie-boutique">
                <select id="sous_categorie_boutique">
                    <option value="">Professions</option>
                </select>
            </div>
            <div class="sous-categorie-autre">
                <input type="text" id="sous_categorie_boutique" placeholder="Entrez votre profession">
            </div>
            <div>
                <select id="ville_boutique">
                    <option value="">Ville</option>
                    <?php 
                    $ville_query = "SELECT * FROM villes";
                    $ville_result = mysqli_query($conn, $ville_query); 
                    while ($ville_row = mysqli_fetch_assoc($ville_result)) {
                    ?>
                    <option value="<?php echo $ville_row['ville'] ?>"><?php echo $ville_row['ville'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="commune-boutique"> 
                <select id="commune_boutique">
                    <option value="">Commune</option>
                </select>
            </div>
            <div>
                <input type="text" id="adresse_boutique" placeholder="Adresse">
            </div>
            <div>
                <input type="text" id="email_boutique" placeholder="Email">
            </div>
            <div>
                <input type="text" id="tlph_boutique" placeholder="Numéro téléphone">
            </div>
            <button type="button" id="create_boutique_button">Créer</button>
        </div>
    </div>
</div>
<div class="create-publication" id="create_boutdechantier">
    <div class="create-publication-container">
        <div class="create-publication-top">
            <div class="cancel-create-mobile">
                <i class="fas fa-arrow-left"></i>
            </div>
            <h4>Créer une annonce</h4>
            <div class="cancel-create">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="create-publication-bottom">
            
        </div>
    </div>
</div>
<div class="create-publication" id="create_offre">
    <div class="create-publication-container">
        <div class="create-publication-top">
            <div class="cancel-create-mobile">
                <i class="fas fa-arrow-left"></i>
            </div>
            <h4>Créer une offre</h4>
            <div class="cancel-create">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="create-publication-bottom">
            
        </div>
    </div>
</div>
<div class="create-publication" id="create_demande">
    <div class="create-publication-container">
        <div class="create-publication-top">
            <div class="cancel-create-mobile">
                <i class="fas fa-arrow-left"></i>
            </div>
            <h4>Créer une demande</h4>
            <div class="cancel-create">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="create-publication-bottom">
            
        </div>
    </div>
</div>
<div class="create-publication" id="create_promotion">
    <div class="create-publication-container">
        <div class="create-publication-top">
            <div class="cancel-create-mobile">
                <i class="fas fa-arrow-left"></i>
            </div>
            <h4>Créer une promotion</h4>
            <div class="cancel-create">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="create-publication-bottom">
            
        </div>
    </div>
</div>
<div class="create-publication" id="create_evenement">
    <div class="create-publication-container">
        <div class="create-publication-top">
            <div class="cancel-create-mobile">
                <i class="fas fa-arrow-left"></i>
            </div>
            <h4>Créer un évènement</h4>
            <div class="cancel-create">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="create-publication-bottom">
            
        </div>
    </div>
</div>
<div class="update-publication">
    <div class="update-publication-container">
        <input type="hidden" id="publication_tail_updt">
        <input type="hidden" id="id_publication_updt">
        <input type="hidden" id="etat_commentaire_updt">
        <div class="update-publication-top">
            <div class="cancel-update-mobile" id="cancel_update_publication_resp">
                <i class="fas fa-arrow-left"></i>
            </div>
            <h4>Modifier la publication</h4>
            <div class="cancel-update" id="cancel_update_publication">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="update-publication-bottom">
            <div class="update-publication-location">
                <div>
                    <input type="text" id="publication_location_text_updt" placeholder="Entrer un lieu ...">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
            </div>
            <div class="publication-preview-location">
                <?php 
                $ville_query = "SELECT * FROM villes";
                $ville_result = mysqli_query($conn, $ville_query); 
                while ($ville_row = mysqli_fetch_assoc($ville_result)) {
                ?>
                <div id="publication_location_item"><p><?php echo $ville_row['ville']; ?></p></div>
                <?php } ?>    
            </div>
            <div class="update-publication-description">
                <textarea id="publication_description_updt" placeholder="Exprimez vous ..."></textarea>
            </div>
            <div class="publication-update-images-preview-container">
                <div class="publication-update-images-preview"></div>
                <div id="loader_pub_img" class="center"></div>
            </div>
            <div class="publication-update-video-preview-container">
                <div class="publication-update-video-preview"></div>
                <div id="loader_pub_img" class="center"></div>
            </div>
            <div class="update-publication-options">
                <P>Ajouter des photos ou vidéo</P>
                <div id="update_publication_image">
                    <i class="far fa-images"></i>
                </div>
                <div id="update_publication_video">
                    <i class="fas fa-video"></i>
                </div>
            </div>
            <form enctype="multipart/form-data">
                <input type="file" id="image_updt" name="images_updt[]" accept="image/*" multiple>
                <input type="button" id="update_publication_image_button">
            </form>
            <form enctype="multipart/form-data">
                <input type="file" id="video_updt" name="video_updt" accept="video/*">
                <input type="button" id="update_publication_video_button">
            </form>
            <button id="update_publication_button">Publier</button>
        </div>
    </div>
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
<?php }else{ ?>
<div class="hide-menu">
    <div class="hide-menu-left">
        <div id="home_button"><i class="fas fa-home"></i><p>acceuil</p></div>
        <div id="categories_button"><i class="fas fa-list"></i><p>categories</p></div>
        <div id="boutdechantier_button"><i class="fas fa-tools"></i><p>bout de chantier</p></div>
        <div id="recrutements_button"><i class="fas fa-briefcase"></i><p>recrutements</p></div>
        <div id="promotions_button"><i class="fas fa-ad"></i><p>promotions</p></div>
        <div id="evenements_button"><i class="far fa-calendar-check"></i><p>évènements</p></div>

        <a href="#"><i class="fas fa-store-alt"></i>Gestion du boutique</a>
        <a style="margin-top:10px" href="./inscription-connexion.php"><i class="fas fa-sign-in-alt"></i>Inscrire/Connecter</a>
        <h4>Nhanik &copy; 2020</h4>
    </div>
</div>
<div class="navbar">
    <div class="navbar-container">
        <div class="navbar-left">
            <div class="show-hide-menu">
                <i id="show_hide_menu" class="fas fa-bars"></i>
            </div>
            <div class="logo-name">
                <h4>Nhannik</h4>
            </div>
            <div class="show-search-bar-rsp">
                <i id="show_search_bar_rsp" class="fas fa-search"></i>
            </div>
            <div class="categorie-search-bar">
                <input type="text" id="categorie_search_button" placeholder="Saisissez votre recherche" autocomplete="off">
                <div id="search_bar_button">
                    <i class="fas fa-search"></i>
                </div>
            </div>
        </div>
        <div class="navbar-middle">
            <div><a class="<?php echo $indexActive; ?>" href="./index.php">acceuil</a></div>
            <div><a class="<?php echo $boutdechantierActive; ?>" href="./boutdechantier.php">Bout de chantier</a></div>
            <div><a class="<?php echo $promotionsActive; ?>" href="./promotions.php">promotions</a></div>
            <div><a class="<?php echo $evenementsActive; ?>" href="./evenements.php">évènements</a></div>
            <!-- <a class="<?php echo $recrutementsActive; ?>" href="./recrutements.php">recrutement</a> -->
        </div>
        <div class="navbar-right-login">
            <div id="gestion_store">
                <!-- <i class="fas fa-store-alt"></i> -->
                <p>Gestion de boutique</p>
            </div>
            <div id="inscription_connexion_button">
                <!-- <i class="fas fa-sign-in-alt"></i> -->
                <p>Inscrire / Connecter</p>
            </div>
        </div>
    </div>
</div>
<div class="categorie-professionnel">
    <div class="categorie-professionnel-top">
        <div id="cancel_search_bar">
            <i class="fas fa-arrow-left"></i>
        </div>
        <div class="categorie-search-bar-rspsv">
            <input type="text" id="categorie_search" placeholder="Saisissez votre recherche" autocomplete="off">
            <i class="fas fa-search"></i>
            <button style="display:none" id="categorie_search_btn"></button>
        </div>
    </div>
    <div class="categorie-professionnel-bottom">
        <div class="categorie-professionnel-bottom-top">
            <div class="categorie-profss">
                <div class="categorie-profss-top">
                    <img src="./icons/bureau-icon.png" alt="">
                    <p>Services</p>
                </div>
                <div class="categorie-profss-bottom">
                    <?php 
                    $categories_query = "SELECT * FROM categories WHERE categories = 'services'";
                    $categories_result = mysqli_query($conn,$categories_query);
                    while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                    ?>
                    <a href="./recherche.php?r=<?php echo $categories_row['sous_categories'] ?>"><li><?php echo $categories_row['sous_categories'] ?></li></a>
                    <?php } ?>
                </div>
            </div>  
            <div class="categorie-profss">
                <div class="categorie-profss-top">
                    <img src="./icons/service-icon.png" alt="">
                    <p>Artisants</p>
                </div>
                <div class="categorie-profss-bottom">
                    <?php 
                    $categories_query = "SELECT * FROM categories WHERE categories = 'artisants'";
                    $categories_result = mysqli_query($conn,$categories_query);
                    while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                    ?>
                    <a href="./recherche.php?r=<?php echo $categories_row['sous_categories'] ?>"><li><?php echo $categories_row['sous_categories'] ?></li></a>
                    <?php } ?>
                </div>
            </div>
            <div class="categorie-profss">
                <div class="categorie-profss-top">
                    <img src="./icons/transport-icon.png" alt="">
                    <p>Transports</p>
                </div>
                <div class="categorie-profss-bottom">
                    <?php 
                    $categories_query = "SELECT * FROM categories WHERE categories = 'transports'";
                    $categories_result = mysqli_query($conn,$categories_query);
                    while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                    ?>
                    <a href="./recherche.php?r=<?php echo $categories_row['sous_categories'] ?>"><li><?php echo $categories_row['sous_categories'] ?></li></a>
                    <?php } ?>
                </div>
            </div>
            <div class="categorie-profss">
                <div class="categorie-profss-top">
                    <img src="./icons/service-icon.png" alt="">
                    <p>Locations</p>
                </div>
                <div class="categorie-profss-bottom">
                    <?php 
                    $categories_query = "SELECT * FROM categories WHERE categories = 'locations'";
                    $categories_result = mysqli_query($conn,$categories_query);
                    while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                    ?>
                    <a href="./recherche.php?r=<?php echo $categories_row['sous_categories'] ?>"><li><?php echo $categories_row['sous_categories'] ?></li></a>
                    <?php } ?>
                </div>
            </div>
            <div class="categorie-profss">
                <div class="categorie-profss-top">
                    <img src="./icons/entreprise-icon.png" alt="">
                    <p>Entreprises</p>
                </div>
                <div class="categorie-profss-bottom">
                    <?php 
                        $categories_query = "SELECT * FROM categories WHERE categories = 'entreprises'";
                        $categories_result = mysqli_query($conn,$categories_query);
                        while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                        ?>
                        <a href="./recherche.php?r=<?php echo $categories_row['sous_categories'] ?>"><li><?php echo $categories_row['sous_categories'] ?></li></a>
                    <?php } ?>
                </div>
            </div>
            <div class="categorie-profss">
                <div class="categorie-profss-top">
                    <img src="./icons/detaillon-icon.png" alt="">
                    <p>Detaillons</p>
                </div>
                <div class="categorie-profss-bottom">
                    <?php 
                        $categories_query = "SELECT * FROM categories WHERE categories = 'detaillons'";
                        $categories_result = mysqli_query($conn,$categories_query);
                        while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                        ?>
                        <a href="./recherche.php?r=<?php echo $categories_row['sous_categories'] ?>"><li><?php echo $categories_row['sous_categories'] ?></li></a>
                    <?php } ?>
                </div>
            </div>
            <div class="categorie-profss">
                <div class="categorie-profss-top">
                    <img src="./icons/grossiste-icon.png" alt="">
                    <p>Grossistes</p>
                </div>
                <div class="categorie-profss-bottom">
                    <?php 
                        $categories_query = "SELECT * FROM categories WHERE categories = 'grossistes'";
                        $categories_result = mysqli_query($conn,$categories_query);
                        while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                        ?>
                        <a href="./recherche.php?r=<?php echo $categories_row['sous_categories'] ?>"><li><?php echo $categories_row['sous_categories'] ?></li></a>
                    <?php } ?>
                </div>
            </div>
            <div class="categorie-profss">
                <div class="categorie-profss-top">
                    <img src="./icons/fabriquant-icon.png" alt="">
                    <p>Fabriquants</p>
                </div>
                <div class="categorie-profss-bottom">
                    <?php 
                        $categories_query = "SELECT * FROM categories WHERE categories = 'fabriquants'";
                        $categories_result = mysqli_query($conn,$categories_query);
                        while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                        ?>
                        <a href="./recherche.php?r=<?php echo $categories_row['sous_categories'] ?>"><li><?php echo $categories_row['sous_categories'] ?></li></a>
                    <?php } ?>
                </div>
            </div>
            <div class="categorie-profss">
                <div class="categorie-profss-top">
                    <img src="./icons/importateur-icon.png" alt="">
                    <p>Import - Export</p>
                </div>
                <div class="categorie-profss-bottom">
                    <?php 
                        $categories_query = "SELECT * FROM categories WHERE categories = 'import-export'";
                        $categories_result = mysqli_query($conn,$categories_query);
                        while ($categories_row = mysqli_fetch_assoc($categories_result)) {
                        ?>
                        <a href="./recherche.php?r=<?php echo $categories_row['sous_categories'] ?>"><li><?php echo $categories_row['sous_categories'] ?></li></a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="categorie-professionnel-bottom-bottom"></div>
    </div>
</div>
<div class="user-list-dropdown" style="display:none">
    <a id="modify_profile"><i class="fas fa-cog"></i>Paramaitre</a>
    <a id="create_boutique_button"><i class="fas fa-plus"></i>Creer une boutique<span>Pro</span></a>
</div>
<div class="user-list-messages" style="display:none">
</div>
<div class="user-list-notifications" style="display:none">
</div>
<?php } ?>