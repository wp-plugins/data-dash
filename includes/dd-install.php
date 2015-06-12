<?php
	
class DD_Install
{
	//Function to Setup DB Tables
	public static function activate()
	{
		global $wpdb;
		$dd_counters = $wpdb->prefix.'dd_counters';

		$dd_counter_table = "CREATE TABLE IF NOT EXISTS $dd_counters(
		id INT(9) UNSIGNED NOT NULL AUTO_INCREMENT,
		name VARCHAR(300) NOT NULL,	
		value BIGINT UNSIGNED NOT NULL,
		inc_range_start INT NOT NULL,
		inc_range_end INT NOT NULL,
		timeperiod VARCHAR(255) NOT NULL,
		status VARCHAR(10) NOT NULL,
		Primary Key id (id)
		)ENGINE=InnoDB DEFAULT CHARSET=utf8;";

		$wpdb->query($dd_counter_table);		
	}

	public static function deactivate()
	{
		return true;
	}

	public static function delete()
	{
		global $wpdb;		
		$dd_counters = $wpdb->prefix.'dd_counters';

		$dd_counter_table = "DROP TABLE $dd_counters;";
		$wpdb->query($dd_counter_table);

		wp_clear_scheduled_hook( 'dd_fivemincronjob' );
		wp_clear_scheduled_hook( 'dd_twelvehourscronjob' );
		wp_clear_scheduled_hook( 'dd_dailycronjob' );
		wp_clear_scheduled_hook( 'dd_threedayscronjob' );
		wp_clear_scheduled_hook( 'dd_everyweekcronjob' );
		wp_clear_scheduled_hook( 'dd_everymonthcronjob' );

		return true;
	}
}

?>