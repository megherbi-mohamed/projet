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
        
        // $insert_msg = "INSERT INTO messages (message) VALUES ('changed')";
        // mysqli_query($conn,$insert_msg);
        
        $header = socket_read($socket_new, 1024); //read data sent by the socket
        perform_handshaking($header, $socket_new, $host, $port); //perform websocket handshake

        socket_getpeername($socket_new, $ip); //get ip address of connected socket
        $expl_header = explode('uid=', $header);
        $user_id = '';
		if ( count($expl_header) > 1 ) {
            $expl_value  = explode(' ', $expl_header[1]);
            $user_id = $expl_value[0];
        }
		//make room for new socket
        $found_socket = array_search($socket, $changed);
        unset($changed[$found_socket]);
		
		if ( !empty($user_id) && is_numeric($user_id) ) {
            $user_data[$user_id] = $user_id;
            $clients[$user_id] = $socket_new; //add socket to client array
		}
	}
	foreach ($changed as $changed_socket) {

        //check for any incomming data
        while(socket_recv($changed_socket, $buf, 1024, 0) >= 1)
        {
            $received_text = unmask($buf); //unmask data
            $tst_msg = json_decode($received_text); //json decode
            $user_id = $tst_msg->uid; //sender id
            $to_id = $tst_msg->to_id; //destination id
            $msgCle = $tst_msg->msgCle;
            $typeMessagerie = $tst_msg->typeMessagerie;

            $user_message = trim($tst_msg->message); //message text
            $timemsg = date("H:i:s");
            //prepare data to be sent to client
            $refreshSender = 0;
			if ( !empty($user_id) && !empty($user_message) ) {
				if ( array_key_exists($to_id, $clients) ) {
                    // echo ' two online';
                    $insert_msg = "INSERT INTO messages (message,id_recever,id_sender,temp_msg,etat_recever_msg,etat_sender_msg) VALUES ('$user_message','$user_id','$to_id','$timemsg','$user_id','$to_id')";
                    if (mysqli_query($conn,$insert_msg)) {
                        $response_text = mask(json_encode(array('typeMessagerie'=>$typeMessagerie,'refreshSender'=>$refreshSender,'msgCle'=>$msgCle,'idSender'=>$to_id,'idRecever'=>$user_id,'message'=>$user_message, 'timemsg'=>$timemsg)));
                        send_private_message($clients[$to_id], $response_text); //send data
                        //Send to Sender
                        $response_text = mask(json_encode(array('typeMessagerie'=>$typeMessagerie,'refreshSender'=>$refreshSender,'msgCle'=>$msgCle,'idSender'=>$to_id,'idRecever'=>$user_id,'message'=>$user_message, 'timemsg'=>$timemsg)));
                        send_private_message($clients[$user_id], $response_text); 
                    }   
                } 
                else {
                    // echo ' one online';
                    $refreshSender = 1;
					$insert_msg = "INSERT INTO messages (message,id_recever,id_sender,temp_msg,etat_recever_msg,etat_sender_msg) VALUES ('$user_message','$user_id','$to_id','$timemsg','$user_id','$to_id')";
                    if (mysqli_query($conn,$insert_msg)) {
                        $response_text = mask(json_encode(array('typeMessagerie'=>$typeMessagerie,'refreshSender'=>$refreshSender,'msgCle'=>$msgCle,'idSender'=>$to_id,'idRecever'=>$user_id,'message'=>$user_message, 'timemsg'=>$timemsg)));
                        send_private_message($clients[$user_id], $response_text); 
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