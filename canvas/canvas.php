<div class="wrap">
    
    <form method="post" id="inferno-panel-form" action="<?php echo admin_url('themes.php?page=inferno-admin'); ?>" enctype="multipart/form-data">
        <div id="inferno-canvas">
            <header class="inferno-header"><img src="http://dotwired.de/static/inferno-header.png" alt="Inferno Panel" /></header>    

            <div class="bar">
                <div class="inferno-version">
                    <i class="icon-fire"></i>
                    <?php _e(sprintf('You are running Inferno version %s', INFERNO_VERSION), 'inferno'); ?>
                </div>
                <div class="clearfix"></div>
            </div>
            <nav class="menu">
                <ul>
                    <?php $this->menu(); ?>
                </ul>
            </nav>
            <section class="content">
                <?php $this->tabs(); ?>
            </section>
            <div class="clearfix"></div>
            <footer class="footer">
                <button name="inferno_action" class="button button-reset" value="reset" id="inferno-canvas-reset"><?php _e('Reset to Defaults', 'inferno'); ?></button>
                <button name="inferno_action" class="button-primary" value="save"><?php _e('Save Changes', 'inferno'); ?></button>
                <div class="clearfix"></div>
                
                <input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce($this->noncestr); ?>" />
                <script type="text/javascript">
                jQuery(document).ready(function($) {
                    $('#inferno-canvas-reset').confirm({
                        msg: "<?php _e('Do You really want to reset all settings?', 'inferno') ?>",
                        timeout: 5000,
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
            <div class="clearfix"></div>

            <div class="inferno-message success ajax">
                <p><?php _e('Options successfully saved!', 'inferno'); ?></p>
            </div>
        </div>
    </form>

</div>