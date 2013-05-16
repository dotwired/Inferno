<?php
/**
 * Plugin Name: Infernal Society
 * Plugin URI:  http://themedale.net
 * Description: Widget and shortcode for your social profiles. It's the awesome social hub of your website.
 * Author:      Indiapart
 * Author URI:  http://themedale.net
 * Version:     1.0
 * 
 * Text Domain: inferno
 * Domain Path: /languages/
 */

if(!class_exists('Infernal_Society')) {
    class Infernal_Society extends Inferno {

        public $iconsets = array(
            'zillasocial'     => 'ZillaSocial',
            'somicro'         => 'Somicro'
            //'lifetree-round'  => 'Lifetree (round)',
            //'lifetree-square' => 'Lifetree (square)'
        );

        public $societies = array(
            '500px' => array(
                'help'     => 'e.g. http://500px.com/username',
                'iconsets' => array('zillasocial')
            ),
            'Behance' => array(
                'help'     => 'e.g. http://www.behance.net/username',
                'iconsets' => array('zillasocial', 'somicro')
            ),
            'Deviantart' => array(
                'help'     => 'e.g. http://username.deviantart.com',
                'iconsets' => array('zillasocial', 'somicro')
            ),
            'Dribbble' => array(
                'help'     => 'e.g. http://dribbble.com/username',
                'iconsets' => array('zillasocial', 'somicro')
            ),
            'E-Mail' => array(
                'help'     => 'e.g. mailto:user@name.com',
                'iconsets' => array('zillasocial', 'somicro')
            ),
            // todo: 'envato' => 
            'Facebook' => array(
                'help'     => 'e.g. https://www.facebook.com/username',
                'iconsets' => array('zillasocial', 'somicro')
            ),
            'Feed' => array(
                'help'     => 'e.g. %s/feed',
                'iconsets' => array('zillasocial', 'somicro')
            ),
            'Flickr' => array(
                'help'     => 'e.g. http://www.flickr.com/photos/username',
                'iconsets' => array('zillasocial', 'somicro')
            ),
            'GitHub'   => array(
                'help'     => 'e.g. https://github.com/username',
                'iconsets' => array('zillasocial')
            ),
            'Google+' => array(
                'help'     => 'e.g. http://plus.google.com/userID',
                'iconsets' => array('zillasocial', 'somicro')
            ),
            'Instagram' => array(
                'help'     => 'e.g. http://instagram.com/username',
                'iconsets' => array('zillasocial', 'somicro')
            ),
            'Pinterest' => array(
                'help'     => 'e.g. http://pinterest.com/username/',
                'iconsets' => array('zillasocial', 'somicro')
            ),
            'Quote.fm' => array(
                'help'     => 'e.g. http://quote.fm/username',
                'iconsets' => array('zillasocial')
            ),
            'Skype' => array(
                'help'     => 'e.g. skype:username',
                'iconsets' => array('zillasocial', 'somicro')
            ),
            'Soundcloud' => array(
                'help'     => 'e.g. http://soundcloud.com/username',
                'iconsets' => array('zillasocial', 'somicro')
            ),
            'Spotify' => array(
                'help'     => 'e.g. http://open.spotify.com/user/username',
                'iconsets' => array('zillasocial', 'somicro')
            ),
            'StumbleUpon' => array(
                'help'     => 'e.g. http://www.stumbleupon.com/stumbler/username',
                'iconsets' => array('zillasocial', 'somicro')
            ),
            'Tumblr' => array(
                'help'     => 'e.g. http://username.tumblr.com',
                'iconsets' => array('zillasocial', 'somicro')
            ),
            'Twitter' => array(
                'help'     => 'e.g. https://twitter.com/username',
                'iconsets' => array('zillasocial', 'somicro')
            ),
            'Vimeo' => array(
                'help'     => 'e.g. http://vimeo.com/username',
                'iconsets' => array('zillasocial', 'somicro')
            ),
            'WordPress' => array(
                'help'     => 'e.g. http://username.wordpress.com',
                'iconsets' => array('zillasocial', 'somicro')
            ),
            'YouTube' => array(
                'help'     => 'e.g. http://www.youtube.com/user/username',
                'iconsets' => array('zillasocial', 'somicro')
            )
        );

        public $settings;

        public $admin_enqueue_styles = array(
            'admin-infernal-society'
        );
        
        public function __construct()
        {
            if(get_option('infernal_society') != false) {
                $this->settings = get_option('infernal_society');
            }

            add_action('init', array(&$this, 'assets')); // instead of $this->assets();
            add_action('admin_init', array(&$this, 'admin_init'));
            add_action('admin_menu', array(&$this, 'admin_menu'));
        }

        public function admin_init()
        {
            register_setting('infernal-society', 'infernal_society');
            add_settings_section('infernal-society', '', array(&$this, 'intro'), 'infernal-society');
            
            add_settings_field('iconsetslabel', __('Available icon sets:', 'inferno'), array(&$this, 'setting_isonsetslabel'), 'infernal-society', 'infernal-society');

            foreach($this->societies as $service => $data) {
                $this->add_network($service, $service . ':', $data);
            }
            
            add_settings_field('iconset', __('Iconset', 'inferno'), array(&$this, 'setting_iconset'), 'infernal-society', 'infernal-society');
            add_settings_field('size', __('Icon Size', 'inferno'), array(&$this, 'setting_size'), 'infernal-society', 'infernal-society');
            add_settings_field('links', __('Open Links', 'inferno'), array(&$this, 'setting_links'), 'infernal-society', 'infernal-society');
            add_settings_field('hover', __('Hover Effect', 'inferno'), array(&$this, 'setting_hover'), 'infernal-society', 'infernal-society');
            add_settings_field('align', __('Align', 'inferno'), array(&$this, 'setting_align'), 'infernal-society', 'infernal-society');
            add_settings_field('preview', __('Preview', 'inferno'), array(&$this, 'setting_preview'), 'infernal-society', 'infernal-society');
        }

        function admin_menu() {
            add_submenu_page(
                'inferno',
                'Infernal Society',
                'Infernal Society',
                'edit_theme_options',
                'infernal-society',
                array(&$this, 'canvas')
            );
        }

        function canvas()
        {
            ?>
            <div class="wrap">
                <div id="icon-themes" class="icon32"></div>
                <h2>Infernal Society</h2>
                <div id="infernal-canvas" class="infernal-society">
                    <?php $this->header(); ?>
                    <div id="infernal-content">
                        <?php $this->message(); ?>
                        <form action="options.php" method="post">
                            <?php settings_fields('infernal-society'); ?>
                            <?php do_settings_sections('infernal-society'); ?>
                            <?php submit_button(); ?>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }

        function setting_isonsetslabel()
        {
            echo '<div class="iconset-columnlabel">';
            foreach($this->iconsets as $iconsetHandle => $iconsetName) {
                echo '<span class="iconset-' . $iconsetHandle . '">' . $iconsetName . '</span>';
            }
            echo '</div>';
        }

        function add_network($id, $service, $data = array())
        {
            $args = array(
                'id'       => $id,
                'help'     => $data['help'],
                'iconsets' => $data['iconsets']
            );

            add_settings_field($id, $service, array(&$this, 'setting_profile'), 'infernal-society', 'infernal-society', $args);
        }

        function setting_profile($args)
        {
            if(!isset($this->settings[$args['id']])) $this->settings[$args['id']] = '';
            
            echo '<input type="text" name="infernal_society[' . $args['id'] . ']" class="regular-text" value="' . $this->settings[$args['id']] . '" /> ';

            if(!empty($args['iconsets'])) {
                echo '<div class="profile-iconsets-available">';
                foreach($this->iconsets as $iconsetHandle => $iconsetName) {
                    if(in_array($iconsetHandle, $args['iconsets'])) {
                        echo '<div class="icon-ok profile-' . $iconsetHandle . '"></div>';
                    } else {
                        echo '<div class="icon-remove profile-' . $iconsetHandle . '"></div>';
                    }
                }
                echo '</div>';
            }

            if($args['help']) echo '<span class="description">' . sprintf($args['help'], home_url()) . '</span>';
        }

        function setting_iconset()
        {
            if(!isset($this->settings['iconset'])) $this->settings['iconset'] = 'zillasocial';
            
            echo '<select name="infernal_society[iconset]">';
            foreach($this->iconsets as $iconsetHandle => $iconsetName) {
                echo '<option value="' . $iconsetHandle . '"'. (($this->settings['iconset'] == $iconsetHandle) ? ' selected="selected"' : '') .'>' . $iconsetName . '</option>';
            }
            echo '</select>';
        }

        function setting_size()
        {
            if(!isset($this->settings['size'])) $this->settings['size'] = '16px';
            
            echo '<select name="infernal_society[size]">
            <option value="16px"'. (($this->settings['size'] == '16px') ? ' selected="selected"' : '') .'>16px</option>
            <option value="32px"'. (($this->settings['size'] == '32px') ? ' selected="selected"' : '') .'>32px</option>
            </select>';
        }

        function setting_links()
        {
            if(!isset($this->settings['links'])) $this->settings['links'] = 'same_window';
            
            echo '<select name="infernal_society[links]">
            <option value="same_window"'. (($this->settings['links'] == 'same_window') ? ' selected="selected"' : '') .'>In same window</option>
            <option value="new_window"'. (($this->settings['links'] == 'new_window') ? ' selected="selected"' : '') .'>In new window</option>
            </select>';
        }

        function setting_hover()
        {
            if(!isset($this->settings['hover'])) $this->settings['hover'] = 'fadein';
            
            echo '<select name="infernal_society[hover]">
            <option value="no"'. (($this->settings['hover'] == 'no') ? ' selected="selected"' : '') .'>No effect</option>
            <option value="fadein"'. (($this->settings['hover'] == 'fadein') ? ' selected="selected"' : '') .'>Fade in</option>
            <option value="fadeout"'. (($this->settings['hover'] == 'fadeout') ? ' selected="selected"' : '') .'>Fade out</option>
            </select>';

            // <option value="bounce"'. (($this->settings['hover'] == 'bounce') ? ' selected="selected"' : '') .'>Bounce</option>
        }

        function setting_align()
        {
            if(!isset($this->settings['align'])) $this->settings['align'] = 'no';
            
            echo '<select name="infernal_society[align]">
            <option value="no"'. (($this->settings['align'] == 'no') ? ' selected="selected"' : '') .'>No alignment</option>
            <option value="center"'. (($this->settings['align'] == 'center') ? ' selected="selected"' : '') .'>Center alignment</option>
            <option value="left"'. (($this->settings['align'] == 'left') ? ' selected="selected"' : '') .'>Left alignment</option>
            <option value="right"'. (($this->settings['align'] == 'right') ? ' selected="selected"' : '') .'>Right alignment</option>
            </select>';
        }

        function setting_preview()
        {
            if($this->settings) echo $this->get_output();
        }

        function message()
        {
            if(isset($_GET['settings-updated']) && $_GET['settings-updated']) : ?>
            <div class="infernal-updated success">
                <p><?php _e('Options successfully saved!', 'inferno'); ?></p>
            </div>
            <?php elseif(isset($_GET['settings-updated']) && !$_GET['settings-updated']) : ?>
            <div class="infernal-updated fail">
                <p><?php _e('Options could not be saved. Please try again or make further steps.', 'inferno'); ?></p>
            </div>
            <?php endif;
        }

        function intro()
        {
            echo '<p>' . __('Paste the URLs of Your social network accounts. The widget and shortcode will automatically link to the specified URLs.', 'inferno') . '</p>';
        }

        function shortcode($atts = array())
        {
            extract(shortcode_atts(array(
                'size'      => null,
                'societies' => null,
                'align'     => null,
                'links'     => 'same_window',
                'hover'     => 'fadein',
                'iconset'   => 'zillasocial'
            ), $atts));

            $societiesArray = array();
            if($societies) $societiesArray = explode(',', str_replace(' ', '', esc_attr($societies)));

            $outputAtts = array(
                'size'      => esc_attr($size),
                'align'     => esc_attr($align),
                'links'     => esc_attr($links),
                'hover'     => esc_attr($hover),
                'iconset'   => esc_attr($iconset),
                'societies' => $societiesArray
            );
            
            return $this->get_output($outputAtts);
        }

        function get_output($atts = array())
        {
            $options = get_option('infernal_society');

            $options['size'] = isset($atts['size']) ? $atts['size'] : (isset($options['size']) ? $options['size'] : '16px');
            $options['align'] = isset($atts['align']) ? $atts['align'] : (isset($options['align']) ? $options['align'] : 'no');
            if($options['align'] == 'no') $options['align'] = null;
            $options['links'] = isset($atts['links']) ? $atts['links'] : (isset($options['links']) ? $options['links'] : 'same_window');
            $options['hover'] = isset($atts['hover']) ? $atts['hover'] : (isset($options['hover']) ? $options['hover'] : 'fadein');
            if($options['hover'] == 'no') $options['hover'] = null;
            $options['iconset'] = isset($atts['iconset']) ? $atts['iconset'] : (isset($options['iconset']) ? $options['iconset'] : 'zillasocial');

            $output = '<div class="infernal-society size-' . $options['size'] . ($options['align'] ? ' align' . $options['align'] : null) . ($options['hover'] ? ' hover-' . $options['hover'] : null) . '">';

            if(!isset($options['societies']) || empty($options['societies'])){
                foreach($this->societies as $service => $data) {
                    if(isset($options[$service]) && $options[$service] && in_array($options['iconset'], $this->societies[$service]['iconsets'])) {
                        $output .= '<a href="'. $options[$service] .'" class="'. $service .'"'. (($options['links'] == 'new_window') ? ' target="_blank"' : '') .'><img src="'. INFERNO_URL . 'assets/img/society/' . $options['iconset'] . '/' . $options['size'] .'/'. $service .'.png" alt="'. $service .'" /></a> ';
                    }
                }
            }
            else {
                foreach($options['societies'] as $service) {
                    if(isset($options[$service]) && $options[$service] && in_array($options['iconset'], $this->societies[$service]['iconsets'])) {
                        $output .= '<a href="'. $options[$service] .'" class="'. $service .'"'. (($options['links'] == 'new_window') ? ' target="_blank"' : '') .'><img src="'. INFERNO_URL . 'assets/img/society/' . $options['iconset'] . '/' . $options['size'] .'/'. $service .'.png" alt="'. $service .'" /></a> ';
                    }
                }
            }
            
            $output .= '</div>';
            return $output;
        }
    }
}