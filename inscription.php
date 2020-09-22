<?php 
include_once './bdd/connexion.php';

$nom_user = htmlspecialchars($_POST['nom_user']);
// $type_user = htmlspecialchars($_POST['type_user']);
$email_tlph_user = htmlspecialchars($_POST['email_tlph_user']);
$mtp_user = htmlspecialchars($_POST['mtp_user']);

$code = rand(111111,999999);

if (filter_var($email_tlph_user, FILTER_VALIDATE_EMAIL)) {
    $find_tlph_user_query = "SELECT * FROM utilisateurs WHERE email_user = '$email_tlph_user'";
}
else{
    $find_tlph_user_query = "SELECT * FROM utilisateurs WHERE tlph_user = '$email_tlph_user'";
}
$find_tlph_user_result = mysqli_query($conn, $find_tlph_user_query);
$find_tlph_user_count = mysqli_num_rows($find_tlph_user_result);

$hash_mtp_user = hash('sha256', $mtp_user);

if (filter_var($email_tlph_user, FILTER_VALIDATE_EMAIL)) {
    $inscr_user_query = "INSERT INTO preutilisateurs (nom_user,tlph_user,email_user,code,mtp_user) 
                VALUES ('$nom_user',0,'$email_tlph_user','$code','$hash_mtp_user')";
} 
else {
    $inscr_user_query = "INSERT INTO preutilisateurs (nom_user,tlph_user,email_user,code,mtp_user) 
                VALUES ('$nom_user','$email_tlph_user','','$code','$hash_mtp_user')";
}

if ($find_tlph_user_count > 0) {
    echo 2;
}
else if ($find_tlph_user_count == 0) {
    if(mysqli_query($conn,$inscr_user_query)){

        if (filter_var($email_tlph_user, FILTER_VALIDATE_EMAIL)) {
            $get_userid_query = "SELECT id_user,email_user FROM preutilisateurs WHERE email_user = '$email_tlph_user'";
            $get_userid_result = mysqli_query($conn, $get_userid_query);
            $get_userid_row = mysqli_fetch_assoc($get_userid_result);
        ?>
        <div class="alert-inscription-connexion">
            <div>
                <i class="fas fa-times"></i>
            </div>
            <p></p>
        </div>
        <div class="mobile-email-confirmation-container">
            <div class="mobile-email-confirmation">
                <div class="email-confirmation">
                    <h3>Email confirmation</h3>
                    <h4>Un code de vérification a été envoyé à votre adresse e-mail <?php echo $get_userid_row['email_user'] ?></h4>
                    <div>
                        <span>Code de vérification</span>
                        <input type="text" id="code_verification">
                    </div>
                    <input type="hidden" id="id_user" value="<?php echo $get_userid_row['id_user']; ?>">
                    <button id="verify_email_button">Vérifier</button>
                </div>
            </div>
        </div>
        <div id="loader_load" class="center"></div>
        <?php
        }
        else{
            $get_userid_query = "SELECT id_user,tlph_user FROM preutilisateurs WHERE tlph_user = '$email_tlph_user'";
            $get_userid_result = mysqli_query($conn, $get_userid_query);
            $get_userid_row = mysqli_fetch_assoc($get_userid_result);
        ?>
        <div class="alert-inscription-connexion">
            <div>
                <i class="fas fa-times"></i>
            </div>
            <p></p>
        </div>
        <div class="mobile-email-confirmation-container">
            <div class="mobile-email-confirmation">
                <div class="mobile-confirmation">
                    <h3>Mobile confirmation</h3>
                    <h4>Un code de vérification a été envoyé par SMS à votre numéro <?php echo $get_userid_row['tlph_user'] ?></h4>
                    <div>
                        <span>Code de vérification</span>    
                        <input type="text" id="code_verification">
                    </div>
                    <input type="hidden" id="id_user" value="<?php echo $get_userid_row['id_user']; ?>">
                    <button id="verify_mobile_button">Vérifier</button>
                </div>
            </div>
        </div>
        <div id="loader_load" class="center"></div>
        <?php
        }
    }
    else{
        echo 0;
    }  
}

?>