<script type='text/javascript'>
$( document ).ready(function() 
{
   (function getCountersData() {
      var ddJSInverval = $('.dd_counter').data('ddjstimeout');     
      var ddCounterObj = $('.dd_counter');

      if(typeof ddJSInverval != 'undefined') 
      {
         $.each($(ddCounterObj), function(index, value) {

            var dd_counterid = $(value).data('counterid');
            dd_counterid = dd_counterid.split("_").pop();

            DataDash.get(dd_counterid); 

         });

         setInterval(getCountersData, ddJSInverval);
      }
   })();
});
</script>

