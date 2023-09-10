<?php
include_once("../lib/lib.dbConnection.php");
include_once("../config/constants.inc.php");
include_once("../lib/lib.commonFunc.php");
include_once("../lib/lib.sysFunc.php");
include_once("../lib/lib.syslog.php");


$weatherCurrentXml = get_weather_current_xml();
$weatherForecastXml = get_weather_forecast_xml();

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
	<locationcity><?php echo $weatherCurrentXml->current_observation->display_location->full; ?></locationcity>
    <locationstate><?php echo $weatherCurrentXml->current_observation->display_location->country; ?></locationstate>
    <latitude><?php echo $weatherCurrentXml->current_observation->display_location->latitude; ?></latitude>
    <longitude><?php echo $weatherCurrentXml->current_observation->display_location->longitude; ?></longitude>
    <temperature><?php echo $weatherCurrentXml->current_observation->temperature_string; ?></temperature>
    <feelsliketemperature><?php echo $weatherCurrentXml->current_observation->feelslike_string; ?></feelsliketemperature>
    <humidity><?php echo $weatherCurrentXml->current_observation->relative_humidity; ?></humidity>
    <wind><?php echo $weatherCurrentXml->current_observation->wind_string; ?></wind>
    <weathercurrentimage><?php echo get_weather_icon(); ?></weathercurrentimage>
    <weathercurrentinfo><?php echo get_weather_info_status(); ?></weathercurrentinfo>
    <weatherraincurrent><?php echo get_rain_current(); ?></weatherraincurrent>
    <weatherraintoday><?php echo get_rain_today(); ?></weatherraintoday>
    <weatherrainpop><?php echo get_rain_pop(); ?></weatherrainpop>
</esprinkler>