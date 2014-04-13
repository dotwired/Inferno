# Function Reference

## inferno_get_option()

### Description

A safe way of getting values for a named option saved with the Inferno admin canvas. If the desired option does not exist, or no value is associated with it, NULL will be returned.

### Usage

```php
<?php echo inferno_get_option($option_name, $default_value); ?>
```

### Parameters

<dl>
  <dt>*`$option_name`*</dt>
  <dd>(string) (required) The key by which you want to retrieve the option value. Default: NULL</dd>

  <dt>*`$default_value`*</dt>
  <dd>(mixed) The default value to return if no value is returned (ie. the option is not in the database). Default: NULL</dd>
</dl>



## inferno_preview()

### Description

Wrapper function for [`Inferno_Preview()`][class_inferno_preview] class.

### Usage

```php
<?php
$args = array(
  'src' => false,
  'width' => false,
  'height' => false,
  'permalink' => false,
  'crop' => true,
  'effect' => 'default',
  'module' => null
);

echo inferno_preview($args);
?>
```

### Parameters

See the [`Inferno_Preview()`][class_inferno_preview] for a description of the arguments passed to `inferno_preview()`



[class_inferno_preview]: .manual_root/php_api/class_reference/#Inferno_Preview()