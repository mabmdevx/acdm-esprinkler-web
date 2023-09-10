<?php
// Access Rights - Start
$_SESSION['pageaccesstype']="superadmin#admin#agent";
// Access Rights - End

log_activity("Set Location");

$errorMsg=""; // Clear Error Msg


$settingsEditQry="select * from settingsconfig where sc_id = 1";
$settingsEditRes=$dbObj->fireQuery($settingsEditQry);
	
if(isset($_POST['settingspostbk']) && ($_POST['settingspostbk']==1) )
{
	
	$sc_sprinkler_location_city=get_form_clean_values($_POST['sc_sprinkler_location_city']); 
	$sc_sprinkler_location_state=get_form_clean_values($_POST['sc_sprinkler_location_state']); 


	// VALIDATIONS
	
		$errorMsg .=validate_txtisset("sc_sprinkler_location_city","Please provide the Location City of Sprinkler","POST");	
		$errorMsg .=validate_txtisset("sc_sprinkler_location_state","Please provide the Location State of Sprinkler","POST");			

	// VALIDATIONS
	
	
	if(isset($errorMsg) && strlen($errorMsg)<=0) // If No Error - Start
	{		
		// Update - Start
					
			set_location($sc_sprinkler_location_city,$sc_sprinkler_location_state);
								
			$_SESSION['successMsg']="Settings Updated Successfully";
			log_activity("Settings Updated Successfully");
			header("Location: ".HOME_PAGE."?pg=set_location");
			exit;
			
		// Update - End
				
	}// If No Error - End
				
	
} // End for postback


?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Set Location</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Configure Location of Sprinkler for Weather Information
            </div>
            <div class="panel-body">
                <div class="row">
                	<div id="msgdiv">
                    <p>
                    <?php if(isset($errorMsg) && strlen($errorMsg)>0 ) { ?>
                    <div align="center" class="errorMsg"><strong><?php echo $errorMsg; ?></strong></div>
                    <?php } else if(isset($_SESSION['successMsg']) && strlen($_SESSION['successMsg'])>0 ) { ?>
                    <div align="center" class="successMsg"><strong><?php echo $_SESSION['successMsg']; ?></strong></div>
                    <?php } ?>
                    </p>
                    </div>
                    <div class="col-lg-6">
                        <form id="settingsForm" name="settingsForm" role="form" method="post" action="">
                            <div class="form-group">
                                <label>Sprinkler Location City:</label>
                                <input id="sc_sprinkler_location_city" name="sc_sprinkler_location_city"  type="text" class="form-control" value="<?php $fieldval=false; if(isset($settingsEditRes)){ $fieldval=get_data($settingsEditRes[0]['sc_sprinkler_location_city']); } echo form_submit_update_textbox("sc_sprinkler_location_city",$fieldval,"POST"); ?>"/>
                            </div>
                            <div class="form-group">    
                                <label>Sprinkler Location State:</label>
                                <input id="sc_sprinkler_location_state" name="sc_sprinkler_location_state"  type="text" class="form-control" value="<?php $fieldval=false; if(isset($settingsEditRes)){ $fieldval=get_data($settingsEditRes[0]['sc_sprinkler_location_state']); } echo form_submit_update_textbox("sc_sprinkler_location_state",$fieldval,"POST"); ?>"/>
                            </div>
                            <input name="settingspostbk" type="hidden" id="settingspostbk" value="1" />
                            <button type="submit" class="btn btn-default">Save</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                        </form>
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