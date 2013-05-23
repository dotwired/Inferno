<?php

if(!class_exists('Inferno_FlexSlider')) {
    class Inferno_FlexSlider extends Inferno {

        // some default settings
        public $settings = array(
            'slider_animation'           => 'slide',
            'slider_animation_speed'     => 800,
            'slider_animation_direction' => 'horizontal',
            'slider_speed'               => 10000,
            'slider_control_nav'         => 'true',
            'slider_css'                 => 'theme_css',
            'overlay'                    => 'false',
            'overlay_class'              => ''
        );

        public $includes = false;

        public $enqueue_scripts = array(
            'jquery-flexslider',
            'infernal-slider'
        );

        public $enqueue_styles = array(
            'flexslider',
            'infernal-slider'
        );

        function __construct()
        {
            $this->module_includes(dirname(__FILE__));

            if(get_option('infernal_slider') != false) {
                $this->settings = get_option('infernal_slider');
            }

            if($this->settings['slider_css'] != 'infernal') {
                foreach($this->enqueue_styles as $key => $value) {
                    if($value == 'infernal-slider')
                        unset($this->enqueue_styles[$key]);
                }
            }

            add_action('init', array(&$this, 'assets')); // instead of $this->assets();

            add_action('init', array(&$this, 'init'), 1);
            add_action('init', array(&$this, 'add_metabox_meta'));
            add_action('admin_init', array(&$this, 'admin_init'));
            add_action('admin_menu', array(&$this, 'admin_menu'));
        }


        function init()
        {
            add_theme_support( 'post-thumbnails' );

            // create slide post type
            $slide_labels = array(
              'name'               => __('Slides', INFERNO),
              'singular_name'      => __('Slide', INFERNO),
              'add_new'            => __('Add new', INFERNO),
              'add_new_item'       => __('Add new slide', INFERNO),
              'edit_item'          => __('Edit slide', INFERNO),
              'new_item'           => __('New slide', INFERNO),
              'all_items'          => __('All slides', INFERNO),
              'view_item'          => __('View slide', INFERNO),
              'search_items'       => __('Search slides', INFERNO),
              'not_found'          => __('No slides found', INFERNO),
              'not_found_in_trash' => __('No slides found in Trash', INFERNO), 
              'parent_item_colon'  => '',
              'menu_name'          => __('FlexSlider', INFERNO)

            );
            $args = array(
              'labels'             => $slide_labels,
              'public'             => true,
              'publicly_queryable' => true,
              'show_ui'            => true, 
              'show_in_menu'       => true, 
              'query_var'          => true,
              'rewrite'            => array('slug' => __('slide', 'URL slug', INFERNO)),
              'capability_type'    => 'page',
              'has_archive'        => true, 
              'hierarchical'       => false,
              'menu_position'      => 100,
              'supports'           => array('title', 'editor', 'author', 'thumbnail')
            ); 
            register_post_type('slide', $args);




            $taxonomy_labels = array(
                'name'                       => __('Slider groups', 'inferno'),
                'singular_name'              => __('Slider', 'inferno'),
                'search_items'               => __('Search slider', 'inferno'),
                'popular_items'              => __('Popular slider', 'inferno'),
                'all_items'                  => __('All slider', 'inferno'),
                'parent_item'                => null,
                'parent_item_colon'          => null,
                'edit_item'                  => __('Edit slider', 'inferno'), 
                'update_item'                => __('Update slider', 'inferno'),
                'add_new_item'               => __('Add new slider', 'inferno'),
                'new_item_name'              => __('New slider name', 'inferno'),
                'separate_items_with_commas' => __('Separate slider with commas', 'inferno'),
                'add_or_remove_items'        => __('Add or remove slider', 'inferno'),
                'choose_from_most_used'      => __('Choose from the most used slider', 'inferno'),
                'menu_name'                  => __('Slider', 'inferno'),
              ); 

            register_taxonomy('slider', 'slide', array(
                'hierarchical'          => true,
                'labels'                => $taxonomy_labels,
                'show_ui'               => true,
                'update_count_callback' => '_update_post_term_count',
                'query_var'             => true,
                'rewrite'               => array('slug' => 'slider'),
            ));
        }


        function admin_init()
        {
            register_setting('infernal-slider', 'infernal_slider');
            add_settings_section('infernal-slider', '', array(&$this, 'intro'), 'infernal-slider');

            add_settings_field('slider_animation', 
                __('Slider animation', INFERNO), 
                array(&$this, 'setting_slider_animation'), 
                'infernal-slider', 'infernal-slider');

            /* height bug here.
            add_settings_field('slider_animation_direction', 
                __('Slider animation direction', INFERNO), 
                array(&$this, 'setting_slider_animation_direction'), 
                'infernal-slider', 'infernal-slider');
            */

            add_settings_field('slider_control_nav', 
                __('Slider control navigation', INFERNO), 
                array(&$this, 'setting_slider_control_nav'), 
                'infernal-slider', 'infernal-slider');

            add_settings_field('slider_animation_speed', 
                __('Slider animation speed', INFERNO), 
                array(&$this, 'setting_slider_animation_speed'), 
                'infernal-slider', 'infernal-slider');

            add_settings_field('slider_speed', 
                __('Slider speed', INFERNO), 
                array(&$this, 'setting_slider_speed'), 
                'infernal-slider', 'infernal-slider');

            add_settings_field('slider_css', 
                __('Slider stylesheet', INFERNO), 
                array(&$this, 'setting_slider_css'), 
                'infernal-slider', 'infernal-slider');

            add_settings_field('overlay', 
                __('Slider overlay', INFERNO), 
                array(&$this, 'setting_overlay'), 
                'infernal-slider', 'infernal-slider');

            add_settings_field('overlay_class', 
                __('Slider overlay CSS class', INFERNO), 
                array(&$this, 'setting_overlay_class'), 
                'infernal-slider', 'infernal-slider');
        }

        function admin_menu() {
            add_submenu_page(
                'inferno',
                'Infernal Slider',
                'Infernal Slider',
                'edit_theme_options',
                'infernal-slider',
                array(&$this, 'canvas')
            );
        }


        function canvas()
        {
            ?>
            <div class="wrap">
                <div id="icon-themes" class="icon32"></div>
                <h2>Infernal Inferno</h2>
                <div id="infernal-canvas">
                    <?php $this->header(); ?>
                    <div id="infernal-content">
                        <?php $this->message(); ?>
                        <form action="options.php" method="post">
                            <?php settings_fields('infernal-slider'); ?>
                            <?php do_settings_sections('infernal-slider'); ?>
                            <?php submit_button(); ?>
                        </form>
                    </div>
                </div>
            </div>
            <?php
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

        function setting_slider_animation()
        {           
            echo '<select name="infernal_slider[slider_animation]">
                <option value="slide"'. (($this->settings['slider_animation'] == 'slide') ? ' selected="selected"' : '') .'>Slide</option>
                <option value="fade"'. (($this->settings['slider_animation'] == 'fade') ? ' selected="selected"' : '') .'>Fade</option>
            </select>';
        }

        function setting_slider_animation_direction()
        {           
            echo '<select name="infernal_slider[slider_animation_direction]">
                <option value="horizontal"'. (($this->settings['slider_animation_direction'] == 'horizontal') ? ' selected="selected"' : '') .'>Horizontal</option>
                <option value="vertical"'. (($this->settings['slider_animation_direction'] == 'vertical') ? ' selected="selected"' : '') .'>Vertical</option>
            </select>';
        }

        function setting_slider_control_nav()
        {           
            echo '<select name="infernal_slider[slider_control_nav]">
                <option value="true"'. (($this->settings['slider_control_nav'] == 'true') ? ' selected="selected"' : '') .'>Default control navigation</option>
                <option value="thumbnails"'. (($this->settings['slider_control_nav'] == 'thumbnails') ? ' selected="selected"' : '') .'>Use thumbnail navigation</option>
                <option value="false"'. (($this->settings['slider_control_nav'] == 'false') ? ' selected="selected"' : '') .'>Turn off control navigation</option>
            </select>';
        }

        function setting_slider_animation_speed()
        {           
            echo '<input type="text" name="infernal_slider[slider_animation_speed]" value="' . $this->settings['slider_animation_speed'] . '" />';
        }

        function setting_slider_speed()
        {          
            echo '<input type="text" name="infernal_slider[slider_speed]" value="' . $this->settings['slider_speed'] . '" />';
        }

        function setting_slider_css()
        {           
            echo '<select name="infernal_slider[slider_css]">
                <option value="infernal"'. (($this->settings['slider_css'] == 'infernal') ? ' selected="selected"' : '') .'>Use plugin stylesheet</option>
                <option value="theme"'. (($this->settings['slider_css'] == 'theme') ? ' selected="selected"' : '') .'>Use theme stylesheet</option>
            </select>';
        }

        function setting_overlay()
        {           
            echo '<select name="infernal_slider[overlay]">
                <option value="true"'. (($this->settings['overlay'] == 'true') ? ' selected="selected"' : '') .'>Overlay slider images</option>
                <option value="false"'. (($this->settings['overlay'] == 'false') ? ' selected="selected"' : '') .'>Do not overlay images</option>
            </select>';
        }

        function setting_overlay_class()
        {           
            echo '<input type="text" name="infernal_slider[overlay_class]" value="' . $this->settings['overlay_class'] . '" />';
        }


        function add_metabox_meta()
        {
            global $infernal_metabox;

            $infernal_metabox->metabox[] = array(
                'title'     => __('Slide caption', INFERNO),
                'name'      => 'slide_caption',
                'desc'      => __('Whether to show an image caption or not.', INFERNO),
                'type'      => 'select',
                'default'   => 'yes',
                'options'   => array(
                    'yes' => 'Yes',
                    'no'  => 'No'
                ),
                'post_type' => array('slide')
            );

            $infernal_metabox->metabox[] = array(
                'title'     => __('Slide link', INFERNO),
                'name'      => 'slide_url',
                'desc'      => __('Where do You want to link this slide?', INFERNO),
                'type'      => 'text',
                'post_type' => array('slide')
            );

            $post_types = get_post_types(array('public' => true), 'names');
            unset($post_types['slide']);

            $infernal_metabox->metabox[] = array(
                'title'     => __('Slider', INFERNO),
                'name'      => 'slider',
                'desc'      => __('Whether to show a slider on this page or not.', INFERNO),
                'default'   => 'no',
                'type'      => 'select',
                'options'   => array(
                    'yes'   => 'Yes',
                    'no'    => 'No'
                ),
                'post_type' => $post_types
            );

            $infernal_metabox->metabox[] = array(
                'title'     => __('Slider source', INFERNO),
                'name'      => 'slider_source',
                'desc'      => __('Chose the source where the slider of this page should fetch images from.', INFERNO),
                'default'   => 'posts',
                'type'      => 'select',
                'options'   => array(),
                'post_type' => $post_types
            );


            $infernal_metabox->metabox[] = array(
                'title'     => __('Slider size', INFERNO),
                'name'      => 'slider_size',
                'desc'      => __('Type in the desired slider size, for example "960x300". Wrong inputs may lead to unexpected results. Leave blank to use the original size of the used images.', INFERNO),
                'default'   => '960x300',
                'type'      => 'text',
                'post_type' => $post_types
            );

            $infernal_metabox->metabox[] = array(
                'title'     => __('Slider link', INFERNO),
                'name'      => 'slider_link',
                'desc'      => __('Where do You want to generate the link to the URL for the slides?', INFERNO),
                'default'   => 'full_slider',
                'type'      => 'select',
                'options'   => array(
                    'full_slider'                   => 'Link full slider size',
                    'full_slider_excluding_caption' => 'Link full slider excluding caption',
                    'heading'                       => 'Link slider caption heading',
                    'none'                          => 'No linking'
                ),
                'post_type' => $post_types
            );

            $terms = get_terms('slider', 'hide_empty=0');

            // todo: solve this better
            if($terms) {
                foreach($terms as $term) {
                    $infernal_metabox->metabox[(int)(count($infernal_metabox->metabox) - 3)]['options'][$term->slug] = $term->name;
                }
            }
        }



        /**
         * todo: improve this method by much -.-
         * @param  [type] $atts [description]
         * @return [type]       [description]
         */
        function get_output($atts)
        {
            global $wp_query;

            extract(shortcode_atts(array(
                'source'          => null,
                'limit'           => $this->settings['source_posts_count'],
                'link'            => 'full_slider',
                'width'           => false,
                'height'          => false,
                'css_class'       => null,
                'overlay'         => $this->settings['overlay'],
                'overlay_class'   => $this->settings['overlay_class']
            ), $atts));
            
            if($source == null) return;

            ?>
            <div id="slideshow" class="<?php echo $css_class; ?>">
                <div class="slider flexslider">
                    <ul class="slides">
                        <?php
                        $args = array(
                            'numberposts' => -1,
                            'post_type' => 'slide',
                            'tax_query' => array(
                                'taxonomy' => 'slider',
                                'field' => 'slug',
                                'terms' => $source
                            )
                        );

                        global $post;
                        $postslist = get_posts($args);
                        foreach($postslist as $post) : setup_postdata($post); 

                        { // generate the thumb url
                            $thumb_id = get_post_thumbnail_id($post->ID);
                            if(empty($thumb_id)) continue;

                            $thumb = wp_get_attachment_image_src($thumb_id, 'full');

                            if($width && $height) {
                                $thumb_url = aq_resize($thumb[0], $width, $height, true, true, true);
                            } else {
                                $thumb_url = $thumb[0];
                            }
                        }

                        // get the slider link url
                        $slide_url = null;
                        $slide_url = inferno_get_post_meta($post->ID, 'slide_url');
                        
                        ?> 
                        <li data-thumb="<?php echo $thumb_url; ?>">
                            <?php if(!empty($slide_url) && ($link == 'full_slider' || $link == 'full_slider_excluding_caption')) echo '<a href="' . $slide_url . '">'; ?>
                            <img src="<?php echo $thumb_url; ?>" alt="<?php the_title(); ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" />
                            <?php if(!empty($slide_url) && $link == 'full_slider_excluding_caption') echo '</a>'; ?>

                            <?php if($overlay == 'true') : ?>
                            <div class="overlay<?php if(!empty($overlay_class)) echo ' ' . $overlay_class; ?>"></div>
                            <?php endif; ?>

                            <?php
                            $slide_caption = inferno_get_post_meta($post->ID, 'slide_caption') == 'yes' ? true : false;
                            if($slide_caption === true) : 
                                $flex_caption = apply_filters('inferno_slider_caption', null, $slide_url, $link);
                                if($flex_caption != null) : echo $flex_caption;
                                else : ?>
                                <div class="flex-caption">
                                    <div class="caption-inner">
                                        <?php 
                                        if(!empty($slide_url) && $link == 'heading') echo '<a href="' . $slide_url . '">';
                                        if(get_the_title()) echo '<h2>' . get_the_title() . '</h2>';
                                        if(!empty($slide_url) && $link == 'heading') echo '</a>';
                                        the_content();
                                        ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if(!empty($slide_url) && $link == 'full_slider') echo '</a>'; ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <?php
        }
    }
}