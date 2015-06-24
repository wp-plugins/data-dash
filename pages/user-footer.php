<script type='text/javascript'>
$( document ).ready(function() 
{
   var Counters = Array();

   (function getCountersData() {
      var ddJSInverval = $('.dd_counter').data('ddjstimeout');     
      var ddCounterObj = $('.dd_counter');

      if(typeof ddJSInverval != 'undefined') 
      {
         $.each($(ddCounterObj), function(index, value) {

            var dd_counterid = $(value).data('counterid');

            // Counters[index] = new DataDash1(dd_counterid);
            // Counters[index].init();
           
            dd_counterid = dd_counterid.split("_").pop();

            DataDash.get(dd_counterid); 

         });

         //setInterval(getCountersData, ddJSInverval);
      }
   })();
});
</script>

