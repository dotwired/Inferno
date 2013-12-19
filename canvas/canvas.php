<div class="wrap">
    
    <form method="post" id="inferno-panel-form" action="<?php echo admin_url('themes.php?page=inferno-admin'); ?>" enctype="multipart/form-data"<?php if(Inferno::$_debug === true) echo ' data-debug="true"'; ?>>
        <div id="inferno-canvas">
            <header class="inferno-header">
                <h1 class="inferno-brand">
                    <?php if(Inferno::$_brand_theme === true) : ?>
                        <?php echo wp_get_theme(); ?>
                    <?php else : ?>
                        WP-Inferno
                    <?php endif; ?>
                </h1>
                <p class="inferno-info">
                    <?php _e(sprintf('You are running Inferno version %s', INFERNO_VERSION), 'inferno'); ?>
                </p>
            </header>

            <nav class="inferno-menu">
                <ul>
                    <?php $this->menu(); ?>
                </ul>
                <?php if($this->advanced_mode === true) : ?>
                <button class="advanced-mode">
                    <span><i class="fa fa-cog"></i></span>
                    <p><?php _e('Advanced', 'inferno'); ?></p>
                </button>
                <?php endif; ?>
            </nav>

            <div class="inferno-content">
                <section class="inferno-settings">
                    <?php $this->tabs(); ?>
                </section>
                <footer class="inferno-footer">
                    <button type="submit" name="inferno_action" class="button-primary" value="save"><?php _e('Save Changes', 'inferno'); ?></button>
                    <button type="submit" name="inferno_action" class="button button-reset" value="reset" id="inferno-canvas-reset"><?php _e('Reset to Defaults', 'inferno'); ?></button>
                    <div class="clearfix"></div>
                    
                    <input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce($this->noncestr); ?>" />
                    <script type="text/javascript">
                    jQuery(document).ready(function($) {
                        $('#inferno-canvas-reset').confirm({
                            msg: "<?php _e('Do You really want to reset all settings?', 'inferno') ?> ",
                            timeout: 7000,
                            dialogShow: 'fadeIn',
                            dialogSpeed: 'slow',
                            buttons: {
                                ok : "<?php _e('Yes', 'inferno'); ?>",
                                cancel: "<?php _e('No', 'inferno'); ?>",
                                separator: ' / '
                            } 
                        });
                    });
                    </script>
                </footer>
            </div>
            

            <div class="inferno-message success ajax">
                <i class="fa fa-check"></i>
                <p><?php _e('Options successfully saved!', 'inferno'); ?></p>
            </div>
            <div class="inferno-message error ajax">
                <i class="fa fa-times"></i>
                <p><?php _e('Options could not be saved! Eventually contact support.', 'inferno'); ?></p>
            </div>
        </div>
        <div class="clearfix"></div>
    </form>

</div>