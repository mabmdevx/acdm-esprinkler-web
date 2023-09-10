<?php
// Access Rights - Start
$_SESSION['pageaccesstype']="superadmin#admin#agent";
// Access Rights - End

log_activity("Set Mode");

$errorMsg=""; // Clear Error Msg

$settingsEditQry="select * from settingsconfig where sc_id = 1";
$settingsEditRes=$dbObj->fireQuery($settingsEditQry);
	
if(isset($_POST['postbk']) && ($_POST['postbk']==1) )
{
	$scheduler_type=get_form_clean_values($_POST['scheduler_type']);
	$scheduler_day=get_form_clean_values($_POST['scheduler_day']); 
	$scheduler_time=get_form_clean_values($_POST['scheduler_time']);
	$scheduler_duration=get_form_clean_values($_POST['scheduler_duration']);
	
	// VALIDATIONS
		
		if($scheduler_type=="weekly")
		{
			$errorMsg .=validate_txtisset("scheduler_day","Please set the Day for Scheduler","POST");
		}
	
		$errorMsg .=validate_txtisset("scheduler_time","Please set the Time for Scheduler","POST");			

	// VALIDATIONS

	if(isset($errorMsg) && strlen($errorMsg)<=0) // If No Error - Start
	{		
	
		
		if(isset($_POST['postbk']))
		{
			scheduler_db($scheduler_type,$scheduler_day,$scheduler_time,$scheduler_duration);
			
			$_SESSION['successMsg']="Scheduler Information Saved Successfully";
			log_activity("Scheduler Information Saved Successfully");
			header("Location: ".HOME_PAGE."?pg=scheduler");
			exit;
		}
		
									

				
	}// If No Error - End
				
	
} // End for postback


?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Scheduler</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Schedule Sprinkler Operation
            </div>
            <div class="panel-body">
                <div class="row">
                	<div id="msgdiv" style="height:30px;">
                    <p>
                    <?php if(isset($errorMsg) && strlen($errorMsg)>0 ) { ?>
                    <div align="center" class="errorMsg"><strong><?php echo $errorMsg; ?></strong></div>
                    <?php } else if(isset($_SESSION['successMsg']) && strlen($_SESSION['successMsg'])>0 ) { ?>
                    <div align="center" class="successMsg"><strong><?php echo $_SESSION['successMsg']; ?></strong></div>
                    <?php } ?>
                    </p>
                    </div>
                    <div class="col-lg-12">
                    	<div align="center">
                        <?php if(get_sprinkler_mode()==2 || get_sprinkler_mode()==3){ ?>
                        <form id="schedulerForm" name="schedulerForm" method="post" action="">
                          <input name="postbk" type="hidden" id="postbk" value="1" />
                            <div class="form-group">
                              <table class="table" border="0" cellpadding="2" cellspacing="3" style="width:300px;">
                                <tr>
                                  <td colspan="2">
                                  <div align="center">
                                  <input id="scheduler_type_weekly" name="scheduler_type" type="radio" value="weekly" onclick="check_scheduler_type();"  <?php if(isset($settingsEditRes) && ($settingsEditRes[0]['sc_sprinkler_scheduler_type']=="weekly")){ ?>checked="checked"<?php } ?>/>
                                    &nbsp;Weekly&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input id="scheduler_type_daily"  name="scheduler_type" type="radio" value="daily" onclick="check_scheduler_type();"  <?php if(isset($settingsEditRes) && ($settingsEditRes[0]['sc_sprinkler_scheduler_type']=="daily")){ ?>checked="checked"<?php } ?> />
                                  &nbsp;Daily
                                  </div>
                                  </td>
                                </tr>
                                <tr id="schedule_day_row">
                                  <td width="80">Day : </td>
                                  <td width="220"><select id="scheduler_day" name="scheduler_day">
                                    <option value="0" <?php if(isset($settingsEditRes) && ($settingsEditRes[0]['sc_sprinkler_scheduler_day']=="0")){ ?>selected="selected"<?php } ?>>Sunday</option>
                                    <option value="1" <?php if(isset($settingsEditRes) && ($settingsEditRes[0]['sc_sprinkler_scheduler_day']=="1")){ ?>selected="selected"<?php } ?>>Monday</option>
                                    <option value="2" <?php if(isset($settingsEditRes) && ($settingsEditRes[0]['sc_sprinkler_scheduler_day']=="2")){ ?>selected="selected"<?php } ?>>Tuesday</option>
                                    <option value="3" <?php if(isset($settingsEditRes) && ($settingsEditRes[0]['sc_sprinkler_scheduler_day']=="3")){ ?>selected="selected"<?php } ?>>Wednesday</option>
                                    <option value="4" <?php if(isset($settingsEditRes) && ($settingsEditRes[0]['sc_sprinkler_scheduler_day']=="4")){ ?>selected="selected"<?php } ?>>Thursday</option>
                                    <option value="5" <?php if(isset($settingsEditRes) && ($settingsEditRes[0]['sc_sprinkler_scheduler_day']=="5")){ ?>selected="selected"<?php } ?>>Friday</option>
                                    <option value="6" <?php if(isset($settingsEditRes) && ($settingsEditRes[0]['sc_sprinkler_scheduler_day']=="6")){ ?>selected="selected"<?php } ?>>Saturday</option>
                                  </select></td>
                                </tr>
                                <tr>
                                  <td>Time :</td>
                                  <td><input id="scheduler_time" name="scheduler_time" type="text" class="time ui-timepicker-input" autocomplete="off" value="<?php $fieldval=false; if(isset($settingsEditRes)){ $fieldval=get_data($settingsEditRes[0]['sc_sprinkler_scheduler_time']); } echo form_submit_update_textbox("sc_sprinkler_scheduler_time",$fieldval,"POST"); ?>" /></td>
                                </tr>
                                <tr>
                                  <td>Duration :</td>
                                  <td><input id="scheduler_duration" name="scheduler_duration" type="text" value="<?php $fieldval=false; if(isset($settingsEditRes)){ $fieldval=get_data($settingsEditRes[0]['sc_sprinkler_scheduler_duration']); } echo form_submit_update_textbox("sc_sprinkler_scheduler_duration",$fieldval,"POST"); ?>"  style="width:40px;" /> Minutes</td>
                                </tr>
                              </table>
                          </div> 
                            <br/>
                          <input name="btnsubmit" class="btn btn-success" type="submit" value="Save"/>  
                        </form>
                        <?php }else{ ?>
                        <p style="color:#C96">
                        <strong>Sprinkler has to be in <br/>
                        <span style="color:#666">Mode-2 : Auto - Scheduler</span><br/>or<br/>
                        <span style="color:#666">Mode-3 : Auto - Scheduler with IntelliSense</span><br/>
                        for Scheduler Mode</strong>
                        </p>
                        <?php } ?>
                        </div>
                    </div>
                    <!-- /.col-lg-6 (nested) -->
                    <p>&nbsp;</p>
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<script type="text/javascript">
function check_scheduler_type()
{
	if(document.getElementById('scheduler_type_daily').checked==true)
	{
		document.getElementById("schedule_day_row").style.display="none";
	}
	else
	{
		document.getElementById("schedule_day_row").style.display="";
	}
}
check_scheduler_type();
</script>
<?php
// Clear Success Msg
$_SESSION['successMsg']="";
?>