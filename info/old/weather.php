<?php
// Access Rights - Start
$_SESSION['pageaccesstype']="superadmin#admin#agent";
// Access Rights - End

log_activity("Weather");

$errorMsg=""; // Clear Error Msg

$weatherXml = getWeatherDataXml();

echo "<pre>";
print_r($weatherXml);
exit;
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
<legend class="fieldset_custom">Location</legend>                      
<table width="400" border="0" cellpadding="3" cellspacing="4" class="table" style="border:1px solid #CCC;">
  <tr>
    <td width="144"> City</td>
    <td width="8">:</td>
    <td width="213">Richardson, TX</td>
  </tr>
  <tr>
    <td>Country</td>
    <td>:</td>
    <td><?php echo @(string)$weatherXml->city->country; ?></td>
  </tr>
  <tr>
    <td>Longitude</td>
    <td>:</td>
    <td><?php echo @(string)$weatherXml->city->coord->attributes()->lon; ?></td>
  </tr>
  <tr>
    <td>Latitude</td>
    <td>:</td>
    <td><?php echo @(string)$weatherXml->city->coord->attributes()->lat; ?></td>
  </tr>
  <tr>
    <td>Sunrise</td>
    <td>:</td>
    <td><?php echo @(string)$weatherXml->city->sun->attributes()->rise; ?></td>
  </tr>
  <tr>
    <td>Sunset</td>
    <td>:</td>
    <td><?php echo @(string)$weatherXml->city->sun->attributes()->set; ?></td>
  </tr>  
</table>
</fieldset>
<fieldset class="fieldset_custom">
<legend class="fieldset_custom">Weather</legend>                      
<table width="400" border="0" cellpadding="3" cellspacing="4" class="table" style="border:1px solid #CCC;">
  <tr>
    <td width="144">Current</td>
    <td width="8">:</td>
    <td width="213"><?php echo @(string)$weatherXml->temperature->attributes()->value; ?>&nbsp;<?php echo "'".substr(ucfirst(@(string)$weatherXml->temperature->attributes()->unit),0,1); ?></td>
  </tr>
  <tr>
    <td>Min</td>
    <td>:</td>
    <td><?php echo @(string)$weatherXml->temperature->attributes()->min; ?>&nbsp;<?php echo "'".substr(ucfirst(@(string)$weatherXml->temperature->attributes()->unit),0,1); ?></td>
  </tr>
  <tr>
    <td>Max</td>
    <td>:</td>
    <td><?php echo @(string)$weatherXml->temperature->attributes()->max; ?>&nbsp;<?php echo "'".substr(ucfirst(@(string)$weatherXml->temperature->attributes()->unit),0,1); ?></td>
  </tr>
  <tr>
    <td>Humidity</td>
    <td>:</td>
    <td><?php echo @(string)$weatherXml->humidity->attributes()->value; ?><?php echo @(string)$weatherXml->humidity->attributes()->unit; ?></td>
  </tr>
  <tr>
    <td>Pressure</td>
    <td>:</td>
    <td><?php echo @(string)$weatherXml->pressure->attributes()->value; ?>&nbsp;<?php echo @(string)$weatherXml->pressure->attributes()->unit; ?></td>
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