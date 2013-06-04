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
<p><?php echo $shortcode['title']; ?></p>
<div class="shortcode-settings">
    <?php foreach( $shortcode['fields'] as $field ) : ?>
    <div class="field">
        <div class="field-left">
            <?php echo $field['desc']; ?>
        </div>
        <div class="field-right">
            <?php new Inferno_Options_Machine( $field ); ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<button class="button button-primary button-large" id="inferno-generator-insert"><?php _e("Insert Shortcode into Editor"); ?></button>
<input id="inferno-generator-result" type="hidden" value="" />
<?php endif; endforeach; ?>