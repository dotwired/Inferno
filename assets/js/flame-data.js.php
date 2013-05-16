<?php

$root = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))));
if(file_exists( $root . '/wp-load.php')) {
    require_once($root . '/wp-load.php');
} else {
    require_once(dirname($root) . '/wp-load.php');
}

header("Content-type: text/javascript; charset=utf-8");


global $wp_registered_sidebars, $wp_registered_widgets;
global $infernal_slider, $infernal_portfolio, $infernal_flame;

$passed_widgets = array();
$duplicate_widgets = array();

// check for widgets to call twice (we will create another js obj vor them)
foreach($wp_registered_widgets as $widget) {
    if(isset($widget['callback'][0]->infernal_data)) {

        if(in_array($widget['callback'][0]->id_base, $passed_widgets)) {
            if(!in_array($widget['callback'][0]->id_base, $duplicate_widgets))
                $duplicate_widgets[] = $widget['callback'][0]->id_base;
        } else {
            $passed_widgets[] = $widget['callback'][0]->id_base;
        }
    }
}
?>
infernal = new Object();
infernal.site = new Object();
infernal.site.url = "<?php echo home_url(); ?>";
infernal.theme = new Object();
infernal.theme.name = "<?php $current_theme = wp_get_theme(); echo $current_theme; ?>";
infernal.theme.url = "<?php echo get_template_directory_uri(); ?>";
infernal.flame = new Object();
infernal.flame.url = "<?php echo INFERNO_URL; ?>";

<?php if($infernal_flame) : ?>
infernal.tweaks = new Object();
infernal.tweaks.scrollToTopButton = <?php echo $infernal_flame->settings['scroll_button'] == 'on' ? 'true' : 'false'; ?>;
infernal.tweaks.scrollToTopButtonDuration = <?php echo $infernal_flame->settings['scroll_button_duration']; ?>;
infernal.tweaks.scrollToTopButtonOffset = <?php echo $infernal_flame->settings['scroll_button_offset']; ?>;

<?php endif;

/* ===================================================================
    slider data
=================================================================== */

if($infernal_slider) : ?>
infernal.slider = new Object();
infernal.slider.animation = "<?php echo $infernal_slider->settings['slider_animation']; ?>";
/* infernal.slider.animationDirection = "<?php echo $infernal_slider->settings['slider_animation_direction']; ?>"; */
infernal.slider.controlNav = <?php echo ($infernal_slider->settings['slider_control_nav'] == 'thumbnails') ? '"thumbnails"' : $infernal_slider->settings['slider_control_nav']; ?>;
infernal.slider.slideshowSpeed = <?php echo $infernal_slider->settings['slider_speed']; ?>;
infernal.slider.animationSpeed = <?php echo $infernal_slider->settings['slider_animation_speed']; ?>;
<?php endif; 

if($infernal_portfolio) : ?>
infernal.portfolio = new Object();
infernal.portfolio.slider = new Object();
<?php 
/*
infernal.portfolio.slider.animation = "<?php echo $infernal_portfolio->settings['slider_animation']; ?>";
infernal.portfolio.slider.slideshowSpeed = <?php echo $infernal_portfolio->settings['slider_speed']; ?>;
infernal.portfolio.slider.animationSpeed = <?php echo $infernal_portfolio->settings['slider_animation_speed']; ?>;
*/
endif;


/* ===================================================================
    widget data
=================================================================== */

$initialized_widgets = array();
$active_widgets = array();
$db_sidebars = get_option('sidebars_widgets');

foreach($db_sidebars as $area => $widgets) {
    if($area != 'wp_inactive_widgets' && is_array($widgets) && !empty($widgets)) {
        foreach($widgets as $widget_name)
            $active_widgets[] = $widget_name;
    }
}

foreach($wp_registered_widgets as $key => $widget) {

    if(in_array($key, $active_widgets)) {

        if(isset($widget['callback'][0]->infernal_data) && $widget['callback'][0]->infernal_data === true) {
            $widget_slug = $widget['callback'][0]->scripts[$widget['callback'][0]->id_base];

            // check if object has been initialized. if not, init.
            if(!in_array($widget['callback'][0]->id_base, $initialized_widgets)) {
                $initialized_widgets[] = $widget['callback'][0]->id_base;
                echo 'infernal.' . $widget_slug . ' = new Object();' . "\n";
            }
            
            $number = $widget['params'][0]['number'];
            $prefix = 'infernal.' . $widget_slug . '.w' . $number;
            
            echo $prefix . ' = new Object();' . "\n";
            echo $prefix . ".id = '#" . $widget['id'] . "'" . "\n";

            $widget_data = get_option($widget['callback'][0]->option_name);

            if(!empty($widget_data[$number])) {
                foreach($widget_data[$number] as $key => $value) {
                    $value = trim(preg_replace('/\s+/', ' ', $value));
                    echo "{$prefix}.{$key} = '{$value}';" . "\n"; 
                }
            }
        }

    }
}