/******* Jquery No Conflict Function *******/
window.$ = jQuery.noConflict();

var DDForm = {

  settings:
  {
      formObj  : null,
  },

  post: function(FormId)
  {    
    DDForm.settings.formObj = $(FormId);

    $.ajax({
        url: ajaxurl,
        type: 'post',
        data: DDForm.settings.formObj.serialize(),
        success: function(data, status) 
        {                        
          if(data.status == true)
          {
            $('.dd-success-msg').fadeIn(1000).siblings('.dd-msg').hide();
            $(FormId)[0].reset();
          }
          else
          {
            $('.dd-error-msg').fadeIn(1000).siblings('.dd-msg').hide();
            $(FormId)[0].reset(); 
          }
        },
        error: function()
        {             
          $('.dd-error-msg').fadeIn(1000).siblings('.dd-msg').hide();
          $(FormId)[0].reset();  
        }                        
    }); 
  }
};