<?php
/*
Plugin Name: Data Dash
Plugin URI: http://labs.think201.com/plugins/data-dash
Description: Data dash allows you to create dynamic counters for your website pages.
Author: Think201
Version: 1.2
Author URI: http://www.think201.com
License: GPL v1

Data Dash Plugin
Copyright (C) 2015, Think201 - think201.com@gmail.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.
See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

//strat session
if (session_id() == '') {
	session_start();
}

if ( !defined( 'DB_NAME' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	die;
}

if(version_compare(PHP_VERSION, '5.2', '<' )) 
{
	if (is_admin() && (!defined( 'DOING_AJAX' ) || !DOING_AJAX )) 
	{
		require_once(ABSPATH . 'wp-admin/includes/plugin.php');
		deactivate_plugins( __FILE__ );
		wp_die( sprintf( __( 'Data Dash requires PHP 5.2 or higher, as does WordPress 3.2 and higher. The plugin has now disabled itself.', 'Data Dash' ), '<a href="http://wordpress.org/">', '</a>' ));
	} 
	else 
	{
		return;
	}
}

if ( !defined( 'DD_PATH' ) )
define( 'DD_PATH', plugin_dir_path( __FILE__ ) );

if ( !defined( 'DD_BASENAME' ) )
define( 'DD_BASENAME', plugin_basename( __FILE__ ) );

if ( !defined( 'DD_VERSION' ) )
define('DD_VERSION', '1.2.1' );

if ( !defined( 'DD_PLUGIN_DIR' ) )
define('DD_PLUGIN_DIR', dirname(__FILE__) );

if ( ! defined( 'DD_LOAD_JS' ) )
define( 'DD_LOAD_JS', true );

if ( ! defined( 'DD_LOAD_CSS' ) )
define( 'DD_LOAD_CSS', true );	

if ( ! defined( 'DD_ONE_MIN_CRON' ) )
define( 'DD_ONE_MIN_CRON', 'everyonemin' );

if ( ! defined( 'DD_FIVE_MIN_CRON' ) )
define( 'DD_FIVE_MIN_CRON', 'everyfivemins' );

require_once DD_PLUGIN_DIR .'/includes/dd-cron.php';
require_once DD_PLUGIN_DIR .'/includes/dd-install.php';

require_once DD_PLUGIN_DIR .'/includes/dd-admin.php';
require_once DD_PLUGIN_DIR .'/includes/dd.php';

register_activation_hook( __FILE__, array('DD_Install', 'activate') );
register_deactivation_hook( __FILE__, array('DD_Install', 'deactivate') );
register_uninstall_hook(__FILE__, array('DD_Install', 'delete') );

add_action( 'plugins_loaded', 'ddStart');

// Register the action hook and schedule for cron to trigger
require_once DD_PLUGIN_DIR .'/includes/dd-registercron.php';

// Add filter for multiple scheduling events
add_filter('cron_schedules', array('DDCron', 'dd_schedules'));

function ddStart()
{
	$initObj = DDAdmin::get_instance();
	$initObj->init();

	$ddObj = DD::get_instance();
	$ddObj->init();
}
?>