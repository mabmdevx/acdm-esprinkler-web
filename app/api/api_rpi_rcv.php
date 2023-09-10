<?php
include_once("../lib/lib.dbConnection.php");
include_once("../config/constants.inc.php");
include_once("../lib/lib.commonFunc.php");
include_once("../lib/lib.sysFunc.php");
include_once("../lib/lib.syslog.php");

$moisture_sensor_reading = "";
if(isset($_GET['moisture_sensor_reading']))
{
	$moisture_sensor_reading = htmlentities($_GET['moisture_sensor_reading']);
	save_moisture_sensor_reading($moisture_sensor_reading);
}

$sprinkler_mode=get_sprinkler_mode();

if($sprinkler_mode=="1")
{
	$sprinkler_operation=get_sprinkler_manual_operation();
}
elseif($sprinkler_mode=="2")
{	
	$sprinkler_operation=get_sprinkler_scheduler_operation();
}
elseif($sprinkler_mode=="3")
{
	$sprinkler_operation=get_sprinkler_intellisense_operation($moisture_sensor_reading);
}

if(strpos($_SERVER['HTTP_USER_AGENT'],"MSIE")>0){
	header("Cache-Control: private, max-age=0");
	header("Expires: -1"); 
}else{
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
}
header("Content-Type: text/xml; charset=UTF-8");

echo "<?xml version='1.0' encoding='UTF-8'?>\r\n";

?>
<esprinkler>
	<operation><?php echo $sprinkler_operation; ?></operation>
    <mode><?php echo $sprinkler_mode; ?></mode>
</esprinkler>
<?php
if($sprinkler_operation=="off")
{
	log_activity("Turn ON Sprinkler.");
	exit;
}
elseif($sprinkler_operation=="off")
{	 
	log_activity("Turn OFF Sprinkler.");
	exit;
}
else
{
	log_activity("Invalid Operation Received.");
	exit;
}
?>