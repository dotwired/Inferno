<?php
// Start WordPress
require_once( '../../../../../wp-load.php' );

// Capability check
//if ( !current_user_can( 'author' ) && !current_user_can( 'editor' ) && !current_user_can( 'administrator' ) )
//    die( 'Access denied' );

// Param check
if ( empty( $_GET['shortcode'] ) )
    die( 'Shortcode not specified' );
else
    $sc = $_GET['shortcode'];

$generator = new Inferno_Shortcode_Generator();
?>

<?php foreach( $generator->shortcodes as $shortcode ) : if( $shortcode['id'] == $sc ) : ?>
<p><?php echo $shortcode['desc']; ?></p>
<div class="shortcode-settings">
    <?php foreach( $shortcode['fields'] as $field ) : ?>
    <?php new Inferno_Options_Machine( $field ); ?>
    <?php endforeach; ?>
</div>

<input id="inferno-shortcode-only-atts" type="hidden" value="<?php echo isset($shortcode['only_atts']) ? $shortcode['only_atts'] : null; ?>" />
<input id="inferno-shortcode-content-att" type="hidden" value="<?php echo isset($shortcode['content_att']) ? $shortcode['content_att'] : null; ?>" />
<input id="inferno-generator-result" type="hidden" value="" />

<button class="button button-primary button-large" id="inferno-generator-insert"><?php _e("Insert Shortcode into Editor", 'inferno'); ?></button>
<?php endif; endforeach; ?>