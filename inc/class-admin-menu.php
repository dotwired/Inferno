<?php


if(!class_exists('Inferno_Admin_Menu')) {
  class Inferno_Admin_Menu extends Inferno {

    private $options = array();

    public function __construct() 
    {
      require ABSPATH . 'wp-admin/includes/nav-menu.php';
      require_once(dirname(__FILE__) . '/class-walker-nav-menu-edit.php');

      add_filter( 'wp_edit_nav_menu_walker', array($this, 'nav_edit_walker'), 10, 2 );
      add_action( 'wp_update_nav_menu_item', array($this, 'nav_update'), 10, 3 );
    }

    function nav_edit_walker($walker, $menu_id) {
      return 'Inferno_Walker_Nav_Menu_Edit';
    }

    /*
     * Saves new field to postmeta for navigation
     */
    
    function nav_update($menu_id, $menu_item_db_id, $args ) {
      foreach($inferno_options as $option) {
        if ( is_array($_REQUEST[$option['id']]) ) {
          $custom_value = $_REQUEST[$option['id']][$menu_item_db_id];
          update_post_meta( $menu_item_db_id, '_menu_item_custom', $custom_value );
        }
      }
    }
  }
}