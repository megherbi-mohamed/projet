<?php 
session_start();
include_once './bdd/connexion.php';
$id_user = htmlspecialchars($_POST['id_user']);
$type_user = htmlspecialchars($_POST['type_user']);
$get_preuser_query = $conn->prepare("SELECT * FROM preutilisateurs WHERE id_user = '$id_user'");
$get_preuser_query->execute();
if($get_preuser_row = $get_preuser_query->fetch(PDO::FETCH_ASSOC)){
    $nom_user = $get_preuser_row['nom_user'];
    $tlph_user = $get_preuser_row['tlph_user'];
    $email_user = $get_preuser_row['email_user'];
    $mtp_user = $get_preuser_row['mtp_user'];
    $set_preuser_query = $conn->prepare("INSERT INTO utilisateurs (type_user,nom_user,email_user,tlph_user,mtp_user,cnx_count)
                                    VALUES ('$type_user','$nom_user','$email_user','$tlph_user','$mtp_user',0)");
    if($set_preuser_query->execute()){
        $delete_preuser_query = $conn->prepare("DELETE FROM preutilisateurs WHERE id_user ='$id_user'");
        if($delete_preuser_query->execute()){
            $get_iduser_query = $conn->prepare("SELECT id_user FROM utilisateurs WHERE email_user = '$email_user' AND tlph_user = '$tlph_user'");
            $get_iduser_query->execute();
            $get_iduser_row = $get_iduser_query->fetch(PDO::FETCH_ASSOC); 
            $_SESSION['user'] = $get_iduser_row['id_user'];
            echo 1;
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
    echo 0;
}

?>