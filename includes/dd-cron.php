<?php

class DDCron
{
    public static function cronjob() 
    {
        $option_name = 'ddcronvalue';

        $time = date( 'h:ia', time() );

        $val = get_option($option_name);

        if($val !== false)
        {            
            // The option already exists, so we just update it.
            update_option($option_name, $time);
        } 
        else 
        {
            // The option hasn't been added yet. We'll add it with $autoload set to 'no'.
            $deprecated = null;
            $autoload = 'no';
            add_option($option_name, $time, $deprecated, $autoload);
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
        if (!isset($schedules['everyfivesec']))
        {            
            $schedules['everyfivesec'] = array( 'interval' => 5, 'display' => __('Every Five Sec') );
        }

        if (!isset($schedules['everyonemin']))
        {            
            $schedules['everyonemin'] = array( 'interval' => 60, 'display' => __('Every One Mins') );
        }

        if (!isset($schedules['everyfivemins']))
        {
            $schedules['everyfivemins'] = array( 'interval' => 300, 'display' => __('Every Five Mins') );
        }
        
        return $schedules;        
    }
}