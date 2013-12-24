<?php

/**
 * Define for the beginning.
 */

define('INFERNO', basename(dirname(__FILE__)));
define('INFERNO_URL', trailingslashit(get_template_directory_uri()) . trailingslashit(basename(dirname(__FILE__))));
define('INFERNO_PATH', trailingslashit(get_template_directory()) . trailingslashit(basename(dirname(__FILE__))));
define('INFERNO_VERSION', '1.0');

if(!class_exists('Inferno')) {
    class Inferno {

        /**
         * This is the config. Initially turn off everything.
         *
         * @var array
         */
        private $_config = array(
            'canvas'      => false,
            'shortcodes'  => false,
            'meta-box'    => false,
            'breadcrumbs' => false,
            'portfolio'   => false
        );

        /**
         * Debug constant
         * @var boolean
         */
        public static $_debug = false;


        /**
         * Register all styles which come with the theme framework.
         * 
         * @var array
         */
        public $register_styles = array(
            array('css3d', 'assets/css/supports3d.css', false, INFERNO_VERSION, 'all'),
            array('flexslider', 'assets/css/flexslider.css', false, '2.1.1', 'all'),
            array('font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css', false, '4.0.3', 'all'),
            array('image-picker', 'assets/css/image-picker.css', false, '0.1.7', 'all'),
            array('inferno-admin', 'assets/css/admin.css', false, INFERNO_VERSION, 'all'),
            array('inferno-menu', 'assets/css/menu.css', false, INFERNO_VERSION, 'all'),
            array('inferno-colorpicker', 'assets/css/colorpicker.css', false, null, 'all'),
            array('inferno-widgets', 'assets/css/widgets.css', false, INFERNO_VERSION, 'all'),
            array('inferno-portfolio', 'assets/css/portfolio.css', false, INFERNO_VERSION, 'all'),
            array('inferno-ui-helper', 'assets/css/ui-helper.css', false, INFERNO_VERSION, 'all'),
            array('jscrollpane', 'assets/css/jscrollpane.css', false, '2.0.19', 'all'),
            array('magnific-popup', 'assets/css/magnific-popup.css', false, '0.9.7', 'all'),
            array('normalize', 'assets/css/normalize.css', false, INFERNO_VERSION, 'all'),
            array('perfect-scrollbar', 'assets/css/perfect-scrollbar.css', false, '0.4.6', 'all'),
            array('structurize', 'assets/css/structurize.css', false, INFERNO_VERSION, 'all'),
            array('structurize-responsive', 'assets/css/structurize-responsive.css', false, INFERNO_VERSION, 'all'),
            array('shortcodes', 'assets/css/shortcodes.css', false, INFERNO_VERSION, 'all'),
            array('wpstyles', 'assets/css/wpstyles.css', false, INFERNO_VERSION, 'all')
        );

        /**
         * Register all scripts which come with the theme framework.
         *
         * @var array
         */
        public $register_scripts = array(
            array('eventemitter', 'assets/js/event-emitter.js', false, '4.2.5', true),
            array('inferno', 'assets/js/inferno.js', array('jquery'), INFERNO_VERSION, true),
            array('inferno-admin', 'assets/js/admin.js', array('jquery'), INFERNO_VERSION, true),
            array('iscroll', 'assets/js/iscroll.js', false, '4.2.5', true),
            array('jquery-blur', 'assets/js/jquery/jquery.blur.js', array('jquery'), '1', true),
            array('jquery-colorbox', 'assets/js/jquery/jquery.colorbox.js', array('jquery'), '1.4.10', true),
            array('jquery-colorpicker', 'assets/js/jquery/jquery.colorpicker.js', array('jquery'), null, true),
            array('jquery-cookie', 'assets/js/jquery/jquery.cookie.js', array('jquery'), '1.3.1', true),
            array('jquery-confirm', 'assets/js/jquery/jquery.confirm.js', array('jquery'), '1.3', true),
            array('jquery-css-transform', 'assets/js/jquery/jquery.css.transform.js', array('jquery'), null, true),
            array('jquery-easing', 'assets/js/jquery/jquery.easing.js', array('jquery'), '1.3', true),
            array('jquery-fitvids', 'assets/js/jquery/jquery.fitvids.js', array('jquery'), '1.0', true),
            array('jquery-flexslider', 'assets/js/jquery/jquery.flexslider.js', array('jquery'), '2.1', true),
            array('jquery-hoverintent', 'assets/js/jquery/jquery.hoverintent.js', array('jquery'), 'r7', true),
            array('jquery-image-picker', 'assets/js/jquery/jquery.image-picker.js', array('jquery'), '0.1.7', true),
            array('jquery-imagesloaded', 'assets/js/jquery/jquery.imagesloaded.js', array('jquery', 'eventemitter'), '3.0.4', true),
            array('jquery-infinitescroll', 'assets/js/jquery/jquery.infinitescroll.js', array('jquery'), '2.0b2.120519', true),
            array('jquery-infinitescroll-behavior-local', 'assets/js/jquery/jquery.infinitescroll.behavior-local.js', array('jquery-infinitescroll'), '2.0b2.120519', true),
            array('jquery-isotope', 'assets/js/jquery/jquery.isotope.js', array('jquery'), '1.5.25', true),
            array('jquery-jscrollpane', 'assets/js/jquery/jquery.jscrollpane.js', array('jquery'), '2.0.19', true),
            array('jquery-magnific-popup', 'assets/js/jquery/jquery.magnific-popup.js', array('jquery'), '0.9.7', true),
            array('jquery-mousewheel', 'assets/js/jquery/jquery.mousewheel.js', array('jquery'), '3.1.8', true),
            array('jquery-perfect-scrollbar', 'assets/js/jquery/jquery.perfect-scrollbar.js', array('jquery'), '0.4.6', true),
            array('jquery-pjax', 'assets/js/jquery/jquery.pjax.js', array('jquery'), '1.7.3', true),
            array('jquery-placeholder', 'assets/js/jquery/jquery.placeholder.js', array('jquery'), '2.0.7', true),
            array('jquery-rotate', 'assets/js/jquery/jquery.rotate.js', array('jquery'), null, true),
            array('jquery-scrollto', 'assets/js/jquery/jquery.scrollto.js', array('jquery'), '1.4.5 BETA', true),
            array('jquery-superfish', 'assets/js/jquery/jquery.superfish.js', array('jquery'), '1.7.2', true),
            array('jquery-tinynav', 'assets/js/jquery/jquery.tinynav.js', array('jquery'), '1.0.14', true),
            array('jquery-tweet', 'assets/js/jquery/jquery.tweet.js', array('jquery'), null, true),
            array('modernizr', 'assets/js/modernizr.js', false, '2.6.2', true),
            array('responsive-nav', 'assets/js/responsivenav.js', false, '1.0.14', true)
        );


        /**
         * The script handles needed for any inferno administration purposes
         */
        public static $admin_scripts = array(
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
            'jquery-image-picker',
            'jquery-confirm',
            'jquery-colorpicker',
            'inferno-admin'
        );

        /**
         * The style handles needed for any inferno administration purposes
         */
        public static $admin_styles = array(
            'thickbox',
            'inferno-colorpicker',
            'font-awesome',
            'image-picker',
            'inferno-admin',
            'inferno-ui-helper'
        );


        /**
         * Get configuration for optional modules and call initialization functions.
         */
        public function __construct($debug = false)
        {
            self::$_debug = $debug;

            $this->_config['canvas']     = get_theme_support( 'inferno-canvas' );
            $this->_config['shortcodes'] = get_theme_support( 'inferno-shortcodes' );
            $this->_config['meta-box']   = get_theme_support( 'inferno-meta-box' );
            $this->_config['portfolio']  = get_theme_support( 'inferno-portfolio' );

            $this->load();
            $this->load_widgets();
            $this->actions();
        }

        /**
         * Include and initialize basic resources. Check for optional modules to load, if enqueued, load them, too.
         */
        private function load()
        {
            require_once(dirname(__FILE__) . '/inc/class-tgm-plugin-activation.php');
            require_once(dirname(__FILE__) . '/inc/functions.php');
            require_once(dirname(__FILE__) . '/inc/aq_resizer.php');
            require_once(dirname(__FILE__) . '/inc/class-preview.php');
            require_once(dirname(__FILE__) . '/inc/class-widget.php');

            // options machine
            if($this->_config['canvas'] || $this->_config['shortcodes'] || $this->_config['meta_box']) {
                require_once(dirname(__FILE__) . '/inc/class-options-machine.php');
            }

            // meta boxes
            if( $this->_config['meta-box'][0] ) {
                require_once(dirname(__FILE__) . '/inc/class-meta-box.php');

                if(isset($this->_config['meta-box'][0]['file']) && is_string($this->_config['meta-box'][0]['file'])) {
                    foreach( include( locate_template( $this->_config['meta-box'][0]['file'] ) ) as $meta_box ) {
                        new Inferno_Meta_Box( $meta_box );
                    }
                }
            }

            // shortcodes
            if( $this->_config['shortcodes'] ) {
                require( dirname(__FILE__) . '/shortcodes/class-shortcode-generator.php' );

                new Inferno_Shortcode_Generator();
            }

            if( $this->_config['portfolio'] ) {
                require( dirname(__FILE__) . '/portfolio/class-portfolio.php' );

                new Inferno_Portfolio();
            }

            // canvas
            if( $this->_config['canvas'] ) {
                require( dirname( __FILE__ ) . '/canvas/class-canvas.php' );
                $current_user = wp_get_current_user();

                // TODO maybe do this in a cooler way?
                if($this->_config['canvas'][0]['demo_mode'] == true 
                    && isset($this->_config['canvas'][0]['demo_account'])
                    && (!is_user_logged_in()
                    || $current_user->user_login == $this->_config['canvas'][0]['demo_account'])) {
                    require( dirname( __FILE__ ) . '/canvas/class-demo-canvas.php' );
                    new Inferno_Demo_Canvas();
                } else {
                    new Inferno_Canvas();
                }
            }

            // todo: require_once(dirname(__FILE__) . '/inc/breadcrumbs.php');
            // todo: require_once(dirname(__FILE__) . '/inc/pagination.php');
            // todo: require_once(dirname(__FILE__) . '/builder/class-builder.php');
        }

        public function actions()
        {
            add_action('init', array(&$this, 'assets'));
            add_action('init', array(&$this, 'fixing_hooks')); // make that dynamically callable
            add_action('after_setup_theme', array(&$this, 'translate'));
            add_action('admin_enqueue_scripts', array(&$this, 'admin_enqueue'));
        }

        public function assets()
        {
            if(is_array($this->register_scripts) && !empty($this->register_scripts)) {
                foreach($this->register_scripts as $script) {
                    wp_deregister_script($script[0]);
                    wp_register_script($script[0], (substr($script[1], 0, 2) == '//' ? null : get_template_directory_uri() . '/' . basename(dirname(__FILE__)) . '/') . $script[1], $script[2], $script[3], $script[4]);
                }
            }

            if(is_array($this->register_styles) && !empty($this->register_styles)) {
                foreach($this->register_styles as $style) {
                    wp_deregister_style($style[0]);
                    wp_register_style($style[0], (substr($style[1], 0, 2) == '//' ? null : get_template_directory_uri() . '/' . basename(dirname(__FILE__)) . '/') . $style[1], $style[2], $style[3], $style[4]);
                }
            }
        }

        /**
         * see http://wordpress.stackexchange.com/questions/41207/how-do-i-enqueue-styles-scripts-on-certain-wp-admin-pages and 
         * http://codex.wordpress.org/Plugin_API/Action_Reference/admin_enqueue_scripts for more details. maybe improve this some time
         */
        public function admin_enqueue($hook)
        {
            if((($this->_config['shortcodes'] || $this->_config['meta-box']) && ($hook == 'post.php' || $hook == 'post-new.php')) || 
            ($this->_config['canvas'] && $hook == 'appearance_page_inferno-admin')) {
                foreach(self::$admin_scripts as $script) {
                    wp_enqueue_script($script);
                }
                foreach(self::$admin_styles as $style) {
                    wp_enqueue_style($style);
                }
            }
        }

        public function fixing_hooks()
        {
            // remove wp default gallery inline style
            add_filter('use_default_gallery_style', '__return_false'); 
        }

        public function translate()
        {
            load_theme_textdomain( 'inferno', INFERNO_PATH . 'languages' );
        }

        private function load_widgets()
        {
            require_once( 'widgets/widget-video.php' );
            require_once( 'widgets/widget-socialcounter.php' );
            require_once( 'widgets/widget-openinghours.php' );
            require_once( 'widgets/widget-recenttweets.php' );
            require_once( 'widgets/widget-socialprofiles.php' );
            require_once( 'widgets/widget-flickr.php' );
        }
    }
}