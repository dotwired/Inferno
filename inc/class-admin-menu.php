<?php

// see http://wordpress.stackexchange.com/questions/33342/how-to-add-a-custom-field-in-the-advanced-menu-properties
if(!class_exists('Inferno_Admin_Menu')) {
  class Inferno_Admin_Menu extends Inferno {

    private $inferno_options = array();

    public function __construct() 
    {
      require ABSPATH . 'wp-admin/includes/nav-menu.php';
      require_once(dirname(__FILE__) . '/class-walker-nav-menu-edit.php');

      add_action( 'admin_init', array($this, 'get_options'));
      add_filter( 'wp_edit_nav_menu_walker', array($this, 'nav_edit_walker'), 10, 2 );
      add_action( 'wp_update_nav_menu_item', array($this, 'nav_update'), 10, 3 );
      add_filter( 'wp_setup_nav_menu_item', array($this, 'nav_item') );
    }

    function get_options(){
      // TODO: can we eventually do this in one place only? class-walker-nav-menu-edit.php has same lines
      $theme_support = get_theme_support('inferno-menu-options');

      if(isset($theme_support[0]['file']) && is_string($theme_support[0]['file'])) {
        $tmp_options = include ( locate_template( $theme_support[0]['file'] ) );
        $this->inferno_options = $tmp_options['fields'];
      }
    }

    function nav_edit_walker($walker, $menu_id) {
      return 'Inferno_Walker_Nav_Menu_Edit';
    }


    /*
     * Adds value of new field to $item object that will be passed to     Walker_Nav_Menu_Edit_Custom
     */
    function nav_item($menu_item) {
      $menu_item->inferno = array();
      foreach($this->inferno_options as $field) {
        // third argument to false, because we need to check if the value actually exists
        $array = get_post_meta( $menu_item->ID, '_menu_item_' . $field['id'], false );
        if(!empty($array)) {
          $menu_item->inferno[$field['id']] = $array[0];
        } else {
          $menu_item->inferno[$field['id']] = isset($field['std']) ? $field['std'] : false;
        }
      }
      return $menu_item;
    }

    /*
     * Saves new field to postmeta for navigation
     */
    function nav_update( $menu_id, $menu_item_db_id, $args ) {
      foreach($this->inferno_options as $field) {
        if ( is_array($_REQUEST[$field['id']] ) && isset($_REQUEST[$field['id']][$menu_item_db_id])) {
          $value = $_REQUEST[$field['id']][$menu_item_db_id];
          update_post_meta( $menu_item_db_id, '_menu_item_' . $field['id'], $value );
        }
      }
    }
  }
}