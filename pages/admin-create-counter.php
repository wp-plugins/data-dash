<div class="wrap t201plugin">
 	<h2>
 	Create Counter
 	<a href="<?php print admin_url('admin.php?page=dd-data-counter'); ?>" class="add-new-h2">All Counters</a>
 	</h2>
	
	<div id="message" class="updated below-h2 think201-wp-msg think201-wp-success-msg">
		<p>Data dash Counter has been created</p>
	</div>
	<div id="message" class="error below-h2 think201-wp-msg think201-wp-error-msg">
		<p>Data dash Counter has been not created</p>
	</div>
 	<div class="tbox">
		<div class="tbox-heading">
		  	Add the details to create the counter.
		  	<a href="http://labs.think201.com/plugins/data-dash" target="_blank" class="pull-right">Need help?</a>
		</div>
		<div class="tbox-body">
			<form name="dd_counter_form" id="dd_counter_form" action="#" method="post">		        
		        <section>
		            <input type="hidden" name="action" value="page_create_counter">
		            <div class="twp-row">
		                <div class="twp-col-lg-12 twp-col-md-12 twp-col-sm-12 twp-col-xs-12">
		                    <div class="dd-fields-container">  
		                        <label for="name">Name:</label>
		                        <input type="text" id="name" name="name" placeholder="Enter Counter Name">
		                    </div>
		                    <div class="dd-fields-container">  
		                        <label for="value">Value:</label>
		                        <input type="text" id="value" name="value" placeholder="Enter Vaue for Counter">
		                    </div>
		                    <div class="dd-fields-container">  
		                        <label for="inc_range_start">Increment Value Range:</label>              
		                        <input type="text" id="inc_range_start" name="inc_range_start" placeholder="Enter Increment Value">
		                        <input type="text" id="inc_range_end" name="inc_range_end" placeholder="Enter Increment Value">
		                    </div>
		                    <div class="dd-fields-container">  
		                        <label for="timeperiod">Time Period: (In Minutes)</label>              
		                    		<select id="timeperiod" name="timeperiod">
		                    			<?php
		                    				$DefinedCronSchedule = ddDefineTheCustomCronEvent();
		                    				foreach ($DefinedCronSchedule as $key => $value) 
		                    				{
		                    			?>
													<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
		                    			<?php
		                    				}
		                    			?>
		                    		</select>		                    	
		                    </div>
		                </div>		                
		            </div> 
		        </section>
		        <div class="tclear"></div>
		        <button onClick="DDForm.post('#dd_counter_form')" class="button button-primary" type="button">Create Counter</button>
		    </form>

		</div>

		<div class="tbox-footer">
		  
		</div>
	</div>
</div>
