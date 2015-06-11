/******* Jquery No Conflict Function *******/
window.$ = jQuery.noConflict();

var DataDash = {

  settings:
  {
      formObj  : null,
  },

  get: function(id)
  {    
    $.ajax({
        url: DDUserAjax.ajaxurl,
        type: 'post',
        data: {action: 'dd_get_all_counters', id: id},
        success: function(data, status) 
        {
          $(data.id).html(data.html);
          DataDash.flipTheNumber(data);
        },
        error: function()
        {    
         return false; 
        }                        
    }); 
  },

  filterNumbersIntoSpan: function(Numbers)
  {
    var html = '';
    $.each($(Numbers), function(index, value){
        if(value === ',') {
          html += '<span class="dd_comma">'+value+'</span>';
        }
        else {
          html += '<span class="dd_number">'+value+'</span>';
        }        
    });

    return html;
  },

  flipTheNumber: function(data)
  {
    // Get the existing source
    var existing = $(data.id);

    var current = $(data.html);

    $.each($(data.id).find('span'), function(index, value){       
        
        if($(value).text() !== $(current[index]).text()) {
            
          $(current[index]).addClass('ddrotate');

        }     

    });

    return $(current);
  }
};