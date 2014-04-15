<?php

if(!class_exists('Inferno_Update')) {
    class Inferno_Update extends Inferno {
    
        private $api_url;
        private $theme_id;
        private $theme_slug;
    
        function __construct($api_url, $theme_id, $theme_slug) {
            $this->api_url = $api_url;
            $this->theme_id = $theme_id;
            $this->theme_slug = $theme_slug;
    
            add_filter('pre_set_site_transient_update_themes', array(&$this, 'check_for_update'));
            
            // This is for testing only!
            set_site_transient('update_themes', null);
        }
        
        function check_for_update($transient) {
            if(empty($transient->checked)) return $transient;
            
            $request_string = $this->prepare_request('theme_update');
            $raw_response = wp_remote_post($this->api_url, $request_string);

            $response = null;
            if(!is_wp_error($raw_response) && ($raw_response['response']['code'] == 200))
                $response = json_decode($raw_response['body'], true);

            if(!empty($response)) // Feed the update data into WP updater
                $transient->response[$this->theme_slug] = $response;

            // once more for testing and debugging
            #echo '<pre>';
            #print_r($transient);
            #echo '</pre>';

            return $transient;
        }
        
        function prepare_request($action) {
            global $wp_version;
            
            return array(
                'body' => array(
                    'action' => $action,
                    'item' => $this->theme_id, 
                    'api_key' => $this->apikey
                ),
                'user-agent' => 'WordPress/' . $wp_version .'; ' . home_url()
            );  
        }
    }
}

