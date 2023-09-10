<?php
// Access Rights - Start
$_SESSION['pageaccesstype']="superadmin#admin#agent";
// Access Rights - End

log_activity("Weather");

$errorMsg=""; // Clear Error Msg

$weatherCurrentXml = get_weather_current_xml();
$weatherForecastXml = get_weather_forecast_xml();

?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Weather</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Current Weather Status</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                    	<div align="center">
<fieldset class="fieldset_custom">
<legend class="fieldset_custom"></legend>             
<br/>         
<table border="0" cellpadding="3" cellspacing="4" class="table" style="border:1px solid #CCC; width:400px;">
  <tr>
    <td width="144"> City</td>
    <td width="8">:</td>
    <td width="213"><?php echo $weatherCurrentXml->current_observation->display_location->full; ?></td>
  </tr>
  <tr>
    <td>Country</td>
    <td>:</td>
    <td><?php echo $weatherCurrentXml->current_observation->display_location->country; ?></td>
  </tr>
  <tr>
    <td>Latitude</td>
    <td>:</td>
    <td><?php echo $weatherCurrentXml->current_observation->display_location->latitude; ?></td>
  </tr>  
  <tr>
    <td>Longitude</td>
    <td>:</td>
    <td><?php echo $weatherCurrentXml->current_observation->display_location->longitude; ?></td>
  </tr>
  <tr>
    <td>Temperature</td>
    <td>:</td>
    <td><?php echo $weatherCurrentXml->current_observation->temperature_string; ?></td>
  </tr>
  <tr>
    <td>Feels Like Temperature</td>
    <td>:</td>
    <td><?php echo $weatherCurrentXml->current_observation->feelslike_string; ?></td>
  </tr>
  <tr>
    <td>Humidity</td>
    <td>:</td>
    <td><?php echo $weatherCurrentXml->current_observation->relative_humidity; ?></td>
  </tr>
  <tr>
    <td>Wind</td>
    <td>:</td>
    <td><?php echo $weatherCurrentXml->current_observation->wind_string; ?></td>
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
</fieldset>
                        </div>
                    </div>
                    <!-- /.col-lg-6 (nested) -->
                    
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<?php
// Clear Success Msg
$_SESSION['successMsg']="";
?>