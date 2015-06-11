<?php

class DDCron
{
    public static function cronJobForFiveMin() 
    {
        self::dd_update_counter('everyfivemins');        
    }

    public static function cronJobForTwelveHours() 
    {
        self::dd_update_counter('everytwelvehours');        
    }

    public static function cronJobForDaily() 
    {
        self::dd_update_counter('everyday');        
    }

    public static function cronJobForThreeDays() 
    {
        self::dd_update_counter('everythreedays');        
    }

    public static function cronJobForWeek() 
    {
        self::dd_update_counter('everyweek');        
    }

    public static function cronJobForMonth() 
    {
        self::dd_update_counter('everymonth');        
    }

    public static function dd_schedules($schedules) 
    {
        // Get the defined scheduler
        $SchedulerData = ddGetCustomSchudler();

        foreach ($SchedulerData as $key => $value) 
        {
            if (!isset($schedules[$key]))
            {
                $DisplayName = ddDefineTheCustomCronEvent();
                $schedules[$key] = array( 'interval' => $value, 'display' => __($DisplayName[$key]) );
            }
        }

        return $schedules;        
    }

    public static function dd_update_counter($TimePeriod)
    {
        if(!class_exists('DDData'))
        {   
            return false;
        }

        $DBData = DDData::getCountersByTimePeriod($TimePeriod);

        if(!$DBData)
        {
            return false;
        }

        global $wpdb;

        $table_prefix = $wpdb->prefix;
        $dd_counters = $table_prefix.'dd_counters';   

        foreach ($DBData as $key => $value) 
        {
            $counterval = self::dd_calculatedValue($value);

            $wpdb->update($dd_counters,
                    array('value' => $counterval),
                    array('id' => $value->id),
                    $format = null, $where_format = null );                   
        }    

        return true;
    }

    public static function dd_calculatedValue($rowdata)
    {
        $randomizedvalue = null;

        $randomizedvalue = $rowdata->value + (rand($rowdata->inc_range_start, $rowdata->inc_range_end));

        return $randomizedvalue;
    }

    public static function getTheDDCustomCrons()
    {
      $Data = array(
                    'everyfivemins' => 'dd_fivemincronjob',
                    'everytwelvehours'  => 'dd_twelvehourscronjob',
                    'everyday'  => 'dd_dailycronjob',                
                    'everythreedays'  => 'dd_threedayscronjob',
                    'everyweek'  => 'dd_everyweekcronjob',
                    'everymonth'  => 'dd_everymonthcronjob'
                  );
      return $Data;
    }   
}