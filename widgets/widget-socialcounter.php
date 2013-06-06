<?php

 if(!class_exists( 'Inferno_Widger_SocialCounter' ) ) {
    class Inferno_Widger_SocialCounter extends Inferno_Widget
    {
        public $widget = array(
            'title'       => 'Inferno Social Counter',
            'description' => 'Show the number of Your followers on various networks.'
        );

        public $default = array(
            'title'     => 'Social Profiles',
        );

        private $networks = array(
            'twitter',
            'facebook',
            'youtube'
        );

        public function __construct() {
            parent::register_widget(
                'inferno-socialcounter', // Base ID
                $this->widget['title'], // Name
                array('classname' => 'inferno-socialcounter', 'description' => $this->widget['description'])
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
            $twitter = $instance['twitter'];
            $youtube = $instance['youtube'];
            $facebook = $instance['facebook'];

            $i = 0;
            foreach ($this->networks as $network) { 
                if($instance[$network]) $i++;
            }

            if($i > 1) {
                $width_class = ' width-divide-by-' . $i;
            }

            echo $before_widget;
            if(!empty($title))
                echo $before_title . $title . $after_title;

            echo '<div class="inferno-widget-socialcounter">';
            if($twitter) {
                echo '<div class="counter-box twitter' . $width_class . '"><a href="https://twitter.com/' . $twitter . '">
                    <p class="network">' . __('Twitter', 'inferno') . '</p>
                    <p class="fans">' . __('Followers', 'inferno') . '</p>
                    <p class="count">'  . inferno_get_twitter_count( $twitter ) . '</p></a></div>';
            }
            if($youtube) {
                echo '<div class="counter-box youtube' . $width_class . '"><a href="https://www.youtube.com/user/' . $youtube . '">
                    <p class="network">' . __('YouTube', 'inferno') . '</p>
                    <p class="fans">' . __('Subscribers', 'inferno') . '</p>
                    <p class="count">'  . inferno_get_youtube_count( $youtube ) . '</p></a></div>';
            }
            if($twitter) {
                echo '<div class="counter-box facebook' . $width_class . '"><a href="https://www.facebook.com/' . $facebook . '">
                    <p class="network">' . __('Facebook', 'inferno') . '</p>
                    <p class="fans">' . __('Fans', 'inferno') . '</p>
                    <p class="count">'  . inferno_get_facebook_count( $facebook ) . '</p></a></div>';
            }
            echo '<div class="clear"></div></div>';
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
            $instance['twitter'] = strip_tags($new_instance['twitter']);
            $instance['youtube'] = strip_tags($new_instance['youtube']);
            $instance['facebook'] = strip_tags($new_instance['facebook']);

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
            $twitter = (isset($instance['twitter'])) ? $instance['twitter'] : $this->default['twitter'];
            $youtube = (isset($instance['youtube'])) ? $instance['youtube'] : $this->default['youtube'];
            $facebook = (isset($instance['facebook'])) ? $instance['facebook'] : $this->default['facebook'];
            ?>

            <p><!-- the widget title -->
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'inferno'); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
            </p>
            <p><!-- twitter -->
                <label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter username:', 'inferno'); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="text" value="<?php echo esc_attr($twitter); ?>" />
            </p>
            <p><!-- youtube -->
                <label for="<?php echo $this->get_field_id('youtube'); ?>"><?php _e('YouTube username:', 'inferno'); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id('youtube'); ?>" name="<?php echo $this->get_field_name('youtube'); ?>" type="text" value="<?php echo esc_attr($youtube); ?>" />
            </p>
            <p><!-- facebook -->
                <label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook page id:', 'inferno'); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="text" value="<?php echo esc_attr($facebook); ?>" />
            </p>
            <?php 
        }
    }
    add_action('widgets_init', create_function('', 'return register_widget("Inferno_Widger_SocialCounter");'));
}
