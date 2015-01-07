<?php $Data = DDData::getCounters(); ?>
<div class="wrap">
 	<h2>Data Counter</h2>
	
 	<div class="tbox">
		<div class="tbox-heading">
			<?php $createLink = 'admin.php?page=dd-create-counter'; ?>
			<a href="<?php echo wp_nonce_url($createLink, 'createLink' ); ?>">
		  		<button class="button button-primary" type="button">Create Counter</button>
		  	</a>
		  <a href="http://labs.think201.com/data-dash" target="_blank" class="pull-right">Need help?</a>
		</div>
		<div class="tbox-body">
			<table class="dash-counters">
				<tr>
					<th>Name</th>
					<th>Value</th>
					<th>Increment Start Range</th>
					<th>Increment End Range</th>
					<th>Time Period</th>
					<th>Function</th>
				</tr>
				<?php
					foreach($Data as $Counter)
					{
		  				$updateLink = 'admin.php?page=dd-update-counter&action=update&id='.$Counter->id;
		  			?>
		  				<tr>
							<td><a href="<?php echo wp_nonce_url($updateLink, 'updateLink' ); ?>"><?php echo $Counter->name; ?></a></td>
							<td><?php echo $Counter->value; ?></td>
							<td><?php echo $Counter->inc_range_start; ?></td>
							<td><?php echo $Counter->inc_range_end; ?></td>
							<td><?php echo $Counter->timeperiod; ?></td>
							<td><input type="text" value='<?php echo "getDashCounter(".$Counter->id.");"; ?>' readonly="readonly" onfocus="this.select();"></td>
						</tr>
				<?php
					}
				?>
			</table>
		</div>

		<div class="tbox-footer">
		  
		</div>
	</div>
</div>
