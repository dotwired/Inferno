<?php

if(!class_exists( 'Inferno_Shortcode_Generator' ) ) {
  class Inferno_Shortcode_Generator
  {
    public $shortcodes = array();

    public function __construct() 
    {            
      $theme_support = get_theme_support('inferno-shortcode-generator');

      if(isset($theme_support[0]['file']) && is_string($theme_support[0]['file'])) {
        $tmp_shortcodes = include ( locate_template( $theme_support[0]['file'] ) );
        $this->shortcodes = $tmp_shortcodes;
        unset($tmp_shortcodes);
      }

      if($theme_support[0]['builtin-shortcodes'] === true) {
        $tmp_shortcodes = include(dirname(__FILE__) . '/shortcodes.php');
        $this->shortcodes = array_merge($this->shortcodes, $tmp_shortcodes);
      }

      add_action( 'media_buttons', array( &$this, 'add_generator_button' ), 100 );
      add_action( 'admin_footer', array( &$this, 'generator_popup' ) );
    }

    public function add_generator_button( $page = null, $target = null ) 
    {
      echo '<a href="#inferno-generator" data-editor="content" class="button mfp inferno-shortcode-generator-button"><span class="wp-media-buttons-icon"><i class="fa fa-gamepad"></i></span> ' . __( 'Insert Shortcode', 'inferno' ) . '</a>';
    }

    public function generator_popup() 
    {
      $screen = get_current_screen();
      if($screen->base == 'post')
        include( 'generator-popup.php' );
    }
  }
}