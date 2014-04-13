# Configuration

The meta box generator is being set up similar to the admin panel.

```php
<?php
add_theme_support( 'inferno-meta-box', array(
    'file' => 'config/meta-boxes.php' # relative path to your meta box config file from your current theme directory, respects child themes
) );
?>
```

## Config file

The settings for your theme go into the file you have specified when addded theme support for the  (see above). For a complete list of setting fields refer to the [Options Machine][options_machine]. 

**Note** there is no [advanced functionality][canvas_advanced] for the meta box generator.

That config file could look like the one in the following (each option type is given once). See [add_meta_box()][codex_add_meta_box()] for explanation of the first level array keys (which are `id`, `title`, `post_types`, `context` and `priority`).

```php
<?php
$prefix = "inferno_"; # it makes sense to add a prefix to all settings to prevent duplicate option ids

return array(
  array(
    "id"         => "theme_tagline", # see http://codex.wordpress.org/Function_Reference/add_meta_box for this and following keys until 'fields' key
    "title"      => "Tagline",
    "post_types" => array( "post", "page" ),
    "context"    => "advanced", # Note, this is not the advanced functionality provided by the Inferno admin panel
    "priority"   => "default",
    "fields"     => array(
      array(
        "id"    => $prefix . "tagline_switch",
        "title" => "Tagline switch",
        "desc"  => "Turn on or off.",
        "type"  => "checkbox",
        "std"   => false
      ),
      array(
        "id"    => $prefix . "tagline",
        "title" => "Tagline content",
        "desc"  => "Some tagline content for the sub header section.",
        "type"  => "textarea"
      ),
      array(
        "id"    => $prefix . "tagline_quote_by",
        "title" => "Tagline quoted by",
        "desc"  => "Who said this?",
        "type"  => "text"
      ),
      array(
        "id"    => $prefix . "tagline_font",
        "title" => "Tagline font",
        "desc"  => "The look.",
        "type"  => "font"
      ),
      array(
        "id"    => $prefix . "tagline_font_color",
        "title" => "Tagline font color",
        "desc"  => "The color.",
        "type"  => "color"
      ),
      array(
        "id"    => $prefix . "tagline_font_size",
        "title" => "Tagline font size",
        "desc"  => "The font size.",
        "type"  => "range",
        "std"   => "20px",
        "min"   => 10,
        "max"   => 30,
        "unit"  => "px"
      )
    )
  ),
  array(
    "id"         => "theme_header",
    "title"      => "Theme header",
    "post_types" => array( "post" ),
    "context"    => "advanced",
    "priority"   => "default",
    "fields"     => array(
      array(
        "id"    => $prefix . "header_type",
        "title" => "Header type",
        "desc"  => "What do you want to show in the header?",
        "type"  => "radio",
        "std"   => "off",
        "options" => array(
          "off"         => "No extra header module",
          "slider"      => "Slider",
          "gmaps"       => "Google Maps",
          "image"       => "Static image"
        )
      ),
      array(
        "id"    => $prefix . "slider",
        "title" => "Slider type",
        "desc"  => "Chose the slider",
        "type"  => "select",
        "options" => array(
          "slider_royal" => "Royal Slider",
          "slider_nivo" => "Nivo Slider",
          "slider_flex" => "Flex Slider"
        )
      )
    )
  ),
);
?>
```

[codex_add_meta_box()]: http://codex.wordpress.org/Function_Reference/add_meta_box
[class_inferno_preview]: .manual_root/admin_panel/configuration/#Advanced_mode