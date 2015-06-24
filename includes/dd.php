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
      add_shortcode( "dd_counter", array(DD::get_instance(), "ddCounter"));
	}

	public function ddCounter($atts)
	{
		$a = shortcode_atts( array('id'), $atts );

		return DDView::printCounter($a['id']);
	}

	public function get_ddCounter($id)
	{
		return DDView::printCounter($id);
	}
}

?>