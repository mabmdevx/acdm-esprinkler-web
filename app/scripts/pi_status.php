<?php

include_once("../lib/lib.dbConnection.php");
include_once("../config/constants.inc.php");
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

?>
<html>
<head>
<title><?php echo SITE_NAME; ?> - RaspberryPi Status</title>
<meta http-equiv="refresh" content="15">
</head>
<body>
<div align="center" style="font-size:14px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; margin-top:40px;">
<table width="300" border="0" cellpadding="3" cellspacing="4" style="border:1px solid #CCC;">
  <tr>
    <td colspan="3" align="center" bgcolor="#EAB06E"><?php echo SITE_NAME; ?></td>
    </tr>
  <tr>
    <td colspan="3" align="center" bgcolor="#9999CC" style="color:#FFF">RaspberryPi Status</td>
  </tr>
  <tr>
    <td width="115">Pi Status</td>
    <td width="5">:</td>
    <td width="180" bgcolor="<?php echo $pi_status_color; ?>"><?php echo strtoupper($pi_status); ?></td>
  </tr>
  <tr>
    <td>Pi External IP</td>
    <td>:</td>
    <td><?php echo $db_ext_ip; ?></td>
  </tr>
  <tr>
    <td>Pi Internal IP</td>
    <td>:</td>
    <td><?php echo $db_int_ip; ?></td>
  </tr>
  <tr>
    <td>Created Date</td>
    <td>: </td>
    <td><?php echo $db_created_date; ?></td>
  </tr>
  <tr>
    <td>Updated Date</td>
    <td>:</td>
    <td><?php echo $db_updated_date; ?></td>
  </tr>
</table>
</div>
</body>
</html>