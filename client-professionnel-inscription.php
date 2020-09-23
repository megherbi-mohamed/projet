<?php 
session_start();
include_once './bdd/connexion.php';
$id_user = htmlspecialchars($_POST['id_user']);
$type_user = htmlspecialchars($_POST['type_user']);
$get_preuser_query = "SELECT * FROM preutilisateurs WHERE id_user = '$id_user'";
$get_preuser_result = mysqli_query($conn,$get_preuser_query);
if($get_preuser_row = mysqli_fetch_assoc($get_preuser_result)){
    $nom_user = $get_preuser_row['nom_user'];
    $tlph_user = $get_preuser_row['tlph_user'];
    $email_user = $get_preuser_row['email_user'];
    $mtp_user = $get_preuser_row['mtp_user'];
    $set_preuser_query = "INSERT INTO utilisateurs (type_user,nom_user,email_user,tlph_user,mtp_user,cnx_count)
                                    VALUES ('$type_user','$nom_user','$email_user','$tlph_user','$mtp_user',0)";
    if(mysqli_query($conn,$set_preuser_query)){
        $delete_preuser_query = "DELETE FROM preutilisateurs WHERE id_user ='$id_user'";
        if(mysqli_query($conn,$delete_preuser_query)){
            $get_iduser_query = "SELECT id_user FROM utilisateurs WHERE email_user = '$email_user' AND tlph_user = '$tlph_user'";
            $get_iduser_result = mysqli_query($conn,$get_iduser_query);
            $get_iduser_row = mysqli_fetch_assoc($get_iduser_result); 
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