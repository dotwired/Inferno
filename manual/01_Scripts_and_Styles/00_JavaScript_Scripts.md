# JavaScript Scripts

In the following a list of all JavaScript plugins (which mostly integrate with jQuery). In the beginning of each point there is the alias which you need to call the script.
All scripts which come with WP-Inferno are licensed under [MIT license][license_mit] unless stated otherwise.

* `eventemitter` - [EventEmitter][eventemitter] by Oliver Caldwell
* `iscroll` - [iScroll][iscroll] by Matteo Spinelli
* `jquery-animate-scale` - monkey patch for `jquery-css-transform` by Zachary Johnson
* `jquery-blur` - [Blur.js][jquery-blur] by Jakiestfu
* `jquery-colorbox` - [Colorbox][jquery-colorbox] by Jack Moore
* `jquery-colorpicker` - [Colorpicker][jquery-colorpicker] by Stefan Petre
* `jquery-cookie` - [Cookie][jquery-cookie] by Klaus Hartl
* `jquery-confirm` - Confirm by Nadia Alramli
* `jquery-css-transform` - [CSS Transform][jquery-css-transform] by Zachary Johnson
* `jquery-easing` - [jQuery Easing][jquery-easing] by George McGinley Smith under the [BSD licence][license_bsd]
* `jquery-fitvids` - [FitVids.js][jquery-fitvids] by Chris Coyier under the [WTFPL license][license_wtfpl]
* `jquery-flexslider` - [FlexSlider][jquery-flexslider] by [WooThemes][woothemes] under the [GPL license][lisence_gpl] (version 2)
* `jquery-hoverintent` - [hoverIntent][jquery-hoverintent] by Brian Cherne
* `jquery-image-picker` - [Image Picker][jquery-image-picker] by Rodrigo Vera
* `jquery-imagesloaded` - [imagesLoaded][jquery-imagesloaded] by David DeSandro
* `jquery-infinitescroll` - [Infinite Scroll][jquery-infinitescroll] by Paul Irish & Luke Shumard
* `jquery-infinitescroll-behavior-local` - [Infinite Scroll local behavior][jquery-infinitescroll] by Paul Irish & Luke Shumard
* `jquery-isotope` - [Isotope][jquery-isotope] by David DeSandro under MIT license **only for non-commercial, personal or open source projects and applications, otherwise you need to [purchase the commercial license][isotope-commercial]**
* `jquery-jscrollpane` - [jScrollPane][jquery-jscrollpane] by Kelvin Luck
* `jquery-magnific-popup` - [Magnific Popup][jquery-magnific-popup] by Dmitry Semenov
* `jquery-mousewheel` - [Mouse Wheel][jquery-mousewheel] by Brandon Aaron 
* `jquery-perfect-scrollbar` - [perfect-scrollbar][jquery-perfect-scrollbar] by HyeonJe Jun
* `jquery-pjax` - [Pjax][jquery-pjax] by Chris Wanstrath
* `jquery-placeholder` - [HTML5 Placeholder][jquery-placeholder] by Mathias Bynens
* `jquery-rotate` - monkey patch for `jquery-css-transform` by Zachary Johnson
* `jquery-scrollto` - [ScrollTo][jquery-scrollto] by Ariel Flesler
* `jquery-superfish` - [SuperFish][jquery-superfish] by Joel Birch
* `jquery-tinynav` - [TinyNav.js][jquery-tinynav] by Viljami Salminen
* `modernizr` - [Modernizr][modernizr] by the Modernizr team
* `responsive-nav` - [Responsive Nav][responsive-nav] by Viljami Salminen

You can call any of these scripts by their aliases with the [`wp_enqueue_script()`][wp_enqueue_script]-function of WordPress in your themes [functions.php][functions.php] like simply:

```php
wp_enqueue_script("modernizr");
```

## Acknowledgments

At this point I personally want to thank all script authors who are doing such a great job in providing useful scripts for free to other people and make possible for others to create further great projects and products. Be assured that I am planning and working towards rewarding you for this invaluable work.

[license_mit]: http://opensource.org/licenses/MIT
[license_gpl]: http://www.gnu.org/licenses/gpl.html
[license_bsd]: http://opensource.org/licenses/BSD-3-Clause
[license_wtfpl]: http://www.wtfpl.net/about/

[eventemitter]: https://github.com/Wolfy87/EventEmitter
[iscroll]: https://github.com/cubiq/iscroll
[jquery-animate-scale]: https://github.com/zachstronaut/jquery-animate-css-rotate-scale/
[jquery-blur]: https://github.com/jakiestfu/Blur.js
[jquery-colorbox]: https://github.com/jackmoore/colorbox
[jquery-colorpicker]: http://www.eyecon.ro/colorpicker/
[jquery-cookie]: https://github.com/carhartl/jquery-cookie
[jquery-css-transform]: https://github.com/zachstronaut/jquery-css-transform
[jquery-easing]: https://github.com/gdsmith/jquery.easing
[jquery-fitvids]: https://github.com/davatron5000/FitVids.js
[jquery-flexslider]: https://github.com/woothemes/FlexSlider
[jquery-hoverintent]: https://github.com/briancherne/jquery-hoverIntent
[jquery-image-picker]: https://github.com/rvera/image-picker
[jquery-imagesloaded]: https://github.com/desandro/imagesloaded
[jquery-infinitescroll]: https://github.com/paulirish/infinite-scroll
[jquery-isotope]: https://github.com/desandro/isotope
[isotope-commercial]: http://isotope.metafizzy.co/docs/license.html
[jquery-jscrollpane]: https://github.com/vitch/jScrollPane
[jquery-magnific-popup]: https://github.com/dimsemenov/Magnific-Popup
[jquery-mousewheel]: https://github.com/brandonaaron/jquery-mousewheel
[jquery-perfect-scrollbar]: https://github.com/noraesae/perfect-scrollbar 
[jquery-pjax]: https://github.com/mathiasbynens/jquery-placeholder
[jquery-placeholder]: https://github.com/mathiasbynens/jquery-placeholder
[jquery-scrollto]: https://github.com/flesler/jquery.scrollTo
[jquery-superfish]: https://github.com/joeldbirch/superfish/
[jquery-tinynav]: https://github.com/viljamis/TinyNav.js
[modernizr]: https://github.com/Modernizr/Modernizr
[responsive-nav]: https://github.com/viljamis/responsive-nav.js

[woothemes]: http://www.woothemes.com/

[wp_enqueue_script]: http://codex.wordpress.org/Function_Reference/wp_enqueue_script
[functions.php]: http://codex.wordpress.org/Functions_File_Explained