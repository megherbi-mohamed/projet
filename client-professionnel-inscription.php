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
    $cnx_user = 0;
    $set_preuser_query = $conn->prepare("INSERT INTO utilisateurs (type_user,nom_user,email_user,tlph_user,mtp_user,cnx_count)
                                    VALUES (:type_user,:nom_user,:email_user,:tlph_user,:mtp_user,:cnx_count)");
    $set_preuser_query->bindParam(':type_user',$type_user);
    $set_preuser_query->bindParam(':nom_user',$nom_user);
    $set_preuser_query->bindParam(':email_user',$email_user);
    $set_preuser_query->bindParam(':tlph_user',$tlph_user);
    $set_preuser_query->bindParam(':mtp_user',$mtp_user);
    $set_preuser_query->bindParam(':cnx_count',$cnx_user);

    if($set_preuser_query->execute()){
        $delete_preuser_query = $conn->prepare("DELETE FROM preutilisateurs WHERE id_user ='$id_user'");
        if($delete_preuser_query->execute()){
            $get_iduser_query = $conn->prepare("SELECT id_user FROM utilisateurs WHERE email_user = '$email_user' AND tlph_user = '$tlph_user'");
            $get_iduser_query->execute();
            $get_iduser_row = $get_iduser_query->fetch(PDO::FETCH_ASSOC); 
            $user = $get_iduser_row['id_user'];

            function generateRandomString($length = 10) {
                $characters = '123456789';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                return $randomString;
            }
            $get_all_session_query = $conn->prepare("SELECT * FROM gerer_connexion");
            $get_all_session_query->execute();
            if ($get_all_session_query->rowCount() > 0) {
                $session1 = 0;
                $session2 = 0;
                $session3 = 0;
                $session4 = 0;
                $session5 = 0;
                while ($get_all_session_row = $get_all_session_query->fetch(PDO::FETCH_ASSOC)) {
                    $session_1 = $get_all_session_row['id_user_1'];
                    $session_2 = $get_all_session_row['id_user_2'];
                    $session_3 = $get_all_session_row['id_user_3'];
                    $session_4 = $get_all_session_row['id_user_4'];
                    $session_5 = $get_all_session_row['id_user_5'];
            
                    if (generateRandomString() !== $session_1 && generateRandomString() !== $session_2 && generateRandomString() !== $session_3 &&
                    generateRandomString() !== $session_4 && generateRandomString() !== $session_5) {
                        $session1 = generateRandomString();
                    }
                    else{
                        generateRandomString();
                    }
                    if (generateRandomString() !== $session_1 && generateRandomString() !== $session_2 && generateRandomString() !== $session_3 &&
                    generateRandomString() !== $session_4 && generateRandomString() !== $session_5) {
                        $session2 = generateRandomString();
                    }
                    else{
                        generateRandomString();
                    }
                    if (generateRandomString() !== $session_1 && generateRandomString() !== $session_2 && generateRandomString() !== $session_3 &&
                    generateRandomString() !== $session_4 && generateRandomString() !== $session_5) {
                        $session3 = generateRandomString();
                    }
                    else{
                        generateRandomString();
                    }
                    if (generateRandomString() !== $session_1 && generateRandomString() !== $session_2 && generateRandomString() !== $session_3 &&
                    generateRandomString() !== $session_4 && generateRandomString() !== $session_5) {
                        $session4 = generateRandomString();
                    }
                    else{
                        generateRandomString();
                    }
                    if (generateRandomString() !== $session_1 && generateRandomString() !== $session_2 && generateRandomString() !== $session_3 &&
                    generateRandomString() !== $session_4 && generateRandomString() !== $session_5) {
                        $session5 = generateRandomString();
                    }
                    else{
                        generateRandomString();
                    }
                }
                if ($session1 !== 0 && $session2 !== 0 && $session3 !== 0 && $session4 !== 0 && $session5 !== 0) {
                    $insert_session_query = $conn->prepare("INSERT INTO gerer_connexion (id_user,id_user_1,id_user_2,id_user_3,id_user_4,id_user_5) VALUES (:id_user,:id_user_1,:id_user_2,:id_user_3,:id_user_4,:id_user_5)");
                    $insert_session_query->bindParam(':id_user',$user);
                    $insert_session_query->bindParam(':id_user_1',$session1);
                    $insert_session_query->bindParam(':id_user_2',$session2);
                    $insert_session_query->bindParam(':id_user_3',$session3);
                    $insert_session_query->bindParam(':id_user_4',$session4);
                    $insert_session_query->bindParam(':id_user_5',$session5);
                    if ($insert_session_query->execute()) {

                        $first_connexion_query = $conn->prepare("INSERT INTO sessions_active (id_user,session_1) VALUES (:id_user,:session_1)");
                        $first_connexion_query->bindParam(':id_user',$user);
                        $first_connexion_query->bindParam(':session_1',$session1);
                        
                        $pass_id_query = $conn->prepare("INSERT INTO boutiques (id_btq) VALUES (:id_btq)");
                        $pass_id_query->bindParam(':id_btq',$user);

                        if ($first_connexion_query->execute() &&  $pass_id_query->execute()) {
                            $_SESSION['user'] = $session1;
                            echo $session1;
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
            }
            else{
                $session = generateRandomString();
                $sessions = array($session,0,0,0,0);
                foreach ($sessions as $s) {
                    if ($session != $s) {
                        $sessions[1] = $session;
                    }
                    else{
                        $session = generateRandomString(); 
                    }
                }
                foreach ($sessions as $s) {
                    if ($session != $s) {
                        $sessions[2] = $session;
                    }
                    else{
                        $session = generateRandomString(); 
                    }
                }
                foreach ($sessions as $s) {
                    if ($session != $s) {
                        $sessions[3] = $session;
                    }
                    else{
                        $session = generateRandomString(); 
                    }
                }
                foreach ($sessions as $s) {
                    if ($session != $s) {
                        $sessions[4] = $session;
                    }
                    else{
                        $session = generateRandomString(); 
                    }
                }
                $session1 = $sessions[0];
                $session2 = $sessions[1];
                $session3 = $sessions[2];
                $session4 = $sessions[3];
                $session5 = $sessions[4];
                if ($session2 !== 0 && $session3 !== 0 && $session4 !== 0 && $session5 !== 0) {
                    $insert_session_query = $conn->prepare("INSERT INTO gerer_connexion (id_user,id_user_1,id_user_2,id_user_3,id_user_4,id_user_5) VALUES (:id_user,:id_user_1,:id_user_2,:id_user_3,:id_user_4,:id_user_5)");
                    $insert_session_query->bindParam(':id_user',$user);
                    $insert_session_query->bindParam(':id_user_1',$session1);
                    $insert_session_query->bindParam(':id_user_2',$session2);
                    $insert_session_query->bindParam(':id_user_3',$session3);
                    $insert_session_query->bindParam(':id_user_4',$session4);
                    $insert_session_query->bindParam(':id_user_5',$session5);
                    if ($insert_session_query->execute()) {

                        $first_connexion_query = $conn->prepare("INSERT INTO sessions_active (id_user,session_1) VALUES (:id_user,:session_1)");
                        $first_connexion_query->bindParam(':id_user',$user);
                        $first_connexion_query->bindParam(':session_1',$session1);

                        $pass_id_query = $conn->prepare("INSERT INTO boutiques (id_btq) VALUES (:id_btq)");
                        $pass_id_query->bindParam(':id_btq',$user);

                        if ($first_connexion_query->execute() &&  $pass_id_query->execute()) {
                            $_SESSION['user'] = $session1;
                            echo $session1;
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
            }
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