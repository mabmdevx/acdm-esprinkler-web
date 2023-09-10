<?php
// server
date_default_timezone_set("America/Chicago");

$config_app = parse_ini_file('../../config/app.ini');
$server_name = $config_app['SOCKET_SERVER'];
$socket = stream_socket_server("tcp://".$server_name.":8000", $errno, $errstr);

if(!$socket)
{
  echo "$errstr ($errno)<br />\n";
} 
else
{
	try
	{	
		while ($conn = stream_socket_accept($socket,-1))
		{
			//while(1)
			//{
				//fwrite($conn, 'The local time is ' . date('n/j/Y g:i a') . "\n");
				fwrite($conn, 'sprinkler_on' . "\n");
			//}
			//fclose($conn);
		}
	  //fclose($socket);
	}
	catch(Exception $e)
	{
		echo $e;
	}
}
?>