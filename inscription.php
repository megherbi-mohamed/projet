<?php 
include_once './bdd/connexion.php';
require __DIR__ .'/vendor/autoload.php';
use Twilio\Rest\Client;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$nom_user = htmlspecialchars($_POST['nom_user']);
$email_tlph_user = htmlspecialchars($_POST['email_tlph_user']);
$mtp_user = htmlspecialchars($_POST['mtp_user']);

$code = rand(111111,999999);

if (filter_var($email_tlph_user, FILTER_VALIDATE_EMAIL)) {
    $mail = new PHPMailer(true); //Argument true in constructor enables exceptions

    //Enable SMTP debugging.
    // $mail->SMTPDebug = 3;                               
    //Set PHPMailer to use SMTP.
    $mail->isSMTP();            
    //Set SMTP host name                          
    $mail->Host = "smtp.gmail.com";
    //Set this to true if SMTP host requires authentication to send email
    $mail->SMTPAuth = true;                          
    //Provide username and password     
    $mail->Username = "megherbimeddz@gmail.com";                 
    $mail->Password = "Genieuser@1995";                           
    //If SMTP requires TLS encryption then set it
    $mail->SMTPSecure = "tls";                           
    //Set TCP port to connect to
    $mail->Port = 587; 

    //From email address and name
    $mail->From = "contact-us@nhannik.com";
    $mail->FromName = "nhannik";

    //To address and name
    // $mail->addAddress("recepient1@example.com", "Recepient Name");
    $mail->addAddress($email_tlph_user); 

    //Send HTML or Plain Text email
    $mail->isHTML(true);

    $mail->Subject = "Code verification";
    $mail->Body = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fugaz One">
    </head>
    <body>
        <div style="width:600px;margin:auto;background:#ecedee">
            <div style="width:100%;background:#ffffff;padding:20px;box-sizing:border-box;text-align:center">
                <h2 style="font-family:Fugaz One;">Nhannik</h2>
            </div>
            <div style="width:80%;margin:auto;text-align:center">
                <p style="margin:10px auto;font-size:.9rem">Merci beaucoup '.$nom_user.' d\'avoir rejoint nhannik! pour terminer votre inscription, il vous suffit de confirmer que nous avons bien reçu votre e-mail</p>
                <p style="margin:10px auto;font-size:.9rem">Code de vérification</p>
                <div style="width:100%:background:#ffffff;padding:30px;box-sizing:border-box;text-align:center">
                    <h4>'.$code.'</h4>
                </div>
            </div>
            <div style="width:80%;margin:auto,display:grid;grid-template-columns:repeat(3,1fr);align-items:center;justify-items:center">
                <a href=""><i class="fab fa-facebook"></i></a>
                <a href=""><i class="fab fa-instagram"></i></a>
                <a href=""><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </body>
    </html>';

    try {
        $mail->send();
        $find_tlph_user_query = $conn->prepare("SELECT * FROM utilisateurs WHERE email_user = '$email_tlph_user'");
    } catch (Exception $e) {
        echo 0;
    }
    // $find_tlph_user_query = $conn->prepare("SELECT * FROM utilisateurs WHERE email_user = '$email_tlph_user'");
}
else{
    $sid    = "ACeba31804b7e0c4afa11711d18016f94a";
    $token  = "1b8365729f3a89459eecf11a2b8ea320";
    $twilio = new Client($sid, $token);
    $message = $twilio->messages
    ->create($email_tlph_user, // to
            ["body" => "nhannik send your code: $code", "from" => "+12039873157"]
    );
    $find_tlph_user_query = $conn->prepare("SELECT * FROM utilisateurs WHERE tlph_user = '$email_tlph_user'");
}

$find_tlph_user_query->execute();
$find_tlph_user_count = $find_tlph_user_query->rowCount();

$hash_mtp_user = hash('sha256', $mtp_user);

if (filter_var($email_tlph_user, FILTER_VALIDATE_EMAIL)) {
    $inscr_user_query = $conn->prepare("INSERT INTO preutilisateurs (nom_user,tlph_user,email_user,code,mtp_user) 
                VALUES (:nom_user, :num, :email_tlph_user, :code, :hash_mtp_user)");
    $inscr_user_query->bindParam(':nom_user', $nom_user);
    $inscr_user_query->bindParam(':num', $num); 
    $inscr_user_query->bindParam(':email_tlph_user', $email_tlph_user);
    $inscr_user_query->bindParam(':code', $code);
    $inscr_user_query->bindParam(':hash_mtp_user', $hash_mtp_user);
    $num = 0;
} 
else {
    $inscr_user_query = $conn->prepare("INSERT INTO preutilisateurs (nom_user,tlph_user,email_user,code,mtp_user) 
                VALUES (:nom_user, :email_tlph_user, :num, :code, :hash_mtp_user)");
    $inscr_user_query->bindParam(':nom_user', $nom_user);
    $inscr_user_query->bindParam(':num', $num); 
    $inscr_user_query->bindParam(':email_tlph_user', $email_tlph_user);
    $inscr_user_query->bindParam(':code', $code);
    $inscr_user_query->bindParam(':hash_mtp_user', $hash_mtp_user);
    $num = '';
}

if ($find_tlph_user_count > 0) {
    echo 2;
}
else if ($find_tlph_user_count == 0) {
    if($inscr_user_query->execute()){
        if (filter_var($email_tlph_user, FILTER_VALIDATE_EMAIL)) {
            $get_userid_query = $conn->prepare("SELECT id_user,email_user FROM preutilisateurs WHERE email_user = '$email_tlph_user'");
            $get_userid_query->execute();
            $get_userid_row = $get_userid_query->fetch(PDO::FETCH_ASSOC);
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
            $get_userid_query = $conn->prepare("SELECT id_user,tlph_user FROM preutilisateurs WHERE tlph_user = '$email_tlph_user'");
            $get_userid_query->execute();
            $get_userid_row =$get_userid_query->fetch(PDO::FETCH_ASSOC);
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