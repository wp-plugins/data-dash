<?php
add_action( 'dd_fivemincronjob',  array('DDCron', 'cronJobForFiveMin'));
add_action( 'dd_twelvehourscronjob',  array('DDCron', 'cronJobForTwelveHours'));
add_action( 'dd_dailycronjob',  array('DDCron', 'cronJobForDaily'));
add_action( 'dd_threedayscronjob',  array('DDCron', 'cronJobForThreeDays'));
add_action( 'dd_everyweekcronjob',  array('DDCron', 'cronJobForWeek'));
add_action( 'dd_everymonthcronjob',  array('DDCron', 'cronJobForMonth'));