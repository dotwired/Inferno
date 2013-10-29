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
            wp_enqueue_script('inferno-portfolio');

            wp_enqueue_style('inferno-portfolio');
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
        private static function work_list($args = array())
        {
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

                $preview = new Inferno_Preview(false, $args['img_width'], $args['img_height'], $args['effect'], $args['link']);
                echo $preview->get_output();
                echo '</li>';
                $i++;
            endforeach;
            echo '</ul>';
        }


        /**
         * @var $args string|array containing ids of categories to include
         */
        public static function get_output($args = array())
        {
            $args = shortcode_atts(array(
                'categories' => null,
                'img_width'  => 300,
                'img_height' => 150,
                'columns'    => 3,
                'filter'     => true,
                'limit'      => 3,
                'effect'     => 'default',
                'link'       => 'post',
                'ajax'       => false,
                'lightbox'   => false
            ), $args);

            ob_start();

            echo '<div class="inferno-portfolio">';

            if(is_string($args['categories'])) {
                $categories = explode(',', $categories);
                $categories = array_map('trim', $categories);
            }

            if(!is_array($args['categories']))
                $args['categories'] = null;

            if($args['filter'] == true) self::filter($args['categories']);

            self::work_list($args);

            echo '</div>';

            $output = ob_get_contents();
            ob_end_clean();

            return $output;
        }

    }
}