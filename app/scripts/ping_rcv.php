<?php

include_once("../lib/lib.dbConnection.php");
include_once("../config/constants.inc.php");
include_once("../lib/lib.sysFunc.php");
include_once("../lib/lib.syslog.php");


$qry="SELECT * FROM pi_track ORDER BY pt_id DESC LIMIT 1";
$res=$dbObj->fireQuery($qry,'select');

$db_ext_ip = "";
$db_int_ip = "";

if(isset($res) && count($res)>0 && $res!=false)
{
	$db_pt_id = $res[0]['pt_id'];
	$db_ext_ip = $res[0]['pt_ext_ip'];
	$db_int_ip = $res[0]['pt_int_ip'];
}


$pt_ext_ip = get_global_ip();

$pt_int_ip = "";
if(isset($_GET['local_addr']))
{
$pt_int_ip = htmlentities(base64_decode($_GET['local_addr']));
}

if($pt_int_ip !== "")
{
	if( ($pt_ext_ip === $db_ext_ip) && ($pt_int_ip === $db_int_ip))
	{
		$mysqlnow=date('Y-m-d H:i:s');
		
		$updQry="UPDATE pi_track SET "; 				
		$updQry.=" updated_date = '".$mysqlnow."' ";
		$updQry.=" WHERE pt_id='".$db_pt_id."' ";		
	
		$updRes=$dbObj->fireQuery($updQry,'insert');
		
		log_activity("Record Updated - IP:".$pt_ext_ip."-#-".$pt_int_ip);
	}
	else
	{
		$mysqlnow=date('Y-m-d H:i:s');
		
		$insQry="INSERT INTO pi_track SET "; 				
		$insQry.=" pt_ext_ip = '".$pt_ext_ip."',";	
		$insQry.=" pt_int_ip = '".$pt_int_ip."',";	
		$insQry.=" created_date = '".$mysqlnow."', ";
		$insQry.=" updated_date = '".$mysqlnow."' ";
		
		$insRes=$dbObj->fireQuery($insQry,'insert');
		
		log_activity("Record Inserted - IP:".$pt_ext_ip."-#-".$pt_int_ip);
	}
}
?>