<?php
// Access Rights - Start
$_SESSION['pageaccesstype']="superadmin#admin#agent";
// Access Rights - End

log_activity("Set Moisture Level");

$errorMsg=""; // Clear Error Msg


$settingsEditQry="select * from settingsconfig where sc_id = 1";
$settingsEditRes=$dbObj->fireQuery($settingsEditQry);
	
if(isset($_POST['settingspostbk']) && ($_POST['settingspostbk']==1) )
{
	
	$sc_sprinkler_moisture_level=get_form_clean_values($_POST['sc_sprinkler_moisture_level']); 

	// VALIDATIONS
	
		$errorMsg .=validate_txtisset("sc_sprinkler_moisture_level","Please set the Sprinkler Moisture Level","POST");			

	// VALIDATIONS
	
	
	if(isset($errorMsg) && strlen($errorMsg)<=0) // If No Error - Start
	{		
		// Update - Start
					
			set_moisture_level($sc_sprinkler_moisture_level);
								
			$_SESSION['successMsg']="Settings Updated Successfully";
			log_activity("Settings Updated Successfully");
			header("Location: ".HOME_PAGE."?pg=set_moisture_level");
			exit;
			
		// Update - End
				
	}// If No Error - End
				
	
} // End for postback


?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Set Moisture Level</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Set Moisture Level to be maintained by Sprinkler</div>
            <div class="panel-body">
                <div class="row">
                	<div id="msgdiv">
                    <?php if(isset($errorMsg) && strlen($errorMsg)>0 ) { ?>
                    <div align="center" class="errorMsg"><strong><?php echo $errorMsg; ?></strong></div>
                    <?php } else if(isset($_SESSION['successMsg']) && strlen($_SESSION['successMsg'])>0 ) { ?>
                    <div align="center" class="successMsg"><strong><?php echo $_SESSION['successMsg']; ?></strong></div>
                    <?php } ?>
                    </div>
                    <div class="col-lg-6">
                        <form id="settingsForm" name="settingsForm" role="form" method="post" action="">
                            <div class="form-group">
                                <label>Sprinkler Mode&nbsp;:&nbsp;&nbsp;</label>
                                 <select id="sc_sprinkler_moisture_level" name="sc_sprinkler_moisture_level">
                                 	<option value="100" <?php if(isset($settingsEditRes) && ($settingsEditRes[0]['sc_sprinkler_moisture_level']=="100")){ ?>selected="selected"<?php } ?>>100%</option>
                                    <option value="80" <?php if(isset($settingsEditRes) && ($settingsEditRes[0]['sc_sprinkler_moisture_level']=="80")){ ?>selected="selected"<?php } ?>>80%</option>
                                    <option value="50" <?php if(isset($settingsEditRes) && ($settingsEditRes[0]['sc_sprinkler_moisture_level']=="50")){ ?>selected="selected"<?php } ?>>50%</option>
                                    <option value="30" <?php if(isset($settingsEditRes) && ($settingsEditRes[0]['sc_sprinkler_moisture_level']=="30")){ ?>selected="selected"<?php } ?>>30%</option>
                                 </select>
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