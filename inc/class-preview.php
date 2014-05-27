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
      'preview'   => 'preview.php',
      'preview_flip' => 'preview-flip.php',
      'preview_fold' => 'preview-fold'
    );

    private $img_url = null;

    private $img_width = 0;

    private $img_height = 0;

    public function __construct($src = false, $width = false, $height = false, $permalink = false, $crop = true, $effect = 'default', $module = null)
    {
      if(!array_key_exists('preview' . ($effect == 'default' ? '' : '_' . $effect), $this->preview_templates)) {
        return;
      }

      if(!in_array($effect, $this->effects)) {
        $this->effects[] = $effect;
      }

      if(!in_array($module, $this->modules)) {
        $this->modules[] = $module;
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

      $thumb_arr = aq_resize($src, $width, $height, $crop, false, true);
      $thumb_url = $thumb_arr[0];
      $this->img_url = $thumb_url;
      $this->img_width = $thumb_arr[1];
      $this->img_height = $thumb_arr[2];

      ob_start();
      $this->get_inferno_template($effect, $module);
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
      $this->preview_templates = wp_parse_args( $theme_templates, $this->preview_templates );

      foreach ( $this->preview_templates as $slug => $file )
      {
        $this->preview_templates[ $slug ] = INFERNO . "/templates/$file";

        if ( isset ( $theme_templates[ $slug ] ) ) {
          $this->preview_templates[ $slug ] = $theme_templates[ $slug ];
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
          // @include is wanted here, as a missing template file at this place may be even wanted
          @include( locate_template( $this->preview_templates['preview_' . $effect] ) ); 
        } else {
          if( locate_template( $this->preview_templates['preview_' . $effect . '_' . $module] ) ) {
            include( locate_template( $this->preview_templates['preview_' . $effect . '_' . $module] ) );
          } else {
            $this->get_inferno_template($effect);
          }
        }
      }
    }

    /**
     * Only a convenient helper method.
     * @return String Image url
     */
    public function image() {
      return $this->img_url;
    }

    public function get_output()
    {
      return $this->output;
    }
  }
}