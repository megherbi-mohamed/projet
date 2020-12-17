<?php
error_reporting(0);
include 'bdd/connexion.php';
set_time_limit(0);
$port = '3030';
$host = '0.0.0.0';
$null = NULL; //null 
//Create TCP/IP sream socket
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
//reuseable port
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);
//bind socket to specified host
socket_bind($socket, 0, $port);
//listen to port
socket_listen($socket);
//create & add listning socket to the list
$clients = array($socket);
//Users Socket
$user_data = array();
while ( true ) {
    $changed = $clients;
    //returns the socket resources in $changed array
    socket_select($changed, $null, $null, 0, 10);
	if (in_array($socket, $changed)) {
        $socket_new = socket_accept($socket); //accpet new socket
        
        $header = socket_read($socket_new, 1024); //read data sent by the socket
        perform_handshaking($header, $socket_new, $host, $port); //perform websocket handshake

        socket_getpeername($socket_new, $ip); //get ip address of connected socket
        $expl_header = explode('uid=', $header);
        $user_id = '';
		if ( count($expl_header) > 1 ) {
            $expl_value  = explode(' ', $expl_header[1]);
            $user_id = $expl_value[0];
        }
        
        $get_session_user_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = $user_id OR id_user_1 = $user_id OR id_user_2 = $user_id 
                                                    OR id_user_3 = $user_id OR id_user_4 = $user_id OR id_user_5 = $user_id");
        $get_session_user_query->execute();
        $get_session_user_row = $get_session_user_query->fetch(PDO::FETCH_ASSOC);
        $id_user = $get_session_user_row['id_user'];
        $get_current_sessions_query = $conn->prepare("SELECT session_1,session_2,session_3,session_4,session_5 FROM sessions_active WHERE id_user = $id_user");
        $get_current_sessions_query->execute();
        $get_current_sessions_row = $get_current_sessions_query->fetch(PDO::FETCH_ASSOC);
        $session1 = $get_current_sessions_row['session_1'];
        $session2 = $get_current_sessions_row['session_2'];
        $session3 = $get_current_sessions_row['session_3'];
        $session4 = $get_current_sessions_row['session_4'];
        $session5 = $get_current_sessions_row['session_5'];
        $sessions = array($session1,$session2,$session3,$session4,$session5);
        if (!in_array($user_id, $sessions)) {
            if ($session1 == null) {
                $insert_session_query = $conn->prepare("UPDATE sessions_active SET session_1 = '$user_id' WHERE id_user = $id_user");
                $insert_session_query->execute();
            }
            else if ($session2 == null) {
                $insert_session_query = $conn->prepare("UPDATE sessions_active SET session_2 = '$user_id' WHERE id_user = $id_user");
                $insert_session_query->execute();
            }
            else if ($session3 == null) {
                $insert_session_query = $conn->prepare("UPDATE sessions_active SET session_3 = '$user_id' WHERE id_user = $id_user");
                $insert_session_query->execute();
            }
            else if ($session4 == null) {
                $insert_session_query = $conn->prepare("UPDATE sessions_active SET session_4 = '$user_id' WHERE id_user = $id_user");
                $insert_session_query->execute();
            }
            else if ($session5 == null) {
                $insert_session_query = $conn->prepare("UPDATE sessions_active SET session_5 = '$user_id' WHERE id_user = $id_user");
                $insert_session_query->execute();
            }
        }
		//make room for new socket
        $found_socket = array_search($socket, $changed);
        unset($changed[$found_socket]);
		
		if ( !empty($user_id) && is_numeric($user_id) && !in_array($user_id, $user_data)) {
            $user_data[$user_id] = $user_id;
            $clients[$user_id] = $socket_new; //add socket to client array
        }
    }

	foreach ($changed as $changed_socket) {
        //check for any incomming data
        while(socket_recv($changed_socket, $buf, 1024, 0) >= 1) {
            $received_text = unmask($buf); //unmask data
            $tst_msg = json_decode($received_text); //json decode
            $typeNotification = $tst_msg->typeNotification; 
            if ($typeNotification == 'message') {
                $user_id = $tst_msg->uid; //sender id
                $to_id = $tst_msg->to_id; //destination id
                $get_all_recever_query = $conn->prepare("SELECT * FROM gerer_connexion WHERE id_user = '$to_id' OR id_user_1 = '$to_id' OR id_user_2 = '$to_id' 
                OR id_user_3 = '$to_id' OR id_user_4 = '$to_id' OR id_user_5 = '$to_id'");
                $get_all_recever_query->execute();
                $get_all_recever_row = $get_all_recever_query->fetch(PDO::FETCH_ASSOC);
                
                $recever = $get_all_recever_row['id_user'];
                $recever_1 = $get_all_recever_row['id_user_1'];
                $recever_2 = $get_all_recever_row['id_user_2'];
                $recever_3 = $get_all_recever_row['id_user_3'];
                $recever_4 = $get_all_recever_row['id_user_4'];
                $recever_5 = $get_all_recever_row['id_user_5'];

                $msgCle = $tst_msg->msgCle;
                $typeMessagerie = $tst_msg->typeMessagerie;
                $user_message = trim($tst_msg->message); //message text
                $timemsg = date("H:i:s");
                //prepare data to be sent to client
                $refreshSender = 0;
                // echo 'eada ';
                if ( !empty($user_id) && !empty($user_message) ) {
                    $get_all_sender_query = $conn->prepare("SELECT * FROM gerer_connexion WHERE id_user = '$user_id' OR id_user_1 = '$user_id' OR id_user_2 = '$user_id' 
                    OR id_user_3 = '$user_id' OR id_user_4 = '$user_id' OR id_user_5 = '$user_id'");
                    $get_all_sender_query->execute();
                    $get_all_sender_row = $get_all_sender_query->fetch(PDO::FETCH_ASSOC);
                    
                    $sender = $get_all_sender_row['id_user'];
                    $sender_1 = $get_all_sender_row['id_user_1'];
                    $sender_2 = $get_all_sender_row['id_user_2'];
                    $sender_3 = $get_all_sender_row['id_user_3'];
                    $sender_4 = $get_all_sender_row['id_user_4'];
                    $sender_5 = $get_all_sender_row['id_user_5'];

                    $insert_msg_query = $conn->prepare("INSERT INTO messages (message,id_recever,id_sender,temp_msg,etat_recever_msg,etat_sender_msg,msg_cle) VALUES (:message,:id_recever,:id_sender,:temp_msg,:etat_recever_msg,:etat_sender_msg,:msg_cle)");
                    $insert_msg_query->bindParam(':message',$user_message);
                    $insert_msg_query->bindParam(':id_recever',$sender);
                    $insert_msg_query->bindParam(':id_sender',$recever);
                    $insert_msg_query->bindParam(':temp_msg',$timemsg);
                    $insert_msg_query->bindParam(':etat_recever_msg',$sender);
                    $insert_msg_query->bindParam(':etat_sender_msg',$recever);
                    $insert_msg_query->bindParam(':msg_cle',$msgCle);
                    if ($insert_msg_query->execute()) {
                        $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'typeMessagerie'=>$typeMessagerie,'refreshSender'=>$refreshSender,'msgCle'=>$msgCle,'idSender'=>$recever,'idRecever'=>$user_id,'message'=>$user_message, 'timemsg'=>$timemsg)));
                        send_private_message($clients[$recever], $response_text);
                        $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'typeMessagerie'=>$typeMessagerie,'refreshSender'=>$refreshSender,'msgCle'=>$msgCle,'idSender'=>$recever_1,'idRecever'=>$user_id,'message'=>$user_message, 'timemsg'=>$timemsg)));
                        send_private_message($clients[$recever_1], $response_text);
                        $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'typeMessagerie'=>$typeMessagerie,'refreshSender'=>$refreshSender,'msgCle'=>$msgCle,'idSender'=>$recever_2,'idRecever'=>$user_id,'message'=>$user_message, 'timemsg'=>$timemsg)));
                        send_private_message($clients[$recever_2], $response_text);
                        $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'typeMessagerie'=>$typeMessagerie,'refreshSender'=>$refreshSender,'msgCle'=>$msgCle,'idSender'=>$recever_3,'idRecever'=>$user_id,'message'=>$user_message, 'timemsg'=>$timemsg)));
                        send_private_message($clients[$recever_3], $response_text);
                        $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'typeMessagerie'=>$typeMessagerie,'refreshSender'=>$refreshSender,'msgCle'=>$msgCle,'idSender'=>$recever_4,'idRecever'=>$user_id,'message'=>$user_message, 'timemsg'=>$timemsg)));
                        send_private_message($clients[$recever_4], $response_text);
                        $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'typeMessagerie'=>$typeMessagerie,'refreshSender'=>$refreshSender,'msgCle'=>$msgCle,'idSender'=>$recever_5,'idRecever'=>$user_id,'message'=>$user_message, 'timemsg'=>$timemsg)));
                        send_private_message($clients[$recever_5], $response_text);
                        
                        $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'typeMessagerie'=>$typeMessagerie,'refreshSender'=>$refreshSender,'msgCle'=>$msgCle,'idSender'=>$to_id,'idRecever'=>$sender,'message'=>$user_message, 'timemsg'=>$timemsg)));
                        send_private_message($clients[$sender], $response_text); 
                        $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'typeMessagerie'=>$typeMessagerie,'refreshSender'=>$refreshSender,'msgCle'=>$msgCle,'idSender'=>$to_id,'idRecever'=>$sender_1,'message'=>$user_message, 'timemsg'=>$timemsg)));
                        send_private_message($clients[$sender_1], $response_text);
                        $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'typeMessagerie'=>$typeMessagerie,'refreshSender'=>$refreshSender,'msgCle'=>$msgCle,'idSender'=>$to_id,'idRecever'=>$sender_2,'message'=>$user_message, 'timemsg'=>$timemsg)));
                        send_private_message($clients[$sender_2], $response_text);
                        $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'typeMessagerie'=>$typeMessagerie,'refreshSender'=>$refreshSender,'msgCle'=>$msgCle,'idSender'=>$to_id,'idRecever'=>$sender_3,'message'=>$user_message, 'timemsg'=>$timemsg)));
                        send_private_message($clients[$sender_3], $response_text);
                        $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'typeMessagerie'=>$typeMessagerie,'refreshSender'=>$refreshSender,'msgCle'=>$msgCle,'idSender'=>$to_id,'idRecever'=>$sender_4,'message'=>$user_message, 'timemsg'=>$timemsg)));
                        send_private_message($clients[$sender_4], $response_text);
                        $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'typeMessagerie'=>$typeMessagerie,'refreshSender'=>$refreshSender,'msgCle'=>$msgCle,'idSender'=>$to_id,'idRecever'=>$sender_5,'message'=>$user_message, 'timemsg'=>$timemsg)));
                        send_private_message($clients[$sender_5], $response_text);
                    }   
                }
            } 
            else if ($typeNotification == 'publication') {
                $user_id = $tst_msg->uid;
                if ( !empty($user_id) ) {
                    $get_all_sender_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$user_id' OR id_user_1 = '$user_id' OR id_user_2 = '$user_id' 
                    OR id_user_3 = '$user_id' OR id_user_4 = '$user_id' OR id_user_5 = '$user_id'");
                    $get_all_sender_query->execute();
                    $get_all_sender_row = $get_all_sender_query->fetch(PDO::FETCH_ASSOC);
                    $sender = $get_all_sender_row['id_user'];

                    $get_user_abn_query = $conn->prepare("SELECT id_user FROM abonnes WHERE id_abn_user = $sender");
                    $get_user_abn_query->execute();
                    while ($get_user_abn_row = $get_user_abn_query->fetch(PDO::FETCH_ASSOC)) {
                        $id_user = $get_user_abn_row['id_user'];

                        $get_all_recever_query = $conn->prepare("SELECT * FROM gerer_connexion WHERE id_user = '$id_user' OR id_user_1 = '$id_user' OR id_user_2 = '$id_user' 
                        OR id_user_3 = '$id_user' OR id_user_4 = '$id_user' OR id_user_5 = '$id_user'");
                        $get_all_recever_query->execute();
                        $get_all_recever_row = $get_all_recever_query->fetch(PDO::FETCH_ASSOC);
                        
                        $recever = $get_all_recever_row['id_user'];
                        $recever_1 = $get_all_recever_row['id_user_1'];
                        $recever_2 = $get_all_recever_row['id_user_2'];
                        $recever_3 = $get_all_recever_row['id_user_3'];
                        $recever_4 = $get_all_recever_row['id_user_4'];
                        $recever_5 = $get_all_recever_row['id_user_5'];
                    
                        $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'to_id'=>$recever)));
                        send_private_message($clients[$recever], $response_text);
                        $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'to_id'=>$recever_1)));
                        send_private_message($clients[$recever_1], $response_text);
                        $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'to_id'=>$recever_2)));
                        send_private_message($clients[$recever_2], $response_text);
                        $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'to_id'=>$recever_3)));
                        send_private_message($clients[$recever_3], $response_text);
                        $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'to_id'=>$recever_4)));
                        send_private_message($clients[$recever_4], $response_text);
                        $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'to_id'=>$recever_5)));
                        send_private_message($clients[$recever_5], $response_text);
                    }
                }  
            }
            else if ($typeNotification == 'like') {
                $user_id = $tst_msg->uid;
                if ( !empty($user_id) ) {
                    $id_user = $tst_msg->to_id;

                    $get_all_recever_query = $conn->prepare("SELECT * FROM gerer_connexion WHERE id_user = '$id_user' OR id_user_1 = '$id_user' OR id_user_2 = '$id_user' 
                    OR id_user_3 = '$id_user' OR id_user_4 = '$id_user' OR id_user_5 = '$id_user'");
                    $get_all_recever_query->execute();
                    $get_all_recever_row = $get_all_recever_query->fetch(PDO::FETCH_ASSOC);
                    
                    $recever = $get_all_recever_row['id_user'];
                    $recever_1 = $get_all_recever_row['id_user_1'];
                    $recever_2 = $get_all_recever_row['id_user_2'];
                    $recever_3 = $get_all_recever_row['id_user_3'];
                    $recever_4 = $get_all_recever_row['id_user_4'];
                    $recever_5 = $get_all_recever_row['id_user_5'];

                    $id_pub = $tst_msg->idPub;

                    $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'idPub'=>$id_pub,'to_id'=>$recever)));
                    send_private_message($clients[$recever], $response_text);
                    $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'idPub'=>$id_pub,'to_id'=>$recever_1)));
                    send_private_message($clients[$recever_1], $response_text);
                    $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'idPub'=>$id_pub,'to_id'=>$recever_2)));
                    send_private_message($clients[$recever_2], $response_text);
                    $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'idPub'=>$id_pub,'to_id'=>$recever_3)));
                    send_private_message($clients[$recever_3], $response_text);
                    $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'idPub'=>$id_pub,'to_id'=>$recever_4)));
                    send_private_message($clients[$recever_4], $response_text);
                    $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'idPub'=>$id_pub,'to_id'=>$recever_5)));
                    send_private_message($clients[$recever_5], $response_text);
                }  
            }
            else if ($typeNotification == 'commentaire') {
                $user_id = $tst_msg->uid;
                if ( !empty($user_id) ) {
                    $id_user = $tst_msg->to_id;

                    $get_all_recever_query = $conn->prepare("SELECT * FROM gerer_connexion WHERE id_user = '$id_user' OR id_user_1 = '$id_user' OR id_user_2 = '$id_user' 
                    OR id_user_3 = '$id_user' OR id_user_4 = '$id_user' OR id_user_5 = '$id_user'");
                    $get_all_recever_query->execute();
                    $get_all_recever_row = $get_all_recever_query->fetch(PDO::FETCH_ASSOC);
                    
                    $recever = $get_all_recever_row['id_user'];
                    $recever_1 = $get_all_recever_row['id_user_1'];
                    $recever_2 = $get_all_recever_row['id_user_2'];
                    $recever_3 = $get_all_recever_row['id_user_3'];
                    $recever_4 = $get_all_recever_row['id_user_4'];
                    $recever_5 = $get_all_recever_row['id_user_5'];

                    $id_pub = $tst_msg->idPub;
                    $img_user = $tst_msg->imgUser;
                    $nom_user = $tst_msg->nomUser;
                    $commentaire = $tst_msg->commentaire;

                    $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'idPub'=>$id_pub,'to_id'=>$recever,'img_user'=>$img_user,'nom_user'=>$nom_user,'commentaire'=>$commentaire)));
                    send_private_message($clients[$recever], $response_text);
                    $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'idPub'=>$id_pub,'to_id'=>$recever_1,'img_user'=>$img_user,'nom_user'=>$nom_user,'commentaire'=>$commentaire)));
                    send_private_message($clients[$recever_1], $response_text);
                    $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'idPub'=>$id_pub,'to_id'=>$recever_2,'img_user'=>$img_user,'nom_user'=>$nom_user,'commentaire'=>$commentaire)));
                    send_private_message($clients[$recever_2], $response_text);
                    $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'idPub'=>$id_pub,'to_id'=>$recever_3,'img_user'=>$img_user,'nom_user'=>$nom_user,'commentaire'=>$commentaire)));
                    send_private_message($clients[$recever_3], $response_text);
                    $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'idPub'=>$id_pub,'to_id'=>$recever_4,'img_user'=>$img_user,'nom_user'=>$nom_user,'commentaire'=>$commentaire)));
                    send_private_message($clients[$recever_4], $response_text);
                    $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'idPub'=>$id_pub,'to_id'=>$recever_5,'img_user'=>$img_user,'nom_user'=>$nom_user,'commentaire'=>$commentaire)));
                    send_private_message($clients[$recever_5], $response_text);
                }  
            }
            else if ($typeNotification == 'abonnement') {
                $user_id = $tst_msg->uid;
                if ( !empty($user_id) ) {
                    $id_abn_user = $tst_msg->to_id;

                    $get_all_recever_query = $conn->prepare("SELECT * FROM gerer_connexion WHERE id_user = '$id_abn_user' OR id_user_1 = '$id_abn_user' OR id_user_2 = '$id_abn_user' 
                    OR id_user_3 = '$id_abn_user' OR id_user_4 = '$id_abn_user' OR id_user_5 = '$id_abn_user'");
                    $get_all_recever_query->execute();
                    $get_all_recever_row = $get_all_recever_query->fetch(PDO::FETCH_ASSOC);
                    
                    $recever = $get_all_recever_row['id_user'];
                    $recever_1 = $get_all_recever_row['id_user_1'];
                    $recever_2 = $get_all_recever_row['id_user_2'];
                    $recever_3 = $get_all_recever_row['id_user_3'];
                    $recever_4 = $get_all_recever_row['id_user_4'];
                    $recever_5 = $get_all_recever_row['id_user_5'];

                    $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'id_abn_user'=>$recever)));
                    send_private_message($clients[$recever], $response_text);
                    $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'id_abn_user'=>$recever_1)));
                    send_private_message($clients[$recever_1], $response_text);
                    $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'id_abn_user'=>$recever_2)));
                    send_private_message($clients[$recever_2], $response_text);
                    $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'id_abn_user'=>$recever_3)));
                    send_private_message($clients[$recever_3], $response_text);
                    $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'id_abn_user'=>$recever_4)));
                    send_private_message($clients[$recever_4], $response_text);
                    $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'id_abn_user'=>$recever_5)));
                    send_private_message($clients[$recever_5], $response_text);
                }  
            }
            else if ($typeNotification == 'abonnementBtq') {
                $user_id = $tst_msg->uid;
                if ( !empty($user_id) ) {
                    $id_abn_user = $tst_msg->to_id;

                    $get_all_recever_query = $conn->prepare("SELECT * FROM gerer_connexion WHERE id_user = '$id_abn_user' OR id_user_1 = '$id_abn_user' OR id_user_2 = '$id_abn_user' 
                    OR id_user_3 = '$id_abn_user' OR id_user_4 = '$id_abn_user' OR id_user_5 = '$id_abn_user'");
                    $get_all_recever_query->execute();
                    $get_all_recever_row = $get_all_recever_query->fetch(PDO::FETCH_ASSOC);
                    
                    $recever = $get_all_recever_row['id_user'];
                    $recever_1 = $get_all_recever_row['id_user_1'];
                    $recever_2 = $get_all_recever_row['id_user_2'];
                    $recever_3 = $get_all_recever_row['id_user_3'];
                    $recever_4 = $get_all_recever_row['id_user_4'];
                    $recever_5 = $get_all_recever_row['id_user_5'];

                    $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'id_abn_user'=>$recever)));
                    send_private_message($clients[$recever], $response_text);
                    $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'id_abn_user'=>$recever_1)));
                    send_private_message($clients[$recever_1], $response_text);
                    $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'id_abn_user'=>$recever_2)));
                    send_private_message($clients[$recever_2], $response_text);
                    $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'id_abn_user'=>$recever_3)));
                    send_private_message($clients[$recever_3], $response_text);
                    $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'id_abn_user'=>$recever_4)));
                    send_private_message($clients[$recever_4], $response_text);
                    $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'id_abn_user'=>$recever_5)));
                    send_private_message($clients[$recever_5], $response_text);
                }  
            }
            else if ($typeNotification == 'commentaireBtq') {
                $user_id = $tst_msg->uid;
                if ( !empty($user_id) ) {
                    $id_user = $tst_msg->to_id;

                    $get_all_recever_query = $conn->prepare("SELECT * FROM gerer_connexion WHERE id_user = '$id_user' OR id_user_1 = '$id_user' OR id_user_2 = '$id_user' 
                    OR id_user_3 = '$id_user' OR id_user_4 = '$id_user' OR id_user_5 = '$id_user'");
                    $get_all_recever_query->execute();
                    $get_all_recever_row = $get_all_recever_query->fetch(PDO::FETCH_ASSOC);
                    
                    $recever = $get_all_recever_row['id_user'];
                    $recever_1 = $get_all_recever_row['id_user_1'];
                    $recever_2 = $get_all_recever_row['id_user_2'];
                    $recever_3 = $get_all_recever_row['id_user_3'];
                    $recever_4 = $get_all_recever_row['id_user_4'];
                    $recever_5 = $get_all_recever_row['id_user_5'];

                    $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'to_id'=>$recever)));
                    send_private_message($clients[$recever], $response_text);
                    $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'to_id'=>$recever_1)));
                    send_private_message($clients[$recever_1], $response_text);
                    $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'to_id'=>$recever_2)));
                    send_private_message($clients[$recever_2], $response_text);
                    $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'to_id'=>$recever_3)));
                    send_private_message($clients[$recever_3], $response_text);
                    $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'to_id'=>$recever_4)));
                    send_private_message($clients[$recever_4], $response_text);
                    $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'to_id'=>$recever_5)));
                    send_private_message($clients[$recever_5], $response_text);
                }  
            }
            else if ($typeNotification == 'produit') {
                $user_id = $tst_msg->uid;
                $get_id_btq_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$user_id' OR id_user_1 = '$user_id' OR id_user_2 = '$user_id' 
                OR id_user_3 = '$user_id' OR id_user_4 = '$user_id' OR id_user_5 = '$user_id'");
                $get_id_btq_query->execute();
                $get_id_btq_row = $get_id_btq_query->fetch(PDO::FETCH_ASSOC);
                $id_btq = $get_id_btq_row['id_user'];
                if ( !empty($id_btq) ) {
                    $get_user_abn_query = $conn->prepare("SELECT id_user FROM abonnes WHERE id_abn_user = $id_btq");
                    $get_user_abn_query->execute();
                    while ($get_user_abn_row = $get_user_abn_query->fetch(PDO::FETCH_ASSOC)) {
                        $id_user = $get_user_abn_row['id_user'];
                        $get_all_recever_query = $conn->prepare("SELECT * FROM gerer_connexion WHERE id_user = '$id_user' OR id_user_1 = '$id_user' OR id_user_2 = '$id_user' 
                        OR id_user_3 = '$id_user' OR id_user_4 = '$id_user' OR id_user_5 = '$id_user'");
                        $get_all_recever_query->execute();
                        $get_all_recever_row = $get_all_recever_query->fetch(PDO::FETCH_ASSOC);
                        
                        $recever = $get_all_recever_row['id_user'];
                        $recever_1 = $get_all_recever_row['id_user_1'];
                        $recever_2 = $get_all_recever_row['id_user_2'];
                        $recever_3 = $get_all_recever_row['id_user_3'];
                        $recever_4 = $get_all_recever_row['id_user_4'];
                        $recever_5 = $get_all_recever_row['id_user_5'];

                        $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'to_id'=>$recever)));
                        send_private_message($clients[$recever], $response_text);
                        $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'to_id'=>$recever_1)));
                        send_private_message($clients[$recever_1], $response_text);
                        $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'to_id'=>$recever_2)));
                        send_private_message($clients[$recever_2], $response_text);
                        $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'to_id'=>$recever_3)));
                        send_private_message($clients[$recever_3], $response_text);
                        $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'to_id'=>$recever_4)));
                        send_private_message($clients[$recever_4], $response_text);
                        $response_text = mask(json_encode(array('typeNotification'=>$typeNotification,'to_id'=>$recever_5)));
                        send_private_message($clients[$recever_5], $response_text);
                    }
                }  
            }
            break 2;
        }
		$buf = @socket_read($changed_socket, 1024, PHP_NORMAL_READ);
        if  ( $buf == false ) { // check disconnected client
            $found_socket = array_search($changed_socket, $clients);
            // remove client for $clients array
            socket_getpeername($changed_socket, $ip);
            $clients = array_diff($clients, array($change_socket));
			if ( array_key_exists($found_socket, $user_data) )
                unset($user_data[$found_socket]);
                $remove_session_user_qeury = $conn->prepare("UPDATE sessions_active SET
                    session_1 = (CASE WHEN session_1 = '$found_socket' then null else session_1 end),
                    session_2 = (CASE WHEN session_2 = '$found_socket' then null else session_2 end),
                    session_3 = (CASE WHEN session_3 = '$found_socket' then null else session_3 end),
                    session_4 = (CASE WHEN session_4 = '$found_socket' then null else session_4 end),
                    session_5 = (CASE WHEN session_5 = '$found_socket' then null else session_5 end)");
                $remove_session_user_qeury->execute();
                $remove_reserve_session_query = $conn->prepare("UPDATE sessions_reserves SET session_usr = null WHERE session_btq = $found_socket");
                $remove_reserve_session_query->execute();
            socket_close($changed_socket);
        }
	}
	
}

// close the listening socket
socket_close($socket);
function send_message($msg)
{
    global $clients;
    foreach($clients as $changed_socket)
    {
        @socket_write($changed_socket,$msg,strlen($msg));
    }
    return true;
}
function send_private_message($changed_socket, $msg) {
    @socket_write($changed_socket,$msg,strlen($msg));
    return true;
}
//Unmask incoming framed message
function unmask($text) {
    $length = ord($text[1]) & 127;
    if($length == 126) {
        $masks = substr($text, 4, 4);
        $data = substr($text, 8);
    }
    elseif($length == 127) {
        $masks = substr($text, 10, 4);
        $data = substr($text, 14);
    }
    else {
        $masks = substr($text, 2, 4);
        $data = substr($text, 6);
    }
    $text = "";
    for ($i = 0; $i < strlen($data); ++$i) {
        $text .= $data[$i] ^ $masks[$i%4];
    }
    return $text;
}

//Encode message for transfer to client.
function mask($text)
{
    $b1 = 0x80 | (0x1 & 0x0f);
    $length = strlen($text);

    if($length <= 125)
        $header = pack('CC', $b1, $length);
    elseif($length > 125 && $length < 65536)
        $header = pack('CCn', $b1, 126, $length);
    elseif($length >= 65536)
        $header = pack('CCNN', $b1, 127, $length);
    return $header.$text;
}

//handshake new client.
function perform_handshaking($receved_header,$client_conn, $host, $port)
{
    $headers = array();
	//echo $receved_header."\r\n\r\n";
    $lines = preg_split("/\r\n/", $receved_header);
    foreach($lines as $line)
    {
        $line = chop($line);
        if(preg_match('/\A(\S+): (.*)\z/', $line, $matches))
        {
            $headers[$matches[1]] = $matches[2];
        }
    }

    $secKey = $headers['Sec-WebSocket-Key'];
    if ( !empty($secKey) ) {
        $secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
		//echo $secAccept."\r\n";
        //hand shaking header
        $upgrade  = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
            "Upgrade: websocket\r\n" .
            "Connection: Upgrade\r\n" .
            "WebSocket-Origin: $host\r\n" .
            "WebSocket-Location: ws://$host:$port\r\n".
            "Sec-WebSocket-Accept:$secAccept\r\n\r\n";
        socket_write($client_conn,$upgrade,strlen($upgrade));
    }
}
?>