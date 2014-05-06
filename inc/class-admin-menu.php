<?php

// see http://wordpress.stackexchange.com/questions/33342/how-to-add-a-custom-field-in-the-advanced-menu-properties
if(!class_exists('Inferno_Admin_Menu')) {
  class Inferno_Admin_Menu extends Inferno {

    public $inferno_options = array();

    public $current_menu_location = null;

    static private $instance = null;

    static public function getInstance() {
      if (null === self::$instance) {
        self::$instance = new self;
      }
      return self::$instance;
    }

    public function __construct() 
    {
      require ABSPATH . 'wp-admin/includes/nav-menu.php';
      require_once(dirname(__FILE__) . '/class-walker-nav-menu-edit.php');

      add_action( 'admin_init', array($this, 'get_options'));
      add_action( 'wp_update_nav_menu_item', array($this, 'nav_update'), 10, 3 );
      add_filter( 'wp_edit_nav_menu_walker', array($this, 'nav_edit_walker'), 10, 2 );
      add_filter( 'wp_setup_nav_menu_item', array($this, 'nav_item') );
    }

    function get_options(){
      $theme_support = get_theme_support('inferno-menu-options');

      if(isset($theme_support[0]['file']) && is_string($theme_support[0]['file'])) {
        $tmp_options = include ( locate_template( $theme_support[0]['file'] ) );
        $this->inferno_options = $tmp_options;
      }
    }

    /**
     * We need to make some not that beautiful things here in the class because nav_edit_walker
     * is the only location we can check for the menu slug. So that's also why Inferno_Admin_Menu
     * must be a Singleton (we will store the current menu slug in $this->current_menu_location here 
     * so we can check in complete other locations for the current menu slug / id)
     * 
     * @param  [type] $walker  [description]
     * @param  [type] $menu_id [description]
     * @return [type]          [description]
     */
    function nav_edit_walker($walker, $menu_id) {
      $menus = get_nav_menu_locations();
      if(in_array($menu_id, $menus) ) {
        foreach($this->inferno_options as $key => $value) {
          if($menus[$key] === $menu_id) {
            $this->current_menu_location = $key;
            return 'Inferno_Walker_Nav_Menu_Edit';
          }
        }
      }
      return 'Walker_Nav_Menu_Edit';
    }


    /*
     * Adds value of new field to $item object that will be passed to     Walker_Nav_Menu_Edit_Custom
     */
    function nav_item($menu_item) {
      if(isset($this->inferno_options[$this->current_menu_location]['fields'])) {
        $menu_item->inferno = array();
        $options = $this->inferno_options[$this->current_menu_location]['fields']; 
        if(!empty($options)) {
          foreach($options as $field) {
            // third argument to false, because we need to check if the value actually exists
            $array = get_post_meta( $menu_item->ID, $field['id'], false );
            if(!empty($array)) {
              $menu_item->inferno[$field['id']] = $array[0];
            } else {
              $menu_item->inferno[$field['id']] = isset($field['std']) ? $field['std'] : false;
            }
          }
        }
      }
      return $menu_item;
    }

    /*
     * Saves new field to postmeta for navigation
     */
    function nav_update( $menu_id, $menu_item_db_id, $args ) {
      // TODO: this line is duplicated, find a solution (see nav_edit_walker())
      $menus = get_nav_menu_locations();
      if(in_array($menu_id, $menus) ) {
        foreach($this->inferno_options as $key => $value) {
          if($menus[$key] === $menu_id) {
            $this->current_menu_location = $key;
          }
        }
      }
      if(isset($this->inferno_options[$this->current_menu_location]['fields']) && !empty($this->inferno_options[$this->current_menu_location]['fields'])) {
        foreach($this->inferno_options[$this->current_menu_location]['fields'] as $field) {
          if ( isset($_REQUEST[$field['id']]) && is_array($_REQUEST[$field['id']] ) && isset($_REQUEST[$field['id']][$menu_item_db_id])) {
            $value = $_REQUEST[$field['id']][$menu_item_db_id];
            update_post_meta( $menu_item_db_id, $field['id'], $value );
          }
        }
      }
    }
  }
}