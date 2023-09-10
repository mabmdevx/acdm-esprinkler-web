<?php
include_once("../lib/lib.dbConnection.php");
include_once("../config/constants.inc.php");
include_once("../lib/lib.commonFunc.php");
include_once("../lib/lib.sysFunc.php");
include_once("../lib/lib.syslog.php");

$piOperationRes = get_scheduler();

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
	<schedulerstartdate><?php echo get_data($piOperationRes[0]['sc_sprinkler_scheduler_start_date']); ?></schedulerstartdate>
    <schedulertimestart1><?php echo get_data($piOperationRes[0]['sc_sprinkler_scheduler_time_start1']); ?></schedulertimestart1>
    <schedulertimeend1><?php echo get_data($piOperationRes[0]['sc_sprinkler_scheduler_time_end1']); ?></schedulertimeend1>
    <schedulertimestart2><?php echo get_data($piOperationRes[0]['sc_sprinkler_scheduler_time_start2']); ?></schedulertimestart2>
    <schedulertimeend2><?php echo get_data($piOperationRes[0]['sc_sprinkler_scheduler_time_end2']); ?></schedulertimeend2>
    <schedulertimestart3><?php echo get_data($piOperationRes[0]['sc_sprinkler_scheduler_time_start3']); ?></schedulertimestart3>
    <schedulertimeend3><?php echo get_data($piOperationRes[0]['sc_sprinkler_scheduler_time_end3']); ?></schedulertimeend3>
    <schedulerintervalday><?php echo get_data($piOperationRes[0]['sc_sprinkler_scheduler_interval_day']); ?></schedulerintervalday>
</esprinkler>