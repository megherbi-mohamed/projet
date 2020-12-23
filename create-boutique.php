<?php
session_start();
include_once './bdd/connexion.php';
$id_session = htmlspecialchars($_SESSION['user']);
$get_session_idSender_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
$get_session_idSender_query->execute();
$get_session_idSender_row = $get_session_idSender_query->fetch(PDO::FETCH_ASSOC);
$id_user = $get_session_idSender_row['id_user'];
$id_btq = htmlspecialchars($_POST['id_btq']);
$nom_btq = htmlspecialchars($_POST['nom_btq']);
$categorie = htmlspecialchars($_POST['categorie']);
$sous_categorie = htmlspecialchars($_POST['sous_categorie']);
$ville_btq = htmlspecialchars($_POST['ville_btq']);
$commune_btq = htmlspecialchars($_POST['commune_btq']);
$adresse_btq = htmlspecialchars($_POST['adresse_btq']);
$email_btq = htmlspecialchars($_POST['email_btq']);
$tlph_btq = htmlspecialchars($_POST['tlph_btq']);
$date =  date("Y-m-d");
$create_btq_query = $conn->prepare("UPDATE boutiques SET nom_btq = '$nom_btq', categorie_btq = '$categorie', sous_categorie_btq = '$sous_categorie',
                    ville_btq = '$ville_btq', commune_btq = '$commune_btq', adresse_btq = '$adresse_btq', email_btq = '$email_btq',
                    tlph_btq = '$tlph_btq', etat = 0, date = '$date' WHERE id_btq = $id_btq AND id_createur = $id_user AND etat = 1");
if($create_btq_query->execute()){
    $pass_id_query = $conn->prepare("INSERT INTO utilisateurs (id_user) VALUES (:id_user)");
    $pass_id_query->bindParam(':id_user',$id_btq);
    if ($pass_id_query->execute()) {
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
                $insert_sessions_1_query = $conn->prepare("INSERT INTO sessions_reserves (session_btq) VALUES (:session_btq)");
                $insert_sessions_1_query->bindParam(':session_btq',$session1);
                $insert_sessions_2_query = $conn->prepare("INSERT INTO sessions_reserves (session_btq) VALUES (:session_btq)");
                $insert_sessions_2_query->bindParam(':session_btq',$session2);
                $insert_sessions_3_query = $conn->prepare("INSERT INTO sessions_reserves (session_btq) VALUES (:session_btq)");
                $insert_sessions_3_query->bindParam(':session_btq',$session3);
                $insert_sessions_4_query = $conn->prepare("INSERT INTO sessions_reserves (session_btq) VALUES (:session_btq)");
                $insert_sessions_4_query->bindParam(':session_btq',$session4);
                $insert_sessions_5_query = $conn->prepare("INSERT INTO sessions_reserves (session_btq) VALUES (:session_btq)");
                $insert_sessions_5_query->bindParam(':session_btq',$session5);
                if ($insert_sessions_1_query->execute() && $insert_sessions_2_query->execute() && $insert_sessions_3_query->execute() && $insert_sessions_4_query->execute() && $insert_sessions_5_query->execute()) { 
                    $insert_session_query = $conn->prepare("INSERT INTO gerer_connexion (id_user,id_user_1,id_user_2,id_user_3,id_user_4,id_user_5) VALUES (:id_user,:id_user_1,:id_user_2,:id_user_3,:id_user_4,:id_user_5)");
                    $insert_session_query->bindParam(':id_user',$id_btq);
                    $insert_session_query->bindParam(':id_user_1',$session1);
                    $insert_session_query->bindParam(':id_user_2',$session2);
                    $insert_session_query->bindParam(':id_user_3',$session3);
                    $insert_session_query->bindParam(':id_user_4',$session4);
                    $insert_session_query->bindParam(':id_user_5',$session5);
                    if ($insert_session_query->execute()) {
                        $sessions_btq = ','.$id_user.'0'.$id_btq.',';
                        $first_connexion_query = $conn->prepare("UPDATE boutiques SET sessions_btq = '$sessions_btq' WHERE id_btq = $id_btq");
                        if ($first_connexion_query->execute()) {
                            $first_connexion_query = $conn->prepare("INSERT INTO sessions_active (id_user) VALUES (:id_user)");
                            $first_connexion_query->bindParam(':id_user',$id_btq);
                            $insert_reserve_session_query = $conn->prepare("UPDATE sessions_reserves SET session_usr = $id_session WHERE session_btq = $session1");
                            if ($first_connexion_query->execute() && $insert_reserve_session_query->execute()) {
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
            if ($session1 !== 0 && $session2 !== 0 && $session3 !== 0 && $session4 !== 0 && $session5 !== 0) {
                $insert_sessions_1_query = $conn->prepare("INSERT INTO sessions_reserves (session_btq) VALUES (:session_btq)");
                $insert_sessions_1_query->bindParam(':session_btq',$session1);
                $insert_sessions_2_query = $conn->prepare("INSERT INTO sessions_reserves (session_btq) VALUES (:session_btq)");
                $insert_sessions_2_query->bindParam(':session_btq',$session2);
                $insert_sessions_3_query = $conn->prepare("INSERT INTO sessions_reserves (session_btq) VALUES (:session_btq)");
                $insert_sessions_3_query->bindParam(':session_btq',$session3);
                $insert_sessions_4_query = $conn->prepare("INSERT INTO sessions_reserves (session_btq) VALUES (:session_btq)");
                $insert_sessions_4_query->bindParam(':session_btq',$session4);
                $insert_sessions_5_query = $conn->prepare("INSERT INTO sessions_reserves (session_btq) VALUES (:session_btq)");
                $insert_sessions_5_query->bindParam(':session_btq',$session5);
                if ($insert_sessions_1_query->execute() && $insert_sessions_2_query->execute() && $insert_sessions_3_query->execute() && $insert_sessions_4_query->execute() && $insert_sessions_5_query->execute()) { 
                    $insert_session_query = $conn->prepare("INSERT INTO gerer_connexion (id_user,id_user_1,id_user_2,id_user_3,id_user_4,id_user_5) VALUES (:id_user,:id_user_1,:id_user_2,:id_user_3,:id_user_4,:id_user_5)");
                    $insert_session_query->bindParam(':id_user',$id_btq);
                    $insert_session_query->bindParam(':id_user_1',$session1);
                    $insert_session_query->bindParam(':id_user_2',$session2);
                    $insert_session_query->bindParam(':id_user_3',$session3);
                    $insert_session_query->bindParam(':id_user_4',$session4);
                    $insert_session_query->bindParam(':id_user_5',$session5);
                    if ($insert_session_query->execute()) {
                        $sessions_btq = ','.$id_user.'0'.$id_btq.',';
                        $first_connexion_query = $conn->prepare("UPDATE boutiques SET sessions_btq = '$sessions_btq' WHERE id_btq = $id_btq");
                        if ($first_connexion_query->execute()) {
                            $first_connexion_query = $conn->prepare("INSERT INTO sessions_active (id_user) VALUES (:id_user)");
                            $first_connexion_query->bindParam(':id_user',$id_btq);
                            $insert_reserve_session_query = $conn->prepare("UPDATE sessions_reserves SET session_usr = $id_session WHERE session_btq = $session1");
                            if ($first_connexion_query->execute() && $insert_reserve_session_query->execute()) {
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

?>