# Getting Started

WP-Inferno is designed to be an all in one, drop and play theme plugin. You embed it, call it and configure it just as you need it. Everything is opt-in, so you need to tell WP-Inferno exactly what you want, because by default it doesn't do very much.

Here is an overview about what WP-Inferno is capable of:

* By default WP-Inferno is not more than a collection of useful scripts and styles.
* A powerful admin panel (which can also be used to show your theme settings in demo mode)
* Meta box generator
* Shortcode generator
* Includes also some useful PHP scripts
* Includes a preview class which can generate flip, and fold effects on any images (editable templates)
* 5 widgets (Flickr, Opening Hours, Social profiles, Video)
* Of course supports multilingualism

By that WP-Inferno makes sure you don't need much more than itself to create a professional and powerful WordPress theme with as little effort as ever possible. Also, you don't need to update embedded JavaScripts from other authors by yourself, WP-Inferno takes care of updating sources as often as possible.

## Deployment

All you need to embed WP-Inferno into your WordPress theme is to drop the framework into your theme directory and initiate Inferno with two sweet lines of code like in the following example:

```php
require_once(dirname(__FILE__) . '/Inferno/inferno.php' );
if( !isset( $theme_framework ) ) $theme_framework = new Inferno(true);
```