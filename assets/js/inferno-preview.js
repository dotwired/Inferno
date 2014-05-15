jQuery(document).ready(function($) {
    function on_resize(c,t){onresize=function(){clearTimeout(t);t=setTimeout(c,100)};return c};

    function set_preview_perspecive() {
        $('.inferno-preview.fold, .inferno-preview.flip').each(function(){
            $element = $(this);
            var preview_hidden = false;
            if($element.css('display') == 'none') { $element.css({ 'display': 'block' }); preview_hidden = true; }
            var $parents = $element.parents().filter(function() {
                return $(this).css('display') == 'none';
            });
            $parents.each(function(){ $(this).css({ 'display': 'block' }); });
            $element.css({
                'perspective': ($element.width() * 1.54),
                '-webkit-perspective': ($element.width() * 1.54),
                '-khtml-perspective': ($element.width() * 1.54),
                '-moz-perspective': ($element.width() * 1.54),
                '-ms-perspective': ($element.width() * 1.54),
                '-o-perspective': ($element.width() * 1.54)
            });
            $parents.each(function(){ $(this).css({ 'display': 'none' }); });
            if(preview_hidden == true) { $element.css({ 'display': 'none' }); }
        });
    }
    
    set_preview_perspecive();
    $(document).ajaxComplete(function() {
        set_preview_perspecive()
    });
    on_resize(function(){
        set_preview_perspecive();
    });
});