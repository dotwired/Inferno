<?php

if(!class_exists( 'Inferno_Shortcode_Generator' ) ) {

    class Inferno_Shortcode_Generator
    {

        public $shortcodes = array();

        public function __construct() 
        {
            $theme_support = get_theme_support('inferno-shortcodes');

            if(isset($theme_support[0]['file']) && is_string($theme_support[0]['file'])) {
                $tmp_shortcodes = include ( locate_template( $theme_support[0]['file'] ) );
                $this->shortcodes = $tmp_shortcodes;
                unset($tmp_shortcodes);
            }

            if($theme_support[0]['builtin-shortcodes'] === true) {
                include( dirname(__FILE__) . '/class-shortcodes.php' );
                new Inferno_Shortcodes();
                $tmp_shortcodes = include(dirname(__FILE__) . '/shortcodes.php');
                $this->shortcodes[] = $tmp_shortcodes[0];
            }

            add_action( 'media_buttons', array( &$this, 'add_generator_button' ), 100 );
            add_action( 'admin_footer', array( &$this, 'generator_popup' ) );
        }

        public function add_generator_button( $page = null, $target = null ) 
        {
            echo '<a href="#TB_inline?width=640&height=600&inlineId=inferno-generator-wrap" class="button thickbox" data-page="' . $page . '" data-target="' . $target . '">[/] ' . __( 'Insert Shortcode', 'inferno' ) . '</a>';
        }

        public function generator_popup() 
        {
            include( 'generator-popup.php' );
        }
    }
}