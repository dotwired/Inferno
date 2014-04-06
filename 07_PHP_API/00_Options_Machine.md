# Options Machine

Inferno uses its internal Options_Machine() class to generate and handle most of the settings. The admin panel and meta box generator are being configured pretty similar because of that.


## Fields

Single field arrays always come into the `fields` array, which may be somehow arranged in another array, dependent on whether you are writing a configuration file for the admin canvas, meta box generator or shortcode generator.
Some field keys stay always the same. 

These apply to every single field array:

<dl>
  <dt>*`id`*</dt>
  <dd>The id of the option. You will be able to fetch the option value for the option based on this `id` value with [`inferno_get_option()`][function_inferno_get_option].</dd>

  <dt>*`title`*</dt>
  <dd>The title for your option field.</dd>

  <dt>*`desc`*</dt>
  <dd>The description for your option field.</dd>

  <dt>*`more`*</dt>
  <dd>Another description place for your option field. Will be visually differ from the `desc` key.</dd>
  
  <dt>*`std`*</dt>
  <dd>Standard value for your option field.</dd>

  <dt>*type*</dt>
  <dd>
    <dl>
      <dt>`colorpicker` `color`</dt>
      <dd>A colorpicker with alpha transparency.</dd>
    </dl>

    <dl>
      <dt>`text`</dt>
      <dd>A simple text input field.</dd>
    </dl>

    <dl>
      <dt>`textarea`</dt>
      <dd>A simple text area (just as the text field but allowing new lines).</dd>
    </dl>

    <dl>
      <dt>`range`</dt>
      <dd>A slider for the selection of numbers in a certain range.</dd>
    </dl>

    <dl>
      <dt>`checkbox`</dt>
      <dd>A checkbox option field. Turn on or turn off something.</dd>
    </dl>

    <dl>
      <dt>`radio`</dt>
      <dd>A radio option field. Select one value between many values.</dd>
    </dl>

    <dl>
      <dt>`select`</dt>
      <dd>A select option field. Select one value between many values (it's basically the same as radio, but differs optically).</dd>
    </dl>

    <dl>
      <dt>`file` `media`</dt>
      <dd>A text input field where you can type in an URL of an image or upload a file to your WordPress installation (after the file upload is complete, the text field is being filled automatically with tha file URL).</dd>
    </dl>

    <dl>
      <dt>`imagepicker` `imageselect`</dt>
      <dd>A select field wich can preview the images which you probably would associate with the stored text value.</dd>
    </dl>

    <dl>
      <dt>`font`</dt>
      <dd>A select field with some basic fonts probably available on pretty much every computer plus a text field which lets the user to type in a Google Webfont (if it's typed in correctly, it will change some preview text to that font). That way the user is always able to easily use every instantly available Google Webfont without the need to update a list of all Google Webfonts.</dd>
    </dl>

    <dl>
      <dt>`transfer`</dt>
      <dd>A text area with all current set options packed in one string for export. Also allows import of settings by pasting a previously exported string.</dd>
    </dl>
  </dd>
</dl>



### Colorpicker

#### Example

```php
<?php
array(
  "title"   => __("Background color", 'theme_domain'),
  "id"      => "bg_color",
  "desc"    => __("Indeed. The background.", 'theme_domain'),
  "std"     => "#ffffff", # use either hexcode for default value or rgba
  "type"    => "colorpicker"
)
?>
```
