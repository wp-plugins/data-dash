<?php 

function getDashCounter($id, $raw = false)
{
    if($raw)
    {
        return getDashCounterRaw($id);
    }

	$Counter = DDData::getCounter($id);
	$Numbers = array_map('intval', str_split($Counter->value));
	$i = 1;	
    ?>
    <div class="numbers">
      <div class="counter">
          <?php

          $Length = count($Numbers);
          foreach($Numbers as $key => $number)
          {						
              ?>
              <span class="number"><?php echo $number; ?></span> 			
              <?php 
              if($i == 3)
              {
                if($Length - 1 != $key)
                {
                    ?>
                    <span class="comma">,</span>
                    <?php
                }
                $i = 0;
            }
            $i++;
        }	
        ?>
    </div>
    <header>
     <h1><?php echo $Counter->name; ?></h1>
 </header>
</div>
<?php
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

function getDashCounterRaw($id)
{
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

?>