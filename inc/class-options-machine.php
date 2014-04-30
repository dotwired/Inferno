<?php

/**
 * Options Machine
 *
 * @version 1.0
 * @since 0.9
 * @package WP_Inferno
 * 
 * Supported options:
 * - checkbox       : Checkbox (basically ON / OFF switch)
 * - color          : Synonym for "colorpicker"
 * - colorpicker    : A color picker
 * - file           : Alias for "media"
 * - font           : Embed font, including Google fonts
 * - imagepicker    : Select field for images (images as preview), suitable for patterns or similar
 * - imageselect    : Synonym for "imagepicker"
 * - transfer       : Import or export inferno panel settings
 * - media          : Upload for images (files) (with live preview)
 * - radio          : A radio field
 * - range          : A range slider, supports units (see http://jqueryui.com/slider/ for example)
 * - select         : Select input
 * - text           : Plain text input
 * - textarea       : Plain text area
 */

if(!class_exists('Inferno_Options_Machine')) {
  class Inferno_Options_Machine {

    private $setting;

    private $setting_value;

    private $item_id;


    private static $count = array(
      'radio'       => 1,
      'range'       => 1,
      'colorpicker' => 1
    );

    private $fonts = array(
      'Arial',
      'Arial Black',
      'Georgia',
      'Helvetica',
      'Helvetica Neue',
      'Lucida Grande',
      'Proxima Nova',
      'Tahoma',
      'Times New Roman'
    );

    /**
     * Build the setting field.
     * @param array  $setting       the setting array
     * @param string $setting_value the setting value
     */
    public function __construct( $setting = array(), $setting_value = null, $item_id = null )
    {
      if ( empty ( $setting ) ) return;
      $this->setting = $setting; 
      $this->setting_value = isset($setting_value) ? $setting_value : (isset($setting['std']) ? $setting['std'] : null);
      $this->item_id = $item_id;

      $class = '';
      if(isset($this->setting['advanced']) && $this->setting['advanced'] === true) $class .= ' advanced';
      ?>

      <div class="field<?php echo $class; ?>">
        <?php if($this->setting['title']) : ?>
        <div class="field-title"><h4><?php echo $this->setting['title']; ?></h4></div>
        <?php endif; ?>

        <?php $this->field_setting(); ?>
        <?php $this->field_details(); ?>
        <div class="clear"></div>
      </div>
      
      <?php
    }

    private function get_full_id( $prependix = null, $appendix = null ) {
      $id = $this->setting['id'];
      if($prependix) $id = $prependix . $id;
      if($appendix) $id = $id . $appendix;

      return $id;
    }

    /**
     * Return the name tag for the current setting form object.
     */
    private function id_tag( $prependix = null, $appendix = null )
    {
      $id = $this->get_full_id( $prependix, $appendix );
      if($this->item_id) $id .= '-' . $this->item_id;

      echo 'id="' . $id . '"';
    }

    /**
     * Print name tag for the current setting form object.
     */
    private function name_tag( $prependix = null, $appendix = null )
    {
      $name = $this->get_full_id( $prependix, $appendix );
      if($this->item_id) $name .= '[' . $this->item_id . ']';

      echo 'name="' . $name . '"';
    }


    private function for_tag( $prependix = null, $appendix = null )
    {
      $for = $this->get_full_id( $prependix, $appendix );
      if($this->item_id) $for .= '-' . $this->item_id;

      echo 'for="' . $for . '"';
    }


    /**
     * left column of the panel inner. contains description and optionally some more tag description
     * @param  array  $setting init the setting for this row.
     * @return void
     */
    function field_details() 
    { ?>
      <div class="field-details">
        <?php if($this->setting['type'] != 'radio' && $this->setting['type'] != 'checkbox') : ?><label <?php $this->for_tag("inferno-concrete-setting-"); ?>><?php endif; ?>
        <?php echo $this->setting['desc']; ?>
        <?php if($this->setting['type'] != 'radio' && $this->setting['type'] != 'checkbox') : ?></label><?php endif; ?>

        <?php if(isset($this->setting['more']) && $this->setting['more'] != '') : ?>
          <span class="more"><?php echo $this->setting['more']; ?></span>
        <?php endif; ?>

        <?php if($this->setting['type'] == 'font') : ?>
          <div class="googlefont-desc">
            <label <?php $this->for_tag("inferno-concrete-setting-", "-googlefont"); ?>>
              <?php _e('Enter the Name of the Google Webfont You want to use, for example "Droid Serif" (without quotes). Leave blank to use a Font from the selector above.', 'inferno'); ?>
            </label>
            <span class="more">
              <?php _e('You can view all Google fonts <a href="http://www.google.com/webfonts">here</a>. Consider, that You have to respect case-sensitivity. If the font has been successfully recognized, the demo text will change to the entered font.', 'inferno'); ?>
            </span>
          </div>
        <?php endif; ?>
      </div>
    <?php
    }

    function field_setting() 
    {
      if($this->setting['type'] == 'colorpicker' || $this->setting['type'] == 'color') {
        $class = 'color-picker';
      } elseif($this->setting['type'] == 'imagepicker' || $this->setting['type'] == 'imageselect') {
        $class = 'imagepicker';
      } elseif($this->setting['type'] == 'file') {
        $class = 'media';
      } else
        $class = $this->setting['type'];

      echo '<div class="field-setting ' . $class . '">';

      switch($this->setting['type']) {
        case 'colorpicker':
        case 'color':
          $this->colorpicker();
          break;
        case 'range':
        case 'text':
          $this->text(); // will maybe call $this->range
          break;
        case 'textarea':
          $this->textarea();
          break;
        case 'checkbox':
          $this->checkbox();
          break;
        case 'radio':
          $this->radio();
          break;
        case 'file':
        case 'media':
          $this->media();
          break;
        case 'select':
          $this->select();
          break;
        case 'font':
          $this->font();
          break;
        case 'imagepicker':
        case 'imageselect':
          $this->select();
          break;
        case 'transfer':
          $this->transfer();
          break;
        default:
          $this->text();
          break;
      }

      echo '</div>';
    }

    function text()
    {
      ?>
      <input type="text" <?php $this->name_tag(); ?> value="<?php echo $this->setting_value; ?>" class="inferno-setting" <?php $this->id_tag("inferno-concrete-setting-"); ?> />
      <?php 
      if($this->setting['type'] == 'range') {
        $this->range();
      }
    }



    function textarea()
    {
      ?>
      <textarea <?php $this->name_tag(); ?> <?php $this->id_tag("inferno-concrete-setting-"); ?> class="inferno-setting"><?php echo esc_textarea( $this->setting_value ); ?></textarea>
      <?php
    }


    function colorpicker() 
    {
      ?>
      <input type="text" <?php $this->name_tag(); ?> class="inferno-setting inferno-color-selector" <?php $this->id_tag(null, '-colorselector_' . self::$count['colorpicker']); ?> value="<?php echo $this->setting_value; ?>" />
      <script type="text/javascript">
        jQuery(document).ready(function($) {
          // call the colorpicker
          $("#<?php echo $this->get_full_id(null, '-colorselector_' . self::$count['colorpicker']); ?>").spectrum({
            color: '<?php echo $this->setting_value; ?>',
            showAlpha: true,
            showInput: true,
            showInitial: true,
            clickoutFiresChange: true,
            showButtons: false,
            preferredFormat: "rgb"
          }).show();
        });
      </script>
      <?php self::$count['colorpicker']++;
    }




    function range()
    {   
      ?>
      <div <?php $this->id_tag(null, '-range_slider_' . self::$count['range']); ?> class="range-slider"></div>
      <script type="text/javascript">
        jQuery(document).ready(function($) {
          $("#<?php echo $this->get_full_id(null, '-range_slider_' . self::$count['range']); ?>").slider({
            <?php 
            echo 'min: ' . (isset($this->setting['min']) ? $this->setting['min'] : 0) . ',';
            echo 'max: ' . (isset($this->setting['max']) ? $this->setting['max'] : 100) . ',';
            echo 'step: ' . (isset($this->setting['step']) ? $this->setting['step'] : 1) . ',';

            if($this->setting_value != null) :
              $range_value = isset($this->setting['unit']) ? str_replace($this->setting['unit'], '', $this->setting_value) : $this->setting_value; ?>
              value: <?php echo (int)$range_value; ?>,
            <?php 
            endif; ?>
            slide: function(event, ui) { 
              $(this).parent().find('input')
              .val(ui.value<?php if(isset($this->setting['unit'])) : ?> + '<?php echo $this->setting['unit']; ?>'<?php endif; ?>);
            }
          });
        });
        </script>
      <?php self::$count['range']++;
    }

    function checkbox()
    {
      // hidden field inspired by http://stackoverflow.com/a/1992745/744230
      ?>
      <input type="hidden" <?php $this->name_tag(); ?> value="0" />
      <input type="checkbox" <?php $this->name_tag(); ?> value="1" class="inferno-setting" <?php $this->id_tag('inferno-concrete-setting-'); if($this->setting_value) echo ' checked'; ?> />
      <label <?php $this->for_tag('inferno-concrete-setting-'); ?> data-true="<?php _e('On'); ?>" data-false="<?php _e('Off'); ?>"><?php if($this->setting_value) _e('On'); else _e('Off'); ?></label>
      <?php 
    }


    function radio()
    {   
      foreach ($this->setting['options'] as $value => $label) : ?>
        <input type="radio" 
               <?php $this->name_tag(); ?>
               value="<?php echo $value; ?>" 
               <?php $this->id_tag('inferno-concrete-setting-', '-' . self::$count['radio']); ?>
               <?php if($value == $this->setting_value) echo "checked"; ?> class="inferno-setting" />
        <label <?php $this->for_tag('inferno-concrete-setting-', '-' . self::$count['radio']); ?>>
          <?php echo $label; ?>
        </label>
        <?php 
        self::$count['radio']++;
      endforeach;
    }

    function select()
    {
      ?>
      <select <?php $this->name_tag(); ?> <?php $this->id_tag('inferno-concrete-setting-'); ?> class="inferno-setting">
        <?php 
        foreach($this->setting['options'] as $value => $label) : ?>
          <option value="<?php echo $value; ?>"<?php if($value == $this->setting_value) echo ' selected="selected"'; 
            if($this->setting['type'] == 'imageselect' || $this->setting['type'] == 'imagepicker') echo ' data-img-src="' . $label . '"'; ?>>
            <?php echo $label; ?>
          </option>
        <?php 
        endforeach; ?>
      </select>
      <?php
    }


    function media()
    {
      ?>
      <input type="text" <?php $this->name_tag(); ?> <?php $this->id_tag('inferno-concrete-setting-'); ?> accept="*.jpg,*.jpeg,*.png,*.ico"
        value="<?php echo $this->setting_value; ?>" class="inferno-setting" />
      <span class="button button-upload"><?php _e('Upload Image', 'inferno'); ?></span>
      <span class="button button-reset"><?php _e('Remove', 'inferno'); ?></span>

      <div class="media-preview">
        <?php if($this->setting_value != null) : ?>
        <img src="<?php echo $this->setting_value; ?>" alt="" />
        <?php endif; ?>
      </div>
      <?php
    }


    function font()
    {
      ?>
      <select <?php $this->name_tag(); ?> <?php $this->id_tag('inferno-concrete-setting-'); ?> class="inferno-setting">
        <?php 
        foreach($this->fonts as $font) : ?>
          <option value="<?php echo $font; ?>" <?php if($font == $this->setting_value) echo 'selected="selected"'; ?>>
            <?php echo $font; ?>
          </option>
        <?php 
        endforeach; ?>
      </select>
      <?php
      $this->googlefont();
    }




    function googlefont() 
    {
      ?>
      <span class="button googlefont show"><?php _e('Show Google Font for this Option.', 'inferno'); ?></span>
      <span class="button googlefont hide"><?php _e('Hide Google Font for this Option.', 'inferno'); ?></span>
  
      <div class="googlefont-setting">
        <input type="text" <?php $this->name_tag(null, '_googlefont'); ?> <?php $this->id_tag('inferno-concrete-setting-', '-googlefont'); ?>
          value="<?php if(!in_array($this->setting_value, $this->fonts)) echo $this->setting_value; ?>" class="inferno-setting" />
        <div class="googlefont-canvas">
          <?php _e('Grumpy wizards make toxic brew for the evil Queen and Jack.', 'inferno'); ?>
          <link class="googlefont-link" href='' rel='stylesheet' type='text/css'>
        </div>
      </div>
      <?php
    }

    function transfer()
    {
      $this->setting['id'] = 'transfer'; // overwrite to "transfer"
      $settings = get_option('inferno', array()); // get all the inferno panel settings
      $this->setting_value = base64_encode(serialize($settings)); // not malicious, ignore alerts on this line
      ?>
      <textarea <?php $this->name_tag(); ?> <?php $this->id_tag('inferno-concrete-setting-'); ?> class="inferno-setting"><?php echo esc_textarea( $this->setting_value ); ?></textarea>
      <button type="submit" name="inferno_action" value="import" class="button"><?php _e('Import options', 'inferno'); ?></button>
      <script type="text/javascript">
      jQuery(document).ready(function($) {
        $('#inferno-concrete-setting-transfer').next().confirm({
          msg: "<?php _e('The import of settings will overwrite all current settings. Are you sure you want to import them?', 'inferno') ?> ",
          timeout: 7000,
          dialogShow: 'fadeIn',
          dialogSpeed: 'slow',
          buttons: {
            ok : "<?php _e('Yes', 'inferno'); ?>",
            cancel: "<?php _e('No', 'inferno'); ?>",
            separator: ' / '
          } 
        });
      });
      </script>
      <?php
    }
  }
}