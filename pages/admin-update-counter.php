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

<div class="wrap">
 	<h2><?php echo _( 'Update Data Dash' ); ?></h2>
	
	<div id="message" class="updated below-h2 dd-msg dd-success-msg">
		<p>Data dash has been updated</p>
	</div>
	<div id="message" class="error below-h2 dd-msg dd-error-msg">
		<p>Data dash has been not updated</p>
	</div>
 	<div class="tbox">
		<div class="tbox-heading">
			<?php $counterlist = 'admin.php?page=dd-data-counter'; ?>
			<a href="<?php echo wp_nonce_url($counterlist, 'counterlist' ); ?>">
		  		<button class="button button-primary" type="button">Data Dash Counters</button>
		  	</a>
		  	<a href="http://labs.think201.com/data-dash" target="_blank" class="pull-right">Need help?</a>
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
		                    	<input type="text" id="timeperiod" name="timeperiod" placeholder="Enter Time Period" value="<?php echo $Data->timeperiod; ?>">
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
