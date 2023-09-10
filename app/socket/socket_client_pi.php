<?php
// client

$config_app = parse_ini_file('../../config/app.ini');
$server_name = $config_app['SOCKET_SERVER'];

do_connect($server_name);

function do_connect($server_name)
{
	$fp = stream_socket_client("tcp://".$server_name.":8001", $errno, $errstr, 30);

	//stream_set_blocking($fp,1);
	
	if(!$fp)
	{
		echo "$errstr ($errno)<br />\n";
	}
	else
	{
		//fwrite($fp, "GET / HTTP/1.0\r\nHost: ".$server_name."\r\nAccept: */*\r\n\r\n");
		
		echo "Connecting to Port 8001 using Socket-1"."\n";
		
		fwrite($fp, 'init_from_pi#Pi-1#23df54ges' . "\n");
		
		while (!feof($fp))
		{
			
			//$rtn=fgets($fp, 128);		
			$rtn=fread($fp, 128);	
			//$chk_rtn = "socket_1"."\n";
			$info = stream_get_meta_data($fp);
			
			if ($info['timed_out']) {
				//echo 'Connection timed out!';
			} else {
				
				echo "Response from server : ".$rtn."\n";
				
				if($rtn=="turn_on_from_app")
				{
					echo "Turn On"."\n";
					fwrite($fp,"ACK from Pi on Port 8001 using Socket-1 for command:".$rtn."\n");	
				}
				else if($rtn=="turn_off_from_app")
				{
					echo "Turn Off"."\n";
					fwrite($fp,"ACK from Pi on Port 8001 using Socket-1 for command:".$rtn."\n");
				}
				
	
			}
			
			
			
			
		}
		fclose($fp);
	}
}


?>