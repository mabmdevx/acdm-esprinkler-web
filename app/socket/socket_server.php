<?php
// server
date_default_timezone_set("America/Chicago");

$config_app = parse_ini_file('../../config/app.ini');
$server_name = $config_app['SOCKET_SERVER'];
$port_num1 = "8001";

 
// open a server on port 
$server = stream_socket_server("tcp://".$server_name.":".$port_num1, $errno, $errorMessage);
 
if ($server === false)
{
    die("Could not bind to socket: $errorMessage");
}
 
$connkv=array(); 
$connkvEach=array(); 
 
$client_socks = array();
while(true)
{
    //prepare readable sockets
    $read_socks = $client_socks;
    $read_socks[] = $server;
     
	 //var_dump($read_socks);
	 
    //start reading and use a large timeout
    if(!stream_select ( $read_socks, $write, $except, 300000 ))
    {
        die('something went wrong while selecting');
    }
     
    //new client
    if(in_array($server, $read_socks))
    {
        $new_client = stream_socket_accept($server);
         
        if ($new_client)
        {
            //print remote client information, ip and port number
            echo 'Connection accepted from ' . stream_socket_get_name($new_client, true) . "\n";
             array_push($connkvEach,stream_socket_get_name($new_client, true));
            $client_socks[] = $new_client;
            echo "Now there are total ". count($client_socks) . " clients.n";
        }
         
        //delete the server socket from the read sockets
        unset($read_socks[ array_search($server, $read_socks) ]);
    }
     
	
	 
    //message from existing client
    foreach($read_socks as $sock)
    {
        $data = fread($sock, 128);
		
		$msgArr=explode("#",$data);
		if($msgArr[0]=="init_from_pi")
		{
			array_push($connkvEach,$msgArr[1]);
			array_push($connkvEach,$msgArr[2]);
			array_push($connkv,$connkvEach);
		}
		
		var_dump($connkv);
		
        if(!$data)
        {
            unset($client_socks[ array_search($sock, $client_socks) ]);          
            echo "A client disconnected - ".stream_socket_get_name($sock, true).". Now there are total ". count($client_socks) . " clients"."\n";
            @fclose($sock);
			continue;
        }
        
		//send the message back to client
		echo $data;
		//check on port 8002 and close after checking
        fwrite($sock, $data);
    }
}


?>