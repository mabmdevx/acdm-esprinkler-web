<?php
include_once("../lib/lib.dbConnection.php");
include_once("../config/constants.inc.php");
include_once("../lib/lib.commonFunc.php");
include_once("../lib/lib.sysFunc.php");
include_once("../lib/lib.syslog.php");

$app_set_location_city = "";
$app_set_location_state = "";
$rtn_set_location = "false";

if(isset($_GET['app_set_location']))
{
	$app_set_location_city = htmlentities($_GET['app_set_location_city']);	
	$app_set_location_state = htmlentities($_GET['app_set_location_state']);
	$rtn_set_location = set_location($app_set_location_city,$app_set_location_state);
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
	<locationcity><?php echo $app_set_location_city; ?></locationcity>
    <locationstate><?php echo $app_set_location_state; ?></locationstate>
    <setlocation><?php echo $rtn_set_location; ?></setlocation>
</esprinkler>