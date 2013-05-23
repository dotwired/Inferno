<?php

if(!class_exists('Inferno_Shortcodes')) {

    class Inferno_Shortcodes
    {

        public $shortcodes = array(
            // columning and structure
            'stacked',
            'one_half',
            'one_half_last',
            'one_third',
            'two_thirds',
            'one_third_last',
            'two_thirds_last',
            'one_fourth',
            'three_fourths',
            'one_fourth_last',
            'three_fourths_last',
            'one_fifth',
            'two_fifths',
            'three_fifths',
            'four_fifths',
            'one_fifth_last',
            'two_fifths_last',
            'three_fifths_last',
            'four_fifths_last',
            'one_sixth',
            'five_sixths',
            'one_sixth_last',
            'five_sixths_last',

            // content elements
            'divider',
            'circle',
            'icon',
            'button',
            'launch',
            'skillbar',
            'staff_member',

            // content element lists
            'portfolio',
            'recent_works',
            'recent_posts',

            // social
            'social_profiles'
        );

        public function __construct()
        {
            foreach($this->shortcodes as $shortcode) {
                add_shortcode($shortcode, array('Inferno_Shortcodes', $shortcode));
            }
        }



        /* ========================================================================
            Page Columning
        ======================================================================== */

        public function stacked($atts, $content = null) {
            extract(shortcode_atts(array(
                'border' => 'no'
            ), $atts));

            $borderclass = $border == 'no' ? ' noborder': null;
            return '<div class="stacked' . $borderclass . '">'.do_shortcode($content).'<div class="clear"></div></div>';
        }

        public function one_half($atts, $content = null) {
            extract(shortcode_atts(array(
                'css_class' => null
            ), $atts));
            $css_class = $css_class ? ' ' . $css_class : null;

            return '<div class="one-half' . $css_class . '">'.do_shortcode($content).'</div>';
        }

        public function one_half_last($atts, $content = null) {
            extract(shortcode_atts(array(
                'css_class' => null
            ), $atts));
            $css_class = $css_class ? ' ' . $css_class : null;

            return '<div class="one-half last' . $css_class . '' . $css_class . '">'.do_shortcode($content).'</div><div class="clear"></div>';
        }

        public function one_third($atts, $content = null) {
            extract(shortcode_atts(array(
                'css_class' => null
            ), $atts));
            $css_class = $css_class ? ' ' . $css_class : null;
            
            return '<div class="one-third' . $css_class . '">'.do_shortcode($content).'</div>';
        }

        public function two_thirds($atts, $content = null) {
            extract(shortcode_atts(array(
                'css_class' => null
            ), $atts));
            $css_class = $css_class ? ' ' . $css_class : null;
            
            return '<div class="two-thirds' . $css_class . '">'.do_shortcode($content).'</div>';
        }

        public function one_third_last($atts, $content = null) {
            extract(shortcode_atts(array(
                'css_class' => null
            ), $atts));
            $css_class = $css_class ? ' ' . $css_class : null;
            
            return '<div class="one-third last' . $css_class . '">'.do_shortcode($content).'</div><div class="clear"></div>';
        }

        public function two_thirds_last($atts, $content = null) {
            extract(shortcode_atts(array(
                'css_class' => null
            ), $atts));
            $css_class = $css_class ? ' ' . $css_class : null;
            
            return '<div class="two-thirds last' . $css_class . '">'.do_shortcode($content).'</div><div class="clear"></div>';
        }

        public function one_fourth($atts, $content = null) {
            extract(shortcode_atts(array(
                'css_class' => null
            ), $atts));
            $css_class = $css_class ? ' ' . $css_class : null;
            
            return '<div class="one-fourth' . $css_class . '">'.do_shortcode($content).'</div>';
        }

        public function three_fourths($atts, $content = null) {
            extract(shortcode_atts(array(
                'css_class' => null
            ), $atts));
            $css_class = $css_class ? ' ' . $css_class : null;
            
            return '<div class="three-fourths' . $css_class . '">'.do_shortcode($content).'</div>';
        }

        public function one_fourth_last($atts, $content = null) {
            extract(shortcode_atts(array(
                'css_class' => null
            ), $atts));
            $css_class = $css_class ? ' ' . $css_class : null;
            
            return '<div class="one-fourth last' . $css_class . '">'.do_shortcode($content).'</div><div class="clear"></div>';
        }

        public function three_fourths_last($atts, $content = null) {
            extract(shortcode_atts(array(
                'css_class' => null
            ), $atts));
            $css_class = $css_class ? ' ' . $css_class : null;
            
            return '<div class="three-fourths last' . $css_class . '">'.do_shortcode($content).'</div><div class="clear"></div>';
        }

        public function one_fifth($atts, $content = null) {
            extract(shortcode_atts(array(
                'css_class' => null
            ), $atts));
            $css_class = $css_class ? ' ' . $css_class : null;
            
            return '<div class="one-fifth' . $css_class . '">'.do_shortcode($content).'</div>';
        }

        public function two_fifths($atts, $content = null) {
            extract(shortcode_atts(array(
                'css_class' => null
            ), $atts));
            $css_class = $css_class ? ' ' . $css_class : null;
            
            return '<div class="two-fifths' . $css_class . '">'.do_shortcode($content).'</div>';
        }

        public function three_fifths($atts, $content = null) {
            extract(shortcode_atts(array(
                'css_class' => null
            ), $atts));
            $css_class = $css_class ? ' ' . $css_class : null;
            
            return '<div class="three-fifths' . $css_class . '">'.do_shortcode($content).'</div>';
        }

        public function four_fifths($atts, $content = null) {
            extract(shortcode_atts(array(
                'css_class' => null
            ), $atts));
            $css_class = $css_class ? ' ' . $css_class : null;
            
            return '<div class="four-fifths' . $css_class . '">'.do_shortcode($content).'</div>';
        }

        public function one_fifth_last($atts, $content = null) {
            extract(shortcode_atts(array(
                'css_class' => null
            ), $atts));
            $css_class = $css_class ? ' ' . $css_class : null;
            
            return '<div class="one-fifth last' . $css_class . '">'.do_shortcode($content).'</div><div class="clear"></div>';
        }

        public function two_fifths_last($atts, $content = null) {
            extract(shortcode_atts(array(
                'css_class' => null
            ), $atts));
            $css_class = $css_class ? ' ' . $css_class : null;
            
            return '<div class="two-fifths last' . $css_class . '">'.do_shortcode($content).'</div><div class="clear"></div>';
        }

        public function three_fifths_last($atts, $content = null) {
            extract(shortcode_atts(array(
                'css_class' => null
            ), $atts));
            $css_class = $css_class ? ' ' . $css_class : null;
            
            return '<div class="three-fifths last' . $css_class . '">'.do_shortcode($content).'</div><div class="clear"></div>';
        }

        public function four_fifths_last($atts, $content = null) {
            extract(shortcode_atts(array(
                'css_class' => null
            ), $atts));
            $css_class = $css_class ? ' ' . $css_class : null;
            
            return '<div class="four-fifths last' . $css_class . '">'.do_shortcode($content).'</div><div class="clear"></div>';
        }

        public function one_sixth($atts, $content = null) {
            extract(shortcode_atts(array(
                'css_class' => null
            ), $atts));
            $css_class = $css_class ? ' ' . $css_class : null;
            
            return '<div class="one-sixth' . $css_class . '">'.do_shortcode($content).'</div>';
        }

        public function five_sixths($atts, $content = null) {
            extract(shortcode_atts(array(
                'css_class' => null
            ), $atts));
            $css_class = $css_class ? ' ' . $css_class : null;
            
            return '<div class="five-sixths' . $css_class . '">'.do_shortcode($content).'</div>';
        }

        public function one_sixth_last($atts, $content = null) {
            extract(shortcode_atts(array(
                'css_class' => null
            ), $atts));
            $css_class = $css_class ? ' ' . $css_class : null;
            
            return '<div class="one-sixth last' . $css_class . '">'.do_shortcode($content).'</div>';
        }

        public function five_sixths_last($atts, $content = null) {
            extract(shortcode_atts(array(
                'css_class' => null
            ), $atts));
            $css_class = $css_class ? ' ' . $css_class : null;
            
            return '<div class="five-sixths last' . $css_class . '">'.do_shortcode($content).'</div>';
        }


        /* ========================================================================
            Content elements
        ======================================================================== */

        public function divider($atts, $content = null) {
            extract(shortcode_atts(array(
                'css_class' => null
            ), $atts));
            $css_class = $css_class ? ' ' . $css_class : null;

            return '<div class="divider' . $css_class . '">' . do_shortcode($content) . '</div>';
        }

        public function circle($atts, $content = null) {
            $width      = isset($atts['width']) ? ' style="width: ' . $atts['width'] . ';"' : null;
            $align      = isset($atts['align']) ? ' align' . $atts['align'] : null; 

            return '<div class="infernal-circle' . $align . '"' . $width . '><div class="dummy"></div><div class="radius"><div class="element">'.do_shortcode($content).'</div></div></div>';
        }

        public function icon($atts, $content = null) {
            extract(shortcode_atts(array(
                'icon'             => 'fire',
                'size'             => null,
                'color'            => null,
                'background'       => null,
                'hover_color'      => null,
                'hover_background' => null
            ), $atts));

            if($size) $size = 'font-size:' . $size . ';';
            if($color) $size = 'color:' . $color . ';';
            if($background) $background = 'background:' . $background . ';';
            if($hover_color) $hover_color = ' data-hoverColor="' . $hover_color . '"';
            if($hover_background) $hover_background = ' data-hoverBackground="' . $hover_background . '"';
            if($color || $background || $size) $style = ' style="' . $color . $background . $size . '"';

            return '<figure class="infernal-icon"' . $style . $hover_color . $hover_background . '><div class="icon-' . $icon . '"></div></figure>';
        }

        public function button($atts, $content = null) {
            extract(shortcode_atts(array(
                'width' => null,
                'align' => null,
                'color' => null,
                'url'   => '#'
            ), $atts));

            if($width) $width = ' style="width: ' . $width . ';"';
            if($align) $align = ' align' . $align;
            if($color) $color = ' ' . $color;

            return '<a href="' . $url . '" class="infernal-button' . $color . $align . '"' . $width . '>' . do_shortcode($content) . '</a>';
        }

        public function launch($atts, $content = null) {
            extract(shortcode_atts(array(
                'url' => '#'
            ), $atts));

            return '<a class="launch" href="' . $url . '">' . do_shortcode($content) . '</a>';
        }

        public function skillbar($atts, $content = null) {
            extract(shortcode_atts(array(
                'background' => null,
                'skill_background' => null,
                'skill_color' => null,
                'bar_background' => null,
                'percent' => '0%',
            ), $atts));

            if(substr($percent, -1) != '%') $percent .= '%';
            $bar_css = ' style="width:' . $percent . ';';

            if($background) $skillbar_css = ' style="background:' . $background . ';"';
            if($bar_background) $bar_css .= 'background:' . $bar_background . ';';
            if($skill_background || $skill_color) {
                $skill_css  = ' style="';
                if($skill_background) $skill_css  .= 'background:' . $skill_background . ';';
                if($skill_color) $skill_css  .= 'color:' . $skill_color . ';';
                $skill_css  .= '"';
            }
            $bar_css .= '"';

            $skillbar  = '<div class="infernal-skillbar" data-percent="' . $percent . '">';
            $skillbar .= '<div class="bar"' . $bar_css . '></div>';
            $skillbar .= '<div class="skill"><span' . $skill_css . '>' . do_shortcode($content) . '</span></div>';
            $skillbar .= '<div class="percent">' . $percent . '</div>';
            $skillbar .= '</div>';

            return $skillbar;
        }

        public function staff_member($atts, $content = null) {
            extract(shortcode_atts(array(
                'image'    => null,
                'color'    => null,
                'style'    => null,
                'name'     => null,
                'position' => null,
                'phone'    => null,

                // profiles
                'twitter'  => null,
                'facebook' => null,
                'linkedin' => null,
                //'xing'     => null,
                'gplus'    => null,
                'github'   => null,
                'email'    => null
            ), $atts));

            if(!$image || !$name) return;
            if($color == 'default') $color = null;

            ob_start();

            echo '<div class="infernal-staff-member' . ($style == 'circle' ? ' circle' : null) . '">';
            if($style == 'circle') {
                echo '<div class="profile-img infernal-circle aligncenter"><div class="dummy"></div><div class="radius"><div class="element"><img src="' . $image . '" alt="' . $name . '" /></div></div>';
            } else {
                echo '<div class="profile-img"><img src="' . $image . '" alt="' . $name . '" />';
            }
            if($twitter) echo '<a href="' . $twitter . '" class="profile-twitter' . ($color ? ' ' . $color : null) . '"><div class="icon-twitter"></div></a>';
            if($facebook) echo '<a href="' . $facebook . '" class="profile-facebook' . ($color ? ' ' . $color : null) . '"><div class="icon-facebook"></div></a>';
            if($linkedin) echo '<a href="' . $linkedin . '" class="profile-linkedin' . ($color ? ' ' . $color : null) . '"><div class="icon-linkedin"></div></a>';
            if($gplus) echo '<a href="' . $gplus . '" class="profile-gplus' . ($color ? ' ' . $color : null) . '"><div class="icon-google-plus"></div></a>';
            if($github) echo '<a href="' . $github . '" class="profile-github' . ($color ? ' ' . $color : null) . '"><div class="icon-github"></div></a>';
            if($email) echo '<a href="mailto:' . $email . '" class="profile-email' . ($color ? ' ' . $color : null) . '"><div class="icon-envelope-alt"></div></a>';
            echo '</div>';

            if($name || $position || $phone) {
                echo '<div class="about">';
                if($name) echo '<div class="name">' . $name . '</div>';
                if($position) echo '<div class="position">' . $position . '</div>';
                if($phone) {
                    echo '<div class="phone"><div class="edge"></div><div class="number"><div class="transition"></div>' . $phone . '</div><div class="icon-phone ' . $color . '"></div></div>';  
                } 
                echo '</div>';
            }

            echo '</div>';

            $output = ob_get_contents();
            ob_end_clean();
            return $output;
        }


        /* ========================================================================
            Portfolio
        ======================================================================== */

        /**
         * Displays the portfolio in an even more extended way then [recent_posts]
         * 
         * @param  [type] $atts    [description]
         * @param  [type] $content [description]
         * @return [type]          [description]
         */
        public function portfolio($atts, $content = null) {
            global $infernal_portfolio, $infernal_flame;

            if(!is_object($infernal_portfolio))
                return;

            $atts = shortcode_atts(array(
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
            ), $atts);

            if($atts['filter'] == 'yes') $atts['filter'] = true; else $atts['filter'] = false;
            if($atts['lightbox'] == 'yes') $atts['lightbox'] = true; else $atts['lightbox'] = false;
            if($atts['link'] != 'media') $atts['lightbox'] = false;
            if($atts['infinite'] != 'click' || $atts['infinite'] != 'auto') $atts['infinite'] = false;

            ob_start();
            
            echo $infernal_portfolio->get_output($atts);

            $output = ob_get_contents();
            ob_end_clean();
            return $output;
        }




        /**
         * Displays a number of portfolio works with a magnitude of options.
         * 
         * @param  [type] $atts    [description]
         * @param  [type] $content [description]
         * @return [type]          [description]
         */
        public function recent_works($atts, $content = null) {
            global $infernal_portfolio, $infernal_flame;

            if(!is_object($infernal_portfolio))
                return;
            
            ob_start();

            extract(shortcode_atts(array(
                'categories' => null,
                'width'      => 'one-third',
                'img_width'  => 300,
                'img_height' => 150,
                'limit'      => 3,
                'last'       => 3,
                'effect'     => 'default'
            ), $atts));

            $width = str_replace('_', '-', $width);

            $args = array(
                'numberposts' => $limit,
                'post_type' => 'portfolio',
                'meta_key' => '_thumbnail_id'
            );

            if($categories) {
                $args['tax_query'] = array(
                    'taxonomy' => 'portfolio_category',
                    'field' => 'slug',
                    'terms' => $categories
                );
            }

            global $post;
            $postslist = get_posts($args);
            if(count($postslist) > 0) :
                echo '<div class="inferno-recent-works">';
                $i = 1;
                foreach($postslist as $post) : setup_postdata($post); 
                    $lastclass = ($i / (int)$last == 1) ? ' last' : null;
                    $preview_args = array(
                        'src'    => false,
                        'width'  => $img_width,
                        'height' => $img_height,
                        'effect' => $effect
                    );
                    ?>
                    <div class="preview-box type-work <?php echo $width . $lastclass; ?>">
                        <?php echo inferno_preview($preview_args); ?>
                        <?php get_template_part('infernal-templates/recent-work-sub'); ?>
                    </div>
                    <?php
                    $i++;
                endforeach;
                echo '<div class="clear"></div>';
                echo '</div>';
            endif;
            
            $output = ob_get_contents();
            ob_end_clean();
            return $output;
        }




        public function recent_posts($atts, $content = null) {
            extract(shortcode_atts(array(
                'categories'                => null,
                'width'                     => 'one-third',
                'img_width'                 => 250,
                'img_height'                => 150,
                'limit'                     => 3,
                'last'                      => 3,
                'effect'                    => 'default',
                'include_without_thumbnail' => false
            ), $atts));

            $width = str_replace('_', '-', $width);

            $args = array(
                'numberposts' => $limit,
                'posts_per_page' => $limit,
                'post_type' => 'post',
                //'meta_key' => '_thumbnail_id' show posts without thumbs, too
            );

            if($include_without_thumbnail !== 'yes') $args['meta_key'] = '_thumbnail_id';

            if($categories) {
                $args['tax_query'] = array(
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => $categories
                );
            }

            global $post;
            $postslist = get_posts($args);

            ob_start();

            $i = 1;
            if(count($postslist) > 0) :
                echo '<div class="inferno-recent-posts">';
                foreach($postslist as $post) : setup_postdata($post); 
                    if($last)
                        $lastclass = (($i / (int)$last) == 1) ? ' last' : null;
                    
                        if($output) : echo $output;
                        else :
                        ?>
                        <h3><?php the_title(); ?></h3>
                        <div class="preview-box type-post <?php echo $width . $lastclass; ?>">
                            <?php echo inferno_preview(false, $img_width, $img_height, $effect, true); ?>
                            <?php get_template_part('infernal-templates/preview-post-sub'); ?>
                        </div>
                        <?php
                        endif;
                    $i++;
                endforeach;
                echo '<div class="clear"></div>';
                echo '</div>';
            endif;
            
            $output = ob_get_contents();
            ob_end_clean();
            return $output;
        }

        public function social_profiles($atts, $content = null)
        {}
    }
}