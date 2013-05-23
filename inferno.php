<?php

/**
 * Define for the beginning.
 */

define('INFERNO', basename(dirname(__FILE__)));
define('INFERNO_URL', trailingslashit(get_template_directory_uri()) . trailingslashit(basename(dirname(__FILE__))));
define('INFERNO_VERSION', '1.0');

if(!class_exists('Inferno')) {
    class Inferno {

        /**
         * the config
         * 
         * @var array
         */
        private $_config = array();

        /**
         * register all styles which come with the theme framework
         * 
         * @var array
         */
        public $register_styles = array(
            array('css3d', 'assets/css/supports3d.css', array('infernal-flame'), INFERNO_VERSION, 'all'),
            array('flexslider', 'assets/css/flexslider.css', false, '2.1.1', 'all'),
            array('font-awesome', 'assets/css/font-awesome.css', false, '3.0.2', 'all'),
            array('inferno', 'assets/css/inferno.css', false, INFERNO_VERSION, 'all'),
            array('inferno-menu', 'assets/css/menu.css', false, INFERNO_VERSION, 'all'),
            array('inferno-colorpicker', 'assets/css/colorpicker.css', false, null, 'all'),
            array('normalize', 'assets/css/normalize.css', false, INFERNO_VERSION, 'all'),
            array('structurize', 'assets/css/structurize.css', false, INFERNO_VERSION, 'all'),
            array('shortcodes', 'assets/css/shortcodes.css', false, INFERNO_VERSION, 'all'),
            array('wpstyles', 'assets/css/wpstyles.css', false, INFERNO_VERSION, 'all')  
        );

        /**
         * register all scripts which come with the theme framework
         * 
         * @var array
         */
        public $register_scripts = array(
            array('inferno', 'assets/js/inferno.js', array('jquery'), INFERNO_VERSION, true),
            array('jquery-colorbox', 'assets/js/jquery/jquery.colorbox.min.js', array('jquery'), '1.4.10', true),
            array('jquery-colorpicker', 'assets/js/jquery/jquery.colorpicker.min.js', array('jquery'), null, true),
            array('jquery-cookie', 'assets/js/jquery/jquery.cookie.min.js', array('jquery'), '1.3.1', true),
            array('jquery-confirm', 'assets/js/jquery/jquery.confirm.min.js', array('jquery'), '1.3', true),
            array('jquery-css-transform', 'assets/js/jquery/jquery.css.transform.min.js', array('jquery'), null, true),
            array('jquery-easing', 'assets/js/jquery/jquery.easing.min.js', array('jquery'), '1.3', true),
            array('jquery-flexslider', 'assets/js/jquery/jquery.flexslider.min.js', array('jquery'), '2.1', true),
            array('jquery-hoverintent', 'assets/js/jquery/jquery.hoverintent.min.js', array('jquery'), 'r7', true),
            array('jquery-imagesloaded', 'assets/js/jquery/jquery.imagesloaded.min.js', array('jquery'), '2.1.1', true),
            array('jquery-infinitescroll', 'assets/js/jquery/jquery.infinitescroll.min.js', array('jquery'), '2.0b2.120519', true),
            array('jquery-isotope', 'assets/js/jquery/jquery.isotope.min.js', array('jquery'), '1.5.25', true),
            array('jquery-placeholder', 'assets/js/jquery/jquery.placeholder.min.js', array('jquery'), '2.0.7', true),
            array('jquery-rotate', 'assets/js/jquery/jquery.rotate.min.js', array('jquery'), null, true),
            array('jquery-scrollto', 'assets/js/jquery/jquery.scrollto.min.js', array('jquery'), '1.4.5 BETA', true),
            array('jquery-superfish', 'assets/js/jquery/jquery.superfish.min.js', array('jquery'), '1.7.2', true),
            array('jquery-tinynav', 'assets/js/jquery/jquery.tinynav.min.js', array('jquery'), '1.0.14', true),
            array('jquery-tweet', 'assets/js/jquery/jquery.tweet.min.js', array('jquery'), null, true),
            array('modernizr', 'assets/js/modernizr.min.js', false, '2.6.2', true),
            array('responsive-nav', 'assets/js/responsivenav.min.js', false, '1.0.14', true)
        );

        public function __construct($_config)
        {
            $this->_config = $_config;
            $this->load();
            $this->actions();
            $this->init_meta_boxes();

            new Inferno_Canvas();
            new Inferno_Shortcodes();
        }

        private function load()
        {
            require_once(dirname(__FILE__) . '/inc/functions.php');
            require_once(dirname(__FILE__) . '/inc/aq_resizer.php');

            //require_once(dirname(__FILE__) . '/inc/class-helper.php');
            require_once(dirname(__FILE__) . '/inc/class-options-machine.php');
            require_once(dirname(__FILE__) . '/inc/class-meta-box.php');
            require_once(dirname(__FILE__) . '/inc/class-shortcodes.php');
            require_once(dirname(__FILE__) . '/inc/class-preview.php');

            // todo: require_once(dirname(__FILE__) . '/inc/breadcrumb.php');
            // todo: require_once(dirname(__FILE__) . '/inc/pagination.php');

            require_once(dirname(__FILE__) . '/canvas/class-canvas.php');
            // todo: require_once(dirname(__FILE__) . '/builder/class-builder.php');
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
                foreach($this->register_scripts as $script) {
                    wp_deregister_script($script[0]);
                    wp_register_script($script[0], get_template_directory_uri() . '/' . basename(dirname(__FILE__)) . '/' . $script[1], $script[2], $script[3], $script[4]);
                }
            }

            if(is_array($this->register_styles) && !empty($this->register_styles)) {
                foreach($this->register_styles as $style) {
                    wp_deregister_style($style[0]);
                    wp_register_style($style[0], get_template_directory_uri() . '/' . basename(dirname(__FILE__)) . '/' . $style[1], $style[2], $style[3], $style[4]);
                }
            }
        }

        public function fixing_hooks()
        {
            // remove wp default gallery inline style
            add_filter('use_default_gallery_style', '__return_false'); 

            add_theme_support('post-thumbnails');
            set_post_thumbnail_size(300, 300, true);
        }

        public function translate()
        {
            load_theme_textdomain($this->_config['theme_slug'], get_template_directory() . '/languages');
        }

        public function getConfig()
        {
            return $this->_config;
        }

        private function init_meta_boxes()
        {
            $meta_boxes = require_once get_template_directory() . '/config/meta-boxes.php';

            foreach($meta_boxes as $meta_box) {
                new Inferno_Meta_Box($meta_box);
            }
        }
    }
}