<?php

if(!class_exists( 'Inferno_Shortcodes' ) ) {

  class Inferno_Shortcodes
  {

    private $shortcodes = array(
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
      'pricing_box',
      'pricing_row',
      'pricing_price',

      // content element lists
      'portfolio',
      'recent_works',
      'recent_posts',

      // social
      'social_profiles',
      'counter_twitter',
      'counter_facebook',
      'counter_gplus'
    );

    private $table_widths = array(
      '1/2' => 'one-half',
      '1/3' => 'one-third',
      '1/4' => 'one-fourth',
      '1/5' => 'one-fifth',
      '1/6' => 'one-sixth',
      '2/3' => 'two-thirds',
      '2/5' => 'two-fifths',
      '3/4' => 'three-fourths',
      '5/6' => 'five-sixths'
    );

    private $shortcode_templates = array(
      'skillbar' => 'skillbar.php',
      'staff_member' => 'staff-member.php',
      'recent_works' => 'recent-works.php',
      'recent_posts' => 'recent-posts.php'
    );

    public function __construct()
    {
      foreach( $this->shortcodes as $shortcode ) {
        add_shortcode( $shortcode, array( &$this, $shortcode ) );
      }

      $theme_templates = (array) get_theme_support( 'inferno-templates' );
      $theme_templates = $theme_templates[0];

      foreach ( $this->shortcode_templates as $shortcode => $file )
      {
        if ( isset ( $theme_templates[ $shortcode ] ) ) {
          $this->shortcode_templates[ $shortcode ] = $theme_templates[ $shortcode ];
        } else {
          $this->shortcode_templates[ $shortcode ] = INFERNO_PATH . "templates/$file";
        }
      }
    }



    /* ========================================================================
      Page Columning
    ======================================================================== */

    public function stacked( $atts, $content = null ){
      $atts = shortcode_atts( array(
        'border' => false,
        'css_class' => null
      ), $atts, 'stacked' );
      $atts['border'] = filter_var( $atts['border'], FILTER_VALIDATE_BOOLEAN );
      $borderclass = $atts['border'] === false ? ' noborder' : null;
      return '<div class="stacked '. $atts['css_class'] . $borderclass . '">'.do_shortcode( $content ).'<div class="clear"></div></div>';
    }

    public function one_half( $atts, $content = null ){
      $atts = shortcode_atts( array(
        'css_class' => null
      ), $atts, 'one_half' );

      return '<div class="one-half ' . $atts['css_class'] . '">'.do_shortcode( $content ).'</div>';
    }

    public function one_half_last( $atts, $content = null ){
      $atts = shortcode_atts( array(
        'css_class' => null
      ), $atts, 'one_half_last' );

      return '<div class="one-half last ' . $atts['css_class'] . '">'.do_shortcode( $content ).'</div><div class="clear"></div>';
    }

    public function one_third( $atts, $content = null ){
      $atts = shortcode_atts( array(
        'css_class' => null
      ), $atts, 'one_third' );
      
      return '<div class="one-third ' . $atts['css_class'] . '">'.do_shortcode( $content ).'</div>';
    }

    public function two_thirds( $atts, $content = null ){
      $atts = shortcode_atts( array(
        'css_class' => null
      ), $atts, 'two_thirds' );
      
      return '<div class="two-thirds ' . $atts['css_class'] . '">'.do_shortcode( $content ).'</div>';
    }

    public function one_third_last( $atts, $content = null ){
      $atts = shortcode_atts( array(
        'css_class' => null
      ), $atts, 'one_third_last' );
      
      return '<div class="one-third last ' . $atts['css_class'] . '">'.do_shortcode( $content ).'</div><div class="clear"></div>';
    }

    public function two_thirds_last( $atts, $content = null ){
      $atts = shortcode_atts( array(
        'css_class' => null
      ), $atts, 'two_thirds_last' );
      
      return '<div class="two-thirds last ' . $atts['css_class'] . '">'.do_shortcode( $content ).'</div><div class="clear"></div>';
    }

    public function one_fourth( $atts, $content = null ){
      $atts = shortcode_atts( array(
        'css_class' => null
      ), $atts, 'one_fourth' );
      
      return '<div class="one-fourth ' . $atts['css_class'] . '">'.do_shortcode( $content ).'</div>';
    }

    public function three_fourths( $atts, $content = null ){
      $atts = shortcode_atts( array(
        'css_class' => null
      ), $atts, 'three_fourths' );
      
      return '<div class="three-fourths ' . $atts['css_class'] . '">'.do_shortcode( $content ).'</div>';
    }

    public function one_fourth_last( $atts, $content = null ){
      $atts = shortcode_atts( array(
        'css_class' => null
      ), $atts, 'one_fourth_last' );
      
      return '<div class="one-fourth last ' . $atts['css_class'] . '">'.do_shortcode( $content ).'</div><div class="clear"></div>';
    }

    public function three_fourths_last( $atts, $content = null ){
      $atts = shortcode_atts( array(
        'css_class' => null
      ), $atts, 'three_fourths_last' );
      
      return '<div class="three-fourths last ' . $atts['css_class'] . '">'.do_shortcode( $content ).'</div><div class="clear"></div>';
    }

    public function one_fifth( $atts, $content = null ){
      $atts = shortcode_atts( array(
        'css_class' => null
      ), $atts, 'one_fifth' );
      
      return '<div class="one-fifth ' . $atts['css_class'] . '">'.do_shortcode( $content ).'</div>';
    }

    public function two_fifths( $atts, $content = null ){
      $atts = shortcode_atts( array(
        'css_class' => null
      ), $atts, 'two_fifths' );
      
      return '<div class="two-fifths ' . $atts['css_class'] . '">'.do_shortcode( $content ).'</div>';
    }

    public function three_fifths( $atts, $content = null ){
      $atts = shortcode_atts( array(
        'css_class' => null
      ), $atts, 'three_fifths' );
      
      return '<div class="three-fifths ' . $atts['css_class'] . '">'.do_shortcode( $content ).'</div>';
    }

    public function four_fifths( $atts, $content = null ){
      $atts = shortcode_atts( array(
        'css_class' => null
      ), $atts, 'four_fifths' );
      
      return '<div class="four-fifths ' . $atts['css_class'] . '">'.do_shortcode( $content ).'</div>';
    }

    public function one_fifth_last( $atts, $content = null ){
      $atts = shortcode_atts( array(
        'css_class' => null
      ), $atts, 'one_fifth_last' );
      
      return '<div class="one-fifth last ' . $atts['css_class'] . '">'.do_shortcode( $content ).'</div><div class="clear"></div>';
    }

    public function two_fifths_last( $atts, $content = null ){
      $atts = shortcode_atts( array(
        'css_class' => null
      ), $atts, 'two_fifths_last' );
      
      return '<div class="two-fifths last ' . $atts['css_class'] . '">'.do_shortcode( $content ).'</div><div class="clear"></div>';
    }

    public function three_fifths_last( $atts, $content = null ){
      $atts = shortcode_atts( array(
        'css_class' => null
      ), $atts, 'three_fifths_last' );
      
      return '<div class="three-fifths last ' . $atts['css_class'] . '">'.do_shortcode( $content ).'</div><div class="clear"></div>';
    }

    public function four_fifths_last( $atts, $content = null ){
      $atts = shortcode_atts( array(
        'css_class' => null
      ), $atts, 'four_fifths_last' );
      
      return '<div class="four-fifths last ' . $atts['css_class'] . '">'.do_shortcode( $content ).'</div><div class="clear"></div>';
    }

    public function one_sixth( $atts, $content = null ){
      $atts = shortcode_atts( array(
        'css_class' => null
      ), $atts, 'one_sixth' );
      
      return '<div class="one-sixth ' . $atts['css_class'] . '">'.do_shortcode( $content ).'</div>';
    }

    public function five_sixths( $atts, $content = null ){
      $atts = shortcode_atts( array(
        'css_class' => null
      ), $atts, 'five_sixths' );
      
      return '<div class="five-sixths ' . $atts['css_class'] . '">'.do_shortcode( $content ).'</div>';
    }

    public function one_sixth_last( $atts, $content = null ) 
    {
      $atts = shortcode_atts( array(
        'css_class' => null
      ), $atts, 'one_sixth_last' );
      
      return '<div class="one-sixth last ' . $atts['css_class'] . '">'.do_shortcode( $content ).'</div>';
    }

    public function five_sixths_last( $atts, $content = null ) 
    {
      $atts = shortcode_atts( array(
        'css_class' => null
      ), $atts, 'five_sixths_last' );
      
      return '<div class="five-sixths last ' . $atts['css_class'] . '">'.do_shortcode( $content ).'</div>';
    }


    /* ========================================================================
      Content elements
    ======================================================================== */

    public function divider( $atts ) 
    {
      $atts = shortcode_atts( array(
        'css_class' => null
      ), $atts, 'divider' );

      return '<div class="divider ' . $atts['css_class'] . '"></div>';
    }

    public function circle( $atts, $content = null ) 
    {
      $atts = shortcode_atts( array(
        'width' => null,
        'align' => null,
        'css_class' => null
      ), $atts, 'circle' );

      $width = isset( $atts[ 'width' ] ) ? ' style="width: ' . $atts[ 'width' ] . ';"' : null;
      $align = isset( $atts[ 'align' ] ) && $atts[ 'align' ] != 'no' ? ' align' . $atts[ 'align' ] : null; 

      return '<div class="inferno-circle' . $align . $atts['css_class'] . '"' . $width . '><div class="dummy"></div><div class="radius"><div class="element">'.do_shortcode( $content ).'</div></div></div>';
    }

    public function icon( $atts ) 
    {
      $atts = shortcode_atts( array(
        'icon'             => 'fire',
        'size'             => null,
        'color'            => null,
        'background'       => null,
        'hover_color'      => null,
        'hover_background' => null,
        'css_class'        => null
      ), $atts, 'icon' );

      if( $atts['size'] ) $size = 'font-size:' . $atts['size'] . ';';
      if( $atts['color'] ) $color = 'color:' . $atts['color'] . ';';
      if( $atts['background'] ) $background = 'background:' . $atts['background'] . ';';
      if( $atts['hover_color'] ) $hover_color = ' data-hoverColor="' . $atts['hover_color'] . '"';
      if( $atts['hover_background'] ) $hover_background = ' data-hoverBackground="' . $atts['hover_background'] . '"';
      if( $color || $background || $size ) $style = ' style="' . $color . $background . $size . '"';

      return '<figure class="inferno-icon ' . $atts['css_class'] . '"' . $style . $hover_color . $hover_background . '><div class="fa-' . $icon . '"></div></figure>';
    }

    public function button( $atts, $content = null ) 
    {
      $atts = shortcode_atts( array(
        'width'     => null,
        'align'     => null,
        'color'     => null,
        'url'       => '#',
        'css_class' => null
      ), $atts, 'button' );

      if( $atts['width'] ) $atts['width'] = ' style="width: ' . $atts['width'] . ';"';
      if( $atts['align'] ) $atts['align'] = ' align' . $atts['align'];
      if( $atts['color'] ) $atts['color'] = ' ' . $atts['color'];

      return '<a href="' . $atts['url'] . '" class="inferno-button ' . $atts['css_class'] . $atts['color'] . $atts['align'] . '"' . $atts['width'] . '>' . do_shortcode( $content ) . '</a>';
    }

    public function launch( $atts, $content = null ) 
    {
      $atts = shortcode_atts( array(
        'url' => '#',
        'css_class' => null
      ), $atts, 'launch' );

      return '<a class="launch ' . $atts['css_class'] . '" href="' . $atts['url'] . '">' . do_shortcode( $content ) . '</a>';
    }

    public function skillbar( $atts, $content = null ) 
    {
      $atts = shortcode_atts( array(
        'background' => null,
        'skill_background' => null,
        'skill_color' => null,
        'bar_background' => null,
        'percent' => '0%',
      ), $atts, 'skillbar' );

      if(substr( $atts['percent'], -1) != '%' ) $atts['percent'] .= '%';
      $bar_css = ' style="width:' . $atts['percent'] . ';';

      if( $atts['background'] ) $skillbar_css = ' style="background:' . $atts['background'] . ';"';
      if( $atts['bar_background'] ) $bar_css .= 'background:' . $atts['bar_background'] . ';';
      if( $atts['skill_background'] || $atts['skill_color'] ) {
        $skill_css  = ' style="';
        if( $atts['skill_background'] ) $skill_css  .= 'background:' . $atts['skill_background'] . ';';
        if( $atts['skill_color'] ) $skill_css  .= 'color:' . $atts['skill_color'] . ';';
        $skill_css  .= '"';
      }
      $bar_css .= '"';

      $skillbar  = '<div class="inferno-skillbar"' . $skillbar_css . ' data-percent="' . $atts['percent'] . '">';
      $skillbar .= '<div class="bar"' . $bar_css . '></div>';
      $skillbar .= '<div class="skill"><span' . $skill_css . '>' . do_shortcode( $content ) . '</span></div>';
      $skillbar .= '<div class="percent">' . $atts['percent'] . '</div>';
      $skillbar .= '</div>';

      return $skillbar;
    }

    public function staff_member( $atts, $content = null ) 
    {
      $atts = shortcode_atts( array(
        'image'    => null,
        'color'    => null,
        'style'    => null,
        'name'     => null,
        'position' => null,
        'phone'    => null,

        // profiles, comma separated list of font awesome icons / slugs
        'profiles' => null 
      ), $atts, 'staff_member' );

      if(!$atts['image'] || !$atts['name']) return;
      if( $atts['color'] == 'default' ) $color = null;

      ob_start();

      echo '<div class="inferno-staff-member' . ( $atts['style'] == 'circle' ? ' circle' : null ) . '">';
      if( $atts['style'] == 'circle' ) {
        echo '<div class="profile-img inferno-circle aligncenter"><div class="dummy"></div><div class="radius"><div class="element"><img src="' . $image . '" alt="' . $atts['name'] . '" /></div></div>';
      } else {
        echo '<div class="profile-img"><img src="' . $image . '" alt="' . $atts['name'] . '" />';
      }

      $profiles = implode(',', $atts['profiles']);
      foreach($profiles as $profile) {
        echo '<a href="' . $profile . '" class="profile-profile' . ( $color ? ' ' . $color : null ) . '"><div class="fa-' . $profile . '"></div></a>';
      }
      echo '</div>';

      echo '<div class="about">';
      echo '<div class="name">' . $atts['name'] . '</div>';
      if( $atts['position'] ) echo '<div class="position">' . $atts['position'] . '</div>';
      if( $atts['phone'] ) {
        echo '<div class="phone"><div class="edge"></div><div class="number"><div class="transition"></div>' . $atts['phone'] . '</div><div class="fa-phone ' . $color . '"></div></div>';  
      } 
      echo '</div>';

      echo '</div>';

      $output = ob_get_contents();
      ob_end_clean();
      return $output;
    }

    public function pricing_box( $atts, $content = null ) 
    {
      $atts = shortcode_atts( array(
        'featured'       => null,
        'featured_label' => null,
        'border'         => false,
        'color'          => null // TODO
      ), $atts, 'pricing_box' );

      $atts['featured'] = filter_var( $atts['featured'], FILTER_VALIDATE_BOOLEAN );
      $atts['border'] = filter_var( $atts['border'], FILTER_VALIDATE_BOOLEAN );

      $featured_class = $color_class = $border_class = null;
      if($atts['featured']) $featured_class = ' featured';
      if($atts['color']) $color_class = ' ' . $atts['color'];
      if($atts['border']) $border_class = ' bordered';

      $data_featured = null;
      if($atts['featured'] && $atts['featured_label']) $data_featured = ' data-featured="' . $atts['featured_label'] . '"';
      echo $atts['featured_label'];
      $output = '<table' . $data_featured . ' class="pricing-box' . $featured_class . $color_class . $border_class . '">';

      add_shortcode( 'row', array( $this, 'pricing_row' ) ); // switch shortcode handlers
      $output .= do_shortcode( $content ) . '</table>';

      return $output;
    }

    public function pricing_price( $atts, $content = null ) 
    {
      $atts = shortcode_atts( array(
        'width' => false,
        'colspan' => false,
        'currency' => "$",
        'info'     => null, // TODO maybe find a better attr name?
      ), $atts, 'price' );

      $class = null;
      if($atts['width'] && array_key_exists($atts['width'], $this->table_widths)) {
        $class = ' ' . $this->table_widths[$atts['width']];
      }

      $colspan = null;
      $atts['colspan'] = filter_var( $atts['colspan'], FILTER_VALIDATE_INT );

      if($atts['colspan'] > 1) $colspan = ' colspan="' . $atts['colspan'] . '"';

      if(strpos($content, '.') !== false) {
        $price = explode(".", $content);
      } else if(strpos($content, ',') !== false) {
        $price = explode(",", $content);
      } else {
        $price = array(
          $content,
          '00'
        );
      }

      $output = '<td class="price' . $class . '"' . $colspan . '><span class="currency">' . $atts['currency'] . '</span>' . $price[0] . '<span class="decimal">' . $price[1] . '</span>';
      if(!empty($atts['info'])) {
        $output .= '<br /><span class="info">' . $atts['info'] . '</span>';
      }
      $output .= '</td>';

      return $output;
    }

    public function pricing_row( $atts, $content = null ) 
    {
      add_shortcode( 'price', array( $this, 'pricing_price' ) ); // switch shortcode handlers
      add_shortcode( 'cell', array( $this, 'pricing_cell' ) ); // switch shortcode handlers
      return '<tr>' . do_shortcode( $content ) . '</tr>';
    }

    public function pricing_cell( $atts, $content = null ) 
    {
      $atts = shortcode_atts( array(
        'heading'  => false,
        'colspan'  => false,
        'scheme'   => false,
        'width'    => null
      ), $atts, 'cell' );

      $colspan = $class = null;
      $atts['heading'] = filter_var( $atts['heading'], FILTER_VALIDATE_BOOLEAN );
      $atts['colspan'] = filter_var( $atts['colspan'], FILTER_VALIDATE_INT );
      if($atts['colspan'] > 1) $colspan = ' colspan="' . $atts['colspan'] . '"';
      if($atts['scheme']) $class = ' class="dark"';
      if($atts['width'] && array_key_exists($atts['width'], $this->table_widths)) {
        if(!empty($class)) {
          $class = ' class="dark ' . $this->table_widths[$atts['width']] . '"';
        } else {
          $class = ' class="' . $this->table_widths[$atts['width']] . '"';
        }
      }

      $table_element = 'td';
      if($atts['heading']) $table_element = 'th';
      return '<' . $table_element . $class . $colspan . '>' . do_shortcode( $content ) . '</' . $table_element . '>';
    }


    /* ========================================================================
      Portfolio
    ======================================================================== */

    /**
     * Displays the portfolio in an even more extended way then [recent_posts]
     * TODO: support infinite loading / scrolling
     * TODO: make this shortcode code + portfolio class much better
     * 
     * @param  [type] $atts    [description]
     * @param  [type] $content [description]
     * @return [type]          [description]
     */
    public function portfolio( $atts, $content = null ) {
      if(!class_exists('Inferno_Portfolio')) {
        // TODO: Implement a notice / alert system for the admin or check out if there is a WP native one
        return;
      }

      $atts = shortcode_atts(array(
        'categories' => null,
        'filter'     => true,
        'img_width'  => 300,
        'img_height' => 150,
        'limit'      => false,
        'effect'     => 'default',
        'link'       => 'post',
        'lightbox'   => true,
        'paginate'   => false
      ), $atts, 'portfolio' );

      $atts['filter'] = filter_var( $atts['filter'], FILTER_VALIDATE_BOOLEAN );
      $atts['lightbox'] = filter_var( $atts['lightbox'], FILTER_VALIDATE_BOOLEAN );
      $atts['paginate'] = filter_var( $atts['paginate'], FILTER_VALIDATE_BOOLEAN );
      if( $atts[ 'link' ] != 'media' ) $atts[ 'lightbox' ] = false;

      ob_start();
      
      $portfolio = new Inferno_Portfolio($atts);
      echo $portfolio->get_output();

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
    public function recent_works( $atts, $content = null ) 
    {
      // TODO
      if(!is_object( $inferno_portfolio ) )
        return;
      
      ob_start();

      extract( shortcode_atts( array(
        'categories' => null,
        'width'      => 'one-third',
        'img_width'  => 300,
        'img_height' => 150,
        'limit'      => 3,
        'last'       => 3,
        'effect'     => 'default'
      ), $atts ) );

      $width = str_replace( '_', '-', $width);

      $args = array(
        'numberposts' => $limit,
        'post_type' => 'portfolio',
        'meta_key' => '_thumbnail_id'
      );

      if( $categories ) {
        $args[ 'tax_query' ] = array(
          'taxonomy' => 'portfolio_category',
          'field' => 'slug',
          'terms' => $categories
        );
      }

      global $post;
      $postslist = get_posts( $args );
      if(count( $postslist) > 0) :
        echo '<div class="inferno-recent-works">';
        $i = 1;
        foreach( $postslist as $post) : setup_postdata( $post); 
          $lastclass = ( $i / (int)$last == 1) ? ' last' : null;
          $preview_args = array(
            'src'    => false,
            'width'  => $img_width,
            'height' => $img_height,
            'effect' => $effect
          );
          require( $this->shortcode_templates[ 'recent_posts' ] );
          $i++;
        endforeach;
        echo '<div class="clear"></div>';
        echo '</div>';
      endif;
      
      $output = ob_get_contents();
      ob_end_clean();
      return $output;
    }




    public function recent_posts( $atts, $content = null ) 
    {
      extract( shortcode_atts( array(
        'categories'                => null,
        'width'                     => 'one-third',
        'img_width'                 => 250,
        'img_height'                => 150,
        'limit'                     => 3,
        'last'                      => 3,
        'effect'                    => 'default',
        'include_without_thumbnail' => false
      ), $atts ) );

      $width = str_replace( '_', '-', $width);

      $args = array(
        'numberposts'    => $limit,
        'posts_per_page' => $limit,
        'post_type'      => 'post',
        //'meta_key'     => '_thumbnail_id' show posts without thumbs, too
      );
 
      if( $include_without_thumbnail !== 'yes' ) $args[ 'meta_key' ] = '_thumbnail_id';

      if($categories) {
        $args['tax_query'] = array(array(
          'taxonomy' => 'category',
          'field' => 'id',
          'terms' => explode(',', $categories)
        ));
      }

      global $post;
      $postslist = get_posts( $args );

      ob_start();

      $i = 1;
      if(count( $postslist ) > 0 ) :
        echo '<div class="inferno-recent-posts">';
        foreach( $postslist as $post ) : setup_postdata( $post );
          if( $last ) $lastclass = ( ( $i / (int) $last ) == 1 ) ? ' last' : null;
            include(locate_template( $this->shortcode_templates[ 'recent_posts' ] ) );
          $i++;
        endforeach;
        echo '<div class="clear"></div>';
        echo '</div>';
      endif;
      
      $output = ob_get_contents();
      ob_end_clean();
      return $output;
    }

    // todo
    public function social_profiles( $atts, $content = null ) {}

    
    public function counter_twitter( $atts, $content = null ) 
    {
      extract( shortcode_atts( array(
        'username' => null,
      ), $atts ) );

      if( !$username ) return;

      return inferno_get_twitter_count( $username );
    }

    public function counter_facebook( $atts, $content = null ) 
    {
      extract( shortcode_atts( array(
        'id' => null,
      ), $atts ) );

      if( !$id ) return;

      return inferno_get_facebook_count( $id );
    }

    public function counter_gplus( $atts, $content = null ) 
    {
      extract( shortcode_atts( array(
        'id' => null,
        'host' => null
      ), $atts ) );

      if( !$id || !$host || !function_exists('curl_version')) return;

      $count = get_transient('gplus_count');
      if ($count !== false) return $count;
      
      $count = 0;
      $data = file_get_contents('http://widgetsplus.com/google_plus_widget.php?pid=' . $id . '&host=');
       
      if (is_wp_error($data)) {
        return 'Google+ fan count could not be loaded.';
      } else { 
        $match = preg_match('/<strong>(.*?)<\/strong>/s', $data, $results); 
        if ( isset ( $results ) && !empty ( $results ) ) $count = $results[1];
      }
      set_transient('gplus_count', $count, 60*60*48); // 72 hour cache
      return $count;
    }
  }
}