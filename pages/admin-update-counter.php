<?php
if(isset($_GET['action']) && isset($_GET['id']))
{
	$update_id = $_GET['id'];
	$Data = DDData::getCounter($update_id);	
}
else
{
	if(function_exists('ddRedirectTo'))
	{
		ddRedirectTo('admin.php?page=dd-data-counter');
	}	
}

?>

<div class="wrap t201plugin">
 	<h2>
 	Update Counter
 	<a href="<?php print admin_url('admin.php?page=dd-data-counter'); ?>" class="add-new-h2">All Counters</a>
 	</h2>
	
	<div id="message" class="updated below-h2 think201-wp-msg think201-wp-success-msg">
		<p>Data dash has been updated</p>
	</div>
	<div id="message" class="error below-h2 think201-wp-msg think201-wp-error-msg">
		<p>Data dash has been not updated</p>
	</div>
 	<div class="tbox">
		<div class="tbox-heading">
			Edit Counter Details
		  	<a href="http://labs.think201.com/plugins/data-dash" target="_blank" class="pull-right">Need help?</a>
		</div>
		<div class="tbox-body">
			<form name="dd_counter_update_form" id="dd_counter_update_form" action="#" method="post">		        
		        <section>
		            <input type="hidden" name="action" value="page_update_counter">
		            <input type="hidden" name="update_id" value="<?php echo $update_id; ?>">
		            <div class="twp-row">
		                <div class="twp-col-lg-12 twp-col-md-12 twp-col-sm-12 twp-col-xs-12">
		                    <div class="dd-fields-container">  
		                        <label for="name">Name:</label>
		                        <input type="text" id="name" name="name" placeholder="Enter Counter Name" value="<?php echo $Data->name; ?>">
		                    </div>
		                    <div class="dd-fields-container">  
		                        <label for="value">Value:</label>
		                        <input type="text" id="value" name="value" placeholder="Enter Vaue for Counter" value="<?php echo $Data->value; ?>">
		                    </div>
		                    <div class="dd-fields-container">  
		                        <label for="inc_range_start">Increment Start Value:</label>              
		                        <input type="text" id="inc_range_start" name="inc_range_start" placeholder="Enter Increment Value" value="<?php echo $Data->inc_range_start; ?>">
		                    </div>
		                    <div class="dd-fields-container">  
		                        <label for="inc_range_end">Increment End Value:</label>              
		                        <input type="text" id="inc_range_end" name="inc_range_end" placeholder="Enter Increment Value" value="<?php echo $Data->inc_range_end; ?>">
		                   	</div>
		                    <div class="dd-fields-container">  
		                        <label for="timeperiod">Time Period:</label>              
		                    		<select id="timeperiod" name="timeperiod">
		                    			<?php
		                    				$DefinedCronSchedule = ddDefineTheCustomCronEvent();
		                    				foreach ($DefinedCronSchedule as $key => $value) 
		                    				{
		                    			?>
													<option <?php echo ($Data->timeperiod == $key) ? 'selected="selected"' : '' ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
		                    			<?php
		                    				}
		                    			?>
		                    		</select>	
		                    </div>
		                </div>		                
		            </div> 
		        </section>
		        <div class="tclear"></div>
		        <button onClick="DDForm.post('#dd_counter_update_form')" class="button button-primary" type="button">Update Counter</button>
		    </form>

		</div>

		<div class="tbox-footer">
		  
		</div>
	</div>
</div>
