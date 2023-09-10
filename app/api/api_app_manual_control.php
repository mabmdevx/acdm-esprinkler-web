<?php
include_once("../lib/lib.dbConnection.php");
include_once("../config/constants.inc.php");
include_once("../lib/lib.commonFunc.php");
include_once("../lib/lib.sysFunc.php");
include_once("../lib/lib.syslog.php");


if(isset($_GET['app_manual_control_operation']))
{
	$app_manual_control_operation = htmlentities($_GET['app_manual_control_operation']);	
	
	if($app_manual_control_operation=="on")
	{
		rpi_turn_on_manual_db();
	}
	else
	{
		rpi_turn_off_manual_db();
	}
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
	<mode><?php echo get_sprinkler_mode(); ?></mode>
    <manualoperation><?php echo get_sprinkler_manual_operation(); ?></manualoperation>
</esprinkler>