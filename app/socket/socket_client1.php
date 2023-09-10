<?php
// client
$config_app = parse_ini_file('../../config/app.ini');
$server_name = $config_app['SOCKET_SERVER'];
$fp = stream_socket_client("tcp://".$server_name.":8000", $errno, $errstr, 30);

if(!$fp)
{
    echo "$errstr ($errno)<br />\n";
}
else
{
    fwrite($fp, "GET / HTTP/1.0\r\nHost: ".$server_name."\r\nAccept: */*\r\n\r\n");
    while (!feof($fp))
	{
        $rtn=fgets($fp, 1024);
		$chk_rtn = "sprinkler_on"."\n";
		if($rtn==$chk_rtn)
		{
			echo "Turn on sprinkler";
		}
    }
    fclose($fp);
}
?>