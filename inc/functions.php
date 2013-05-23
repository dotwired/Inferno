<?php

/**
 * This file contains functions which may eventually used in the theme directly and are not generous at all
 */

function inferno_get_post_meta($post_id, $option = '') 
{
    $return = get_post_meta($post_id, '_infernal-postmeta', true);

    if(!$return) {
        global $infernal_metabox;

        foreach($infernal_metabox->metabox as $metabox) {
            if($metabox['name'] == $option) {
                return isset($metabox['default']) ? $metabox['default'] : null;
            }
        }
    }

    return isset($return[$option]) ? $return[$option] : null;
}

function inferno_get_option($option_name = null, $default_value = null) {
    global $infernal_option;
    if(isset($infernal_option[$option_name]) && !empty($infernal_option[$option_name])) {
        return $infernal_option[$option_name];
    }
    return $default_value;
}



/*
function i_go() {}
function i_uo() {}
function inferno_update_option() {}
*/

function inferno_preview($src = false, $width = false, $height = false, $effect = 'default', $link = false, $crop = true) {
    if(!class_exists('Inferno_Preview')) return;

    $preview = new Inferno_Preview($src, $width, $height, $effect, $link, $crop);
    return $preview->get_output();
}

function inferno_society($size = '16px') {
    global $infernal_society;
    if(isset($infernal_society) && method_exists($infernal_society, 'get_output')) return $infernal_society->get_output($size);
    return false;
}

function inferno_slider($args = array())
{
    global $infernal_slider;
    if(isset($infernal_slider) && method_exists($infernal_slider, 'get_output')) return $infernal_slider->get_output($args);;
    return false;
}

function inferno_portfolio($args = array()) {
    global $infernal_portfolio;
    if(isset($infernal_portfolio) && method_exists($infernal_portfolio, 'get_output')) return $infernal_portfolio->get_output($args);
    return false;
}

function inferno_notification_bar() {
    global $infernal_flame;
    if(isset($infernal_flame) && method_exists($infernal_flame, 'get_notification_bar')) return $infernal_flame->get_notification_bar();
    return false;
}

function inferno_gmaps() {
    global $infernal_gmaps;
    if(isset($infernal_gmaps) && method_exists($infernal_gmaps, 'get_output')) return $infernal_gmaps->get_output();
    return false;
}

function inferno_is_google_font($font = null) {
    global $infernal_panel;

    if($font !== null && !in_array($font, $infernal_panel->_default_fonts)) {
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
            if(inferno_is_google_font()) {
                $font = str_replace(' ', '+', $font);
                $url .= $font . $styles . '|';
            }
        }
        if(substr($url, -1) != '|') return false;
        trim($url, '|');
    }
    
    return $url;
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