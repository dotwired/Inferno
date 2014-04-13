# Shortcode Reference

The HTML output of the shortcodes can be determined not only with the passed options but also by activating or deactivating some CSS framework like [Bootstrap][Bootstrap] or [Foundation][Foundation]. Here the main difference will be in the used gridsystem, especially when it's about the column shortcodes.

E.g. the shortcode `[one_half]some content[/one_half]` will generate the following code by default:

```html
<div class="one-half">some content</div>
```

While if you [activate Bootstrap][activate_bootstrap] it will be the following code:

```html
<div class="col-md-6">some content</div>
```

And finally [activating Foundation][activate_foundation] will generate:

```html
<div class="medium-6 columns">some content</div>
```

*Note* that there is no difference between `[one_half]` and `[one_half_last]` when Bootstrap or Foundation support is activated, so you don't need to use the `_last` column shortcodes at all.

For general understanding of how WordPress Shortcodes work see the [Codex][codex_shortcodes]. For advanced knowledge about how the shortcodes work precisely you may want to have a look at [Inferno_Shortcodes() class][github_Inferno_Shortcodes()].


## `[stacked]`

This is a simple row container with some bottom padding .

### Usage

`[stacked css_class="string" border="true|false"]Further content here[/stacked]`

### Parameters 

<dl>
  <dt>*`css_class`*</dt>
  <dd>Any class(es) added here will be appended to the div element classes.</dd>

  <dt>*`border`*</dt>
  <dd>Will add `border` or `noborder` class to the element dependend on whether this is set to `true` or `false`.</dd>
</dl>



## `[one_half]`

Column which divides horizontally into two.

### Usage

`[one_half css_class="string"]Further content here[/one_half]`

### Parameters 

<dl>
  <dt>*`css_class`*</dt>
  <dd>Any class(es) added here will be appended to the div element classes.</dd>
</dl>


## `[one_half_last]`_last

Column which divides horizontally into two. Should be used when filling up the last half on the right unless Bootstrap or Foundation support is activated.

### Usage

`[one_half css_class="string"]`

### Parameters 

<dl>
  <dt>*`css_class`*</dt>
  <dd>Any class(es) added here will be appended to the div element classes.</dd>
</dl>



## `[one_third]`

Column which divides horizontally into one third.

### Usage

`[one_third css_class="string"]`

### Parameters 

<dl>
  <dt>*`css_class`*</dt>
  <dd>Any class(es) added here will be appended to the div element classes.</dd>
</dl>


## `[two_thirds]`

Column which divides horizontally into two thirds.

### Usage

`[two_third css_class="string"]`

### Parameters 

<dl>
  <dt>*`css_class`*</dt>
  <dd>Any class(es) added here will be appended to the div element classes.</dd>
</dl>


## `[one_third_last]`

Column which divides horizontally into one third. Should be used when filling up the last third on the right unless Bootstrap or Foundation support is activated.

### Usage

`[one_third_last css_class="string"]`

### Parameters 

<dl>
  <dt>*`css_class`*</dt>
  <dd>Any class(es) added here will be appended to the div element classes.</dd>
</dl>


## `[two_thirds_last]`

Column which divides horizontally into two thirds. Should be used when filling up the last two thirds on the right unless Bootstrap or Foundation support is activated.

### Usage

`[two_thirds_last css_class="string"]`

### Parameters 

<dl>
  <dt>*`css_class`*</dt>
  <dd>Any class(es) added here will be appended to the div element classes.</dd>
</dl>

## More column shortcodes

You get the idea of the column shortcodes. Apart from the ones above there are available the following:

* `[one_fourth]`
* `[three_fourths]`
* `[one_fourth_last]`
* `[three_fourths_last]`
* `[one_fifth]`
* `[two_fifths]`
* `[three_fifths]`
* `[four_fifths]`
* `[one_fifth_last]`
* `[two_fifths_last]`
* `[three_fifths_last]`
* `[four_fifths_last]`
* `[one_sixth]`
* `[five_sixths]`
* `[one_sixth_last]`
* `[five_sixths_last]`



## `[divider]`

A padding container. Optionally can show a border.

### Usage

`[divider css_class="string"]`

### Parameters 

<dl>
  <dt>*`css_class`*</dt>
  <dd>Any class(es) added here will be appended to the div element classes.</dd>
</dl>



## `[icon]`

A padding container. Optionally can show a border.

### Usage

`[icon css_class="string" icon="fire" size="18px" color="rgba(1, 1, 1, 0.5)" background="#555" hover_color="rgba(1, 1, 1, 1)" hover_background="red"]`

### Parameters 

<dl>
  <dt>*`css_class`*</dt>
  <dd>Any class(es) added here will be appended to the element classes.</dd>

  <dt>*`icon`*</dt>
  <dd>Shortcut for any [Font Awesome icon][font_awesome_icons].</dd>
</dl>


[Bootstrap]: http://getbootstrap.com
[Foundation]: http://foundation.zurb.com
[activate_bootstrap]: .manual_root/css_frameworks/bootstrap
[activate_foundation]: .manual_root/css_frameworks/foundation
[codex_shortcodes]: https://codex.wordpress.org/Shortcode
[github_Inferno_Shortcodes()]: https://github.com/maximski/Inferno/blob/master/shortcodes/class-shortcodes.php
[font_awesome_icons]: http://fortawesome.github.io/Font-Awesome/icons/
