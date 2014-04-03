# Configuration

The meta box generator is being set up similar to the admin panel.

```php
<?php
add_theme_support( 'inferno-shortcodes', array(
    'file'               => 'config/shortcodes.php', # relative path to your shortcodes config file from your current theme directory, respects child themes.
    'builtin-shortcodes' => true # whether to activate Inferno built in shortcodes
) );
?>
```

## Config file

The settings for your theme go into the file you have specified when addded theme support for the  (see above). For a complete list of setting fields refer to the [Options Machine][options_machine].

That config file could look like the one in the following (each option type is given once):

```php
<?php

$prefix = "inferno_";


return array(
  array(
    "id"         => "halo_p_settings",
    "title"      => "Halo: Regarding this post / page",
    "post_types" => array( "post", "page" ),
    "context"    => "advanced",
    "priority"   => "default",
    "fields"     => array(
      array(
        "id"    => $prefix . "tagline",
        "title" => "Tagline",
        "desc"  => "Some tagline content for the sub header section.",
        "type"  => "textarea"
      ),
      array(
        "id"    => $prefix . "tagline_quote_by",
        "title" => "Tagline quoted by",
        "desc"  => "If you used some quote for the tagline you may want to include the author. It will look nicely as a quote.",
        "type"  => "text"
      )
    )
  ),
  array(
    "id"         => "halo_inferno_slider",
    "title"      => "Halo: Header module for this page",
    "post_types" => array( "post", "page" ),
    "context"    => "advanced",
    "priority"   => "default",
    "fields"     => array(
      array(
        "id"    => $prefix . "header_type",
        "title" => "Header type",
        "desc"  => "The header module to show on this page.",
        "type"  => "select",
        "std"   => "off",
        "options" => array(
          "off"         => "No extra header module",
          "royalslider" => "Royal Slider",
          "gmaps"       => "Google Maps",
          "image"       => "Static image"
        )
      ),
      array(
        "id"    => $prefix . "royalslider",
        "title" => "Royal Slider",
        "desc"  => "Choose which Royal Slider you want to use on this page. Notice: You need to create sliders in the Royal Slider administration by yourself, before.",
        "type"  => "select",
        "options" => $royalslider_arr
      )
    )
  ),
);

?>
```