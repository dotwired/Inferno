# Configuration

To activate the admin panel at all you need to activate it in your `functions.php`:

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
?>
```


## Config file

The settings for your theme go into the file you have specified when addded theme support of the canvas (see above). For a complete list of setting fields refer to the [Options Machine][options_machine].

That config file could look like the one in the following (each option type is given once):

```php
<?php 
return array( # Begin this with a return statement
  array( # 2nd level array described the canvas sections
    "title" => __("General", "theme_domain"), # well, the title
    "icon"  => "cogs", # you can specify here the icon of the section in the canvas menu. Paste the slug of some Font Awesome slug (without the 'fa-'  )
    "fields" => array(
      array(
        "id"    => "responsive", # that's the option key to get the value of the setting in the theme
        "title" => __("Responsive layout", "theme_domain"), # remember to provide multilanguage in your theme. People love it.
        "desc"  => __("Wanna mobile?"),
        "std"   => true, # you can set a default value here
        "type"  => "checkbox" # set the type
      ),

      array(
        "id"      => "logo_type",
        "title"   => __("Logo Type", "theme_domain"),
        "desc"    => __("Image or Text?", 'theme_domain'),
        "std"     => "image",
        "type"    => "radio",
        "options" => array( # options array for the radio buttons. It's value => label
            "image" => __("Image", 'theme_domain'),
            "text"  => __("Text", 'theme_domain')
        )
      ),
      
      array(
        "id"    => "logo_url",
        "title" => __("Logo Image", 'theme_domain'),
        "desc"  => __("Upload it.", 'theme_domain'),
        "type"  => "file"
      ),
    )
  ),

array(
  "title" => "Frontpage",
  "icon" => "desktop",
  "fields" => array(
      array(
          "title" => __("Frontpage: Show Latest Blogpost under the portfolio works", 'theme_domain'),
          "id"    => "front_recentpost",
          "desc"  => __("Do You want to show the latest blogpost right under the recent portfolio works on the frontpage template? Notice, that you have to define a featured blogpost image, then (Halo Theme will catch the latest blogpost with such an image).", 'theme_domain'),
          "std"   => true,
          "type"  => "checkbox"
      )
  )
),

array(
  "title" => "Header",
  "icon" => "rocket",
  "fields" => array(
      array(
          "id"    => "logo_image_header",
          "title" => "Logo image",
          "desc"  => "If you've chosen an image logo you can upload here the image.",
          "type"  => "media"
      ),
      array(
          "id"    => "logo_image_height",
          "title" => "Logo image height",
          "desc"  => "If you've chosen an image logo you can specify the height of it here (width will be calculated accordingly).",
          "more"  => "Requires custom stylesheet to be enabled.",
          "type"  => "range",
          "std"   => "50px",
          "min"   => 0,
          "max"   => 1000,
          "unit"  => "px"
      ),
      array(
          "id"    => "slogan_header",
          "title" => "Show slogan in the header",
          "desc"  => "Whether you want to show your blog slogan next to your logo.",
          "std"   => "yes",
          "type"  => "radio",
          "options" => array(
              "yes" => "Yes",
              "no"  => "No",
              "test" => "bla"
          )
      ),
      array(
          "id"    => "nav_search",
          "title" => "Navigation search",
          "desc"  => "Do you want to enable the search in the navigation bar?",
          "std"   => "yes",
          "type"  => "radio",
          "options" => array(
              "yes" => "Yes",
              "no"  => "No"
          )
      ),
      array(
          "id"    => "header_image_type",
          "title" => "Header image type",
          "desc"  => "Wether images shall be stretched on the full width, inherit its original width or have a procentual width (if third case, please set the next option to the desired width).",
          "std"   => "orig",
          "type"  => "radio",
          "options" => array(
              "full"       => "Full width",
              "orig"       => "Original width",
              "procentual" => "Procentual width"
          ),
          "advanced" => true
      ),
      array(
          "id"    => "header_image_size",
          "title" => "Procentual header image size",
          "desc"  => "The procentual width of the image in the header module.",
          "std"   => "100",
          "type"  => "range",
          "min"   => "0",
          "max"   => "100",
          "unit"  => "%",
          "advanced" => true
      ),
  )
),

array(
  "title"  => "Blog",
  "icon"   => "book",
  "fields" => array(
      array(
          "title" => __("Article featured image on Listings", 'theme_domain'),
          "id"    => "blog_preview_images",
          "desc"  => __("Show the featured image on the Post Listing Templates (Post Overview, Archives, Categories, ...)?", 'theme_domain'),
          "std"   => true,
          "type"  => "checkbox"
      ),
      
      array(
          "title" => __("Article featured image on Single Post", 'theme_domain'),
          "id"    => "blog_post_preview_images",
          "desc"  => __("Show the featured image on the Single Post View?", 'theme_domain'),
          "std"   => true,
          "type"  => "checkbox"
      ),
      array(
          "id"    => "blog_header_type",
          "title" => "Blog header type",
          "desc"  => "You can set which type of header you want to use on blog pages (including category or index listings, excluding single posts).",
          "std"   => "none",
          "type"  => "select",
          "options" => array(
              "none"   => "No header module",
              "image"  => "Image header",
              "slider" => "Slider header"
          )
      ),
      array(
          "id"    => "blog_header_img",
          "title" => "Blog header image",
          "desc"  => "You can upload an image here which you want to appear in the image header module.",
          "type"  => "media"
      ),
      array(
          "id"    => "blog_sidebar",
          "title" => "Blog sidebar",
          "desc"  => "Which layout should be used for the blog (this includes all blog related pages like single posts or category listings)?",
          "std"   => "left",
          "type"  => "select",
          "options" => array(
              "right"  => "Sidebar on the right",
              "left"   => "Sidebar on the left",
              "off"    => "No sidebar (full width)"
          )
      ),
      array(
          "id"    => "blog_index_excerpt",
          "title" => "Blog index excerpt",
          "desc"  => "Do you want the excerpt on post listing pages like the blog index to be shortened automatically or manually with the &lt;!-- more --&gt; tag?",
          "std"   => "the_excerpt",
          "type"  => "radio",
          "options" => array(
              "the_excerpt" => "Yes",
              "the_content"  => "No"
          )
      ),
      array(
          "id"    => "blog_show_tags",
          "title" => "Show post tags",
          "desc"  => "Whether you want to show post tags or not in the post meta information.",
          "std"   => "yes",
          "type"  => "radio",
          "options" => array(
              "yes" => "Yes",
              "no"  => "No"
          )
      ),
      array(
          "id"    => "blog_show_categories",
          "title" => "Show post categories",
          "desc"  => "Whether you want to show post categories or not in the post meta information.",
          "std"   => "yes",
          "type"  => "radio",
          "options" => array(
              "yes" => "Yes",
              "no"  => "No"
          )
      ),
      array(
          "id"    => "blog_show_author",
          "title" => "Show post author",
          "desc"  => "Whether you want to show the post author or not in the post meta information.",
          "std"   => "yes",
          "type"  => "radio",
          "options" => array(
              "yes" => "Yes",
              "no"  => "No"
          )
      ),
  )
),

array(
  "title" => "Portfolio",
  "icon"  => "camera",
  "fields" => array(
      array(
          "title"   => __("Single Work display", 'theme_domain'),
          "id"      => "portfolio_display",
          "desc"    => __("Do You want to present Your single work the classic way on a single URL (site) or do You want to use the unique scrolling view?", 'theme_domain'),
          "std"     => "single",
          "type"    => "radio",
          "options" => array(
              "single" => __("Single Page", 'theme_domain'),
              "scroll" => __("Scroll View", 'theme_domain')
          ),  
      ),
      array(
          "title"   => __("Maximum count of images per work", 'theme_domain'),
          "id"      => "portfolio_max_img_per_work",
          "desc"    => __("How many images have your works at maximum?", 'theme_domain'),
          "std"     => 3,
          "type"    => "range",
          "min"     => 0,
          "max"     => 20
      ),
      array(
          "title"   => __("Mark new works as 'New'", 'theme_domain'),
          "id"      => "new_work_days",
          "desc"    => __("Do You want to mark new works as new? If so, select after how many days a work still should be marked.", 'theme_domain'),
          "std"     => 7,
          "type"    => "range",
          "min"     => 0,
          "max"     => 365
      ),
      array(
          "id"    => "portfolio_img_width",
          "title" => "Image width in the portfolio",
          "desc"  => "Basically needed to define the ratio of the images (with the image height option below) and quality of the images.",
          "type"  => "range",
          "min"   => 100,
          "max"   => 500,
          "std"   => 200
      ),
      array(
          "id"    => "portfolio_img_height",
          "title" => "Image width in the portfolio",
          "desc"  => "Basically needed to define the ratio of the images (with the image width option above) and quality of the images.",
          "type"  => "range",
          "min"   => 100,
          "max"   => 500,
          "std"   => 200
      ),
      array(
          "id"      => "portfolio_effect",
          "title"   => "Portfolio hover effect",
          "desc"    => "What effect do you want to use on the images?",
          "std"     => "default",
          "type"    => "select",
          "options" => array(
              "default" => "Default",
              "fold"    => "Fold effect",
              "flip"    => "Flip effect"
          )
      ),
      array(
          "id"    => "portfolio_link",
          "title" => "Portfolio link",
          "desc"  => "Where do you want to link on image click?",
          "std"   => "media",
          "type"  => "select",
          "options" => array(
              "media" => "Link directly to image source",
              "post"  => "Link to the portfolio post type page"
          )
      ),
      array(
          "id"    => "portfolio_lightbox",
          "title" => "Portfolio lightbox",
          "desc"  => "Do you want to use a lightbox in the portfolio? This is going to work only, if the portfolio link option is set to link directly on the image source.",
          "std"   => "true",
          "type"  => "select",
          "options" => array(
              "true" => "Use lightbox",
              "false"  => "Don't use lightbox"
          )
      )
  )
),

array(
  "title" => "Contact",
  "icon" => "map-marker",
  "fields" => array(
      array(
          "id"      => "contact_gmaps_width",
          "title"   => "Google Maps width",
          "desc"    => "Which width shall the Google Map have on Your contact page?",
          "std"     => "wide",
          "type"    => "radio",
          "options" => array(
              "wide" => "Wide",
              "slim" => "Slim"
          )
      ),
      array(
          "id"    => "contact_gmaps_latitude",
          "title" => "Google Maps Latitude",
          "desc"  => "The Latitude of the Google Maps marker.",
          "more"  => "You can get the Latitude of Your adress e.g. <a href='http://itouchmap.com/latlong.html'>here</a>.",
          "type"  => "text"
      ),
      array(
          "id"    => "contact_gmaps_longitude",
          "title" => "Google Maps Longitude",
          "desc"  => "The Longitude of the Google Maps marker.",
          "more"  => "You can get the Longitude of Your adress e.g. <a href='http://itouchmap.com/latlong.html'>here</a>.",
          "type"  => "text"
      ),
      array(
          "id"    => "contact_gmaps_zoom",
          "title" => "Google Maps Zoom Level",
          "desc"  => "Determines the detail of the Google Maps.",
          "type"  => "range",
          "min"   => 1,
          "max"   => 20,
          "std"   => 12
      ),
      array(
          "id"    => "contact_gmaps_scrollwheel",
          "title" => "Google Maps Scrollwheel",
          "desc"  => "Shall using the scrollwheel above the map zoom in / out the map?",
          "type"  => "radio",
          "std"   => "no",
          "options" => array(
              "yes" => "Yes",
              "no"  => "No"
          )
      ),
  )
),

array(
  "title" => "Footer",
  "icon" => "anchor",
  "fields" => array(
      array(
          "id"    => "logo_image_footer",
          "title" => "Logo Image",
          "desc"  => "If You've chosen an image logo You can upload here the image.",
          "type"  => "media"
      ),
      array(
          "title" => __("Copyright", 'theme_domain'),
          "id"    => "copyright",
          "desc"  => __("Here comes the footer text. May contain basic HTML markup.", 'theme_domain'),
          "std"   => "Halo Theme by Indiapart.",
          "type"  => "textarea"
      )
  )
),


array(
  "title" => __("Basic Style", 'theme_domain'),
  "icon" => "compass",
  "fields" => array(
      array(
          "id"      => "header_style",
          "title"   => __("Header style", "theme_domain"),
          "desc"    => __("Do you want to activate header decoration lines?", "theme_domain"),
          "type"    => "checkbox",
          "std"     => true
      ),
      array(
          "id"      => "footer_style",
          "title"   => __("Footer style", "theme_domain"),
          "desc"    => __("Decide whether you want the footer to be displayed boxed or in full width.", "theme_domain", "theme_domain"),
          "type"    => "radio",
          "std"     => "fullwidth",
          "options" => array(
              "boxed"     => "Boxed footer",
              "fullwidth" => "Full width footer"
          )
      ),
      array(
          "id"    => "box_shadow",
          "title" => __("Content area drop shadow", "theme_domain"),
          "desc"  => __("Activate shadow on the content box.", "theme_domain"),
          "type"  => "checkbox",
          "std"   => false
      ),
  )
),

array(
  "title" => __("Custom Style", 'theme_domain'),
  "icon" => "css3",
  "fields" => array(
      array(
          "id"    => "custom_css",
          "title" => __("Custom CSS file", "theme_domain"),
          "desc"  => __("Do You want to load an aditional CSS file, which will allow you to style the theme itself by the options provided in this panel?", "theme_domain"),
          "more"  => __("All options in the 'fonts' and the 'style' section of this admin panel are meant to be working only with this option activated.", "theme_domain"),
          "type"  => "checkbox",
          "std"   => false
      ),

      array(
          "title"   => __("Background color", 'theme_domain'),
          "id"      => "bg_color",
          "desc"    => __("Choose the background color.", 'theme_domain'),
          "more"    => __("Only, if the option below is deactivated.", 'theme_domain'),
          "std"     => "#ffffff",
          "type"    => "colorpicker"
      ),

      array(
          "id"    => "bg_pattern_switch",
          "title" => __("Use pattern as background", 'theme_domain'),
          "desc"  => __("If you want to use the option below you need to turn this option on. Otherwise the background color option above will take effect.", 'theme_domain'),
          "type"  => "checkbox",
          "std"   => false
      ),

      // settings for the style options
      array(
          "title"   => __("Background patterns", 'theme_domain'),
          "id"      => "bg_pattern",
          "desc"    => __("Choose a pattern for the background.", 'theme_domain'),
          "std"     => "grey1",
          "type"    => "imagepicker",
          "options" => array( 
              "grey1"    => get_template_directory_uri() . "/assets/img/pattern/option-grey1.png",
              "grey2"    => get_template_directory_uri() . "/assets/img/pattern/option-grey2.png",
              "grey3"    => get_template_directory_uri() . "/assets/img/pattern/option-grey3.png",
              "wood1"    => get_template_directory_uri() . "/assets/img/pattern/option-wood1.png",
              "wood2"    => get_template_directory_uri() . "/assets/img/pattern/option-wood2.png",
              "wood3"    => get_template_directory_uri() . "/assets/img/pattern/option-wood3.png",
              "wood4"    => get_template_directory_uri() . "/assets/img/pattern/option-wood4.png",
              "caro"     => get_template_directory_uri() . "/assets/img/pattern/option-caro.png",
              "white"    => get_template_directory_uri() . "/assets/img/pattern/option-white.png",
              "dark1"    => get_template_directory_uri() . "/assets/img/pattern/option-dark1.png",
              "dark2"    => get_template_directory_uri() . "/assets/img/pattern/option-dark2.png",
              "traffic1" => get_template_directory_uri() . "/assets/img/pattern/option-traffic1.png",
              "traffic2" => get_template_directory_uri() . "/assets/img/pattern/option-traffic2.png"
          ),
      )
  )
),

array(
  "title" => "Fonts",
  "icon" => "edit",
  "fields" => array(
      array(
          "id"    => "site_font",
          "title" => __("Global Site Font", "theme_domain"),
          "desc"  => __("Choose a font for all texts on your Website excluding the Logo Font.", "theme_domain"),
          "std"   => "Droid Serif",
          "type"  => "font"
      ),
      array(
          "id"    => "site_font_size",
          "title" => __("Site text size", "theme_domain"),
          "desc"  => __("How large all texts shall be relatively be.", "theme_domain"),
          "std"   => "16px",
          "type"  => "range",
          "min"   => "6",
          "max"   => "200",
          "unit"  => "px"
      ),
      array(
          "id"    => "site_font_color",
          "title" => __("Common content text color", "theme_domain"),
          "desc"  => __("Choose color for your global site text.", "theme_domain"),
          "std"   => "#000000",
          "type"  => "colorpicker"
      ),

      array(
          "title"   => __("Logo Font", 'theme_domain'),
          "id"      => "font_logo",
          "desc"    => __("Which Font do You want to use for Your Logo?", 'theme_domain'),
          "more"    => __("Requires You to select Text Logo in the General settings.", 'theme_domain'),
          "std" => "georgia",
          "type"    => "font"
      ),
      array(
          "title" => __("Logo Font Size", 'theme_domain'),
          "id"    => "logo_font_size",
          "desc"  => __("Which Font Size do You want to use for Your Logo?", 'theme_domain'),
          "more"  => __("Only, if You selected Text Logo in the General settings.", 'theme_domain'),
          "std"   => "35px",
          "type"  => "range",
          "min"   => "5",
          "max"   => "70",
          "unit"  => "px"
      ),
      array(
          "title"   => __("Logo Font Color", 'theme_domain'),
          "id"      => "logo_font_color",
          "desc"    => __("Which Font Color do You want to use for Your Logo?", 'theme_domain'),
          "more"    => __("Only, if You selected Text Logo in the General settings.", 'theme_domain'),
          "std"     => "#000000",
          "type"    => "colorpicker"
      ),

      array(
          "title" => __("Slogan Font", 'theme_domain'),
          "id"    => "slogan_font",
          "desc"  => __("Which Font do You want to use for Your Slogan?", 'theme_domain'),
          "std"   => "Georgia",
          "type"  => "font"
      ),
      array(
          "title" => __("Slogan Font Size", 'theme_domain'),
          "id"   => "slogan_font_size",
          "desc" => __("Which Font Size do You want to use for Your Slogan?", 'theme_domain'),
          "std"  => "12px",
          "type" => "range",
          "min"  => "5",
          "max"  => "25",
          "unit" => "px"
      ),
      array(
          "id"    => "slogan_font_color",
          "title" => __("Color for slogan", 'theme_domain'),
          "desc"  => __("Choose the color of the slogan text.", 'theme_domain'),
          "std"   => "#ffffff",
          "type"  => "colorpicker"
      ),


      array(
          "title" => __("Navigation Font", 'theme_domain'),
          "id"    => "nav_font",
          "desc"  => __("Which Font do You want to use for Your Navigation?", 'theme_domain'),
          "std"   => "georgia",
          "type"  => "font"              
      ),
      array(
          "title" => __("Navigation Font Size", 'theme_domain'),
          "id"    => "nav_font_size",
          "desc"  => __("Which Font Size do You want to use for Your Navigation?", 'theme_domain'),
          "std"   => "14px",
          "type"  => "range",
          "min"   => "5",
          "max"   => "20",
          "unit"  => "px"
      ),
      array(
          "title" => __("Navigation Font Color", 'theme_domain'),
          "id"    => "nav_font_color",
          "desc"  => __("Which Font Color do You want to use for Your Navigation?", 'theme_domain'),
          "std"   => "#666666",
          "type"  => "colorpicker"
      ),
      array(
          "title"  => __("Navigation Font Hover and Active Color", 'theme_domain'),
          "id"     => "nav_font_color_hover",
          "desc"   => __("Which Font Color do You want to use for hovered links in Navigation?", 'theme_domain'),
          "std"    => "#000",
          "type"   => "text",
          "extend" => "colorpicker"
      ),

      array(
          "title" => __("Tagline Font", 'theme_domain'),
          "id"    => "tagline_font",
          "desc"  => __("Which Font do You want to use in the Tagline?", 'theme_domain'),
          "std"   => "georgia",
          "type"  => "font"
      ),
      array(
          "title" => __("Tagline Font Size", 'theme_domain'),
          "id"    => "tagline_font_size",
          "desc"  => __("Which Font Size do You want to use in the Tagline?", 'theme_domain'),
          "more"  => __("This will enlarge (value is bigger than 1) / reduce (value is smaller than 1) the Font size in the area relatively.", 'theme_domain'),
          "std"   => "21px",
          "type"  => "range",
          "min"   => "5",
          "max"   => "35",
          "unit"  => "px"
      ),
      array(
          "title" => __("Tagline Font Color", 'theme_domain'),
          "id"    => "tagline_font_color",
          "desc"  => __("Which Font Color do You want to use for text in the Tagline?", 'theme_domain'),
          "std"   => "#4F4F4F",
          "type"  => "colorpicker"
      )
    )
  )
);
?>
```