<div id="inferno-generator-wrap" style="display:none">
  <div id="inferno-generator">
    <header class="header">
      <h1><?php _e('Shortcode Generator', 'inferno'); ?></h1>
    </header>
    <div class="inner">
      <div class="select">
        <select id="inferno-generator-select" data-placeholder="<?php _e( 'Select Shortcode', 'inferno' ); ?>" data-no-results-text="<?php _e( 'Shortcode not found', 'inferno' ); ?>">
          <option value="raw"></option>
          <?php foreach( $this->shortcodes as $shortcode ) : ?>
          <option value="<?php echo $shortcode['id']; ?>"><?php echo $shortcode['title']; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <section id="inferno-generator-shortcode">
        <?php include( 'generator.php' ); ?>
      </section>

      <input id="inferno-shortcode-only-atts" type="hidden" value="<?php echo isset($shortcode['only_atts']) ? $shortcode['only_atts'] : null; ?>" />
      <input id="inferno-shortcode-content-att" type="hidden" value="<?php echo isset($shortcode['content_att']) ? $shortcode['content_att'] : null; ?>" />
      <input id="inferno-generator-result" type="hidden" value="" />

      <button class="button button-primary button-large" id="inferno-generator-insert"><?php _e("Insert Shortcode into Editor", 'inferno'); ?></button>
    </div>
  </div>
</div>