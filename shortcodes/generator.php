<?php
$generator = new Inferno_Shortcode_Generator();
foreach( $generator->shortcodes as $shortcode ) : ?>
<div id="inferno-shortcode-<?php echo $shortcode['id']; ?>" class="inferno-shortcode" data-shortcode-id="<?php echo $shortcode['id']; ?>">
    <p><?php echo $shortcode['desc']; ?></p>
    <div class="shortcode-settings">
        <?php foreach( $shortcode['fields'] as $field ) : ?>
        <?php 
        $field['id'] = $shortcode['id'] . '_' . $field['id'];
        new Inferno_Options_Machine( $field ); ?>
        <?php endforeach; ?>
    </div>
</div>
<?php endforeach; ?>