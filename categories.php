<?php 
session_start();
include_once './bdd/connexion.php';
if (isset($_SESSION['user'])) {
    $cnx_user_query = "SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['user'];
    $result = mysqli_query($conn, $cnx_user_query);
    $row = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css-js/style.css">
    <link rel="stylesheet" href="./css-js/categories.css">
    <link href="./css-js/fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fugaz One">
    <title>Categories</title>
</head>
<body>
    <?php include './navbar.php';
    if (isset($_SESSION['user'])) { ?>
        <input type="hidden" id="session" value="1">
        <div id="session" class="clear-session"></div>
    <?php }else{ ?>
        <input type="hidden" id="session" value="0">
        <div class="clear"></div>
    <?php } ?>
    <div class="categories-container">
        <div class="categories-left">
            <div>
                <img src="./icons/bureau-icon.png" alt="">
                <p>Services</p>
            </div>
            <div>
                <img src="./icons/service-icon.png" alt="">
                <p>Artisant</p>
            </div>
            <div>
                <img src="./icons/transport-icon.png" alt="">
                <p>Transport</p>
            </div>
            <div>
                <img src="./icons/service-icon.png" alt="">
                <p>Location</p>
            </div>
            <div>
                <img src="./icons/entreprise-icon.png" alt="">
                <p>Entreprises</p>
            </div>
            <div>
                <img src="./icons/detaillon-icon.png" alt="">
                <p>Detaillons</p>
            </div>
            <div>
                <img src="./icons/grossiste-icon.png" alt="">
                <p>Grossistes</p>
            </div>
            <div>
                <img src="./icons/fabriquant-icon.png" alt="">
                <p>Fabriquants</p>
            </div>
            <div>
                <img src="./icons/importateur-icon.png" alt="">
                <p>Import-Export</p>
            </div>
        </div>
        <div class="categories-right-active">
            <h4>Categories recommandées</h4>
            <div class="random-boutiques-profile">
                <?php 
                $fetch_user_query = "SELECT * FROM utilisateurs WHERE type_user = 'professionnel'";
                $fetch_user_result = mysqli_query($conn,$fetch_user_query);
                while ($fetch_user_row = mysqli_fetch_assoc($fetch_user_result)) {
                ?>
                <div class="random-profile">
                    <img src="<?php if($fetch_user_row['couverture_user']==''){echo'./images/profile.png';}else{echo './'.$fetch_user_row['couverture_user'];}?>" alt="">
                    <img src="<?php if($fetch_user_row['img_user']==''){echo'./images/profile.png';}else{echo './'.$fetch_user_row['img_user'];}?>" alt="">
                    <div>
                        <p><?php echo $fetch_user_row['profession_user'] ?></p>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="categories-right">
            <div class="categories-right-top">
                <h4>Categories recommandées</h4>
                <div>
                    <a href=""><img src="./boutique-logo/logo.png" alt=""></a>
                    <a href=""><img src="./boutique-logo/logo2.jpg" alt=""></a>
                    <a href=""><img src="./boutique-logo/logo3.jpg" alt=""></a>
                </div>
            </div>
            <div class="categories-right-bottom">
                <a href=""><li>BUREAU D’ETUDE D’ARCHITECTEUR</li></a>
                <a href=""><li>BUREAU D’ETUDE D’HYDRAULIQUE</li></a>
                <a href=""><li>BUREAU  GEOMETRIQUE</li></a>
                <a href=""><li>BUREAU D’AFFAIRE</li></a>
                <a href=""><li>BUREAU D’ASSURANCE</li></a>
                <a href=""><li>AGENCE D’IMMOBILIER</li></a>
                <a href=""><li>BUREAU D’ETUDE DE CHARPENTE METALLIQUE</li></a>
                <a href=""><li>BUREAU D'ETUDE ET DE CONSEIL DANS LE DOMAINE DE TRAVAUX BATIMENT (CONSULTING)</li></a>
                <a href=""><li>BUREAU D'ETUDES EN ORGANISATION, ETUDES DE MARCHES ET SONDAGES</li></a>
                <a href=""><li>BUREAU D'INGENIERIE ET D'ETUDE TECHNIQUES</li></a>
                <a href=""><li>CABINET DE GEOMETRES METREURS</li></a>
                <a href=""><li>SOCIETE D'EXPERTISE TECHNIQUE ET DE COMMISSARIAT D'AVARIES</li></a>
                <a href=""><li>CONSULTING ET ASSISTANCE AUX ENTRPRISES NATIONALES ET INTERNATIONALES DANS LES DOMAINES DE L'INDUSTRIE ET DE L'ENERGIE</li></a>
                <a href=""><li>TIRAGE DE PLANS, PHOTOCOPIES DIVERSES</li></a>
                <a href=""><li>BUREAU D'ETUDES D'OUVRAGES ELECTRIQUES ET GAZ</li></a>
                <a href=""><li>BUREAU D’ETUDE D’ARCHITECTEUR</li></a>
                <a href=""><li>BUREAU D’ETUDE D’ARCHITECTEUR</li></a>
                <a href=""><li>BUREAU D’ETUDE D’ARCHITECTEUR</li></a>
            </div>
        </div>
        <div class="categories-right">
            <div class="categories-right-top">
                <h4>Categories recommandées</h4>
                <div>
                    <a href=""><img src="./boutique-logo/logo.png" alt=""></a>
                    <a href=""><img src="./boutique-logo/logo2.jpg" alt=""></a>
                    <a href=""><img src="./boutique-logo/logo3.jpg" alt=""></a>
                </div>
            </div>
            <div class="categories-right-bottom">
                <a href="./recherche.php?r=maçon"><li>MAÇON</li></a>
                <a href=""><li>CARRELEUR</li></a>
                <a href=""><li>CHARPENTIER</li></a>
                <a href=""><li>CHAUFFAGISTE</li></a>
                <a href=""><li>COUVREUR</li></a>
                <a href=""><li>CUISINISTE</li></a>
                <a href=""><li>DECORATEUR D’INTERIEURE</li></a>
                <a href=""><li>DEMENAGEUR</li></a>
                <a href=""><li>ELECTRICIEN BATIMENT </li></a>
                <a href=""><li>FERU NIER</li></a>
                <a href=""><li>SERURIER</li></a>
                <a href=""><li>PEINTRE</li></a>
                <a href=""><li>VITRIER</li></a>
                <a href=""><li>MIROITIER</li></a>
                <a href=""><li>PLATRIER</li></a>
                <a href=""><li>TANCHISTES</li></a>
                <a href=""><li>MARBRERIER</li></a>
                <a href=""><li>PEINTRE DECORATEUR</li></a>
                <a href=""><li>MENUISIER EN BOIS</li></a>
                <a href=""><li>MENUISIER EN ALUMINIUM</li></a>
                <a href=""><li>MENUISIER EN PVC</li></a>
                <a href=""><li>INSTALLATEUR DE CHEMINE</li></a>
                <a href=""><li>INSTALLATEUR DE SYSTEME DE CLIMATISATION</li></a>
                <a href=""><li>INSTALLATEUR D’ALARME ET VIDEO SURVIVANCE</li></a>
                <a href=""><li>INSTALLATEUR D’ANTENNES SATELLITE (TV)</li></a>
                <a href=""><li>INSTALLATEUR DE SYSTEME HYDRAULIQUE DE PISCINE</li></a>
                <a href=""><li>OUVRIER POLYVALENT</li></a>
                <a href=""><li>PLOMBIER</li></a>
                <a href=""><li>POSEUR DE MOQUETTE</li></a>
                <a href=""><li>PROFESSIONNELLE DE D’ASSAINISSEMENT ET FOSSE SEPTIQUE</li></a>
                <a href=""><li>PLAQUISTE</li></a>
                <a href=""><li>RAMONEUR</li></a>
                <a href=""><li>SPECIALISTE D’ENERGIE NOUVELLE RENOUVELABLE</li></a>
                <a href=""><li>SPECIALISTE DES FENETRES VERANDA –SERRURE PATIOS</li></a>
                <a href=""><li>SPECIALISTE DE LA PORTE DE GARAGE PORTAIL– RIDEAU</li></a>
                <a href=""><li>SPECIALISTE DES SOLES – CARRELAGE BITON IMPRIME</li></a>
                <a href=""><li>SPECIALISTE DES FILS DE PROTECTION SOLAIRE</li></a>
                <a href=""><li>SPECIALISTE DES VOLEES STORE</li></a>
                <a href=""><li>SPECIALISTE DES NETTOYAGES DE SALLE VITRE LOCAL</li></a>
                <a href=""><li>SPECIALISTE  FAÇADE</li></a>
                <a href=""><li>TAPISSERIE /SPECIALISTE DE TISSUS, RIDEAU, VOILAGE</li></a>
                <a href=""><li>TRAITEMENT DES NUISIBLE, SPECIALISTE TRAITEMENT DE BOIS CHARPENTE, IMIDITE /ET TANCHEITE</li></a>
                <a href=""><li>SPECIALISTE DE  MONTAGE EST ENTRETIEN ASSAINISSEUR</li></a>
                <a href=""><li>REPARATION DE MATERIEL ET MACHINES POUR BTP</li></a>
                <a href=""><li>REPARATEUR DE MACHINES-OUTILS</li></a>
                <a href=""><li>INSTALLATEUR ELECTRIQUES INDUSTRIELLES ET MAINTENANCE</li></a>
                <a href=""><li>INSTALLATEUR ET REPARATEUR DE CHAUDIERES, EQUIPEMENTS ET MATERIELS DE CHAUFFAGE</li></a>
                <a href=""><li>REPARATEUR DE GENERATEURS DE VAPEUR D'EAU</li></a>
                <a href=""><li>REPARATION MECANIQUE DE MATERIEL LOURD DE TRANSPORT ROUTIER</li></a>
                <a href=""><li>REPARATEUR DE MATERIELS HYDROMECANIQUES</li></a>
                <a href=""><li>REPARATEUR D'EQUIPEMENTS ELECTRIQUES ET ELECTRONIQUES</li></a>
                <a href=""><li>INSTALLATEUR ET REPARATEUR D'EQUIPEMENTS DE REFRIGERATION ET DE CLIMATISATION</li></a>
                <a href=""><li>INSTALLATEUR ET REPARATEUR DE MATERIEL DE SECURITE ET DE PROTECTION CONTRE L'INCENDIE  ET LE LEVOL</li></a>
                <a href=""><li>REPARATEUR DES POMPES</li></a>
                <a href=""><li>INSTALLATEUR ET MAINTENANCIER INDUSTRIELLE DE TOUS EQUIPEMENTS, MOTEURS ET MATERIELS</li></a>
                <a href=""><li>INSTALLATEUR, REPARATEUR ET MAINTENANCIER DE MOTEURS ET MATERIELS MARINS</li></a>
                <a href=""><li>INSTALLATEUR ET REPARATEUR DE MATERIEL ET EQUIPEMENTS LIES AU DOMAINE DE L'ENERGIE SOLAIRE ET ELECTRIQUE</li></a>
                <a href=""><li>ARTISANT EN REPARATION ET ENTRETIEN DES ASCENSEURS ET AUTRES APPAREILS SIMILAIRES</li></a>
                <a href=""><li>INSTALATEUR ET REPARATEUR DES RIDEAUX EN FER POUR  LOCAUX COMMERCIAUX</li></a>
                <a href=""><li>INSTALLATEUR ET REPARATEUR DES EQUIPEMENTS PORTUAIRES, DE MANUTENTION, DE LEVAGE ET DES MOYENS DE SAUVETAGE MARITIME</li></a>
                <a href=""><li>INSTALLATEUR, REPARATEUR DE TOUT EQUIPEMENT ET EXPLOITATION FONCTIONNANT AU GAZ</li></a>
                <a href=""><li>AMENAGEMENT DES ESPACES VERTS (JARDINIER)</li></a>
                <a href=""><li>SERVICES RELATIFS A L'UTILISATION DE L'ELECTRICITE ET LE GAZ</li></a>
            </div>
        </div>
        <div class="categories-right">
            <div class="categories-right-top">
                <h4>Categories recommandées</h4>
                <div>
                    <a href=""><img src="./boutique-logo/logo.png" alt=""></a>
                    <a href=""><img src="./boutique-logo/logo2.jpg" alt=""></a>
                    <a href=""><img src="./boutique-logo/logo3.jpg" alt=""></a>
                </div>
            </div>
            <div class="categories-right-bottom">
                <a href=""><li>TRANSPORT SUR TOUTES DISTANCES DE MARCHANDISES</li></a>
                <a href=""><li>TRANSPORT ET DISTRIBUTION DE TOUTES MARCHANDISES</li></a>
                <a href=""><li>TRANSPORT PUBLIC ROUTIER NATIONAL ET INTERNATIONAL</li></a>
                <a href=""><li>TRANSPORT PUBLIC ROUTIER NATIONAL</li></a>
                <a href=""><li>TRANSPORT FERROVIAIRE DE MARCHANDISES</li></a>
                <a href=""><li>TRANSPORT AERIEN DE MARCHANDISES</li></a>
                <a href=""><li>TRANSPORT MARITIME DE MARCHANDISES</li></a>
                <a href=""><li>DEMENAGEMENT TOUTES DESTINATIONS</li></a>
                <a href=""><li>TRANSPORT SUR TOUTES DISTANCES D’EAU</li></a>
                <a href=""><li>TRANSPORT SUR TOUTES DISTANCES D’ENGINS</li></a>
            </div>
        </div>
        <div class="categories-right">
            <div class="categories-right-top">
                <h4>Categories recommandées</h4>
                <div>
                    <a href=""><img src="./boutique-logo/logo.png" alt=""></a>
                    <a href=""><img src="./boutique-logo/logo2.jpg" alt=""></a>
                    <a href=""><img src="./boutique-logo/logo3.jpg" alt=""></a>
                </div>
            </div>
            <div class="categories-right-bottom">
                <a href=""><li>LOCATION DE VEHICULES AVEC OU SANS CHAUFFEUR</li></a>
                <a href=""><li>LOCATION D'ENGINS ET MATERIELS POUR LE BATIMENT ET TRAVAUX PUBLICS</li></a>
                <a href=""><li>LOCATION DE MACHINES ET EQUIPEMENTS DIVERS</li></a>
                <a href=""><li>LOCATION DE BIENS IMMOBILIERS</li></a>
                <a href=""><li>LOCATION DE TERRAINS</li></a>
                <a href=""><li>LOCATION DE STRUCTURES COMMERCIALES</li></a>
                <a href=""><li>LOCATION OUTILLAGE PROFERSSIONNEL</li></a>
                <a href=""><li>LOCATION TOUS MATERIELS DE TOPOGRAPHE</li></a>
            </div>
        </div>
        <div class="categories-right">
            <div class="categories-right-top">
                <h4>Categories recommandées</h4>
                <div>
                    <a href=""><img src="./boutique-logo/logo.png" alt=""></a>
                    <a href=""><img src="./boutique-logo/logo2.jpg" alt=""></a>
                    <a href=""><img src="./boutique-logo/logo3.jpg" alt=""></a>
                </div>
            </div>
            <div class="categories-right-bottom">
                <a href=""><li>ENTREPRISE DE MENUISERIE DE BOIS</li></a>
                <a href=""><li>CONSTRUCTION DE MAISONS ET CHALETS PREFABRIQUES, EN BOIS</li></a>
                <a href=""><li>ENTREPRISE DE TRAVAUX DE BATIMENT TOUT CORPS D'ETAT</li></a>
                <a href=""><li>ENTREPRISE INDUSTRIELLE DE MENUISERIE DU  BATIMENT</li></a>
                <a href=""><li>ENTREPRISE DE TRAVAUX  D'ETANCHEITE DU BATIMENT ET DE PLOMBERIE</li></a>
                <a href=""><li>ENTREPRISE DE PEINTURE DU BATIMENT</li></a>
                <a href=""><li>ENTREPRISE INDUSTRIELLE DE PRODUCTION D'ENSEMBLES DE CONSTRUCTION  METALLIQUES</li></a>
                <a href=""><li>ENTREPRISE DE TRAVAUX D'ELECTRICITE</li></a>
                <a href=""><li>ENTREPRISE D'INSTALLATION DE SYSTEMES DE CLIMATISATION ET DE REFRIGERATION</li></a>
                <a href=""><li>ENTREPRISE DE PROTECTION CONTRE LES INCENDIES ET LE VOL</li></a>
                <a href=""><li>ENTREPRISE DE GRANDS TRAVAUX PUBLICS ET HYDRAULIQUES</li></a>
                <a href=""><li>ENTREPRISE DE TERRASSEMENTS ET TRAVAUX RURAUX</li></a>
                <a href=""><li>ENTREPRISE DE TRAVAUX DE ROUTES ET D'AERODROMES</li></a>
                <a href=""><li>ENTREPRISE DE TRAVAUX DE VOIES FERREES</li></a>
                <a href=""><li>ENTREPRISE DE TRAVAUX URBAINS ET D'HYGIENE PUBLIQUE</li></a>
                <a href=""><li>ENTREPRISE D'INSTALLATION DE RESEAUX ET DE CENTRALES ELECTRIQUES ET TELEPHONIQUES</li></a>
                <a href=""><li>ENTREPRISE DE POSE DE CANALISATIONS A GRANDE DISTANCE</li></a>
                <a href=""><li>ENTREPRISE D’INSTALLATIONS THERMIQUES INDUSTRIELLES </li></a>
                <a href=""><li>ENTRERPISE DE TRAVAUX DE MAINTENANCE ET D'EXPERTISE D'OUVRAGES D'ART</li></a>
                <a href=""><li>ENTREPRISE DE PROMOTION IMMOBILIERE</li></a>
                <a href=""><li>ENTREPRISE D'ETUDES ET DE REALISATION EN GENIE CIVIL</li></a>
                <a href=""><li>ENTREPRISE DE RESTAURATION DE BATIMENT</li></a>
                <a href=""><li>ENTREPRISE D'ETUDES ET DE REALISATIONS D'OUVRAGES ELECTRIQUES ET GAZ</li></a>
                <a href=""><li>ENTREPRISE D'ETUDES ET DE REALISATION DE TOUTES BRANCHES D'ACTIVITES DU B.T.P.H</li></a>
                <a href=""><li>ENTREPRISE DE CONSTRUCTION ET D'AMENAGEMENT D'INFRASTRUCTURES DIVERSES</li></a>
                <a href=""><li>ENTREPRISE INDUSTRIELLE DE TRANSFORMATION DU BOIS</li></a>
                <a href=""><li>ENTREPRISE ARTISANALE DE POTERIE-FAIENCERIE</li></a>
                <a href=""><li>ENTREPRISE ARTISANALE DE CERAMIQUE</li></a>
                <a href=""><li>ENTREPRISE ARTISANALE DE VERRERIE</li></a>
                <a href=""><li>ENTREPRISE ARTISANALE DE MARBRERIE</li></a>
                <a href=""><li>ENTREPRISE ARTISANALE DE FERRONNERIE</li></a>
                <a href=""><li>ENTREPRISE ARTISANALE D'EXPLOITATION DE CARRIERES (PIERRES, GYPSE, PIERRE A CHAUX)</li></a>
                <a href=""><li>ENTREPRISE ARTISANALE DE CHAUDRONNERIE</li></a>
                <a href=""><li>ENTREPRISE ARTISANALE DE PRODUCTION DE CHARPENTES METALLIQUES</li></a>
                <a href=""><li>ENTREPRISE ARTISANALE  DE BOULONNERIE–VISSERIE</li></a>
                <a href=""><li>ENTREPRISE ARTISANALE DE FERRONNERIE ET MENUISERIE METALLIQUE</li></a>
                <a href=""><li>ENTREPRISE ARTISANALE DE PRODUCTION DE PETITS ARTICLES METALLIQUES DIVERS</li></a>
                <a href=""><li>ENTREPRISE ARTISANALE DE SCIAGE DU BOIS (SCIERIE)</li></a>
                <a href=""><li>ENTREPRISE ARTISANALE DE MENUISERIE ALLUMINUM</li></a>
                <a href=""><li>ENTREPRISE ARTISANALE DE MENUISERIE GENERALE</li></a>
                <a href=""><li>ENTREPRISE ARTISANALE DE FABRICATION D'ARTICLES DE DECORATION</li></a>
                <a href=""><li>ENTREPRISE ARTISANALE DE PRODUCTION DE QUINCAILLERIE DE BATIMENT</li></a>
                <a href=""><li>ENTREPRISE ARTISANALE DE PRODUCTION DE PRODUITS EN CIMENT </li></a>
                <a href=""><li>ENTREPRISE ARTISANALE DE MIROITERIE</li></a>
                <a href=""><li>ENTREPRISE DE COULAGE DE BETON</li></a>
                <a href=""><li>ENTREPRISE DES RESEAUX  DE TELECOMMUNICATION</li></a>
                <a href=""><li>ENTREPRISE DE DECORATION</li></a>
                <a href=""><li>ENTREPRISE D'ETUDES ET DE REALISATION DE PROGRAMMES DE PREVENTION ET D'ASSAINISSEMENT DE L'ENVIRONNEMENT</li></a>
                <a href=""><li>ENTREPRISE D'ARCHITECTURE</li></a>
                <a href=""><li>ENTREPRISE DE NETTOYAGE, D'ENTRETIEN ET DE DESINFECTION</li></a>
            </div>
        </div>
        <div class="categories-right">
            <div class="categories-right-top">
                <h4>Categories recommandées</h4>
                <div>
                    <a href=""><img src="./boutique-logo/logo.png" alt=""></a>
                    <a href=""><img src="./boutique-logo/logo2.jpg" alt=""></a>
                    <a href=""><img src="./boutique-logo/logo3.jpg" alt=""></a>
                </div>
            </div>
            <div class="categories-right-bottom">
                <a href=""><li>ARTICLES DE REVETEMENT D'INTERIEUR</li></a>
                <a href=""><li>ARTICLES DE DECORATION D'INTERIEUR</li></a>
                <a href=""><li>ARTICLES DE MENAGE</li></a>
                <a href=""><li>PRODUITS D'HYGIENE ET D'ENTRETIEN DOMESTIQUE ET PROFESSIONNEL</li></a>
                <a href=""><li>GAZ BUTANE, CHARBON DE BOIS ET AUTRES COMBUSTIBLES SOLIDES, LIQUIDES OU GAZEUX</li></a>
                <a href=""><li>APPAREILS SANITAIRES ET DE CHAUFFAGE</li></a>
                <a href=""><li>MATERIAUX DE CONSTRUCTION</li></a>
                <a href=""><li>BOIS ET LIEGE POUR LA MENUISERIE</li></a>
                <a href=""><li>VITRERIE ET MIROITERIE</li></a>
                <a href=""><li>PEINTURES ET VERNIS</li></a>
                <a href=""><li>DROGUERIE</li></a>
                <a href=""><li>QUINCAILLERIE</li></a>
                <a href=""><li>FOURNITURES POUR L'ELECTRICITE</li></a>
                <a href=""><li>EQUIPEMENTS ET FOURNITURES DE PROTECTION ET DE SECURITE</li></a>
                <a href=""><li>MATERIELS ET OUTILLAGES POUR BTP</li></a>
                <a href=""><li>EQUIPEMENTS ET FOURNITURES THERMIQUES</li></a>
                <a href=""><li>OUTILLAGES PROFESSIONNELS POUR MACHINES-OUTILS</li></a>
                <a href=""><li>MATERIELS ET EQUIPEMENTS LIES AU DOMAINE DE L'ELECTRICITE ET L'ELECTRONIQUE</li></a>
                <a href=""><li>MATERIEL HYDRAULIQUE</li></a>
                <a href=""><li>APPAREILS ET MACHINES PROFESSIONNELS OU DOMESTIQUES D'OCCASIONS</li></a>
            </div>
        </div>
        <div class="categories-right">
            <div class="categories-right-top">
                <h4>Categories recommandées</h4>
                <div>
                    <a href=""><img src="./boutique-logo/logo.png" alt=""></a>
                    <a href=""><img src="./boutique-logo/logo2.jpg" alt=""></a>
                    <a href=""><img src="./boutique-logo/logo3.jpg" alt=""></a>
                </div>
            </div>
            <div class="categories-right-bottom">
                <a href=""><li>APPAREILS SANITAIRES ET DE CHAUFFAGE</li></a>
                <a href=""><li>ARTICLES DE DECORATION D'INTERIEUR</li></a>
                <a href=""><li>MATERIELS ET EQUIPEMENTS LIES AU DOMAINE DE L'ELECTRICITE ET L'ELECTRONIQUE</li></a>
                <a href=""><li>APPAREILS ET MACHINES PROFESSIONNELS OU DOMESTIQUES D'OCCASIONS</li></a>
                <a href=""><li>PRODUITS DE LA DROGUERIE, PRODUITS D'HYGIENE, D'ENTRETIEN DOMESTIQUE, PROFESSIONNEL ET AUTRES PRODUITS SIMILAIRES</li></a>
                <a href=""><li>MATERIAUX DE CONSTRUCTION, CERAMIQUE  SANITAIRE VERRE PLAT</li></a>
                <a href=""><li>QUINCAILLERIE ET FOURNITURES POUR PLOMBERIE ET CHAUFFAGE</li></a>
                <a href=""><li>LA VITRERIE ET DE LA MIROITERIE</li></a>
                <a href=""><li>BOIS, DU LIEGE ET PRODUITS DERIVES</li></a>
                <a href=""><li>PRODUITS D'ETANCHIETE</li></a>
                <a href=""><li>FOURNITURES POUR L'ELECTRICITE</li></a>
                <a href=""><li>EQUIPEMENTS, MATERIEL ET FOURNITURES DE SECURITE ET DE PROTECTION</li></a>
                <a href=""><li>MACHINES ET MATERIELS POUR BTP</li></a>
                <a href=""><li>OUTILS ET OUTILLAGES</li></a>
                <a href=""><li>MATERIELS HYDRAULIQUES</li></a>
                <a href=""><li>GAZ BUTANE, PROPANE ET DU GAZ INDUSTRIEL</li></a>
                <a href=""><li>ARTICLES DE REVETEMENT D'INTERIEUR</li></a>
            </div>
        </div>
        <div class="categories-right">
            <div class="categories-right-top">
                <h4>Categories recommandées</h4>
                <div>
                    <a href=""><img src="./boutique-logo/logo.png" alt=""></a>
                    <a href=""><img src="./boutique-logo/logo2.jpg" alt=""></a>
                    <a href=""><img src="./boutique-logo/logo3.jpg" alt=""></a>
                </div>
            </div>
            <div class="categories-right-bottom">
                <a href=""><li>EXPLOITATION DE CARRIERES DE PIERRES DE TAILLE POUR LA CONSTRUCTION ET L'INDUSTRIE</li></a>
                <a href=""><li>EXTRACTION ET PREPARATION DE SABLES, EXTRACTION DE MATERIAUX ALLUVIONNAIRES </li></a>
                <a href=""><li>EXTRACTION ET PREPARATION DE GYPSE</li></a>
                <a href=""><li>EXTRACTION ET PREPARATION DE LA PIERRE A CHAUX</li></a>
                <a href=""><li>EXTRACTION ET PREPARATION DE L'ARGILE</li></a>
                <a href=""><li>FABRICATION DE PEINTURES ET VERNIS</li></a>
                <a href=""><li>FABRICATION DE MACHINES ET TURBINES A VAPEUR</li></a>
                <a href=""><li>FABRICATION DE POMPES ET DE MATERIEL HYDRAULIQUE</li></a>
                <a href=""><li>FABRICATION DE MATERIEL D'INCENDIE</li></a>
                <a href=""><li>FABRICATION D'OUTILLAGE A MAIN METALLIQUE</li></a>
                <a href=""><li>CONSTRUCTION D'ENGINS SPECIAUX</li></a>
                <a href=""><li>FABRICATION DE CABLES ELECTRIQUES ET TELEPHONIQUES</li></a>
                <a href=""><li>FABRICATION DE MACHINES ET MATERIELS ELECTRIQUES ET D'APPAREILLAGES DE DISTRIBUTION</li></a>
                <a href=""><li>FABRICATION DE PETIT APPAREILLAGE D'INSTALLATION ET D'ECLAIRAGE ELECTRIQUE, MATERIEL TELEPHONIQUE ET TELEGRAPHIQUE</li></a>
                <a href=""><li>FABRICATION DE COMPTEURS ELECTRIQUES, TRANSFORMATEURS DE MESURE, D’APPAREILS ELECTRIQUES ET ELECTRONIQUES DE MESURE ET DE CONTROLE</li></a>
                <a href=""><li>FABRICATION DE LAMPES ELECTRIQUES</li></a>
                <a href=""><li>FABRICATION  DE MATERIELS, EQUIPEMENTS  LIES AUX DOMAINES  DE L'ENERGIE SOLAIRE ET ELECTRIQUE</li></a>
                <a href=""><li>REALISATION ET CONCEPTION DE COMPOSANTS ELECTRONIQUES DESTINES A LA MAINTENANCE INDUSTRIELLE</li></a>
                <a href=""><li>FABRICATION D'EQUIPEMENTS, DE MATERIELS ET FOURNITURES DE SECURITE ET DE PROTECTION</li></a>
                <a href=""><li>FABRICATION D’ACIERS COURANTS</li></a>
                <a href=""><li>LAMINAGE A CHAUD DES ACIERS COURANTS</li></a>
                <a href=""><li>FABRICATION DES ACIERS FINS ET SPECIAUX (A.F.S)</li></a>
                <a href=""><li>LAMINAGE ET FABRICATION DE PRODUITS A.F.S</li></a>
                <a href=""><li>TRANSFORMATION DES ACIERS FINS ET SPECIAUX (AFS)</li></a>
                <a href=""><li>LAMINAGE ET PROFILAGE A FROID DE L'ACIER COURANT, TREFILAGE, ETIRAGE ET AUTRES TRANSFORMATIONS DE L'ACIER COURANT</li></a>
                <a href=""><li>FABRICATION DE TUBES D'ACIER</li></a>
                <a href=""><li>METALLURGIE DE L'ALUMINIUM ETD'AUTRES METAUX LEGERS (Y COMPRIS FABRICATION D'ALLIAGES LEGERS, DE DURALUMIN ET D'ALPAX)</li></a>
                <a href=""><li>PREMIERE TRANSFORMATION DES METAUX NON FERREUX ET FABRICATION DE DEMIPRODUITS EN METAUX NON FERREUX</li></a>
                <a href=""><li>METALLURGIE DES METAUX  ENTRANT DANS LES FERRO-ALLIAGES ET METAUX CONNEXES</li></a>
                <a href=""><li>METALLURGIE ET AFFINAGE DES METAUX COMMUNS ET LEURS ALLIAGES</li></a>
                <a href=""><li>AFFINAGE DES METAUX PRECIEUX</li></a>
                <a href=""><li>LAMINAGE SUR BOIS</li></a>
                <a href=""><li>FABRICATION DE FONTE</li></a>
                <a href=""><li>GROSSE FORGE ET GROS EMBOUTISSAGE</li></a>
                <a href=""><li>FONDERIE</li></a>
                <a href=""><li>CHAUDRONNERIE</li></a>
                <a href=""><li>ROBINETTERIE</li></a>
                <a href=""><li>CONSTRUCTION METALLIQUE (FABRICATION D'ELEMENTS ET POSE ASSOCIEES OU FABRICATION SEULE)</li></a>
                <a href=""><li>REVETEMENT ET TRAITEMENT DES METAUX</li></a>
                <a href=""><li>DECOUPAGE ET EMBOUTISSAGE DE METAL</li></a>
                <a href=""><li>DECOLLETAGE, TOURNAGE, BOULONNERIE, VISSERIE</li></a>
                <a href=""><li>FERRONNERIE ET MENUISERIE METALLIQUES</li></a>
                <a href=""><li>FABRICATION DE TUYAUX METALLIQUES FLEXIBLES</li></a>
                <a href=""><li>FABRICATION DE PETITS ARTICLES METALLIQUES</li></a>
                <a href=""><li>FABRICATION D'AIMANTS PERMANENTS</li></a>
                <a href=""><li>FABRICATION D'ELECTRODES POUR ELECTROMETALLURGIE OU ELECTROCHIMIE EN GRAHITE OU EN CARBONE  AMORPHE (N.C LES ELECTRODES DE SOUDURE)</li></a>
                <a href=""><li>FABRICATION INDUSTRIELLE DE CIMENTS (CIMENTERIE)</li></a>
                <a href=""><li>FABRICATION INDUSTRIELLE DE PLATRE ET DERIVES (PLATERERIE)</li></a>
                <a href=""><li>FABRICATION INDUSTRIELLE DE PRODUITS EN BETON AUTRES QU’AGGLOMERES</li></a>
                <a href=""><li>FABRICATION  INDUSTRIELLE DE PRODUITS MANUFACTURES EN BETON OU EN PLATRE (DITS AGGLOMERES)</li></a>
                <a href=""><li>FABRICATION INDUSTRIELLE DE CARREAUX ET DALLES EN CIMENT ET GRANITO</li></a>
                <a href=""><li>PREFABRICATION D'ELEMENTS EN BETON ET FABRICATION DU BETON PRET A L'EMPLOI</li></a>
                <a href=""><li>FABRICATION INDUSTRIELLE DE PRODUITS EN ARGILE NON REFRACTAIRE (BRIQUETERIE, TUILERIE INDUSTRIELLE)</li></a>
                <a href=""><li>FABRICATION INDUSTRIELLE DE PRODUITS REFRACTAIRES ET CALORIFUGES</li></a>
                <a href=""><li>FABRICATION INDUSTRIELLE DE PRODUITS CERAMIQUES AUTRES QUE SANITAIRES POUR L'INDUSTRIE ET LE BATIMENT</li></a>
                <a href=""><li>FABRICATION INDUSTRIELLE DE PRODUITS SANITAIRES EN CERAMIQUE</li></a>
                <a href=""><li>FABRICATION DE MATERIAUX DE CONSTRUCTION EN PLASTIQUE</li></a>
                <a href=""><li>FABRICATION D'ARTICLES SANITAIRES EN PLASTIQUE</li></a>
                <a href=""><li>FABRICATION INDUSTRIELLE, FACONNAGE ET TRANSFORMATION DU VERRE PLAT ET MIROITERIE</li></a>
                <a href=""><li>FABRICATION INDUSTRIELLE, FACONNAGE ET TRANSFORMATION DU VERRE CREUXMECANIQUE ET DU VERRE TECHNIQUE</li></a>
                <a href=""><li>FABRICATION DE CABINES " SAHARIENNES "  ET AUTRES PREFABRICATIONS  METALLIQUES</li></a>
                <a href=""><li>FABRICATION INDUSTRIELLE DE SERRURERIE ET QUINCAILLERIE</li></a>
                <a href=""><li>FABRICATION INDUSTRIELLE D'ARTICLES DE FERBLANTERIE ET TOLERIE</li></a>
                <a href=""><li>FABRICATION DE MOBILIER METALLIQUE</li></a>
                <a href=""><li>FABRICATION INDUSTRIELLE D'ARTICLES DE DECORATION</li></a>
                <a href=""><li>MARBRERIE INDUSTRIELLE</li></a>
            </div>
        </div>
        <div class="categories-right">
            <div class="categories-right-top">
                <h4>Categories recommandées</h4>
                <div>
                    <a href=""><img src="./boutique-logo/logo.png" alt=""></a>
                    <a href=""><img src="./boutique-logo/logo2.jpg" alt=""></a>
                    <a href=""><img src="./boutique-logo/logo3.jpg" alt=""></a>
                </div>
            </div>
            <div class="categories-right-bottom">
                <a href=""><li>MATERIELS ET PRODUITS LIES AU DOMAINE HYDRAULIQUE</li></a>
                <a href=""><li>EQUIPEMENTS, MATERIELS ET PRODUITS LIES AU DOMAINE DU BATIMENT ET DES TRAVAUX PUBLICS</li></a>
                <a href=""><li>MACHINES MATIERES ET PRODUITS POUR LA SECURITE ET LA SIGNALISATION ROUTIERE</li></a>
                <a href=""><li>PLANCHERS SURELEVES ET FAUX PLAFONDS DESTINES A L'AMENAGEMENT DE CENTRES INFORMATIQUES ET TECHNIQUES</li></a>
                <a href=""><li>TOUS MATERIELS ET EQUIPEMENTS LIES AU DOMAINE DE L'ELECTRICITE ET L'ELECTRONIQUE</li></a>
                <a href=""><li>MATIERES PREMIERES LIES AU DOMAINE DE LA CERAMIQUE</li></a>
                <a href=""><li>EQUIPEMENTS LIES AU DOMAINE DE LA CERAMIQUE</li></a>
                <a href=""><li>MATERIELS ET ACCESSOIRES LIES AU DOMAINE DE LA CERAMIQUE</li></a>
                <a href=""><li>TOLES GALVANISEES OU INOXYDABLES</li></a>
                <a href=""><li>MATERIELS ET PRODUITS LIES AU DOMAINE DE LA QUINCAILLERIE</li></a>
                <a href=""><li>MATERIELS ET PRODUITS LIES AU DOMAINE DE LA DROGUERIE</li></a>
                <a href=""><li>MATERIELS ET PRODUITS LIES AU DOMAINE DE LA ARTICLES DE MENAGE, ET TOUS ARTICLES D'HYGIENE ET D'ENTRETIEN DOMESTIQUE ET PROFESSIONNEL</li></a>
                <a href=""><li>ARTICLES DE DECORATION D'INTERIEUR</li></a>
                <a href=""><li>EQUIPEMENTS,  MATERIELS ET FOURNITURES DE SECURITE ET DE PROTECTION</li></a>
                <a href=""><li>APPAREILS,  ARTICLES ET PRODUITS DESTINES A LA FILTRATION OU L'EPURATION DES LIQUIDES ET DES GAZ</li></a>
                <a href=""><li>MATERIELS, MACHINES, MATIERE PREMIERE ET ACCESSOIRES DESTINES A LA TRANSFORMATION DU BOIS ET SES DERIVES</li></a>
                <a href=""><li>MATERIELS, MACHINES, MATIERES PREMIERES, PIECES DETACHEES ET ACCESSOIRES DESTINES A LA FABRICATION ET LA TRANSFORMATION DES METAUX</li></a>
                <a href=""><li>MATERIELS, MACHINES, PIECES DETACHEES ET ACCESSOIRES DESTINES AU CONDITIONNEMENT DE L'AIR, TURBINES, CHAUDIERES, GENERATEURS DE GAZ</li></a>
                <a href=""><li>MATERIELS DE TRAVAUX PUBLICS ET DE BATIMENT Y COMPRIS PIECES DETACHEES ET ACCESSOIRES</li></a>
                <a href=""><li>CABINES SAHARIENNES</li></a>
                <a href=""><li>MOTEURS ET TURBINES INDUSTRIELLES OU AUTRES Y COMPRIS LEURS PIECES DETACHEES ET LEURS ACCESSOIRES</li></a>
                <a href=""><li>ARTICLES DE REVETEMENT D'INTERIEUR</li></a>
            </div>
        </div>
    </div>
    <div id="loader" class="center"></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="./css-js/main.js"></script>
    <script>
        document.onreadystatechange = function() { 
            if (document.readyState !== "complete") { 
                document.querySelector("body").style.visibility = "hidden"; 
                document.querySelector("#loader").style.visibility = "visible"; 
            } else { 
                document.querySelector("#loader").style.display = "none"; 
                document.querySelector("body").style.visibility = "visible"; 
            } 
        };
        
        var windowWidth = window.innerWidth;
        if (windowWidth <= 768) {
            $('.footer').css('display','none');
            var session = $('#session').val();
            if (session == 0) {
                $('.navbar').height(40);
                $('.navbar-menu').css('display','none');
                $('.clear').height(40);
            }
            else{
                $('.categories-left').css('top','81px'); 
                $('.categories-left').css('height','calc(100vh - 80px)'); 
            }
        }
        else{
            $('.clear-session').css('height','60px');
        }

        var categorie = document.querySelectorAll('.categories-left div');
        var categorieDetails = document.querySelectorAll('.categories-right');
        var categorieTop = document.querySelectorAll('.categories-right-top');
        
        for (let j = 0; j < categorie.length; j++) {
            categorie[j].addEventListener('click',()=>{
                activeCategorie();
                $('.categories-right-active').hide();
                categorie[j].style.background = "#ecedee";
                categorie[j].style.borderLeft = "solid 3px #000";
                activeDetailsCategorie();
                categorieDetails[j].style.display = "block";
            });
        }

        function activeCategorie(){
            categorie.forEach(c => {
                c.style.background = "";
                c.style.borderLeft = "";
            });
        }

        function activeDetailsCategorie(){
            categorieDetails.forEach(cd => {
                cd.style.display = "";
                cd.scrollTop = 0;
            });
        }
    </script>
</body>
</html>