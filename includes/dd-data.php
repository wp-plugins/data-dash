<?php
/**
 * @package Internals
 */

class DDData
{
	public static function getCounters()
	{
		global $wpdb;		
		$dd_counters = $wpdb->prefix.'dd_counters';	

		$active = 'active';
		
		$QueryforData = $wpdb->prepare( "SELECT * FROM $dd_counters WHERE status = %s", $active);
		$Data = $wpdb->get_results($QueryforData);

		return $Data;
	}

	public static function getCountersByTimePeriod($TimePeriod)
	{
		global $wpdb;		
		$dd_counters = $wpdb->prefix.'dd_counters';	

		$active = 'active';

		$Query = $wpdb->prepare( "SELECT * FROM $dd_counters WHERE timeperiod = %s AND status = %s", $TimePeriod, $active);	
		$Data = $wpdb->get_results($Query);

		return $Data;
	}

	public static function getCounter($id)
	{
		global $wpdb;		
		$dd_counters = $wpdb->prefix.'dd_counters';	

		$active = 'active';

		$Query = $wpdb->prepare( "SELECT * FROM $dd_counters WHERE id = %d AND status = %s", $id, $active);	
		$Data = $wpdb->get_row($Query);

		return $Data;
	}
}
?>