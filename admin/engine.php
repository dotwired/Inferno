<?php 

//require_once(dirname(__FILE__) . '/')

if(!class_exists('Inferno_Panel_Engine')) {

    class Inferno_Panel_Engine extends Inferno {

        private $_settings = array();

        private $_option = array();

        private $_noncestr = 'inferno-panel';

        private $_option_name = 'inferno';

        private $_error = false;

        private $_debug = array();

        private $_count = array(
            'radio' => 1,
            'range' => 1,
            'colorpicker' => 1
        );

        public $_default_fonts = array(
            'Arial', 'Arial Black', 'Lucida Grande', 'Helvetica', 'Helvetica Neue', 'Tahoma', 'Georgia', 'Times New Roman'
        );
        
            
        public function __construct($_config)
        {
            global $inferno_option;

            $this->_config = $_config;

            $this->load_settings();

            add_action('init', array(&$this, 'assets')); // instead of $this->assets();

            // call data
            add_action('init', array(&$this, 'init'));

            // add the menu item to the wp admin menu
            add_action('admin_menu', array(&$this, 'admin_menu')); 

            // save data
            add_action('admin_init', array(&$this, 'save')); 
        }



        function nonce_input()
        {
            echo '<input type="hidden" name="_wpnonce" value="'. wp_create_nonce($this->_noncestr) .'" />';
        }


        function check_nonce()
        {
            $nonce = $_POST['_wpnonce'];
            if(!wp_verify_nonce($nonce, $this->_noncestr)) die(__("Security check failed.", 'inferno'));
        }

        /**
         * Perform the saving from the received panel data.
         * @version 1.0
         * @since 1.0
         */
        function save()
        {
            global $inferno_option;

            // if there are some actions with the theme optionspage
            if(isset($_POST['inferno_action'])) {

                // check wp nonce
                $this->check_nonce();

                // save action
                if($_POST['inferno_action'] == 'save') {
                    foreach($this->_settings as $topic ) {
                        foreach($topic['fields'] as $option) {
                            if(isset($_POST[$option['name']])) {

                                // TODO: find out why the following if statement is important
                                if(is_array($_POST[$option['name']]) && !Inferno_Helper::array_empty($_POST[$option['name']])) {

                                    // TODO: furthermore, is this REALLY a security hole?
                                    $inferno_option[$option['name']] = $_POST[$option['name']];
                                    if(!update_option($this->_option_name, json_encode($inferno_option))) 
                                        $this->error($option['name'], $inferno_option[$option['name']], 'Could not save option array.');

                                } elseif(!is_array($_POST[$option['name']])) {
                                    $inferno_option[$option['name']] = Inferno_Helper::sanitize_data(trim(stripslashes($_POST[$option['name']])), $option['type']);

                                    // if this is google font
                                    if(isset($_POST[$option['name'] . '_googlefont']) && !empty($_POST[$option['name'].'_googlefont'])) {
                                        $inferno_option[$option['name']] = trim(stripslashes($_POST[$option['name'].'_googlefont']));
                                    }

                                    if(!update_option($this->_option_name, json_encode($inferno_option))) 
                                        $this->error($option['name'], $inferno_option[$option['name']], 'Could not save flat option string.');
                                }
                            }
                        }
                    }
                }

                // reset action
                if($_POST['inferno_action'] == 'reset' && get_option($this->_option_name)) {
                    if(!delete_option($this->_option_name)) $this->error('Reset', null, 'Reset action failed');
                }

                if($this->_error == false) {
                    if(stristr($_SERVER['REQUEST_URI'], '&settings-updated=true')) {
                        $location = $_SERVER['REQUEST_URI'];
                    } else {
                        $location = $_SERVER['REQUEST_URI'] . "&settings-updated=true";
                    }
                } else {
                    $location = $_SERVER['REQUEST_URI'] . "&settings-updated=false";
                }

                // for debug
                if(!$this->_config['debug']) {
                    header("Location: $location");
                }
                echo '<pre>';
                echo '$_POST: ';
                print_r($_POST);
                echo 'Debug: ';
                print_r($this->_debug);
                echo '</pre>';
                die;
            }
        }

        function error($optionname = '', $optionvalue, $msg = '')
        {
            $this->_error = true;
            $this->_debug[$optionname] = array(
                'value' => $optionvalue,
                'msg' => $msg
            );
        }

        function save_file($option)
        {
            global $inferno_option;

            // if there is a file to upload.
            if(isset($_FILES[$option['name'].'_file'] ) && !empty($_FILES[$option['name'].'_file']['name'] )) {
                $tmp_name = $_FILES[$option['name'].'_file']['tmp_name'];
                $name = $_FILES[$option['name'].'_file']['name'];

                $attachment = wp_upload_bits( $name, null, file_get_contents( $tmp_name ), date( "Y-m" ) );
                if ($attachment['error'] == false ) {
                    $inferno_option[$option['name']] = $attachment['url'];
                    if(!update_option($this->_option_name, json_encode($inferno_option)))
                        $this->error($option['name'], $inferno_option[$option['name']]);
                        
                } else {
                    $msg = $attachment['error'];
                }
            }
        }

        function init()
        {
            global $inferno_option;

            //get options
            $inferno_option = json_decode(get_option($this->_option_name, $this->_option_name), true );

            // important. Give undefined options their default values
            $this->standarize_options();

            // also important. remove backslashes etc. for work after json_decode
            $this->walk_trough_options();
        }

        public function admin_menu()
        {
            add_theme_page(
                'Theme Options',
                'Theme Options',
                'edit_theme_options',
                'inferno-admin',
                array(&$this, 'canvas')
            );
        }


        /**
         * [settings description]
         * @return [type] [description]
         */
        private function load_settings() {
            if(file_exists(get_template_directory() . '/settings.php')) {
                $this->_settings = require_once(get_template_directory() . '/settings.php');
            }
        }


        /**
         * perform some common actions with keys and values of the settings array
         * @return void
         */
        function walk_trough_options() {
            global $inferno_option;

            $inferno_option = Inferno_Helper::trim_r($inferno_option);
            $inferno_option = Inferno_Helper::stripslashes_r($inferno_option);
            
            if(is_admin()) $inferno_option = Inferno_Helper::htmlspecialchars_r($inferno_option);
        }

        /**
         * check $inferno_option for not available options and make them default
         * @return void
         */
        function standarize_options() {
            global $inferno_option;
            
            if(!is_array($this->_settings) || empty($this->_settings)) return false;

            foreach($this->_settings as $topic) {
                foreach($topic as $option) {
                    if(isset($option['name']) && !isset($inferno_option[$option['name']])) {
                        if(isset($option['default'])) {
                            $inferno_option[$option['name']] = $option['default'];
                        } else {
                            $inferno_option[$option['name']] = "";
                        }
                    }
                }
            }
        }

        function canvas() 
        {
            require_once('canvas.php'); 
        }

        /**
         * panel navigation
         * @return void
         */
        function menu() 
        { 
            if(!isset($this->_settings) || !is_array($this->_settings) || empty($this->_settings)) return false;

            // todo: this is just a temporary fix for icon output, too lazy 
            // to rewrite all the settings array ight now. do it right some time.
            $settings = simplexml_load_file(get_template_directory() . '/settings.xml'); 
            $icons = array();
            foreach($settings as $topic) {
                $icons[] = (String)$topic{'icon'};
            }
                                                                                         
            $i = 1; foreach($this->_settings as $label => $data) : ?>
            <li><?php echo '<a href="#tab-'.$i.'" id="tablink-'.$i.'"><div class="icon-' .  $icons[$i - 1] . '"></div><span>' .  $label . '</span></a>'; ?></li>
            <?php $i++; endforeach;
        }


        function tabs()
        {
            if(isset($this->_settings) && is_array($this->_settings) && !empty($this->_settings)) {
                $count = 1;
                foreach($this->_settings as $name => $topic) : ?>
                    <!-- BEGIN .ip-tab -->
                    <div id="tab-<?php echo $count; ?>" class="ip-tab">
                        <?php foreach($topic['fields'] as $field) $this->field($field); ?>
                    <!-- END .ip-tab -->
                    </div>
                    <?php $count++;
                endforeach;
            }
        }

        function message()
        {
            // no settings file message
            if(!is_array($this->_settings) || empty($this->_settings)) : ?>
                <div class="inferno-updated error">
                    <p><?php _e('Whooops, looks like the settings could not be loaded. Are You sure the current theme got a settings file?', 'inferno'); ?></p>
                </div>
            <?php endif;

            if(isset($_GET['settings-updated'])) {
                if($_GET['settings-updated'] == 'true') : ?>
                <div class="inferno-updated success">
                    <p><?php _e('Options successfully saved!', 'inferno'); ?></p>
                </div>
                <?php elseif($_GET['settings-updated'] == 'false') : ?>
                <div class="inferno-updated fail">
                    <p><?php _e('Options could not be saved. Please try again or make further steps.', 'inferno'); ?></p>
                </div>
                <?php endif;
            }
            ?>
            <div class="inferno-updated success ajax">
                <p><?php _e('Options successfully saved!', 'inferno'); ?></p>
            </div>
            <?php
        }

        function field($setting)
        {
            $this->_setting = $setting; ?>

            <div class="field">
                <h3><?php echo $this->_setting['label']; ?></h3>
                <?php $this->field_details(); ?>
                <?php $this->field_setting(); ?>
                <div class="clear"></div>
            </div>

            <?php
        }



        /**
         * left column of the panel inner. contains description and optionally some more tag description
         * @param  array  $setting init the setting for this row.
         * @return void
         */
        function field_details() 
        { ?>
            <div class="field-details">
                <?php if($this->_setting['type'] != 'radio') : ?><label for="<?php echo $this->_setting['name']; ?>"><?php endif; ?>
                <?php echo $this->_setting['desc']; ?>
                <?php if($this->_setting['type'] != 'radio') : ?></label><?php endif; ?>

                <?php if(isset($this->_setting['more']) && $this->_setting['more'] != '') : ?>
                    <span class="more"><?php echo $this->_setting['more']; ?></span>
                <?php endif; ?>
            </div>
        <?php
        }

        function field_setting() 
        {
            if($this->_setting['type'] == 'colorpicker' || $this->_setting['type'] == 'color')
                $class = 'ip-colorpicker';
            else
                $class = $this->_setting['type'];


            echo '<div class="field-setting ' . $class . '">';

            switch($this->_setting['type']) {
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
                case 'select':
                    $this->select();
                    break;
                case 'font':
                    $this->font();
                    break;
                default:
                    $this->text(); // will maybe call $this->range or $this->colorpicker
                    break;
            }

            echo '</div>';
        }



        function get_setting_value() 
        {
            global $inferno_option;

            echo $inferno_option[$this->_setting['name']];
            return (isset($inferno_option[$this->_setting['name']])) ? $inferno_option[$this->_setting['name']] : '';
        }



        function text() 
        {
            ?>
            <input type="text" name="<?php echo $this->_setting['name']; ?>" value="<?php echo $this->get_setting_value(); ?>" />
            <?php 
            if($this->_setting['type'] == 'colorpicker' || $this->_setting['type'] == 'color') {
                $this->colorpicker();
            } elseif($this->_setting['type'] == 'range') {
                $this->range();
            }
        }



        function textarea()
        {
            ?>
            <textarea name="<?php echo $this->_setting['name']; ?>"><?php echo esc_textarea( $this->get_setting_value() ); ?></textarea>
            <?php
        }


        function colorpicker() 
        {
            ?>
            <div class="colorSelector" id="ip-colorselector-<?php echo $this->_count['colorpicker']; ?>">
                <div style="background-color: <?php echo $this->get_setting_value(); ?>;"></div>
            </div>
            <script type="text/javascript">
                jQuery(document).ready(function($) {
                    // call the colorpicker
                    $('#ip-colorselector-<?php echo $this->_count['colorpicker']; ?>').ColorPicker({
                        color: '<?php echo $this->get_setting_value(); ?>',
                        onShow: function(colpkr) {
                            $(colpkr).fadeIn(500);
                            return false;
                        },
                        onHide: function(colpkr) {
                            $(colpkr).fadeOut(500);
                            return false;
                        },
                        onChange: function(hsb, hex, rgb) {
                            $('#ip-colorselector-<?php echo $this->_count['colorpicker']; ?> div').css({'background-color': '#' + hex});
                            $('#ip-colorselector-<?php echo $this->_count['colorpicker']; ?>').parent().find('input').val('#' + hex);
                        }
                    });
                });
            </script>
            <?php
            $this->_count['colorpicker']++;               
        }




        function range()
        {   
            global $inferno_option;
            ?>
            <div id="ip-range-<?php echo $this->_count['range']; ?>" class="ip-range"></div>
            <script type="text/javascript">
                jQuery(document).ready(function($) {
                    $('#ip-range-<?php echo $this->_count['range']; ?>').slider({
                        <?php 
                        if(isset($this->_setting['min'])) echo 'min: ' . $this->_setting['min'] . ',';
                        if(isset($this->_setting['max'])) echo 'max: ' . $this->_setting['max'] . ',';
                        if(isset($this->_setting['step'])) echo 'step: ' . $this->_setting['step'] . ',';

                        if($inferno_option[$this->_setting['name']] != '') :
                            $range_value = str_replace($this->_setting['unit'], '', $inferno_option[$this->_setting['name']]); ?>
                            value: <?php echo (int)$range_value; ?>,
                        <?php 
                        endif; ?>
                        slide: function(event, ui) { 
                            $(this).parent().find('input')
                            .val(ui.value<?php if(isset($this->_setting['unit'])) : ?> + '<?php echo $this->_setting['unit']; ?>'<?php endif; ?>);
                        }
                    });
                });
                </script>
            <?php $this->_count['range']++;
        }



        function radio()
        {   
            global $inferno_option;

            foreach ($this->_setting['options'] as $key => $value) : ?>
                <input type="radio" 
                             name="<?php echo $this->_setting['name']; ?>"
                             value="<?php echo $value; ?>" 
                             id="radio-<?php echo $this->_setting['name'] . '-' . $this->_count['radio']; ?>" 
                             <?php if($value == $inferno_option[$this->_setting['name']]) echo "checked"; ?> />
                <label for="radio-<?php echo $this->_setting['name'] . '-' . $this->_count['radio']; ?>">
                    <?php echo $value; ?>
                </label>
                <?php 
                $this->_count['radio']++;
            endforeach;
        }

        function select()
        {
            global $inferno_option;
            ?>
            <select name="<?php echo $this->_setting['name']; ?>" id="<?php echo $this->_setting['name']; ?>">
                <?php 
                foreach($this->_setting['options'] as $index => $option) : ?>
                    <option value="<?php echo $option['value'] ?>" <?php if($option['value'] == $inferno_option[$this->_setting['name']]) echo 'selected="selected"'; ?>>
                        <?php echo $option['label']; ?>
                    </option>
                <?php 
                endforeach; ?>
            </select>
            <?php
        }



        function file()
        {
            ?>
            <input type="text" name="<?php echo $this->_setting['name']; ?>" accept="*.jpg,*.jpeg,*.png"
                value="<?php echo $this->get_setting_value(); ?>" />
            <span class="button"><?php _e('Upload Image', 'inferno'); ?></span>
            <?php
        }



        function font()
        {
            global $inferno_option;
            ?>
            <select name="<?php echo $this->_setting['name']; ?>" id="<?php echo $this->_setting['name']; ?>">
                <?php 
                foreach($this->_default_fonts as $font) : ?>
                    <option value="<?php echo $font; ?>" <?php if($font == $inferno_option[$this->_setting['name']]) echo 'selected="selected"'; ?>>
                        <?php echo $font; ?>
                    </option>
                <?php 
                endforeach; ?>
            </select>
            <?php
            $this->googlefont();
        }




        function googlefont() {
            global $inferno_option;
            ?>
            <span class="button googlefont">
                <?php _e('Show / hide Google Font for this Option.', 'inferno'); ?>                   
            </span>
        </div>
        <div class="clear"></div>
        <div class="field-details ip-googlefont-desc">
            <label for="<?php echo $this->_setting['name'] . '_googlefont'; ?>">
                <?php _e('Enter the Name of the Google Webfont You want to use, for example "Droid Serif" (without quotes). Leave blank to use a Font from the selector above.', 'inferno'); ?>
            </label>
            <span class="more">
                <?php _e('You can view all Google fonts <a href="http://www.google.com/webfonts">here</a>. Consider, that You have to respect case-sensitivity. If the font has been successfully recognized, the demo text will change to the entered font.', 'inferno'); ?>
            </span>
        </div>
        <div class="field-setting ip-googlefont-option">
            <input type="text" name="<?php echo $this->_setting['name']; ?>_googlefont" id="<?php echo $this->_setting['name']; ?>_googlefont"
                value="<?php if(!in_array($inferno_option[$this->_setting['name']], $this->_default_fonts)) echo $inferno_option[$this->_setting['name']]; ?>" />
            <div class="ip-googlefont-canvas">
                <?php _e('Grumpy wizards make toxic brew for the evil Queen and Jack.', 'inferno'); ?>
                <link class="ip-googlefont-link" href='' rel='stylesheet' type='text/css'>
            </div>
            <?php
        }
    }
}