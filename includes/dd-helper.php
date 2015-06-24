<?php 

function getDashCounter($id, $jstimeout = 60, $raw = false)
{
  if($raw)
  {
      return getDashCounterRaw($id);
  }
  
  $Counter = DDData::getCounter($id);

  if(empty($Counter))
  {
      return;
  }


  $jstimeout = $jstimeout * 60000;
	
	$Numbers = str_split(number_format($Counter->value));
  
    ?>    
    <div class="dd_counter" data-counterid="<?php echo 'dd_counter_'.$id; ?>" data-ddjstimeout="<?php echo $jstimeout; ?>">
      <h2 id="<?php echo 'dd_counter_'.$id; ?>">
        <?php

        $Length = count($Numbers);
        foreach($Numbers as $key => $number)
        {						
          if($number == ',')
          {
          ?><span class="dd_comma"><?php echo $number; ?></span><?php
          }
          else {
            ?><span class="dd_number"><?php echo $number; ?></span><?php
          }
      }	
      ?>
    </h2>
</div>
<?php
}

function ddGetNumberArrayComma($Numbers)
{
  return str_split(number_format($Numbers));
}

function getCounterNumbersDesign($Numbers)
{
  $HTML = '';
  $Numbers = str_split(number_format($Numbers));

  foreach($Numbers as $key => $number)
  {     
    if($number == ',')
    {
      $HTML .= '<span class="dd_comma">,</span>';
    }
    else 
    {
        $HTML .= '<span class="dd_number">'.$number.'</span>';
    }
  } 

  return $HTML;
}

function ddRedirectTo($url)
{
    if (headers_sent())
    {
      die('<script type="text/javascript">window.location.href="' . $url . '";</script>');
  }
  else
  {
      header('Location: ' . $url);
      die();
  }    
}

function getSingleDDOptionValue($id)
{
  $value = false;

  $DDOptions = ddGetCounterOptionVal();

  foreach($DDOptions as $key => $values)
  {
    if($values['id'] == $id)
    {
      $value = $values['value'];

      break;
    }
  }

  return $value;
}

function getDashCounterRaw($id)
{
    // Get the actual counter value
    $Counter = DDData::getCounter($id);
    
    $Numbers = array_map('intval', str_split($Counter->value));

    $i = 1; 

    $StringNumber = '';

    $Length = count($Numbers);

    foreach($Numbers as $key => $number)
    {   
        $StringNumber .= $number;                   

        if($i == 3)
        {
            if($Length - 1 != $key)
            {
                $StringNumber .= ',';
            }

            $i = 0;
        }

        $i++;
    }   

    echo $StringNumber;
}

function getTheTimePeriodName($timeperiod)
{
  $period = '';

  switch ($timeperiod) {
    case 'everyfivemins':
      $period = 'dd_fivemincronjob';
      break;

    case 'everytwelvehours':
      $period = 'dd_twelvehourscronjob';
      break;

    case 'everyday':
      $period = 'dd_dailycronjob';
      break;
    
    case 'everythreedays':
      $period = 'dd_threedayscronjob';
      break;

    case 'everyweek':
      $period = 'dd_everyweekcronjob';
      break;

    case 'everymonth':
      $period = 'dd_everymonthcronjob';
      break;

    default:
      $period = 'dd_everymonthcronjob';
      break;
  }

  return $period;
}

function ddGetCustomSchudler()
{
  $Data = array(
                'everyfivemins' => (300),
                'everytwelvehours'  => (12 * HOUR_IN_SECONDS),
                'everyday'  => (DAY_IN_SECONDS),                
                'everythreedays'  => (3 * DAY_IN_SECONDS),
                'everyweek'  => (7 * DAY_IN_SECONDS),
                'everymonth'  => (30 * DAY_IN_SECONDS)
              );

  return $Data;
}

function ddDefineTheCustomCronEvent()
{
  $Data = array(
                'everyfivemins' => 'Every Five Minutes',
                'everytwelvehours'  => 'Every Twelve Hours',
                'everyday'  => 'Every Day',                
                'everythreedays'  => 'Every Three Days',
                'everyweek'  => 'Every Week',
                'everymonth'  => 'Every Month'
              );
  return $Data;
}

function getDDTheDDCustomCrons()
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

function dd_print_tasks() 
{
  echo '<pre>'; print_r(_get_cron_array());
}

function ddCheckTheCronRegister($timeperiod)
{
  $timeperiod = getTheTimePeriodName($timeperiod);

  // get the all registered cron job
  $schedulejobs = _get_cron_array();
  
  // filter the array
  foreach ($schedulejobs as $key => $value) 
  {    
    // Check if cron is registered
    if(isset($value[$timeperiod]))
    {
      // if exist return true
      return true;
      break;
    }

    // else return false
    return false;
  }
}

?>