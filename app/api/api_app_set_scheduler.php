<?php
include_once("../lib/lib.dbConnection.php");
include_once("../config/constants.inc.php");
include_once("../lib/lib.commonFunc.php");
include_once("../lib/lib.sysFunc.php");
include_once("../lib/lib.syslog.php");

$app_set_scheduler_start_date = "";	
$app_set_scheduler_time_start1 = "";		
$app_set_scheduler_time_end1 = "";	
$app_set_scheduler_time_start2 = "";		
$app_set_scheduler_time_end2 = "";	
$app_set_scheduler_time_start3 = "";	
$app_set_scheduler_time_end3 = "";	
$app_set_scheduler_interval_day = "";	
$rtn_set_scheduler = "false";

if(isset($_GET['app_set_scheduler_start_date']) && isset($_GET['app_set_scheduler_start_date']))
{
	$app_set_scheduler_start_date = htmlentities($_GET['app_set_scheduler_start_date']);	
	$app_set_scheduler_time_start1 = htmlentities($_GET['app_set_scheduler_time_start1']);	
	$app_set_scheduler_time_end1 = htmlentities($_GET['app_set_scheduler_time_end1']);	
	$app_set_scheduler_time_start2 = htmlentities($_GET['app_set_scheduler_time_start2']);	
	$app_set_scheduler_time_end2 = htmlentities($_GET['app_set_scheduler_time_end2']);
	$app_set_scheduler_time_start3 = htmlentities($_GET['app_set_scheduler_time_start3']);
	$app_set_scheduler_time_end3 = htmlentities($_GET['app_set_scheduler_time_end3']);
	$app_set_scheduler_interval_day = htmlentities($_GET['app_set_scheduler_interval_day']);	
	
	$rtn_set_scheduler = scheduler_db($app_set_scheduler_start_date,$app_set_scheduler_time_start1,$app_set_scheduler_time_end1,$app_set_scheduler_time_start2,$app_set_scheduler_time_end2,$app_set_scheduler_time_start3,$app_set_scheduler_time_end3,$app_set_scheduler_interval_day);
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
    <schedulerdate><?php echo $app_set_scheduler_start_date; ?></schedulerdate>
    <schedulertimestart1><?php echo $app_set_scheduler_time_start1; ?></schedulertimestart1>
    <schedulertimeend1><?php echo $app_set_scheduler_time_end1; ?></schedulertimeend1>
    <schedulertimestart2><?php echo $app_set_scheduler_time_start2; ?></schedulertimestart2>
    <schedulertimeend2><?php echo $app_set_scheduler_time_end2; ?></schedulertimeend2>
    <schedulertimestart3><?php echo $app_set_scheduler_time_start3; ?></schedulertimestart3>
    <schedulertimeend3><?php echo $app_set_scheduler_time_end3; ?></schedulertimeend3>
    <schedulerintervalday><?php echo $app_set_scheduler_interval_day; ?></schedulerintervalday>    
    <setscheduler><?php echo $rtn_set_scheduler; ?></setscheduler>
</esprinkler>