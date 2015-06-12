<?php

add_shortcode( "datadash", array('DDShortCodes', 'datadash'));

class DDShortCodes
{
    public static function datadash($atts, $content = null, $code)
    {
        $attr_store = shortcode_atts( array(
         'id' => null,
         'timeout' => 60,
      ), $atts );
        
      if($attr_store['id'] == null)
      {
        return false;
      }
 
      return getDashCounter(esc_attr( $attr_store['id'] ), esc_attr( $attr_store['timeout'] ));
    }
}    

?>