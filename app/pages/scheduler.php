<?php
// Access Rights - Start
$_SESSION['pageaccesstype']="superadmin#admin#agent";
// Access Rights - End

log_activity("Scheduler");

$errorMsg=""; // Clear Error Msg

$settingsEditQry="select * from settingsconfig where sc_id = 1";
$settingsEditRes=$dbObj->fireQuery($settingsEditQry);
	
if(isset($_POST['postbk']) && ($_POST['postbk']==1) )
{
	$scheduler_start_date=date("Y-m-d",strtotime(get_form_clean_values($_POST['scheduler_start_date']))); 
	$scheduler_time_start1=get_form_clean_values($_POST['scheduler_time_start1']);
	$scheduler_time_end1=get_form_clean_values($_POST['scheduler_time_end1']);
	$scheduler_time_start2=get_form_clean_values($_POST['scheduler_time_start2']);
	$scheduler_time_end2=get_form_clean_values($_POST['scheduler_time_end2']);
	$scheduler_time_start3=get_form_clean_values($_POST['scheduler_time_start3']);
	$scheduler_time_end3=get_form_clean_values($_POST['scheduler_time_end3']);
	$scheduler_interval_day=get_form_clean_values($_POST['scheduler_interval_day']);
	
	// VALIDATIONS
		
		$errorMsg .=validate_txtisset("scheduler_start_date","Please set the Date for Scheduler","POST");	
		$errorMsg .=validate_txtisset("scheduler_time_start1","Please set Start Time-1 for Scheduler","POST");	
		$errorMsg .=validate_txtisset("scheduler_time_end1","Please set End Time-1 for Scheduler","POST");	
		$errorMsg .=validate_txtisset("scheduler_interval_day","Please set the Scheduler Interval for Scheduler","POST");

	// VALIDATIONS

	if(isset($errorMsg) && strlen($errorMsg)<=0) // If No Error - Start
	{		
	
		
		scheduler_db($scheduler_start_date,$scheduler_time_start1,$scheduler_time_end1,$scheduler_time_start2,$scheduler_time_end2,$scheduler_time_start3,$scheduler_time_end3,$scheduler_interval_day);
		
		$_SESSION['successMsg']="Scheduler Information Saved Successfully";
		log_activity("Scheduler Information Saved Successfully");
		header("Location: ".HOME_PAGE."?pg=scheduler");
		exit;

				
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
                        <?php if(get_sprinkler_mode()==2){ ?>
                        <form id="schedulerForm" name="schedulerForm" method="post" action="">
                          <input name="postbk" type="hidden" id="postbk" value="1" />
                            <div class="form-group">
                            <br/>
                              <table border="0" cellpadding="2" cellspacing="3" class="table" style="width:300px;">
                                <tr>
                                  <td width="93">Start Day : </td>
                                  <td width="144"><span><span class="input-group date">
    <input id="scheduler_start_date" name="scheduler_start_date" type="text" class="form-control" value="<?php $fieldval=false; if(isset($settingsEditRes)){ $fieldval=date("m/d/Y",strtotime($settingsEditRes[0]['sc_sprinkler_scheduler_start_date'])); } echo form_submit_update_textbox("scheduler_start_date",$fieldval,"POST"); ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
    </span></span>
                                    </td>
                                  <td width="39"><img src="images/delete.png" onclick="clear_txtbox('scheduler_start_date');" style="cursor:pointer"/></td>
                                </tr>
                                <tr>
                                  <td>Start Time-1 :</td>
                                  <td colspan="2"><input id="scheduler_time_start1" name="scheduler_time_start1" style="width:100px;" type="text" class="time ui-timepicker-input" autocomplete="off" value="<?php $fieldval=false; if(isset($settingsEditRes)){ $fieldval=get_data($settingsEditRes[0]['sc_sprinkler_scheduler_time_start1']); } echo form_submit_update_textbox("scheduler_time_start1",$fieldval,"POST"); ?>" />&nbsp;<img src="images/delete.png" onclick="clear_txtbox('scheduler_time_start1');" style="cursor:pointer"/></td>
                                </tr>
                                <tr>
                                  <td>End Time-1 :</td>
                                  <td colspan="2"><input id="scheduler_time_end1" name="scheduler_time_end1" style="width:100px;" type="text" class="time ui-timepicker-input" autocomplete="off" value="<?php $fieldval=false; if(isset($settingsEditRes)){ $fieldval=get_data($settingsEditRes[0]['sc_sprinkler_scheduler_time_end1']); } echo form_submit_update_textbox("scheduler_time_end1",$fieldval,"POST"); ?>" />&nbsp;<img src="images/delete.png" onclick="clear_txtbox('scheduler_time_end1');" style="cursor:pointer"/></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>Start Time-2 :</td>
                                  <td colspan="2"><input id="scheduler_time_start2" name="scheduler_time_start2" style="width:100px;" type="text" class="time ui-timepicker-input" autocomplete="off" value="<?php $fieldval=false; if(isset($settingsEditRes)){ $fieldval=get_data($settingsEditRes[0]['sc_sprinkler_scheduler_time_start2']); } echo form_submit_update_textbox("scheduler_time_start2",$fieldval,"POST"); ?>" />&nbsp;<img src="images/delete.png" onclick="clear_txtbox('scheduler_time_start2');" style="cursor:pointer"/></td>
                                </tr>
                                <tr>
                                  <td>End Time-2 :</td>
                                  <td colspan="2"><input id="scheduler_time_end2" name="scheduler_time_end2" style="width:100px;" type="text" class="time ui-timepicker-input" autocomplete="off" value="<?php $fieldval=false; if(isset($settingsEditRes)){ $fieldval=get_data($settingsEditRes[0]['sc_sprinkler_scheduler_time_end2']); } echo form_submit_update_textbox("scheduler_time_end2",$fieldval,"POST"); ?>" />&nbsp;<img src="images/delete.png" onclick="clear_txtbox('scheduler_time_end2');" style="cursor:pointer"/></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>Start Time-3 :</td>
                                  <td colspan="2"><input id="scheduler_time_start3" name="scheduler_time_start3" style="width:100px;" type="text" class="time ui-timepicker-input" autocomplete="off" value="<?php $fieldval=false; if(isset($settingsEditRes)){ $fieldval=get_data($settingsEditRes[0]['sc_sprinkler_scheduler_time_start3']); } echo form_submit_update_textbox("scheduler_time_start3",$fieldval,"POST"); ?>" />&nbsp;<img src="images/delete.png" onclick="clear_txtbox('scheduler_time_start3');" style="cursor:pointer"/></td>
                                </tr>
                                <tr>
                                  <td>End Time-3 :</td>
                                  <td colspan="2"><input id="scheduler_time_end3" name="scheduler_time_end3" style="width:100px;" type="text" class="time ui-timepicker-input" autocomplete="off" value="<?php $fieldval=false; if(isset($settingsEditRes)){ $fieldval=get_data($settingsEditRes[0]['sc_sprinkler_scheduler_time_end3']); } echo form_submit_update_textbox("scheduler_time_end3",$fieldval,"POST"); ?>" />&nbsp;<img src="images/delete.png" onclick="clear_txtbox('scheduler_time_end3');" style="cursor:pointer"/></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>Interval : </td>
                                  <td colspan="2"><select id="scheduler_interval_day" name="scheduler_interval_day">
                                   <?php 
								   for($s=0;$s<=15;$s++)
								   {
								   ?>
                                    <option value="<?php echo $s; ?>" <?php if(isset($settingsEditRes) && ($settingsEditRes[0]['sc_sprinkler_scheduler_interval_day']==$s)){ ?>selected="selected"<?php } ?>><?php echo $s; ?></option>
                                   <?php
								   }
								   ?>
                                  </select> 
                                  Days</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2">&nbsp;</td>
                                </tr>
                              </table>
                          </div> 
                            <br/>
                          <input name="btnsubmit" class="btn btn-success" type="submit" value="Save"/>  
                        </form>
                        <?php }else{ ?>
                        <p style="color:#C96">
                        <strong>
                        Sprinkler has to be in<br/>
                        <span style="color:#666">Mode-2 : Auto - Scheduler</span><br/>
                        for Scheduler Mode
                        </strong>
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
	    $('.input-group.date').datepicker({
    });
</script> 

<?php
// Clear Success Msg
$_SESSION['successMsg']="";
?>