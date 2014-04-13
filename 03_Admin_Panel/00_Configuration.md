# Configuration

To activate the admin panel at all you need to activate it in your `functions.php`:

```php
<?php
add_theme_support( 'inferno-canvas', array(
    'file'            => 'config/canvas.php', # relative path to your canvas config file from your current theme directory, respects child themes. Required
    'social_profiles' => true, # whether Inferno shall include the default social profiles section
    'backup'          => true, # whether Inferno shall include the default backup section
    'advanced_mode'   => true, # whether you want to enable settings for advanced mode
    'demo_mode'       => true, # whether you want to activate the demo mode
    'demo_account'    => 'demo', # username of the demo account (needs to be created by yourself and have the subscriber role)
    'brand_theme'     => true # whether you want to brand the admin panel with your themes name (Inferno uses the name from the theme style.css)
) );
?>
```

## Demo mode

This is a completely new feature no admin panel out there can provide. Are you eventually tired of creating color and font and whatsoever switcher manually for each theme?

This hassle ends with the demo mode of Inferno. Just turn it on (by creating a subscriber demo account, passing its username to the `demo_account` value of the array and setting `demo_mode` to true) and it will generate the admin panel in the frontend of your WordPress site. Visitors are able to change all settings except uploading files (the settings are not being stored in the database but in user cookies for each visitor separately).

That way, people can change permanently all the settings provided by the theme (which will actually take effect instantly but only single visitors) and though not affect the site itself.


## Advanced mode

The admin canvas provides an advanced functionality. That is, if you mark single option arrays as advanced (by additionally passing `'advanced' => true` to them), these settings will be hidden by default, which can enhance the 
clarity. There is a button which will enable the advanced options and make them visible.


## Config file

The settings for your theme go into the file you have specified when addded theme support for the canvas (see above). For a complete list of setting fields refer to the [Options Machine][options_machine].

That config file could look like the one in the following (each option type is given once):

```php
<?php 
return array( # Begin this with a return statement
  array( # 2nd level array described the canvas sections
    "title" => __("General", "theme_domain"), # well, the title
    "icon"  => "cogs", # you can specify here the icon of the section in the canvas menu. Paste the slug of some Font Awesome slug (without the 'fa-'  )
    "fields" => array(

      array( # this is an example for a CHECKBOX type field
        "id"    => "responsive", # that's the option key to get the value of the setting in the theme
        "title" => __("Responsive layout", "theme_domain"), # remember to provide multilanguage in your theme. People love it.
        "desc"  => __("Wanna mobile?"),
        "std"   => true, # you can set a default value here
        "type"  => "checkbox" # set the type
      ),

      array( # this is an example for a RADIO type field
        "id"      => "logo_type",
        "title"   => __("Logo Type", "theme_domain"),
        "desc"    => __("Image or Text?", 'theme_domain'),
        "std"     => "image", # in these cases it must replicate the value (left side) of some options array field
        "type"    => "radio",
        "options" => array( # options array for the radio buttons. It's value => label
            "image" => __("Image", 'theme_domain'),
            "text"  => __("Text", 'theme_domain')
        )
      ),

      array( # this is an example for a TEXT type field
          "id"    => "contact_gmaps_latitude",
          "title" => "Google Maps Latitude",
          "desc"  => "The Latitude of some map marker.",
          "more"  => "You can get the Latitude of Your adress e.g. <a href='http://itouchmap.com/latlong.html'>here</a>.", # we can have HTML here (and in desc) by the way
          "type"  => "text"
      ),

      array( # this is an example for a TEXTAREA type field
          "title" => __("Copyright", 'theme_domain'),
          "id"    => "copyright",
          "desc"  => __("Copyright ALL THE CONTENTS.", 'theme_domain'),
          "std"   => "You may not copy.",
          "type"  => "textarea"
      )
    )
  ),

  array( # let's have another section
    "title" => "Header",
    "icon" => "rocket",
    "fields" => array(

      array( # this is an example for a FILE type field
        "id"    => "logo_url",
        "title" => __("Logo Image", 'theme_domain'),
        "desc"  => __("Upload it.", 'theme_domain'),
        "type"  => "file"
      ),

      array( # this is an example for a RANGE type field
        "id"    => "logo_image_height",
        "title" => "Logo image height",
        "desc"  => "Slide the slider.",
        "more"  => "It's pixel", # even more description, something like a note maybe?
        "type"  => "range",
        "std"   => "50px",
        "min"   => 0, # it's the minimum value for the range slider
        "max"   => 1000, # it's the maximum value for the range slider
        "unit"  => "px", # append a unit to the setting
        "advanced" => true # make this setting field visible only when advanced mode is activated in the panel
      ),

      array( # this is an example for a SELECT type field
        "id"    => "blog_header_type",
        "title" => "Blog header type",
        "desc"  => "For the space between your navigation and post.",
        "std"   => "none",
        "type"  => "select",
        "options" => array(
          "none"   => "No header module",
          "image"  => "Image header",
          "slider" => "Slider header"
        )
      ),
    )
  ),

  array(
    "title" => __("Custom Style", 'theme_domain'),
    "icon" => "css3",
    "fields" => array(

      array( # this is an example for a COLORPICKER type field
        "title"   => __("Background color", 'theme_domain'),
        "id"      => "bg_color",
        "desc"    => __("Indeed. The background.", 'theme_domain'),
        "std"     => "#ffffff",
        "type"    => "colorpicker"
      ),

      array( # this is an example for a IMAGEPICKER type field
        "title"   => __("Background patterns", 'theme_domain'),
        "id"      => "bg_pattern",
        "desc"    => __("Fancier than just a color.", 'theme_domain'),
        "std"     => "grey",
        "type"    => "imagepicker",
        "options" => array( # remindes of a SELECT or RADIO? That's right.
          "grey"        => get_template_directory_uri() . "/assets/img/pattern/option-grey.png", # remember, the value being stored is on the left
          "cascade"     => get_template_directory_uri() . "/assets/img/pattern/option-cascade.png",
          "reallyfancy" => get_template_directory_uri() . "/assets/img/pattern/option-reallyfancy.png",
          "wood"        => get_template_directory_uri() . "/assets/img/pattern/option-wood.png"
        ),
      ),

      array( # this is an example for a FONT type field
        "id"    => "site_font",
        "title" => __("Global Site Font", "theme_domain"),
        "desc"  => __("One setting to rule all of them.", "theme_domain"),
        "std"   => "Droid Serif", # all the Google Webfonts are available for this setting
        "type"  => "font"
      )
    )
  )
);
?>
```

## Retrieving data

You can retrieve an option value at any time in your theme files. Use `[inferno_get_option()][inferno_get_option]` to do so.



[inferno_get_option]: .manual_root/php_api/function_reference/#inferno_get_option()