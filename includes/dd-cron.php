<?php

class DDCron
{
    public static function cronjob() 
    {
        $option_name = 'ddcrontest';

        $val = get_option($option_name);

        if($val !== false)
        {
            $val = time();
            // The option already exists, so we just update it.
            update_option($option_name, $val);
        } 
        else 
        {
            // The option hasn't been added yet. We'll add it with $autoload set to 'no'.
            $deprecated = null;
            $autoload = 'no';
            add_option($option_name, '1', $deprecated, $autoload);
        }

        global $wpdb;
        $table_prefix = $wpdb->prefix;
        $dd_counters = $table_prefix.'dd_counters'; 
        
        $wpdb->insert($dd_counters,
            array(
                'name'      => 'This is test',
                'value'                 => 11125, 
                'inc_range_start'      => 111,
                'inc_range_end'     => 112,
                'timeperiod'    => 113
                ),
            array('%s', '%d', '%d', '%d', '%d')   
            ); 
    }

    public static function dd_schedules($schedules) 
    {

        if (!isset($schedules['everyfivemin']))
            $schedules['everyfivemin'] = array( 'interval' => 300, 'display' => __('Every Five Mins') );

        if (!isset($schedules['everyfifteenmin']))
            $schedules['everyfifteenmin'] = array( 'interval' => 900, 'display' => __('Every Fifteen Mins') );

        if (!isset($schedules['twicehourly']))
            $schedules['twicehourly'] = array( 'interval' => 1800, 'display' => __('Twice Hourly') );

        if (!isset($schedules['weekly']))
            $schedules['weekly'] = array( 'interval' => 604800, 'display' => __('Once Weekly') );

        if (!isset($schedules['twiceweekly']))
            $schedules['twiceweekly'] = array( 'interval' => 302400, 'display' => __('Twice Weekly') );

        if (!isset($schedules['monthly']))
            $schedules['monthly'] = array( 'interval' => 2628002, 'display' => __('Once Monthly') );

        if (!isset($schedules['twicemonthly']))
            $schedules['twicemonthly'] = array( 'interval' => 1314001, 'display' => __('Twice Monthly') );

        if (!isset($schedules['yearly']))
            $schedules['yearly'] = array( 'interval' => 31536000, 'display' => __('Once Yearly') );

        if (!isset($schedules['twiceyearly']))
            $schedules['twiceyearly'] = array( 'interval' => 15768012, 'display' => __('Twice Yearly') );

        if (!isset($schedules['fouryearly']))
            $schedules['fouryearly'] = array( 'interval' => 7884006, 'display' => __('Four Times Yearly') );

        if (!isset($schedules['sixyearly']))
            $schedules['sixyearly'] = array( 'interval' => 5256004, 'display' => __('Six Times Yearly') );

        return apply_filters('dd_schedules', $schedules);
    }
}