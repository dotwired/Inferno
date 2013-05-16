<?php

/**
 * Define for the beginning.
 */

define('INFERNO_VERSION', '1.0');
define('INFERNO_URL', trailingslashit(get_template_directory_uri()) . trailingslashit(basename(dirname(__FILE__))));



if(!class_exists('Inferno')) {
    class Inferno {

        private $_config = array();

        /**
         * register all styles which come with the theme framework
         * array( $handle => array( $src, $dependencies, $version, $media ), ... )
         * 
         * @var array
         */
        public $register_styles = array(
            'normalize' => array(
                'assets/css/normalize.css', false, INFERNO_VERSION, 'all'
            ),
            'wpstyles' => array(
                'assets/css/wpstyles.css', false, INFERNO_VERSION, 'all'
            ),
            'inferno-menu' => array(
                'assets/css/menu.css', false, INFERNO_VERSION, 'all'
            ),
            'inferno'               => array(
                'assets/css/panel.css', false, INFERNO_VERSION, 'all'
            ),
            'panel-colorpicker'     => array(
                'assets/css/colorpicker.css', false, null, 'all'
            ),
            'css3d'                 => array(
                'assets/css/supports3d.css', array('infernal-flame'), INFERNO_VERSION, 'all'
            ),
            'flexslider'            => array(
                'assets/css/flexslider.css', false, '2.1.1', 'all'
            ),
            'font-awesome'          => array(
                'assets/css/font-awesome.css', false, '3.0.2', 'all'
            ),
            'admin-infernal-panel'   => array(
                'assets/css/admin/panel.css', false, INFERNO_VERSION, 'all'
            ),
            'admin-infernal-society' => array(
                'assets/css/admin/society.css', false, INFERNO_VERSION, 'all'
            )
        );

        public $register_scripts = array(
            'modernizr'             => array(
                'assets/js/modernizr.min.js', false, '2.6.2', true
            ),
            'jquery-colorbox'       => array(
                'assets/js/jquery/jquery.colorbox.min.js', array('jquery'), '1.4.10', true
            ),
            'jquery-colorpicker'    => array(
                'assets/js/jquery/jquery.colorpicker.min.js', array('jquery'), null, true
            ),
            'jquery-cookie'         => array(
                'assets/js/jquery/jquery.cookie.min.js', array('jquery'), '1.3.1', true
            ),
            'jquery-confirm'        => array(
                'assets/js/jquery/jquery.confirm.min.js', array('jquery'), '1.3', true
            ),
            'jquery-css-transform'  => array(
                'assets/js/jquery/jquery.css.transform.min.js', array('jquery'), null, true
            ),
            'jquery-easing'         => array(
                'assets/js/jquery/jquery.easing.min.js', array('jquery'), '1.3', true
            ),
            'jquery-flexslider'     => array(
                'assets/js/jquery/jquery.flexslider.min.js', array('jquery'), '2.1', true
            ),
            'jquery-hoverintent'    => array(
                'assets/js/jquery/jquery.hoverintent.min.js', array('jquery'), 'r7', true
            ),
            'jquery-imagesloaded'   => array(
                'assets/js/jquery/jquery.imagesloaded.min.js', array('jquery'), '2.1.1', true
            ),
            'jquery-infinitescroll' => array(
                'assets/js/jquery/jquery.infinitescroll.min.js', array('jquery'), '2.0b2.120519', true
            ),
            'jquery-isotope'        => array(
                'assets/js/jquery/jquery.isotope.min.js', array('jquery'), '1.5.25', true
            ),
            'jquery-placeholder'    => array(
                'assets/js/jquery/jquery.placeholder.min.js', array('jquery'), '2.0.7', true
            ),
            'jquery-rotate'       => array(
                'assets/js/jquery/jquery.rotate.min.js', array('jquery'), null, true
            ),
            'jquery-scrollto'       => array(
                'assets/js/jquery/jquery.scrollto.min.js', array('jquery'), '1.4.5 BETA', true
            ),
            'jquery-superfish'      => array(
                'assets/js/jquery/jquery.superfish.min.js', array('jquery'), '1.7.2', true
            ),
            'jquery-tinynav'        => array(
                'assets/js/jquery/jquery.tinynav.min.js', array('jquery'), '1.0.14', true
            ),
            'jquery-tweet'          => array(
                'assets/js/jquery/jquery.tweet.min.js', array('jquery'), null, true
            ),
            'inferno-panel'        => array(
                'assets/js/panel.js', array('jquery'), INFERNO_VERSION, true
            ),
            'inferno-portfolio'    => array(
                'assets/js/portfolio.js', array('jquery'), INFERNO_VERSION, true
            ),
            'inferno-slider'       => array(
                'assets/js/slider.js', array('jquery'), INFERNO_VERSION, true
            ),
            'flame-data'            => array(
                'assets/js/flame-data.js.php', array('jquery'), INFERNO_VERSION, true
            ),
            'flame'                 => array(
                'assets/js/flame.js', array('jquery', 'modernizr'), INFERNO_VERSION, true
            ),
            'responsive-nav'        => array(
                'assets/js/responsivenav.min.js', false, '1.0.14', true
            ),
        );


        public $admin_enqueue_scripts = array(
            'jquery',
            'jquery-ui-core',
            'jquery-ui-widget',
            'jquery-ui-tabs',
            'jquery-ui-slider',
            'jquery-ui-sortable',
            'jquery-ui-button',
            'jquery-form',
            'media-upload',
            'thickbox',
            'jquery-confirm',
            'jquery-colorpicker',
            'inferno-panel'
        );

        public $admin_enqueue_styles = array(
            'thickbox',
            'admin-inferno-panel',
            'panel-colorpicker',
            'font-awesome',
            'inferno'
        );

        public function __construct($_config)
        {
            $this->_config = $_config;
            $this->actions();
            $this->admin_update_page();

            require_once('inc/inferno-helper.php');
            require_once('admin/engine.php');
            new Inferno_Panel_Engine($_config);
        }

        public function menu($menu = null) {
            wp_nav_menu(array(
                'menu' => $menu
            ));
        }

        public function actions()
        {
            add_action('init', array(&$this, 'add_menus'));
            add_action('init', array(&$this, 'assets'));
            add_action('init', array(&$this, 'fixing_hooks'));
            add_action('widgets_init', array(&$this, 'register_sidebars'));
            add_action('after_setup_theme', 'translate');
        }

        public function add_menus()
        {
            register_nav_menus($this->_config['menus']);
        }

        public function register_sidebars()
        {
            foreach($this->_config['sidebars'] as $id => $title) {
                register_sidebar(
                    array(
                        'name'          => $title,
                        'id'            => $id,
                        'before_widget' => '<div id="%1$s" class="block %2$s">',
                        'after_widget'  => '<div class="clear"></div></div>',
                        'before_title'  => '<h3>',
                        'after_title'   => '</h3>',
                    )
                );
            }
        }

        public function assets()
        {
            if(is_array($this->register_scripts) && !empty($this->register_scripts)) {
                foreach($this->register_scripts as $handle => $data) {
                    wp_deregister_script($handle);
                    wp_register_script($handle, get_template_directory_uri() . '/framework/' . $data[0], $data[1], $data[2], $data[3]);
                }
            }

            if(is_array($this->register_styles) && !empty($this->register_styles)) {
                foreach($this->register_styles as $handle => $data) {
                    wp_deregister_style($handle);
                    wp_register_style($handle, get_template_directory_uri() . '/framework/' . $data[0], $data[1], $data[2], $data[3]);
                }
            }

            add_action('admin_enqueue_scripts', array(&$this, 'admin_enqueue'));
            add_action('wp_enqueue_scripts', array(&$this, 'enqueue'), 1);
        }

        function admin_enqueue()
        {
            foreach($this->admin_enqueue_scripts as $handle)
                wp_enqueue_script($handle);

            foreach($this->admin_enqueue_styles as $handle)
                wp_enqueue_style($handle);
        }

        public function fixing_hooks()
        {
            add_filter('use_default_gallery_style', '__return_false'); // remove wp default gallery inline style
        }

        public function register_featured_images()
        {
            add_theme_support('post-thumbnails');
            set_post_thumbnail_size(100, 100, true);
        }

        public function translate()
        {
            load_theme_textdomain($this->_config['theme_slug'], get_template_directory() . '/languages');
        }

        public function load_plugins()
        {
            foreach($this->_config['plugins'] as $plugin_handle) {
                if($plugin_handle == 'multiple-featured-images') {
                    require_once(dirname(__FILE__) . '/plugins/multiple-featured-images/multiple-featured-images.php');
                }
            }
        }

        public function admin_update_page()
        {
            if($this->_config['update_mode'] == 'themeforest') {
                require_once(dirname(__FILE__) . '/plugins/envato-wordpress-toolkit/index.php');
            }
        }

        public function getConfig()
        {
            return $this->_config;
        }
    }
}