jQuery(document).ready(function($) {

    /* ===================================================================
        header slider
    =================================================================== */

    (function($) {
        $('#slideshow .flexslider').flexslider({
            animation: typeof infernal === 'undefined' ? 'fade' : infernal.slider.animation, //String: Select your animation type, "fade" or "slide"
            easing: "swing",                        //{NEW} String: Determines the easing method used in jQuery transitions. jQuery easing plugin is supported!
            direction: 'horizontal', //String: Select the sliding direction, "horizontal" or "vertical"
            reverse: false,                 //{NEW} Boolean: Reverse the animation direction
            animationLoop: true,             //Boolean: Should the animation loop? If false, directionNav will received "disable" classes at either end
            smoothHeight: false,            //{NEW} Boolean: Allow height of the slider to animate smoothly in horizontal mode
            startAt: 0,                     //Integer: The slide that the slider should start on. Array notation (0 = first slide)
            slideshow: true,                //Boolean: Animate slider automatically
            slideshowSpeed: typeof infernal === 'undefined' ? 7000 : infernal.slider.slideshowSpeed,   //Integer: Set the speed of the slideshow cycling, in milliseconds
            animationSpeed: typeof infernal === 'undefined' ? 1000 : infernal.slider.animationSpeed,            //Integer: Set the speed of animations, in milliseconds
            initDelay: 0,                   //{NEW} Integer: Set an initialization delay, in milliseconds
            randomize: false,               //Boolean: Randomize slide order

            // Usability features
            pauseOnAction: true,            //Boolean: Pause the slideshow when interacting with control elements, highly recommended.
            pauseOnHover: false,            //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
            useCSS: true,                   //{NEW} Boolean: Slider will use CSS3 transitions if available
            touch: true,                    //{NEW} Boolean: Allow touch swipe navigation of the slider on touch-enabled devices
            video: true,                   //{NEW} Boolean: If using video in the slider, will prevent CSS3 3D Transforms to avoid graphical glitches

            // Primary Controls
            controlNav: typeof infernal === 'undefined' ? true : infernal.slider.controlNav,    //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
            directionNav: true,             //Boolean: Create navigation for previous/next navigation? (true/false)
            prevText: '<span>Previous</span>',           //String: Set the text for the "previous" directionNav item
            nextText: '<span>Next</span>',               //String: Set the text for the "next" directionNav item

            // Special properties
            controlsContainer: "",          //{UPDATED} Selector: USE CLASS SELECTOR. Declare which container the navigation elements should be appended too. Default container is the FlexSlider element. Example use would be ".flexslider-container". Property is ignored if given element is not found.
            manualControls: "",             //Selector: Declare custom control navigation. Examples would be ".flex-control-nav li" or "#tabs-nav li img", etc. The number of elements in your controlNav should match the number of slides/tabs.
            sync: "",                       //{NEW} Selector: Mirror the actions performed on this slider with another slider. Use with care.
            asNavFor: ""                   //{NEW} Selector: Internal property exposed for turning the slider into a thumbnail navigation for another slider
            //start: fixControlNav,            //Callback: function(slider) - Fires when the slider loads the first slide
            //before: fixControlNav           //Callback: function(slider) - Fires asynchronously with each slider animation
        });

        // clearfix;
        $('#slideshow .slider').append('<div class="clear"></div>');
    })(jQuery);




    /* ===================================================================
        portfolio slider
    =================================================================== */
    (function($) {
        if(typeof infernal != 'undefined') {
            $('#work .slider').flexslider({
                animation: infernal.portfolio.slider.animation,              //String: Select your animation type, "fade" or "slide"
                    easing: "swing",               //{NEW} String: Determines the easing method used in jQuery transitions. jQuery easing plugin is supported!
                    direction: "horizontal",        //String: Select the sliding direction, "horizontal" or "vertical"
                    reverse: false,                 //{NEW} Boolean: Reverse the animation direction
                    animationLoop: true,             //Boolean: Should the animation loop? If false, directionNav will received "disable" classes at either end
                    smoothHeight: true,            //{NEW} Boolean: Allow height of the slider to animate smoothly in horizontal mode
                    startAt: 0,                     //Integer: The slide that the slider should start on. Array notation (0 = first slide)
                    slideshow: true,                //Boolean: Animate slider automatically
                    slideshowSpeed: infernal.portfolio.slider.slideshowSpeed,           //Integer: Set the speed of the slideshow cycling, in milliseconds
                    animationSpeed: infernal.portfolio.slider.animationSpeed,            //Integer: Set the speed of animations, in milliseconds
                    initDelay: 0,                   //{NEW} Integer: Set an initialization delay, in milliseconds
                    randomize: false,               //Boolean: Randomize slide order

                    // Usability features
                    pauseOnAction: true,            //Boolean: Pause the slideshow when interacting with control elements, highly recommended.
                    pauseOnHover: false,            //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
                    useCSS: true,                   //{NEW} Boolean: Slider will use CSS3 transitions if available
                    touch: true,                    //{NEW} Boolean: Allow touch swipe navigation of the slider on touch-enabled devices
                    video: false,                   //{NEW} Boolean: If using video in the slider, will prevent CSS3 3D Transforms to avoid graphical glitches

                    // Primary Controls
                    controlNav: true,               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
                    directionNav: true,             //Boolean: Create navigation for previous/next navigation? (true/false)
                    prevText: '<span>Previous</span>',           //String: Set the text for the "previous" directionNav item
                    nextText: '<span>Next</span>'               //String: Set the text for the "next" directionNav item
            });
        }
    })(jQuery);
});