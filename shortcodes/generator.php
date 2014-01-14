<?php
$generator = new Inferno_Shortcode_Generator();
foreach( $generator->shortcodes as $shortcode ) : ?>
<div id="inferno-shortcode-<?php echo $shortcode['id']; ?>" class="inferno-shortcode">
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
</div>
<?php endforeach; ?>