# Class Reference

## Inferno_Preview()

### Description

Generates a preview with cool effects and a (customizable) template for that preview. For convenience you should use the wrapper function, which will prevent errors when this class changes things like the order of the arguments.

### Usage

```php
<?php
$src = false;
$width = false;
$height = false;
$permalink = false;
$crop = true;
$effect = 'default';
$module = null;

$preview = new Inferno_Preview($src, $width, $height, $permalink, $crop, $effect, $module);
echo $preview->get_output();
?>
```

### Parameters

<dl>
  <dt>*`$src`*</dt>
  <dd>(string|false) The location (url) for the image you want to use in the preview. If false, you need to be in the WordPress Loop. Default: false</dd>

  <dt>*`$width`*</dt>
  <dd>(integer|false) Generated image width. Either width, height or both must be set. Default: false</dd>

  <dt>*`$height`*</dt>
  <dd>(integer|false) Generated image height. Either height, width or both  must be set. Default: false</dd>

  <dt>*`$permalink`*</dt>
  <dd>(string|false) If you want the generated preview to link somewhere, pass the url here. Default: false</dd>

  <dt>*`$crop`*</dt>
  <dd>(boolean) whether to crop the image eventually. Default: true</dd>

  <dt>*`$effect`*</dt>
  <dd>(string) Can be 'default', 'flip' or 'fold'. Default: 'default'</dd>

  <dt>*`$module`*</dt>
  <dd>(string|null) Some string, which allows to differentiate even further between effects as it is being passed to [`get_template_part()`][get_template_part] as the $name parameter. E.g. you can have a portfolio which uses a flip effect and a blog with a flip effect and though two different template files (and therefore looks) for both. Default: 'default'</dd>
</dl>

[get_template_part]: https://codex.wordpress.org/Function_Reference/get_template_part
