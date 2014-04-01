# Getting Started

WP-Inferno is designed to be a full featured, all in one, drop and play theme framework. You embed it, call it and configure it just as you need it. Everything is opt-in, so you need to tell WP-Inferno exactly what you want, because by default it doesn't do very much.

Here is an overview about what WP-Inferno is capable of:

* By default WP-Inferno is not more than a collection of useful scripts and styles.
* A powerful and **responsive** admin panel (which can also be used to show your theme settings in demo mode)
* Meta box generator
* Shortcode generator
* Includes also some useful PHP scripts
* Includes a preview class which can generate flip, and fold effects on any images (editable templates)
* 5 widgets (Flickr, Opening Hours, Social profiles, Video)
* Of course supports multilingualism

By that WP-Inferno makes sure you don't need much more than itself to create a professional and powerful WordPress theme with as little effort as ever possible. Also, you don't need to update embedded JavaScripts from other authors by yourself, WP-Inferno takes care of updating sources as often as possible.

## Opt in the features you need

Inferno doesn't include much if you don't opt into the features and functions you need. This allows to keep your theme as performant and quick as possible, without needless additional load, at least not added by Inferno.

You need to opt in the features you want before you initialize Inferno itself. Use the WordPress native [`add_theme_support()`][add_theme_support]-function to do so.
Here is a quick and dirty example of how a theme could incorporate Inferno:

```php
<?php
add_theme_support( 'inferno-canvas', array(
    'file'            => 'config/canvas.php', # relative path to your canvas config file from your current theme directory, respects child themes
    'social_profiles' => true, # whether Inferno shall include the default social profiles section
    'backup'          => true, # whether Inferno shall include the default backup section
    'advanced_mode'   => true, # whether you want to enable settings for advanced mode
    'demo_mode'       => true, # whether you want to activate the demo mode
    'demo_account'    => 'demo', # username of the demo account (needs to be created by yourself)
    'brand_theme'     => true # whether you want to brand the admin panel with your themes name (Inferno uses the name from the theme style.css)
) );
add_theme_support( 'inferno-shortcodes', array(
    'file'               => 'config/shortcodes.php', # relative path to your shortcodes config file from your current theme directory, respects child themes
    'builtin-shortcodes' => true # whether to activate Inferno built in shortcodes
) );
add_theme_support( 'inferno-meta-box', array(
    'file' => 'config/meta-boxes.php' # relative path to your meta box config file from your current theme directory, respects child themes
) );
add_theme_support( 'inferno-templates', array(
    'recent_posts' => 'inferno-templates/recent-posts.php', # relative path to your recent posts template
    'preview' => 'inferno-templates/preview.php', # relative path to your default preview template
    'preview_flip' => 'inferno-templates/preview-flip.php', # relative path to your flip effect preview template
) );
add_theme_support( 'inferno-portfolio' ); # add this to enable the Inferno Portfolio
?>
```

## Deployment / Installation

In the and, all you need to embed WP-Inferno into your WordPress theme is to drop the framework into your theme directory and initiate Inferno with two sweet lines of code like in the following example:

```php
<?php
require_once(dirname(__FILE__) . '/Inferno/inferno.php' );
if( !isset( $theme_framework ) ) $theme_framework = new Inferno(true);
?>
```

That's basically it. Now go and configure the hell out of your theme.


[add_theme_support]: http://codex.wordpress.org/Function_Reference/add_theme_support