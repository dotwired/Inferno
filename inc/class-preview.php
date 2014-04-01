<?php


if(!class_exists('Inferno_Preview')) {
    class Inferno_Preview {

        private $output = null;

        private $effects = array(
            'default',
            'flip',
            'fold'
        );

        private $modules = array(
            'portfolio',
            'post'
        );

        private $template_slug_format = 'preview_{effect}_{module}';

        private $template_format = 'preview-{effect}-{module}.php';

        private $preview_templates = array(
            'preview'   => 'preview.php'
        );

        private $img_width = 0;

        private $img_height = 0;

        public function __construct($src = false, $width = false, $height = false, $permalink = false, $crop = true, $effect = 'default', $module = null)
        {
            if(!method_exists($this, 'preview_' . $effect)) {
                return;
            }

            global $post;

            if(!$width && !$height) $width = 250;

            $output = null;

            if(!$src && !has_post_thumbnail()) return false;

            $this->process_templates();

            if(!$src) {
                $thumb_id = get_post_thumbnail_id($post->ID);
                $thumb = wp_get_attachment_image_src($thumb_id, 'full');
                $src = $thumb[0];
            }

            $thumb_arr = aq_resize($src, $width, $height, true, false, true);
            $thumb_url = $thumb_arr[0];
            $this->img_width = $thumb_arr[1];
            $this->img_height = $thumb_arr[2];

            ob_start();

            if($permalink || $permalink === null) {
                if($permalink) {
                    echo '<a href="' . $permalink . '" class="inferno-preview ' . $effect . '">';
                } else {
                    echo '<a href="' . $src . '" class="inferno-preview ' . $effect . '">';
                }
            } else {
                echo '<div class="inferno-preview ' . $effect . '">';
            }


            switch($effect) {
                case 'fold':
                    $this->get_inferno_template($effect, $module);
                    $this->preview_fold($thumb_url);
                    break;
                case 'flip':
                    $this->preview_flip($thumb_url);
                    echo '<div class="back">';
                    $this->get_inferno_template($effect, $module);
                    echo '</div>';
                    break;
                default:
                    $this->get_inferno_template($effect, $module);
                    $this->preview_default($thumb_url);
                    break;
            }

            if($permalink || $permalink === null) {
                echo '</a>';
            } else {
                echo '</div>';
            }

            $output = ob_get_contents();
            $this->output = $output;
            ob_end_clean();
        }

        /**
         * Create a list of all template files. If there are files given by the theme (via add_theme_support()) overwrite the default.
         */
        private function process_templates()
        {
            // create all possible template file combinations
            foreach($this->effects as $effect) {
                $this->preview_templates['preview_' . $effect] = 'preview-' . $effect . '.php';
                foreach($this->modules as $module) {
                    $this->preview_templates['preview_' . $effect . '_' . $module] = 'preview-' . $effect . '-' . $module . '.php';
                }
            }

            $theme_templates = (array) get_theme_support( 'inferno-templates' );
            $theme_templates = $theme_templates[0];

            foreach ( $this->preview_templates as $slug => $file )
            {
                if ( isset ( $theme_templates[ $slug ] ) ) {
                    $this->preview_templates[ $slug ] = $theme_templates[ $slug ];
                } else {
                    $this->preview_templates[ $slug ] = INFERNO . "/templates/$file";
                }
            }
        }

        /**
         * Include the needed template file given on the $effect and $module. Template files are 
         * being computed by $this->process_templates().
         * Fallbacks to file without the module, if the file with the module could not be found.
         */
        private function get_inferno_template($effect = null, $module = null) {
            if(!$effect || ($effect === 'default' && !$module)) {
                include( locate_template( $this->preview_templates['preview'] ) );
            }
            else {
                if(!$module) {
                    include( locate_template( $this->preview_templates['preview_' . $effect] ) );
                } else {
                    if( locate_template( $this->preview_templates['preview_' . $effect . '_' . $module] ) ) {
                        include( locate_template( $this->preview_templates['preview_' . $effect . '_' . $module] ) );
                    } else {
                        $this->get_inferno_template($effect);
                    }
                }
            }
        }

        public function get_output()
        {
            return $this->output;
        }


        private function preview_fold($img_url)
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
            <img src="<?php echo $img_url ?>" alt="" class="fallback" width="<?php echo $this->img_width; ?>" height="<?php echo $this->img_height; ?>" />
            <?php
        }

        private function preview_flip($img_url)
        {
            ?>
            <div class="front">
                <img src="<?php echo $img_url ?>" alt="<?php the_title(); ?>" width="<?php echo $this->img_width; ?>" height="<?php echo $this->img_height; ?>" />
            </div>
            <?php
        }

        private function preview_default($img_url)
        {
            ?>
            <img src="<?php echo $img_url ?>" alt="<?php the_title(); ?>" width="<?php echo $this->img_width; ?>" height="<?php echo $this->img_height; ?>" />
            <?php
        }
    }
}