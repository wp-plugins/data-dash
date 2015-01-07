<?php

class DD
{
	protected static $instance = null;

    public static function get_instance() 
    {
	 	// create an object
	 	NULL === self::$instance and self::$instance = new self;

	 	return self::$instance;
	}

	public function init()
	{
		// Short codes
        add_shortcode( "datadash_counter", array($this, "ddCounter"));

  //       		global $wpdb;
		// $table_prefix = $wpdb->prefix;
		// $dd_counters = $table_prefix.'dd_counters';	
		
		// $wpdb->insert($dd_counters,
		// 			array(
		// 				'name'     	=> 'This is test',
		// 				'value' 				=> 11125, 
		// 				'inc_range_start'      => 111,
		// 				'inc_range_end'		=> 112,
		// 				'timeperiod'    => 113
		// 				),
		// 			array('%s',	'%d', '%d', '%d', '%d')   
		// 			); 

	}

	public function ddCounter()
	{

	}
}

?>