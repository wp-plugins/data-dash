<?php
$Data = DDData::getCounters(); 
$wp_list_table = new dd\DDListTable();

?>
<div class="wrap t201plugin">
 	<h2>
 	Data Counter
 	<a href="<?php print admin_url('admin.php?page=dd-create-counter'); ?>" class="add-new-h2">Add New</a>
 	</h2>

	<?php
		$wp_list_table->display();
	?>
</div>