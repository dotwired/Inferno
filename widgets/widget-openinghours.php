<?php

 if(!class_exists( 'Inferno_Widget_OpeningHours' ) ) {
    class Inferno_Widget_OpeningHours extends Inferno_Widget
    {
        public $widget = array(
            'title'       => 'Inferno Opening Hours',
            'description' => 'Show Your visitors when Your local shop is open.'
        );

        public $default = array(
            'title'     => 'Opening Hours',
            'Monday'    => null,
            'Tuesday'   => null,
            'Wednesday' => null,
            'Thursday'  => null,
            'Friday'    => null,
            'Saturday'  => null,
            'Sunday'    => null
        );

        public function __construct() {
            parent::register_widget(
                'inferno-openinghours', // Base ID
                $this->widget['title'], // Name
                array('classname' => 'inferno-openinghours', 'description' => $this->widget['description'])
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
            $monday = $instance['monday'];
            $tuesday = $instance['tuesday'];
            $wednesday = $instance['wednesday'];
            $thursday = $instance['thursday'];
            $friday = $instance['friday'];
            $saturday = $instance['saturday'];
            $sunday = $instance['sunday'];

            $current_day = ((date("w") + 6) % 7) + 1;

            echo $before_widget;
            if(!empty($title))
                echo $before_title . $title . $after_title;

            echo '<div class="inferno-widget-openinghours">';
            echo '<ul class="data-list">';
            if($monday) {
                echo '<li class="monday' . ( $current_day == 1 ? ' current-day' : null ) . '">
                    <label>' . __('Monday', 'inferno') . '</label>
                    <span>'  . $monday . '</span></li>';
            }
            if($tuesday) {
                echo '<li class="tuesday' . ( $current_day == 2 ? ' current-day' : null ) . '">
                    <label>' . __('Tuesday', 'inferno') . '</label>
                    <span>'  . $tuesday . '</span></li>';
            }
            if($wednesday) {
                echo '<li class="wednesday' . ( $current_day == 3 ? ' current-day' : null ) . '">
                    <label>' . __('Wednesday', 'inferno') . '</label>
                    <span>'  . $wednesday . '</span></li>';
            }
            if($thursday) {
                echo '<li class="thursday' . ( $current_day == 4 ? ' current-day' : null ) . '">
                    <label>' . __('Thursday', 'inferno') . '</label>
                    <span>'  . $thursday . '</span></li>';
            }
            if($friday) {
                echo '<li class="friday' . ( $current_day == 5 ? ' current-day' : null ) . '">
                    <label>' . __('Friday', 'inferno') . '</label>
                    <span>'  . $friday . '</span></li>';
            }
            if($saturday) {
                echo '<li class="saturday' . ( $current_day == 6 ? ' current-day' : null ) . '">
                    <label>' . __('Saturday', 'inferno') . '</label>
                    <span>'  . $saturday . '</span></li>';
            }
            if($sunday) {
                echo '<li class="sunday' . ( $current_day == 7 ? ' current-day' : null ) . '">
                    <label>' . __('Sunday', 'inferno') . '</label>
                    <span>'  . $sunday . '</span></li>';
            }
            echo '</ul>';
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
            $instance['monday'] = strip_tags($new_instance['monday']);
            $instance['tuesday'] = strip_tags($new_instance['tuesday']);
            $instance['wednesday'] = strip_tags($new_instance['wednesday']);
            $instance['thursday'] = strip_tags($new_instance['thursday']);
            $instance['friday'] = strip_tags($new_instance['friday']);
            $instance['saturday'] = strip_tags($new_instance['saturday']);
            $instance['sunday'] = strip_tags($new_instance['sunday']);

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
            $monday = (isset($instance['monday'])) ? $instance['monday'] : $this->default['monday'];
            $tuesday = (isset($instance['tuesday'])) ? $instance['tuesday'] : $this->default['tuesday'];
            $wednesday = (isset($instance['wednesday'])) ? $instance['wednesday'] : $this->default['wednesday'];
            $thursday = (isset($instance['thursday'])) ? $instance['thursday'] : $this->default['thursday'];
            $friday = (isset($instance['friday'])) ? $instance['friday'] : $this->default['friday'];
            $saturday = (isset($instance['saturday'])) ? $instance['saturday'] : $this->default['saturday'];
            $sunday = (isset($instance['wednesday'])) ? $instance['wednesday'] : $this->default['wednesday'];
            ?>

            <p><!-- the widget title -->
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'inferno'); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
            </p>
            <p><!-- monday -->
                <label for="<?php echo $this->get_field_id('monday'); ?>"><?php _e('Monday:', 'inferno'); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id('monday'); ?>" name="<?php echo $this->get_field_name('monday'); ?>" type="text" value="<?php echo esc_attr($monday); ?>" />
            </p>
            <p><!-- tuesday -->
                <label for="<?php echo $this->get_field_id('tuesday'); ?>"><?php _e('Tuesday:', 'inferno'); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id('tuesday'); ?>" name="<?php echo $this->get_field_name('tuesday'); ?>" type="text" value="<?php echo esc_attr($tuesday); ?>" />
            </p>
            <p><!-- wednesday -->
                <label for="<?php echo $this->get_field_id('wednesday'); ?>"><?php _e('Wednesday:', 'inferno'); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id('wednesday'); ?>" name="<?php echo $this->get_field_name('wednesday'); ?>" type="text" value="<?php echo esc_attr($wednesday); ?>" />
            </p>
            <p><!-- thursday -->
                <label for="<?php echo $this->get_field_id('thursday'); ?>"><?php _e('Thursday:', 'inferno'); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id('thursday'); ?>" name="<?php echo $this->get_field_name('thursday'); ?>" type="text" value="<?php echo esc_attr($thursday); ?>" />
            </p>
            <p><!-- friday -->
                <label for="<?php echo $this->get_field_id('friday'); ?>"><?php _e('Friday:', 'inferno'); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id('friday'); ?>" name="<?php echo $this->get_field_name('friday'); ?>" type="text" value="<?php echo esc_attr($friday); ?>" />
            </p>
            <p><!-- saturday -->
                <label for="<?php echo $this->get_field_id('saturday'); ?>"><?php _e('Saturday:', 'inferno'); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id('saturday'); ?>" name="<?php echo $this->get_field_name('saturday'); ?>" type="text" value="<?php echo esc_attr($saturday); ?>" />
            </p>
            <p><!-- sunday -->
                <label for="<?php echo $this->get_field_id('sunday'); ?>"><?php _e('sunday:', 'inferno'); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id('sunday'); ?>" name="<?php echo $this->get_field_name('sunday'); ?>" type="text" value="<?php echo esc_attr($sunday); ?>" />
            </p>
            <?php 
        }
    }
    add_action('widgets_init', create_function('', 'return register_widget("Inferno_Widget_OpeningHours");'));
}
