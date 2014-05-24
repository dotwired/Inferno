<?php 

if(!class_exists('Inferno_Demo_Canvas')) {

    class Inferno_Demo_Canvas extends Inferno_Canvas {

        private $_cookie_name = 'inferno_panel_demo_data';

        public function __construct()
        {
            require_once INFERNO_PATH . 'inc/class-cookie-handler.php';

            global $inferno_option;
            $this->setup();

            $this->demo_mode = true;
            $theme_support = get_theme_support('inferno-canvas');
            $this->demo_account = $theme_support[0]['demo_account'];

            //get options
            if(isset($_COOKIE[$this->_cookie_name])) {
                // TODO why do i need to unescape???
                $inferno_option = Inferno_Cookie_Handler::fetchcookie($this->_cookie_name);
            } else {
                $inferno_option = get_option($this->option_name, array());
                $this->standarize_options(); // important. Give undefined options their default values
            }

            // add the menu item to the wp admin menu
            add_action('admin_menu', array(&$this, 'admin_menu')); 

            // save data
            add_action('init', array(&$this, 'save')); 

            add_action('init', array(&$this, 'auto_login'));
            add_action('init', array(&$this, 'hide_admin_bar'));
            add_action('wp_footer', array(&$this, 'inject_panel'));
            add_action('wp_footer', array(&$this, 'inject_opener'));
            add_action('wp_enqueue_scripts', array(&$this, 'enqueue'));
        }

        public function enqueue()
        {
            foreach(Inferno::$admin_scripts as $script) {
                wp_enqueue_script($script);
            }
            foreach(Inferno::$admin_styles as $style) {
                wp_enqueue_style($style);
            }

            // additional scripts & styles for the demo
            wp_enqueue_script('jquery-magnific-popup');
            wp_enqueue_style('magnific-popup');

            $jsstrings = array(
                'demo_opener_qtip' => __('Play with the theme settings.', 'inferno'),
            );

            wp_localize_script('inferno-admin', 'INFERNO', $jsstrings);
        }

        public function auto_login()
        {
            if(!is_user_logged_in() && !inferno_is_login_page()) {
                $user_login = $this->demo_account;
                $user = get_user_by('login', $user_login);

                // login
                wp_set_current_user($user->ID, $user_login);
                wp_set_auth_cookie($user->ID);
                do_action('wp_login', $user_login);
            }
        }

        public function hide_admin_bar()
        {
            show_admin_bar(false);
        }

        public function inject_panel()
        {
            include('canvas.php');
        }

        public function inject_opener()
        {
            include('opener.php');
        }

        public function save()
        {
            global $inferno_option;

            // if there are some actions with the theme optionspage
            if(isset($_POST['inferno_action'])) {
                // save action
                if($_POST['inferno_action'] == 'save') {
                    foreach($this->theme_settings as $topic ) {
                        foreach($topic['fields'] as $field) {
                            if(isset($_POST[$field['id']]) && $field['type'] != 'transfer') {
                                $inferno_option[$field['id']] = trim(stripslashes($_POST[$field['id']]));

                                // if this is google font
                                if(isset($_POST[$field['id'] . '_googlefont']) && !empty($_POST[$field['id'].'_googlefont'])) {
                                    $inferno_option[$field['id']] = trim(stripslashes($_POST[$field['id'].'_googlefont']));
                                }
                            } else {
                                unset($inferno_option[$field['id']]);
                            }
                        }
                    }

                    // until end of session (close browser)
                    Inferno_Cookie_Handler::storecookie($this->_cookie_name, $inferno_option, 0);
                } elseif($_POST['inferno_action'] == 'reset' && isset($_COOKIE[$this->_cookie_name])) {
                    Inferno_Cookie_Handler::clearcookie($this->_cookie_name);
                } elseif($_POST['inferno_action'] == 'import') {
                    Inferno_Cookie_Handler::storecookie($this->_cookie_name, unserialize(base64_decode($_POST['transfer'])), 0);
                }

                $location = $_SERVER['REQUEST_URI'];
                header("Location: $location");
            }
        }
    }
}