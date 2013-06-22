WordPress Inferno Framework.
===

The idea
---

WordPress [Theme Frameworks](http://codex.wordpress.org/Theme_Frameworks), as well as they're written and as awesome as they work, are always doing too much for the user, require You to deal with them too long or do not provide enough features. In fact, there has been no perfect theme framework (until now, hehe), so most theme authors are even more motivated to make the huge effort to write an own framework than to use the available ones.

That's where Inferno joins in. Inferno provides a wide amount of pre built features with consistent syntax, yet it's up to You whether You want to use these features or not. Basically, Inferno will extend the script library of Your WordPress with commonly used scripts like `jquery-superfish` or `modernizr`. That's it. *If* You want more, just activate a highly customizable and advanced Options Panel. Or the Shortcode Generator. Or a custom Meta Box. And best (apart from the fact that Inferno is completely free) about this is that all three modules use the same Options Machine (that's how I call the Engine behind the form generator), so the syntax for creating option fields in the Options Panel, the Shortcode Generator and the Meta Box are almost identically.

Also have a look at the [Inferno YouTube playlist](http://www.youtube.com/playlist?list=PLsnqaZZSZarrVUj4G2CABrB0LMycRcfph) where I am going to periodically publish screencasts.


Installation
---

Download Inferno and drop it in Your theme directory. Paste the following code in the functions.php of Your theme:
```php
require_once( dirname( __FILE__ ) . '/Inferno/inferno.php' );
new Inferno();
```
That's basically it. 



Features
---

- Handle all Your generous Scripts and Styles from one point. Inferno registers a bunch of popular Scripts. All You have to do is to enqueue them where needed
    - Extends WordPress by the following Scripts (name is followed by the script handler):
        - Colorbox (`jquery-colorbox`)
        - Colorpicker (`jquery-colorpicker`)
        - Cookie (`jquery-cookie`)
        - Confirm (`jquery-confirm`)
        - CSS Transform (`jquery-css-transform`)
        - Easing (`jquery-easing`)
        - FitVids (`jquery-fitvids`)
        - Flexslider (`jquery-flexslider`)
        - HoverIntent (`jquery-hoverintent`)
        - ImagesLoaded (`jquery-imagesloaded`)
        - InfiniteScroll (`jquery-infinitescroll`)
        - Placeholder (`jquery-placeholder`)
        - Rotate (`jquery-rotate`)
        - Scrollto (`jquery-scrollto`)
        - Superfish (`jquery-superfish`)
        - Tinynav (`jquery-tinynav`)
        - Tweet (`jquery-tweet`)
        - Modernizr (`modernizr`)
        - ResponsiveNav (`responsive-nav`)
    - And by the following Styles (name is followed by the style handler): 
        - [normalize](https://github.com/necolas/normalize.css) (`normalize`)
        - structurize (`structurize`) - a custom stylesheet which provides columning stylings (e.g. .one-half, .one-half.last, etc.) and other helpful structure styling for websites
        - wpstyles (`wpstyles`) - provides minimal and extendable (but already stylish) styles for WordPress native elements and classes (e.g. Gallery, Image Captions, alignment classes, etc.)
        - [Font-Awesome](http://fortawesome.github.io/Font-Awesome/) (`font-awesome`)
- An advanced Options Panel, Shortcode Generator and Meta Box, all configured in the same way and providing following formular elements: `text`, `textarea` `select`, `radio`, `radio-image`, `font`, `range`, `spinner`, `image`, `colorpicker`
- Some cool widgets:
    - Opening hours
    - Flickr
    - Recent tweets
    - Social counter
    - Social profiles
    - Responsive video
- Missing something? Open an issue.


Coming soon
---

- breadcrumbs navigation



Changelog
---

- **v0.9**
    - Initial release