<?php

if(!class_exists( 'Inferno_Shortcodes' ) ) {
    class Inferno_Widget extends WP_Widget
    {

        public $scripts = array();


        public function __construct()
        {
            # do nothing
        }

        public function register_widget($base_id = '', $name = '', $args = array())
        {
            parent::__construct(
                $base_id,
                $name,
                $args
            );
        }


        public function enqueue_scripts()
        {
            foreach($this->scripts as $base_id => $script) {
                if(is_active_widget(false, false, $base_id)) {
                    wp_enqueue_script($script);
                }
            }
        }
    }
}