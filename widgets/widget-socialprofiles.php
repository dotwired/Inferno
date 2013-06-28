<?php

 
class Infernal_Widget_Society extends Infernal_Widget
{
    public $widget = array(
        'title'       => 'Infernal Society',
        'description' => 'Show linked social profiles.'
    );

    public $default = array(
        'title'   => 'Social networks',
        'size'    => '16px',
        'align'   => 'no',
        'links'   => 'same_window',
        'hover'   => 'fadein',
        'iconset' => 'zillasocial'
    );

    public function __construct() {
        parent::register_widget(
            'infernal-society', // Base ID
            $this->widget['title'], // Name
            array('classname' => 'infernal-society', 'description' => $this->widget['description'])
        );
    }



    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {
        extract($args);
        $title     = apply_filters('widget_title', $instance['title']);

        $atts = array(
            'size'    => $instance['size'],
            'align'   => $instance['align'],
            'links'   => $instance['links'],
            'hover'   => $instance['hover'],
            'iconset' => $instance['iconset'],
        );

        echo $before_widget;
        if(!empty($title))
            echo $before_title . $title . $after_title;

        global $infernal_society;

        if(is_object($infernal_society))
            echo $infernal_society->get_output($atts);

        echo $after_widget;
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['size'] = strip_tags($new_instance['size']);
        $instance['align'] = strip_tags($new_instance['align']);
        $instance['links'] = strip_tags($new_instance['links']);
        $instance['hover'] = strip_tags($new_instance['hover']);
        $instance['iconset'] = strip_tags($new_instance['iconset']);

        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) 
    {
        $title = (isset($instance['title'])) ? $instance['title'] : (isset($this->default['title']) ? $this->default['title'] : null);
        $size = (isset($instance['size'])) ? $instance['size'] : (isset($this->default['size']) ? $this->default['size'] : null);
        $align = (isset($instance['align'])) ? $instance['align'] : (isset($this->default['align']) ? $this->default['align'] : null);
        $links = (isset($instance['links'])) ? $instance['links'] : (isset($this->default['links']) ? $this->default['links'] : null);
        $hover = (isset($instance['hover'])) ? $instance['hover'] : (isset($this->default['hover']) ? $this->default['hover'] : null);
        $iconset = (isset($instance['iconset'])) ? $instance['iconset'] : (isset($this->default['iconset']) ? $this->default['iconset'] : null);
        ?>

        <p><!-- the widget title -->
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'inferno'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p><!-- size -->
            <label for="<?php echo $this->get_field_id('size'); ?>"><?php _e('Icon Size:', 'inferno'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('size'); ?>" name="<?php echo $this->get_field_name('size'); ?>">
                <option value="16px"<?php if('16px' == $size) echo ' selected'?>><?php _e('16px', 'inferno'); ?></option>
                <option value="32px"<?php if('32px' == $size) echo ' selected'?>><?php _e('32px', 'inferno'); ?></option>
            </select> 
        </p>
        <p><!-- align -->
            <label for="<?php echo $this->get_field_id('align'); ?>"><?php _e('Align:', 'inferno'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('align'); ?>" name="<?php echo $this->get_field_name('align'); ?>">
                <option value="no"<?php if('no' == $align) echo ' selected'?>><?php _e('No alignment', 'inferno'); ?></option>
                <option value="center"<?php if('center' == $align) echo ' selected'?>><?php _e('Center alignment', 'inferno'); ?></option>
                <option value="left"<?php if('left' == $align) echo ' selected'?>><?php _e('Left alignment', 'inferno'); ?></option>
                <option value="right"<?php if('right' == $align) echo ' selected'?>><?php _e('Right alignment', 'inferno'); ?></option>
            </select> 
        </p>
        <p><!-- links -->
            <label for="<?php echo $this->get_field_id('links'); ?>"><?php _e('Open Links in:', 'inferno'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('links'); ?>" name="<?php echo $this->get_field_name('links'); ?>">
                <option value="same_window"<?php if('same_window' == $links) echo ' selected'?>><?php _e('Same window', 'inferno'); ?></option>
                <option value="new_window"<?php if('new_window' == $links) echo ' selected'?>><?php _e('New window', 'inferno'); ?></option>
            </select> 
        </p>
        <p><!-- hover -->
            <label for="<?php echo $this->get_field_id('hover'); ?>"><?php _e('Hover Effect:', 'inferno'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('hover'); ?>" name="<?php echo $this->get_field_name('hover'); ?>">
                <option value="no"<?php if('no' == $hover) echo ' selected'?>><?php _e('No hover effect', 'inferno'); ?></option>
                <option value="fadein"<?php if('fadein' == $hover) echo ' selected'?>><?php _e('Fade in', 'inferno'); ?></option>
                <option value="fadeout"<?php if('fadeout' == $hover) echo ' selected'?>><?php _e('Fade out', 'inferno'); ?></option>
            </select> 
        </p>
        <p><!-- iconset -->
            <label for="<?php echo $this->get_field_id('iconset'); ?>"><?php _e('Icon Set:', 'inferno'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('iconset'); ?>" name="<?php echo $this->get_field_name('iconset'); ?>">
                <option value="zillasocial"<?php if('zillasocial' == $iconset) echo ' selected'?>><?php _e('ZillaSocial', 'inferno'); ?></option>
                <option value="somicro"<?php if('somicro' == $iconset) echo ' selected'?>><?php _e('Somicro', 'inferno'); ?></option>
            </select> 
        </p>
        <?php 
    }
}
add_action('widgets_init', create_function('', 'return register_widget("Infernal_Widget_Society");'));

