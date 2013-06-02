<?php

if(!class_exists( 'Inferno_Shortcode_Generator' ) ) {

    class Inferno_Shortcode_Generator
    {

        private $shortcodes = array();

        public function __construct( $config = array() ) 
        {
            $this->shortcodes = require_once( 'shortcodes.php' );

            add_action( 'media_buttons', array( &$this, 'add_generator_button' ), 100 );
            add_action( 'admin_footer', array( &$this, 'generator_popup' ) );
        }

        public function add_generator_button( $page = null, $target = null ) 
        {
            echo '<a href="#TB_inline?width=640&height=600&inlineId=inferno-generator" class="button thickbox" data-page="' . $page . '" data-target="' . $target . '">[/] ' . __( 'Insert Shortcode', 'inferno' ) . '</a>';
        }

        public function generator_popup() 
        {
            require_once( 'generator.php' );
        }

        
    }
}