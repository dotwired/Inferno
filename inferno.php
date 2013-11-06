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
         * Register all styles which come with the theme framework.
         * 
         * @var array
         */
        public $register_styles = array(
            array('css3d', 'assets/css/supports3d.css', false, INFERNO_VERSION, 'all'),
            array('flexslider', 'assets/css/flexslider.css', false, '2.1.1', 'all'),
            array('font-awesome', 'assets/css/font-awesome.css', false, '3.0.2', 'all'),
            array('image-picker', 'assets/css/image-picker.css', false, '0.1.7', 'all'),
            array('inferno-admin', 'assets/css/admin.css', false, INFERNO_VERSION, 'all'),
            array('inferno-menu', 'assets/css/menu.css', false, INFERNO_VERSION, 'all'),
            array('inferno-colorpicker', 'assets/css/colorpicker.css', false, null, 'all'),
            array('inferno-widgets', 'assets/css/widgets.css', false, INFERNO_VERSION, 'all'),
            array('inferno-portfolio', 'assets/css/portfolio.css', false, INFERNO_VERSION, 'all'),
            array('magnific-popup', 'assets/css/magnific-popup.css', false, '0.9.7', 'all'),
            array('normalize', 'assets/css/normalize.css', false, INFERNO_VERSION, 'all'),
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
            array('inferno', 'assets/js/inferno.js', array('jquery'), INFERNO_VERSION, true),
            array('inferno-admin', 'assets/js/admin.js', array('jquery'), INFERNO_VERSION, true),
            array('jquery-colorbox', 'assets/js/jquery/jquery.colorbox.min.js', array('jquery'), '1.4.10', true),
            array('jquery-colorpicker', 'assets/js/jquery/jquery.colorpicker.min.js', array('jquery'), null, true),
            array('jquery-cookie', 'assets/js/jquery/jquery.cookie.min.js', array('jquery'), '1.3.1', true),
            array('jquery-confirm', 'assets/js/jquery/jquery.confirm.min.js', array('jquery'), '1.3', true),
            array('jquery-css-transform', 'assets/js/jquery/jquery.css.transform.min.js', array('jquery'), null, true),
            array('jquery-easing', 'assets/js/jquery/jquery.easing.min.js', array('jquery'), '1.3', true),
            array('jquery-fitvids', 'assets/js/jquery/jquery.fitvids.min.js', array('jquery'), '1.0', true),
            array('jquery-flexslider', 'assets/js/jquery/jquery.flexslider.min.js', array('jquery'), '2.1', true),
            array('jquery-hoverintent', 'assets/js/jquery/jquery.hoverintent.min.js', array('jquery'), 'r7', true),
            array('jquery-image-picker', 'assets/js/jquery/jquery.image-picker.min.js', array('jquery'), '0.1.7', true),
            array('jquery-imagesloaded', 'assets/js/jquery/jquery.imagesloaded.min.js', array('jquery'), '2.1.1', true),
            array('jquery-infinitescroll', 'assets/js/jquery/jquery.infinitescroll.min.js', array('jquery'), '2.0b2.120519', true),
            array('jquery-isotope', 'assets/js/jquery/jquery.isotope.min.js', array('jquery'), '1.5.25', true),
            array('jquery-magnific-popup', 'assets/js/jquery/jquery.magnific-popup.min.js', array('jquery'), '0.9.7', true),
            array('jquery-placeholder', 'assets/js/jquery/jquery.placeholder.min.js', array('jquery'), '2.0.7', true),
            array('jquery-rotate', 'assets/js/jquery/jquery.rotate.min.js', array('jquery'), null, true),
            array('jquery-scrollto', 'assets/js/jquery/jquery.scrollto.min.js', array('jquery'), '1.4.5 BETA', true),
            array('jquery-superfish', 'assets/js/jquery/jquery.superfish.min.js', array('jquery'), '1.7.2', true),
            array('jquery-tinynav', 'assets/js/jquery/jquery.tinynav.min.js', array('jquery'), '1.0.14', true),
            array('jquery-tweet', 'assets/js/jquery/jquery.tweet.min.js', array('jquery'), null, true),
            array('modernizr', 'assets/js/modernizr.min.js', false, '2.6.2', true),
            array('responsive-nav', 'assets/js/responsivenav.min.js', false, '1.0.14', true)
        );


        /**
         * Get configuration for optional modules and call initialization functions.
         */
        public function __construct()
        {
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
            // todo: remove that? require_once(dirname(__FILE__) . '/inc/class-helper.php');

            // options machine
            if($this->_config['canvas'] || $this->_config['shortcodes'] || $this->_config['meta_box']) {
                require_once(dirname(__FILE__) . '/inc/class-options-machine.php');
            }
            
            // meta boxes
            if( $this->_config['meta-box'][0] ) {
                require_once(dirname(__FILE__) . '/inc/class-meta-box.php');

                if(isset($this->_config['meta-box'][0]['file']) && is_string($this->_config['meta-box'][0]['file'])) {
                    foreach( @include_once($this->_config['meta-box'][0]['file']) as $meta_box ) {
                        new Inferno_Meta_Box( $meta_box );
                    }
                }
            }

            // shortcodes
            if( $this->_config['shortcodes'] ) {
                require_once( dirname(__FILE__) . '/shortcodes/class-shortcode-generator.php' );

                new Inferno_Shortcode_Generator();
            }

            if( $this->_config['portfolio'] ) {
                require_once( dirname(__FILE__) . '/portfolio/class-portfolio.php' );

                new Inferno_Portfolio();
            }

            // canvas
            if( $this->_config['canvas'] ) {
                require_once( dirname( __FILE__ ) . '/canvas/class-canvas.php' );
                new Inferno_Canvas();
            }

            // todo: require_once(dirname(__FILE__) . '/inc/breadcrumbs.php');
            // todo: require_once(dirname(__FILE__) . '/inc/pagination.php');
            // todo: require_once(dirname(__FILE__) . '/builder/class-builder.php');
        }

        public function actions()
        {
            add_action('init', array(&$this, 'assets'));
            add_action('init', array(&$this, 'fixing_hooks'));
            add_action('after_setup_theme', array(&$this, 'translate'));
            add_action('admin_enqueue_scripts', array(&$this, 'admin_enqueue'));
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

        /**
         * see http://wordpress.stackexchange.com/questions/41207/how-do-i-enqueue-styles-scripts-on-certain-wp-admin-pages and 
         * http://codex.wordpress.org/Plugin_API/Action_Reference/admin_enqueue_scripts for more details. maybe improve this some time
         */
        public function admin_enqueue($hook)
        {
            if((($this->_config['shortcodes'] || $this->_config['meta-box']) && ($hook == 'post.php' || $hook == 'post-new.php')) || 
                    ($this->_config['canvas'] && $hook == 'appearance_page_inferno-admin')) {
                wp_enqueue_script('jquery');
                wp_enqueue_script('jquery-ui-core');
                wp_enqueue_script('jquery-ui-widget');
                wp_enqueue_script('jquery-ui-tabs');
                wp_enqueue_script('jquery-ui-slider');
                wp_enqueue_script('jquery-ui-sortable');
                wp_enqueue_script('jquery-ui-button');
                wp_enqueue_script('jquery-form');
                wp_enqueue_script('media-upload');
                wp_enqueue_script('thickbox');
                wp_enqueue_script('jquery-image-picker');
                wp_enqueue_script('jquery-confirm');
                wp_enqueue_script('jquery-colorpicker');
                wp_enqueue_script('inferno-admin');

                wp_enqueue_style('thickbox');
                wp_enqueue_style('inferno-colorpicker');
                wp_enqueue_style('font-awesome');
                wp_enqueue_style('image-picker');
                wp_enqueue_style('inferno-admin');
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