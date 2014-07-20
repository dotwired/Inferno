jQuery(document).ready(function($) {

  // get the demo mode
  var demo_mode = $('#inferno-panel-form').data('demo') == true ? true : false;

  /* ==========================================================================
     Inferno opener
     ========================================================================== */

  // TODO: make this maybe an iframe popup to prevent style and script incopatibilities of panel and frontend?
  if(demo_mode) {
    $('#inferno-demo-opener').magnificPopup({
      type: 'inline',
      mainClass: 'inferno-demo-popup',
      alignTop: true,
      midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
    });

    var qtip_my = 'left center';
    var qtip_at = 'right center';

    if($('#inferno-demo-opener').hasClass('right')) {
      qtip_my = 'right center';
      qtip_at = 'left center';
    }

    $('#inferno-demo-opener').qtip({
      content: {
        text: INFERNO.demo_opener_qtip
      },
      style: {
        classes: 'qtip-bootstrap'
      },
      position: {
        my: qtip_my,
        at: qtip_at
      }
    });
  }

  /* ==========================================================================
     Inferno globally
     ========================================================================== */

  // TODO: make this height fix cleaner: http://stackoverflow.com/questions/2345784/jquery-get-height-of-hidden-element-in-jquery
  function equalHeightInfernoColumn() {
    var originClass = $('#inferno-panel-form').attr('class');
    $('#inferno-panel-form.mfp-hide').css({
      position:   'absolute',
      visibility: 'hidden',
      display:    'block'
    }).removeClass('mfp-hide');

    if($('#inferno-canvas .inferno-menu').height() > $('#inferno-canvas .inferno-content').height()) {
      $('#inferno-canvas .inferno-menu').animate({ 
        height: Math.max.apply(Math, [ $('#inferno-canvas .inferno-content').height(), $('#inferno-canvas .inferno-menu > ul').outerHeight(true) + $('#inferno-canvas .inferno-menu > button').outerHeight(true) ]) + 'px'
      });
    } else {
      $('#inferno-canvas .inferno-menu').animate({ 
        height: $('#inferno-canvas .inferno-content').height() + 'px'
      });
    }

    $('#inferno-panel-form').removeAttr('style').attr('class', originClass);
  }

  /* Form elements
     ========================================================================== */
  $("#inferno-canvas .radio, .inferno-meta-box .radio, .inferno-menu-options .radio").buttonset();
  $("#inferno-canvas .checkbox input, .inferno-meta-box .checkbox input, .inferno-menu-options .checkbox input").button().change(function(){
    $label = $(this).next('label.ui-button');
    if($label.hasClass('ui-state-active')) {
      $label.find('span.ui-button-text').text($label.data('true'));
    } else {
      $label.find('span.ui-button-text').text($label.data('false'));
    }
  });


  /* Upload button
     ========================================================================== */
  if(!demo_mode) {
    $('#inferno-canvas .media .button-upload, .inferno-meta-box .media .button-upload').on('click', function() {
      $element = $(this);
      window.send_to_editor = function(html) {
        imgurl = $('img', html).attr('src');
        $element.parent().find('input[type="text"]').val(imgurl);
        $element.parent().find('.media-preview').html('<img src="' + $element.parent().find('input[type="text"]').val() + '" alt="" />');
        tb_remove();
      };
      tb_show('', 'media-upload.php?post_id=0&amp;type=image&amp;TB_iframe=true');
      return false;
    });
  }


  /* Image picker
     ========================================================================== */
  $('.imagepicker select').imagepicker();


  /* Google webfonts button
     ========================================================================== */
  $('#inferno-canvas .googlefont-desc, #inferno-canvas .googlefont-setting, #inferno-canvas .button.googlefont.hide').hide();
  $('#inferno-canvas .button.googlefont.hide').hide();
  $('#inferno-canvas .button.googlefont').live('click', function() {
    var btn = $(this);
    var googlefonts_container = btn.parent().parent().find('.googlefont-desc, .googlefont-setting');
    btn.parent().find('.button.googlefont').css({ display: 'none' });
    if(btn.hasClass('hide')) {
      btn.parent().find('.button.googlefont.show').css({ display: 'inline-block' });
      googlefonts_container.slideUp(200, function() { equalHeightInfernoColumn(); });
    } else if(btn.hasClass('show')) {
      btn.parent().find('.button.googlefont.hide').css({ display: 'inline-block' });
      googlefonts_container.slideDown(200, function() { equalHeightInfernoColumn(); });
    }        
  });
  $('#inferno-canvas .button.googlefont.hide').live('click', function() {
    var googlefonts_container = $(this).parent().parent().find('.googlefont-desc, .googlefont-setting');
    $(this).parent().find('.button.googlefont.show').show();
    $(this).hide();
    googlefonts_container.slideUp(200, function() { equalHeightInfernoColumn(); });  
  });

  $('#inferno-canvas .googlefont-setting input').live('keyup', function(){
    var google_font = $(this).val().split(' ').join('+');
    $(this).parent().find('.googlefont-link').attr('href', 'http://fonts.googleapis.com/css?family=' + google_font);
    $(this).parent().find('.googlefont-canvas').attr('style', 'font-family: \'' + $(this).val() + '\' !important;');
  });

  /* ==========================================================================
     Inferno Canvas
     ========================================================================== */

  /* Mobile menu
     ========================================================================== */

  $('#inferno-mobile-menu-toggle').on('click', function(event){
    event.preventDefault();
    var toggle = $(this);

    if(toggle.hasClass('active')) {
      toggle.removeClass('active');
      $('#inferno-canvas .inferno-menu').removeClass('active');
      $('#inferno-canvas .inferno-content').removeClass('menu-active');
    } else {
      toggle.addClass('active');
      $('#inferno-canvas .inferno-menu').addClass('active');
      $('#inferno-canvas .inferno-content').addClass('menu-active');
    }

    return false;
  });




  /* Tabs
     ========================================================================== */
  $("#inferno-canvas").tabs({
    hide: { effect: 'fadeOut', duration: 150 },
    show: { effect: 'fadeIn', duration: 150 },
    activate: function(event, ui) {
      equalHeightInfernoColumn();
    },
    create: function(event, ui) {
      equalHeightInfernoColumn();
    }
  });


  /* Ajax form
     ========================================================================== */
  function successResponse(responseText, statusText, xhr, $form) {
    $('.inferno-message.ajax.success').show(250);
    $('.inferno-message.ajax.success i').animate({ fontSize: '30px' }, 200);
    $('.inferno-message.ajax.success p').animate({ fontSize: '12px' }, 200);
    setTimeout(function() {
      $('.inferno-message.ajax.success').hide(250);
      $('.inferno-message.ajax.success i').animate({ fontSize: '0px' }, 200);
      $('.inferno-message.ajax.success p').animate({ fontSize: '0px' }, 200);
    }, 5000);
  }

  function errorResponse() {
    $('.inferno-message.ajax.error').show(250);
    $('.inferno-message.ajax.error i').animate({ fontSize: '30px' }, 200);
    $('.inferno-message.ajax.error p').animate({ fontSize: '12px' }, 200);
    setTimeout(function() {
      $('.inferno-message.ajax.error').hide(250);
      $('.inferno-message.ajax.error i').animate({ fontSize: '0px' }, 200);
      $('.inferno-message.ajax.error p').animate({ fontSize: '0px' }, 200);
    }, 5000);
  }

  function showRequest(formData, jqForm, options) {
    // formData is an array; here we use $.param to convert it to a string to display it 
    // but the form plugin does this for you automatically when it submits the data 
    var queryString = $.param(formData);
   
    // jqForm is a jQuery object encapsulating the form element.  To access the 
    // DOM element for the form do this: 
    // var formElement = jqForm[0]; 
   
    alert('About to submit: \n\n' + queryString);
   
    // here we could return false to prevent the form from being submitted; 
    // returning anything other than false will allow the form submit to continue 
    return true;
  }

  if(!demo_mode) {
    $('#inferno-panel-form').ajaxForm({
      beforeSubmit: ($('#inferno-panel-form').data('debug') === true ? showRequest : null),
      success: successResponse,
      error: errorResponse
    });
  }



  /* Reset button
     ========================================================================== */
  $('#inferno-canvas .media .button-reset').live('click', function(){
    $container = $(this).parent();
    $container.find('.media-preview img').hide(200);
    $container.find('input[type="hidden"]').val('');
  });

  /* Advanced mode
     ========================================================================== */
  $('#inferno-canvas .field.advanced').slideUp(0, function() { equalHeightInfernoColumn(); });
  $('#inferno-canvas button.advanced-mode').live('click', function(e){
    e.preventDefault();
    var btn = $(this);
    if(!btn.find('i.fa').hasClass('fa-spin')) {
      btn.find('i.fa').addClass('fa-spin');
      $('#inferno-canvas .field.advanced').slideDown(200, function() { equalHeightInfernoColumn(); });
    } else if(btn.find('i.fa').hasClass('fa-spin')) {
      btn.find('i.fa').removeClass('fa-spin');
      $('#inferno-canvas .field.advanced').slideUp(200, function() { equalHeightInfernoColumn(); });
    }
  });


  /* Transfer option
     ========================================================================== */

  $('#inferno-canvas .field-setting.transfer textarea').on('focus', function(){
    $(this).select();
    $(this).mouseup(function() {
      // Prevent further mouseup intervention
      $(this).unbind("mouseup");
      return false;
    });
  });


  /* ==========================================================================
     Inferno Shortcode Generator
     ========================================================================== */

  $('#inferno-generator-insert').hide();
  $("#inferno-generator-select").on("change", function(){
    $('#inferno-generator-shortcode .inferno-shortcode').css({ display: 'none' });
    $('#inferno-generator-shortcode #inferno-shortcode-' + $(this).val() + '.inferno-shortcode').css({ display: 'block' });

    if(!$(this).val() || $(this).val() === 'raw') {
      $('#inferno-generator-insert').hide();
    } else {
      $('#inferno-generator-insert').show();
    }
  });

  $('.mfp.inferno-shortcode-generator-button').magnificPopup({
    type: 'inline',
    showCloseBtn: true,
    closeBtnInside: true
  });

  $("#inferno-generator .radio").buttonset();
  $("#inferno-generator .checkbox input[type=checkbox]").button().change(function(){
    $label = $(this).next('label.ui-button').first();
    if($label.hasClass('ui-state-active')) {
      $label.find('span.ui-button-text').text($label.data('true'));
    } else {
      $label.find('span.ui-button-text').text($label.data('false'));
    }
  });


  $("#inferno-generator-insert").live('click', function(){
    $inferno_shortcode_result = $("#inferno-generator-result");
    $inferno_shortcode_select = $("#inferno-generator-select");
    $inferno_shortcode_result.val(""); // flush
    var inferno_shortcode_only_atts = $("#inferno-shortcode-only-atts").val() === 'true' ? true : false;
    var inferno_shortcode_content_att = $("#inferno-shortcode-content-att").val() !== '' ? $("#inferno-shortcode-content-att").val() : false;


    var $shortcode_container = $("#inferno-generator").find('.inferno-shortcode').filter(':visible:first');
    var shortcode_id = $shortcode_container.data('shortcode-id');

    $shortcode_container.find('.inferno-setting').each(function(){
      $setting = $(this);

      // remove that nasty shortcode id at the beginnging + the _
      var setting_id = $setting.attr('name').substring(shortcode_id.length + 1);

      // TODO: all this process may be lightened up some time. kinda confusing and complex right now
      if((($setting.is('input[type=text]') || $setting.is('textarea')) && $setting.val()) ||
        (($setting.is('input[type=checkbox]') || $setting.is('input[type=radio]')) && $setting.is(':checked') && $setting.val())) {
        $inferno_shortcode_result.val($inferno_shortcode_result.val() + ' ' + setting_id + '="' + $setting.val() + '"');
      }
    });
    $inferno_shortcode_result.val('[' + $inferno_shortcode_select.val() + $inferno_shortcode_result.val() + ']');
    if(!inferno_shortcode_only_atts) $inferno_shortcode_result.val($inferno_shortcode_result.val() + '[/' + $inferno_shortcode_select.val()  + ']');

    var shortcode = $inferno_shortcode_result.val();
    window.send_to_editor(shortcode);
    $.magnificPopup.instance.close();

    // Prevent default action
    event.preventDefault();
    return false;
  });

  
  /* ==========================================================================
     Unleash the Inferno
     ========================================================================== */

  $(window).load(function(){
    $('#inferno-canvas').addClass('show');
  });
});