<?php
// Access Rights - Start
$_SESSION['pageaccesstype']="superadmin#admin#agent";
// Access Rights - End

log_activity("Set Mode");

$errorMsg=""; // Clear Error Msg


$settingsEditQry="select * from settingsconfig where sc_id = 1";
$settingsEditRes=$dbObj->fireQuery($settingsEditQry);
	
if(isset($_POST['settingspostbk']) && ($_POST['settingspostbk']==1) )
{
	
	$sc_sprinkler_mode=get_form_clean_values($_POST['sc_sprinkler_mode']); 

	// VALIDATIONS
	
		$errorMsg .=validate_txtisset("sc_sprinkler_mode","Please set the Sprinkler Mode","POST");			

	// VALIDATIONS
	
	
	if(isset($errorMsg) && strlen($errorMsg)<=0) // If No Error - Start
	{		
		// Update - Start
					
			set_mode($sc_sprinkler_mode);
								
			$_SESSION['successMsg']="Settings Updated Successfully";
			log_activity("Settings Updated Successfully");
			header("Location: ".HOME_PAGE."?pg=set_mode");
			exit;
			
		// Update - End
				
	}// If No Error - End
				
	
} // End for postback


?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Set Mode</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Set Mode for Sprinkler Operation
            </div>
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
                                <br/>
                                <label class="radio-inline">
                                <input id="sc_sprinkler_mode1" name="sc_sprinkler_mode" type="radio" value="1" <?php if(isset($settingsEditRes) && ($settingsEditRes[0]['sc_sprinkler_mode']=="1")){ ?>checked="checked"<?php } ?>>Mode-1 : Manual
                                </label>
                                <br/>
                                <label class="radio-inline">
                                <input id="sc_sprinkler_mode2" name="sc_sprinkler_mode" type="radio" value="2" <?php if(isset($settingsEditRes) && ($settingsEditRes[0]['sc_sprinkler_mode']=="2")){ ?>checked="checked"<?php } ?>>Mode-2 : Auto - Scheduler
                                </label>
                                <br/>
                                <label class="radio-inline">
                                <input id="sc_sprinkler_mode3" name="sc_sprinkler_mode" type="radio" value="3" <?php if(isset($settingsEditRes) && ($settingsEditRes[0]['sc_sprinkler_mode']=="3")){ ?>checked="checked"<?php } ?>>Mode-3 : Auto - IntelliSense
                                </label>
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