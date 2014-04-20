<?php 

if(!class_exists('Inferno_Canvas')) {

  class Inferno_Canvas {

    protected $theme_settings = array();

    protected $noncestr = 'inferno';

    protected $option_name = 'inferno';

    protected $advanced_mode = false;

    protected $brand_theme = false;

    protected $demo_mode = false;

    protected $demo_account = false;
    
    public function __construct()
    {
      global $inferno_option;
      $this->setup();

      //get options
      $inferno_option = get_option($this->option_name, array());
      $this->standarize_options(); // important. Give undefined options their default values

      // add the menu item to the wp admin menu
      add_action('admin_menu', array(&$this, 'admin_menu')); 

      // save data
      add_action('admin_init', array(&$this, 'save')); 
    }

    protected function setup()
    {
      $theme_support = get_theme_support('inferno-canvas');

      if(isset($theme_support[0]['file']) && is_string($theme_support[0]['file'])) {
        $this->theme_settings = include( locate_template( $theme_support[0]['file'] ) );
      }
      if(isset($theme_support[0]['backup']) && $theme_support[0]['backup'] === true) { 
        $this->theme_settings[] = include( dirname( __FILE__ ) . '/backup.php' );
      }
      if(isset($theme_support[0]['advanced_mode']) && $theme_support[0]['advanced_mode'] === true) {
        $this->advanced_mode = true;
      }
      if(isset($theme_support[0]['brand_theme']) && $theme_support[0]['brand_theme'] === true) {
        $this->brand_theme = true;
      }
    }

    public function admin_menu()
    {
      return $hook = add_theme_page(
        'Theme Options',
        'Theme Options',
        'edit_theme_options',
        'inferno-admin',
        array(&$this, 'canvas')
      );
    }

    private function check_nonce()
    {
      $nonce = $_POST['_wpnonce'];
      if(!wp_verify_nonce($nonce, $this->noncestr)) die(__("Security check failed.", 'inferno'));
    }

    /**
     * TODO
     * @return [type] [description]
     */
    private function error()
    {

    }

    /**
     * Perform the saving from the received panel data.
     * @version 1.0
     * @since 1.0
     */
    public function save()
    {
      global $inferno_option;

      // if there are some actions with the theme optionspage
      if(isset($_POST['inferno_action'])) {
        // check wp nonce
        $this->check_nonce();

        // save action
        if($_POST['inferno_action'] == 'save') {
          foreach($this->theme_settings as $topic ) {
            foreach($topic['fields'] as $field) {
              if(isset($_POST[$field['id']]) && $field['type'] != 'transfer') {
                $inferno_option[$field['id']] = $_POST[$field['id']];

                // if this is google font
                if(isset($_POST[$field['id'] . '_googlefont']) && !empty($_POST[$field['id'].'_googlefont'])) {
                  $inferno_option[$field['id']] = trim(stripslashes($_POST[$field['id'].'_googlefont']));
                }

              } else {
                unset($inferno_option[$field['id']]);
              }
            }
          }

          update_option($this->option_name, $inferno_option);

        } elseif($_POST['inferno_action'] == 'reset' && get_option($this->option_name)) {
          delete_option($this->option_name);
        } elseif($_POST['inferno_action'] == 'import') {
          update_option($this->option_name, unserialize(base64_decode($_POST['transfer'])));
        }

        if(stristr($_SERVER['REQUEST_URI'], '&settings-updated=true')) {
          $location = $_SERVER['REQUEST_URI'];
        } else {
          $location = $_SERVER['REQUEST_URI'] . "&settings-updated=true";
        }

        header("Location: $location");
      }
    }

    public function save_file($option)
    {
      global $inferno_option;

      // if there is a file to upload.
      if(isset($_FILES[$option['id'].'_file'] ) && !empty($_FILES[$option['id'].'_file']['name'] )) {
        $tmp_name = $_FILES[$option['id'].'_file']['tmp_name'];
        $name = $_FILES[$option['id'].'_file']['name'];

        $attachment = wp_upload_bits( $name, null, file_get_contents( $tmp_name ), date( "Y-m" ) );
        if ($attachment['error'] == false ) {
          $inferno_option[$option['id']] = $attachment['url'];
          update_option($this->option_name, $inferno_option);
        } else {
          $msg = $attachment['error'];
        }
      }
    }

    /**
     * check $inferno_option for not available options and make them default
     * @return void
     */
    protected function standarize_options() {
      global $inferno_option;
      
      if(!is_array($this->theme_settings) || empty($this->theme_settings)) return false;

      foreach($this->theme_settings as $topic) {
        foreach($topic['fields'] as $field) {
          if(isset($field['id']) && !isset($inferno_option[$field['id']])) {
            if(isset($field['std'])) {
              $inferno_option[$field['id']] = $field['std'];
            } else {
              $inferno_option[$field['id']] = null;
            }
          }
        }
      }
    }

    public function canvas() 
    {
      echo '<div class="wrap">';
      require_once('canvas.php'); 
      echo '</div>';
    }

    /**
     * panel navigation
     * @return void
     */
    protected function menu() 
    { 
      if( !isset( $this->theme_settings ) || !is_array( $this->theme_settings ) || empty( $this->theme_settings ) ) return false;

      $i = 1; foreach( $this->theme_settings as $topic ) : ?>
      <li><?php echo '<a href="#tab-' . $i . '" id="tablink-' . $i . '"><i class="fa fa-' . $topic[ 'icon' ] . '"></i><span>' . $topic[ 'title' ] . '</span></a>'; ?></li>
      <?php $i++; endforeach;
    }

    protected function tabs()
    {
      global $inferno_option;

      if( isset( $this->theme_settings ) && is_array( $this->theme_settings ) && !empty( $this->theme_settings ) ) {
        $count = 1;
        foreach( $this->theme_settings as $topic ) : ?>
          <!-- BEGIN .tab-content -->
          <div id="tab-<?php echo $count; ?>" class="tab-content">
            <?php 
            foreach( $topic[ 'fields' ] as $field ) {
              $option = new Inferno_Options_Machine( $field, (isset($inferno_option[ $field[ 'id' ] ]) ? $inferno_option[ $field[ 'id' ] ] : false) );
            }
            ?>
          <!-- END .tab-content -->
          </div>
          <?php $count++;
        endforeach;
      }
    }
  }
}
