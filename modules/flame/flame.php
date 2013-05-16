<?php 
/**
 * Plugin Name: Infernal Flame
 * Plugin URI:  http://themedale.net
 * Description: Powerful widget- and shortcodekit for WordPress. Also adds the ability to create multiple sidebars right from the panel!
 * Author:      Indiapart
 * Author URI:  http://themedale.net
 * Version:     1.0
 * 
 * Text Domain: inferno
 * Domain Path: /languages/
 */


/**
 * This is the InfernalPanel loader class.
 *
 * @package   IPPanel
 * @author    Maxim Zubarev
 */
if(!class_exists('Infernal_Flame')) {

    /**
     * Loader class for the IP Panel.
     */
    class Infernal_Flame extends Inferno {

        /**
         * included files without file ending
         *
         * @var array
         */
        public $includes = array(
            'shortcodes',
            'infernal-widget',
            'widget-recenttweets',
            'widget-flickr',
            'widget-video',
            'widget-society'
        );

        public $enqueue_scripts = array(
            'flame-data',
            'flame',

            'jquery-scrollto'
        );

        public $enqueue_styles = array(
            'infernal-flame'
        );

        public $settings = array(
            'sidebars' => array(),
            'scroll_button' => true,
            'scroll_button_offset' => 200,
            'scroll_button_duration' => 500
        );

        /**
         * constructor calls some initial methods.
         * @param array $config array for overwriting $this->_config
         */
        public function __construct() {
            $this->module_includes(dirname(__FILE__));

            if(!is_admin()) {
                // instead of $this->assets();
                add_action('init', array(&$this, 'assets'));
                add_action('init', array(&$this, 'flame_assets')); // detour because we need jquery loaded before all the flame tweak scripts
            }

            $infernal_shortcodes = new Infernal_Shortcodes();

            if(get_option('infernal_flame') != false) {
                $this->settings = get_option('infernal_flame');
            }

            if(!empty($this->settings['sidebars']))
                $this->settings['sidebars'] = array_unique($this->settings['sidebars']);

            $this->sidebar_request();

            add_action('init', array(&$this, 'init'));
            add_action('init', array(&$this, 'add_metabox_meta'));
            add_action('admin_init', array(&$this, 'admin_init'));
            add_action('admin_menu', array(&$this, 'admin_menu'));
        }

        public function init()
        {
            // add sidebars
            if(!empty($this->settings['sidebars'])) {
                foreach($this->settings['sidebars'] as $sidebar) {
                    register_sidebar(
                        array(
                            'name'          => $sidebar,
                            'id'            => 'sidebar-' . str_replace(' ', '-', strtolower($sidebar)),
                            'before_widget' => '<div id="%1$s" class="block %2$s">',
                            'after_widget'  => '<div class="clear"></div></div>',
                            'before_title'  => '<h3>',
                            'after_title'   => '</h3>',
                        )
                    );
                }
            }
        }

        function flame_assets()
        {
            add_action('wp_enqueue_scripts', array(&$this, 'flame_enqueue'), 2);
        }

        function flame_enqueue()
        {
            if(!empty($this->enqueue_scripts) && is_array($this->enqueue_scripts)) {
                foreach($this->enqueue_scripts as $handle) {
                    if($handle == 'jquery-scrollto' && $this->settings['scroll_button'] == true) {
                        wp_enqueue_script($handle);
                    }
                    // here is space for more "tweaks"; todo: idea, maybe another infernal plugin named "infernal tweaks" for something? or
                    // renaming infernal flame to infernal tweaks?
                }
                    
            }
        }


        public function sidebar_request()
        {   
            if(isset($_POST['add_sidebar']) && $_POST['add_sidebar'] != '') {
                $this->settings['sidebars'][] = esc_html($_POST['add_sidebar']);
                update_option('infernal_flame', $this->settings);

                header("Location: admin.php?page=infernal-flame&settings-updated=true");
                exit;
            } 
            // added && $_POST['submit'] === 'Add sidebar' as a workaround for trouble
            elseif(isset($_POST['add_sidebar']) && $_POST['submit'] === __('Add sidebar', 'inferno') && $_POST['add_sidebar'] == '' && !isset($_POST['remove_sidebar'])) {
                header("Location: admin.php?page=infernal-flame&settings-updated=false");
                exit;
            } 

            if(isset($_POST['remove_sidebar'])) {
                unset($this->settings['sidebars'][$_POST['remove_sidebar']]);
                update_option('infernal_flame', $this->settings);
                
                header("Location: admin.php?page=infernal-flame&settings-updated=true");
                exit;
            }
        }



        public function add_metabox_meta()
        {
            global $infernal_metabox, $wp_registered_sidebars;

            $infernal_metabox->metabox[] = array(
                'title'     => __('Video', 'inferno'),
                'name'      => 'attachment_video',
                'desc'      => __('Paste a video URL here like "http://www.youtube.com/watch?v=tDvBwPzJ7dY" or "https://vimeo.com/58449984" (without the quotes).', 'inferno'),
                'type'      => 'text',
                'post_type' => array('attachment')
            );

            $infernal_metabox->metabox[] = array(
                'title'     => __('Preview description', 'inferno'),
                'name'      => 'preview_description',
                'desc'      => __('A short sentence which will be displayed right under a post preview box', 'inferno'),
                'type'      => 'text',
                'post_type' => array('post')
            );

            $sidebars = array('_default' => 'Default (the first one in the widgets settings)', '_none' => 'None');
            $stack_sidebars = array();

            foreach($wp_registered_sidebars as $sidebar) {
                $stack_sidebars[$sidebar['id']] = $sidebar['name'];
            }
            $sidebars = array_merge($sidebars, $stack_sidebars);

            $infernal_metabox->metabox[] = array(
                'title'     => __('Sidebar to embed', 'inferno'),
                'name'      => 'sidebar',
                'desc'      => __('Decide which of the sidebars created with Infernal Flame You want to show on this page.', 'inferno'),
                'type'      => 'select',
                'options'   => $sidebars,
                'post_type' => array('page')
            );
        }

        function admin_init()
        {
            register_setting('infernal-flame', 'infernal_flame');
            add_settings_section('infernal-flame', '', array(&$this, 'intro'), 'infernal-flame');

            add_settings_field('scroll_button', 
                __('Do You want to activate the scroll to top button?', 'inferno'), 
                array(&$this, 'setting_scroll_button'), 
                'infernal-flame', 'infernal-flame');

            add_settings_field('scroll_button_duration', 
                __('How long shall the scroll duration be? 1 = 1ms, so 1000 = 1s', 'inferno'), 
                array(&$this, 'setting_scroll_button_duration'), 
                'infernal-flame', 'infernal-flame');

            add_settings_field('scroll_button_offset', 
                __('How many pixels shall be the offset of the scroll to top button, at which he appears / disappears. Type in 1 to make it appear after the smallest scroll move.', 'inferno'), 
                array(&$this, 'setting_scroll_button_offset'), 
                'infernal-flame', 'infernal-flame');
        }

        function admin_menu() {
            add_submenu_page(
                'inferno',
                'Infernal Flame',
                'Infernal Flame',
                'edit_theme_options',
                'infernal-flame',
                array(&$this, 'canvas')
            );
        }

        function canvas()
        {
            ?>
            <div class="wrap">
                <div id="icon-themes" class="icon32"></div>
                <h2>Infernal Flame</h2>
                <div id="infernal-canvas">
                    <?php $this->header(); ?>
                    <div id="infernal-content">
                        <?php $this->message(); ?>
                        <form action="options.php" method="post">
                            <?php settings_fields('infernal-flame'); ?>
                            <?php do_settings_sections('infernal-flame'); ?>
                            <?php submit_button(); ?>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }

        function intro()
        {
            echo '<p>' . __('Type in a name for a sidebar You want to add. All dynamically created sidebars are available on the admin widgets page.', 'inferno') . '</p>';
            echo '<input type="text" name="add_sidebar" />';
            submit_button(__('Add sidebar', 'inferno'));

            if(isset($this->settings['sidebars']) && !empty($this->settings['sidebars'])) {
                echo '<h3>Added sidebars</h3>';
                echo '<table class="infernal-sidebar-table">';
                echo '<thead><tr><th>Sidebar name</th><th>CSS id</th><th>Remove</th></tr></thead><tbody>';
                foreach($this->settings['sidebars'] as $key => $sidebar) {
                    echo '<tr><td>' . $sidebar . '</td><td>sidebar-' . str_replace(' ', '-', strtolower($sidebar)) . '</td><td><button name="remove_sidebar" value="' . $key . '">Remove sidebar</button></td></tr>';
                }
                echo '</tbody></table>';
            }

            echo '<h3>' . __('Infernal tweaks', 'inferno') . '</h3>';
        }

        function setting_scroll_button()
        {  
            echo '<select name="infernal_flame[scroll_button]">
                <option value="on" ' . ($this->settings['scroll_button'] == 'on' ? ' selected="selected"' : null) . '>On</option>
                <option value="off" ' . ($this->settings['scroll_button'] == 'off' ? ' selected="selected"' : null). '>Off</option>
            </select>';
        }

        function setting_scroll_button_duration()
        {   
            echo '<input type="text" name="infernal_flame[scroll_button_duration]" value="' . $this->settings['scroll_button_duration'] . '" />';
        }

        function setting_scroll_button_offset()
        {
            echo '<input type="text" name="infernal_flame[scroll_button_offset]" value="' . $this->settings['scroll_button_offset'] . '" />';
        }

        function get_notification_bar()
        {
            $output = '<div class="infernal-notification-bar">';
            $output .= '<div class="inner">';
            $output .= '<p>' . $this->settings['notification_bar_text'] . '</p>';
            $output .= '<div class="icon-remove close"></div>';
            $output .= '<div class="open"></div>';
            $output .= '</div>';
            $output .= '</div>';

            return $output;
        }

        /**
         * @var $args array()
         * $args['link'] 'image' | 'post'
         * todo: change img_width to width and img_height to height
         */
        function get_preview($args = array(
            'img_url'                => false,
            'img_width'              => false,
            'img_height'             => false,
            'template_hover'         => 'preview-hover',
            'effect'                 => 'default',
            'link'                   => 'media',
            'lightbox'               => false
        ))
        { 
            global $post;
            $permalink = get_permalink();

            extract(shortcode_atts(array(
                'img_url' => false,
                'img_width' => false,
                'img_height' => false,
                'template_hover' => 'preview-hover',
                'effect' => 'default',
                'link' => 'permalink',
                'lightbox' => false
            ), $args));

            $output = null;

            if($img_url || has_post_thumbnail()) {

                if(!$img_url) {
                    $thumb_id = get_post_thumbnail_id($post->ID);
                    $thumb = wp_get_attachment_image_src($thumb_id, 'full');
                    $img_url = $thumb[0];
                }

                $thumb_url = aq_resize($img_url, $img_width, $img_height, true, true, true);
                $this->view['thumb_url'] = $thumb_url;
                $iframe = false;

                if(empty($permalink) || $link == 'media') {
                    $attachment_video = inferno_get_post_meta($thumb_id, 'attachment_video');
                    if(!empty($attachment_video)) {
                        $permalink = Infernal_Helper::get_video_embed_url($attachment_video);
                        $iframe = true;
                    } else {
                        $permalink = $img_url;
                    }
                }

                $data_title = get_the_title();
                $data_desc = get_the_excerpt();

                ob_start();

                echo '<a href="' . $permalink . '" class="preview-thumb ' . $effect . ($lightbox ? ' infernal-lightbox' : null) . ($iframe ? ' iframe' : null) . '"' . ($lightbox ? ' data-title="' . $data_title . '"' : null) . '>';
                switch($effect) {
                    case 'fold':
                        $this->template($template_hover, 'fold');
                        $this->preview_fold($thumb_url);
                        break;
                    case 'flip':
                        $this->preview_flip($thumb_url);
                        echo '<div class="back">';
                        $this->template($template_hover, 'flip');
                        echo '</div>';
                        break;
                    default:
                        $this->template($template_hover);
                        $this->preview_default($thumb_url);
                        break;
                }
                echo '</a>';

                $output = ob_get_contents();
                ob_end_clean();
            }

            return $output;
        }


        function preview_fold($img_url)
        {
            ?>
            <div class="panel panel1" style="background-image: url(<?php echo $img_url; ?>);">
                <div class="overlay"></div>
            </div>
            <div class="panel panel2" style="background-image: url(<?php echo $img_url; ?>);">
                <div class="overlay"></div>
            </div>
            <div class="panel panel3" style="background-image: url(<?php echo $img_url; ?>);">
                <div class="overlay"></div>
            </div>
            <div class="panel panel4shadow"></div>
            <div class="panel panel4" style="background-image: url(<?php echo $img_url; ?>);">
                <div class="overlay"></div>
            </div>
            <img src="<?php echo $img_url ?>" alt="" class="fallback" />
            <?php
        }

        function preview_flip($img_url)
        {
            ?>
            <div class="front">
                <img src="<?php echo $img_url ?>" alt="<?php the_title(); ?>" />
            </div>
            <?php
        }

        function preview_default($img_url)
        {
            ?>
            <img src="<?php echo $img_url ?>" alt="<?php the_title(); ?>" />
            <?php
        }
    }
}
