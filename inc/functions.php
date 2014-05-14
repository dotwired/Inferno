<?php

/**
 * This file contains functions which may eventually used in the theme directly and are not generous at all
 */

function inferno_get_option($option_name = null, $default_value = null) {
  global $inferno_option;

  if(isset($inferno_option[$option_name]) && !empty($inferno_option[$option_name])) {
    return $inferno_option[$option_name];
  }
  return $default_value;
}

function inferno_is_login_page() {
  return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
}


/*
function inferno_update_option() {}
*/

function inferno_preview($args = array()) {
  $defaults = array(
    'src'       => false, 
    'width'     => false, 
    'height'    => false, 
    'permalink' => false, 
    'crop'      => true, 
    'effect'    => 'default', 
    'module'    => null
  );
  $args = wp_parse_args($args, $defaults);

  if(!class_exists('Inferno_Preview')) return;

  $preview = new Inferno_Preview($args['src'], $args['width'], $args['height'], $args['permalink'], $args['crop'], $args['effect'], $args['module']);
  return $preview->get_output();
}

function inferno_portfolio($args = array()) {
  global $inferno_portfolio;
  if(isset($inferno_portfolio) && method_exists($inferno_portfolio, 'get_output')) return $inferno_portfolio->get_output($args);
  return false;
}

function inferno_is_google_font($font = null) {
  $default_fonts = array(
    'Arial', 
    'Arial Black', 
    'Lucida Grande', 
    'Helvetica', 
    'Helvetica Neue', 
    'Tahoma', 
    'Georgia', 
    'Times New Roman'
  );

  if($font !== null && !in_array($font, $default_fonts)) {
    return true;
  }

  return false;
}

function inferno_get_google_font_url($font_collection = null)
{
  $url = null;
  $styles = ':100,200,300,400,500,600,700,800,900,100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic';

  if(is_string($font_collection) && inferno_is_google_font()) {
    $font = str_replace(' ', '+', $font_collection);
    $url = 'http://fonts.googleapis.com/css?family=' . $font . $styles;
  } elseif(is_array($font_collection) && !empty($font_collection)) {
    $url = 'http://fonts.googleapis.com/css?family=';
    foreach($font_collection as $font) {
      if(inferno_is_google_font($font)) {
        $font = str_replace(' ', '+', $font);
        $url .= $font . $styles . '|';
      }
    }
    if(substr($url, -1) != '|') return false;
    trim($url, '|');
  }
  
  return $url;
}

function inferno_get_image_id_from_url($image_url) {
  global $wpdb;
  $prefix = $wpdb->prefix;
  $attachment = $wpdb->get_col($wpdb->prepare("SELECT id FROM " . $prefix . "posts" . " WHERE guid='%s';", $image_url )); 
  return $attachment[0]; 
}


function inferno_widgets_exist($sidebar = array()){
  $sidebars_widgets = get_option('sidebars_widgets');
  $active = array();

  if(is_array($sidebar)) {
    $i = 1;
    foreach($sidebar as $name) {
      if(count($sidebars_widgets[$name]))
        $active[$i] = true;
      else
        $active[$i] = false;

      $i++;
    }
  }
  else {
    if(count($sidebars_widgets[$sidebar]))
      return true;
    else
      return false;
  }

  return $active;
}


function inferno_get_widget_data_for($sidebar_name) {
  global $wp_registered_sidebars, $wp_registered_widgets;

  // Holds the final data to return
  $output = array();

  // Loop over all of the registered sidebars looking for the one with the same name as $sidebar_name
  $sibebar_id = false;
  foreach( $wp_registered_sidebars as $sidebar ) {
    if( $sidebar['name'] == $sidebar_name ) {
      // We now have the Sidebar ID, we can stop our loop and continue.
      $sidebar_id = $sidebar['id'];
      break;
    }
  }

  if( !$sidebar_id ) {
    // There is no sidebar registered with the name provided.
    return $output;
  } 

  // A nested array in the format $sidebar_id => array( 'widget_id-1', 'widget_id-2' ... );
  $sidebars_widgets = wp_get_sidebars_widgets();
  $widget_ids = $sidebars_widgets[$sidebar_id];

  if( !$widget_ids ) {
    // Without proper widget_ids we can't continue. 
    return array();
  }

  // Loop over each widget_id so we can fetch the data out of the wp_options table.
  foreach( $widget_ids as $id ) {
    // The name of the option in the database is the name of the widget class.  
    $option_name = $wp_registered_widgets[$id]['callback'][0]->option_name;

    // Widget data is stored as an associative array. To get the right data we need to get the right key which is stored in $wp_registered_widgets
    $key = $wp_registered_widgets[$id]['params'][0]['number'];

    $widget_data = get_option($option_name);

    // Add the widget data on to the end of the output array.
    $output[] = (object) $widget_data[$key];
  }

  return $output;
}


function inferno_get_tag($tag = null, $args = array()) {
  if(!$tag || empty($args)) {
    return null;
  }

  // Separates args with a single space, collates args for element
  return $tag . '="' . join( ' ', $args ) . '"';
}


/**
 * Display the given classes
 *
 * @since 1.0
 *
 * @param string|array $classes One or more classes to add to the class list.
 */
function inferno_class_tag( $classes = array() ) {
  echo inferno_get_tag('class', $classes);
}
