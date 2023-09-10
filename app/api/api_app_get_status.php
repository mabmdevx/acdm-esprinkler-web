<?php
include_once("../lib/lib.dbConnection.php");
include_once("../config/constants.inc.php");
include_once("../lib/lib.commonFunc.php");
include_once("../lib/lib.sysFunc.php");
include_once("../lib/lib.syslog.php");

$qry="SELECT * FROM pi_track ORDER BY pt_id DESC LIMIT 1";
$res=$dbObj->fireQuery($qry,'select');

$db_ext_ip = "";
$db_int_ip = "";
$db_created_date = "";
$db_updated_date = "";
$pi_status = "offline";
$pi_status_color = "#FC6A6C";

if(isset($res) && count($res)>0 && $res!=false)
{
	$db_ext_ip = $res[0]['pt_ext_ip'];
	$db_int_ip = $res[0]['pt_int_ip'];
	$db_created_date = $res[0]['created_date'];
	$db_updated_date = $res[0]['updated_date'];
	
	$time_diff=(time()-strtotime($db_updated_date))/60;
	
	if($time_diff < 5)
	{
		$pi_status = "online";
		$pi_status_color = "#99CC00";
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
	<sprinklercurrentstatus><?php echo get_location_city(); ?></sprinklercurrentstatus>
	<sprinklerlocationcity><?php echo get_location_city(); ?></sprinklerlocationcity>
    <sprinklerlocationstate><?php echo get_location_state(); ?></sprinklerlocationstate>
    <sprinklermode><?php echo get_sprinkler_mode(); ?></sprinklermode>
    <moisturesensorreading><?php echo get_moisture_sensor_reading(); ?> [<?php echo moisture_sensor_reading_to_percent(get_moisture_sensor_reading());?>%]</moisturesensorreading>
    <moisturelevelset><?php echo get_moisture_level(); ?>%</moisturelevelset>
    <weathercurrentimage><?php echo get_weather_icon(); ?></weathercurrentimage>
    <weathercurrentinfo><?php echo get_weather_info_status(); ?></weathercurrentinfo>
    <weatherraincurrent><?php echo get_rain_current(); ?></weatherraincurrent>
    <weatherraintoday><?php echo get_rain_today(); ?></weatherraintoday>
    <weatherrainpop><?php echo get_rain_pop(); ?></weatherrainpop>
</esprinkler>