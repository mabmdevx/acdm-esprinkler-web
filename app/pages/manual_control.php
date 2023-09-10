<?php
// Access Rights - Start
$_SESSION['pageaccesstype']="superadmin#admin#agent";
// Access Rights - End

log_activity("Set Mode");

$errorMsg=""; // Clear Error Msg


	
if(isset($_POST['postbk']) && ($_POST['postbk']==1) )
{
	

	if(isset($errorMsg) && strlen($errorMsg)<=0) // If No Error - Start
	{		
	
		
		if(isset($_POST['btnx_on']))
		{
			rpi_turn_on_manual_db();
			
			//$_SESSION['successMsg']="Sprinkler Turned ON";
			log_activity("Sprinkler Turned ON");
			header("Location: ".HOME_PAGE."?pg=manual_control");
			exit;
		}
		
		if(isset($_POST['btnx_off']))
		{
			rpi_turn_off_manual_db();
			 
			//$_SESSION['successMsg']="Sprinkler Turned OFF";
			log_activity("Sprinkler Turned OFF");
			header("Location: ".HOME_PAGE."?pg=manual_control");
			exit;
		}

								
			

				
	}// If No Error - End
				
	
} // End for postback


?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Manual Control</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Control Sprinkler Manually
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                    	<div align="center">
                        <?php if(get_sprinkler_mode()==1){ ?>
                        <form id="manualControlForm" name="manualControlForm" method="post" action="">
                            <p><strong>Current Sprinkler Status : <?php echo strtoupper(get_sprinkler_manual_operation()); ?></strong></p>
                          	<?php if(get_sprinkler_manual_operation()=="off"){ ?>
                            <button name="btnx_on" class="btn btn-success btn-lg" style="width:140px;">TURN ON</button>
                            <?php }else{ ?>
                            <button name="btnx_off" class="btn btn-danger btn-lg" style="width:140px;">TURN OFF</button>
                            <?php } ?>
                            <input name="postbk" type="hidden" id="postbk" value="1" />
                        </form>
                        <?php }else{ ?>
                        <p style="color:#C96"><strong>Sprinkler has to be in <br/>
                        <span style="color:#666">Mode-1 : Manual</span><br/>
                        for Manual Control</strong></p>
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
<?php
// Clear Success Msg
$_SESSION['successMsg']="";
?>