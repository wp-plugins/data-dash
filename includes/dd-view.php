<?php

class DDView
{
    public static function printCounter($id)
    {
        $Counter = DDData::getCounter($id);
        $Numbers = array_map('intval', str_split($Counter->value));
        $i = 1; 
        ?>
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
        <?php
    }
}