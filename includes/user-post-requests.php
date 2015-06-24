<?php
namespace DataDash;		
/**
 * @package Internals
 */

// Action hook for AJAX Request
add_action( 'wp_ajax_nopriv_dd_get_all_counters', array('DataDash\UserPostRequest', 'getAllCounterData'));
add_action('wp_ajax_dd_get_all_counters', array('DataDash\UserPostRequest', 'getAllCounterData'));

class UserPostRequest
{
   public static function getAllCounterData()
   {
      $Id = $_POST['id'];
      $OptionVal =  \DDData::getCounter($Id);
      $Numbers = getCounterNumbersDesign($OptionVal->value);

      $response = array(                                  
                  'status' => true, 
                  'html'  => $Numbers,
                  'id' => '#dd_counter_'.$Id
               );

      wp_send_json($response);
   }
}
?>