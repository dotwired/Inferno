<?php
/**
 * Plugin Name: Infernal Portfolio
 * Plugin URI:  http://themedale.net
 * Description: An advanced portfolio module. Customizeable but still really easy to use.
 * Author:      Indiapart
 * Author URI:  http://themedale.net
 * Version:     1.0
 * 
 * Text Domain: inferno
 * Domain Path: /languages/
 */

if(!class_exists('Infernal_Portfolio')) {

    /**
     * Loader class for the IP Panel.
     */
    class Infernal_Portfolio extends Inferno {

        // some default settings
        public $settings = array(
            'hover_effect' => 'fold'
        );

        public $includes = array();

        public $enqueue_styles = array(
            'infernal-portfolio'
        );

        public $enqueue_scripts = array(
            'jquery-imagesloaded',
            'jquery-easing',
            #'animate-scale',
            #'css-transform',
            'jquery-isotope',
            'infernal-portfolio'
        );

        function __construct()
        {
            $this->module_includes('infernal-portfolio');

            if(get_option('infernal_portfolio') != false) {
                $this->settings = get_option('infernal_portfolio');    
            }
            

            add_action('init', array(&$this, 'init'), 1);
            add_action('init', array(&$this, 'add_metabox_meta'));
            add_action('admin_init', array(&$this, 'admin_init'));
            #add_action('admin_menu', array(&$this, 'admin_menu'));

            if(!is_admin()) {
                add_action('init', array(&$this, 'assets')); // instead of $this->assets();
            }
        }


        function init()
        {
            add_theme_support('post-thumbnails');

            // create slide post type
            $portfolio_labels = array(
              'name'               => __('Portfolio', 'inferno'),
              'singular_name'      => __('Work', 'inferno'),
              'add_new'            => __('Add new', 'inferno'),
              'add_new_item'       => __('Add new work', 'inferno'),
              'edit_item'          => __('Edit work', 'inferno'),
              'new_item'           => __('New work', 'inferno'),
              'all_items'          => __('All works', 'inferno'),
              'view_item'          => __('View work', 'inferno'),
              'search_items'       => __('Search portfolio', 'inferno'),
              'not_found'          => __('No work found', 'inferno'),
              'not_found_in_trash' => __('No works found in Trash', 'inferno'), 
              'parent_item_colon'  => '',
              'menu_name'          => __('Portfolio', 'inferno')

            );

            $args = array(
              'labels'             => $portfolio_labels,
              'public'             => true,
              'publicly_queryable' => true,
              'show_ui'            => true, 
              'show_in_menu'       => true, 
              'query_var'          => true,
              'rewrite'            => array('slug' => __('portfolio', 'URL slug', 'inferno')),
              'capability_type'    => 'page',
              'has_archive'        => true, 
              'hierarchical'       => false,
              'menu_position'      => null,
              'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt')
            ); 
            register_post_type('portfolio', $args);

            $taxonomy_labels = array(
                'name'                       => __('Category', 'inferno'),
                'singular_name'              => __('Category', 'inferno'),
                'search_items'               => __('Search categories', 'inferno'),
                'popular_items'              => __('Popular categories', 'inferno'),
                'all_items'                  => __('All categories', 'inferno'),
                'parent_item'                => null,
                'parent_item_colon'          => null,
                'edit_item'                  => __('Edit portfolio', 'inferno'), 
                'update_item'                => __('Update category', 'inferno'),
                'add_new_item'               => __('Add new category', 'inferno'),
                'new_item_name'              => __('New portfolio category name', 'inferno'),
                'separate_items_with_commas' => __('Separate categories with commas', 'inferno'),
                'add_or_remove_items'        => __('Add or remove category', 'inferno'),
                'choose_from_most_used'      => __('Choose from the most used category', 'inferno'),
                'menu_name'                  => __('Categories', 'inferno'),
            ); 

            register_taxonomy('portfolio_category', 'portfolio', array(
                'hierarchical'          => true,
                'labels'                => $taxonomy_labels,
                'show_ui'               => true,
                'update_count_callback' => '_update_post_term_count',
                'query_var'             => true,
                'rewrite'               => array('slug' => 'portfolio'),
            ));
        }


        function admin_init()
        {
            register_setting('infernal-portfolio', 'infernal_portfolio');
            add_settings_section('infernal-portfolio', '', array(&$this, 'intro'), 'infernal-portfolio');
        }

        function admin_menu() {
            add_submenu_page(
                'inferno',
                'Infernal Portfolio',
                'Infernal Portfolio',
                'edit_theme_options',
                'infernal-portfolio',
                array(&$this, 'canvas')
            );
        }




        function add_metabox_meta()
        {
            global $infernal_metabox;

            $infernal_metabox->metabox[] = array(
                'title'     => __('Hide the post thumbnail in the slider', 'inferno'),
                'name'      => 'portfolio_hide_post_thumb',
                'desc'      => __('You can hide the post thumbnail image which you defined for the portfolio preview from the work slider.', 'inferno'),
                'default'   => 'no',
                'type'      => 'select',
                'options'   => array(
                    'yes' => 'Yes',
                    'no'  => 'No'
                ),
                'post_type' => array('portfolio')
            );

            $infernal_metabox->metabox[] = array(
                'title'     => __('Ajax portfolio', 'inferno'),
                'name'      => 'portfolio_ajax',
                'desc'      => __('Do you want to use ajax on this portfolio page?', 'inferno'),
                'default'   => 'no',
                'options'   => array(
                    'yes'   => 'Yes',
                    'no'    => 'No'
                ),
                'type'      => 'select',
                'post_type' => array('page')
            );

            $infernal_metabox->metabox[] = array(
                'title'     => __('Portfolio image size', 'inferno'),
                'name'      => 'portfolio_image_size',
                'desc'      => __('Type in the image size (proportion) of the generated images, such as "400x200" where "400" is the image width and "200" the image height. Images will be scaled down for responsive purposes, while large image proportion will cause more load time but better quality.', 'inferno'),
                'default'   => '400x200',
                'type'      => 'text',
                'post_type' => array('page')
            );

            $infernal_metabox->metabox[] = array(
                'title'     => __('Portfolio hover effect', 'inferno'),
                'name'      => 'portfolio_effect_hover',
                'desc'      => __('Which effect to use for preview hovering.', 'inferno'),
                'default'   => 'default',
                'type'      => 'select',
                'options'   => array(
                    'default' => 'Default',
                    'fold'    => 'Fold',
                    'flip'    => 'Flip'
                ),
                'post_type' => array('page')
            );
        }



        function canvas()
        {
            ?>
            <div class="wrap">
                <div id="icon-themes" class="icon32"></div>
                <h2>Infernal Portfolio</h2>
                <div id="infernal-canvas">
                    <?php $this->header(); ?>
                    <div id="infernal-content">
                        <?php $this->message(); ?>
                        <form action="options.php" method="post">
                            <?php settings_fields('infernal-portfolio'); ?>
                            <?php do_settings_sections('infernal-portfolio'); ?>
                            <?php submit_button(); ?>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }

        function message(){}


        private function filter($categories = array())
        {
            if(!empty($categories)) {
                $portfolio_categories = get_terms('portfolio_category', array('include' => $categories)); 
            } else {
                $portfolio_categories = get_terms('portfolio_category', 'object'); 
            }

            if($portfolio_categories) {
                echo '<div class="portfolio-filter-container">';
                echo '<ul class="portfolio-filter">';
                echo '<li class="selected"><a href="#" data-filter="*">' . __('Show all', 'inferno') . '</a></li>';
                foreach($portfolio_categories  as $portfolio_category) {
                    echo '<li><a href="#" data-filter=".' . $portfolio_category->slug . '">' . $portfolio_category->name . '</a></li>';
                }
                echo '</ul>';
                echo '<div class="clear"></div>';
                echo '</div>';
            }  
        }

        /**
         * print the portfolio list
         * 
         * @param  array  $args [description]
         * @return [type]       [description]
         */
        private function work_list($args = array())
        {
            global $infernal_flame;
            if(!is_object($infernal_flame) && !method_exists($infernal_flame, 'get_preview')) return;

            echo '<ul class="portfolio-list" data-columns="' . $args['columns'] . '" data-basewidth="' . $args['img_width'] . '" data-baseheight="' . $args['img_height'] . '" data-infinite="' . ((!$args['infinite']) ? 'off' : $args['infinite']) . '">';

            $query_args = array(
                'numberposts' => $args['limit'],
                'post_type' => 'portfolio'
            );

            global $wp_query, $post;
            $ajax = ($args['ajax'] == true) ? ' ajax' : null;

            $portfoliolist = get_posts($query_args);
            $i = 1;
            foreach($portfoliolist as $post) : setup_postdata($post); 
                $data_class = '';
                $term_list = wp_get_post_terms($post->ID, 'portfolio_category', array('fields' => 'all'));
                foreach($term_list as $term)
                    $data_class .= ' ' . $term->slug;

                echo '<li data-id="id-' . $i . '" class="preview-box ' . $ajax . $data_class . '">';
                $preview_args = array(
                    'img_url'        => false,
                    'img_width'      => $args['img_width'],
                    'img_height'     => $args['img_height'],
                    'effect'         => $args['effect'],
                    'template_hover' => 'preview-work-hover',
                    'link'           => $args['link'],
                    'lightbox'       => $args['lightbox']
                );

                echo $infernal_flame->get_preview($preview_args);
                echo '</li>';
                $i++;
            endforeach;
            echo '</ul>';
        }


        /**
         * @var $args string|array containing ids of categories to include
         */
        public function get_output($args = array())
        {
            $args = shortcode_atts(array(
                'categories' => null,
                'img_width'  => 300,
                'img_height' => 150,
                'columns'    => 3,
                'infinite'   => false, // 'click' or 'auto', everything else is false
                'filter'     => true,
                'limit'      => 3,
                'effect'     => 'default',
                'link'       => 'post',
                'ajax'       => false,
                'lightbox'   => false
            ), $args);

            ob_start();

            echo '<div class="infernal-portfolio">';

            if(is_string($args['categories'])) {
                $categories = explode(',', $categories);
                $categories = array_map('trim', $categories);
            }

            if(!is_array($args['categories']))
                $args['categories'] = null;

            if($args['filter'] == true) {
                $this->filter($args['categories']);
            }

            $this->work_list($args);

            if(isset($args['infinite']) && $args['infinite'] === 'click') {
                echo '<a href="#" class="load-infinite">' . __('Load more items.', 'inferno') . '</a>';
            }
            echo '</div>';

            $output = ob_get_contents();
            ob_end_clean();

            return $output;
        }

    }
}