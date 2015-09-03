 jQuery(document).ready(function($){
 $('#myForm').submit(function(ev){
        console.log("Submitting form...");
        ev.preventDefault();
        $('div.validation-error').html('');
        var error = '';
        var notValid = false;
        var phone_valid = validatePhone();
        if(phone_valid !== true) {
          error = phone_valid;
          notValid = true;
        }
        var params = {
         'widgetId' : $('#widget-id').val(),
         'phone_number' : sanitize($('#inputPhoneNumber').val()),
         'lastname' : sanitize($('#lastname').val()),
         'firstname' : sanitize($('#firstname').val()),
        }
      
      $('div.param.visible_element').each(function(){
        var name = sanitize($(this).children('.paramName').val());
        var value = sanitize($(this).children('.paramValue').val());
        if(name || value) {
          var pattern = /^[\w]{1,64}$/;
          var message = '';
          if(!value) {
            message += 'Value est blanc; '; 
          } else if(!value.match(pattern)) {
            message += 'Value n\'est pas valide; '; 
          } 
          if(!name) {
            message += 'Name est blanc; '; 
          } else if(!name.match(pattern)) {
            message += 'Name n\'est pas valide; ';                     
          } 
          if(message.length > 0) {
            notValid = true;
            $(this).children('div.validation-error').html(message);
          } else {
            params[name] = value;
          } 
        }
      });
      if(notValid) {
        console.log("notValid set to " + notValid);
        if(error) {
          alert(error);
        }
      } else {
        $("button").prop('disabled', true);
        $("<span class='info'>Nous vous rappelons maintenant</span>").insertAfter('#myForm');
        //$.post('https://w4c.widget4call.fr/fr/place-call', 
        console.log("Launching POST request");
        $.ajax({
          type: "POST",
          url: 'https://w4c.widget4call.fr/fr/place-call',
          data: params,
          success: function(data){
            if(data.status == 'OK'){
              $('.info').text('Appel en cours');
              } else {
                $('.main-error').text('Une erreur est survenue');
                $("#myForm button").prop('disabled', false);
              }
          },
          error: function(data) {
            if(data.responseJSON.status == 'ERROR') {
              $('.main-error').text(data.responseJSON.message);
            } else {
              $('.main-error').text('Une erreur est survenue');
            }
            $("#myForm button").prop('disabled', false);
          },
          dataType: "json"
        });
      }
  });

$('#add_param').on('click', function(){    
  var elem =  $('div.hidden_element.param:first');
  elem.removeClass('hidden_element');
  elem.addClass('visible_element');
  elem.show();
  toggleButtonsVisibility();
});

$('i.fa-minus-circle').on('click' , function() {
  var line = $(this).parent();
  $(line).removeClass('visible_element').addClass('hidden_element').hide();
  $(line).children('input').val(''); 
  $(line).children('div.error').html('');
  toggleButtonsVisibility();
});
function validatePhone() {
  var phone = $('#inputPhoneNumber').val();
  var pattern = /^[0][12345679]([0-9]{8})$/;  
  if(!phone.match(pattern))  
  {  
    return 'Le numéro de téléphone n\'est pas valide';
  }

  return true;            
}

function toggleButtonsVisibility() {
  var number =  $('div.hidden_element.param').length;
  switch(number) {
   case 0:
   $('#add_param').hide();
   break;
   case 1:
   $('#add_param').show();
   break;
  }
 }
});
function sanitize(input) {
  var output = input.replace(/<script[^>]*?>.*?<\/script>/gi, '').
  replace(/<[\/\!]*?[^<>]*?>/gi, '').
  replace(/<style[^>]*?>.*?<\/style>/gi, '').
  replace(/<![\s\S]*?--[ \t\n\r]*>/gi, '');
  return output;
}