jQuery(document).ready(function($) {

    /* ==========================================================================
       Inferno Canvas
       ========================================================================== */

    /* tabs */
    $("#inferno-canvas").tabs({
        fx: { opacity: 'toggle', duration: 200 }
    });

    /* form elements */
    $("#inferno-canvas .radio").buttonset();

    /* ajax form */
    $('#inferno-panel-form').ajaxForm(function() {
        $('.inferno-message.ajax').show(250);
        setTimeout(function() {
            $('.inferno-message.ajax').hide(250);
        }, 7000);
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

        $("#inferno-generator .inferno-setting").each(function(){
            $setting = $(this);
            if($setting.val()) {
                $inferno_shortcode_result.val($inferno_shortcode_result.val() + ' ' + $setting.attr('name') + '="' + $setting.val() + '"');
            }
        });
        $inferno_shortcode_result.val('[' + $inferno_shortcode_select.val() + ' ' + $inferno_shortcode_result.val() + ']');

        var shortcode = $inferno_shortcode_result.val();
        window.send_to_editor(shortcode);
        tb_remove();

        // Prevent default action
        event.preventDefault();
        return false;
    });


    /* ==========================================================================
       Buttons
       ========================================================================== */

    /* media */
    $('#inferno-canvas .media .button-upload').live('click', function() {
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

    $('#inferno-canvas .media .button-reset').live('click', function(){
        $container = $(this).parent();
        $container.find('.media-preview img').hide(200);
        $container.find('input[type="hidden"]').val('');
    });




    /* google webfonts button */
    $('#inferno-canvas .googlefont-desc, #inferno-canvas .googlefont-setting').hide();
    $('#inferno-canvas .button.googlefont').live('click', function(){
        var googlefonts_container = $(this).parent().parent().find('.googlefont-desc, .googlefont-setting');
        if(googlefonts_container.is(':visible'))
            googlefonts_container.slideUp(200);
        else
            googlefonts_container.slideDown(200);
    });

    $('#inferno-canvas .googlefont-setting input').live('keyup', function(){
        var google_font = $(this).val().split(' ').join('+');
        $(this).parent().find('.googlefont-link').attr('href', 'http://fonts.googleapis.com/css?family=' + google_font);
        $(this).parent().find('.googlefont-canvas').attr('style', 'font-family: \'' + $(this).val() + '\' !important;');
    });

});