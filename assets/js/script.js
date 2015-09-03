jQuery(document).ready(function($){
  var options = {
    change: function(event, ui){
      $(this).val($(this).wpColorPicker( 'color' ));
      $(' #w4c-content input[name="w4c-size"]').trigger('change');
    }
  };
  $('.input-color').wpColorPicker(options);
  $('#w4c-content  #add-input-destination').on('click', function(ev) {
    ev.preventDefault();
    $('<br/><input type="text" id="w4c-destinations" name="w4c-destinations[]" value="" class="" /> <input type="text" id="w4c-timeouts" name="w4c-timeouts[]" value=""/> <a href="" class="button remove-input-destination"><i class="dashicons dashicons-no"></i> </a>').appendTo($('#w4c-content #w4c-destinations-wrap'));
  });
  $('img.default-agent').on('click', function(){
    $(this).next('input.agent-logo').prop('checked', true).trigger('keyup');
  });

  $(document).on('click', ".remove-input-destination",function(ev) {
    ev.preventDefault();
    if($('#w4c-destinations-wrap input').size() >2) {
      $(this).prev().prev().prev().remove();
      $(this).prev().prev().remove();
      $(this).prev().remove();
      $(this).remove();
    }
    return false;
  });
  $( ".slider" ).slider({
    range: true,
    min: 0,
    max: 720,
    values: [540,720],
    step: 15,
    slide: function(event, ui) {
      var slider_id = event.target.parentNode.id;
      var minutes0 = getMinutes(parseInt(ui.values[0] % 60));
      var hours0 = getMinutes(parseInt(ui.values[0] / 60));
      var minutes1 = getMinutes(parseInt(ui.values[1] % 60));
      var hours1 = getMinutes(parseInt(ui.values[1] / 60));
      
      $('#'+slider_id+' .w4c-tod0').val(ui.values[0]);
      $('#'+slider_id+' .w4c-tod1').val(ui.values[1]);
      $('#'+slider_id+' .w4c-slider-label').text(
        hours0 + 'h' +
        minutes0 + 'min - ' +
        hours1 + 'h' +
        minutes1 + 'min'
      );
    }
  });
  $( ".slider2" ).slider({
    range: true,
    min: 720,
    max: 1440,
    values: [720, 1080],
    step: 15,
    slide: function(event, ui) {
      var slider_id = event.target.parentNode.id;
      var minutes0 = getMinutes(parseInt(ui.values[0] % 60));
      var hours0 = getMinutes(parseInt(ui.values[0] / 60));
      var minutes1 = getMinutes(parseInt(ui.values[1] % 60));
      var hours1 = getMinutes(parseInt(ui.values[1] / 60));
      $('#'+slider_id+' .w4c-tod2').val(ui.values[0]);
      $('#'+slider_id+' .w4c-tod3').val(ui.values[1]);
      $('#'+slider_id+' .w4c-slider2-label').text(
        hours0 + 'h' +
        minutes0 + 'min - ' +
        hours1 + 'h' +
        minutes1 + 'min'
      );
    }
  });
  initSliderValues();
  $('input[name="w4c-tod-active"]').change(function(){
    if($(this).is('input:checked'))
      $('.w4c-tod-wrap').show();
    else
      $('.w4c-tod-wrap').hide();
  }).trigger('change');

  $('input.w4c-day-active').change(function(){
    if($(this).is('input:checked')){
      $(this).parent().parent().find('.slider').slider( "option", "disabled", false );
      $(this).parent().parent().find('.slider2').slider( "option", "disabled", false );
    } else {
      $(this).parent().parent().find('.slider').slider( "option", "disabled", true );
      $(this).parent().parent().find('.slider2').slider( "option", "disabled", true );
    }
  }).trigger('change');

  $('#w4c-content input[name="w4c-type"]').change(function(){
    if($(this).is('input:checked')){
      $('#w4c-content .w4c-display-btn-wrap').show();
      $('#w4c-content .w4c-display-content-wrap').show();
      $('#w4c-content .w4c-display-content-wrap #w4c-content-img').parent().parent().show();
      $('#w4c-content .w4c-display-header-wrap #w4c-content-img').parent().parent().hide();
      if($(this).val() == 'notif'){
        $('#w4c-content .w4c-display-header-wrap').show();
        $('#w4c-content .w4c-dev-mode').hide();
        $('#w4c-content .w4c-display-btn-wrap').show();
        $('#w4c-content .w4c-btn-result').show();

        if(!$('#w4c-content input[name=w4c-immediat-recall]').is('input:checked')){
          $('#w4c-content .w4c-display-btn-wrap').hide();
          $('#w4c-content .w4c-display-content-wrap').hide();
          $('#w4c-content .w4c-display-content-wrap #w4c-content-img').parent().parent().hide();
          $('#w4c-content .w4c-display-header-wrap #w4c-content-img').parent().parent().show();
          //$('#fileupload').parent().parent().hide();
          //$('#fileupload2').parent().parent().show();
        }
        else {
      $('#w4c-content .w4c-display-content-wrap #w4c-content-img').parent().parent().show();
          $('#w4c-content .w4c-display-header-wrap #w4c-content-img').parent().parent().hide();
      
        }
      }
      else if($(this).val() == 'btn') {
        $('#w4c-content .w4c-dev-mode').hide();
        $('#w4c-content .w4c-display-header-wrap').hide();
        $('#w4c-content .w4c-display-content-wrap').hide();
        $('#w4c-content .w4c-display-btn-wrap').show();
        $('#w4c-content .w4c-btn-result').show();
      } else if($(this).val() == 'dev-mode') {
        $('#w4c-content .w4c-dev-mode').show();
        $('#w4c-content .w4c-display-header-wrap').hide();
        $('#w4c-content .w4c-display-content-wrap').hide();
        $('#w4c-content .w4c-display-btn-wrap').hide();
        $('#w4c-content .w4c-btn-result').hide();

        
        
      }
    }
  }).trigger('change');

  function initSliderValues() {
    var sliderClass = '.slider';
    $(sliderClass).each(function(){
      var sliderId = $(this).parent().attr('id');
      $('#'+sliderId+' '+sliderClass).slider("values", 0, $('#'+sliderId+' .w4c-tod0').val());
      $('#'+sliderId+' '+sliderClass).slider("values", 1, $('#'+sliderId+' .w4c-tod1').val());
      /*$('#'+sliderId+' .w4c-tod0').val($('#'+sliderId+' '+sliderClass).slider('values',0));
      $('#'+sliderId+' .w4c-tod1').val($('#'+sliderId+' '+sliderClass).slider('values',1));*/
      $('#'+sliderId+' .w4c-slider-label').text(
        parseInt($('#'+sliderId+' '+sliderClass).slider('values',0) / 60) + 'h' +
        getMinutes(parseInt($('#'+sliderId+' '+sliderClass).slider('values',0) % 60)) + 'min - ' +
        parseInt($('#'+sliderId+' '+sliderClass).slider('values',1) / 60) + 'h' +
        getMinutes(parseInt($('#'+sliderId+' '+sliderClass).slider('values',1) % 60)) + 'min');
    });
    var sliderClass = '.slider2';
    $(sliderClass).each(function(){
      var sliderId = $(this).parent().attr('id');
      $('#'+sliderId+' '+sliderClass).slider("values", 0, $('#'+sliderId+' .w4c-tod2').val());
      $('#'+sliderId+' '+sliderClass).slider("values", 1, $('#'+sliderId+' .w4c-tod3').val());
      /*$('#'+sliderId+' .w4c-tod2').val($('#'+sliderId+' '+sliderClass).slider('values',0));
      $('#'+sliderId+' .w4c-tod3').val($('#'+sliderId+' '+sliderClass).slider('values',1));*/
      $('#'+sliderId+' .w4c-slider2-label').text(
        parseInt($('#'+sliderId+' '+sliderClass).slider('values',0) / 60) + 'h' +
        getMinutes(parseInt($('#'+sliderId+' '+sliderClass).slider('values',0) % 60)) + 'min - ' +
        parseInt($('#'+sliderId+' '+sliderClass).slider('values',1) / 60) + 'h' +
        getMinutes(parseInt($('#'+sliderId+' '+sliderClass).slider('values',1) % 60)) + 'min');
    });
  }


  $(' #w4c-content input[name="w4c-size"], #w4c-content input[name="w4c-color"], #w4c-content input[name="w4c-text-color"], #w4c-content textarea[name="w4c-text"], #w4c-content input[name="w4c-header-icon-active"],#w4c-content input[name="w4c-icon-active"],#w4c-content input[name="w4c-type"], #w4c-content input[name="w4c-header-bg-color"], #w4c-content input[name="w4c-header-color"], #w4c-content input[name="w4c-header-text"], #w4c-content textarea[name="w4c-content-text"], #w4c-content input[name="w4c-content-color"],#w4c-content input[name="w4c-content-bg-color"], #w4c-content input[name="w4c-immediat-recall"],  #w4c-content #w4c-content-img-src, .agent-logo').on('change keyup',function(){
        var button_type  = $('#w4c-content input[name="w4c-type"]:checked').val();
        var button_size  = $('#w4c-content input[name="w4c-size"]:checked').val();
        var button_header_bg_color = $('#w4c-content input[name="w4c-header-bg-color"]').val();
        var button_header_color = $('#w4c-content input[name="w4c-header-color"]').val();
        var button_content_bg_color = $('#w4c-content input[name="w4c-content-bg-color"]').val();
        var button_content_color = $('#w4c-content input[name="w4c-content-color"]').val();
        var button_header_text  = $('#w4c-content input[name="w4c-header-text"]').val();
        var button_content_text  = $('#w4c-content textarea[name="w4c-content-text"]').val();
        var button_content_img = '';
        
        if($('#w4c-content input[name="w4c-content-img"]:checked').val()) {
          button_content_img  = 'img/'+$('#w4c-content input[name="w4c-content-img"]:checked').val();
        } else {
          button_content_img  = $('#w4c-content input[name="w4c-content-img-dir"]').val() +
           $('#w4c-content input[name="w4c-content-img-default"]').val();
        }
         
        var button_color = $('#w4c-content input[name="w4c-color"]').val();
        var button_text_color = $('#w4c-content input[name="w4c-text-color"]').val();
        var button_text  = $('#w4c-content textarea[name="w4c-text"]').val();
        var button_icon_active = $('#w4c-content input[name="w4c-icon-active"]').is(':checked');
        var button_header_icon_active = $('#w4c-content input[name="w4c-header-icon-active"]').is(':checked');
        if(button_type == 'notif'){
          code = createNotif(button_header_text, button_header_bg_color,button_header_color,button_content_text,button_text, button_color, button_text_color,button_size,button_icon_active,button_header_icon_active,$('#w4c-content input[name="id"]').val(),button_content_bg_color,button_content_color,button_content_img);
          displayNotif($('#button-display .w4c').first());
        } else {
          code= createButon(button_text, button_color,button_text_color,button_size,button_icon_active,$('#w4c-content input[name="id"]').val());
          displayButon($('#button-display .w4c'));
        }
  
      }).trigger('change');

function createButon(button_text, button_color,button_text_color,button_size,button_icon_active,id) {
  code = "<a class='w4c' id='w4c-"+id+"' data-type='btn' href='"+location.protocol+"//w4c.widget4call.fr/fr/call/"+id+"' data-color='"+button_text_color+"' data-bg-color='"+button_color+"' data-size='"+button_size+"' data-icon='"+button_icon_active+"'>"+button_text.replace(/\r?\n/g, '<br/>')+"</a>";
  $('#button-display').html(code);
  return code;
}

function createNotif(button_header_text,button_header_bg_color, button_header_color,button_content_text,button_text, button_color,button_text_color,button_size,button_icon_active,button_header_icon_active,id,button_content_bg_color,button_content_color,button_content_img) {
  var code = '<div class="w4c" id="w4c-'+id+'" data-type="notif" data-title="'+button_header_text+'"  data-content="'+button_content_text+'" data-title-color="'+button_header_color+'" data-icon="'+button_header_icon_active+'" data-content-bg-color="'+button_content_bg_color+'" data-content-color="'+button_content_color+'" data-title-bg-color="'+button_header_bg_color+'" data-logo="'+button_content_img+'">';
  code += createButon(button_text, button_color,button_text_color,button_size,button_icon_active,id)+'</div>';
  $('#button-display').html(code);
  return code;
}


function displayButon(el){
  el.addClass('w4c-btn');
  if(el.length > 0) {
    if (typeof(el.data('icon')) != 'undefined' && el.data('icon') != false) {
      el.prepend('<i class="w4c-icon-phone"></i>');
    }
    if (typeof(el.data('color')) != 'undefined' && el.data('color').match(/#(?:[0-9a-f]{3}){1,2}/gi)) {
      el.css('color', el.data('color'));
    }
    if (typeof(el.data('bg-color')) != 'undefined' && el.data('bg-color').match(/#(?:[0-9a-f]{3}){1,2}/gi)) {
      el.css('background-color', el.data('bg-color'));
    }
    if (typeof(el.data('size')) != 'undefined' && (el.data('size') == 'lg' || el.data('size') == 'sm' || el.data('size') == 'xs')) {
      el.addClass('w4c-btn-'+el.data('size'));
    }
  }
}

function displayNotif(el){
  //el.hide();
  el.addClass('w4c-notif');

  btn = el.children('a');
  displayButon(btn);
  btn = el.html()
  el.html(''
    +'<div class="w4c-header">'
      +'<div class="w4c-title"></div>'
      +'<div class="w4c-show-hide w4c-icon-hide"></div>'
    +'</div>'
    +'<div class="w4c-content">'
      +'<div class="w4c-logo"></div>'
      +'<div class="w4c-content-wrap">'
        +'<div class="w4c-content-text"></div>'
        +btn
      +'</div>'
    +'</div>'
  );

  if (typeof(el.data('title')) != 'undefined') {
    el.find('.w4c-title').html(el.data('title'));
  }
  if (typeof(el.data('title-color')) != 'undefined' && el.data('title-color').match(/#(?:[0-9a-f]{3}){1,2}/gi)) {
    el.find('.w4c-header').css('color', el.data('title-color'));
  }
  if (typeof(el.data('title-bg-color')) != 'undefined' && el.data('title-bg-color').match(/#(?:[0-9a-f]{3}){1,2}/gi)) {
    el.find('.w4c-header').css('background-color', el.data('title-bg-color'));
    el.find('.w4c-content').css('border-color', el.data('title-bg-color'));
  }
  if (typeof(el.data('icon')) != 'undefined' && el.data('icon') != false) {
    el.find('.w4c-title').prepend('<i class="w4c-icon-phone"></i>');
  }
  if (typeof(el.data('content')) != 'undefined') {
    el.find('.w4c-content-text').html(el.data('content').replace(/\r?\n/g, '<br/>'));
  }
  if (typeof(el.data('content-color')) != 'undefined' && el.data('content-color').match(/#(?:[0-9a-f]{3}){1,2}/gi)) {
    el.find('.w4c-content-text').css('color', el.data('content-color'));
  }

  //if (typeof(el.data('content-bg-color')) != 'undefined' && el.data('content-bg-color').match(/#(?:[0-9a-f]{3}){1,2}/gi)) {
    el.find('.w4c-content').css('background-color', el.data('content-bg-color'));
  //}
  if (typeof(el.data('logo')) != 'undefined' && el.data('logo') != '') {
    el.find('.w4c-logo').css('background', 'url("https://w4c.widget4call.fr/'+el.data('logo')+'") no-repeat scroll 0 0 rgba(0, 0, 0, 0)');
  }
  else
   el.find('.w4c-logo').css('background', 'url("https://w4c.widget4call.fr/img/agent1.png") no-repeat scroll 0 0 rgba(0, 0, 0, 0)'); 

  $('.w4c-notif .w4c-header').on('click auto', function(ev) {
    if (typeof this.counter == 'undefined' ) this.counter = 0;
    if (ev.type == 'click') this.counter = 1;
    if ((ev.type == 'auto' && this.counter == 0) || ev.type == "click") {
      $('.w4c-show-hide').toggleClass('w4c-icon-show w4c-icon-hide');
      if ($('.w4c-show-hide').hasClass('w4c-icon-hide')) {
        h = 0;          
      }
      else {
        h = -$(this).parent().height()+$(this).height();
      }
      $('.w4c-notif')
        .stop()
        .animate({marginBottom: h}, {duration:400, easing:'linear', queue:true})
    }
  });
}
});
function getMinutes(minutes) {
  if(minutes < 10)
    minutes = "0" + minutes;
  return minutes;
}
