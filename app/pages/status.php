<?php
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
<meta http-equiv="refresh" content="15">

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Status</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div align="center"> 
        <table border="0" cellpadding="3" cellspacing="4" class="table" style="border:1px solid #CCC; width:350px;">
          <tr>
            <td colspan="3" align="center" bgcolor="#F5F5F5">Sprinkler Status</td>
          </tr>
          <tr>
            <td>Current Status</td>
            <td width="8">:</td>
            <td>OFF</td>
          </tr>
          <tr>
            <td>Sprinkler Location</td>
            <td>:</td>
            <td><?php echo get_sprinkler_location(); ?></td>
          </tr>
          <tr>
            <td>Sprinkler Mode</td>
            <td>:</td>
            <td><?php echo "Mode-".get_sprinkler_mode(); ?></td>
          </tr>
          <tr>
            <td>Sensor Reading</td>
            <td>:</td>
            <td><?php echo get_moisture_sensor_reading(); ?>&nbsp;[<?php echo moisture_sensor_reading_to_percent(get_moisture_sensor_reading());?>%]</td>
          </tr>
          <tr>
            <td>Moisture Level Set</td>
            <td>:</td>
            <td><?php echo get_moisture_level(); ?>%</td>
          </tr>
          <tr>
            <td>IntelliSense Value</td>
            <td>:</td>
            <td><?php echo get_sprinkler_intellisense_value(get_moisture_sensor_reading()); ?>%</td>
          </tr>      
          <tr>
            <td>Weather - Current</td>
            <td>:</td>
            <td><img src="<?php echo get_weather_icon(); ?>"/><br/><?php echo get_weather_info_status(); ?></td>
          </tr>
          <tr>
            <td>Weather - Rain</td>
            <td>:</td>
            <td>Current - <?php echo get_rain_current(); ?> <br/> Today - <?php echo get_rain_today(); ?> <br/> Chance of Rain : <?php echo get_rain_pop(); ?>%</td>
          </tr>
        </table>        
    </div>
    <!-- /.col-lg-6 -->
    <br style="clear:both"/><hr/><br style="clear:both"/> 
    <div align="center">                
        <table border="0" cellpadding="3" cellspacing="4" class="table" style="border:1px solid #CCC; width:350px;">
          <tr>
            <td colspan="3" align="center" bgcolor="#F5F5F5"><span class="panel-heading">RaspberryPi Status</span></td>
          </tr>
          <tr>
            <td width="166">Current Status</td>
            <td width="8">:</td>
            <td width="190" bgcolor="<?php echo $pi_status_color; ?>"><?php echo strtoupper($pi_status); ?></td>
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
            <td>IP Last Updated</td>
            <td>: </td>
            <td><?php echo $db_created_date; ?></td>
          </tr>
          <tr>
            <td>Last Ping Received</td>
            <td>:</td>
            <td><?php echo $db_updated_date; ?></td>
          </tr>
        </table>
    </div>
    <!-- /.col-lg-6 -->
    <br style="clear:both"/> 
</div>
<?php
// Clear Success Msg
$_SESSION['successMsg']="";
?>