<?php
/**
 * This is the InfernalPanel loader class.
 *
 * @package   IPPanel
 * @author    Maxim Zubarev
 */
if(!class_exists('Infernal_Metabox')) {

    /**
     * Loader class for the IP Panel.
     */
    class Infernal_Metabox extends Inferno {


        private $_noncestr = 'infernal-metabox';

        public $admin_enqueue_scripts = array(
            'media-upload',
            'thickbox',
            'jquery-colorpicker',
            'infernal-panel'
        );

        public $admin_enqueue_styles = array(
            'thickbox',
            'panel-colorpicker'
        );

        public $metabox = array();

        private $_postmeta = array();

        private $_meta = array();

        private $_count = array(
            'colorpicker' => 1
        );

        /**
         * constructor calls some initial methods.
         * @param array $config array for overwriting $this->_config
         */
        public function __construct() {
            add_action('init', array(&$this, 'assets')); // instead of $this->assets();

            add_action('add_meta_boxes', array(&$this, 'add_metabox'));
            add_action('save_post', array(&$this, 'save'));
            add_action('edit_attachment', array(&$this, 'save'));
            #add_action('admin_menu', array(&$this, 'admin_menu'));
        }

        public function add_metabox()
        {   
            $all = false;
            $post_types_have_meta = array();

            foreach($this->metabox as $meta) {
                if($meta['post_type'] != 'all') {
                    foreach($meta['post_type'] as $post_type) {
                        if(!in_array($post_type, $post_types_have_meta))
                            $post_types_have_meta[] = $post_type;
                    } 
                } else {
                    $all = true;
                }
            }

            if(empty($this->metabox))
                return;

            if($all) $post_types = get_post_types(array('public' => true), 'names');
            else $post_types = $post_types_have_meta;


            foreach($post_types as $post_type) {
                add_meta_box( 
                    'infernal-metabox',
                    __('Infernal Metabox', INFERNO),
                    array(&$this, 'metabox'),
                    $post_type,
                    'advanced',
                    'high'
                );
            }
        }

        public function save($post_id)
        {
            // verify if this is an auto save routine. 
            // If it is our form has not been submitted, so we dont want to do anything
            if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) 
                return;

            if (!isset($_POST['infernal_nonce']) || !wp_verify_nonce($_POST['infernal_nonce'], plugin_basename(__FILE__)))
                return;

            
            // Check permissions
            if('page' == $_POST['post_type']) {
                if(!current_user_can('edit_page', $post_id))
                    return;
            } else {
                if(!current_user_can('edit_post', $post_id))
                    return;
            }

            // OK, we're authenticated: we need to find and save the data
            // Do something with $mydata 
            // probably using add_post_meta(), update_post_meta(), or 
            // a custom table (see Further Reading section below)
            $update = array();
            foreach($this->metabox as $meta) {
                if(isset($_POST['infernal-postmeta'][$meta['name']]) && $_POST['infernal-postmeta'][$meta['name']]) {
                    $update[$meta['name']] = Infernal_Helper::sanitize_data(trim($_POST['infernal-postmeta'][$meta['name']]), $meta['type']);
                }
                update_post_meta($post_id, '_infernal-postmeta', $update);
            }
        }

        function nonce_input()
        {
            wp_nonce_field(plugin_basename(__FILE__), 'infernal_nonce');
            #echo '<input type="hidden" name="_wpnonce" value="'. wp_create_nonce($this->_noncestr) .'" />';
        }

        function get_meta_value() 
        {
            return (isset($this->_postmeta[$this->_meta['name']])) ? $this->_postmeta[$this->_meta['name']] : (isset($this->_meta['default']) ? $this->_meta['default'] : null);
        }

        public function metabox($post)
        {
            $this->_postmeta = get_post_meta($post->ID, '_infernal-postmeta', true);
            $this->nonce_input();

            foreach($this->metabox as $meta) :
                $this->_meta = $meta;
                if($meta['post_type'] == 'all' || in_array($post->post_type, $meta['post_type'])) : ?>
                    <div class="infernal-postmeta">
                        <div class="title">
                            <strong><?php echo $meta['title']; ?></strong>
                        </div>
                        <?php // The actual fields for data entry
                        switch($meta['type']) :
                            // selects
                            case 'select':
                                $this->select();
                                break;
                            // for input="text" only
                            case 'file':
                                $this->file();
                                break;
                            case 'colorpicker':
                            case 'color':
                                $this->colorpicker();
                                break;
                            case 'text':
                            default:
                                $this->text();
                                break;
                        endswitch; ?>
                        <div class="clear"></div>
                        <p><span class="description"><?php print $meta['desc']; ?></span></p>
                    </div>
                            
                <?php
                endif;
            endforeach;     
        }


        function text()
        {
            echo '<input class="widefat" type="text" name="infernal-postmeta[' . $this->_meta['name'] . ']" value="' . $this->get_meta_value() . '" />';
        }


        function select()
        {
            echo '<select name="infernal-postmeta[' . $this->_meta['name'] . ']" class="widefat">';
            foreach($this->_meta['options'] as $value => $label) {
                $selected = ($this->get_meta_value() == $value) ? ' selected' : null;
                echo '<option value="' . $value . '"'. $selected .'>' . $label . '</option>';
            }
            echo '</select>';
        }

        function colorpicker() 
        {
            echo '<input class="widefat infernal-colorpicker-meta-input" type="text" name="infernal-postmeta[' . $this->_meta['name'] . ']" value="' . $this->get_meta_value() . '" />';
            ?>
            <div class="colorSelector" id="ip-colorselector-<?php echo $this->_count['colorpicker']; ?>">
                <div style="background-color: <?php echo $this->get_meta_value(); ?>;"></div>
            </div>
            <script type="text/javascript">
                jQuery(document).ready(function($) {
                    // call the colorpicker
                    $('#ip-colorselector-<?php echo $this->_count['colorpicker']; ?>').ColorPicker({
                        color: '<?php echo $this->get_meta_value(); ?>',
                        onShow: function(colpkr) {
                            $(colpkr).fadeIn(500);
                            return false;
                        },
                        onHide: function(colpkr) {
                            $(colpkr).fadeOut(500);
                            return false;
                        },
                        onChange: function(hsb, hex, rgb) {
                            $('#ip-colorselector-<?php echo $this->_count['colorpicker']; ?> div').css({'background-color': '#' + hex});
                            $('#ip-colorselector-<?php echo $this->_count['colorpicker']; ?>').parent().find('input').val('#' + hex);
                        }
                    });
                });
            </script>
            <?php
            $this->_count['colorpicker']++;               
        }

        function file()
        {
            ?>
            <input type="text" name="<?php echo $this->_setting['name']; ?>" accept="*.jpg,*.jpeg,*.png"
                value="<?php echo $this->get_meta_value(); ?>" class="widefat inferna-file-meta-input" />
            <span class="ip-button-upload"><?php _e('Upload Image'); ?></span>
            <?php
        }



    }
}
