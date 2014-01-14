<div id="inferno-generator-wrap" style="display:none">
    <div id="inferno-generator">
        <div class="inner">
            <header class="header">
                <select id="inferno-generator-select" data-placeholder="<?php _e( 'Select Shortcode', 'inferno' ); ?>" data-no-results-text="<?php _e( 'Shortcode not found', 'inferno' ); ?>">
                    <option value="raw"></option>
                    <?php foreach( $this->shortcodes as $shortcode ) : ?>
                    <option value="<?php echo $shortcode['id']; ?>"><?php echo $shortcode['title']; ?></option>
                    <?php endforeach; ?>
                </select>
            </header>
            <section id="inferno-generator-shortcode">
                <?php include( 'generator.php' ); ?>
            </section>
        </div>
    </div>
</div>

<script type="text/javascript">
jQuery(document).ready(function($) {
    $("#inferno-generator-select").on("change", function(){
        $('#inferno-generator-shortcode .inferno-shortcode').css({ display: 'none' });
        $('#inferno-generator-shortcode #inferno-shortcode-' + $(this).val() + '.inferno-shortcode').css({ display: 'block' });
    });
});
</script>