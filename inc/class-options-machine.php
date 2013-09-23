<?php

/**
 * Options Machine
 *
 * @version 1.0
 * @since 0.9
 * @package WP_Inferno
 * 
 * Supported options:
 * - text           : Plain text input
 * - textarea       : Plain text area
 * - colorpicker    : A color picker
 * - color          : Synonym for "colorpicker"
 * - range          : A range slider, supports units (see http://jqueryui.com/slider/ for example)
 * - radio          : A radio field
 * - file           : For any file upload
 * - media          : Upload for images (with live preview)
 * - select         : Select input
 * - font           : Embed font, including Google fonts
 * - imagepicker    : Select field for images (images as preview), suitable for patterns or similar
 * - imageselect    : Synonym for "imagepicker"
 */

if(!class_exists('Inferno_Options_Machine')) {
    class Inferno_Options_Machine {

        private $setting;

        private $setting_value;

        private static $count = array(
            'radio' => 1,
            'range' => 1,
            'colorpicker' => 1
        );

        private $fonts = array(
            'Arial', 
            'Arial Black', 
            'Lucida Grande', 
            'Helvetica', 
            'Helvetica Neue', 
            'Tahoma', 
            'Georgia', 
            'Times New Roman'
        );

        /**
         * Build the setting field.
         * @param array  $setting       the setting array
         * @param string $setting_value the setting value
         */
        public function __construct( $setting = array(), $setting_value = null )
        {
            if ( empty ( $setting ) ) return;
            $this->setting = $setting; 
            $this->setting_value = $setting_value ? $setting_value : $setting['std'];
            ?>

            <div class="field">
                <?php if($this->setting['title']) : ?>
                <div class="field-title"><h4><?php echo $this->setting['title']; ?></h4></div>
                <?php endif; ?>

                <?php $this->field_setting(); ?>
                <?php $this->field_details(); ?>
                <div class="clear"></div>
            </div>

            <?php
        }

        private function get_name()
        {
            return 'name="' . $this->setting['id'] . '"';
        }
 
        /**
         * left column of the panel inner. contains description and optionally some more tag description
         * @param  array  $setting init the setting for this row.
         * @return void
         */
        function field_details() 
        { ?>
            <div class="field-details">
                <?php if($this->setting['type'] != 'radio') : ?><label for="<?php echo $this->setting['id']; ?>"><?php endif; ?>
                <?php echo $this->setting['desc']; ?>
                <?php if($this->setting['type'] != 'radio') : ?></label><?php endif; ?>

                <?php if(isset($this->setting['more']) && $this->setting['more'] != '') : ?>
                    <span class="more"><?php echo $this->setting['more']; ?></span>
                <?php endif; ?>
            </div>
        <?php
        }

        function field_setting() 
        {
            if($this->setting['type'] == 'colorpicker' || $this->setting['type'] == 'color')
                $class = 'colorpicker';
            elseif($this->setting['type'] == 'imagepicker' || $this->setting['type'] == 'imageselect')
                $class = 'imagepicker';
            else
                $class = $this->setting['type'];


            echo '<div class="field-setting ' . $class . '">';

            switch($this->setting['type']) {
                case 'text':
                case 'colorpicker':
                case 'color':
                case 'range':
                    $this->text(); // will maybe call $this->range or $this->colorpicker
                    break;
                case 'textarea':
                    $this->textarea();
                    break;
                case 'radio':
                    $this->radio();
                    break;
                case 'file':
                    $this->file();
                    break;
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
                default:
                    $this->text(); // will maybe call $this->range or $this->colorpicker
                    break;
            }

            echo '</div>';
        }

        function text() 
        {
            ?>
            <input type="text" <?php echo $this->get_name(); ?> value="<?php echo $this->setting_value; ?>" class="inferno-setting" />
            <?php 
            if($this->setting['type'] == 'colorpicker' || $this->setting['type'] == 'color') {
                $this->colorpicker();
            } elseif($this->setting['type'] == 'range') {
                $this->range();
            }
        }



        function textarea()
        {
            ?>
            <textarea <?php echo $this->get_name(); ?> class="inferno-setting"><?php echo esc_textarea( $this->setting_value ); ?></textarea>
            <?php
        }


        function colorpicker() 
        {
            ?>
            <div class="colorSelector inferno-setting" id="ip-colorselector-<?php echo self::$count['colorpicker']; ?>">
                <div style="background-color: <?php echo $this->setting_value; ?>;"></div>
            </div>
            <script type="text/javascript">
                jQuery(document).ready(function($) {
                    // call the colorpicker
                    $('#ip-colorselector-<?php echo self::$count['colorpicker']; ?>').ColorPicker({
                        color: '<?php echo $this->setting_value; ?>',
                        onShow: function(colpkr) {
                            $(colpkr).fadeIn(500);
                            return false;
                        },
                        onHide: function(colpkr) {
                            $(colpkr).fadeOut(500);
                            return false;
                        },
                        onChange: function(hsb, hex, rgb) {
                            $('#ip-colorselector-<?php echo self::$count['colorpicker']; ?> div').css({'background-color': '#' + hex});
                            $('#ip-colorselector-<?php echo self::$count['colorpicker']; ?>').parent().find('input').val('#' + hex);
                        }
                    });
                });
            </script>
            <?php
            self::$count['colorpicker']++;               
        }




        function range()
        {   
            ?>
            <div id="range-slider-<?php echo self::$count['range']; ?>" class="range-slider inferno-setting"></div>
            <script type="text/javascript">
                jQuery(document).ready(function($) {
                    $('#range-slider-<?php echo self::$count['range']; ?>').slider({
                        <?php 
                        echo 'min: ' . ($this->setting['min'] ? $this->setting['min'] : 0) . ',';
                        echo 'max: ' . ($this->setting['max'] ? $this->setting['max'] : 100) . ',';
                        echo 'step: ' . ($this->setting['step'] ? $this->setting['step'] : 1) . ',';

                        if($this->setting_value != null) :
                            $range_value = str_replace($this->setting['unit'], '', $this->setting_value); ?>
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



        function radio()
        {   
            foreach ($this->setting['options'] as $value => $label) : ?>
                <input type="radio" 
                             <?php echo $this->get_name(); ?>
                             value="<?php echo $value; ?>" 
                             id="radio-<?php echo $this->setting['id'] . '-' . self::$count['radio']; ?>" 
                             <?php if($value == $this->setting_value) echo "checked"; ?> class="inferno-setting" />
                <label for="radio-<?php echo $this->setting['id'] . '-' . self::$count['radio']; ?>">
                    <?php echo $label; ?>
                </label>
                <?php 
                self::$count['radio']++;
            endforeach;
        }

        function select()
        {
            ?>
            <select <?php echo $this->get_name(); ?> id="<?php echo $this->setting['id']; ?>" class="inferno-setting">
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
            <input type="hidden" <?php echo $this->get_name(); ?> accept="*.jpg,*.jpeg,*.png"
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


        function file()
        {
            ?>
            <input type="text" <?php echo $this->get_name(); ?> accept="*.jpg,*.jpeg,*.png"
                value="<?php echo $this->setting_value; ?>" class="inferno-setting" />
            <span class="button upload"><?php _e('Upload Image', 'inferno'); ?></span>
            <?php
        }



        function font()
        {
            ?>
            <select <?php echo $this->get_name(); ?> id="<?php echo $this->setting['id']; ?>" class="inferno-setting">
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
            <span class="button googlefont">
                <?php _e('Show / hide Google Font for this Option.', 'inferno'); ?>                   
            </span>
        </div>
        <div class="clear"></div>
        <div class="field-details googlefont-desc">
            <label for="<?php echo $this->setting['id'] . '_googlefont'; ?>">
                <?php _e('Enter the Name of the Google Webfont You want to use, for example "Droid Serif" (without quotes). Leave blank to use a Font from the selector above.', 'inferno'); ?>
            </label>
            <span class="more">
                <?php _e('You can view all Google fonts <a href="http://www.google.com/webfonts">here</a>. Consider, that You have to respect case-sensitivity. If the font has been successfully recognized, the demo text will change to the entered font.', 'inferno'); ?>
            </span>
        </div>
        <div class="field-setting googlefont-setting">
            <input type="text" name="<?php echo $this->setting['id']; ?>_googlefont" id="<?php echo $this->setting['id']; ?>_googlefont"
                value="<?php if(!in_array($this->setting_value, $this->fonts)) echo $this->setting_value; ?>" class="inferno-setting" />
            <div class="googlefont-canvas">
                <?php _e('Grumpy wizards make toxic brew for the evil Queen and Jack.', 'inferno'); ?>
                <link class="googlefont-link" href='' rel='stylesheet' type='text/css'>
            </div>
            <?php
        }
    }
}