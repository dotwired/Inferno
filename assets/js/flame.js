jQuery(document).ready(function($) {

    Modernizr.load([
    {
        test: (Modernizr.csstransforms3d && ($('.preview-thumb.fold').length > 0 || $('.preview-thumb.flip').length > 0)),
        yep : infernal.flame.url + 'assets/css/supports3d.css',
        complete: function() {
            $('.preview-thumb.fold').each(function(){
                $element = $(this);

                $element.css({
                    'perspective': ($element.width() * 1.54),
                    '-webkit-perspective': ($element.width() * 1.54),
                    '-moz-perspective': ($element.width() * 1.15)
                });
            });

            $(document).ajaxComplete(function() {
                $('.preview-thumb.fold').each(function(){
                    $element = $(this);

                    $element.css({
                        'perspective': ($element.width() * 1.54),
                        '-webkit-perspective': ($element.width() * 1.54),
                        '-moz-perspective': ($element.width() * 1.15)
                    });
                });
            });
        }
    },
    {
        test: $('div[class^="icon-"], i[class^="icon-"]').length > 0,
        yep : infernal.flame.url + 'assets/css/font-awesome.css',
        complete: function() {
            $('.infernal-circle').each(function() {
                $element = $(this);
                if($element.find('.infernal-icon').length > 0) {
                    //$element.height($element.width());
                    $element.css({ 'line-height': $element.width() + 'px', height: $element.width() });
                }
            });

            $(window).resize(function(){
                $('.infernal-circle').each(function() {
                    $element = $(this);
                    if($element.find('.infernal-icon').length > 0) {
                        //$element.height($element.width());
                        $element.css({ 'line-height': $element.width() + 'px', height: $element.width() });
                    }
                });
            });
        }
    },
    {
        test: $('.infernal-video').length > 0 || $('.preview-thumb.iframe').length > 0,
        yep : infernal.flame.url + 'assets/js/jquery/jquery.fitvids.min.js',
        complete: function() {
            if(jQuery().fitVids) {
                $(".infernal-video").fitVids();
                $("#colorbox").fitVids();
            }
        }
    },
    {
        test: $('.infernal-tweet').length > 0,
        yep : infernal.flame.url + 'assets/js/jquery/jquery.tweet.min.js',
        complete: function() {
            if(jQuery().tweet) {
                for(var widget in infernal.tweet) {
                    $(infernal.tweet[widget].id).find('.infernal-tweet').tweet({
                        username: infernal.tweet[widget].username,
                        count: infernal.tweet[widget].count,
                        loading_text: infernal.tweet[widget].loadingtext,
                        template: infernal.tweet[widget].template
                    });
                }
            }
        }
    },
    {
        test: $('.infernal-society').length > 0,
        yep : infernal.flame.url + 'assets/css/society.css'
    },
    {
        test: $('body').find('.portfolio-list[data-infinite="scroll"]').length > 0,
        yep : infernal.flame.url + 'assets/js/jquery/jquery.infinitescroll.min.js'
    },
    {
        test: $('body').find('.infernal-lightbox').length > 0,
        yep : infernal.flame.url + 'assets/js/jquery/jquery.colorbox.min.js',
        complete: function() {
            if(jQuery().colorbox) {
                $('.infernal-portfolio .infernal-lightbox').colorbox({
                    rel: 'infernal-portfolio',
                    opacity: 0.75,
                    next: '',
                    previous: '',
                    close: '',
                    maxWidth: '95%',
                    maxHeight: '85%',
                    title: function() {
                        return $(this).data('title');
                    },
                    onOpen: function() {
                        $('.infernal-portfolio .infernal-lightbox').addClass('blur');
                    },
                    onClosed: function() {
                        $('.infernal-portfolio .infernal-lightbox').removeClass('blur');
                    }
                });
                $('.infernal-portfolio .infernal-lightbox.iframe').colorbox({
                    rel: 'infernal-portfolio',
                    opacity: 0.75,
                    next: '',
                    previous: '',
                    maxWidth: '95%',
                    maxHeight: '85%',
                    iframe: true,
                    innerWidth: 500,
                    innerHeight: 409,
                    title: function() {
                        return $(this).data('title');
                    },
                    onOpen: function() {
                        $('.infernal-portfolio .infernal-lightbox').addClass('blur');
                    },
                    onClosed: function() {
                        $('.infernal-portfolio .infernal-lightbox').removeClass('blur');
                    }
                });
            }
        }
    }
    ]);


    /* some jquery bugfixes
    ====================================== */

    $('.gallery > br').remove();


    /* here come the tweaks
    ====================================== */

    (function($) {
        if(infernal.tweaks.scrollToTopButton === true) {
            $('body').append('<div id="infernal-scrolltotop"></div>');
            $('#infernal-scrolltotop').fadeOut();

            $('#infernal-scrolltotop').click(function(){
                $(window).scrollTo(0, infernal.tweaks.scrollToTopButtonDuration);
            });

            $('#infernal-scrolltotop').bind('mouseover', function(){
                $(this).stop().animate({ opacity : 1 }, 75);
            });

            $('#infernal-scrolltotop').bind('mouseout', function(){
                $(this).stop().animate({ opacity : 0.6 }, 75);
            });

            $(window).scroll(function(){
                var fromTop = $(this).scrollTop();

                if(fromTop >= infernal.tweaks.scrollToTopButtonOffset) {
                    //$('#infernal-scrolltotop').css({ opacity: '0.6' });
                    $('#infernal-scrolltotop').fadeIn(500);
                } else {
                    //$('#infernal-scrolltotop').css({ opacity: '0' });
                    $('#infernal-scrolltotop').fadeOut(500);
                }
            });
        }
    })(jQuery);

    /* infernal icon
    ====================================== */
    (function($) {
        $('.infernal-icon').live('mouseover', function(){
            var currentStyle = $(this).attr('style');
            $('body').append('<input id="infernal-icon-style" type="hidden" value="' + currentStyle + '" />');
            $(this).css({ 'color': $(this).data('hovercolor'), 'background': $(this).data('hoverbackground') });
        });
        $('.infernal-icon').live('mouseout', function(){
            $(this).attr('style', $('#infernal-icon-style').val());
            $('#infernal-icon-style').remove();
        });
    })(jQuery);


    /* infernal staff member
    ====================================== */
    (function($) {
        $('.infernal-staff-member').each(function(){
            $member = $(this);
            var profilesCount = $member.find('.profile-img a').size();

            if($member.hasClass('circle')) {
                $member.live('mouseover', function(){
                    $hoverMember = $(this);

                    // thanks to http://mattconnolly.com/jquery-arrange-items-in-a-circle/ for basic approach
                    start = 0.25;
                    radius = ($hoverMember.width() * 3) / 7;
                    step = (2 * Math.PI) / profilesCount;
                    $hoverMember.find('.profile-img a').each(function(){
                        tmpTop = (($hoverMember.find('.infernal-circle').height() / 2) + radius * Math.sin(start));
                        tmpLeft = (($hoverMember.find('.infernal-circle').width()/2) + radius * Math.cos(start));
                        start += step;

                        $(this).css({ top: tmpTop, left: tmpLeft });
                    });
                });

                $member.live('mouseout', function(){
                    $(this).find('.profile-img a').css({ top: '50%', left: '50%' });
                });
            } else {
                for(var i = 1; i <= profilesCount; i++) {
                    $member.find('.profile-img a').eq(i - 1).css({ left: (i * (100 / (profilesCount + 1))) + '%' });
                }
            }
        });
    })(jQuery);

    /* infernal notification bar
    ====================================== */
    $(function() {

        $('.infernal-notification-bar').css({ marginTop: -40 });

        // if hello contents are enabled
        if($('.infernal-notificat').length !== 0) {
            $('.infernal-notification-bar').css({'margin': '0'});

            if($.cookie("infernal-notification-bar") === 'closed') {
                $('.infernal-notification-bar').css({ marginTop: -40 });
                $('.infernal-notification-bar .open').css({ marginTop: 110 });
            }

            $('.infernal-notification-bar .close').live('click', function(event){
                event.preventDefault();
                $('.infernal-notification-bar').animate({ marginTop: -40 }, 600, 'easeOutBounce');
                $('.infernal-notification-bar .open').animate({ marginTop: 110 }, 600, 'easeOutBounce');

                $.cookie("infernal-notification-bar", "closed", { path: '/', expires: 14 });
            });

            $('.infernal-notification-bar .open').live('click', function(event){
                event.preventDefault();
                $('.infernal-notification-bar').animate({ marginTop: 0 }, 600, 'easeOutBounce');
                $('.infernal-notification-bar .open').animate({ marginTop: 0 }, 600, 'easeOutBounce');

                $.cookie("infernal-notification-bar", "open", { path: '/', expires: 14 });
            });
        }

    });
});