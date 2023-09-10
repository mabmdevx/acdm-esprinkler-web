<?php
// client

$config_app = parse_ini_file('../../config/app.ini');
$server_name = $config_app['SOCKET_SERVER'];

$op="";
if(isset($_GET["op"]))
{
	$op=$_GET["op"];
}

$fp = stream_socket_client("tcp://".$server_name.":8002", $errno, $errstr, 30);

if(!$fp)
{
    echo "$errstr ($errno)<br />\n";
}
else
{
   // fwrite($fp, "GET / HTTP/1.0\r\nHost: ".$server_name."\r\nAccept: */*\r\n\r\n");
	
	fwrite($fp, $op."\n");
	
	echo "Connecting to Port 8002 using Socket-2"."\n";

    while (!feof($fp))
	{
        $rtn=fgets($fp, 1024);
		
		echo "Response from server : ".$rtn."\n";
		fwrite($fp, 'ACK from App on Port 8002 using Socket-2' . "\n");
		exit;
    }
    fclose($fp);
}
?>