jQuery(document).ready(function($) {

    /* ===========================================================
        upload images on custom panels
    =========================================================== */

    $('.ip-button-upload').live('click', function(event) {
        event.preventDefault();

        var thisthis = this;
        window.send_to_editor = function(html) {
            imgurl = $('img', html).attr('src');
            $(thisthis).parent().find('input[type="text"]').val(imgurl);
            tb_remove();
        };
        tb_show('', 'media-upload.php?post_id=0&amp;type=image&amp;TB_iframe=true');
        return false;
    });


    /* tabs */
    $(".inferno-canvas").tabs({
        fx: { opacity: 'toggle', duration: 200 }
    });

    /* form elements */
    $(".inferno-canvas .radio").buttonset();







    /* ===========================================================

        ajaxify admin panel and prepare messages

    =========================================================== */

    // bind 'myForm' and provide a simple callback function
    if(jQuery().ajaxForm) {
        $('#ip-form.ajax').ajaxForm(function() {
            $('.inferno-updated.ajax').animate({ height: 'toggle', opacity: 'toggle' }, 250);
            setTimeout(function(){
                $('.inferno-updated.ajax').animate({ height: 'toggle', opacity: 'toggle' }, 250);
            }, 7000);
        });
    }




    /* ===========================================================

        google webfonts story

    =========================================================== */

    $('.inferno-canvas .ip-googlefont-desc, .inferno-canvas .ip-googlefont-option').hide();
    $('.inferno-canvas .ip-button-googlefont').live('click', function(){
        var googlefonts_container = $(this).parent().parent().find('.ip-googlefont-desc, .ip-googlefont-option');
        if(googlefonts_container.is(':visible'))
            googlefonts_container.slideUp(200);
        else
            googlefonts_container.slideDown(200);
    });

    $('.inferno-canvas .ip-googlefont-option input').live('keyup', function(){
        var google_font = $(this).val().split(' ').join('+');
        $(this).parent().find('.ip-googlefont-link').attr('href', 'http://fonts.googleapis.com/css?family=' + google_font);
        $(this).parent().find('.ip-googlefont-canvas').attr('style', 'font-family: \'' + $(this).val() + '\' !important;');
    });

});