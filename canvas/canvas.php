<?php
//TODO: make this smoother
$form_action = $this->demo_mode  === true ? $_SERVER['REQUEST_URI'] : admin_url('themes.php?page=inferno-admin');
$data_debug = Inferno::$_debug === true ? ' data-debug="true"' : null;
$data_demo = $this->demo_mode  === true ? ' data-demo="true"' : null;
$class = $this->demo_mode  === true ? ' class="inferno-demo white-popup mfp-hide"' : null;
?>
<form method="post" id="inferno-panel-form" action="<?php echo $form_action; ?>" enctype="multipart/form-data"<?php echo $data_debug . $data_demo . $class; ?>>
    <div id="inferno-canvas">
        <header class="inferno-header">
            <h1 class="inferno-brand">
                <?php if($this->brand_theme === true) : ?>
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
            <?php
            // TODO make a inferno message here with a hook (-> for things like "you need to activate cookies to make this work" in the demo) ?>
            <? if($this->demo_mode === true) : ?>
            <div class="inferno-notice">
                <p><?php _e('You are running this admin panel in demo mode. This requires You to activate cookies, if You want to take Your changes effect.', 'inferno'); ?></p>
                <p><?php _e('Please note, that some functionality is stripped in demo mode. That said, You are not able to upload any files', 'inferno'); ?></p>
            </div>
            <?php endif; ?>
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