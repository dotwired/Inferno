<?php


if(!class_exists('Inferno_Meta_Box')) {

    class Inferno_Meta_Box extends Inferno {

        private $_noncestr = 'infernal-metabox';

        private $meta_box = array();

        private $_postmeta = array();

        private $_meta = array();

        /**
         * constructor calls some initial methods.
         * @param array $config array for overwriting $this->_config
         */
        public function __construct($meta_box) {
            $this->meta_box = $meta_box;

            add_action('init', array(&$this, 'assets')); // instead of $this->assets();

            add_action('add_meta_boxes', array(&$this, 'add'));
            add_action('save_post', array(&$this, 'save'));
            add_action('edit_attachment', array(&$this, 'save'));
            add_action('admin_enqueue_scripts', array(&$this, 'admin_enqueue'));
        }

        public function add()
        {   
            $this->meta_box['context'] = empty( $this->meta_box['context'] ) ? 'normal' : $this->meta_box['context'];
            $this->meta_box['priority'] = empty( $this->meta_box['priority'] ) ? 'high' : $this->meta_box['priority'];

            if ( is_array( $this->meta_box['post_types'] ) ) {
                foreach ( $this->meta_box['post_types'] as $post_type ) {
                    add_meta_box( $this->meta_box['id'], 
                        $this->meta_box['title'], 
                        array(&$this, 'show'), 
                        $post_type, 
                        $this->meta_box['context'], 
                        $this->meta_box['priority']) ;
                }
            } elseif( $this->meta_box['post_types'] == 'all' ) {
                $all_post_types = get_post_types(array('public' => true), 'names');

                foreach($all_post_types as $post_type) {
                    add_meta_box( $this->meta_box['id'], 
                        $this->meta_box['title'], 
                        array(&$this, 'show'), 
                        $post_type, 
                        $this->meta_box['context'], 
                        $this->meta_box['priority']) ;
                }
            }
        }

        public function admin_enqueue()
        {
            wp_enqueue_script('jquery');
            wp_enqueue_script('jquery-ui-core');
            wp_enqueue_script('jquery-ui-widget');
            wp_enqueue_script('jquery-ui-tabs');
            wp_enqueue_script('jquery-ui-slider');
            wp_enqueue_script('jquery-ui-sortable');
            wp_enqueue_script('jquery-ui-button');
            wp_enqueue_script('jquery-form');
            wp_enqueue_script('media-upload');
            wp_enqueue_script('thickbox');
            wp_enqueue_script('jquery-confirm');
            wp_enqueue_script('jquery-colorpicker');
            wp_enqueue_script('inferno');

            wp_enqueue_style('thickbox');
            wp_enqueue_style('inferno-colorpicker');
            wp_enqueue_style('font-awesome');
            wp_enqueue_style('inferno');
        }

        public function save($post_id)
        {
            // verify if this is an auto save routine. 
            // If it is our form has not been submitted, so we dont want to do anything
            if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) 
                return;

            if (!isset($_POST['infernal_nonce']) || !wp_verify_nonce($_POST['infernal_nonce'], plugin_basename(__FILE__)))
                return;

            
            // Check permissions
            if('page' == $_POST['post_type']) {
                if(!current_user_can('edit_page', $post_id))
                    return;
            } else {
                if(!current_user_can('edit_post', $post_id))
                    return;
            }

            // OK, we're authenticated: we need to find and save the data
            // Do something with $mydata 
            // probably using add_post_meta(), update_post_meta(), or 
            // a custom table (see Further Reading section below)
            $update = array();
            foreach($this->metabox as $meta) {
                if(isset($_POST['infernal-postmeta'][$meta['name']]) && $_POST['infernal-postmeta'][$meta['name']]) {
                    $update[$meta['name']] = Infernal_Helper::sanitize_data(trim($_POST['infernal-postmeta'][$meta['name']]), $meta['type']);
                }
                update_post_meta($post_id, '_infernal-postmeta', $update);
            }
        }

        function nonce_input()
        {
            wp_nonce_field(plugin_basename(__FILE__), 'inferno');
        }

        function get_meta_value() 
        {
            return (isset($this->_postmeta[$this->_meta['name']])) ? $this->_postmeta[$this->_meta['name']] : (isset($this->_meta['default']) ? $this->_meta['default'] : null);
        }

        public function show($post)
        {
            $this->_postmeta = get_post_meta($post->ID, '_infernal-postmeta', true);
            $this->nonce_input();

            echo '<div class="inferno-meta-box">';
            foreach($this->meta_box['fields'] as $field) {
                new Inferno_Options_Machine($field);
            }
            echo '</div>';
        }
    }
}
