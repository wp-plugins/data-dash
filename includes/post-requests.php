<?php
namespace DataDash;	
/**
 * @package Internals
 */

// Action hook for AJAX Request
add_action('wp_ajax_page_create_counter', array('DataDash\PostData', 'createCounter'));
add_action('wp_ajax_page_update_counter', array('DataDash\PostData', 'updateCounter'));

class PostData
{
	public static function createCounter()
	{
		// Get the form data
		$Data = self::getData('create');

		// Insert data into DB
		$RetVal = self::saveData($Data);

		// Check if cron is running for timeperiod
		$Cron = self::ddCheckOrCreateCron($Data);

		if($RetVal)
		{	
			$response = array(					   					 
						'status' => true, 
					    'data' 	=> 'Success.'
					);
		}
		else
		{
			$response = array(					   					 
						'status' => false, 
					    'data' 	=> 'Failed'
					);
		}

		wp_send_json($response);
	}

	public static function updateCounter()
	{
		// Get the form data
		$Data = self::getData('update');

		// Insert data into DB
		$RetVal = self::updateData($Data);

		if($RetVal)
		{	
			$response = array(					   					 
						'status' => true, 
					    'data' 	=> 'Success.'
					);
		}
		else
		{
			$response = array(					   					 
						'status' => false, 
					    'data' 	=> 'Failed'
					);
		}

		wp_send_json($response);
	}

	public static function getData($type)
	{
		$Data = array();

		$Data['name'] 				= $_POST['name'];
		$Data['value'] 				= $_POST['value'];
		$Data['inc_range_start'] 	= $_POST['inc_range_start'];
		$Data['inc_range_end'] 		= $_POST['inc_range_end'];
		$Data['timeperiod'] 		= $_POST['timeperiod'];
		if($type == 'update')
		{
			$Data['update_id']          = $_POST['update_id'];
		}		

		return $Data;
	}

	public static function saveData($Data)
	{
		global $wpdb;

		$table_prefix = $wpdb->prefix;
		$dd_counters = $table_prefix.'dd_counters';	
		
		$wpdb->insert($dd_counters,
					array(
						'name'     			=> $Data['name'],
						'value' 			=> $Data['value'],
						'inc_range_start'   => $Data['inc_range_start'],
						'inc_range_end'		=> $Data['inc_range_end'],
						'timeperiod'    	=> $Data['timeperiod'],
						'status'    		=> 'active'
						),
					array('%s',	'%d', '%d', '%d', '%s', '%s')   
					); 

		return true;
	}

	public static function updateData($Data)
	{
		global $wpdb;

		$table_prefix = $wpdb->prefix;
		$dd_counters = $table_prefix.'dd_counters';			

		$wpdb->update($dd_counters,
					array(
						'name'     			=> $Data['name'],
						'value' 			=> $Data['value'],
						'inc_range_start'   => $Data['inc_range_start'],
						'inc_range_end'		=> $Data['inc_range_end'],
						'timeperiod'    	=> $Data['timeperiod'],
						'status'    		=> 'active'
						),
					array(
						'id'      	=> $Data['update_id']
						),
					$format = null, $where_format = null );		

		return true;
	}

	public static function ddCheckOrCreateCron($Data)
	{
		// get the name from cron job
		$cronname = getTheTimePeriodName($Data['timeperiod']);

		// Check if cron exist for current timeperiod
		if( !wp_next_scheduled( $cronname ) ) 
		{
			$Timestamp = ddGetCustomSchudler();

			wp_schedule_event( $Timestamp[$Data['timeperiod']], $Data['timeperiod'], $cronname );
		}	

		return true;
	}
}
?>