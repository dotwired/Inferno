<?php 

if(!class_exists('Inferno_Canvas')) {

    class Inferno_Canvas {

        private $theme_settings = array();

        private $noncestr = 'inferno';

        private $option_name = 'inferno';

        private $advanced_mode = false;

        
        public function __construct()
        {
            global $inferno_option;
            
            $theme_support = get_theme_support('inferno-canvas');

            if(isset($theme_support[0]['file']) && is_string($theme_support[0]['file'])) {
                $this->theme_settings = @include_once($theme_support[0]['file']);
            }
            if($theme_support[0]['social_profiles'] === true) { 
                $this->theme_settings[] = require_once(dirname(__FILE__) . '/social.php');
            }
            if($theme_support[0]['advanced_mode'] === true) {
                $this->advanced_mode = true;
            }

            //get options
            $inferno_option = get_option($this->option_name, array());
            $this->standarize_options(); // important. Give undefined options their default values

            // add the menu item to the wp admin menu
            add_action('admin_menu', array(&$this, 'admin_menu')); 

            // save data
            add_action('admin_init', array(&$this, 'save')); 
        }

        public function admin_menu()
        {
            $hook = add_theme_page(
                'Theme Options',
                'Theme Options',
                'edit_theme_options',
                'inferno-admin',
                array(&$this, 'canvas')
            );
        }

        private function check_nonce()
        {
            $nonce = $_POST['_wpnonce'];
            if(!wp_verify_nonce($nonce, $this->noncestr)) die(__("Security check failed.", 'inferno'));
        }

        /**
         * Perform the saving from the received panel data.
         * @version 1.0
         * @since 1.0
         */
        public function save()
        {
            global $inferno_option;

            // if there are some actions with the theme optionspage
            if(isset($_POST['inferno_action'])) {

                // check wp nonce
                $this->check_nonce();

                // save action
                if($_POST['inferno_action'] == 'save') {
                    foreach($this->theme_settings as $topic ) {
                        foreach($topic['fields'] as $field) {
                            if(isset($_POST[$field['id']])) {
                                $inferno_option[$field['id']] = $_POST[$field['id']];

                                // if this is google font
                                if(isset($_POST[$field['id'] . '_googlefont']) && !empty($_POST[$field['id'].'_googlefont'])) {
                                    $inferno_option[$field['id']] = trim(stripslashes($_POST[$field['id'].'_googlefont']));
                                }

                                update_option($this->option_name, $inferno_option);
                            }
                        }
                    }
                } elseif($_POST['inferno_action'] == 'reset' && get_option($this->option_name)) {
                    if(!delete_option($this->option_name)) $this->error('Reset', null, 'Reset action failed');
                }

                if(stristr($_SERVER['REQUEST_URI'], '&settings-updated=true')) {
                    $location = $_SERVER['REQUEST_URI'];
                } else {
                    $location = $_SERVER['REQUEST_URI'] . "&settings-updated=true";
                }

                header("Location: $location");
            }
        }

        public function save_file($option)
        {
            global $inferno_option;

            // if there is a file to upload.
            if(isset($_FILES[$option['id'].'_file'] ) && !empty($_FILES[$option['id'].'_file']['name'] )) {
                $tmp_name = $_FILES[$option['id'].'_file']['tmp_name'];
                $name = $_FILES[$option['id'].'_file']['name'];

                $attachment = wp_upload_bits( $name, null, file_get_contents( $tmp_name ), date( "Y-m" ) );
                if ($attachment['error'] == false ) {
                    $inferno_option[$option['id']] = $attachment['url'];
                    update_option($this->option_name, $inferno_option);
                } else {
                    $msg = $attachment['error'];
                }
            }
        }

        /**
         * check $inferno_option for not available options and make them default
         * @return void
         */
        private function standarize_options() {
            global $inferno_option;
            
            if(!is_array($this->theme_settings) || empty($this->theme_settings)) return false;

            foreach($this->theme_settings as $topic) {
                foreach($topic['fields'] as $field) {
                    if(isset($field['id']) && !isset($inferno_option[$field['id']])) {
                        if(isset($field['std'])) {
                            $inferno_option[$field['id']] = $field['std'];
                        } else {
                            $inferno_option[$field['id']] = null;
                        }
                    }
                }
            }
        }

        public function canvas() 
        {
            require_once('canvas.php'); 
        }

        /**
         * panel navigation
         * @return void
         */
        private function menu() 
        { 
            if( !isset( $this->theme_settings ) || !is_array( $this->theme_settings ) || empty( $this->theme_settings ) ) return false;

            $i = 1; foreach( $this->theme_settings as $topic ) : ?>
            <li><?php echo '<a href="#tab-' . $i . '" id="tablink-' . $i . '"><i class="icon-' . $topic[ 'icon' ] . '"></i><span>' . $topic[ 'title' ] . '</span></a>'; ?></li>
            <?php $i++; endforeach;
        }

        private function tabs()
        {
            global $inferno_option;

            if( isset( $this->theme_settings ) && is_array( $this->theme_settings ) && !empty( $this->theme_settings ) ) {
                $count = 1;
                foreach( $this->theme_settings as $topic ) : ?>
                    <!-- BEGIN .tab-content -->
                    <div id="tab-<?php echo $count; ?>" class="tab-content">
                        <?php 
                        foreach( $topic[ 'fields' ] as $field ) {
                            $option = new Inferno_Options_Machine( $field, $inferno_option[ $field[ 'id' ] ] );
                        }
                        ?>
                    <!-- END .tab-content -->
                    </div>
                    <?php $count++;
                endforeach;
            }
        }
    }
}
