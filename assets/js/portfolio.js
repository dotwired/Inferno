jQuery(document).ready(function($) {    

    /* ===============================================
        portfolio & item hovers
    =============================================== */
    
    (function($) {
        
        $('.infernal-portfolio').each(function(index) {
            var $container = $(this);
            var $element = $(this).find('ul.portfolio-list');
            //var columns = $element.data('columns');

            var baseWidth = $element.data('basewidth');
            var baseHeight = $element.data('baseheight');

            var colNum = Math.floor($element.width() / baseWidth);

            /**
             * ($element.width() - 3) at each point is thaught as an isotope fixe for the effect, that pixels are 
             * computed "wrong" by the browser and there is not enough space for all planned columns, so the last
             * one would slip under to the next row and in the row above would be almost one column completely free.
             * though, this fix causes most of the time a 1-3px wide gap between the last column item and the right
             * edg of the parent container.
             */
            $element.imagesLoaded(function(){
                while(true) { // hopefully this loop breaks :D
                    if(baseWidth < $element.width() / colNum) {
                        colNum++;
                    } else if((colNum - 1) * baseWidth > $element.width() && colNum > 1) {
                        colNum--;
                    } else {
                        break;
                    }
                }

                $element.find('li').css({ width: (($element.width() - 3) / colNum) + 'px' });

                $element.isotope({
                    itemSelector : '.preview-box',
                    animationOptions: {
                        duration: 750,
                        easing: 'linear',
                        queue: false
                    },
                    layoutMode: 'fitRows',
                    resizable: false,
                    masonry: {
                        columnWidth: ($element.width() - 3) / colNum
                    }
                });

                $element.css({ overflow: 'visible' });


                $(window).smartresize(function(){
                    if(baseWidth < $element.width() / colNum) {
                        colNum++;
                    } else if((colNum - 1) * baseWidth > $element.width() && colNum > 1) {
                        colNum--;
                    }

                    $element.find('li').css({ width: (($element.width() - 3) / colNum) + 'px' });

                    $element.isotope({
                        itemSelector : '.preview-box',
                        animationOptions: {
                            duration: 750,
                            easing: 'linear',
                            queue: false
                        },
                        layoutMode: 'fitRows',
                        masonry: {
                            columnWidth: ($element.width() - 3) / colNum
                        }
                    });
                });

                // filter items when filter link is clicked
                $container.find('ul.portfolio-filter a').click(function(){
                    var selector = $(this).attr('data-filter');
                    var clicked = $(this);
                    clicked.parent().parent().find('li').removeClass('selected');
                    clicked.parent().addClass('selected');
                    $element.isotope({ filter: selector });
                    return false;
                });

                // make infinite scroll available
                if($element.data('infinite') == 'scroll') {
                    // make it infinite
                    $container.infinitescroll({
                        navSelector  : '#page_nav',    // selector for the paged navigation 
                        nextSelector : '#page_nav a',  // selector for the NEXT link (to page 2)
                        itemSelector : '.element',     // selector for all items you'll retrieve
                        loading: {
                            finishedMsg: 'No more pages to load.',
                            img: 'http://i.imgur.com/qkKy8.gif'
                        }
                    },
                    // call Isotope as a callback
                    function(newElements) {
                        $container.isotope('appended', $(newElements));
                    });
                }
            });
        });
    })(jQuery);


    // ajaxing the portfolio
    $(function() {
        $('.portfolio-list li.ajax a, #work-ajax a.ajax').live('click', function(event){
            event.preventDefault();
            
            var position = $('#work-ajax').position();
            $('html, body').animate({ scrollTop: position.top }, 500);
            $('#work-ajax').animate({ 'height': 0 }, 1000);
            
            $('#work-ajax').load($(this).attr('href') + ' #work');
            
            $(document).ajaxComplete(function() {
                
                $('.work-slider > .slider').flexslider({
                    animation: "slide",                 //String: Select your animation type, "fade" or "slide"
                    slideshow: true,                    //Boolean: Animate slider automatically
                    slideshowSpeed: 10000,           //Integer: Set the speed of the slideshow cycling, in milliseconds
                    animationDuration: 500,         //Integer: Set the speed of animations, in milliseconds
                    directionNav: true,                 //Boolean: Create navigation for previous/next navigation? (true/false)
                    controlNav: true,                   //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
                    keyboardNav: true,                  //Boolean: Allow slider navigating via keyboard left/right keys
                    prevText: "",               //String: Set the text for the "previous" directionNav item
                    nextText: "",              //String: Set the text for the "next" directionNav item
                    pausePlay: false,                   //Boolean: Create pause/play dynamic element
                    animationLoop: true,                //Boolean: Should the animation loop? If false, directionNav will received "disable" classes at either end
                    pauseOnAction: true,                //Boolean: Pause the slideshow when interacting with control elements, highly recommended.
                    pauseOnHover: true,                //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
                    smoothHeight: true,
                    after: function(){
                        if($('#work-ajax').height() > 0) {
                            $('#work-ajax').animate({ 'height': $('#work').outerHeight() }, 1000);
                        }
                    }
                });

                setTimeout(function(){
                    $('#work-ajax').animate({ 'height': $('#work').outerHeight() }, 1000);
                }, 100);
            });
        });
    });

    // ajaxing the portfolio
    $(function() {
        $('#work-ajax a.work-close').live('click', function(event){
            event.preventDefault();

            $('#work-ajax').animate({ 'height': 0 }, 1000);
        });
    });

    (function($) {
        $('.work-next, .work-prev, .work-close').live('mouseover', function(){
            $(this).find('span').stop().animate({ opacity: 1 }, 100);
        });
        
        $('.work-next, .work-prev, .work-close').live('mouseout', function(){
            $(this).find('span').stop().animate({ opacity: 0 }, 100);
        });
    })(jQuery);

});