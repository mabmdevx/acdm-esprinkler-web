<?php
// server
date_default_timezone_set("America/Chicago");

$config_app = parse_ini_file('../../config/app.ini');
$server_name = $config_app['SOCKET_SERVER'];

$socket1 = stream_socket_server("tcp://".$server_name.":8001", $errno, $errstr);
$socket2 = stream_socket_server("tcp://".$server_name.":8002", $errno, $errstr);

if(!$socket1)
{
  echo "$errstr ($errno)<br />\n";
} 
else
{
	try
	{	
		echo "Socket Server started..."."\n";
		
		while ($conn1 = stream_socket_accept($socket1,-1))
		{
			echo "Socket-1 on Port 8001 : Connection from RaspberryPi Received". "\n";
			
			fwrite($conn1, 'Socket-1 on Port 8001 : Connection from RaspberryPi Established' . "\n");

								
				/*if(!$socket2)
				{
				  echo "$errstr ($errno)<br />\n";
				} 
				else
				{
					try
					{	
						while ($conn2 = stream_socket_accept($socket2,-1))
						{
								echo "Socket-2 on Port 8002 : Connection from App Received". "\n";
							
								fwrite($conn2, 'Socket-2 on Port 8002 : Connection from App Established' . "\n");
								$rtn2=fgets($conn2, 1024);
								echo "Received from App on Port 8002 using Socket-2:".$rtn2."\n";
								
								fwrite($conn1, 'Socket-1 on Port 8001 : Send command from App to RaspberryPi' . "\n");	
								$rtn1=fgets($conn1, 1024);
								echo "Received from App on Port 8001 using Socket-1:".$rtn1."\n";						
								
								fwrite($conn1, $rtn2 . "\n");

							//fclose($conn);
						}
						echo "Socket-2 on Port 8002 : Connection from App Closed". "\n";	
					  //fclose($socket);
					}
					catch(Exception $e2)
					{
						echo $e2;
					}
				}*/

				
				
				
				
			if(!$conn1)
			{
				echo "Socket-1 on Port 8001 : Connection from RaspberryPi Lost". "\n";	
			}
			
			fclose($conn1);
		}
		
	  fclose($socket1);
	}
	catch(Exception $e1)
	{
		echo $e1;
	}
}







?>