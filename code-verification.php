<?php 
include_once './bdd/connexion.php';

$id_user = htmlspecialchars($_POST['id_user']);
$code_verification = htmlspecialchars($_POST['code_verification']);
$query = "SELECT code FROM preutilisateurs WHERE id_user = '$id_user'";
if($result = mysqli_query($conn,$query)){
    $row = mysqli_fetch_assoc($result);
    if ($row['code'] == $code_verification) {
        echo $id_user;
    ?>
    <div class="inscription-details-container">
        <div class="inscription-client-professionnel-final">
            <div class="close-final-inscription" id="close_final_inscription">
                <i class="fas fa-times"></i>
            </div>
            <div class="inscription-final-details">
                <div class="inscription-client-final-details">
                    <p>Aujourd'hui, il n'a jamais été aussi simple de trouver un pro 
                        des taches que monsieur tout le monde a besoin avec la plate forme N’HANIK.</p>
                    <p>Si  vous avez une petite mission à déléguer, faites tout simplement 
                        appel à N’HANIK  plutôt qu'à une grande enseigne spécialisée : bricolage, 
                        ménage, jardinage ou même déménagement, de nombreux partenaires ont 
                        du temps à revendre et toutes les compétences nécessaires pour venir à 
                        bout de votre corvée en un temps record et de manière efficace et professionnelle. 
                        Alors, pour tous vos petits traquas du quotidien, faites confiance a N’HANIK.</p>
                    <p>Non seulement vous pourrez donner à un particulier le complément de revenu qu'il 
                        mérite, mais vous pourrez aussi aider une micro-entreprise qui débute à développer 
                        sa notoriété. Et pour cela, rien de plus simple, choisissez la catégorie dans laquelle 
                        poster votre besoin et faites nous confiance  pour tout le reste, il réalisera votre 
                        mission en toute confiance et en toute sécurité !</p>
                    <p>N’HANIK  est la solution idéale pour tous vos besoins: plomberie, électricité…etc.</p>
                    <p>Réactivité à toute heure, professionnalisme des intervenants, super expérience client, bref, que du positif.</p>
                    <p>- Décrivez votre besoin.</p>
                    <p>- Des professionnels disponibles et compétents vous proposent leurs services.</p>
                    <p>- Evaluez et réglez votre prestataire une fois le job terminé.</p>
                </div>
                <div class="inscription-professionnel-final-details">
                    <h4>Vous êtes une entreprise ou artisan!</h4>
                    <p>Devenez partenaire de la plate forme N’HANIK, trouvez de nouveaux clients.</p>
                    <p>En créant votre profil ; sélectionnez vos compétences. Souscrivez à nos alertes jobs pour ne jamais rien manquer.</p>
                    <p>Proposez vos services : Faites des offres pour les jobs qui vous intéressent. Vous fixez vos propres tarifs. Vous êtes payé après la fin du job.</p>
                    <h4>Vous avez un volume de travail dépassant vos capacités!</h4>
                    <p>nous vous mettons en relation avec des partenaires et des collaborateurs en cas de besoin et nous nous chargerons de toute prospection en matériaux et équipements.</p>
                    <h4>Nous mettons a votre disposition une équipe qui vous:</h4>
                    <p>déchargera  des taches administratifs et autres qui risquent de vous faire perdre du temps précieux.</p>
                </div>   
            </div>
            <form action="./client-professionnel-inscription.php" method="post" id="final_inscription_form">
                <input type="hidden" id="id_user_final">
                <input type="hidden" id="type_user_final">
                <input type="submit" value="Valider">
            </form>
        </div>
        <div class="inscription-details-container-responsive">
            <div class="profession-inscription">
                <div class="inscription-profession-details">
                    <div class="inscription-avantages">
                        <img src="./icons/service-icon.png" alt="">
                    </div>
                    <button id="professionnel_inscription">Inscription professionnel</button>
                </div>
            </div>
            <div class="inscription-choice">
                <p>- OU -</p>
            </div>
            <div class="client-inscription">
                <div class="inscription-client-details">
                    <div class="inscription-avantages">
                        <img src="./icons/service-icon.png" alt="">
                    </div>
                    <button id="client_inscription">Inscription client</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    else{
        echo 0;
    }
}
else{
    echo 0;
}
?>