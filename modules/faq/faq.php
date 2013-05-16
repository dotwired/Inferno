<?php
/**
 * Plugin Name: Infernal FAQ
 * Plugin URI:  http://themedale.net
 * Description: This plugin allows You to create easily complex, beautiful and well structured FAQs.
 * Version:     1.0
 * Author:      Maxim Zubarev
 * Author URI:  http://dotwired.de
 */

/**
 * This is the InfernalPanel loader class.
 *
 * @package   IPPanel
 * @author    Maxim Zubarev
 */
if(!class_exists('Infernal_Faq')) {

    /**
     * Loader class for the IP Panel.
     */
    class Infernal_Faq extends Inferno {

        /**
         * included files without file ending
         *
         * @var array
         */
        public $includes = array(
            'functions',
            'infernal-widget',
            'widget-recenttweets',
            'widget-flickr',
            'widget-video',
            'widget-society'
        );

        public $enqueue_scripts = array();



        /**
         * constructor calls some initial methods.
         * @param array $config array for overwriting $this->_config
         */
        public function __construct() {
            $this->includes();

            if(!is_admin()) {
                $this->assets();
            }
        }


        /**
         * include all needed files
         * @return void
         */
        private function includes() {
            foreach ( $this->includes as $file ) {
                require_once INFERNO_DIR . "infernal-flame/includes/{$file}.php";
            }
        }

    }
}
