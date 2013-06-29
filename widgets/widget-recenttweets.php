<?php

 
class Inferno_Widget_RecentTweets extends Inferno_Widget
{
    // make clear that this widget needs to give some dynamic vars to the 
    // client server side.
    public $infernal_data = true;

    public $widget = array(
        'title'       => 'Infernal Tweets',
        'description' => 'Show your recent tweets.'
    );

    public $default = array(
        'title'       => 'Recent tweets',
        'username'    => '',
        'loadingtext' => 'Loading.',
        'template'    => '<span class="bird"></span>{time} - {text}'
    );

    public function __construct() {
        $this->scripts['infernal-tweet'] = 'tweet';
        
        parent::register_widget(
            'infernal-tweet', // Base ID
            $this->widget['title'], // Name
            array('classname' => 'infernal-tweet', 'description' => $this->widget['description'])
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
        $title = apply_filters('widget_title', $instance['title']);
        $username = $instance['username'];

        echo $before_widget;
        if(!empty($title)) echo $before_title . $title . $after_title;

        echo '<div class="infernal-tweet"></div>';
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
        $instance['username'] = strip_tags($new_instance['username']);
        $instance['count'] = strip_tags($new_instance['count']);
        $instance['loadingtext'] = strip_tags($new_instance['loadingtext']);
        $instance['template'] = $new_instance['template'];

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
        $username = (isset($instance['username'])) ? $instance['username'] : $this->default['username'];
        $count = (isset($instance['count'])) ? $instance['count'] : $this->default['count']; 
        $loadingtext = (isset($instance['loadingtext'])) ? $instance['loadingtext'] : $this->default['loadingtext']; 
        $template = (isset($instance['template'])) ? $instance['template'] : $this->default['template']; 
        ?>

        <p><!-- the widget title -->
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'inferno'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p><!-- twitter username -->
            <label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Username:', 'inferno'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo esc_attr($username); ?>" />
        </p>
        <p><!-- tweet count -->
            <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Amount of Tweets to show:', 'inferno');; ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>">
                <?php for($i = 1; $i <= 10; $i++) : ?>
                <option value="<?php echo $i ?>"<?php if($i == $count) echo ' selected'?>><?php echo $i ?></option>
                <?php endfor; ?> 
            </select> 
        </p>
        <p><!-- loadingtext -->
            <label for="<?php echo $this->get_field_id('loadingtext'); ?>"><?php _e('Loading Text:', 'inferno');; ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('loadingtext'); ?>" name="<?php echo $this->get_field_name('loadingtext'); ?>" type="text" value="<?php echo esc_attr($loadingtext); ?>" />
            <small><?php _e('While tweet is not loaded yet.', 'inferno'); ?></small>
        </p>
        <p><!-- template -->
            <label for="<?php echo $this->get_field_id('template'); ?>"><?php _e('Template:', 'inferno');; ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('template'); ?>" name="<?php echo $this->get_field_name('template'); ?>"><?php echo esc_attr($template); ?></textarea>
            <small><?php _e('Template used to construct each tweet li - see <a href="https://github.com/seaofclouds/tweet/">jQuery tweet plugin</a> source code for available vars.', 'inferno'); ?></small>
        </p>
        <?php 
    } 
}
add_action('widgets_init', create_function('', 'return register_widget("Inferno_Widget_RecentTweets");'));