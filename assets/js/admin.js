jQuery(document).ready(function($) {

    /* ==========================================================================
       Inferno globally
       ========================================================================== */

    /* Form elements
       ========================================================================== */
    $("#inferno-canvas .radio, .inferno-meta-box .radio").buttonset();


    /* Upload button
       ========================================================================== */
    $('#inferno-canvas .media .button-upload, .inferno-meta-box .media .button-upload').live('click', function() {
        $element = $(this);
        window.send_to_editor = function(html) {
            imgurl = $('img', html).attr('src');
            $element.parent().find('input[type="hidden"]').val(imgurl);
            $element.parent().find('.media-preview').html('<img src="' + $element.parent().find('input[type="hidden"]').val() + '" alt="" />');
            tb_remove();
        };
        tb_show('', 'media-upload.php?post_id=0&amp;type=image&amp;TB_iframe=true');
        return false;
    });


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
            googlefonts_container.slideUp(200);
        } else if(btn.hasClass('show')) {
            btn.parent().find('.button.googlefont.hide').css({ display: 'inline-block' });
            googlefonts_container.slideDown(200);
        }           
    });
    $('#inferno-canvas .button.googlefont.hide').live('click', function() {
        var googlefonts_container = $(this).parent().parent().find('.googlefont-desc, .googlefont-setting');
        $(this).parent().find('.button.googlefont.show').show();
        $(this).hide();
        googlefonts_container.slideUp(200);            
    });

    $('#inferno-canvas .googlefont-setting input').live('keyup', function(){
        var google_font = $(this).val().split(' ').join('+');
        $(this).parent().find('.googlefont-link').attr('href', 'http://fonts.googleapis.com/css?family=' + google_font);
        $(this).parent().find('.googlefont-canvas').attr('style', 'font-family: \'' + $(this).val() + '\' !important;');
    });

    /* ==========================================================================
       Inferno Canvas
       ========================================================================== */

    /* Tabs
       ========================================================================== */
    $("#inferno-canvas").tabs({
        hide: { effect: 'fadeOut', duration: 150 },
        show: { effect: 'fadeIn', duration: 150 }
    });

    /* Ajax form
       ========================================================================== */
    $('#inferno-panel-form').ajaxForm(function() {
        $('.inferno-message.ajax').show(250);
        $('.inferno-message.ajax i').animate({ fontSize: '30px' }, 200);
        $('.inferno-message.ajax p').animate({ fontSize: '12px' }, 200);
        setTimeout(function() {
            $('.inferno-message.ajax').hide(250);
            $('.inferno-message.ajax i').animate({ fontSize: '0px' }, 200);
            $('.inferno-message.ajax p').animate({ fontSize: '0px' }, 200);
        }, 5000);
    });

    /* Reset button
       ========================================================================== */
    $('#inferno-canvas .media .button-reset').live('click', function(){
        $container = $(this).parent();
        $container.find('.media-preview img').hide(200);
        $container.find('input[type="hidden"]').val('');
    });

    /* Advanced mode
       ========================================================================== */
    $('#inferno-canvas .field.advanced').slideUp(0);
    $('#inferno-canvas button.advanced-mode').live('click', function(e){
        e.preventDefault();
        var btn = $(this);
        if(btn.hasClass('inactive')) {
            btn.removeClass('inactive').addClass('active');
            $('#inferno-canvas .field.advanced').slideDown(200);
        } else if(btn.hasClass('active')) {
            btn.removeClass('active').addClass('inactive');
            $('#inferno-canvas .field.advanced').slideUp(200);
        }
    });


    /* ==========================================================================
       Inferno Shortcode Generator
       ========================================================================== */

    $(document).ajaxComplete(function() {
        $("#inferno-generator .radio").buttonset();
    });

    $("#inferno-generator-insert").live('click', function(){
        $inferno_shortcode_result = $("#inferno-generator-result");
        $inferno_shortcode_select = $("#inferno-generator-select");
        $inferno_shortcode_result.val(""); // flush
        var inferno_shortcode_only_atts = $("#inferno-shortcode-only-atts").val() === 'true' ? true : false;
        var inferno_shortcode_content_att = $("#inferno-shortcode-content-att").val() !== '' ? $("#inferno-shortcode-content-att").val() : false;


        $("#inferno-generator .inferno-setting").each(function(){
            $setting = $(this);
            if($setting.val()) {
                $inferno_shortcode_result.val($inferno_shortcode_result.val() + ' ' + $setting.attr('name') + '="' + $setting.val() + '"');
            }
        });
        $inferno_shortcode_result.val('[' + $inferno_shortcode_select.val() + ' ' + $inferno_shortcode_result.val() + ']');
        if(!inferno_shortcode_only_atts) $inferno_shortcode_result.val($inferno_shortcode_result.val() + '[' + $inferno_shortcode_select.val()  + ']');

        var shortcode = $inferno_shortcode_result.val();
        window.send_to_editor(shortcode);
        tb_remove();

        // Prevent default action
        event.preventDefault();
        return false;
    });
});