<?php

 
class Infernal_Widget_Video extends Infernal_Widget
{
    public $widget = array(
        'title'       => 'Infernal Video',
        'description' => 'Embed a responsive video.'
    );

    public $default = array(
        'title'     => 'Video',
    );

    public function __construct() {
        parent::register_widget(
            'infernal-video', // Base ID
            $this->widget['title'], // Name
            array('classname' => 'infernal-video', 'description' => $this->widget['description'])
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
        $description = $instance['description'];
        $video     = $instance['video'];


        echo $before_widget;
        if(!empty($title))
            echo $before_title . $title . $after_title;

        if(!empty($description))
            echo '<p>' . $description . '</p>';

        echo '<div class="elastic-video">' . $video . '</div>';
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
        $instance['description'] = strip_tags($new_instance['description']);
        $instance['video'] = $new_instance['video'];

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
        $description = (isset($instance['description'])) ? $instance['description'] : $this->default['description'];
        $video = (isset($instance['video'])) ? $instance['video'] : $this->default['video'];
        ?>

        <p><!-- the widget title -->
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'inferno'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p><!-- description -->
            <label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Description:', 'inferno'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>" type="text" value="<?php echo esc_attr($description); ?>" />
        </p>
        <p><!-- video -->
            <label for="<?php echo $this->get_field_id('video'); ?>"><?php _e('Embed Code:', 'inferno'); ?></label> 
            <textarea class="widefat" id="<?php echo $this->get_field_id('video'); ?>" name="<?php echo $this->get_field_name('video'); ?>"><?php echo esc_attr($video); ?></textarea>
            <small><?php _e('Paste the embed code of the video.', 'inferno'); ?></small>
        </p>
        <?php 
    }
}
add_action('widgets_init', create_function('', 'return register_widget("Infernal_Widget_Video");'));

