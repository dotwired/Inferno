<?php

 
class Inferno_Widget_Flickr extends Inferno_Widget
{
    public $widget = array(
        'title'       => 'Infernal Flickr',
        'description' => 'Show photos of a flickr stream.'
    );

    public $default = array(
        'title'     => 'Flickr stream',
        'flickr_id' => null,
        'count'     => 12,
        'display'   => null,
        'source'    => null
    );

    public function __construct() {
        parent::register_widget(
            'infernal-flickr', // Base ID
            $this->widget['title'], // Name
            array('classname' => 'infernal-flickr', 'description' => $this->widget['description'])
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
        $flickr_id = $instance['flickr_id'];
        $count     = $instance['count'];
        $display   = $instance['display'];
        $source    = $instance['source'];


        echo $before_widget;
        if(!empty($title))
            echo $before_title . $title . $after_title;

        echo '<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=' . $count . '&amp;display=' . $display . '&amp;size=s&amp;layout=x&amp;source=' . $source . '&amp;' . $source . '=' . $flickr_id . '"></script>';
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
        $instance['flickr_id'] = strip_tags($new_instance['flickr_id']);
        $instance['count'] = strip_tags($new_instance['count']);
        $instance['display'] = strip_tags($new_instance['display']);
        $instance['source'] = $new_instance['source'];

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
        $title = (isset($instance['title'])) ? $instance['title'] : $this->default['title'];
        $flickr_id = (isset($instance['flickr_id'])) ? $instance['flickr_id'] : $this->default['flickr_id'];
        $count = (isset($instance['count'])) ? $instance['count'] : $this->default['count']; 
        $display = (isset($instance['display'])) ? $instance['display'] : $this->default['display']; 
        $source = (isset($instance['source'])) ? $instance['source'] : $this->default['source']; 
        ?>

        <p><!-- the widget title -->
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'inferno'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p><!-- flickr_id -->
            <label for="<?php echo $this->get_field_id('flickr_id'); ?>"><?php _e('Flickr ID:', 'inferno'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('flickr_id'); ?>" name="<?php echo $this->get_field_name('flickr_id'); ?>" type="text" value="<?php echo esc_attr($flickr_id); ?>" />
            <small><?php _e('Type in here Your <a href="http://idgettr.com/">Flickr ID</a>', 'inferno'); ?></small>
        </p>
        <p><!-- photo count -->
            <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Amount of Photos to show:', 'inferno'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>">
                <?php for($i = 1; $i <= 16; $i++) : ?>
                <option value="<?php echo $i ?>"<?php if($i == $count) echo ' selected'?>><?php echo $i ?></option>
                <?php endfor; ?> 
            </select> 
        </p>
        <p><!-- display -->
            <label for="<?php echo $this->get_field_id('display'); ?>"><?php _e('Photos to show:', 'inferno'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('display'); ?>" name="<?php echo $this->get_field_name('display'); ?>">
                <option value="random"<?php if('random' == $display) echo ' selected'?>><?php _e('Random', 'inferno'); ?></option>
                <option value="latest"<?php if('latest' == $display) echo ' selected'?>><?php _e('Latest', 'inferno'); ?></option>
            </select> 
        </p>
        <p><!-- source -->
            <label for="<?php echo $this->get_field_id('source'); ?>"><?php _e('Stream Type:', 'inferno'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('source'); ?>" name="<?php echo $this->get_field_name('source'); ?>">
                <option value="user"<?php if('user' == $source) echo ' selected'?>><?php _e('User', 'inferno'); ?></option>
                <option value="group"<?php if('group' == $source) echo ' selected'?>><?php _e('Group', 'inferno'); ?></option>
            </select> 
        </p>
        <?php 
    }  
}
add_action('widgets_init', create_function('', 'return register_widget("Inferno_Widget_Flickr");'));

