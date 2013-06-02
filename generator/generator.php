<div id="inferno-generator" style="display:none">
    <div class="inner">
        <header class="header">
            <select id="inferno-generator-select" data-placeholder="<?php _e( 'Select Shortcode', 'inferno' ); ?>" data-no-results-text="<?php _e( 'Shortcode not found', 'inferno' ); ?>">
                <option value="raw"></option>
                <?php foreach( $this->shortcodes as $shortcode ) : ?>
                <option value="<?php echo $shortcode['id']; ?>"><?php echo $shortcode['title']; ?></option>
                <?php endforeach; ?>
            </select>
        </header>

        <?php foreach( $this->shortcodes as $shortcode ) : ?>
        <section class="inferno-shortcode <?php echo $shortcode['id']; ?>">
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
        </section>
        <?php endforeach; ?>
    </div>
</div>