<?php
	
class DD_Install
{
	//Function to Setup DB Tables
	public static function activate()
	{		
		global $wpdb;
		$dd_counters = $$wpdb->prefix.'dd_counters';

		$dd_counter_table = "CREATE TABLE IF NOT EXISTS $dd_counters(
		id INT(9) UNSIGNED NOT NULL AUTO_INCREMENT,
		name VARCHAR(300) NOT NULL,
		value BIGINT UNSIGNED NOT NULL,
		inc_range_start INT NOT NULL,
		inc_range_end INT NOT NULL,
		timeperiod INT NOT NULL,
		status VARCHAR(10) NOT NULL,
		Primary Key id (id)
		)ENGINE=InnoDB DEFAULT CHARSET=utf8;";

		$wpdb->query($dd_counter_table);		

		wp_schedule_event( time(), 'everyfivesec', 'ddcronjob' );
	}

	public static function deactivate()
	{
		wp_clear_scheduled_hook('ddcronjob');

		return true;
	}

	public static function delete()
	{
		global $wpdb;
		$table_prefix = $wpdb->prefix;
		$dd_counters = $table_prefix.'dd_counters';

		$dd_counter_table = "DROP TABLE $dd_counters;";
		$wpdb->query($git_contact_form_data);
	}
}

?>