<?php

/**
 * Is the static way really the better way... ?
 */
if(!class_exists('Inferno_Portfolio')) {

    class Inferno_Portfolio {

        // some default settings
        public $settings = array(
            'hover_effect' => 'fold'
        );

        public static $portfolio_count = 1;

        function __construct()
        {
            add_action('init', array(&$this, 'init'), 1);
            add_action('wp_enqueue_scripts', array(&$this, 'enqueue'));
        }

        public function enqueue()
        {
            wp_enqueue_script('jquery-imagesloaded');
            wp_enqueue_script('jquery-easing');
            wp_enqueue_script('animate-scale');
            wp_enqueue_script('css-transform');
            wp_enqueue_script('jquery-isotope');

            wp_enqueue_style('inferno-portfolio');
            wp_enqueue_style('css3d');
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

        /**
         * The image filter
         */
        private static function filter($categories = array())
        {
            $portfolio_categories = get_terms( 'portfolio_category' );
            $count = count( $portfolio_categories );

            if($count == 0) return;

            echo '<ul class="portfolio-filter">';
            echo '<li><a href="#" data-filter="*">' . __('Show all', 'inferno') . '</a></li>';
            foreach( $portfolio_categories as $term ) {
                echo '<li><a href="#" data-filter=".' . $term->slug . '">' . $term->name . '</a></li>';
            }
            echo '</ul>';
            echo '<div class="clear"></div>';
        }

        /**
         * print the filter for the portfolio
         * 
         * @param  array  $args [description]
         * @return [type]       [description]
         */
        private static function worklist($atts = array())
        {
            $atts = shortcode_atts(array(
                'categories' => null,
                'filter'     => true,
                'img_width'  => 300,
                'img_height' => 150,
                'limit'      => false,
                'effect'     => 'default',
                'link'       => 'post',
                'lightbox'   => true
            ), $atts );


            $portfolio_query = new WP_Query(array(
                'post_type' => 'portfolio',
                'numberposts' => $atts['limit']
            ));

            if($portfolio_query->have_posts()) {
                echo '<div class="portfolio-list">';
                $i = 1;

                while($portfolio_query->have_posts()) {
                    $portfolio_query->the_post();
                    $data_class = '';
                    $terms = wp_get_post_terms(get_the_ID(), 'portfolio_category', array('fields' => 'all'));
                    foreach($terms as $term) $data_class .= $term->slug . ' ';

                    echo '<div data-id="' . $i . '" class="preview-box ' . $data_class . '">';
                    $preview = new Inferno_preview(false, $atts['img_width'], $atts['img_height'], $atts['effect'], $atts['link']);
                    echo $preview->get_output();
                    echo '</div>';
                    $i++;
                }

                echo '</div>';
            }

            wp_reset_postdata();
        }


        /**
         * @var $args string|array containing ids of categories to include
         */
        public static function get_output($atts = array())
        {
            $atts = shortcode_atts(array(
                'categories' => null,
                'filter'     => true,
                'limit'      => false,
                'effect'     => 'default',
                'link'       => 'post',
                'lightbox'   => true
            ), $atts );

            ob_start();

            echo '<div id="inferno-portfolio-' . self::$portfolio_count . '" class="inferno-portfolio">';

            if(is_string($atts['categories'])) {
                $categories = explode(',', $categories);
                $categories = array_map('trim', $categories);
            }

            if(!is_array($atts['categories'])) {
                $atts['categories'] = null;
            }

            if($atts['filter'] == true) self::filter($atts['categories']);

            self::worklist($atts);
            // self::javascript(); TODO at some time let create INFERNO the js
            echo '</div>';

            $output = ob_get_contents();
            ob_end_clean();

            return $output;
        }


        public static function javascript() {
            require_once('embedded-js.php');
        }
    }
}